<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    //
    public function delete(Sale $sale)
    {
        $sale->delete();

        return redirect()->back();
    }
}
