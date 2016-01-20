<form method="POST" action="{{ action('Auth\EmailTokenController@postLogin', $token) }}">
  {!! csrf_field() !!}

  @if (count($errors) > 0)
    <ul>
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  @endif

  <div>
    Email
    <input type="email" name="email" value="{{ old('email', $email) }}">
  </div>

  <div>
    <button type="submit">Login</button>
  </div>
</form>