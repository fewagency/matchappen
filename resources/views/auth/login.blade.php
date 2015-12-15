@extends('layouts.master')

@section('content')
  @include('auth.partials.login_form')

  <a href="{{ action('Auth\AuthController@getRegister') }}">Registrera din arbetsplats!</a>
@endsection