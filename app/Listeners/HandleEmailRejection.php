<?php

namespace Matchappen\Listeners;

use Matchappen\Booking;
use Matchappen\Events\EmailWasRejected;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class HandleEmailRejection
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  EmailWasRejected $event
     * @return void
     */
    public function handle(EmailWasRejected $event)
    {
        $bookings = Booking::forSupervisor($event->rejected_email_address)->recentlyBooked()->get();
        $bookings->each(function (Booking $booking) use ($event) {
            $booking->delete();
            //TODO: email student about canceled booking due to supervisor email rejection
            \Log::info('Booking ' . $booking->getKey() . ' cancelled due to rejected email from supervisor ' . $event->rejected_email_address);
        });
    }
}
