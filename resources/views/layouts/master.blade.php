<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
<head>
  <meta charset="utf-8">

  <meta content='width=device-width, initial-scale=1.0' name='viewport'/>
  <title>{{ $title or trans('general.appname') }} – Malmö stad</title>
  <!--[if IE]><meta content='IE=edge' http-equiv='X-UA-Compatible'/><![endif]-->
  {{-- <!--[if lte IE 8]><script src='//assets.malmo.se/external/v4/html5shiv-printshiv.js' type='text/javascript'></script><![endif]--> --}}
  {{-- <link href='//assets.malmo.se/external/v4/malmo.css' media='all' rel='stylesheet' type='text/css'/> --}}
  <link rel="stylesheet" href="{{ elixir('css/app.css') }}">
  {{-- <!--[if lte IE 8]><link href='//assets.malmo.se/external/v4/legacy/ie8.css' media='all' rel='stylesheet' type='text/css'/><![endif]--> --}}
  {{-- <noscript><link href="//assets.malmo.se/external/v4/icons.fallback.css" rel="stylesheet"></noscript> --}}
  {{-- <link rel='icon' type='image/x-icon' href='//assets.malmo.se/external/v4/favicon.ico'/> --}}
  <script src="https://use.typekit.net/kjy7xgd.js"></script>
  <script>try{Typekit.load({ async: true });}catch(e){}</script>

</head>
<body class="mf-v4 {{ $body_class or '' }}">

@include('partials.nav')
@include('partials.warning')
  <div class="main">
  @include('partials.nav')
  </div>

@yield('content')


  @include('partials.mega-nav-item', [
    'itemModifier' => 'companies',
    'headline' => 'Spännande företag',
    'introText' => 'Läs om lorem ipsum dolor sit amet',
    'sub_items' => [
        [
          'headline' => 'AD Headline',
          'text' => 'AD Text',
          'href' => '#adhref'
        ],
[
          'headline' => 'AD Headline 2',
          'text' => 'AD Text 2',
          'href' => '#adhref'
        ]
      ]
    ])





</div>

{{-- <script src='//assets.malmo.se/external/v4/malmo.js'></script> --}}
<script src='{{ elixir('js/all.js') }}'></script>
<!--<script src='/your_own_javascript.js'></script>-->
</body>
</html>