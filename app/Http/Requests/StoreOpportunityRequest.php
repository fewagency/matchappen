<?php

namespace Matchappen\Http\Requests;

use FewAgency\Carbonator\Carbonator;
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

        // After validation code that copies some error messages to relevant middleware-concatenated fields
        $validator->after(function (\Illuminate\Validation\Validator $validator) {
            // Get array of failed attributes, their rules and parameters
            $failed_rules = $validator->failed();

            // Errors on start_local should be copied to a start_local_xxx field
            if ($validator->errors()->has('start_local')) {
                $target_attribute_name = 'start_local_day'; // Default field to copy error to
                $start = Carbonator::parseToTz($validator->getData()['start_local'],
                    Opportunity::getTimezoneAttribute(), Opportunity::getTimezoneAttribute());

                $first_rule_message = $validator->errors()->first('start_local');
                // Must be in this order:
                $first_rule_parameters = reset($failed_rules['start_local']);
                $first_rule_name = key($failed_rules['start_local']);

                if ($first_rule_name == 'After' and $start) {
                    $earliest_start = Carbonator::parseToTz($first_rule_parameters[0],
                        Opportunity::getTimezoneAttribute(), Opportunity::getTimezoneAttribute());
                    $target_attribute_name = 'start_local_minute';
                    if ($start->hour < $earliest_start->hour) {
                        $target_attribute_name = 'start_local_hour';
                    }
                    if ($start->day < $earliest_start->day) {
                        $target_attribute_name = 'start_local_day';
                    }
                    if ($start->month < $earliest_start->month) {
                        $target_attribute_name = 'start_local_month';
                    }
                    if ($start->year < $earliest_start->year) {
                        $target_attribute_name = 'start_local_year';
                    }
                }

                if ($first_rule_name == 'Before' and $start) {
                    $latest_start = Carbonator::parseToTz($first_rule_parameters[0],
                        Opportunity::getTimezoneAttribute(), Opportunity::getTimezoneAttribute());
                    $target_attribute_name = 'start_local_day';
                    if ($start->month > $latest_start->month) {
                        $target_attribute_name = 'start_local_month';
                    }
                    if ($start->year > $latest_start->year) {
                        $target_attribute_name = 'start_local_year';
                    }
                }

                $validator->errors()->add($target_attribute_name, $first_rule_message);
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
            'max_visitors' => 'integer|between:1,' . Opportunity::MAX_VISITORS,
            'description' => 'string|max:1000',
            'start_local' => 'after:' . Opportunity::getEarliestStartTimeLocal()->format($datetime_format) . '|before:' . Opportunity::getLatestStartTimeLocal()->toDateString(),
            'minutes' => 'in:' .
                implode(',', array_keys(trans('opportunity.minutes_options'))),
            'registration_end_days_before' => 'integer|between:0,10',
            'address' => 'string|max:400',
            'contact_name' => ['string', 'max:100', 'regex:' . trans('general.personal_name_regex')],
            'contact_phone' => ['string', 'max:20', 'regex:' . trans('general.local_phone_regex')],
            'occupations' => 'array', // TODO: don't let any occupation name contain more than one whitespace
        ];
    }
}
