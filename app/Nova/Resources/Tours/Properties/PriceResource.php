<?php

namespace App\Nova\Resources\Tours\Properties;

use App\Models\Tour\TourProperties;
use App\Models\Tour\TourPropertyPrice;
use App\Nova\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;

class PriceResource extends Resource
{
   public static string $model = TourPropertyPrice::class;

   public static $title = 'name';

   public static $search = [
      'id', 'name'
   ];

   public static $group = 'Tours';

   public static $displayInNavigation = false;

   public static function label(): string
   {
      return __('Property Prices');
   }

   public function fields(Request $request): array
   {
      $properties = TourProperties::with('tour')->get(['id', 'started_date', 'vehicle', 'amount', 'status', 'tour_id']);

      return [
         ID::make()->sortable(),

         Select::make('Property', 'property_id')
            ->rules('required', 'in:' . $properties->pluck('id')->implode(','))
            ->searchable()
            ->options(fn() => $properties->keyBy('id')->map(fn($val) => [
               'label' => Blade::render(
                  '{{ $startedDate }} - {{ $vehicle }}@if($amount !== -1) - {{ $seatAvailable }}/{{ $amount }}@endif',
                  [
                     'startedDate' => $val->started_date->format('d/m/Y'),
                     'vehicle' => $val->vehicle,
                     'seatAvailable' => $val->seat_available,
                     'amount' => $val->amount
                  ],
                  true
               ),
               'group' => "Tour #{$val->tour->id} - Property #{$val->id}"
            ]))
            ->default(fn() => request('viaResource') !== 'tours-properties' || !request('viaResourceId') ? null : request('viaResourceId'))
            ->onlyOnForms(),

         Text::make('Name')
            ->sortable()
            ->rules('required', 'max:50'),

         Number::make('Price', 'price')
            ->sortable()
            ->rules('required', 'integer')
            ->displayUsing(fn() => number_format($this->price ?? 0)),

         Date::make('Created At')->hideWhenCreating()->hideWhenUpdating(),

         HasOne::make('Property', 'property', PropertyResource::class)->onlyOnDetail()
      ];
   }
}
