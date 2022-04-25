<?php

namespace App\Nova;

use App\Models\Post;
use Emilianotisato\NovaTinyMCE\NovaTinyMCE;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Panel;

class PostResource extends Resource
{
   public static string $model = Post::class;

   public static $title = 'title';

   public static $search = [
      'id', 'title', 'slug'
   ];

   public static function label(): string
   {
      return __('Posts');
   }

   public static function uriKey(): string
   {
      return 'posts';
   }

   public function fields(Request $request): array
   {
      return [
         ID::make()->sortable(),

         Text::make('Title')
            ->sortable()
            ->rules('required'),

         Slug::make('Slug')
            ->from('Title')
            ->rules('required')
            ->creationRules('unique:posts,slug')
            ->updateRules('unique:posts,slug,{{resourceId}}'),

         Textarea::make('Short Description')->nullable(),
         NovaTinyMCE::make('Content')->onlyOnForms()->nullable(),

         Image::make('Feature Image')->rules('nullable'),

         Date::make('Created At')->hideWhenCreating()->hideWhenUpdating(),

         new Panel('SEO', [
            Text::make('Seo Title')->hideFromIndex()->nullable(),
            Textarea::make('Seo Description')->hideFromIndex()->nullable(),
            Image::make('Seo Image')->hideFromIndex()->nullable(),
         ])
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
