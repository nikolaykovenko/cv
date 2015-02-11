<?php
/**
 * @package NCMS
 * @author Nikolay Kovenko <nikolay.kovenko@gmail.com>
 * @date 17.11.14
 */

namespace app\ncmscore\controllers;

use app\models\User;
use app\ncmscore\core\Helpers;
use app\ncmscore\models\ActiveModel;
use app\ncmscore\models\LoginForm;
use SebastianBergmann\Exporter\Exception;
use Yii;
use yii\db\mysql\QueryBuilder;
use yii\filters\AccessControl;

/**
 * Базовый класс админки
 */
class BaseAdminController extends BaseController
{

    /**
     * @var string сообщение для вывода
     */
    public $message = '';

    /**
     * @var string класс алерта сообщения
     */
    public $messageClass = 'alert-info';

    /**
     * @var string шаблон
     */
    public $layout = 'admin';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'denyCallback' => function () {
                    $this->redirect(['admin/login']);
                },
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

//		TODO: Вынести в конфиг после создания отдельного приложения для админки
        Yii::$app->set('urlManager', 'app\ncmscore\core\admin\UrlManager');
        Yii::$app->set('formatter', 'app\ncmscore\core\admin\Formatter');
    }


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
        $this->setAutoScenario($model, 'update');

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
        $this->setAutoScenario($model, 'create');

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
     * Форма авторизации
     * @return string
     */
    public function actionLogin()
    {
        $form = new LoginForm();
        $form->setUserModel(new User());
        
        if ($form->load(Yii::$app->request->post()) and $form->login()) {
            $this->redirect(['/admin']);
        }
        
        return $this->renderPartial('@ncms-core-views/admin/login', ['loginForm' => $form]);
    }

    /**
     * Logout
     * @return void
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        $this->redirect(['/admin']);
    }

    /**
     * Возвращает название модели
     * @return string|null
     */
    public function getModelName()
    {
        return Helpers::getAdminModelName();
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

    /**
     * Проверяет наличие у модели стандартного сценария, в случае успеха - устанавливает его
     * @param ActiveModel $model
     * @param string $scenario
     * @return bool
     */
    private function setAutoScenario(ActiveModel $model, $scenario)
    {
        if (array_key_exists($scenario, $model->scenarios())) {
            $model->scenario = $scenario;
            return true;
        }
        
        return false;
    }
}
