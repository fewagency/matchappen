<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class EmailPatternTest extends TestCase
{
    protected $supervisor_regex;
    protected $student_regex;
    protected $edu_regex;

    public function setUp()
    {
        parent::setUp();
        $this->supervisor_regex = config('school.supervisor_email_regex');
        $this->student_regex = config('school.student_email_regex');
        $this->edu_regex = config('school.edu_email_regex');
    }

    public function testSupervisorEmail()
    {
        $regex = $this->supervisor_regex;
        $this->assertNotRegExp($regex, 'utb12a@skola.malmo.se');
        $this->assertRegExp($regex, 'syv@malmo.se');
        $this->assertNotRegExp($regex, 'abc@abc.com');

        $this->assertRegExp($regex, 'för_namn.efter-namn@kunskapsgymnasiet.se');
        $this->assertNotRegExp($regex, 'xxx111@edu.kunskapsgymnasiet.se');

        $this->assertRegExp($regex, 'en_lärare.på-@plusgymnasiet.se');
        $this->assertNotRegExp($regex, 'en_elev.på-@plusgymnasietmalmo.se');

        $this->assertRegExp($regex, 'för_namn.efter-namn@montessoriskolan.com');
        $this->assertNotRegExp($regex, 'för_namn.efter-namn@elev.montessoriskolan.com');
    }

    public function testStudentEmail()
    {
        $regex = $this->student_regex;
        $this->assertRegExp($regex, 'utb12a@skola.malmo.se');
        $this->assertNotRegExp($regex, 'syv@malmo.se');
        $this->assertNotRegExp($regex, 'abc@abc.com');

        $this->assertNotRegExp($regex, 'för_namn.efter-namn@kunskapsgymnasiet.se');
        $this->assertRegExp($regex, 'xxx111@edu.kunskapsgymnasiet.se');

        $this->assertNotRegExp($regex, 'en_lärare.på-@plusgymnasiet.se');
        $this->assertRegExp($regex, 'en_elev.på-@plusgymnasietmalmo.se');

        $this->assertNotRegExp($regex, 'för_namn.efter-namn@montessoriskolan.com');
        $this->assertRegExp($regex, 'för_namn.efter-namn@elev.montessoriskolan.com');
    }

    public function testEduEmail()
    {
        $regex = $this->edu_regex;
        $this->assertRegExp($regex, 'utb12a@skola.malmo.se');
        $this->assertRegExp($regex, 'syv@malmo.se');
        $this->assertNotRegExp($regex, 'abc@abc.com');

        $this->assertRegExp($regex, 'för_namn.efter-namn@kunskapsgymnasiet.se');
        $this->assertRegExp($regex, 'xxx111@edu.kunskapsgymnasiet.se');

        $this->assertRegExp($regex, 'en_lärare.på-@plusgymnasiet.se');
        $this->assertRegExp($regex, 'en_elev.på-@plusgymnasietmalmo.se');

        $this->assertRegExp($regex, 'för_namn.efter-namn@montessoriskolan.com');
        $this->assertRegExp($regex, 'för_namn.efter-namn@elev.montessoriskolan.com');
    }

}
