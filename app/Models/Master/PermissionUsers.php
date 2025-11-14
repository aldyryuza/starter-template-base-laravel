<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class PermissionUsers extends Model
{
    //
    protected $table = 'permission_users';
    protected $guarded = [];

    public function MasterMenu()
    {
        return $this->belongsTo(Menu::class, 'menu', 'id');
    }

    public function UserGroup()
    {
        return $this->belongsTo(UserGroup::class, 'user_group', 'id');
    }
}
