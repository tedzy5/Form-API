<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    use HasFactory;

    protected $fillable = ['first_name', 'last_name', 'email', 'mobile', 'category'];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
}
