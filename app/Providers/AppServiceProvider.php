<?php

namespace App\Providers;

use App;
use Illuminate\Database\QueryException;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Route;
use URL;

class AppServiceProvider extends ServiceProvider
{
   /**
    * Register any application services.
    *
    * @return void
    */
   public function register()
   {
      //
   }

   /**
    * Bootstrap any application services.
    *
    * @return void
    */
   public function boot()
   {
      if (App::isProduction()) {
         URL::forceScheme('https');
      }

      try {
         config(['app.name' => nova_get_setting('site_name', config('app.name'))]);

         $this->handleMailSetting();

         Route::matched(function (RouteMatched $matched) {
            $this->handleMenu($matched);
         });
      } catch (QueryException $exception) {

      }
   }

   private function handleMenu(RouteMatched $matched)
   {
      $menu = collect([
         [
            'title' => 'Trang chủ',
            'href' => url('/')
         ],
         [
            'title' => 'Chính sách',
            'href' => Route::has('page.policy') ? route('page.policy') : url('/')
         ],
         [
            'title' => 'Tin tức',
            'href' => Route::has('news') ? route('news') : url('/')
         ],
         [
            'title' => 'Liên hệ - góp ý',
            'href' => Route::has('page.policy') ? route('page.contact') : url('/')
         ],
      ]);
      View::share('globalMainMenu', $menu->map(fn($item) => array_merge($item, [
         'active' => $item['href'] === $matched->request->fullUrl()
      ]))->toArray());
   }

   private function handleMailSetting()
   {
      config([
         'mail.default' => 'smtp',
         'mail.mailers.smtp.host' => nova_get_setting('smtp_host', config('mail.mailers.smtp.host')),
         'mail.mailers.smtp.port' => nova_get_setting('smtp_port', config('mail.mailers.smtp.port')),
         'mail.mailers.smtp.username' => nova_get_setting('smtp_username', config('mail.mailers.smtp.username')),
         'mail.mailers.smtp.password' => nova_get_setting('smtp_password', config('mail.mailers.smtp.password')),
         'mail.mailers.smtp.encryption' => nova_get_setting('smtp_encryption', config('mail.mailers.smtp.encryption')),
         'mail.from.name' => nova_get_setting('smtp_from_name', config('mail.from.name')),
         'mail.from.address' => nova_get_setting('smtp_from_address', config('mail.from.address')),
      ]);
   }
}
