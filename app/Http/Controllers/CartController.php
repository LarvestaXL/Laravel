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
        // Middleware to restrict access to members only, except for index and show methods
        $this->middleware('role:member')->except(['index', 'show']);
        
        // Get user role when logged in
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
        // Validate the request
        $validator = Validator::make($request->all(), [
            'produk_id' => 'required',
            'member_id' => 'required',
            'nama_barang' => 'required|string',
            'harga' => 'required|numeric',
            'gambar' => 'nullable|image'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Handle the input
        $input = $request->all();

        // Handle image upload
        if ($request->hasFile('gambar')) {
            $imageName = time() . '.' . $request->gambar->extension();
            $request->gambar->move(public_path('storage/images'), $imageName);
            $input['gambar'] = $imageName;
        }

        // Create the cart item
        $cart = Cart::create($input);

        return response()->json(['data' => $cart]);
    }

    public function show(Cart $cart)
    {
        return response()->json(['data' => $cart]);
    }

    public function destroy(Cart $cart)
    {
        // Delete the image if exists
        if ($cart->gambar) {
            File::delete(public_path('storage/images/' . $cart->gambar));
        }

        // Delete the cart item
        $cart->delete();

        return response()->json(['message' => 'berhasil hapus data']);
    }
}
