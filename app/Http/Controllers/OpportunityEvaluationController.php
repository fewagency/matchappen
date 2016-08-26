<?php

namespace Matchappen\Http\Controllers;

use Illuminate\Http\Request;
use Matchappen\HostOpportunityEvaluation;
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
        if (!$opportunity->isPassed()) {
            abort(404, 'Opportunity is in the future - it cannot be evaluated yet');
        }

        if ($this->auth->check()) {
            $evaluation = $opportunity->getHostEvaluationForUser($this->auth->user());
        } elseif ($this->token_guard->check()) {
            $evaluation = $opportunity->getVisitorEvaluationForEmail($this->token_guard->email());
        }

        if (empty($evaluation)) {
            return redirect()->guest(action('Auth\AuthController@getLogin'));
        }

        if ($evaluation->exists) {
            return redirect()->route('dashboard')->with('warning',
                trans('evaluation.already_received', ['opportunity' => $opportunity->name]));
        }

        return view('evaluation.create')->with([
            'opportunity' => $opportunity,
            'booking' => $evaluation->booking
        ]);
    }

    public function store(Opportunity $opportunity, StoreOpportunityEvaluationRequest $request)
    {
        $evaluation = $request->getOpportunityEvaluation();
        $evaluation->fill($request->all());
        $evaluation->save();

        \Mail::queue('emails.supervisor_evaluation_notification', compact('opportunity', 'evaluation'),
            function ($message) use ($opportunity, $evaluation) {
                if ($evaluation instanceof HostOpportunityEvaluation) {
                    $message->to(array_unique($opportunity->bookings->pluck('supervisor_email')->toArray()));
                    $message->subject(trans('evaluation.supervisor_notification_subject',
                        ['author' => $opportunity->workplace->name, 'opportunity' => $opportunity->name]));
                } else {
                    $message->to($evaluation->booking->supervisor_email);
                    $message->subject(trans('evaluation.supervisor_notification_subject',
                        ['author' => $evaluation->booking->name, 'opportunity' => $opportunity->name]));
                }
            });

        return redirect()->route('dashboard')->with('status',
            trans('evaluation.sent', ['opportunity' => $opportunity->name]));
    }
}
