<p>
  Eleven <strong>{{ $booking->name }}</strong>
  har avbokat {{ ucfirst($booking->opportunity->name) }}
</p>

@if($booking->email)<p>Elevens epost: {{ $booking->email }}</p>@endif
@if($booking->phone)<p>Elevens telefon: {{ $booking->phone }}</p>@endif

@include('emails.partials.opportunity', ['opportunity' => $booking->opportunity])

@include('emails.partials.booking_number', compact('booking'))