<?php

namespace App\Http\Livewire;

use App\Enums\TourStatusEnum;
use App\Models\Tour;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class TourCategory extends Component
{

   public string $name;

   public Tour\TourCategory $category;

   public Collection|Tour $tours;

   public bool $hasTour;

   public int $pageNumber = 1;

   public bool $hasMorePages = true;

   public function mount(\App\Models\Tour\TourCategory $category)
   {
      $this->category = $category;
      $this->name = $category->name;
      $this->tours = new Collection();

      $this->loadMore();
   }

   public function loadMore()
   {
      $tours = $this->category->tours()
         ->orderByDesc('created_at')
         ->whereHas('properties', fn(Builder $query) => $query->where('status', TourStatusEnum::Seats))
         ->paginate(3, '*', 'page', $this->pageNumber);

      $this->hasTour = $tours->isNotEmpty();

      $this->pageNumber += 1;
      $this->hasMorePages = $tours->hasMorePages();

      $this->tours->push(...$tours->items());
   }

   public function render(): Factory|View|Application
   {
      return view('livewire.tour-category');
   }
}
