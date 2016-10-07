# Matchappen för Malmö stad
Built on the [Laravel](http://laravel.com/5.1/docs) 5.1 framework for Long Term Support (LTS).

## Development installation
1. Clone the git-repository into a directory of your choice - preferable in your [Homestead virtual machine](http://laravel.com/docs/homestead).
2. In the project directory, run `composer create-project` to create a default `.env` file.
3. Set up the site and database to be served by a webserver - preferable in your [Homestead.yaml file](http://laravel.com/docs/5.1/homestead#configuring-homestead).
4. Put database credentials in `.env` and run `php artisan migrate` in the project directory to create the tables.

[Configure PhpStorm](https://github.com/fewagency/best-practices/blob/master/Configure%20PhpStorm%20for%20Laravel%20project.md) if relevant.

### Building assets
We're using [Laravel's Elixir](http://laravel.com/docs/elixir) for assets, so run `npm install` in the project root
and then `gulp` or `gulp watch` will build the assets during development.

## App structure
The base PHP namespace is `Matchappen`.

[Controllers](https://laravel.com/docs/controllers) are found in [app/Http/Controllers](app/Http/Controllers) and the
routes to them in [app/Http/routes.php](app/Http/routes.php).
Route-Model binding is configured in [app/Providers/RouteServiceProvider.php](app/Providers/RouteServiceProvider.php).

### Models
Models are placed directly in the [app] directory.

[Workplace](app/Workplace.php) represents companies/organisations that students can get in contact with.

[Opportunity](app/Opportunity.php) represents meetings offered by a `Workplace`.

[Booking](app/Booking.php) represents a booking on an `Opportunity`.
Each `Booking` has a number of `visitors` which is 1 if made by a student, and may be >1 if made by a supervisor.
If a `Booking` has `reserved_until` time set, it should be soft-deleted after that time passes.

[Occupation](app/Occupation.php) represents occupations that are related to `Workplace` and `Opportunity`.

[User](app/User.php) represents `Workplace` users as well as system wide admins (identified by `is_admin`).

Admin users can be created directly in the database table `users`,
or through `php artisan tinker` with

```php
$admin = Matchappen\User::create(['email'=>'testadmin@malmo.se', 'name' => 'admin', 'is_admin' => 1]);
$admin->is_admin = 1;
$admin->save();
```

After the user record is saved, the user can set their desired password
by entering their email address through the password reset url.

### Authentication and Authorization
Workplace users and system admins are standard [Laravel users](https://laravel.com/docs/authentication),
each an instance of the `User` model.
These users log in and out using the standard Laravel [AuthController](app/Http/Controllers/Auth/AuthController.php)
and reset their passwords through the [PasswordController](app/Http/Controllers/Auth/PasswordController.php)

Students as well as their supervisors (teachers, vocational guidance counselors _SYV_, and other school personnel)
log in when necessary using their email address and and an [AccessToken](app/AccessToken.php) instance.
The [Matchappen\Services\EmailTokenGuard](app/Services/EmailTokenGuard.php) keeps track of the current login status and
privileges for these token-users.

Authorization policies for models are defined in [app/Policies](app/Policies), registered in
(app/Providers/AuthServiceProvider.php)[app/Providers/AuthServiceProvider.php]
and can be checked throughout controllers, blade-views, etc using the
[standard Laravel ways](https://laravel.com/docs/authorization#checking-policies).


### Email
The site accepts student and supervisor email patterns that are defined in [config/school.php](config/school.php).
The validation messages related to those email patterns can be edited in
[validation.php](resources/lang/sv/validation.php)
under `custom.student_email.regexp`, `custom.supervisor_email.regexp`, and `custom.edu_email.regexp`.

Outgoing email is configured in `.env`, see [.env.example](.env.example).
Set `MAIL_DRIVER=log` to log emails instead of sending them from your development environment.

#### Rejected emails
Depending on the email server configuration, make sure to catch bounced or rejected outgoing emails.
Any outgoing email that didn't reach its intended receiver should raise the
[EmailWasRejected](app/Events/EmailWasRejected.php) event.
This can be done from [within the app](https://laravel.com/docs/5.1/events#firing-events)
or from the outside through the 'php artisan bookings:handle-email-rejection' command.

#### Queue driver
Install and set up a [queue driver like Redis](https://laravel.com/docs/5.1/queues),
and [run it](https://laravel.com/docs/5.1/queues#running-the-queue-listener) to make mail sending asynchronous.

Remember to set the `QUEUE_DRIVER` in `.env`. 

### Scheduler
Remember to configure the [Laravel scheduler](https://laravel.com/docs/5.1/scheduling)
on the server to periodically run the jobs that are scheduled in
[app/Console/Kernel.php](app/Console/Kernel.php).

## Authors
Matchappen was conceived within
(11:11 Meet Malmö)[http://malmo.se/Foretagande--jobb/Driva--utveckla-foretag/Meet-Malmo.html]
and originally designed and built by [FEW](http://fewagency.se) for Malmö Stad.

## License
The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)

Matchappen's code is released as open source in accordance with
[the Malmö Stad Web Application Guidelines](http://malmostad.github.io/wag-v4/#source-code-license-and-management). 
