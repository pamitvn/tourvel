<?php

namespace App\Nova;

use App\Models\Slider;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;

class SliderResource extends Resource
{
   public static string $model = Slider::class;

   public static $title = 'id';

   public static $globallySearchable = false;

   public static function label(): string
   {
      return __('Sliders');
   }

   public static function uriKey(): string
   {
      return 'sliders';
   }

   public function fields(Request $request): array
   {
      return [
         ID::make()->sortable(),

         Image::make('Cover image')->rules('required'),

         Date::make('Created At')->hideWhenCreating()->hideWhenUpdating(),
      ];
   }
}
