@extends('layouts.master', ['use_master_container' => true])

@section('content')
  <h1>Registrera {{ trans_choice('workplace.workplace', 1) }}</h1>
  <p>Här registrerar du din arbetsplats. Skapa ett konto nedan. Uppgifterna du skriver in blir publika när vår administratör har godkänt kontot.</p>
  @include('auth.partials.registration_form')

  <a href="{{ action('Auth\AuthController@getLogin') }}">Har du ett konto?</a>
@endsection