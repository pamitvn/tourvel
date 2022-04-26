<?php

namespace App\Models\Tour;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TourBooked extends Model
{
   protected $table = 'tour_booked';

   protected $fillable = [
      'customer_id',
      'tour_property_id',
      'amounts',
      'total_price',
      'started_date',
      'note'
   ];

   protected $casts = [
      'amounts' => 'array',
      'started_date' => 'date'
   ];

   public function customer(): HasOne
   {
      return $this->hasOne(Customer::class, 'id', 'customer_id');
   }

   public function property(): HasOne
   {
      return $this->hasOne(TourProperties::class, 'id', 'tour_property_id');
   }

   public function amounts(): HasMany
   {
      return $this->hasMany(TourBookedAmount::class, 'booked_id', 'id');
   }
}
