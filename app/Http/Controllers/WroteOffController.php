<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Product;
use App\Models\User;
use App\Models\WroteOff;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WroteOffController extends Controller
{
    //
    public function create(Request $request)
    {
        $product = '';//init products
        
        //checking wroteoff type
        if($request->type == 'product')
        {
            $product = Product::find($request->id);
        }
        else
        {
            $product = Inventory::find($request->id);
        }
        $wroteoff = new WroteOff;
        $wroteoff->quantity = $request->quantity;
        $wroteoff->remarks = $request->remarks;
        $product->quantity = (int)$product->quantity - (int)$request->quantity; // remove wroteoffs from inventory or product
        $product->save();

        $product->wroteoffs()->save($wroteoff); //create new wroteoff

        //partial reload
        return redirect()->route('writeoff')->with('message', 'Success!');
    }

    public function wroteoffs()
    {
        $products = Product::whereHas('wroteoffs')->get()->load('wroteoffs','inventory.item');
        foreach($products as $product)
        {
            $product->item = $product->inventory->item;
        }
        $inventories = Inventory::whereHas('wroteoffs')->get()->load('wroteoffs','item');
        return $products->merge($inventories)->paginate(20);
    }

    public function update(WroteOff $wroteoff, Request $request)
    {
        $request->validate([
            'quantity' => 'required',
            'remarks' => 'required',
        ]);

        $wroteoff->quantity = $request->quantity;
        $wroteoff->remarks = $request->remarks;

        $wroteoff->save();

        return redirect()->back();
    }

    public function delete(WroteOff $wroteoff)
    {
        $wroteoff->delete();

        return redirect()->back();
    }
}
