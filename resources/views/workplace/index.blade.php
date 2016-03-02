@extends('layouts.master')

@section('content')

  @include('workplace.partials.list', [
    'intro_type' => 2
  ])

@endsection