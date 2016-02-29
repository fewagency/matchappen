@extends('layouts.master'. ['use_master_container' => true])
@inject('token_guard', 'Matchappen\Services\EmailTokenGuard')

@section('content')
  <h1>
    {{ $booking->checkVisitorEmail($token_guard->email()) ? 'Du' : $booking->name }}
    har bokat {{ $opportunity->name }}
  </h1>
  <p>Längd: {{ $opportunity->minutes }} minuter</p>

  @if($token_guard->checkSupervisor())
    @if($booking->isGroup())
      <p>Antal deltagare: {{ $booking->visitors }}</p>
    @elseif($booking->email)
      <p>
        Besökare: <a href="mailto:{{ $booking->email }}">{{ $booking->email }}</a>
      </p>
    @endif

  @endif

  @if($opportunity->description)
    <p>Beskrivning: {{ $opportunity->description }}</p>
  @endif

  <address>
    Address för besöket:<br>
    {!! nl2br(e($opportunity->display_address)) !!}
  </address>

  <p>
    Kontakta {{ $opportunity->workplace->name }}:
    {{ $opportunity->display_contact_name }}, {{ $opportunity->display_contact_phone }}
  </p>

  <p>Ansvarig {{ trans('general.edu-staff') }}:
    <a href="mailto:{{ $booking->supervisor_email }}">{{ $booking->supervisor_email }}</a>
  </p>

  @include('booking.partials.cancel_form')

  @include('workplace.partials.card', ['workplace' => $opportunity->workplace])
@endsection