<?php

namespace App\Http\Controllers;

use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Psy\CodeCleaner\ReturnTypePass;

class SubCategoryController extends Controller
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
        $subcategory = SubCategory::all();

        return response()->json([
            'data' => $subcategory
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
            'nama_subkategori' => 'required',
            'category_id' => 'required',
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
        

        $subcategory = SubCategory::create($input);

        return response()->json([
            'data' => $subcategory
        ]);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SubCategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function show(SubCategory $subcategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SubCategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function edit(SubCategory $subcategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SubCategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SubCategory $subcategory)
{
    $validator = Validator::make($request->all(), [
        'nama_subkategori' => 'required',
        'category_id' => 'required',
        'deskripsi' => 'required',
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
        if ($subcategory->gambar) {
            File::delete(public_path('storage/images/' . $subcategory->gambar));
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

    // Memperbarui data subkategori
    $subcategory->update($input);

    return response()->json([
        'message' => 'success',
        'data' => $subcategory
    ]);
}

    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SubCategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubCategory $subcategory)
{
    if ($subcategory->gambar) {
        // Hapus gambar terkait jika ada
        File::delete(public_path('storage/images/' . $subcategory->gambar));
    }

    // Hapus data kategori dari database
    $subcategory->delete();

    return response()->json([
        'message' => 'success'
    ]);
}

}
