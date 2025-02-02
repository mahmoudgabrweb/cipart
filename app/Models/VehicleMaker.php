<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VehicleMaker extends Model
{
    protected $fillable = ["name", "logo", "is_active"];

    public function models(): HasMany
    {
        return $this->hasMany(VehicleModel::class);
    }
}
