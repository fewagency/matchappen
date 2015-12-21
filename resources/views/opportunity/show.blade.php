@extends('layouts.master')

@section('content')

  <h1>{{ $opportunity->name }}</h1>
  <p>Beskrivning: {{ $opportunity->description }}</p>
  <p>Längd: {{ $opportunity->minutes }} minuter</p>
  <address>{{ $opportunity->display_address }}</address>
  <p>Kontaktperson: {{ $opportunity->display_contact_name }}</p>
  <p>Telefon: {{ $opportunity->display_contact_phone }}</p>
  <p>Sista anmälan: {{ $opportunity->registration_end->format('j/n') }}</p>

  @include('workplace.partials.card', ['workplace' => $opportunity->workplace])

  @include('opportunity.partials.admin_edit_link')

@endsection