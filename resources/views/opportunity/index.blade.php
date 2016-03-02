@extends('layouts.master')

@section('content')

  @include('opportunity.partials.list', [
    'intro_type' => 2
  ])

@endsection