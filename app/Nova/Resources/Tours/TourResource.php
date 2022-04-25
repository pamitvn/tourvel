<?php

namespace App\Nova\Resources\Tours;

use App\Models\Tour;
use App\Nova\Filters\Tours\TourCategoryFilter;
use App\Nova\Metrics\Tours\Status\CancelMetrics;
use App\Nova\Metrics\Tours\Status\CompleteMetrics;
use App\Nova\Metrics\Tours\Status\StartedMetrics;
use App\Nova\Metrics\Tours\TourStatusMetrics;
use App\Nova\Resource;
use App\Nova\Resources\Tours\Properties\PropertyResource;
use Emilianotisato\NovaTinyMCE\NovaTinyMCE;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\{Date, HasMany, HasOne, ID, Image, Select, Slug, Text, Textarea, Trix};
use Illuminate\Support\Arr;

class TourResource extends Resource
{
   public static string $model = Tour::class;

   public static $title = 'name';

   public static $group = 'Tours';

   public static $search = [
      'id',
      'name',
   ];

   public static function label(): string
   {
      return __('Tours');
   }

   public static function uriKey(): string
   {
      return 'tours';
   }

   public function fields(Request $request): array
   {
      return [
         ID::make()->sortable(),
         Select::make('Category', 'category_id')
            ->rules('required', 'in:' . Tour\TourCategory::all(['id'])->pluck('id')->implode(','))
            ->searchable()
            ->options(fn() => Tour\TourCategory::all(['id', 'name'])->keyBy('id')->map(fn($val) => $val->name))
            ->default(fn() => request('viaResource') !== 'tours-categories' || !request('viaResourceId') ? null : request('viaResourceId'))
            ->onlyOnForms(),
         Text::make('Name')->rules('required', 'max:150'),
         Slug::make('Slug')->from('Name')
            ->rules('required')
            ->creationRules('unique:tours,slug')
            ->updateRules('unique:tours,slug,{{resourceId}}'),
         Text::make('From', 'locationFrom', fn() => Arr::get($this->location, 'from'))
            ->rules('required', 'max:150')
            ->displayUsing(fn() => Arr::get($this->location, 'from'))
            ->fillUsing(fn(Request $request, Tour $tour, $attr) => $tour->location = array_merge($tour->location ?? [], [
               'from' => $request->input($attr)
            ])),
         Text::make('To', 'locationTo', fn() => Arr::get($this->location, 'to'))
            ->rules('required', 'max:150')
            ->displayUsing(fn() => Arr::get($this->location, 'to'))
            ->fillUsing(fn(Request $request, Tour $tour, $attr) => $tour->location = array_merge($tour->location ?? [], [
               'to' => $request->input($attr)
            ])),
         Textarea::make('Short Description')->nullable(),
         NovaTinyMCE::make('Description')->onlyOnForms()->nullable(),
         NovaTinyMCE::make('Policy')->onlyOnForms()->nullable(),
         Image::make('Feature Image', 'cover_image')->nullable(),
         Date::make('Created At')->hideWhenCreating()->hideWhenUpdating(),

         HasOne::make('Category', 'category', CategoryResource::class)
            ->onlyOnDetail(),
         HasMany::make('Timetable', 'timetables', TimetableResource::class)
            ->onlyOnDetail(),
         HasMany::make('Properties', 'properties', PropertyResource::class)
            ->onlyOnDetail(),
      ];
   }

   public function cards(Request $request): array
   {
      return [
         new CompleteMetrics,
         new CancelMetrics,
         new StartedMetrics,
      ];
   }

   public function filters(Request $request): array
   {
      return [
         (new TourCategoryFilter)->setField('category_id')
      ];
   }

   public function lenses(Request $request): array
   {
      return [];
   }

   public function actions(Request $request): array
   {
      return [];
   }
}
