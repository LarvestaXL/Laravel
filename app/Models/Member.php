<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Carbon\Carbon;

class Member extends Authenticatable implements JWTSubject
{
    protected $guarded = [];
    protected $dates = ['banned_until'];

    public function checkouts()
    {
        return $this->hasMany(Checkout::class, 'member_id');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
