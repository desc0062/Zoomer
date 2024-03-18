<?php

namespace App\Tests\Controller;

use App\Tests\Support\ControllerTester;

class LoginCest
{
    public function form(ControllerTester $I)
    {
        $I->amOnPage('/login');
        $I->seeResponseCodeIsSuccessful();
        $I->seeNumberOfElements('form > input', 3);
        $I->seeNumberOfElements('form > label', 2);
    }
}
