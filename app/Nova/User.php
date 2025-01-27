<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Gravatar;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class User extends Resource
{
   /**
    * The model the resource corresponds to.
    *
    * @var string
    */
   public static string $model = \App\Models\User::class;

   /**
    * The single value that should be used to represent the resource when being displayed.
    *
    * @var string
    */
   public static $title = 'name';

   public static $group = 'User';

   /**
    * The columns that should be searched.
    *
    * @var array
    */
   public static $search = [
      'id', 'name', 'email',
   ];

   public static function label(): string
   {
      return __('Administrators');
   }

   public static function uriKey(): string
   {
      return 'administrators';
   }

   /**
    * Get the fields displayed by the resource.
    *
    * @param NovaRequest $request
    * @return array
    */
   public function fields(NovaRequest $request): array
   {
      return [
         ID::make()->sortable(),

         Gravatar::make()->maxWidth(50),

         Text::make('Name')
            ->sortable()
            ->rules('required', 'max:255'),

         Text::make('Email')
            ->sortable()
            ->rules('required', 'email', 'max:254')
            ->creationRules('unique:users,email')
            ->updateRules('unique:users,email,{{resourceId}}'),

         Password::make('Password')
            ->onlyOnForms()
            ->creationRules('required', Rules\Password::defaults())
            ->updateRules('nullable', Rules\Password::defaults()),

         Date::make('Created At')->hideWhenCreating()->hideWhenUpdating()
      ];
   }

   /**
    * Get the cards available for the request.
    *
    * @param NovaRequest $request
    * @return array
    */
   public function cards(NovaRequest $request)
   {
      return [];
   }

   /**
    * Get the filters available for the resource.
    *
    * @param NovaRequest $request
    * @return array
    */
   public function filters(NovaRequest $request)
   {
      return [];
   }

   /**
    * Get the lenses available for the resource.
    *
    * @param NovaRequest $request
    * @return array
    */
   public function lenses(NovaRequest $request)
   {
      return [];
   }

   /**
    * Get the actions available for the resource.
    *
    * @param NovaRequest $request
    * @return array
    */
   public function actions(NovaRequest $request)
   {
      return [];
   }
}
