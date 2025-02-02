<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleStatus extends Model
{
    protected $fillable = ["name", "key", "is_active"];
}
