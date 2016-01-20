@extends('layouts.master')

@inject('token_guard', 'Matchappen\Services\EmailTokenGuard')

@section('content')
  <h1>{{ $opportunity->name }}</h1>
  @if($token_guard->checkSupervisor())
      <!-- TODO: show booking for for supervisor -->
  @else
    @include('opportunity.partials.booking_form')

    <a href="{{ action('Auth\EmailTokenController@getEmail') }}">Vill du boka som skolpersonal?</a>
  @endif

@endsection