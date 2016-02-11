@extends('layouts.master')

@section('content')

  <h1>{{ $workplace->name }}</h1>

  <p>Publicerad: {{ $workplace->isPublished() ? 'Ja' : 'Nej' }}</p>

  @include('workplace.partials.card')

  {{-- @include('opportunity.partials.list', ['opportunities' => $workplace->upcomingOpportunities]) --}}

  @foreach($workplace->upcomingOpportunities as $upcoming_opportunity)

    @include('partials.mega-nav-item-sub-item', [
      'sub_item' => $upcoming_opportunity
    ])

  @endforeach

  <a href="{{ action('WorkplaceController@show', $workplace) }}">
    Hur ser din {{ trans_choice('workplace.workplace', 1) }} ut för andra besökare?
  </a>

  <a href="{{ action('OpportunityController@create') }}">Skapa {{ trans_choice('opportunity.opportunity', 1) }}</a>

  @include('workplace.partials.admin_edit_link')

@endsection