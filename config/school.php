<?php

return [
    // email pattern for supervisors within Malmö stad - doesn't start with 'utb' and ends in @skola.malmo.se or @malmo.se
    'supervisor_email_regex' => '/^((?!utb)([\w\._-]+)@(skola\.)?malmo\.se)|(\w+\.\w+@kunskapsgymnasiet\.se)$/',
    // email pattern for students within Malmö stad - always starts with 'utb' and ends in @skola.malmo.se
    'student_email_regex' => '/^utb([\w\._-]+)@skola\.malmo\.se$/',
    // email pattern for all education system users (supervisors and students)
    'edu_email_regex' => '/(@(skola\.)?malmo\.se)|(@kunskapsgymnasiet.se)$/'
];