<?php

namespace App\Tests\Controller;

use App\Tests\Support\ControllerTester;

class RegisterCest
{
    public function form(ControllerTester $I)
    {
        $I->amOnPage('/register');
        $I->seeResponseCodeIsSuccessful();
        $I->seeNumberOfElements('form > div > div > div > input', 4);
        $I->seeNumberOfElements('form > div > div > div > label', 4);
        $I->seeNumberOfElements('form > div > div > input', 1);
        $I->seeNumberOfElements('form > div > div > label', 1);
        $I->seeNumberOfElements('form > div > button', 1);
    }

    // tests
    public function image(ControllerTester $I)
    {
        $I->amOnPage('/register');
        $I->seeResponseCodeIsSuccessful();
        $I->seeNumberOfElements('.img-fluid', 1);
    }
}
