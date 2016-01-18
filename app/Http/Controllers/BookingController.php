<?php

namespace Matchappen\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

use Matchappen\Booking;
use Matchappen\Http\Requests;
use Matchappen\Http\Controllers\Controller;
use Matchappen\Http\Requests\StoreBookingRequest;
use Matchappen\Opportunity;
use Matchappen\Services\EmailTokenGuard;

class BookingController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('input.trim:name,email,supervisor_email,phone', ['only' => ['update', 'store']]);
    }

    public function store(Opportunity $opportunity, StoreBookingRequest $request, EmailTokenGuard $guard)
    {
        if (!$opportunity->isBookable()) {
            return redirect(action('OpportunityController@show', $opportunity));
        }
        $booking = new Booking($request->input());
        $booking->opportunity()->associate($opportunity);
        if ($guard->checkSupervisor()) {
            $booking->save();

            return redirect(action('BookingController@show', $booking));
        } else {
            $booking->reserved_until = Carbon::parse('+1 hour');
            $booking->save();
            $token = $booking->generateAccessToken($booking->email);

            //TODO: email token to pupil

            return redirect(action('BookingController@reserved'))->with('reserved_booking_id', $booking->getKey());
        }
    }

    public function reserved(Request $request)
    {
        $booking = Booking::find($request->session()->get('reserved_booking_id'));
        if (empty($booking)) {
            return redirect(action('OpportunityController@index'));
        }

        return view('booking.reserved', compact('booking'));
    }

    public function show(Booking $booking, EmailTokenGuard $guard)
    {
        if (!$booking->checkEmail($guard->email())) {
            // TODO: allow user to email new token to access this booking?
            abort(403, 'Access denied');
        }

        return $booking;
    }
}
