<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    protected $userRole;

    public function __construct()
    {
        // Middleware untuk memperbolehkan Member mengakses
        $this->middleware('role:member')->except(['index', 'show']);
        
        // Mendapatkan Role user yang login
        if (auth()->check()) {
            $this->userRole = auth()->user()->role;
        }
    }

    public function index()
    {
        $carts = Cart::all();
        return response()->json(['data' => $carts]);
    }

    public function store(Request $request)
    {
        // Validasi Request
        $validator = Validator::make($request->all(), [
            'produk_id' => 'required',
            'member_id' => 'required',
            'nama_barang' => 'required|string',
            'harga' => 'required|numeric',
            'gambar' => 'nullable|url'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        
        $input = $request->all();

        // Menangani Input gambar
        if ($request->hasFile('gambar')) {
            $imageName = time() . '.' . $request->gambar->extension();
            $request->gambar->move(public_path('storage/images'), $imageName);
            $input['gambar'] = $imageName;
        }

        $cart = Cart::create($input);

        return response()->json(['data' => $cart]);
    }

    public function show(Cart $cart)
    {
        return response()->json(['data' => $cart]);
    }

    public function destroy(Cart $cart)
    {
        // Delete Gambar jika ada
        if ($cart->gambar) {
            File::delete(public_path('storage/images/' . $cart->gambar));
        }
        //menghapus data di database
        $cart->delete();
        //return pesan berhaisl hapus data
        return response()->json(['message' => 'berhasil hapus data']);
    }
}
