<?php

namespace App\Nova\Resources\Tours;

use App\Models\Tour;
use App\Models\Tour\TourTimetable;
use App\Nova\Filters\Tours\TourFilter;
use App\Nova\Resource;
use Emilianotisato\NovaTinyMCE\NovaTinyMCE;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\{Date, HasOne, ID, Select, Text, Trix};

class TimetableResource extends Resource
{
   public static string $model = TourTimetable::class;

   public static $title = 'name';

   public static $group = 'Tours';

   public static $search = [
      'id',
      'name'
   ];

   public static function label(): string
   {
      return __('Timetables');
   }

   public static function uriKey(): string
   {
      return 'tours-timetables';
   }

   public function fields(Request $request): array
   {
      return [
         ID::make()->sortable(),

         Select::make('Tour', 'tour_id')
            ->rules('required', 'in:' . Tour::all(['id'])->pluck('id')->implode(','))
            ->searchable()
            ->options(fn() => Tour::all(['id', 'name'])->keyBy('id')->map(fn($val) => $val->name))
            ->default(fn() => request('viaResource') !== 'tours' || !request('viaResourceId') ? null : request('viaResourceId'))
            ->onlyOnForms(),

         Text::make('Day')->rules('required', 'max:50'),
         Text::make('Name')->rules('required', 'max:150'),
         NovaTinyMCE::make('Description')->onlyOnForms()->nullable(),
         Date::make('Created At')->hideWhenCreating()->hideWhenUpdating(),

         HasOne::make('Tour', 'tour', TourResource::class)->onlyOnDetail(),
      ];
   }


   public function cards(Request $request): array
   {
      return [];
   }

   public function filters(Request $request): array
   {
      return [
         (new TourFilter)->setField('tour_id'),
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
