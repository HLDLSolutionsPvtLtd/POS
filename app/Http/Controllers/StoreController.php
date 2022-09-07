<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;

class StoreController extends Controller
{
    //
    public function create(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
        ]);

        Store::create($validated);
        Permission::create(['name' => $request->name]);
        return redirect()->route('store')->with('message', 'Store Created Successfully!');
    }

    public function update(Store $store, Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $store->name = $request->name;

        $store->save();

        return redirect()->back();
    }

    public function delete(Store $store)
    {
        $store->delete();

        return redirect()->back();
    }
}
