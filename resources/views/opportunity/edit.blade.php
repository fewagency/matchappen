@extends('layouts.master')

@section('content')

  <h1>Redigera {{ $opportunity->name }}</h1>

  @include('opportunity.partials.edit_form')

@endsection