<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';
    protected $fillable = ['title', 'description', 'user_ids', 'read_by'];

    protected $casts = [
        'user_ids' => 'array',
        'read_by' => 'array'
    ];

    public function markAsRead($userId)
    {
        $readBy = $this->read_by ?? [];
        $userIdStr = (string)$userId;

        if (!in_array($userIdStr, $readBy)) {
            $readBy[] = $userIdStr;
            $this->read_by = $readBy;
            return $this->save();
        }

        return true;
    }

    public function isReadByUser($userId)
    {
        $readBy = $this->read_by ?? [];
        return in_array((string)$userId, $readBy);
    }

    public function scopeUnreadByUser($query, $userId)
    {
        return $query->where(function ($q) use ($userId) {
            $q->whereNull('read_by')
                ->orWhereJsonDoesntContain('read_by', (string)$userId);
        });
    }

    public function creator()
    {
        return $this->belongsTo(Users::class, 'created_by');
    }

    public function details()
{
    return $this->hasMany(NotificationDetail::class, 'notification_id');
}
}
