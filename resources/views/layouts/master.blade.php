<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
<head>
  <meta charset="utf-8">

  <style>

    body {
      background: #000;
    }

    .js body.loading {
      height: 100vh;
      width: 100vw;
      overflow: hidden;
    }

    .js body.loading > * {
      visibility: hidden;
    }

  </style>

  <meta content='width=device-width, initial-scale=1.0' name='viewport'/>
  <title>{{ $title or trans('general.appname') }} – Malmö stad</title>
  <!--[if IE]><meta content='IE=edge' http-equiv='X-UA-Compatible'/><![endif]-->
  <!--[if lte IE 8]><script src='//assets.malmo.se/external/v4/html5shiv-printshiv.js' type='text/javascript'></script><![endif]-->
  <link href='//assets.malmo.se/external/v4/malmo.css' media='all' rel='stylesheet' type='text/css'/>
  <link type="text/css" rel="stylesheet" href="//fast.fonts.net/cssapi/c8d4739f-47f8-40c5-ab92-66d3f33d9d70.css"/>
  <link rel="stylesheet" href="{{ elixir('css/app.css') }}">
  <!--[if lte IE 8]><link href='//assets.malmo.se/external/v4/legacy/ie8.css' media='all' rel='stylesheet' type='text/css'/><![endif]-->
  <noscript><link href="//assets.malmo.se/external/v4/icons.fallback.css" rel="stylesheet"></noscript>
  <script src="{{ asset('/build/js/modernizr.js') }}"></script> {{-- Lets put modernizr here since some CSS relies heavily on it --}}
  <script>
    try{Typekit.load({ async: true });}catch(e){};
    document.getElementsByTagName('HTML')[0].classList.add('js');
    document.documentElement.className += ' wf-loading';
  </script>
</head>
<body class="loading no-footer {{ $body_class or '' }}">

<div class="master-wrapper">
  @include('partials.site-header')

  @include('partials.warning')

  @if(isset($use_master_container) && $use_master_container === true)
    <div class="container container--master">
      <div class="row">
        <div class="col-xs-12">
  @endif

          <div class="master-content-wrapper">
            @yield('content')
          </div>

  @if(isset($use_master_container) && $use_master_container === true)
        </div>
      </div>
    </div>
  @endif

  @include('partials.site-footer')
</div>

{{-- @include('partials.loading-indicator') --}}

@include('partials.cookie-alert')

<script src='//assets.malmo.se/external/v4/malmo.js'></script>
<script src='{{ elixir('js/all.js') }}'></script>
</body>
</html>