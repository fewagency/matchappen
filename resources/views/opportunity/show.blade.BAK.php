@extends('layouts.master')

@section('content')

  <section class="page-intro">
    <div class="container">
      <div class="row">
        <div class="col-xs-12">

          <h1>{{ $opportunity->name }}</h1>

          @include('opportunity.partials.booking_link')

          @include('opportunity.partials.admin_edit_link')

          @if($opportunity->description)
            <p>Beskrivning: {{ $opportunity->description }}</p>
          @endif

          <p>Längd: {{ $opportunity->minutes }} minuter</p>

          <address>{!! nl2br(e($opportunity->display_address)) !!}</address>
          <p>Kontaktperson: {{ $opportunity->display_contact_name }}</p>
          <p>Telefon: {{ $opportunity->display_contact_phone }}</p>
          <p>Sista anmälan: {{ $opportunity->registration_end->format('j/n') }}</p>
          <p>Platser kvar: {{ $opportunity->placesLeft() }}/{{ $opportunity->max_visitors }}</p>

        </div>
      </div>
    </div>
  </section>

  @include('occupation.partials.list', ['occupations' => $opportunity->occupations ])

@endsection