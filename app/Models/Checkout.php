<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    use HasFactory;
    protected $table = 'checkout';
    protected $fillable = [
        'email', 'first_name', 'last_name', 'address', 'apartmen', 'province', 'payment_method', 'postal_code', 'payment_number', 'produk_id', 'member_id', 'total_harga', 'cart_id', 'city'
    ];
}


