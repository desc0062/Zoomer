<?php

namespace App\Tests\Controller\HomeController;

use App\Tests\Support\ControllerTester;

class IndexCest
{
    public function carousel(ControllerTester $I)
    {
        $I->amOnPage('/');
        $I->seeResponseCodeIsSuccessful();
        $I->seeNumberOfElements('.carousel-inner > .carousel-item > img', 3);
        $I->seeNumberOfElements('.carousel-inner > .carousel-item > .carousel-caption', 3);
    }

    public function navBar(ControllerTester $I)
    {
        $I->amOnPage('/');
        $I->seeResponseCodeIsSuccessful();
        $I->seeNumberOfElements('#mainNavigation > nav > .navbar-expand-md > #navbarNavDropdown > .navbar-nav > .nav-item', 4);
    }

    public function linkToHome(ControllerTester $I)
    {
        $I->amOnPage('/');
        $I->click('.navbar-nav > li:first-child > a');
        $I->seeResponseCodeIsSuccessful();
        $I->seeCurrentRouteIs('app_home');
    }
    /*public function linkToAnimal(ControllerTester $I){
        Code à implémenter
    }*/

    public function linkToActivities(ControllerTester $I)
    {
        $I->amOnPage('/');
        $I->click('.navbar-nav > li:nth-child(2) > a');
        $I->seeCurrentRouteIs('app_activity');
    }

    public function linkToAccount(ControllerTester $I)
    {
        $I->amOnPage('/');
        $I->click('.navbar-nav > li:last-child > a');
        $I->seeResponseCodeIsSuccessful();
        $I->seeCurrentRouteIs('app_user_account');
    }

    public function linkToLogin(ControllerTester $I)
    {
        $I->amOnPage('/');
        $I->click('.dropdown-menu > li:first-child > a');
        $I->seeResponseCodeIsSuccessful();
        $I->seeCurrentRouteIs('app_login');
    }

    public function linkToRegister(ControllerTester $I)
    {
        $I->amOnPage('/');
        $I->click('.dropdown-menu > li:last-child > a');
        $I->seeResponseCodeIsSuccessful();
        $I->seeCurrentRouteIs('app_register');
    }
}
