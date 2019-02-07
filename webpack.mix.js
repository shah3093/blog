const mix = require('laravel-mix');

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

mix.js(['resources/js/app.js'
], 'public/frontend/js')
    .styles(['resources/frontend/css/style.css'],'public/frontend/css/all.css')
    .sass('resources/sass/app.scss', 'public/frontend/css').version();
