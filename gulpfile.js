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

  mix
    .sass('app.scss')
    .scripts([
      //'vendor/modernizr.js',
      //'../../../bower_components/jquery/dist/jquery.min.js',
      '../../../bower_components/jQuery.dotdotdot/src/js/jquery.dotdotdot.js',
      'vendor/paperfold.js',
      '../../../bower_components/selectize/dist/js/standalone/selectize.min.js',
      'MegaNav.js',
      'FewPaperfold.js',
      'selectize.js',
      'app.js'
    ])
    .version([
      'css/app.css',
      'js/all.js'
    ])
    .imagemin()
    .copy(
      'resources/assets/images', 'public/images'
    )
    .copy(
      'resources/assets/js/vendor/modernizr.js', 'public/build/js/modernizr.js'
    )
    .browserSync({
      proxy: 'matchappen.local'
    });

});
