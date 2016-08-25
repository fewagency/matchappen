<?php

namespace Matchappen\Http\Requests;


use Matchappen\HostOpportunityEvaluation;
use Matchappen\Http\Requests\Request;
use Illuminate\Auth\Guard;
use Matchappen\Services\EmailTokenGuard;
use Matchappen\VisitorOpportunityEvaluation;

class StoreOpportunityEvaluationRequest extends Request
{
    /**
     * An evaluation instance that is created and associated upon authorization
     * @var HostOpportunityEvaluation|VisitorOpportunityEvaluation
     */
    protected $opportunity_evaluation;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @param Guard $auth
     * @param EmailTokenGuard $token_guard
     * @return bool
     */
    public function authorize(Guard $auth, EmailTokenGuard $token_guard)
    {
        $opportunity = $this->route('opportunity');

        if ($opportunity->start->isFuture()) {
            return false;
        }

        if ($auth->check() and $this->opportunity_evaluation = $opportunity->getHostEvaluationForUser($auth->user())) {
            // The logged in user represents the organising workplace
            // If the evaluation is already saved, don't authorize
            return !$this->opportunity_evaluation->exists;
        }

        if ($token_guard->check() and $this->opportunity_evaluation = $opportunity->getVisitorEvaluationForEmail($token_guard->email())) {
            // The logged in student had a booking
            // If the evaluation is already saved, don't authorize
            return !$this->opportunity_evaluation->exists;
        }

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'rating' => 'required|integer|between:1,5',
            'comment' => 'string|max:65535',
        ];
    }

    /**
     * Get an instance of the opportunity evaluation that can be filled and saved
     * @return HostOpportunityEvaluation|VisitorOpportunityEvaluation
     */
    public function getOpportunityEvaluation()
    {
        return $this->opportunity_evaluation;
    }
}
