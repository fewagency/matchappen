<?php

namespace Matchappen\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

use Matchappen\Booking;
use Matchappen\Http\Requests;
use Matchappen\Http\Controllers\Controller;
use Matchappen\Http\Requests\StoreBookingRequest;
use Matchappen\Http\Requests\CancelBookingRequest;
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
            return redirect()->action('OpportunityController@show', $opportunity);
        }
        $booking = new Booking($request->input());
        $booking->opportunity()->associate($opportunity);
        if ($guard->checkSupervisor()) {
            $booking->save();

            //TODO: email booking link to supervisor

            return redirect()->action('BookingController@show', $booking);
        } else {
            $booking->reserved_until = Carbon::parse('+1 hour');
            $booking->save();
            $token = $booking->generateAccessToken($booking->email);

            //TODO: email token to pupil

            return redirect()->action('BookingController@reserved')->with('reserved_booking_id', $booking->getKey());
        }
    }

    public function reserved(Request $request)
    {
        $booking = Booking::find($request->session()->get('reserved_booking_id'));
        if (empty($booking)) {
            return redirect()->action('OpportunityController@index');
        }

        return view('booking.reserved', compact('booking'));
    }

    public function show(Booking $booking, EmailTokenGuard $guard)
    {
        if (!$booking->checkEmail($guard->email())) {
            // TODO: allow user to email new token to access this booking?
            abort(403, 'Access denied');
        }

        if (!$booking->isConfirmed() and $booking->checkVisitorEmail($guard->email())) {
            $booking->confirm();
            // TODO: email supervisor
            // TODO: email admin link to pupil
        }

        $opportunity = $booking->opportunity;

        return view('booking.show')->with(compact('booking', 'opportunity'));
    }

    public function postCancel(Booking $booking, CancelBookingRequest $request)
    {
        //Cancel booking (soft-delete)
        $booking->delete();

        //TODO: notify supervisor

        return redirect()->route('dashboard')->with('status',
            trans('booking.cancelled', ['booking' => $booking->opportunity->name])
        );
    }
}
