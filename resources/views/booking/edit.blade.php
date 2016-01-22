@extends('layouts.master')

@section('content')
  <h1>Bokning: {{ $opportunity->name }}</h1>

  <p>Längd: {{ $opportunity->minutes }} minuter</p>

  @if($opportunity->description)
    <p>Beskrivning: {{ $opportunity->description }}</p>
  @endif

  <address>{{ $opportunity->display_address }}</address>
  <p>Kontaktperson: {{ $opportunity->display_contact_name }}</p>
  <p>Telefon: {{ $opportunity->display_contact_phone }}</p>

  <!-- TODO: show details about booking -->

  @include('booking.partials.cancel_form')

  @include('workplace.partials.card', ['workplace' => $opportunity->workplace])
@endsection