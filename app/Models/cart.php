<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    // mendefinisikan atrribut yang dapat diisi secara massal
    protected $fillable = ['produk_id', 'member_id', 'gambar', 'nama_barang', 'harga'];
}
