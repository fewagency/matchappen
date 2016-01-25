@extends('layouts.master')

@section('content')

  @include('partials.status')

  <h2>Bokningar under ditt ansvar</h2>
  @if($bookings->count())
    <ul>
      @foreach($bookings as $booking)
        <li>
          <a href="{{ action('BookingController@show', $booking) }}">
            {{ $booking->name }} {{ $booking->opportunity->name }}
          </a>
        </li>
      @endforeach
    </ul>
  @else
    <p>
      Du har inga aktuella bokningar under ditt ansvar.
      Om du <a href="{{ action('OpportunityController@index') }}">gör egna {{ trans_choice('booking.booking', 2) }}</a>
      eller om studenter gör {{ trans_choice('booking.booking', 2) }} med dig som referens kommer de visas här.
    </p>
  @endif

  @if($passed_bookings->count())
    <h2>Passerade bokningar</h2>
    <ul>
      @foreach($passed_bookings as $booking)
        <li>
          <a href="{{ action('BookingController@show', $booking) }}">
            {{ $booking->name }} {{ $booking->opportunity->name }}
          </a>
        </li>
      @endforeach
    </ul>
  @endif

@endsection