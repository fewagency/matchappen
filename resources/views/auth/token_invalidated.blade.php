@extends('layouts.master')

@section('content')
  <p>{{ trans('auth.token_invalidated') }}</p>
  <a href="{{ action('Auth\EmailTokenController@getEmail') }}">Vill du ha en ny inloggningslänk?</a>
@endsection