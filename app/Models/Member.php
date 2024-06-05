<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
 
class Member extends Authenticatable implements JWTSubject
{
    // Existing model content
 
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        //Mengembalikan nilai kunci utama dari model Member.
        return $this->getKey(); 
    }
 
    /**
     * 
     * 
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        //Mengembalikan array kosong, yang berarti tidak ada klaim khusus tambahan yang akan ditambahkan ke JWT.
        return [];
    }
    
    protected $guarded = [];
    //mendefinisikan atribut mana saja yang tidak boleh diisi secara massal. Dalam kasus ini, properti ini kosong, yang berarti semua atribut dapat diisi secara massal.
}