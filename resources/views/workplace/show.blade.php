@extends('layouts.master')

@section('content')

  <h1>{{ $workplace->name }}</h1>

  @include('workplace.partials.approve')

  @include('workplace.partials.admin_edit_link')

  @if(!$workplace->isPublished() and Gate::allows('publish', $workplace))

  <p>Publicerad: {{ $workplace->isPublished() ? 'Ja' : 'Nej' }}</p>

  @endif

  @if($workplace->description)
    <p>Beskrivning: {{ $workplace->description }}</p>
  @endif

  @if($workplace->homepage)
    <p>Hemsida: <a href="{{ $workplace->homepage }}">{{ $workplace->homepage }}</a></p>
  @endif

  <p>Anställda: {{ $workplace->employees }}</p>
  <p>Kontaktperson: {{ $workplace->display_contact_name }}</p>
  <p>Epost: <a href="mailto:{{ $workplace->display_email }}">{{ $workplace->display_email }}</a></p>
  <p>Telefon: {{ $workplace->display_phone }}</p>
  <address>{{ $workplace->address }}</address>

  @include('opportunity.partials.list', ['opportunities' => $workplace->opportunities])

@endsection