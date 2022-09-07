<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Particular;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

use function PHPUnit\Framework\isEmpty;

class PurchaseController extends Controller
{
    public function create(Request $request)
    {
        //validate request data
        $validated = $request->validate([
            'supplier_id' => 'required',
            'supplier_invoice' => 'nullable',
            'total_amount' => 'nullable',
            'payment_method' => 'required',
            'transaction_id' => 'nullable',
            'payment_date' => 'required',
        ]);

        //create new purchase with validated data
        $purchase = Purchase::create($validated);

        //create particular for each product in purchase
        foreach($request->particulars as $particular)
        {
            Particular::create([
                'item_id' => $particular['item_id'],
                'quantity' => $particular['quantity'],
                'unit_price' => $particular['unit_price'],
                'purchase_id' => $purchase->id,
                'gst_percent' => $particular['gst_percent'],
            ]);
        }

        //add each particulars to inventory
        foreach($request->particulars as $particular)
        {
            Inventory::create([
                'item_id' => $particular['item_id'],
                'purchase_id' => $purchase->id,
                'hsn' => $particular['hsn'],
                'quantity' => $particular['quantity'],
                'unit_price' => $particular['unit_price'],
                'gst_percent' => $particular['gst_percent'],
                'mfg_date' => $particular['mfg_date'],
                'expiry_date' => $particular['expiry_date'],
                'selling_price' => $particular['selling_price'],
            ]);
        } 

        //partial reload
        return redirect()->route('purchase')->with('message', 'Purchase Created Successfully!');
    }

    public function delete(Purchase $purchase)
    {
        $particulars = Particular::where('purchase_id', $purchase->id)->get();
        foreach($particulars as $particular)
        {
            $particular->delete();
        }

        $inventories = Inventory::where('purchase_id', $purchase->id)->get();
        foreach($inventories as $inventory)
        {
            $inventory->delete();
        }

        $purchase->delete();

        return redirect()->back();
    }

    
    // public function index()
    // {
        
    // }
}
