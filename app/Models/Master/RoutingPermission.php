<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class RoutingPermission extends Model
{
    protected $table = 'routing_permission';
    protected $guarded = 'id';

    public function RoutingHeader()
    {
        return $this->belongsTo(RoutingHeader::class, 'id', 'routing_header');
    }

    public function Users()
    {
        return $this->belongsTo(Users::class, 'users', 'id');
    }
    public function Menu()
    {
        return $this->belongsTo(Menu::class, 'menu', 'id');
    }
    public function Dictionary()
    {
        return $this->belongsTo(Dictionary::class, 'state', 'term_id');
    }
}
