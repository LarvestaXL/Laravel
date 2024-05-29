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
        return [];
    }
    
    protected $guarded = [];
}