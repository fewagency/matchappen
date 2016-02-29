@extends('layouts.master', ['use_master_container' => true])

@section('content')
  @include('auth.partials.login_form')

  <a href="{{ action('Auth\AuthController@getRegister') }}">Registrera din {{ trans_choice('workplace.workplace', 1) }}!</a>

  <a href="{{ action('Auth\PasswordController@getEmail') }}">Glömt lösenordet?</a>

  <a href="{{ action('Auth\EmailTokenController@getEmail') }}">Logga in som {{ trans_choice('general.student', 1) }} eller {{ trans('general.edu-staff') }}!</a>
@endsection