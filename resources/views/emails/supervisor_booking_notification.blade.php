{{ ucfirst($booking->opportunity->name) }}

{{ $booking->name }}
@if($booking->email){{ $booking->email }}@endif
{{ $booking->visitors }}
@if($booking->phone){{ $booking->phone }}@endif

@include('emails.partials.opportunity', ['opportunity' => $booking->opportunity])

{{  action('BookingController@show', $booking) }}