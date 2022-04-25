<?php

namespace App\Nova\Actions\Tours;

use App\Enums\TourStatusEnum;
use App\Models\Tour;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\NovaRequest;

class TourPropertiesStatusAction extends Action
{
    use InteractsWithQueue, Queueable;

    public function name(): string
    {
        return __('Update status');
    }

    /**
     * Perform the action on the given models.
     *
     * @param ActionFields $fields
     * @param Collection $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $models->map(function (Model $tour) use ($fields) {
            $tour->updateOrFail([
                'status' => TourStatusEnum::from($fields->get('status', TourStatusEnum::Seats))
            ]);
        });
    }

    /**
     * Get the fields available on the action.
     *
     * @param NovaRequest $request
     * @return array
     */
    public function fields(NovaRequest $request): array
    {
        return [
            Select::make('Status')->options(fn() => collect(TourStatusEnum::cases())->keyBy('value')->map(fn($val) => TourStatusEnum::label($val->value)))
        ];
    }
}
