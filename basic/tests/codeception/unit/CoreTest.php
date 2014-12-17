<?php
/**
 * @package NCMS
 * @author Nikolay Kovenko <nikolay.kovenko@gmail.com>
 * @date 15.12.14
 */

use \Codeception\Util\Debug;

/**
 * Тестирование базовых элементов ядра
 */
class CoreTest extends yii\codeception\TestCase {

	/**
	 * Тестирование базовых хелперов ядра
	 */
	public function testCoreHelpers()
	{
		/** Видимость полей формы */
		
		/**
		 * Модель из ядра
		 */
		$model = new \app\models\Categories();
		$helper = new \app\ncmscore\core\Helpers();
		
		$this->assertFalse($helper->isFieldVisible('id', $model, $helper::VIEW_TYPE_UPDATE));
		$this->assertTrue($helper->isFieldVisible('id', $model, $helper::VIEW_TYPE_VIEW));
		$this->assertTrue($helper->isFieldVisible('caption', $model));
		
		
		/** Определение краткого названия класса */
		$this->assertEquals('categories', $helper->shortClassName($model));
		
		
		/** Получение названия модели из get */
		$request = $this->getMock('\yii\web\Request');
		$request
			->expects($this->once())
			->method('get')
			->with('model')
			->willReturn('categories');

		
		$this->assertEmpty($helper->getAdminModelName());
		
		Yii::$app->set('request', $request);
		$this->assertEquals('categories', $helper->getAdminModelName());
	}

	/**
	 * Тестирование компонента для определения типов полей
	 */
	public function testModelColumnExploder()
	{
		$model = new \app\models\Categories();
		$exploder = new \app\ncmscore\core\ModelColumnsExploder();
		
		/** Тестирование обычного формата */
		$columns = $exploder->getAttributes($model);
		
		$this->assertNotEmpty($columns['id']);
		$this->assertNotEmpty($columns['caption']);
		$this->assertEquals('integer', $columns['id']['type']);
		$this->assertEquals('html', $columns['caption']['type']);
		
		
		/** Тестирвание формата для виджетов */
		$columns = $exploder->getViewAttributes($model);
		
		$this->assertTrue(in_array('id:integer', $columns));
		$this->assertTrue(in_array('caption:html', $columns));
	}

	/**
	 * Тестирование Url менеджера для админки
	 */
	public function testAdminUrlManager()
	{
		$controller = $this->getMock('\app\ncmscore\controllers\BaseAdminController', [], ['base-admin', null]);
		$controller
			->expects($this->atLeastOnce())
			->method('getModelName')
			->willReturn('categories');


		Yii::$app->controller = $controller;
		Yii::$app->set('urlManager', 'app\ncmscore\core\admin\UrlManager');

		$urlManager = Yii::$app->getUrlManager();
		$url = $urlManager->createUrl('test');

		$this->assertRegExp("/model=categories/", $url);
	}
}