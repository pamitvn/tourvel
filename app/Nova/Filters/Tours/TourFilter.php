<?php

namespace App\Nova\Filters\Tours;

use App\Models\Tour;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Nova\Filters\Filter;
use Laravel\Nova\Http\Requests\NovaRequest;

class TourFilter extends Filter
{
    public $name = 'Tour';

    public $component = 'select-filter';

    protected string $field = 'tour_id';

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
        return $query->where($this->field, $value);
    }

    /**
     * Get the filter's available options.
     *
     * @param NovaRequest $request
     * @return array
     */
    public function options(NovaRequest $request): array
    {
        return Tour::all(['id', 'name'])
            ->keyBy('name')
            ->map(fn($val) => $val->id)
            ->toArray();
    }

    public function setField($field): self
    {
        $this->field = $field;

        return $this;
    }
}
