@extends('layouts.master')

@section('content')

  <h1>{{ trans('general.appname') }}</h1>

  <a href="{{ action('WorkplaceController@index') }}">{{ trans_choice('workplace.workplace', \Matchappen\Workplace::published()->count()) }}</a>

  <a href="{{ action('OpportunityController@index') }}">{{ trans_choice('opportunity.opportunity', \Matchappen\Opportunity::published()->count()) }}</a>

@endsection