@extends('layouts.master')

@section('content')

  <h1>{{ $opportunity->name }}</h1>
  <p>{{ $opportunity->description }}</p>

  @include('opportunity.partials.admin_edit_link')

@endsection