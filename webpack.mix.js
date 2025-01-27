const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js');
mix.sass('resources/css/app.scss', 'public/css')
   .options({
      postCss: [
         require('tailwindcss'),
      ],
   });

mix.copyDirectory('resources/assets/images', 'public/images');
mix.copyDirectory('resources/assets/fontawesome', 'public/fontawesome');

mix.disableNotifications();
