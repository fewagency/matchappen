@extends('layouts.master', ['use_master_container' => true])

@section('content')
  @include('partials.status')

  <h1>{{ $workplace->name }}</h1>

  @include('workplace.partials.approve')

  @include('workplace.partials.edit_form')

@endsection