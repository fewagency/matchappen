@extends('layouts.master')

@section('content')

  <h1>{{ $workplace->name }}</h1>

  @if($workplace->description)
    <p>{{ $workplace->description }}</p>
  @endif

  @if($workplace->homepage)
    <a href="{{ $workplace->homepage }}">{{ $workplace->homepage }}</a>
  @endif

  <p>Anställda: {{ $workplace->employees }}</p>

  <p>Kontaktperson: {{ $workplace->display_contact_name }}</p>

  <a href="mailto:{{ $workplace->display_email }}">{{ $workplace->display_email }}</a>

  <p>Tel: {{ $workplace->display_phone }}</p>

  <address>{{ $workplace->address }}</address>

  @include('workplace.partials.admin_edit_link')

@endsection