<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class SalesDataController extends Controller
{
    public function getTopTheaterBySalesForm()
    {
        $result = null;

        return view('theaterSales', ['result' => $result]);
    }


    public function getTopTheaterBySales(Request $request)
    {
        $result = null;

        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'sales_date' => 'required|date_format:m-d-Y|after_or_equal:11-08-2024|before_or_equal:11-10-2024',
            ]);

            $sales_date = \Carbon\Carbon::createFromFormat('m-d-Y', $validated['sales_date'])->toDateString();

            $result = DB::table('sales as s')
                ->join('theaters as t', 's.theater_id', '=', 't.id')
                ->select('s.theater_id', 't.name as theater_name', DB::raw('SUM(s.total_sales) as total_sales'), 's.sales_date')
                ->where('s.sales_date', '=', $sales_date)
                ->groupBy('s.theater_id', 't.name', 's.sales_date')
                ->orderByDesc(DB::raw('SUM(s.total_sales)'))
                ->limit(1)
                ->first();
        }

        return view('theaterSales', ['result' => $result]);
    }
}

