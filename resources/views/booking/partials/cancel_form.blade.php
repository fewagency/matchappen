@if($booking->isCancelable())
  {!!
  FluentForm::withAction(action('BookingController@postCancel', $booking))
  ->withToken(csrf_token())
  ->withButtonBlock(trans('booking.cancel-btn-text'))
  !!}
@endif