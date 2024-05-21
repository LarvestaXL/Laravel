<?php
// CheckoutController.php

namespace App\Http\Controllers;

use App\Models\Checkout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index']);
    }

    public function index()
    {
        $checkouts = Checkout::all();

        return response()->json([
            'data' => $checkouts
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
            'city' => 'required',
            'province' => 'required',
            'payment_number' => 'required',
            'cart_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $input = $request->all();
        $checkout = Checkout::create($input);

        return response()->json(['data' => $checkout]);
    }

    public function show(Checkout $checkout)
    {
        return response()->json(['data' => $checkout]);
    }

    public function update(Request $request, Checkout $checkout)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
            'city' => 'required',
            'province' => 'required',
            'payment_number' => 'required',
            'cart_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $checkout->update($request->all());

        return response()->json(['data' => $checkout]);
    }

    public function destroy(Checkout $checkout)
    {
        if ($checkout->gambar) {
            File::delete(public_path('storage/images/' . $checkout->gambar));
        }

        $checkout->delete();

        return response()->json(['message' => 'success']);
    }
}
