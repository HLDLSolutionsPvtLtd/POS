<?php

namespace App\Exports;

use App\Models\Purchase;
use App\Models\Sale;
use Maatwebsite\Excel\Concerns\FromCollection;

class OrdersYear implements FromCollection
{
    public function collection()
    {
        return Purchase::all();
    }
}