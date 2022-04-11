<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'company_id',
        'subject',
        'body',
        'icon'
    ];
}
