@extends('layouts.master')

@section('content')

  @include('workplace.partials.list', [
    'hide_intro' => true
  ])

@endsection