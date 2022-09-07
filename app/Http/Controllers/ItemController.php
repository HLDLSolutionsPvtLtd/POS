<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ItemController extends Controller
{
    //
    public function create(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'unit_measurement' => 'required',
            'description' => 'required',
            'product_code' => 'nullable'
        ]);
        $path = $request->image->storeAs('media', Str::uuid() . '.' . $request->image->getClientOriginalExtension(), [ 'disk'=> 'public']);
        Item::create(array_merge($validated, ['img' => $path]));

        return redirect()->route('items')->with('message', 'Item Added Successfully!');
    }

    public function update(Item $item, Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'unit_measurement' => 'required',
            'description' => 'required',
            'product_code' => 'nullable'
        ]);
        
        
        if($request->img)
        {
            Storage::disk('public')->delete($item->img);
            $path = $request->img->storeAs('media', Str::uuid() . '.' . $request->img->getClientOriginalExtension(), [ 'disk'=> 'public']);
            $item->update(array_merge($validated, ['img' => $path]));
        }
        else
        {
            $item->update($validated);
        }
        return redirect()->back();
    }

    public function delete(Item $item)
    {
        $item->delete();

        return redirect()->back();
    }
}
