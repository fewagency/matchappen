<?php

return [
    /*
     * Email pattern for supervisors within
     * - Malmö stad: doesn't start with 'utb' and ends in @skola.malmo.se or @malmo.se
     * - Kunskapsgymnasiet: för.efternamn@kunskapsgymnasiet.se
     * - Plusgymnasiet: ends in @plusgymnasiet.se
    */
    'supervisor_email_regex' => '/^((?!utb)([\w\._-]+)@(skola\.)?malmo\.se)|(.+\..+@kunskapsgymnasiet\.se)|(.+@plusgymnasiet\.se)$/',

    /* Email pattern for students within
     * - Malmö stad: always starts with 'utb' and ends in @skola.malmo.se
     * - Kunskapsgymnasiet: xxx111@edu.kunskapsgymnasiet
     * - Plusgymnasiet: ends in @plusgymnasietmalmo.se
     */
    'student_email_regex' => '/^(utb([\w\._-]+)@skola\.malmo\.se)|(\w{3}\d{3}@edu\.kunskapsgymnasiet\.se)|(.+@plusgymnasietmalmo\.se)$/',

    // email pattern for all education system users (supervisors and students)
    'edu_email_regex' => '/(.+@(skola\.)?malmo\.se)|(.+@(edu\.)?kunskapsgymnasiet\.se)|(.+@plusgymnasiet(malmo)?\.se)$/',
];