<?php

namespace Matchappen\Http\Requests;

use Illuminate\Support\Facades\Gate;
use Matchappen\Http\Requests\Request;
use Matchappen\Opportunity;

class StoreOpportunityRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $opportunity = $this->route('opportunity');

        if (!$opportunity) {
            return (bool)$this->user()->workplace_id;
        }

        return Gate::allows('update', $opportunity);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $opportunity = $this->route('opportunity');
        if (!$opportunity) {
            return $this->rulesForCreate();
        }

        return $this->rulesForUpdate();
    }

    public static function rulesForCreate()
    {
        $rules = self::rulesForUpdate();
        $rules['max_visitors'] .= '|required';
        $rules['start'] .= '|required';

        return $rules;
    }

    public static function rulesForUpdate()
    {
        return [
            'max_visitors' => 'integer|min:1|max:' . Opportunity::MAX_VISITORS,
            'description' => 'string|max:1000',
            'start' => 'string',
            'minutes' => 'integer|required_with:start|in:' .
                implode(',', array_keys(trans('opportunity.minutes_options'))),
            'registration_end' => 'string|required_with:start',
            'address' => 'string|max:400',
            'contact_name' => 'string|max:100',
            'contact_phone' => ['string', 'max:20', 'regex:'.trans('general.local_phone_regex')],
        ];
    }
}
