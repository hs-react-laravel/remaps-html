<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NotificationRead extends Model
{
    protected $fillable = [
        'notification_id',
        'user_id',
        'is_read'
    ];
}
