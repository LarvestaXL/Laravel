<?php

namespace App\Http\Controllers;

use App\Models\cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class cartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index']);
    }

    public function index()
    {
        $carts = cart::all();
        return response()->json(['data' => $carts]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'produk_id' => 'required',
            'member_id' => 'required',
            'nama_barang' => 'required|string',
            'harga' => 'required|numeric',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $input = $request->all();

        if ($request->hasFile('gambar')) {
            $imageName = time() . '.' . $request->gambar->extension();
            $request->gambar->move(public_path('storage/images'), $imageName);
            $input['gambar'] = $imageName;
        }

        $cart = cart::create($input);

        return response()->json(['data' => $cart]);
    }

    public function show(cart $cart)
    {
        return response()->json(['data' => $cart]);
    }

    public function update(Request $request, cart $cart)
    {
        $validator = Validator::make($request->all(), [
            'produk_id' => 'required',
            'member_id' => 'required',
            'nama_barang' => 'required|string',
            'harga' => 'required|numeric',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $input = $request->all();

        if ($request->hasFile('gambar')) {
            if ($cart->gambar) {
                File::delete(public_path('storage/images/' . $cart->gambar));
            }
            $imageName = time() . '.' . $request->gambar->extension();
            $request->gambar->move(public_path('storage/images'), $imageName);
            $input['gambar'] = $imageName;
        }

        $cart->update($input);

        return response()->json(['message' => 'success', 'data' => $cart]);
    }

    public function destroy(cart $cart)
    {
        if ($cart->gambar) {
            File::delete(public_path('storage/images/' . $cart->gambar));
        }

        $cart->delete();

        return response()->json(['message' => 'success']);
    }
}
