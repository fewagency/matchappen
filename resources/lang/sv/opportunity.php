<?php
return [
    'opportunity' => 'möte|möten',
    'create_opportunity_headline' => 'Erbjud ett besök på :workplace',
    'opportunity_at_workplace' => 'besök hos :workplace :time',
    'minutes_options' => [45 => '45 minuter', 60 => '1 timme', 90 => '1,5 timmar', 120 => '2 timmar'],
    'registration_end_weekdays_before_options' => [
        //0 => 'samma dag - strax innan mötet',
        1 => 'vardagen innan mötet',
        2 => 'två vardagar innan mötet',
        3 => 'tre vardagar innan mötet',
        5 => 'en vecka innan mötet',
        10 => 'två veckor innan mötet'
    ],
    'labels' => [
        'student_email' => 'Elevens epostadress',
        'supervisor_email' => 'Din lärares epostadress',
        'your_mobile_phone' => 'Ditt mobilnummer',
    ],
    'actions' => [
        'book' => 'boka',
    ],
    'datetime_format' => 'Y-m-d H:i',

    'created_admin_notification_mail_subject' => 'Möte skapat: :opportunity',
    'update_admin_notification_mail_subject' => 'Ändrat möte: :opportunity',
];