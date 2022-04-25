<?php

namespace App\Nova\Filters\Tours;

use App\Enums\TourStatusEnum;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Nova\Filters\Filter;
use Laravel\Nova\Http\Requests\NovaRequest;

class TourPropertiesStatusFilter extends Filter
{
    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'select-filter';

    public $name = 'Status';

    /**
     * Apply the filter to the given query.
     *
     * @param NovaRequest $request
     * @param Builder $query
     * @param mixed $value
     * @return Builder
     */
    public function apply(NovaRequest $request, $query, $value): Builder
    {
        return $query->where('status', $value);
    }

    /**
     * Get the filter's available options.
     *
     * @param NovaRequest $request
     * @return array
     */
    public function options(NovaRequest $request): array
    {
        return collect(TourStatusEnum::cases())->map(function ($val) {
            return [
                'name' => TourStatusEnum::label($val->value),
                'value' => $val->value
            ];
        })->keyBy('name')->map(fn($val) => $val['value'])->toArray();
    }
}
