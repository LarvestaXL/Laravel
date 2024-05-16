<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $this->middleware('auth:api')->except(['index']);
    }

    public function show()
    {
        $totalProduks = Produk::count();
        $bajuProduks = Produk::where('category_id', '1')->count();
        $celanaProduks = Produk::where('category_id', '2')->count();
        $sepatuProduks = Produk::where('category_id', '3')->count();

        return response()->json([
            'total_Produks' => $totalProduks,
            'baju_Produks' => $bajuProduks,
            'celana_Produks' => $celanaProduks,
            'sepatu_Produks' => $sepatuProduks,
        ]);
    }
}