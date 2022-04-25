<?php

namespace App\Nova\Resources\Tours\Booked;

use App\Models\Tour\TourBooked;
use App\Models\Tour\TourBookedAmount;
use App\Nova\Resource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class AmountResource extends Resource
{
   public static string $model = TourBookedAmount::class;

   public static $globallySearchable = false;

   public static $displayInNavigation = false;

   public function fields(Request $request): array
   {
      return [
         ID::make()->sortable(),

         Text::make('Price Type', 'property_price_id', fn() => $this->propertyPrice->name ?? null),

         Number::make('Price', 'booked_id', fn() => number_format($this->propertyPrice->price) ?? null)
            ->sortable(),

         Number::make('Amount')
            ->sortable()
            ->rules('required', 'integer'),

         Date::make('Created At')->hideWhenCreating()->hideWhenUpdating(),
      ];
   }

   public static function authorizedToCreate(Request $request): bool
   {
      return false;
   }

   public function authorizedToUpdate(Request $request): bool
   {
      return false;
   }
}
