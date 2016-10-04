Lämna din utvärdering av {{ $booking->opportunity->name }}
genom att följa den här länken:
{{ $token->getTokenUrl() }}

@include('emails.partials.booking_number', compact('booking'))