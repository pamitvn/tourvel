<?php

namespace App\View\Components\Category;

use App\Models\Tour;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class TourCategoryItem extends Component
{

   public Collection|Tour $tour;

   public function __construct($tour)
   {
      $this->tour = $tour;
   }

   public function render(): View
   {
      return view('components.category.tour-category-item');
   }
}
