@extends('layouts.master')

@section('content')

  <h1>{{ trans('general.appname') }}</h1>

  <a href="{{ action('WorkplaceController@index') }}">{{ trans('general.workplaces') }}</a>

  @include('user.partials.login_info')

  <!-- TODO: add teacher login to the index page -->

@endsection