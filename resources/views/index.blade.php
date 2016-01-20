@extends('layouts.master')

@section('content')

  <h1>{{ trans('general.appname') }}</h1>

  <a href="{{ action('WorkplaceController@index') }}">{{ trans('general.workplaces') }}</a>

  <a href="{{ action('OpportunityController@index') }}">{{ trans('general.opportunities') }}</a>

  @include('user.partials.login_info')
@endsection