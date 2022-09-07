<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    //
    public function create(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'address' => 'required',
            'gst_no' => 'required',
            'pan_no' => 'required',
            'state_code' => 'required',
        ]);

        Supplier::create($validated);

        return redirect()->route('suppliers')->with('message', 'Supplier Added Successfully!');
    }

    public function update(Supplier $supplier, Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'address' => 'required',
            'gst_no' => 'required',
            'pan_no' => 'required',
            'state_code' => 'required',
        ]);

        $supplier->update($validated);

        return redirect()->route('suppliers')->with('message', 'Supplier Updated Successfully!');
    }

    public function delete(Supplier $supplier)
    {
        $supplier->delete();

        return redirect()->back();
    }
}
