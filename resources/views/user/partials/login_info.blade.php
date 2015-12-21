@if($user = Auth::user())
  <a href="{{ action('Auth\AuthController@getLogout') }}">Logga ut {{ $user->email }}</a>
@else
  <a href="{{ action('Auth\AuthController@getLogin') }}">Logga in!</a>
@endif
