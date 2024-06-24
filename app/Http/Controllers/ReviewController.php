<?php

namespace App\Http\Controllers;

use App\Models\Reviews;
use App\Models\Checkout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    protected $userRole;

    public function __construct()
    {
        // Middleware untuk memperbolehkan Member mengakses
        $this->middleware('role:member')->except(['index', 'show','destroy']);
        
        // Mendapatkan Role user yang login
        if (auth()->check()) {
            $this->userRole = auth()->user()->role;
        }
    }

    public function index()
    {
        $reviews = Reviews::all();
        return response()->json(['data' => $reviews]);
    }

    public function store(Request $request)
    {
        // Validasi Request
        $validator = Validator::make($request->all(), [
            'content' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'checkout_id' => 'required|exists:checkout,id', // Tambahkan validasi untuk checkout_id
          
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Ambil data checkout berdasarkan checkout_id
        $checkout = Checkout::findOrFail($request->checkout_id);

        // membaca dari checkout
        $review = new Reviews();
        $review->content = $request->content;
        $review->rating = $request->rating;
        $review->checkout_id = $request->checkout_id;
        $review->produk_id = $checkout->produk_id; // produk_id dari checkout
        $review->member_id = $checkout->member_id; // member_id dari checkout
        
        $review->save();

        return response()->json(['data' => $review]);
    }

    public function show(Reviews $reviews)
    {
        return response()->json(['data' => $reviews]);
    }

    public function destroy(Reviews $reviews)
    {
        // Delete Gambar jika ada
        if ($reviews->gambar) {
            File::delete(public_path('storage/images/' . $reviews->gambar));
        }
        //menghapus data di database
        $reviews->delete();
        //return pesan berhaisl hapus data
        return response()->json(['message' => 'berhasil hapus data']);
    }
}
