<?php

namespace App\Models\Tour;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TourBookedAmount extends Model
{
    protected $table = 'tour_booked_amounts';

    protected $fillable = [
        'booked_id',
        'property_price_id',
        'amount'
    ];

    public function booked(): HasOne
    {
        return $this->hasOne(TourBooked::class, 'id', 'booked_id');
    }

    public function propertyPrice(): HasOne
    {
        return $this->hasOne(TourPropertyPrice::class, 'id', 'property_price_id');
    }
}
