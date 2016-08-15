<?php

namespace Matchappen\Http\Requests;

use Illuminate\Support\Facades\Gate;
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
            return $this->user() and $this->user()->workplace_id;
        }

        return Gate::allows('update', $opportunity);
    }

    public function validator(\Illuminate\Contracts\Validation\Factory $factory)
    {
        // Factory use from \Illuminate\Foundation\Http\FormRequest::getValidatorInstance
        $validator = $factory->make(
            $this->all(), $this->container->call([$this, 'rules']), $this->messages(), $this->attributes()
        );

        // After validation code that copies error messages to relevant middleware-imploded fields
        $validator->after(function (\Illuminate\Validation\Validator $validator) {
            if ($validator->errors()->has('start_local')) {
                $error_target = 'start_local_day';
                $validator->errors()->add($error_target, $validator->errors()->first('start_local'));
            }
        });

        return $validator;
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
        $rules['start_local'] .= '|required';

        return $rules;
    }

    public static function rulesForUpdate()
    {
        $datetime_format = trans('opportunity.datetime_format');

        return [
            'max_visitors' => 'integer|min:1|max:' . Opportunity::MAX_VISITORS,
            'description' => 'string|max:1000',
            'start_local' => 'after:' . Opportunity::getEarliestStartTimeLocal()->format($datetime_format) . '|before:' . Opportunity::getLatestStartTimeLocal()->toDateString(),
            'minutes' => 'integer|required_with:start_local|in:' .
                implode(',', array_keys(trans('opportunity.minutes_options'))),
            'registration_end_local' => 'required_with:start_local|before:start_local|after:' . Opportunity::getEarliestStartTimeLocal()->format($datetime_format),
            'address' => 'string|max:400',
            'contact_name' => ['string', 'max:100', 'regex:' . trans('general.personal_name_regex')],
            'contact_phone' => ['string', 'max:20', 'regex:' . trans('general.local_phone_regex')],
            'occupations' => 'array',
        ];
    }
}
