<?php

namespace App\Models\Tour;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TourPropertyPrice extends Model
{
    protected $fillable = [
        'name',
        'price'
    ];

    public function property(): HasOne
    {
        return $this->hasOne(TourProperties::class, 'id', 'property_id');
    }
}
