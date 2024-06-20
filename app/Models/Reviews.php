<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reviews extends Model
{
    use HasFactory;

    protected $fillable = [
        "checkout_id", "member_id", "content", "rating" , "produk_id"
    ];
    public function checkout()
    {
        return $this->belongsTo(Checkout::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}
