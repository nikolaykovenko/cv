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

//	public $layout = '';

	/**
	 * Отображение списка элементов
	 * @param string $message сообщение для вывода
	 * @param string $messageClass класс сообщения
	 * @return string
	 * @throws \yii\base\Exception
	 */
	public function actionIndex($message = '', $messageClass = '')
	{
		$model = $this->getModel();
		$dataProvider = $this->getDataProvider($model);
		
		return $this->render(
			'index.php',
			['dataProvider' => $dataProvider, 'message' => $message, 'messageClass' => $messageClass ? : 'alert-info']
		);
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
		return $this->render('view', ['model' => $model]);
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
			$message = 'deleted ' . $id;
			$messageClass = 'alert-success';
		} catch (\Exception $e) {
		    $message = 'not deleted ' . $id;
			$messageClass = 'alert-error';
		}

		$modelName = \Yii::$app->helpers->shortClassName($model);
		return $this->redirect(['index', 'message' => $message, 'model' => $modelName, 'messageClass' => $messageClass]);
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
			return $this->render('form', ['model' => $model]);
		}
	}
}