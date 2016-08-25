<?php

namespace Matchappen\Http\Controllers;

use Illuminate\Http\Request;
use Matchappen\Http\Requests;
use Matchappen\Http\Controllers\Controller;
use Matchappen\Http\Requests\StoreOpportunityRequest;
use Matchappen\Occupation;
use Matchappen\Opportunity;
use Matchappen\Services\EmailTokenGuard;
use Matchappen\User;

class OpportunityController extends Controller
{

    public function __construct(Request $request)
    {
        $this->middleware('auth', ['except' => ['index', 'show', 'booking']]);

        $fields_to_trim = array_keys(StoreOpportunityRequest::rulesForUpdate());
        $middleware_options = ['only' => ['update', 'store']];
        $this->middleware('reformulator.explode:occupations', $middleware_options);
        $this->middleware('reformulator.trim:' . implode(',', $fields_to_trim), $middleware_options);
        $this->middleware('reformulator.strip_repeats:occupations', $middleware_options);

        $this->middleware('reformulator.concatenate:start_local_date,-,start_local_year,start_local_month,start_local_day',
            $middleware_options);
        $this->middleware('reformulator.concatenate:start_local_time,:,start_local_hour,start_local_minute',
            $middleware_options);
        $this->middleware('reformulator.concatenate:start_local, ,start_local_date,start_local_time',
            $middleware_options);
        $this->middleware('reformulator.datetime-local:start_local,start_local,' . Opportunity::getTimezoneAttribute(),
            $middleware_options);
    }

    public function index()
    {
        $opportunities = Opportunity::viewable()->get();
        $number_of_bookable_opportunities = Opportunity::bookable()->count();

        return view('opportunity.index')->with(compact('opportunities', 'number_of_bookable_opportunities'));
    }

    public function show(Opportunity $opportunity)
    {
        if (!$opportunity->isViewable()) {
            return redirect()->action('OpportunityController@index');
        }

        return view('opportunity.show')->with(compact('opportunity'));
    }

    public function create(Request $request)
    {
        $workplace = $request->user()->workplace;

        $opportunity = new Opportunity();
        $opportunity->workplace()->associate($workplace);
        $opportunity->occupations = $workplace->occupations;

        return view('opportunity.create')->with(compact('opportunity', 'workplace'));
    }

    public function store(StoreOpportunityRequest $request)
    {
        $opportunity = new Opportunity($request->input());
        $opportunity->workplace()->associate($request->user()->workplace);
        $opportunity->save();

        $occupations = Occupation::getOrCreateFromNames($request->input('occupations'), $request->user());
        $opportunity->occupations()->sync($occupations);

        // Email admin when new opportunity was created
        \Mail::queue('emails.opportunity_created_admin_notification', compact('opportunity'),
            function ($message) use ($opportunity) {
                $message->to(User::getAdminEmails());
                $message->subject(trans('opportunity.created_admin_notification_mail_subject',
                    ['opportunity' => $opportunity->name]));
            });

        return redirect()->action('OpportunityController@show', $opportunity->getKey());
    }

    public function edit(Opportunity $opportunity)
    {
        $this->authorize('update', $opportunity);

        return view('opportunity.edit')->with(compact('opportunity'));
    }

    public function update(Opportunity $opportunity, StoreOpportunityRequest $request)
    {
        $opportunity->update($request->input());

        $occupations = Occupation::getOrCreateFromNames($request->input('occupations'), $request->user());
        $opportunity->occupations()->sync($occupations);

        // Email admin when opportunity was updated
        \Mail::queue('emails.opportunity_update_admin_notification', compact('opportunity'),
            function ($message) use ($opportunity) {
                $message->to(User::getAdminEmails());
                $message->subject(trans('opportunity.update_admin_notification_mail_subject',
                    ['opportunity' => $opportunity->name]));
            });

        foreach ($opportunity->bookings as $booking) {

            // Email supervisor when opportunity was updated
            \Mail::queue('emails.opportunity_update_supervisor_notification', compact('booking'),
                function ($message) use ($booking) {
                    $message->to($booking->supervisor_email);
                    $message->subject(trans('opportunity.update_supervisor_notification_mail_subject',
                        ['opportunity' => $booking->opportunity->name]));
                });

            // Email student when opportunity was updated
            if ($booking->email) {
                \Mail::queue('emails.opportunity_update_student_notification', compact('booking'),
                    function ($message) use ($booking) {
                        $message->to($booking->email);
                        $message->subject(trans('opportunity.update_student_notification_mail_subject',
                            ['opportunity' => $booking->opportunity->name]));
                    });
            }

        }

        return redirect()->action('OpportunityController@show', $opportunity->getKey());
    }

    // TODO: Refactor booking, move it to BookingController
    public function booking(Opportunity $opportunity, EmailTokenGuard $token_guard)
    {
        if (!$opportunity->isBookable()) {
            return redirect()->action('OpportunityController@show', $opportunity);
        }
        if ($booking = $opportunity->getBookingForStudent($token_guard->email())) {
            //The logged in student already has a booking
            return redirect()->action('BookingController@show', $booking);
        }

        return view('opportunity.booking')->with(compact('opportunity'));
    }
}
