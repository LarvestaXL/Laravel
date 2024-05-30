<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ProdukController extends Controller
{
    public function __construct(){
        $this->middleware('auth:api')->except(['index', 'search', 'show']);
    }
//nambahkan update tidak perlu auth
    public function index()
    {
        $produks = Produk::all();

        return response()->json([
            'data' => $produks
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required',
            'subkategori_id' => 'required',
            'nama_barang' => 'required',
            'gambar' => 'required|image|mimes:jpg,png,webp',
            'deskripsi' => 'required',
            'harga' => 'required',
            'diskon' => 'required',
            'bahan' => 'required',
            'tags' => 'required',
            'sku' => 'required',
            'ukuran' => 'required',
            'warna' => 'required'
        ]);

        if ($validator->fails()){
            return response()->json(
                $validator->errors(),
                422
            );
        }

        $input = $request->all();

        if ($request->has('gambar')){
            $gambar = $request->file('gambar');
            $nama_gambar = time() . rand(1,9) . '.' . $gambar->getClientOriginalExtension();
            $path = $gambar->storeAs('public/images', $nama_gambar);
            $input['gambar'] = $nama_gambar;
        }

        $produk = Produk::create($input);

        return response()->json([
            'data' => $produk
        ]);
    }

    public function show(Produk $produk)
    {
        return response()->json([
            'data' => $produk
        ]);
    }

    public function edit(Produk $produk)
    {
        //
    }

    public function update(Request $request, Produk $produk)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required',
            'subkategori_id' => 'required',
            'nama_barang' => 'required',
            'gambar' => 'required|image|mimes:jpg,png,webp',
            'deskripsi' => 'required',
            'harga' => 'required',
            'diskon' => 'required',
            'bahan' => 'required',
            'tags' => 'required',
            'sku' => 'required',
            'ukuran' => 'required',
            'warna' => 'required'
        ]);

        if ($validator->fails()){
            return response()->json(
                $validator->errors(),
                422
            );
        }

        $input = $request->all();

        if ($request->hasFile('gambar')) {
            if ($produk->gambar) {
                File::delete(public_path('storage/images/' . $produk->gambar));
            }

            $gambar = $request->file('gambar');
            $nama_gambar = time() . rand(1,9) . '.' . $gambar->getClientOriginalExtension();
            $path = $gambar->storeAs('public/images', $nama_gambar);
            $input['gambar'] = $nama_gambar;
        } else {
            unset($input['gambar']);
        }

        $produk->update($input);

        return response()->json([
            'message' => 'success',
            'data' => $produk
        ]);
    }

    public function destroy(Produk $produk)
    {
        if ($produk->gambar) {
            File::delete(public_path('storage/images/' . $produk->gambar));
        }

        $produk->delete();

        return response()->json([
            'message' => 'success'
        ]);
    }

    public function search(Request $request)
 {
     $query = Produk::query();
  
    
     if ($request->has('nama_barang')) {
         $query->where('nama_barang', 'like', '%' . $request->nama_barang . '%');
     }

     $results = $query->get();
  
     return response()->json([
         'data' => $results
     ]);
 }
}
