<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderTaxDetail;
use Carbon\Carbon;

class ReportController extends Controller
{
  public function monthlyReport(Request $request)
{
    $from = $request->from
        ? Carbon::parse($request->from)->startOfDay()
        : now()->startOfMonth();

    $to = $request->to
        ? Carbon::parse($request->to)->endOfDay()
        : now()->endOfDay();

    $records = OrderTaxDetail::with(['order', 'invoice', 'product'])
        ->whereBetween('sale_date', [$from->toDateString(), $to->toDateString()])
        ->orderBy('sale_date')
        ->get();

    $totals = [
        'amount'        => $records->sum('amount'),
        'items'         => $records->sum('quantity'),
        'cgst'          => $records->sum('cgst_amount'),
        'sgst'          => $records->sum('sgst_amount'),
        'igst'          => $records->sum('igst_amount'),
        'delivery_cost' => $records->sum('delivery_cost'),
        'gross_amount'  => $records->sum('gross_amount'),
    ];

    return view('admin.monthly_sales', compact('records', 'from', 'to', 'totals'));
}
}
