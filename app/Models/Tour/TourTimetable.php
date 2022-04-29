<?php

namespace App\Models\Tour;

use App\Models\Tour;
use Emilianotisato\NovaTinyMCE\NovaTinyMCECasts;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TourTimetable extends Model
{
   protected $fillable = [
      'tour_id',
      'day',
      'name',
      'description',
   ];

   protected $casts = [
      'description' => NovaTinyMCECasts::class
   ];

   public function tour(): HasOne
   {
      return $this->hasOne(Tour::class, 'id', 'tour_id');
   }
}
