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

    /**
     * @return array of validator rules
     */
    public static function rulesForCreate()
    {
        $rules = self::rulesForUpdate();
        $rules['name'] .= '|required';
        $rules['employees'] .= '|required';

        return $rules;
    }

    public static function rulesForUpdate($exclude_id_from_unique = null)
    {
        $rules = [
            'name' => 'min:3|max:255|unique:workplaces,name',
            'employees' => 'integer|min:1|max:65535',
            'description' => '',
            'homepage' => 'url|max:255',
            'contact_name' => 'max:100',
            'email' => 'email|max:50',
            'phone' => ['max:20', 'regex:/^(\+46 ?|0)[1-9]\d?-?(\d ?){5,}$/'],
            'address' => 'max:500',
        ];
        if($exclude_id_from_unique) {
            $rules['name'] = $rules['name'] .= ','.$exclude_id_from_unique;
        }

        return $rules;
    }
}
