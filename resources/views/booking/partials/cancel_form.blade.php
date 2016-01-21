@if($booking->isCancelable())
  <form action="{{ action('BookingController@postCancel', $booking) }}" method="POST">
    {!! csrf_field() !!}
    <input type="submit" value="{{ trans('booking.cancel-btn-text') }}">
  </form>
@endif