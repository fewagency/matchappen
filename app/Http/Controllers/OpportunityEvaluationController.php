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

        $this->middleware('reformulator.trim:comment', ['only' => 'store']);
    }

    public function create(Opportunity $opportunity)
    {
        if ($opportunity->start->isFuture()) {
            abort(404, 'Opportunity is in the future - it cannot be evaluated yet');
        }

        //TODO: check if user has already evaluated this opportunity

        // For workplace
        if ($this->auth->check() and $this->auth->user()->workplace_id === $opportunity->workplace_id) {
            return view('evaluation.create')->with(compact('opportunity'));
        }

        // For student
        if ($this->token_guard->check() and ($booking = $opportunity->getBookingForStudent($this->token_guard->email()))) {
            return view('evaluation.create')->with(compact('opportunity', 'booking'));
        }

        return redirect()->guest(action('Auth\AuthController@getLogin'));
    }

    public function store(Opportunity $opportunity, StoreOpportunityEvaluationRequest $request)
    {
        $evaluation = $request->getOpportunityEvaluation();
        $evaluation->fill($request->all());
        $evaluation->save();

        return redirect()->route('dashboard')->with('status', trans('evaluation.sent'));
    }
}
