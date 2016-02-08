@inject('token_guard', 'Matchappen\Services\EmailTokenGuard')

<div class="site-top-bar">
  <div></div><div></div><div></div>
</div>

<div class="site-header">

  <div class="container">

    <div class="row">

      <div class="col-xs-12">

        <a href="/" class="site-header__app-name">{{ trans('general.appname') }}</a>

        <a href="http://malmo.se" target="_blank" class="site-header__client-link"><div>Malmö stad</div></a>

      </div>

    </div>

  </div>

</div>

@include('partials.main-nav')