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
        $this->assertNotRegExp($this->supervisor_regex, 'utb123@skola.malmo.se');
        $this->assertRegExp($this->supervisor_regex, 'syv@malmo.se');
        $this->assertNotRegExp($this->supervisor_regex, 'abc@abc.com');
    }

    public function testStudentEmail()
    {
        $this->assertRegExp($this->student_regex, 'utb123@skola.malmo.se');
        $this->assertNotRegExp($this->student_regex, 'syv@malmo.se');
        $this->assertNotRegExp($this->student_regex, 'abc@abc.com');
    }

    public function testEduEmail()
    {
        $this->assertRegExp($this->edu_regex, 'utb123@skola.malmo.se');
        $this->assertRegExp($this->edu_regex, 'syv@malmo.se');
        $this->assertNotRegExp($this->edu_regex, 'abc@abc.com');
    }


}
