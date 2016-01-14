@extends('layouts.master')

@section('content')
  <h1>{{ $opportunity->name }}</h1>
  @include('opportunity.partials.booking_form')
@endsection