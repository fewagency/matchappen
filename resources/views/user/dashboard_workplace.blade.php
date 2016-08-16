@extends('layouts.master', ['use_master_container' => true])

@section('content')

  <h1>Din {{ trans_choice('workplace.workplace', 1) }}: {{ $workplace->name }}</h1>

  <p>Publicerad: {{ $workplace->isPublished() ? 'Ja' : 'Nej' }}</p>

  <p>
    <a href="{{ action('WorkplaceController@show', $workplace) }}">
      Hur ser {{ $workplace->name }} ut för andra besökare?
    </a>
  </p>
  <p>
    @include('workplace.partials.admin_edit_link')
  </p>

  @include('workplace.partials.card')

  <h2>Aktuella {{ trans_choice('opportunity.opportunity',2) }}</h2>
  {{-- @include('opportunity.partials.list', ['opportunities' => $workplace->upcomingOpportunities]) --}}
  <ul class="mega-nav-item__sub-items">
    @foreach($workplace->upcomingOpportunities as $upcoming_opportunity)

      @include('partials.mega-nav-item-sub-item', [
        'sub_item' => $upcoming_opportunity
      ])

    @endforeach
  </ul>
  <a href="{{ action('OpportunityController@create') }}">Skapa {{ trans_choice('opportunity.opportunity', 1) }}
    hos {{ $workplace->name }}</a>

@endsection