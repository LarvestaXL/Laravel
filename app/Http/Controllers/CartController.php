<?php

namespace App\Http\Controllers;

use App\Models\cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Psy\CodeCleaner\ReturnTypePass;

class cartController extends Controller
{


 /*    public function www(){
        return "www";
    } */
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
        $carts = cart::all();

        return response()->json([
            'data' => $carts
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
            'produk_id' => 'required',
            'member_id' => 'required'       
        ]);

        if ($validator->fails()){
            return response()->json(
                $validator->errors(),
                422
            );
        };

        $input = $request->all();

  
        $cart = cart::create($input);

        return response()->json([
            'data' => $cart
        ]);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(cart $cart)
    {
        return response()->json([
            'data' => $cart
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, cart $cart)
    {
        $validator = Validator::make($request->all(), [
            'produk_id' => 'required',
            'member_id' => 'required'             
        ]);
    
        if ($validator->fails()){
            return response()->json(
                $validator->errors(),
                422
            );
        }
    
        $input = $request->all();
    
        // Memperbarui data kategori
        $cart->update($input);
    
        return response()->json([
            'message' => 'success',
            'data' => $cart
        ]);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(cart $cart)
{
    if ($cart->gambar) {
        // Hapus gambar terkait jika ada
        File::delete(public_path('storage/images/' . $cart->gambar));
    }

    // Hapus data kategori dari database
    $cart->delete();

    return response()->json([
        'message' => 'success'
    ]);
}

}
