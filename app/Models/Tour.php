<?php

namespace App\Models;

use App\Models\Tour\TourCategory;
use App\Models\Tour\TourProperties;
use App\Models\Tour\TourTimetable;
use Emilianotisato\NovaTinyMCE\NovaTinyMCECasts;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Tour extends Model
{
   protected $fillable = [
      'category_id',
      'name',
      'description',
      'short_description',
      'cover_image',
      'location',
      'slug',
      'policy'
   ];

   protected $casts = [
      'location' => 'array',
      'description' => NovaTinyMCECasts::class,
      'policy' => NovaTinyMCECasts::class,
   ];

   public function category(): HasOne
   {
      return $this->hasOne(TourCategory::class, 'id', 'category_id');
   }

   public function properties(): HasMany
   {
      return $this->hasMany(TourProperties::class, 'tour_id', 'id');
   }

   public function timetables(): HasMany
   {
      return $this->hasMany(TourTimetable::class, 'tour_id', 'id')
         ->orderBy('created_at');
   }

   public function minPrice(): Attribute
   {
      return Attribute::get(fn() => $this->properties()->withMin('prices', 'price')->get(['prices_min_price'])->min('prices_min_price'));
   }

   public function maxPrice(): Attribute
   {
      return Attribute::get(fn() => $this->properties()->withMax('prices', 'price')->get(['prices_max_price'])->min('prices_max_price'));
   }
}
