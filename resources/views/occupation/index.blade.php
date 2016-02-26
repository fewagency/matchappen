@extends('layouts.master')

@section('content')

  @include('occupation.partials.list', [
    'hide_intro' => true
  ])

@endsection