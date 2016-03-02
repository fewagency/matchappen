@extends('layouts.master')

@section('content')

  @include('occupation.partials.list', [
    'intro_type' => 2
  ])

@endsection