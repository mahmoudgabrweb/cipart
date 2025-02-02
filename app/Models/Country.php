<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    protected $fillable = ["name", "display_name", "iso", "iso3", "phone_code"];

    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }
}
