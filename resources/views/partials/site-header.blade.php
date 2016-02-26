<div class="site-top-bar">
  <div></div><div></div><div></div>
</div>

<div class="site-header">

  <div class="container">

    <div class="row">

      <div class="col-xs-12">

        <a href="/" class="site-header__app-name"><span>{{ trans('general.appname') }}</span></a>

        <a href="http://malmo.se" target="_blank" class="site-header__client-link"><div>Malmö stad</div></a>

      </div>

    </div>

  </div>

  @if(!Request::is('/'))
    @include('partials.main-nav')
  @endif

</div>