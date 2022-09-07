<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
class InventoryController extends Controller
{
    //
    public function update(Inventory $inventory, Request $request)
    {
        $inventory->hsn = $request->hsn;
        $inventory->unit_price = $request->unit_price;
        $inventory->gst_percent = $request->gst_percent;
        $inventory->quantity = $request->quantity;
        $inventory->selling_price = $request->selling_price;
        $inventory->expiry_date = $request->expiry_date;

        if(!empty($request->image))
        {
            if($inventory->image)
            {
                Storage::disk('public')->delete($inventory->image);
            }
            $path = $request->image->storeAs('media', Str::uuid() . '.' . $request->image->getClientOriginalExtension(), [ 'disk'=> 'public']);
            $inventory->image = $path;
        }
        $inventory->save();

        return redirect()->back();
    }

    public function delete(Inventory $Inventory)
    {
        $Inventory->delete();

        return redirect()->back();
    }
}
