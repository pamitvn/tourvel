<?php

namespace App\Models;

use App\Models\Tour\TourBooked;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    protected $fillable = [
        'full_name',
        'email',
        'phone_number',
    ];

    public function booked(): HasMany
    {
        return $this->hasMany(TourBooked::class, 'customer_id', 'id');
    }
}
