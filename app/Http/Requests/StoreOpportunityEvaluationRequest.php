<?php

namespace Matchappen\Http\Requests;


use Matchappen\Http\Requests\Request;
use Illuminate\Auth\Guard;
use Matchappen\Services\EmailTokenGuard;

class StoreOpportunityEvaluationRequest extends Request
{
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
        if ($auth->check() and $auth->user()->workplace_id === $opportunity->workplace_id) {
            // The logged in user represents the organising workplace
            return true;
        }

        if ($opportunity->bookings->pluck('email')->contains($token_guard->email())) {
            // The logged in student had a booking
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
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'string|max:65535',
        ];
    }
}
