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
        if (true) { //TODO: check that teacher is not logged in
            //TODO: generate verification token and email to pupil
            $booking->reserved_until = Carbon::parse('+1 hour'); //TODO: set reserved_until to the tokens expiry time
        }
        $booking->save();

        return view('booking.complete');
    }
}
