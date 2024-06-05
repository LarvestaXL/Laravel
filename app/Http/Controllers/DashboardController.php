<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        //Middleware Untuk memperbolehkan Admin untuk mengakses 
        $this->middleware('role:admin')->except(['index']);
    }

    public function show()
    {
        $totalProduks = Produk::count();//Menghitung total produk
        $bajuProduks = Produk::where('category_id', '1')->count();//Menghitung jumlah total Baju
        $celanaProduks = Produk::where('category_id', '2')->count();//Menghitung jumlah total Celana
        $sepatuProduks = Produk::where('category_id', '3')->count();//Menghitung jumlah total Sepatu

        return response()->json([
            'total_Produks' => $totalProduks,
            'baju_Produks' => $bajuProduks,
            'celana_Produks' => $celanaProduks,
            'sepatu_Produks' => $sepatuProduks,
        ]);//Mengembalikan hasil dalam format JSON
    }
}