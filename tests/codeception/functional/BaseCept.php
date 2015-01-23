<?php
$I = new FunctionalTester($scenario);
$I->amOnPage('/');


$I->wantToTest('Category in DB exists');
$I->seeRecord('\app\models\Categories', ['caption' => 'Personal data']);


$I->wantToTest('Category from db is at the page');
$cat = $I->grabRecord('\app\models\Categories');
$I->see($cat->caption, 'h2');

