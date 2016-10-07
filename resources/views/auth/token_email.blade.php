@extends('layouts.master', ['use_master_container' => true])

@section('content')
  @include('partials.status')
  @if(session('status'))
  @else
    <h1>Logga in som {{ trans_choice('general.student', 1) }} eller {{ trans('general.edu-staff') }}</h1>
    @include('auth.partials.token_email_form')

    <a href="{{ action('Auth\AuthController@getLogin') }}">
      Vill du logga in som {{ trans_choice('workplace.workplace', 1) }} istället?
    </a>
  @endif
@endsection