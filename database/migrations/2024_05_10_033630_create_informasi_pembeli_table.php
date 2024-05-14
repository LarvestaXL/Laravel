<?php

namespace App\Http\Controllers;

use App\Models\Informasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class InformasiController extends Controller
{
    public function __construct(){
        $this->middleware('auth:api')->except(['index']);
    }

    public function index()
    {
        $informasis = Informasi::all();

        return response()->json([
            'data' => $informasis
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
            'province' => 'required',
            'payment_method' => 'required',
            'payment_number' => 'required',
            'produk_id' => 'nullable|exists:products,id',
            'member_id' => 'nullable|exists:members,id',
            'total_harga' => 'nullable|numeric',
            'cart_id' => 'nullable|exists:carts,id'
        ]);

        if ($validator->fails()){
            return response()->json(
                $validator->errors(),
                422
            );
        }

        $input = $request->all();
        $informasi = Informasi::create($input);

        return response()->json([
            'data' => $informasi
        ]);
    }

    public function show(Informasi $informasi)
    {
        return response()->json([
            'data' => $informasi
        ]);
    }

    public function update(Request $request, Informasi $informasi)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
            'apartmen' => 'nullable',
            'province' => 'required',
            'payment_method' => 'required',
            'payment_number' => 'required',
            'produk_id' => 'required',
            'member_id' => 'required',
            'total_harga' => 'nullable',
            'cart_id' => 'required'
        ]);

        if ($validator->fails()){
            return response()->json(
                $validator->errors(),
                422
            );
        }

        $input = $request->all();
        $informasi->update($input);

        return response()->json([
            'data' => $informasi
        ]);
    }

    public function destroy(Informasi $informasi)
    {
        if ($informasi->gambar) {
            File::delete(public_path('storage/images/' . $informasi->gambar));
        }

        $informasi->delete();

        return response()->json([
            'message' => 'success'
        ]);
    }
}
