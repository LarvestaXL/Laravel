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

    public function index()
    {
        $report = DB::table('order_detail')
            ->join('produks', 'produks.id', '=', 'order_detail.id_member')
            ->select(DB::raw('count(*) as jumlah_dibeli, nama_barang, harga, total'))
            ->groupBy('id_member', 'nama_barang')
            ->get();

        return response()->json([
            'data' => $report
        ]);
    }
}