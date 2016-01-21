<nav>
  <a href="/">Index</a>

  @if(\Auth::user())
    - <a href="/hem">Dashboard</a>
  @endif
</nav>