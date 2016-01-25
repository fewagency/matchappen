@extends('layouts.master')

@section('content')

  @include('partials.status')

  <h2>Dina bokningar</h2>
  @if($bookings->count())
    <ul>
      @foreach($bookings as $booking)
        <li>
          <a href="{{ action('BookingController@show', $booking) }}">
            {{ $booking->opportunity->name }}
          </a>
        </li>
      @endforeach
    </ul>
  @else
    <p>
      Du har inga aktuella {{ trans_choice('booking.booking', 2) }}.
      <a href="{{ action('OpportunityController@index') }}">
        Här hittar du intressanta {{ trans_choice('opportunity.opportunity', 2) }} att boka!
      </a>
    </p>
  @endif

  @if($passed_bookings->count())
    <h2>Dina gamla bokningar</h2>
    <p>Här visas dina bokningar för den senaste månaden.</p>
    <ul>
      @foreach($passed_bookings as $booking)
        <li>
          <a href="{{ action('BookingController@show', $booking) }}">
            {{ $booking->opportunity->name }}
          </a>
        </li>
      @endforeach
    </ul>
  @endif

@endsection