<?php

namespace Matchappen\Http\Controllers;

use Illuminate\Http\Request;
use Matchappen\Http\Requests;
use Matchappen\Http\Controllers\Controller;
use Carbon\Carbon;
use Matchappen\Booking;
use Matchappen\Http\Requests\StoreBookingRequest;
use Matchappen\Http\Requests\CancelBookingRequest;
use Matchappen\Opportunity;
use Matchappen\Services\EmailTokenGuard;

class BookingController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('auth.token', ['only' => 'show']);
        $this->middleware('reformulator.trim:name,email,supervisor_email,phone', ['only' => ['update', 'store']]);
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

            // Email confirmation to the supervisor that did the booking
            \Mail::queue('emails.supervisor_booking_confirmed', compact('booking'),
                function ($message) use ($booking) {
                    $message->to($booking->supervisor_email);
                    $message->subject(trans('booking.supervisor_booking_confirmed_mail_subject',
                        ['opportunity' => $booking->opportunity->name]));
                });

            return redirect()->action('BookingController@show', $booking);
        } else {
            $booking->reserved_until = Carbon::parse('+1 hour');
            $booking->save();
            $token = $booking->generateAccessToken($booking->email);

            // Email the confirmation token to the student that did the booking
            \Mail::queue('emails.student_booking_confirmation_token', compact('booking', 'token'),
                function ($message) use ($booking) {
                    $message->to($booking->email);
                    $message->subject(trans('booking.student_booking_confirmation_token_mail_subject',
                        ['opportunity' => $booking->opportunity->name]));
                });

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
            abort(403, 'Access denied');
        }

        if (!$booking->isConfirmed() and $booking->checkVisitorEmail($guard->email())) {
            $booking->confirm();

            // Email notification to supervisor that a student has completed a booking
            \Mail::queue('emails.supervisor_booking_notification', compact('booking'),
                function ($message) use ($booking) {
                    $message->to($booking->supervisor_email);
                    $message->subject(trans('booking.supervisor_booking_notification_mail_subject',
                        ['opportunity' => $booking->opportunity->name, 'student' => $booking->name]));
                });

            // Email confirmation to the student that completed the booking
            \Mail::queue('emails.student_booking_confirmed', compact('booking'),
                function ($message) use ($booking) {
                    $message->to($booking->email);
                    $message->subject(trans('booking.student_booking_confirmed_mail_subject',
                        ['opportunity' => $booking->opportunity->name]));
                });
        }

        $opportunity = $booking->opportunity;

        return view('booking.show')->with(compact('booking', 'opportunity'));
    }

    public function postCancel(Booking $booking, CancelBookingRequest $request, EmailTokenGuard $guard)
    {
        //Cancel booking (soft-delete)
        $booking->delete();

        if (!$guard->checkSupervisor()) {
            // Email notification to supervisor that a student has cancelled a booking
            \Mail::queue('emails.supervisor_booking_cancelled_notification', compact('booking'),
                function ($message) use ($booking) {
                    $message->to($booking->supervisor_email);
                    $message->subject(trans('booking.supervisor_booking_cancelled_notification_mail_subject',
                        ['opportunity' => $booking->opportunity->name, 'student' => $booking->name]));
                });
        }

        return redirect()->route('dashboard')->with('status',
            trans('booking.cancelled', ['booking' => $booking->opportunity->name])
        );
    }
}
