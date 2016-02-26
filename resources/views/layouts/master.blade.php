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
  <link rel="stylesheet" href="{{ elixir('css/app.css') }}">
  <script src="{{ asset('/build/js/modernizr.js') }}"></script> {{-- Lets put modernizr here since some CSS relies heavily on it --}}
  <script src="https://use.typekit.net/kjy7xgd.js"></script>
  <script>
    try{Typekit.load({ async: true });}catch(e){};
    document.getElementsByTagName('HTML')[0].classList.add('js');
    document.documentElement.className += ' wf-loading';
  </script>
</head>
<body class="loading {{ $body_class or '' }}">

@include('partials.site-header')
@include('partials.warning')

@yield('content')


{{-- @include('partials.loading-indicator') --}}

<script src='{{ elixir('js/all.js') }}'></script>
</body>
</html>