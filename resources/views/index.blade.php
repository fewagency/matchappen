@extends('layouts.master')

@section('content')

  <h1>{{ trans('general.appname') }}</h1>

  <a href="{{ action('WorkplaceController@index') }}">{{ trans('general.workplaces') }}</a>

  <!-- TODO: add general project info to the index page -->

  <a href="{{ action('Auth\AuthController@getLogin') }}">Logga in!</a>

  <!-- TODO: add teacher login to the index page -->

@endsection