<?php

namespace Laravel\Nova\Fields;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Laravel\Nova\Contracts\ListableField;
use Laravel\Nova\Contracts\RelatableField;
use Laravel\Nova\Contracts\Resolvable;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\ResourceToolElement;

/**
 * @template TKey of int
 * @template TValue of \Laravel\Nova\Fields\FieldElement|\Laravel\Nova\Fields\Field
 */
class FieldCollection extends Collection
{
    /**
     * Assign the fields with the given panels to their parent panel.
     *
     * @param  string  $label
     * @return static<TKey, \Laravel\Nova\Fields\Field>
     */
    public function assignDefaultPanel($label)
    {
        return $this->map(function ($field) use ($label) {
            if (! $field->panel) {
                $field->panel = $label;
            }

            return $field;
        });
    }

    /**
     * Find a given field by its attribute.
     *
     * @template TGetDefault
     *
     * @param  string  $attribute
     * @param  TGetDefault|\Closure():TGetDefault  $default
     * @return \Laravel\Nova\Fields\Field|TGetDefault
     */
    public function findFieldByAttribute($attribute, $default = null)
    {
        return $this->first(function ($field) use ($attribute) {
            return isset($field->attribute) &&
                $field->attribute == $attribute;
        }, $default);
    }

    /**
     * Filter elements should be displayed for the given request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return static<int, \Laravel\Nova\Fields\Field>
     */
    public function authorized(Request $request)
    {
        return $this->filter(function ($field) use ($request) {
            return $field->authorize($request);
        })->values();
    }

    /**
     * Filter elements should be displayed for the given request.
     *
     * @param  mixed  $resource
     * @return static<int, \Laravel\Nova\Fields\Field>
     */
    public function resolve($resource)
    {
        return $this->each(function ($field) use ($resource) {
            if ($field instanceof Resolvable) {
                $field->resolve($resource);
            }
        });
    }

    /**
     * Resolve value of fields for display.
     *
     * @param  mixed  $resource
     * @return static<int, \Laravel\Nova\Fields\Field>
     */
    public function resolveForDisplay($resource)
    {
        return $this->each(function ($field) use ($resource) {
            if ($field instanceof ListableField || ! $field instanceof Resolvable) {
                return;
            }

            if ($field->pivot) {
                $field->resolveForDisplay($resource->{$field->pivotAccessor} ?? new Pivot);
            } else {
                $field->resolveForDisplay($resource);
            }
        });
    }

    /**
     * Filter fields for showing on detail.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  mixed  $resource
     * @return static<int, \Laravel\Nova\Fields\Field>
     */
    public function filterForDetail(NovaRequest $request, $resource)
    {
        return $this->filter(function ($field) use ($resource, $request) {
            return $field->isShownOnDetail($request, $resource);
        })->values();
    }

    /**
     * Filter fields for showing on preview.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  mixed  $resource
     * @return static<int, \Laravel\Nova\Fields\Field>
     */
    public function filterForPreview(NovaRequest $request, $resource)
    {
        return $this->filter(function ($field) use ($resource, $request) {
            return $field->isShownOnPreview($request, $resource);
        })->values();
    }

    /**
     * Filter fields for showing on index.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  mixed  $resource
     * @return static<int, \Laravel\Nova\Fields\Field>
     */
    public function filterForIndex(NovaRequest $request, $resource)
    {
        return $this->filter(function ($field) use ($resource, $request) {
            return $field->isShownOnIndex($request, $resource);
        })->values();
    }

    /**
     * Reject if the field is readonly.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return static<int, \Laravel\Nova\Fields\Field>
     */
    public function withoutReadonly(NovaRequest $request)
    {
        return $this->reject(function ($field) use ($request) {
            return $field->isReadonly($request);
        });
    }

    /**
     * Reject fields which use their own index listings.
     *
     * @return static<int, \Laravel\Nova\Fields\Field>
     */
    public function withoutListableFields()
    {
        return $this->reject(function ($field) {
            return $field instanceof ListableField;
        });
    }

    /**
     * Reject fields which are actually ResourceTools.
     *
     * @return static<int, \Laravel\Nova\Fields\Field>
     */
    public function withoutResourceTools()
    {
        return $this->reject(function ($field) {
            return $field instanceof ResourceToolElement;
        });
    }

    /**
     * Filter the fields to only many-to-many relationships.
     *
     * @return static<int, \Laravel\Nova\Fields\MorphToMany|\Laravel\Nova\Fields\BelongsToMany>
     */
    public function filterForManyToManyRelations()
    {
        return $this->filter(function ($field) {
            return $field instanceof BelongsToMany || $field instanceof MorphToMany;
        });
    }

    /**
     * Apply depends on for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return $this
     */
    public function applyDependsOn(NovaRequest $request)
    {
        $payloads = $this->mapWithKeys(function ($field) {
            $key = $field instanceof RelatableField ? $field->resourceName : $field->attribute;

            return [$key => $field->value];
        })->all();

        $this->each->applyDependsOn(
            NovaRequest::createFrom($request)->merge($payloads)
        );

        return $this;
    }
}
