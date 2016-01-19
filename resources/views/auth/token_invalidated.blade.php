@extends('layouts.master')

@section('content')
  <p>{{ trans('auth.token_invalidated') }}</p>
  <!-- TODO: add possibility to generate a new access token when the old one is invalidated? -->
@endsection