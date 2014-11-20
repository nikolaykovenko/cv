<?php
/**
 * @package NCMS
 * @author Nikolay Kovenko <nikolay.kovenko@gmail.com>
 * @date 17.11.14
 */

namespace app\ncmscore\controllers;

use app\ncmscore\models\ActiveModel;

/**
 * Базовый класс админки
 */
class BaseAdminController extends BaseController {

	/**
	 * @var string сообщение для вывода
	 */
	public $message = '';

	/**
	 * @var string класс алерта сообщения
	 */
	public $messageClass = 'alert-info';

//	public $layout = '';

	/**
	 * Отображение списка элементов
	 * @return string
	 * @throws \yii\base\Exception
	 */
	public function actionIndex()
	{
		$model = $this->getModel();
		$dataProvider = $this->getDataProvider($model);
		
		return $this->render('index.php', ['dataProvider' => $dataProvider]);
	}

	/**
	 * Обновление элемента
	 * @param int $id
	 * @return string|\yii\web\Response
	 * @throws \yii\base\Exception
	 * @throws \yii\web\NotFoundHttpException
	 */
	public function actionUpdate($id)
	{
		$model = $this->getModel($id);
		return $this->saveModel($model, \Yii::$app->request->post());
	}

	/**
	 * Создание элемента
	 * @return string|\yii\web\Response
	 * @throws \yii\base\Exception
	 * @throws \yii\web\NotFoundHttpException
	 */
	public function actionCreate()
	{
		$model = $this->getModel();
		return $this->saveModel($model, \Yii::$app->request->post());
	}

	/**
	 * Просмотр элемента
	 * @param int $id
	 * @return string|\yii\web\Response
	 * @throws \yii\base\Exception
	 * @throws \yii\web\NotFoundHttpException
	 */
	public function actionView($id)
	{
		$model = $this->getModel($id);
		return $this->render('view', ['model' => $model, 'dataProvider' => $this->getDataProvider($model)]);
	}

	/**
	 * Удаляет элемент
	 * @param $id
	 * @return \yii\web\Response
	 */
	public function actionDelete($id)
	{
		$model = $this->getModel($id);
		
		try {
			$model->delete();
			$this->message = 'deleted ' . $id;
			$this->messageClass = 'alert-success';
		} catch (\Exception $e) {
		    $this->message = 'not deleted ' . $id;
			$this->messageClass = 'alert-error';
		}

		$modelName = \Yii::$app->helpers->shortClassName($model);
		return $this->redirect(['index', 'model' => $modelName]);
	}

	/**
	 * Возвращает название модели
	 * @return string|null
	 */
	public function getModelName()
	{
		$result = \Yii::$app->request->get('model');
		if (empty($result)) return null;
		return $result;
	}
	
	


	/**
	 * Сохраняет модель с переданными значениями и проводит редирект на страницу просмотра или рендерит форму заново
	 * @param ActiveModel $model модель
	 * @param array $values новые значения
	 * @return string|\yii\web\Response
	 */
	private function saveModel(ActiveModel $model, array $values)
	{
		$modelName = \Yii::$app->helpers->shortClassName($model);
		
		if ($model->load($values) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->id, 'model' => $modelName]);
		} else {
			return $this->render('form', ['model' => $model, 'dataProvider' => $this->getDataProvider($model)]);
		}
	}
}