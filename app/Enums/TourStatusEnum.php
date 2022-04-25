<?php

namespace App\Enums;

use Illuminate\Support\Arr;

enum TourStatusEnum: string
{
    case Cancel = '0';
    case Complete = '1';
    case Started = '2';
    case Seats = '3';
    case SeatsFull = '4';

    public static function label(int|string $value): string
    {
        $enumLabel = [
            '0' => __('nova.tours.properties.cancel'),
            '1' => __('nova.tours.properties.complete'),
            '2' => __('nova.tours.properties.started'),
            '3' => __('nova.tours.properties.seats'),
            '4' => __('nova.tours.properties.seatsFull'),
        ];

        $self = self::from($value);

        return $enumLabel[$self->value];
    }

    public static function toArray(): array
    {
        return array_map(function (self $val) {
            return $val->value;
        }, self::cases());
    }

    public static function classToArray(): array
    {
        return [
            '0' => 'bg-red-100 text-red-600 dark:bg-red-400 dark:text-red-900',
            '1' => 'bg-green-100 text-green-600 dark:bg-green-500 dark:text-green-900',
            '2' => 'bg-yellow-100 text-yellow-600 dark:bg-yellow-300 dark:text-yellow-800',
            '3' => 'bg-blue-100 text-blue-600 dark:bg-blue-600 dark:text-blue-900',
            '4' => 'bg-red-100 text-red-600 dark:bg-red-400 dark:text-red-900',
        ];
    }
}
