<?php

namespace Matchappen\Http\Requests;

use Matchappen\Http\Requests\Request;
use Matchappen\Services\EmailTokenGuard;

class CancelBookingRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @param EmailTokenGuard $token_guard
     * @return bool
     */
    public function authorize(EmailTokenGuard $token_guard)
    {
        $booking = $this->route('booking');

        return $booking->checkEmail($token_guard->email());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }
}
