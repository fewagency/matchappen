@extends('layouts.master')

@section('content')

  <h1>{{ $workplace->name }}</h1>

  @include('workplace.partials.card')

  @include('opportunity.partials.list', ['opportunities' => $workplace->upcomingOpportunities])

  <a href="{{ action('WorkplaceController@show', $workplace) }}">Hur ser din arbetsplats ut för andra?</a>

  <a href="{{ action('OpportunityController@create') }}">Skapa {{ trans('general.opportunity') }}</a>

  @include('workplace.partials.admin_edit_link')

@endsection