<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiPackage extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'pay_plan_id', 'amount', 'description'];
}
