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

        return [
            'name' => ['required', 'max:255', 'regex:' . trans('general.personal_name_regex')],
            'email' => [
                'required_without:visitors',
                'required_if:visitors,1',
                'email',
                'max:255',
                'regex:' . config('school.supervisor_email_regex'),
                'unique:bookings,email,NULL,NULL,opportunity_id,' . $opportunity->getKey(),
            ],
            'supervisor_email' => [
                'required',
                'email',
                'different:email',
                'regex:' . config('school.supervisor_email_regex'),
            ],
            'phone' => ['string', 'max:20', 'regex:' . trans('general.local_phone_regex')],
            'visitors' => 'int|min:1|max:' . $opportunity->placesLeft(),
        ];
    }
}
