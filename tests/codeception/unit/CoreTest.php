<?php
/**
 * @package NCMS
 * @author Nikolay Kovenko <nikolay.kovenko@gmail.com>
 * @date 15.12.14
 */

use \Codeception\Util\Debug;
use \app\models\User;
use \AspectMock\Test;

/**
 * Тестирование базовых элементов ядра
 */
class CoreTest extends yii\codeception\TestCase
{

    protected function setUp()
    {
        parent::setUp();
        Test::clean();
        $this->transaction = \Yii::$app->db->beginTransaction();
    }


    protected function tearDown()
    {
        parent::tearDown();
        $this->transaction->rollBack();
    }


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
        $this->assertEquals('Categories', $helper->shortClassName($model));


        /** Получение названия модели из get */
        $request = $this->getMock('\yii\web\Request');
        $request
            ->expects($this->once())
            ->method('get')
            ->with('model')
            ->willReturn('Categories');


        $this->assertEmpty($helper->getAdminModelName());

        Yii::$app->set('request', $request);
        $this->assertEquals('Categories', $helper->getAdminModelName());
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

    /**
     * Тестирование генератора хеша паролей
     */
    public function testPasswordGenerator()
    {
        $helper = new \app\ncmscore\core\Helpers();
        $this->assertEmpty($helper->generatePasswordHash(''));
        
        $password = '123';
        $this->assertTrue(Yii::$app->getSecurity()->validatePassword($password, '$2y$13$P/gl10LS4aJaMqOOYCKX5uEuDRXUYRLrj1GjebX3Q5VkJKX9QhIpm'));
    }

    /**
     * Тестирование авторизации и модели администраторов
     */
    public function testUser()
    {
//        Поиск и удаление старой учетной записи администратора
        $user = User::findByUsername('admin');
        if (!empty($user)) {
            $deleteResult = $user->delete();
            
            $this->assertNotFalse($deleteResult);
            $this->assertGreaterThan(0, $deleteResult);
        }
        
        $this->assertEmpty(User::findByUsername('admin'));
        
        $user = new User();
        
//        Добавление новой учетной записи
        $user->username = 'admin';
        $user->password_hash = '111';
        $user->password_hash_repeat = '1112';
        $this->assertFalse($user->save());
        
        $user->password_hash_repeat = '111';
        $this->assertTrue($user->save());
        $this->assertNotEmpty($user->id);
        
        
//        Изменение пароля администратора
        $oldId = $user->id;
        $oldPass = $user->password_hash;
        $this->assertNotEquals('111', $oldPass);
        
        $user->password_hash = '123';
        $user->password_hash_repeat = '123';
        $this->assertTrue($user->save());
        $this->assertNotEquals('123', $user->password_hash);
        $this->assertNotEquals($oldPass, $user->password_hash);
        $this->assertEquals($oldId, $user->id);
        
        
//        Изменение логина администратора без пароля
        $user = User::findByUsername('admin');
        $auth = [
            'username' => 'admin',
            'password_hash' => '',
            'password_hash_repeat' => '',
        ];
        $user->attributes = $auth;
        $this->assertTrue($user->save());
        
//        Попытка сохранить новую учетную запись без пароля
        $user = new User();
        $user->scenario = 'create';
        $user->attributes = $auth;
        $this->assertFalse($user->save());
        
        
        
//        Тестирование аутентификации
        $auth = [
            'username' => 'admin',
            'password' => '1234',
        ];
        
        $loginForm = new \app\ncmscore\models\LoginForm();
        $loginForm->setUserModel(new User());
        
        $loginForm->attributes = $auth;
        $this->assertFalse($loginForm->login());
        
        $loginForm->password = '123';
        $this->assertTrue($loginForm->login());
        
        
//        Тестирование логаута
        $LoggedUserId = Yii::$app->user->getId();
        $this->assertGreaterThan(0, $LoggedUserId);
        Yii::$app->user->logout();
        $this->assertNull(Yii::$app->user->getId());
    }

    /**
     * Тестирование модуля параметров конфигурации
     */
    public function testAppSettings()
    {
        $modelName = '\app\models\Settings';
        
        $query = Test::double(new \yii\db\ActiveQuery($modelName), ['all' => [
            (object) ['id' => 2, 'param' => 'home_url', 'value' => 'url_of_home_page'],
        ]]);
        $this->assertCount(1, $query->all());
        
        Test::double($modelName, ['find' => $query]);
        
        /** @var \app\ncmscore\core\Config $settings */
        $settings = Yii::$app->get('appSettings');
        $settings->setModel(new $modelName());
        
        $this->assertEquals('url_of_home_page', $settings->param('home_url'));
        $this->assertEmpty($settings->param('test_param'));
        $query->verifyInvokedMultipleTimes('all', 2);
    }
}