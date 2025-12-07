<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class MasterAplikasi extends Model
{
    use Notifiable;
    use SoftDeletes;
    protected $table = 'master_aplikasi';
}
