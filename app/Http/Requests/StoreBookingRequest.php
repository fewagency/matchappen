<?php

namespace Matchappen\Http\Requests;

use Matchappen\Http\Requests\Request;

class StoreBookingRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $opportunity = $this->route('opportunity');

        //TODO: validate email and supervisor email against the rules for school emails

        return [
            'name' => ['required', 'min:5', 'max:255', 'regex:'.trans('general.person_name_regex')],
            'email' => 'required_without:visitors|required_if:visitors,1|email|max:255|unique:bookings,email,NULL,NULL,opportunity_id,'.$opportunity->getKey(),
            'supervisor_email' => 'required|email|different:email',
            'phone' => ['string', 'max:20', 'regex:' . trans('general.local_phone_regex')],
            'visitors' => 'int|min:1|max:' . $opportunity->placesLeft(),
        ];
    }
}
