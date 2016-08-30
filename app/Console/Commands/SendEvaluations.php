<?php

namespace Matchappen\Console\Commands;

use Illuminate\Console\Command;
use Matchappen\Booking;
use Matchappen\Opportunity;

class SendEvaluations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'evaluations:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Trigger all evaluation notifications for meetings that have passed';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Opportunity::toEvaluate()->get()->each(function (Opportunity $opportunity) {
            $opportunity->setEvaluationNotified();
            if ($opportunity->hasBookings()) {
                //Email evaluation-link to the workplace
                \Mail::queue('emails.workplace_evaluation_notification', compact('opportunity'),
                    function ($message) use ($opportunity) {
                        $message->to($opportunity->display_contact_email);
                        $message->subject(trans('evaluation.workplace_notification_subject',
                            ['opportunity' => $opportunity->name]));
                    });
                $opportunity->bookings->each(function (Booking $booking) {
                    //Email evaluation-token to visitor
                    $token = $booking->generateStudentEvaluationToken();
                    if ($token) {
                        \Mail::queue('emails.student_evaluation_notification', compact('booking', 'token'),
                            function ($message) use ($booking) {
                                $message->to($booking->email);
                                $message->subject(trans('evaluation.student_notification_subject',
                                    ['opportunity' => $booking->opportunity->name]));
                            });
                    }
                });
            }
        });
    }
}
