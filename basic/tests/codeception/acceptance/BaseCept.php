<?php 
$I = new AcceptanceTester($scenario);
$I->wantToTest('If main nav exist');

$I->amOnPage('/');
$I->seeElement('.navbar');
$I->seeElement('.navbar a[href="#personal-data"]');


$I->wantToTest('Headers exist');
$I->seeElement('h1');
$I->seeElement('h2');


$I->wantToTest('Skill matrix exist');
$I->seeElement('.main-section > #skills-matrix');


$I->wantToTest('Check github link');
$I->seeElement('a[href*="github"]');
$I->click('a[href*="github"]');
$I->see('GitHub');


$I->wantToTest('404 error');
$I->amOnPage('bla-bla');
$I->seePageNotFound();


$I->wantToTest('Page title');
$I->amOnPage('/');
$I->seeInTitle('Nikolay Kovenko');