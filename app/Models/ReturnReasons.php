<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReturnReasons extends Model
{
    protected $fillable = ["reason", "is_active"];
}
