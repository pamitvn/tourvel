<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Slider extends Component
{
   public function render(): View
   {
      $sliders = \App\Models\Slider::get();

      return view('components.slider', compact('sliders'));
   }
}
