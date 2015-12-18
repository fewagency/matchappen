@extends('layouts.master')

@section('content')

  <h1>{{ $workplace->name }}</h1>

  @include('workplace.partials.edit_form')

@endsection