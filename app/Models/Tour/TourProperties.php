<?php

namespace App\Models\Tour;

use App\Enums\TourStatusEnum;
use App\Models\Tour;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TourProperties extends Model
{
   protected $fillable = [
      'tour_id',
      'contact_phone',
      'time',
      'started_date',
      'vehicle',
      'amount',
      'status',
   ];

   protected $casts = [
      'status' => TourStatusEnum::class,
      'started_date' => 'date',
   ];

   public function prices(): HasMany
   {
      return $this->hasMany(TourPropertyPrice::class, 'property_id', 'id');
   }

   public function tour(): HasOne
   {
      return $this->hasOne(Tour::class, 'id', 'tour_id');
   }

   public function booked(): HasMany
   {
      return $this->hasMany(TourBooked::class, 'tour_property_id', 'id');
   }

   public function seatAvailable(): Attribute
   {
      return Attribute::get(function () {
         if ($this->status->value !== TourStatusEnum::Seats->value || $this->amount === -1) return -1;

         return TourBooked::whereTourPropertyId($this->id)->count();
      });
   }
}
