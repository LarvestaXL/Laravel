<?php

namespace App\Http\Controllers;

use App\Models\Testimoni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Psy\CodeCleaner\ReturnTypePass;

class TestimoniController extends Controller
{

    public function __construct(){
        $this->middleware('auth:api')->except(['index']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()

    {
        $testimonis = Testimoni::all();

        return response()->json([
            'data' => $testimonis
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_testimoni' => 'required',
            'deskripsi' => 'required',
            'gambar' => 'required|image|mimes:jpg,png,webp'
        ]);

        if ($validator->fails()){
            return response()->json(
                $validator->errors(),
                422
            );
        };

        $input = $request->all();

        if ($request->has('gambar')){
            $gambar = $request->file('gambar');
            $nama_gambar = time() . rand(1,9) . '.' . $gambar->getClientOriginalExtension();
            $path = $gambar->storeAs('public/images', $nama_gambar);
            $input['gambar'] = $nama_gambar;
        }
        

        $testimoni = Testimoni::create($input);

        return response()->json([
            'data' => $testimoni
        ]);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Testimoni  $testimoni
     * @return \Illuminate\Http\Response
     */
    public function show(Testimoni $testimoni)
    {
        return response()->json([
            'data' => $testimoni
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Testimoni  $testimoni
     * @return \Illuminate\Http\Response
     */
    public function edit(Testimoni $testimoni)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Testimoni  $testimoni
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Testimoni $testimoni)
    {
        $validator = Validator::make($request->all(), [
            'nama_testimoni' => 'required',
            'deskripsi' => 'required',
            'gambar' => 'required|image|mimes:jpg,png,webp'
            
        ]);
    
        if ($validator->fails()){
            return response()->json(
                $validator->errors(),
                422
            );
        }
    
        $input = $request->all();
    
        if ($request->hasFile('gambar')) {
            // Menghapus gambar yang sudah ada
            if ($testimoni->gambar) {
                File::delete(public_path('storage/images/' . $testimoni->gambar));
            }
    
            // Mengunggah gambar yang baru
            $gambar = $request->file('gambar');
            $nama_gambar = time() . rand(1,9) . '.' . $gambar->getClientOriginalExtension();
            $path = $gambar->storeAs('public/images', $nama_gambar);
            $input['gambar'] = $nama_gambar;
        } else {
            // Jika tidak ada gambar baru, hapus informasi gambar dari input
            unset($input['gambar']);
        }
    
        // Memperbarui data kategori
        $testimoni->update($input);
    
        return response()->json([
            'message' => 'success',
            'data' => $testimoni
        ]);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Testimoni  $testimoni
     * @return \Illuminate\Http\Response
     */
    public function destroy(Testimoni $testimoni)
{
    if ($testimoni->gambar) {
        // Hapus gambar terkait jika ada
        File::delete(public_path('storage/images/' . $testimoni->gambar));
    }

    // Hapus data kategori dari database
    $testimoni->delete();

    return response()->json([
        'message' => 'success'
    ]);
}

}
