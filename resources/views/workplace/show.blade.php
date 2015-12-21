@extends('layouts.master')

@section('content')

  <h1>{{ $workplace->name }}</h1>

  <p>{{ $workplace->description }}</p>

  <p>Kontaktperson: {{ $workplace->display_contact_name }}</p>

  @include('workplace.partials.admin_edit_link')

@endsection