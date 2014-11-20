<?php
/**
 * @package NCMS
 * @author Nikolay Kovenko <nikolay.kovenko@gmail.com>
 * @date 17.11.14
 */

namespace app\ncmscore\controllers;

use app\ncmscore\models\ActiveModel;
use yii\base\Exception;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Базовый контроллер
 */
abstract class BaseController extends Controller {

	/**
	 * @var null|ActiveModel
	 */
	protected $model;

	/**
	 * Возвращает название модели
	 * @return string|null
	 */
	abstract public function getModelName();
	
	/**
	 * Возвращает главную модель контроллера
	 * @param int|null $itemId
	 * @return ActiveModel|null
	 * @throws Exception если не найдена
	 */
	protected function getModel($itemId = null)
	{
		if (is_null($this->model)) {
			$modelName = $this->getModelName();
			if (empty($modelName)) throw new Exception('empty model param');

			$fullModelName = 'app\models\\'.ucfirst(strtolower($modelName));
			if (!class_exists($fullModelName)) throw new Exception('model ' . $fullModelName . 'not exists');

			$this->model = new $fullModelName;
			if (!is_null($itemId)) {
				$this->model = $this->model->findOne($itemId);
				if (is_null($this->model)) throw new NotFoundHttpException;
			}
		}

		return $this->model;
	}

	/**
	 * Возвращает стандартный DataProvider
	 * @param ActiveModel $model
	 * @param int|null $pageSize
	 * @return ActiveDataProvider
	 */
	protected function getDataProvider(ActiveModel $model, $pageSize = null)
	{
		if (is_null($pageSize)) $pageSize = \Yii::$app->params['pageSize'];
		
		return new ActiveDataProvider([
			'query' => $model::find(),
			'pagination' => [
				'pageSize' => $pageSize
			]
		]);
	}
}