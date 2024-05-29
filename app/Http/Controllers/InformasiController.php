<?php

namespace App\Http\Controllers;

use App\Models\Informasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Psy\CodeCleaner\ReturnTypePass;

class InformasiController extends Controller
{


 /*    public function www(){
        return "www";
    } */
    public function __construct(){
        $this->middleware('auth:sanctum')->except(['index']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()

    {
        $informasis = Informasi::all();

        return response()->json([
            'data' => $informasis
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
            'email' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
            'province' => 'required',
            'payment_method' => 'required',
            'payment_number' => 'required',
            'cart_id' => 'required'
        ]);

        if ($validator->fails()){
            return response()->json(
                $validator->errors(),
                422
            );
        };

        $input = $request->all();
        $informasi = Informasi::create($input);

        return response()->json([
            'data' => $informasi
        ]);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Informasi  $informasi
     * @return \Illuminate\Http\Response
     */
    public function show(Informasi $informasi)
    {
        return response()->json([
            'data' => $informasi
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Informasi  $informasi
     * @return \Illuminate\Http\Response
     */
    public function edit(Informasi $informasi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Informasi  $informasi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Informasi $informasi)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
            'provnce' => 'required',
            'payment_method' => 'required',
            'payment_number' => 'required',
            'cart_id' => 'reqired',
        ]);

        if ($validator->fails()){
            return response()->json(
                $validator->errors(),
                422
            );
        };

        $input = $request->all();
        $informasi = Informasi::create($input);

        return response()->json([
            'data' => $informasi
        ]);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Informasi  $informasi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Informasi $informasi)
{
    if ($informasi->gambar) {
        // Hapus gambar terkait jika ada
        File::delete(public_path('storage/images/' . $informasi->gambar));
    }

    // Hapus data kategori dari database
    $informasi->delete();

    return response()->json([
        'message' => 'success'
    ]);
}

}
