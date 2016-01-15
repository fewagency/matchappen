@extends('layouts.master')

@section('content')
  <p>Vi har skickat epost till dig med instruktioner för att slutföra bokningen!</p>
  <p>Din bokning är reserverad fram till {{ $booking->reserved_until }}.</p>
@endsection