<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VehicleModel extends Model
{
    protected $fillable = ["name", "vehicle_maker_id", "is_active"];

    public function maker(): BelongsTo
    {
        return $this->belongsTo(VehicleMaker::class, 'vehicle_maker_id'); // important to mention FK
    }
}
