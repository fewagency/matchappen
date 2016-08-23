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

    'after' => ':attribute måste vara efter :date.',
    'before' => ':attribute måste vara före :date.',
    'between' => [
        'numeric' => ':attribute måste vara mellan :min och :max.',
        'string' => ':attribute måste vara mellan :min och :max tecken.',
    ],
    'confirmed' => 'bekräftelsen för :attribute matchar inte.',
    'different' => ':attribute och :other måste vara olika.',
    'email' => ':attribute måste vara en giltig epostadress.',
    'in' => 'valet av :attribute är ogiltigt.',
    'integer' => ':attribute måste vara ett heltal.',
    'max' => [
        'numeric' => ':attribute får inte vara större än :max.',
        'string' => ':attribute får inte vara längre än :max tecken.',
    ],
    'min' => [
        'numeric' => ':attribute måste vara minst :min.',
        'string' => ':attribute måste vara minst :min tecken.',
    ],
    'regex' => ':attribute har ett ogiltigt format.',
    'required' => ':attribute måste anges.',
    'required_if' => ':attribute måste anges när :other är :value.',
    'required_without' => ':attribute måste anges.',
    'unique' => ':attribute finns redan i systemet.',
    'url' => ':attribute måste vara en giltig webbadress med protokoll - prova att lägga till http:// i början!',

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
        'user' => [
            'name' => [
                'regex' => 'namnet måste bestå av minst två ord.',
            ],
            'email' => [
                'unique' => 'epostadressen är redan registrerad - försök logga in!',
            ],
        ],
        'workplace' => [
            'name' => [
                'unique' => 'arbetsplatsens namn är redan registrerat - fråga dina kollegor vem som har inloggningsuppgifterna!'
            ],
        ],
        'contact_name' => [
            'regex' => 'namnet måste bestå av minst två ord.',
        ],
        'name' => [
            'regex' => 'namnet måste bestå av minst två ord.',
        ],
        'student_email' => [
            'regex' => 'epostaddressen måste tillhöra en elev i Malmö kommuns skolor.',
            // TODO: lägg till elever i klara friskolor i detta meddelande
        ],
        'supervisor_email' => [
            'regex' => 'epostaddressen måste tillhöra en anställd på Malmö kommuns skolor.',
            // TODO: lägg till personal från klara friskolor i detta meddelande
        ],
        'edu_email' => [
            'regex' => 'epostaddressen måste tillhöra någon från Malmö kommuns skolor.',
            // TODO: lägg till elever och personal från klara friskolor i detta meddelande
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
        'password' => 'lösenord',
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
        'start_local' => 'starttid',
        'start_local_day' => 'starttid - dag i månaden',
        'start_local_month' => 'starttid - månad',
        'start_local_year' => 'starttid - år',
        'start_local_hour' => 'starttid - klockslag',
        'start_local_minute' => 'starttid - minuter över hel timme',
        'minutes' => 'längd',
        'registration_end_local' => 'tid för sista anmälan',
        'registration_end_weekdays_before' => 'sista anmälan',
        'occupations' => 'yrken',
        'contact_phone' => 'telefon',
        'visitors' => 'antal besökare',
        'workplace' => [
            'name' => 'arbetsplatsens namn',
            'employees' => 'antal anställda på arbetsplatsen',
            'occupations' => 'yrken på arbetsplatsen',
            'address' => 'arbetsplatsens adress',
            'description' => 'beskrivning av arbetsplatsen',
        ],
        'user' => [
            'name' => 'ditt namn',
            'email' => 'din epostadress',
            'phone' => 'ditt telefonnummer',
            'password' => 'lösenord',
        ]
    ],

];
