<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Product;
use App\Models\Store;
use App\Models\Transfer;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TransferController extends Controller
{
    //
    public function create(Request $request)
    {
        //validate request parameters
        $request->validate([
            'item' => 'required',
            'store_id' => 'required',
            'quantity' => 'required',
            'status' => 'nullable'
        ]);

        //create new transfer
        Transfer::create([
            'inventory_id' => $request->item['id'],
            'store_id' => $request->store_id,
            'remarks' => $request->remarks,
            'type' => 'toproduct',
            'quantity' => $request->quantity,
        ]);

        $inventory = Inventory::where('id', $request->item['id'])->first();
        $inventory->quantity = $inventory->quantity - $request->quantity;
        $inventory->save();

        return redirect()->route('inventories')->with('message', 'Transfered Successfully!');
    }

    public function accept(Transfer $transfer)
    {
        
        if($transfer->type == 'toproduct')
        {
            $store = Store::find($transfer->store_id);
            $id = $transfer->inventory->item_id;
            // if($product)
            // {
            //     $product->quantity = $product->quantity + $transfer->quantity;
            //     $product->save();

            //     // $sproduct = Product::find($product->id);
            //     // $sproduct->quantity = $product->quantity + $transfer->quantity;
            //     // $product->save();

            //     // $store->products()->updateExistingPivot($product->id,['quantity' => $product->quantity + $transfer->quantity]);
            // }
            // else
            // {
                Product::create([
                    'store_id' => $transfer->store_id,
                    'item_id' => $transfer->inventory->item_id,
                    'inventory_id' => $transfer->inventory->id,
                    'quantity' => $transfer->quantity,
                ]);
            // }
    
        }
        else
        {
            $inventory = Inventory::find($transfer->inventory_id);
            $inventory->quantity = $inventory->quantity + $transfer->quantity;
            $inventory->save();
        }
        $transfer->status = 'received';
        $transfer->save();

        return redirect()->back();
    }
}
