<?php

namespace App\Nova;

use App\Models\Customer;
use App\Nova\Resources\Tours\Booked\BookedResource;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\{Date, HasMany, ID, Text};

class CustomerResource extends Resource
{
    public static string $model = Customer::class;

    public static $title = 'full_name';

    public static $group = 'User';

    public static $search = [
        'id', 'full_name', 'email', 'phone_number'
    ];

    public static function label(): string
    {
        return __('Customers');
    }

    public static function uriKey(): string
    {
        return 'customers';
    }

    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),

            Text::make('Full Name')
                ->sortable()
                ->rules('required'),

            Text::make('Email')
                ->sortable()
                ->rules('required', 'unique:customers,email', 'email', 'max:254'),

            Text::make('Phone Number')
                ->sortable()
                ->rules('required', 'unique:customers,phone_number'),

           Date::make('Created At')->hideWhenCreating()->hideWhenUpdating(),

            HasMany::make('Booked', 'booked', BookedResource::class)->onlyOnDetail(),
        ];
    }

    public function cards(Request $request): array
    {
        return [];
    }

    public function filters(Request $request): array
    {
        return [];
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
