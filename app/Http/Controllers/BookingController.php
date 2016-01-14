<?php

namespace Matchappen\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

use Matchappen\Booking;
use Matchappen\Http\Requests;
use Matchappen\Http\Controllers\Controller;
use Matchappen\Http\Requests\StoreBookingRequest;
use Matchappen\Opportunity;

class BookingController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('input.trim:name,email,supervisor_email,phone', ['only' => ['update', 'store']]);
    }

    public function store(Opportunity $opportunity, StoreBookingRequest $request)
    {
        if (!$opportunity->isBookable()) {
            return redirect(action('OpportunityController@show', $opportunity));
        }
        $booking = new Booking($request->input());
        $booking->opportunity()->associate($opportunity);
        if (false) { //TODO: check if supervisor is logged in
            $booking->save();

            return view('booking.complete'); //TODO: make the booking.complete view different for supervisors
        } else {
            $booking->reserved_until = Carbon::parse('+1 hour');
            $booking->save();
            $token = $booking->generateAccessToken($booking->email);

            //TODO: email token to pupil

            return view('booking.complete');
        }
    }
}
