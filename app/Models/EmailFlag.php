<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailFlag extends Model
{
    //
    use SoftDeletes;
    protected $fillable = [
        'company_id', 'is_email_failed', 'description'
    ];
}
