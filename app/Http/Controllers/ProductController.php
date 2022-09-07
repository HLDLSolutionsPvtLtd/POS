<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Product;
use App\Models\Store;
use App\Models\Transfer;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    //

    public function transfer(Request $request)
    {
        //validate request parameters
        $request->validate([
            'item' => 'required',
            'quantity' => 'required',
            'store_id' => 'required',
            'status' => 'nullable'
        ]);

        //create new transfer
        Transfer::create([
            'inventory_id' => $request->item['id'],
            'store_id' => $request->store_id,
            'remarks' => $request->remarks,
            'type' => 'toinventory',
            'quantity' => $request->quantity,
        ]);

        $inventory = Inventory::where('id', $request->item['inventory_id'])->first();
        $inventory->quantity = $inventory->quantity + $request->quantity;
        $inventory->save();

        $product = Product::where('id', $request->item['id'])->first();
        $product->quantity = $product->quantity - $request->quantity;
        $product->save();

        //
        return redirect()->route('inventories')->with('message', 'Transfered Successfully!');
    }

    public function delete(Product $product, Request $request)
    {
        $store = Store::find($request->store_id);
        $store->products()->detach($product);

        $product->delete();

        return redirect()->back();
    }

    public function update(Product $product, Request $request)
    {
        $product->quantity = $request->quantity;
        $product->save();

        return redirect()->back();
    }
}
