<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['index']);
    }

    public function index(Request $request)
    {
        $report = DB::table('order_detail')
            ->join('produks', 'produks.id', '=', 'order_detail.id_produk')
            ->select(DB::raw('count(*) as jumlah_dibeli, nama_barang, 
                harga,
                SUM(total) as total_harga,
                SUM(jumlah) as total_qty'))
            ->whereRaw("date(order_detail.created_at) >= '$request->dari'")
            ->whereRaw("date(order_detail.created_at) <= '$request->sampai'")
            ->groupBy('id_produk', 'nama_barang', 'harga', 'total')
            ->get();
    
        return response()->json([
            'data' => $report
        ]);
    }
    
}