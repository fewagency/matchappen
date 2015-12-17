@extends('layouts.master')

@section('content')
  @include('auth.partials.registration_form')

  <a href="{{ action('Auth\AuthController@getLogin') }}">Har du ett konto?</a>
@endsection