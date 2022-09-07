<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //
    public function index(Store $store)
    {
        $products = Product::where('store_id', $store->id)->where('quantity', '>', 0)->get()->load(['inventory.item']);

        return response()->json($products);
    }

    public function search(Store $store,Request $request)
    {
        $products = Product::whereHas('inventory', function($q) use($request){
            $q->whereHas("item", function($q) use($request){
                $q->where('name', 'like', "%$request->key%");
            });
        })->where('store_id', $store->id)->where('quantity', '>', 0)->with(['inventory.item'])->get();

        return response()->json($products);
    }
}
