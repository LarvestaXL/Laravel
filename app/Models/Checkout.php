<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    use HasFactory;

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }
        public function reviews()
    {
        return $this->hasMany(Reviews::class);
    }
    // Mendefinisikan table yang diisi
    protected $table = 'checkout';

    // Mendefinisikan atribut yang dapat diisi secara massal
    protected $fillable = [
        'email', 'first_name', 'last_name', 'address', 'apartmen', 'province', 'payment_method', 'postal_code', 'payment_number', 'produk_id', 'member_id', 'total_harga', 'cart_id', 'city','status'
    ];
}
