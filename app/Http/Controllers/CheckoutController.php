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
        // Middleware to allow access to members except index and show can be accessed by everyone
        $this->middleware('role:member')->except(['index', 'show']);
        
        // Getting the role of the currently logged in user
        if (auth()->check()) {
            $this->userRole = auth()->user()->role;
        }
    }

    public function index(Request $request)
    {
        // Paginate checkouts
        $perPage = $request->get('per_page', 5);
        $checkouts = Checkout::paginate($perPage);
        return response()->json(['data' => $checkouts]);
    }

    public function store(Request $request)
    {
        // Validate request
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

        // Handle input
        $input = $request->all();

        // Handle image upload
        if ($request->hasFile('gambar')) {
            $imageName = time() . '.' . $request->gambar->extension();
            $request->gambar->move(public_path('storage/images'), $imageName);
            $input['gambar'] = $imageName;
        }

        $checkout = Checkout::create($input);

        return response()->json(['data' => $checkout]);
    }

    public function show(Checkout $checkout)
    {
        return response()->json(['data' => $checkout]);
    }
}
