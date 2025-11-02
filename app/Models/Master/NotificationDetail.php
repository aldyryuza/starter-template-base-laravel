<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class NotificationDetail extends Model
{
    protected $table = 'notification_details';

    public function notification()
    {
        return $this->belongsTo(Notification::class, 'notification_id');
    }

    public function user()
    {
        return $this->belongsTo(Users::class, 'user_id');
    }

}
