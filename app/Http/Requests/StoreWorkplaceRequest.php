<?php

namespace Matchappen\Http\Requests;

use Illuminate\Support\Facades\Gate;
use Matchappen\Http\Requests\Request;

class StoreWorkplaceRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $workplace = $this->route('workplace');
        if ($this->input('is_published') and Gate::denies('publish', $workplace)) {
            return false;
        }

        return Gate::allows('update', $workplace);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $workplace = $this->route('workplace');

        return $this->rulesForUpdate($workplace ? $workplace->getKey() : null);
    }

    public static function rulesForCreate()
    {
        $rules = [
            'name' => ['required', 'min:3', 'max:255', 'unique:workplaces,name'],
            'employees' => ['required', 'integer', 'min:1', 'max:65535'],
            'description' => ['string'],
            'homepage' => ['url', 'max:255'],
            'contact_name' => ['string', 'max:100', 'regex:' . trans('general.personal_name_regex')],
            'email' => ['email', 'max:50'],
            'phone' => ['string', 'max:20', 'regex:' . trans('general.local_phone_regex')],
            'address' => ['required', 'string', 'max:500'],
        ];

        return $rules;
    }

    public static function rulesForUpdate($exclude_id_from_unique = null)
    {
        $rules = self::rulesForCreate();

        foreach ($rules as $field => &$field_rules) {

            // Handle unique-rules
            if ($exclude_id_from_unique) {
                foreach ($field_rules as &$rule) {
                    if (starts_with($rule, 'unique:workplaces,')) {
                        $rule .= ',' . $exclude_id_from_unique;
                    }
                }
            }

            // Make all rules apply only if field is present
            array_unshift($field_rules, 'sometimes');
        }

        return $rules;
    }
}