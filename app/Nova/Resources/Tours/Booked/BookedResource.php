<?php

namespace App\Nova\Resources\Tours\Booked;

use App\Enums\TourStatusEnum;
use App\Models\Customer;
use App\Models\Tour\TourBooked;
use App\Models\Tour\TourProperties;
use App\Nova\{CustomerResource, Resource, Resources\Tours\Properties\PropertyResource};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Laravel\Nova\Fields\{Date, DateTime, HasMany, HasOne, Hidden, ID, Select, Text, Textarea};

class BookedResource extends Resource
{
    public static string $model = TourBooked::class;

    public static $title = 'id';

    public static $group = 'Tours';

    public static $search = [
        'customer_id',
        'customer.full_name',
        'customer.phone_number',
        'customer.email',
    ];

    public static function label(): string
    {
        return __('Booked');
    }

    public static function uriKey(): string
    {
        return 'tours-booked';
    }

    public function title(): string
    {
        return Blade::render(
            'Booked #{{ $id }} - Tour #{{ $tourId }} - {{ $fullName }}',
            [
                'id' => $this->id,
                'tourId' => $this->property->tour->id,
                'fullName' => $this->customer->full_name,
            ],
            true
        );
    }

    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),

            Text::make('Total Price', fn($val) => number_format($val['total_price']))->default(fn() => 0),
            Textarea::make('Note', 'note'),
            Date::make('Started Date', 'started_date'),
            Date::make('Created Date', 'created_at'),

            HasOne::make('Customer', 'customer', CustomerResource::class)->onlyOnDetail(),
            HasOne::make('Properties', 'property', PropertyResource::class)->onlyOnDetail(),
            HasMany::make('Amounts', 'amounts', AmountResource::class)->onlyOnDetail()
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
