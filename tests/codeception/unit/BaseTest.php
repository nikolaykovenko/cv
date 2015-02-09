<?php

use \app\models\Categories;
use Codeception\Util\Debug;
use \Codeception\Util\Stub;

class BaseTest extends yii\codeception\TestCase
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @var \yii\db\Transaction
     */
    protected $transaction;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    protected function setUp()
    {
        parent::setUp();
        $this->transaction = \Yii::$app->db->beginTransaction();
    }


    protected function tearDown()
    {
        parent::tearDown();
        $this->transaction->rollBack();
    }


    /**
     * Category testing
     */
    public function testCategories()
    {
//        $category = new Stub('Categories');

		$item = Categories::findOne(['caption' => 'Personal data']);
		$this->assertEquals($item->caption, 'Personal data');
		
		$item = new Categories();
		$item->caption = 'New Category';
		$item->static = 'new-cat';
		
		$this->assertEquals($item->validate(), true);
        $item->save();
        $this->assertNotEmpty($item->id);
        
        $item = new Categories();
        $item->caption = 'New Category';
        $item->static = 'new-cat';

        $this->assertEquals($item->validate(), false, 'The same category is validated');
        $item->save();
        $this->assertEmpty($item->id, 'The same category is saved');
        
        
        $lastCategory = Categories::find()->orderBy('id desc')->one();
        
        Debug::debug($lastCategory->caption);
    }
}