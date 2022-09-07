<?php

namespace App\Exports;

use App\Models\Sale;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class OrdersExport implements FromView
{
    public function view(): View
    {
        return view('export', [
            'orders' => Sale::whereBetween('created_at', [$this->from, $this->to])->get()->load(['customer', 'store']),
        ]);
    }

    public function __construct($from, $to)
    {
        $this->from = $from;
        $this->to = $to;
    }
}