 const { mix } = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css')


.scripts([
      'resources/assets/js/mainjs.min.js',
      'resources/assets/js/metisMenu.min.js',
      'resources/js/grdynav.js',
      'resources/assets/js/perfect-scrollbar.min.js',
  ], 'public/js/all.js')
  
.styles([
      'resources/assets/css/maincss.min.css',
      'resources/assets/css/perfect-scrollbar.css',
   ], 'public/css/all.css')

   .version();
   