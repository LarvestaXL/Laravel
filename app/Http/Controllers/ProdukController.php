<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ProdukController extends Controller
{
    public function __construct(){
        //Meneraokan middleware auth:api kecuali index,search,dan show
        $this->middleware('auth:api')->except(['index', 'search', 'show']);
    }
//nambahkan update tidak perlu auth
    public function index()
    {
        //Mengambil semua produk dan mengembalikannya dalam format JSON.
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
        //Validasi request
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
        //menghandle inputan
        $input = $request->all();
        //Menagani Input gambar
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
        //validasi rewuest
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
        //Menangani Inputan
        $input = $request->all();
        //Jika terdapatMenghaous gambar yang sudah ada sebelumnya
        if ($request->hasFile('gambar')) {
            if ($produk->gambar) {
                File::delete(public_path('storage/images/' . $produk->gambar));
            }
            // Mengatasi Upload gambar/image
            $gambar = $request->file('gambar');
            $nama_gambar = time() . rand(1,9) . '.' . $gambar->getClientOriginalExtension();
            $path = $gambar->storeAs('public/images', $nama_gambar);
            $input['gambar'] = $nama_gambar;
        } else {
            unset($input['gambar']);
        }

        $produk->update($input);
        //Memberikan pesan 'succes ' ketika berhasil  UPdate
        return response()->json([ 
            'message' => 'success',
            'data' => $produk
        ]);
    }

    public function destroy(Produk $produk)
    {
        //Menghapus gambar
        if ($produk->gambar) {
            File::delete(public_path('storage/images/' . $produk->gambar));
        }
        //Menghapus data produk
        $produk->delete();
        //Menampilkan pesan 'success' ketika berhasil hapus gambar
        return response()->json([
            'message' => 'success'
        ]);
    }

    public function search(Request $request)
 {
     $query = Produk::query();
  
    //Searching brang berdasarkan kemiripan nama banrang 
     if ($request->has('nama_barang')) {
         $query->where('nama_barang', 'like', '%' . $request->nama_barang . '%');
     }

     $results = $query->get();
     //Menampilkan data pencarian
     return response()->json([
         'data' => $results
     ]);
 }
}
