@extends('layouts.master')

@section('content')
  <p>Vi har skickat epost till dig med instruktioner för att slutföra bokningen!</p>
  <p>Din bokning är reserverad fram till {{ $booking->reserved_until }}.</p>

  <!-- TODO: remove this token link from template! This is just for testing! -->
  <a href="{{ $booking->accessTokens->last()->getTokenUrl() }}">Test the emailed token link</a>
@endsection