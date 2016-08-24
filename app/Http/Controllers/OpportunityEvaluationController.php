<?php

namespace Matchappen\Http\Controllers;

use Illuminate\Http\Request;

use Matchappen\Booking;
use Matchappen\Http\Requests;
use Matchappen\Http\Controllers\Controller;
use Matchappen\Http\Requests\StoreOpportunityEvaluationRequest;
use Matchappen\Opportunity;
use Illuminate\Auth\Guard;
use Matchappen\Services\EmailTokenGuard;

class OpportunityEvaluationController extends Controller
{
    protected $auth;
    protected $token_guard;

    public function __construct(Guard $auth, EmailTokenGuard $token_guard)
    {
        $this->auth = $auth;
        $this->token_guard = $token_guard;
    }

    public function create(Opportunity $opportunity)
    {
        // TODO: if opportunity is in the future, abort!

        // For workplace
        if ($this->auth->check() and $this->auth->user()->workplace_id === $opportunity->workplace_id) {
            return view('evaluation.create')->with(compact('opportunity'));
        }

        // For student
        if ($booking = $opportunity->bookings->first(function ($key, Booking $booking) {
            return $booking->checkVisitorEmail($this->token_guard->email());
        })
        ) {
            return view('evaluation.create')->with(compact('opportunity', 'booking'));
        }

        return redirect()->guest(action('Auth\AuthController@getLogin'));
    }

    public function store(Opportunity $opportunity, StoreOpportunityEvaluationRequest $request)
    {
        //
    }
}
