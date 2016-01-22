@extends('layouts.master')

@section('content')
  @if(session('status'))
    @include('partials.status')
  @else
    @include('auth.partials.password_form')

    <a href="{{ action('Auth\AuthController@getLogin') }}">Minns du lösenordet?</a>
  @endif
@endsection