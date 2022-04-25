<?php

namespace App\Nova\Resources\Tours;

use App\Models\Tour\TourCategory;
use App\Nova\Resource;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\{Date, HasMany, ID, Text};

class CategoryResource extends Resource
{
   public static string $model = TourCategory::class;

   public static $title = 'name';

   public static $group = 'Tours';

   public static $search = [
      'id',
      'name'
   ];

   public static function label(): string
   {
      return __('Categories');
   }

   public static function uriKey(): string
   {
      return 'tours-categories';
   }

   public function fields(Request $request): array
   {
      return [
         ID::make()->sortable(),
         Text::make('Name')->rules('required', 'max:150'),
         Date::make('Created At')->hideWhenCreating()->hideWhenUpdating(),

         HasMany::make('Tours', 'tours', TourResource::class)->onlyOnDetail()
      ];
   }
}
