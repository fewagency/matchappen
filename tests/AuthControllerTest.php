<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AuthControllerTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testOccupationsFilters()
    {
        $this->visit('registrering')
            ->type("   socker\nbagare,  Art  Director ,\n \t copy--writer,åå ", 'workplace[occupations]')
            ->press('Registrera arbetsplats')
            ->seeInField('workplace[occupations]', 'socker,bagare,Art Director,copy-writer,åå');
    }
}
