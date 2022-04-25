<?php

namespace App\Http\Controllers;

use App\Models\Tour;

class TourBookingController extends Controller
{
   public function __invoke(string $slug, Tour\TourProperties $property)
   {
      $tour = Tour::whereSlug($slug)->withCount('timetables')->whereHas('properties', fn($query) => $query->whereId($property->id))->firstOrFail();

      return view('tours.booking', compact('tour', 'property'));
   }
}
