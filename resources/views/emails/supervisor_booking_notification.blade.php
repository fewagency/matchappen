<p>
  Eleven <strong>{{ $booking->name }}</strong>
  har bokat {{ ucfirst($booking->opportunity->name) }}
</p>

<p>
Om du som ansvarig skolpersonal <em>inte</em> godkänner detta måste du avboka genom den här länken:
{{ action('BookingController@show', $booking) }}
</p>
<p>
  <small>Om du avbokar bör du också kontakta eleven och förklara varför.</small>
</p>

@if($booking->email)<p>Elevens epost: {{ $booking->email }}</p>@endif
@if($booking->phone)<p>Elevens telefon: {{ $booking->phone }}</p>@endif

@include('emails.partials.opportunity', ['opportunity' => $booking->opportunity])

@include('emails.partials.booking_number', compact('booking'))