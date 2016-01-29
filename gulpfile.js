var elixir = require('laravel-elixir');

require('laravel-elixir-imagemin');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function (mix) {

  mix.sass('app.scss');

  mix.scripts([
    '../../../bower_components/jquery/dist/jquery.min.js',
    'vendor/modernizr.js',
    'vendor/paperfold.js',
    'MegaNav.js',
    'FewPaperfold.js',
    'app.js'
  ]);

  mix.version([
    'css/app.css',
    'js/all.js'
  ]);

  mix.imagemin();

  mix.copy('resources/assets/images', 'public/images');

});
