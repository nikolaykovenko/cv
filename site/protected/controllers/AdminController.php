<?php
/**
 * @package NCMS_Base
 * @author Nikolay Kovenko <nikolay.kovenko@gmail.com>
 * @date 07.10.14
 */

/**
 * Контроллер для редактирования моделей
 */
class AdminController extends CController {

 /**
  * @var string главный шаблон
  */
 public $layout = '//layouts/column2';

 /**
  * @var \NCMS\admin\AdminHelper
  */
 protected $adminHelper;

 /**
  * @var array правое меню
  */
 public $menu = array();

 public function __construct($id, $module = null)
 {
  parent::__construct($id, $module);

  Yii::setPathOfAlias('NCMS', Yii::getPathOfAlias('ext').'/NCMS');
  $this->adminHelper = new \NCMS\admin\AdminHelper();
  
  $this->menu = array(
	  array('label'=>'list', 'url'=>array('index', 'model'=>Yii::app()->request->getParam('model'))),
	  array('label'=>'add', 'url'=>array('add', 'model'=>Yii::app()->request->getParam('model')))
  );
 }


 /**
  * Действие по умолчанию
  * Вывд списка элементов модели
  * @param string $model
  */
 public function actionIndex($model = '')
 {
  if (!empty($model))
  {
   $model = new $model;
   $dataProvider = new CActiveDataProvider($model);

   $message = '';
   if (isset($_GET['deleted'])) $message = 'Элемент ID '.$_GET['deleted'].' успешно удален';

   $this->render('index', array('model'=>$model, 'dataProvider'=>$dataProvider, 'message'=>$message));
  }
  else $this->render('text', array('caption'=>'Добро пожаловать!', 'text'=>'Вас првиетствует NCMS4! Пожалуйста, выберите интересующий Вас раздел в главном меню =>>'));
 }

 /**
  * Вывод полной информации о элементе
  * @param string $model
  * @param int $id
  * @throws Exception если элемент не найден
  */
 public function actionView($model, $id)
 {
  /** @var BaseActiveRecord $item */
  $item = $model::model()->findByPk($id);
  if (empty($item)) throw new CHttpException(404);
  $item->scenario = 'fullItemView';
  
  $renderer = new \NCMS\admin\FullViewItemRenderer($item);

  $this->render('simpleRenderer', array('renderer'=>$renderer, 'itemsList'=>$this->renderItemList($item)));
 }

 /**
  * Добавление нового элемента
  * @param string $model
  */
 public function actionAdd($model)
 {
  /** @var BaseActiveRecord $model */
  $model = new $model();
  if ($this->saveModel($model)) $this->redirect('index.php?r=admin/edit&model='.get_class($model).'&id='.$model->id);

  $renderer = new NCMS\admin\EditFormRenderer($model);
  
  $this->render('simpleRenderer', array('renderer'=>$renderer, 'itemsList'=>$this->renderItemList($model)));
 }

 /**
  * Редактирование элемента
  * @param string $model
  * @param int $id
  * @throws Exception если элемент не найден
  */
 public function actionEdit($model, $id)
 {
  /** @var BaseActiveRecord $model */
  $model = new $model();
  $model = $model->findByPk($id);
  if (empty($model)) throw new CHttpException(404);
  if ($this->saveModel($model)) $this->redirect('index.php?r=admin/edit&model='.get_class($model).'&id='.$model->id);
  
  $renderer = new NCMS\admin\EditFormRenderer($model);

  $this->render('simpleRenderer', array('renderer'=>$renderer, 'itemsList'=>$this->renderItemList($model)));
 }

 /**
  * Удаление элемента
  * @param string $model
  * @param int $id
  * @throws Exception если элемент не найден
  */
 public function actionDelete($model, $id)
 {
  /** @var BaseActiveRecord $model */
  $model = $model::model()->findByPk($id);
  if (empty($model)) throw new CHttpException(404);
  
  if ($model->delete()) $this->redirect('index.php?r=admin/index&model='.get_class($model).'&deleted='.$id);

  throw new Exception('Ошибко');
 }

 
 
 
 
 /**
  * Заполняет модель значениеями из формы и сохраняет
  * @param BaseActiveRecord $model
  * @returns bool
  */
 private function saveModel(BaseActiveRecord $model)
 {
  if (!empty($_POST[get_class($model)]))
  {
   $values = $_POST[get_class($model)];
   $model->attributes = $values;
   if ($model->validate()) return $model->save(false);
  }
  
  return false;
 }

 /**
  * Возвращает таблицу элементов для модели
  * @param BaseActiveRecord $model
  * @throws CException
  * @returns string
  */
 private function renderItemList(BaseActiveRecord $model)
 {
  $dataProvider = new CActiveDataProvider($model);
  return $this->renderPartial('index', array('model'=>$model, 'dataProvider'=>$dataProvider, 'message'=>''), true); 
 }
}