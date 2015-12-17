<?php

namespace Matchappen;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Workplace extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'employees',
        'description',
        'homepage',
        'contact_name',
        'email',
        'phone',
        'address',
    ];

    //TODO: make global scope: is_published=1

    /**
     * @return array of validator rules
     */
    public static function rulesForCreate()
    {
        return [
            'name' => 'required|min:3|max:255|unique:workplaces,name',
            'employees' => 'required|integer|min:1|max:65535',
            'description' => '',
            'homepage' => 'url|max:255',
            'contact_name' => 'max:100',
            'email' => 'email|max:50',
            'phone' => ['max:20', 'regex:/^(\+46 ?|0)[1-9]\d?-?(\d ?){5,}$/'],
            'address' => 'max:500',
        ];
    }
}
