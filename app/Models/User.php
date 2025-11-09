<?php

namespace App\Models;

use App\Models\Master\UserGroup;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    protected $fillable = [
        'username',
        'password',
        'name',
        'user_group',
        'employee_code',
        'nik'
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function  UserGroup()
    {
        return $this->belongsTo(UserGroup::class, 'user_group', 'id');
    }
}
