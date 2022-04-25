<?php

namespace App\Http\Controllers;

use App\Models\Tour;

class TourDetailController extends Controller
{
   public function __invoke(string $slug)
   {
      $tour = Tour::whereSlug($slug)->firstOrFail();

      return view('tours.detail', compact('tour'));
   }
}
