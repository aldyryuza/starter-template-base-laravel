<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class RoutingHeader extends Model
{
    //
    protected $table = 'routing_header';
    protected $guarded = 'id';

    public function RoutingPermission()
    {
        return $this->hasMany(RoutingPermission::class, 'routing_header', 'id');
    }
}
