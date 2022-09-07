<?php

namespace App\Http\Controllers\API;

use App\Events\NewPayment;
use App\Exports\OrdersExport;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Store;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Razorpay\Api\Api;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function callback(Request $request)
    {
        $transaction = Transaction::where('razorpay_order_id', $request->payload['qr_code']['entity']['id'])->first();
        if($transaction)
        {
            $transaction->status = 'completed';
            $transaction->save();
            
            NewPayment::dispatch($transaction);
        }
    }

    public function search(Request $request)
    {
        $orders = '';
        if($request->phoneNumber)
        {
            $orders = Sale::whereHas('customer', function($q) use($request){
                $q->where('phone_no', 'like', "%$request->phoneNumber%");
            })->orderBy('created_at', 'desc')->get()->load(['customer','products.inventory.item']);
        }
        else
        {
            $orders = Sale::whereDate('created_at', Carbon::now())->orderBy('created_at', $request->sortBy)->get()->load(['products.inventory.item']);
        }

        return response()->json([
            'orders' => $orders
        ]);

    }

    public function order(Request $request)
    {
       $order = Sale::where('transaction_id', $request->id)->first()->load(['store', 'customer', 'products.inventory.item']);
       return response()->json([
           'order' => $order,
           'message' => 'success'
       ]);
    }

    public function fetchQr(Request $request)
    {
        $api = new Api(env('RZP_KEY'), env('RZP_SECRET'));
        $response = $api->qrCode->fetch($request->id);
        $data = array(
            "name" => $response->name,
            "usage" => $response->usage,
            "type" => $response->type,
            "status" => $response->status,
            "customer_id" => $response->customer_id,
            "image_url" => $response->image_url,
            "id" => $response->id
        );
       
        return response()->json($data);
    }

    public function returnOrder(Sale $sale)
    {
        foreach($sale->products as $item)
        {
            $product = Product::find($item->id)->first();
            $product->quantity = $product->quantity + $item->pivot->quantity;
            $product->save();
        }
        if($sale->transaction->method == 'rzp' && $sale->transaction->status == 'captured')
        {
            $api = new Api(env('RZP_KEY'), env('RZP_SECRET'));
            $refund = $api->payment->fetch($sale->transaction->razorpay_payment_id)->refund(array("amount"=> "100", "speed"=>"normal"));
            if($refund->id)
            {
                $sale->transaction->status = 'refunded';
                $sale->transaction->save();
            }
        }
        else
        {
            $sale->transaction->status = 'refunded';
            $sale->transaction->save();
        }
        $sale->status = 'returned';
        $sale->save();

        return response()->json([
            'message' => 'success',
            'order' => $sale->load('products.inventory.item')
        ]);
    }

    public function create(Store $store, Request $request)
    {
        $api = new Api(env('RZP_KEY'), env('RZP_SECRET'));
        $tax = 0;
        $subtotal = 0;
        foreach( json_decode($request->carts) as $cart)
        {
            $product = $cart->product;
            $item = Product::find($product->id);
            if($item->quantity < $cart->quantity)
            {
                return response(400, 'Quntity exceeded!');
            }

            if ($request->discount['item_id'] == $product->id) {
                // NOTE: Discount added to item
                $subtotal = $subtotal + (($item->inventory->selling_price - $request->discount['amount']) * $cart->quantity);
                $tax = ($tax + ((($item->inventory->selling_price - $request->discount['amount']) * $item->inventory->gst_percent)/100)) * $cart->quantity;
            } else{
                $subtotal = $subtotal + ($item->inventory->selling_price * $cart->quantity);
                $tax = ($tax + (($item->inventory->selling_price * $item->inventory->gst_percent)/100)) * $cart->quantity;
            }
        }
        
        $user = User::firstOrCreate(['phone_no' => $request->phone_no]);
        
        if(!$user->hasAnyRole(['admin', 'sales', 'manager', 'customer']))
        {
            $user->assignRole('customer');
        }

        if($user->rzp_id)
        {
            //create razorpay customer
            $customer = $api->customer->create(array(
                'name' => 'User'. Str::uuid(),
                'contact'=> $user->phone_no,
            ));

            $user->rzp_id = $customer->id;
            $user->save();
        }

        $sale = Sale::create([
            'store_id' => $store->id,
            'user_id' => $user->id,
            'total_with_gst' => $subtotal + $tax,
            'total_without_gst' => $subtotal,
            'status' => 'created'
        ]);

        foreach(json_decode($request->carts) as $cart)
        {
            $product = $cart->product;
            $item = Product::find($product->id);

            if ($request->discount['item_id'] == $product->id) {
                $sale->products()->attach($item, ['quantity' => $cart->quantity, 'discount_amount' => $request->discount['amount']]);
            } else {
                $sale->products()->attach($item, ['quantity' => $cart->quantity]);
            }

            $item->quantity = $item->quantity - $cart->quantity;
            $item->save();
        }

        if($request->payment_type == 'cash')
        {
            $transaction = Transaction::create([
                'method' => 'cash',
                'status' => 'paid',
            ]);
            $sale->status = "completed";
            $sale->transaction_id = $transaction->id;
            $sale->save();

            return response()->json([
                'message' => 'success',
                'transaction_id' => $transaction->id,
            ]);
        }
        else
        {
            $response = $api->qrCode->create(
                array("type" => "bharat_qr",
                "name" => "Store_1", 
                "usage" => "single_use",
                "fixed_amount" => 1,
                "payment_amount" => ($subtotal + $tax) * 100,
                "customer_id" => $user->rzp_id,
                "description" => "For Store 1",
                "close_by" => 1681615838,
                "notes" => array("purpose" => "Test UPI QR code notes")
            ));
    
            $transaction = Transaction::create([
                'method' => 'rzp',
                'status' => 'created',
                'razorpay_order_id' => $response->id,
            ]);
    
            $sale->transaction_id = $transaction->id;
            $sale->save();
    
            return response()->json([
                "name" => $response->name,
                "usage" => $response->usage,
                "type" => $response->type,
                "status" => $response->status,
                "customer_id" => $response->customer_id,
                "image_url" => $response->image_url,
                "id" => $response->id,
                'transaction_id' => $transaction->id
            ]);
        }
    }
    public function checkPayment(Request $request)
    {
        $api = new Api(env('RZP_KEY'), env('RZP_SECRET'));

        $res = $api->qrCode->fetch($request->id);
        
        if($res->payments_amount_received == $res->payment_amount)
        {
            return response()->json([
                'success' => true,
            ]);
        }
        else
        {
            return response()->json([
                'success' => false, 
            ]);
        }

    }

    public function index(Store $store)
    {
       $sorted = Sale::where('store_id', $store->id)->whereDate('created_at', Carbon::now())->orderBy('created_at', 'desc')->with(['products.inventory.item'])->get();
       return response()->json([
           'orders' => $sorted->load(['store', 'customer', 'products.inventory.item']),
       ]);
    }

    public function export(Request $request)
    {
        return Excel::download(new OrdersExport($request->from, $request->to), 'Sales'.$request->from.'-to-'.$request->to.'.xlsx');
    }

    public function printReceipt(Sale $sale)
    {
        return view('receipt', ['sale' => $sale->load(['products.inventory.item'])]);
    }
}
