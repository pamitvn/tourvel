<?php

namespace App\Nova\Resources\Tours\Properties;

use App\Enums\TourStatusEnum;
use App\Models\Tour;
use App\Models\Tour\TourProperties;
use App\Nova\Actions\Tours\TourPropertiesStatusAction;
use App\Nova\Filters\Tours\TourFilter;
use App\Nova\Filters\Tours\TourPropertiesStatusFilter;
use App\Nova\Resource;
use App\Nova\Resources\Tours\Booked\BookedResource;
use App\Nova\Resources\Tours\TourResource;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\{Badge, Date, HasMany, HasOne, ID, Number, Select, Stack, Text};


class PropertyResource extends Resource
{
   public static string $model = TourProperties::class;

   public static $title = 'name';

   public static $group = 'Tours';

   public static $search = [
      'id',
      'tour_id',
      'vehicle',
      'price',
      'status'
   ];

   public static function label(): string
   {
      return __('Properties');
   }

   public static function uriKey(): string
   {
      return 'tours-properties';
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

         Stack::make('Tour Details', [
            Text::make('Tour category', fn() => "Category: " . $this->tour->category->name),
            Text::make('Tour', fn() => "Name: " . $this->tour->name),
         ])->onlyOnDetail(),

         Date::make('Started Date')
            ->sortable()
            ->rules('nullable', 'date'),

         Text::make('Contact Phone')->rules('nullable', 'min:10', 'max:11'),
         Text::make('Time')->rules('nullable'),
         Text::make('Vehicle')->rules('nullable'),

         Number::make('Amount')
            ->sortable()
            ->rules('required', 'integer')
            ->default(fn() => -1),

         Badge::make('Status', fn() => $this->status->value ?? TourStatusEnum::Seats->value)
            ->types(TourStatusEnum::classToArray())
            ->label(fn() => TourStatusEnum::label($this->status->value ?? TourStatusEnum::Seats->value))
            ->showOnDetail()
            ->showOnIndex(),

         Date::make('Created At')->hideWhenCreating()->hideWhenUpdating(),

         HasOne::make('Tour', 'tour', TourResource::class)->onlyOnDetail(),
         HasMany::make('Prices', 'prices', PriceResource::class)->onlyOnDetail(),
         HasMany::make('Booked', 'booked', BookedResource::class)->onlyOnDetail()
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
         new TourPropertiesStatusFilter,
      ];
   }

   public function lenses(Request $request): array
   {
      return [];
   }

   public function actions(Request $request): array
   {
      return [
         (new TourPropertiesStatusAction)->showOnIndex()->showInline()
      ];
   }
}
