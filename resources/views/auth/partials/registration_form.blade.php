<form method="POST" action="{{ action('Auth\AuthController@postRegister') }}">
  {!! csrf_field() !!}

  @if (count($errors) > 0)
    <ul>
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  @endif

  <div>
    Arbetsplats
    <input type="text" name="workplace[name]" value="{{ old('workplace.name') }}">
  </div>

  <div>
    Antal anställda på arbetsplatsen
    <input type="number" name="workplace[employees]" min="1" max="65535" value="{{ old('workplace.employees') }}">
  </div>

  <div>
    Företagets adress
    <textarea name="workplace[address]">{{ old('workplace.address') }}</textarea>
  </div>

  <div>
    Ditt namn
    <input type="text" name="user[name]" value="{{ old('user.name') }}">
  </div>

  <div>
    Din epostadress
    <input type="email" name="user[email]" value="{{ old('user.email') }}">
  </div>

  <div>
    Ditt telefonnummer
    <input type="text" name="user[phone]" value="{{ old('user.phone') }}">
  </div>

  <div>
    Önskat lösenord
    <input type="password" name="user[password]">
  </div>

  <div>
    Bekräfta lösenord
    <input type="password" name="user[password_confirmation]">
  </div>

  <div>
    <button type="submit">Register</button>
  </div>
</form>