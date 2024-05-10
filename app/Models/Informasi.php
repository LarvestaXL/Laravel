<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Informasi extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'informasi_pembeli';
    protected $fillable = [
        'email', 'first_name', 'last_name', 'address', 'apartmen', 'province', 'payment_method', 'postal_code', 'payment_number'
    ];
}
