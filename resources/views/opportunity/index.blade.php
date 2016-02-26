@extends('layouts.master')

@section('content')

  @include('opportunity.partials.list', [
    'hide_intro' => true
  ])

@endsection