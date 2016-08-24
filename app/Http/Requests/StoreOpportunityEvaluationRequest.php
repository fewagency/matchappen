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

        //TODO: check if user has already evaluated this opportunity

        if ($auth->check() and $auth->user()->workplace_id === $opportunity->workplace_id) {
            // The logged in user represents the organising workplace
            $this->opportunity_evaluation = new HostOpportunityEvaluation();
            $this->opportunity_evaluation->opportunity()->associate($opportunity);
            $this->opportunity_evaluation->user()->associate($auth->user());

            return true;
        }

        if ($booking = $opportunity->getBookingForStudent($token_guard->email())) {
            // The logged in student had a booking
            $this->opportunity_evaluation = new VisitorOpportunityEvaluation();
            $this->opportunity_evaluation->booking()->associate($booking);

            return true;
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
