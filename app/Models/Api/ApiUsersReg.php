<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiUsersReg extends Model
{
    use HasFactory;

    protected $fillable = ['first_name', 'last_name', 'email', 'password', 'phone', 'api_token'];
}
