@extends('layouts.master')

@section('content')
  @include('auth.partials.login_form')

  <a href="{{ action('Auth\AuthController@getRegister') }}">Registrera din arbetsplats!</a>

  <a href="{{ action('Auth\PasswordController@getEmail') }}">Glömt lösenordet?</a>

  <a href="{{ action('Auth\EmailTokenController@getEmail') }}">Logga in som skolpersonal!</a>
@endsection