<?php

namespace App\Providers;

use Emilianotisato\NovaTinyMCE\NovaTinyMCE;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Laravel\Nova\Fields\Code;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\URL;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use Laravel\Nova\Panel;
use OptimistDigital\NovaSettings\NovaSettings;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
   /**
    * Bootstrap any application services.
    *
    * @return void
    */
   public function boot()
   {
      parent::boot();

      Route::matched(function () {
         NovaSettings::addSettingsFields([
            new Panel('Site', [
               Text::make('Title', 'site_title')->nullable(),
               Text::make('Name', 'site_name')->nullable(),
               Image::make('Logo', 'site_logo')->nullable(),
               Image::make('Favicon', 'site_favicon')->nullable(),
               NovaTinyMCE::make('Footer', 'site_footer')->nullable()
            ]),

            new Panel('SEO', [
               Text::make('Title', 'seo_title')->nullable(),
               Textarea::make('Description', 'seo_description')->nullable(),
               Text::make('Keywords', 'seo_keyword')->nullable(),
               Image::make('Image', 'seo_image')->nullable(),
               Text::make('Facebook App ID', 'seo_facebook_app_id')->nullable(),
            ]),

            new Panel('Contact', [
               Text::make('Company name', 'contact_company_name')->nullable(),
               Text::make('Address', 'contact_address')->nullable(),
               Text::make('Email', 'contact_email')->rules('email')->nullable(),
               Text::make('Phone', 'contact_phone')->rules('min:10', 'max:11')->nullable(),
            ]),

            new Panel('Social', [
               Text::make('Zalo', 'social_zalo')->rules('min:10', 'max:11')->nullable(),
               Image::make('Zalo QR', 'social_zalo_qr')->nullable(),
               URL::make('Facebook', 'social_facebook')->nullable()
            ])
         ]);

         NovaSettings::addSettingsFields([
            new Panel('Policy', [
               NovaTinyMCE::make('Content', 'page_policy_content')->nullable()
            ]),
            new Panel('Contact', [
               Text::make('Mail To', 'page_contact_mail_to')->rules('nullable', 'email')->nullable()
            ])
         ], [], 'Pages');

         NovaSettings::addSettingsFields([
            Text::make('Host', 'smtp_host')->nullable(),
            Number::make('Port', 'smtp_port')->nullable(),
            Text::make('Username', 'smtp_username')->rules('email', 'max:150')->nullable(),
            Text::make('Password', 'smtp_password')->nullable(),
            Select::make('Encryption', 'smtp_encryption')
               ->options([
                  'tls' => 'TLS',
                  'ssl' => 'SSL',
               ])
               ->nullable(),
            Text::make('From Address', 'smtp_from_address')
               ->rules('email', 'max:150')->nullable(),
            Text::make('From Name', 'smtp_from_name')
               ->rules('max:150')->nullable(),
         ], [], 'Mail SMTP');

         NovaSettings::addSettingsFields([
            Code::make('Head', 'custom_head')->language('htmlmixed')->nullable(),
            Code::make('Script', 'custom_script')->language('htmlmixed')->nullable(),
         ], [], 'customize');
      });
   }

   /**
    * Register the Nova routes.
    *
    * @return void
    */
   protected function routes()
   {
      Nova::routes()
         ->withAuthenticationRoutes()
         ->withPasswordResetRoutes()
         ->register();
   }

   /**
    * Register the Nova gate.
    *
    * This gate determines who can access Nova in non-local environments.
    *
    * @return void
    */
   protected function gate()
   {
      Gate::define('viewNova', function ($user) {
         return in_array($user->email, [
            //
         ]);
      });
   }

   /**
    * Get the dashboards that should be listed in the Nova sidebar.
    *
    * @return array
    */
   protected function dashboards()
   {
      return [
         new \App\Nova\Dashboards\Main,
      ];
   }

   /**
    * Get the tools that should be listed in the Nova sidebar.
    *
    * @return array
    */
   public function tools()
   {
      return [
         new NovaSettings,
      ];
   }

   /**
    * Register any application services.
    *
    * @return void
    */
   public function register()
   {
      //
   }
}
