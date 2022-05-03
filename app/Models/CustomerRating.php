<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerRating extends Model
{
    use SoftDeletes;
	protected $fillable = ['rating', 'user_id', 'company_id'];
}
