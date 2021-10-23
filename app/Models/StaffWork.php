<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffWork extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'fileservice_id', 'ticket_id'
    ];
}
