{{ ucfirst($booking->opportunity->name) }}

@if($booking->visitors > 1)<p>{{ $booking->visitors }} besökare</p>@endif
<p>{{ $booking->name }}</p>
@if($booking->email)<p>{{ $booking->email }}</p>@endif
@if($booking->phone)<p>{{ $booking->phone }}</p>@endif

@include('emails.partials.opportunity', ['opportunity' => $booking->opportunity])

{{  action('BookingController@show', $booking) }}