<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Car extends Model {
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'brand', 'model', 'year', 'engine_type', 'std_bhp', 'tuned_bhp', 'tuned_bhp_2', 'std_torque', 'tuned_torque', 'tuned_torque_2','title'
    ];
}
