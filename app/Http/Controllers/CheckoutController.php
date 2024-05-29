<?php

namespace App\Http\Controllers;

use App\Models\Checkout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
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
        $chekouts = Checkout::all();
        return response()->json(['data' => $chekouts]);
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

        // Create the Checkout item
        $checkout = Checkout::create($input);

        return response()->json(['data' => $checkout]);
    }

    public function show(Checkout $checkout)
    {
        return response()->json(['data' => $checkout]);
    }

  
}
