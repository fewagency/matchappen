<nav>
  <a href="/">Index</a>

  @if(Auth::check())
    <a href="{{ route('dashboard') }}">Dashboard</a>
  @endif

  @include('user.partials.login_info')

</nav>