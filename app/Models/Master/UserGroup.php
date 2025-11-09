<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class UserGroup extends Model
{
    //
    protected $table = 'users_group';
    protected $guarded = [];

    public function PermissionUser()
    {
        return $this->hasMany(PermissionUsers::class, 'user_group', 'id');
    }
}
