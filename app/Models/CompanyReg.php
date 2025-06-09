<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CompanyReg extends Model
{
  use HasFactory;

  protected $fillable = [
    'name', 
    'main_email_address', 
    'password', 
    'own_domain', 
    'v2_domain_link', 
    'address_line_1', 
    'address_line_2', 
    'town', 
    'country', 
    'vat_number',
    'logo',
    'status'
  ];
}
