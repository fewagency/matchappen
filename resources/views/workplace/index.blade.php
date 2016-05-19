@extends('layouts.master', [
  'body_class' => 'list-view'
])

@section('content')

  @include('workplace.partials.list', [
    'intro_type' => 2
  ])

@endsection