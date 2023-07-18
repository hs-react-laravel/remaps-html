<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiUser extends Model
{
    use HasFactory;

    protected $fillable = ['first_name', 'last_name', 'email', 'phone', 'api_token'];

    public function getFullNameAttribute() {
        return ucwords($this->first_name . ' ' . $this->last_name);
    }
}
