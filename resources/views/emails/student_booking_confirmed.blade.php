Din bokning är bekräftad:
{{ ucfirst($booking->opportunity->name) }}

@include('emails.partials.opportunity', ['opportunity' => $booking->opportunity])

{{ action('BookingController@show', $booking) }}