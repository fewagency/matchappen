@inject('token_guard', 'Matchappen\Services\EmailTokenGuard')
@if($user = Auth::user())
  <a href="{{ action('Auth\AuthController@getLogout') }}">Logga ut {{ $user->email }}</a>
@elseif($token_email = $token_guard->email())
  <a href="{{ action('Auth\EmailTokenController@getLogout') }}">Logga ut {{ $token_email }}</a>
@else
  <a href="{{ action('Auth\AuthController@getLogin') }}">Logga in!</a>
@endif