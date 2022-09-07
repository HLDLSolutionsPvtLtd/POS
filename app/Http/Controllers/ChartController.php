<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ChartController extends Controller
{
    //

    public function orderDaily(Request $request)
    {
        $x= [];
        $y = [];
        for($i = 18; $i >= 0; $i--)
        {

            $date = date("Y-m-d", strtotime("-$i days"));   
            $orders = Sale::whereYear('created_at', date("Y", strtotime($date)))->whereMonth('created_at', date("m", strtotime($date)))->whereDay('created_at', date("d", strtotime($date)))->get();
            $no = 0;
            $no = $no + count($orders);
            array_push($x,date("M j", strtotime("-$i days")));
            array_push($y, $no);
        }
        
        return response()->json([
            'x' => $x,
            'y' => $y, 
        ]);
    }

    public function orderRevenue(Request $request)
    {
        $x= [];
        $y = [];
        for($i = 18; $i >= 0; $i--)
        {

            $date = date("Y-m-d", strtotime("-$i days"));   
            $orders = Sale::whereYear('created_at', date("Y", strtotime($date)))->whereMonth('created_at', date("m", strtotime($date)))->whereDay('created_at', date("d", strtotime($date)))->get();
            $no = 0;
            foreach($orders as $order)
            {
                $no = $no + $order->total_with_gst;
            }
            array_push($x,date("M j", strtotime("-$i days")));
            array_push($y, $no);
        }
        
        return response()->json([
            'x' => $x,
            'y' => $y, 
        ]);
    }

    public function orderMonth()
    {
        $x= [];
        $y = [];
        for ($i = 11; $i >= 0; $i--) {
            $monthname = Carbon::today()->startOfMonth()->subMonth($i);
            $month = Carbon::today()->startOfMonth()->subMonth($i)->format('Y-m-d');
            $orders = Sale::whereYear('created_at', date("Y", strtotime($month)))->whereMonth('created_at', date("m", strtotime($month)))->get();
            array_push($x, $monthname->shortMonthName);
            $no = 0;
            $no = $no + count($orders);
            array_push($y, $no);
        }

        return response()->json([
            'x' => $x,
            'y' => $y, 
        ]);
    }
}
