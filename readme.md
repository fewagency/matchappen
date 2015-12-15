# Matchappen för Malmö stad
Built on the [Laravel](http://laravel.com/docs) 5 framework.

## Development installation
1. Clone the git-repository into a directory of your choice - preferable in your [Homestead virtual machine](http://laravel.com/docs/homestead).
2. In the project directory, run `composer create-project` to create a default `.env` file.
3. Set up the site to be served by a webserver - preferable in your [Homestead.yaml file](http://laravel.com/docs/5.1/homestead#configuring-homestead).

[Configure PhpStorm](https://github.com/fewagency/best-practices/blob/master/Configure%20PhpStorm%20for%20Laravel%20project.md) if relevant.

### Building assets
We're using [Laravel's Elixir](http://laravel.com/docs/elixir) for assets, so run `npm install` in the project root and then `gulo` or `gulp watch` will build the assets during development.

## License
The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)