<?php

namespace App\Nova\Metrics\Tours\Status;

use App\Enums\TourStatusEnum;
use App\Models\Tour\TourProperties;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;
use Laravel\Nova\Metrics\ValueResult;

class CompleteMetrics extends Value
{
    /**
     * Calculate the value of the metric.
     *
     * @param NovaRequest $request
     * @return ValueResult
     */
    public function calculate(NovaRequest $request): ValueResult
    {
        return $this->result(TourProperties::whereStatus(TourStatusEnum::Complete)->count());
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey(): string
    {
        return 'tour-status-completed-metrics';
    }

    public function name(): string
    {
        return __('Tour completed count');
    }
}
