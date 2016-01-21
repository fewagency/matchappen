@extends('layouts.master')

@section('content')
  @if(session('status'))
    {{ session('status') }}
    <!-- TODO: remove this token link from template! This is just for testing! -->
    <a href="{{ \Matchappen\AccessToken::orderBy('created_at', 'desc')->first()->getTokenUrl() }}">Test the emailed token link</a>
  @else
    <h1>Logga in som {{ trans('general.edu-staff') }}</h1>
    @include('auth.partials.token_email_form')

    <a href="{{ action('Auth\AuthController@getLogin') }}">Vill du logga in som {{ trans_choice('workplace.workplace', 1) }} istället?</a>
  @endif
@endsection