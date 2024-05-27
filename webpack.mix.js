const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
   .vue() // Enable Vue support
   .sass('resources/sass/app.scss', 'public/css')
   .postCss('resources/css/app.css', 'public/css', [
       require('postcss-import'),
   ]);

if (mix.inProduction()) {
    mix.version();
}
