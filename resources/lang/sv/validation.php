<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */


    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        'email' => 'epostadress',
        'name' => 'namn',
        'supervisor_email' => 'ansvarig skolpersonals epostadress',
        'phone' => 'telefon',
        'employees' => 'antal anställda',
        'address' => 'adress',
        'contact_name' => 'kontaktperson',
        'description' => 'beskrivning',
        'is_published' => 'publicerad',
        'homepage' => 'hemsida',
        'max_visitors' => 'antal platser',
        'start' => 'start',
        'minutes' => 'längd',
        'registration_end' => 'anmälan fram till',
        'occupations' => 'yrken',
        'contact_phone' => 'telefon',
        'visitors' => 'antal besökare',
        'workplace' => [
            'name' => 'arbetsplatsens namn',
            'employees' => 'antal anställda på arbetsplatsen',
            'occupations' => 'yrken på arbetsplatsen',
            'address' => 'arbetsplatsens adress',
        ],
        'user' => [
            'name' => 'ditt namn',
            'email' => 'din epostadress',
            'phone' => 'ditt telefonnummer',
            'password' => 'lösenord',
        ]
    ],

];
