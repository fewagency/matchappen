@extends('layouts.master', ['use_master_container' => true])

@section('content')
  @include('auth.partials.registration_form')

  <a href="{{ action('Auth\AuthController@getLogin') }}">Har du ett konto?</a>
@endsection