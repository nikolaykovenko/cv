<?php
/**
 * @package NCMS
 * @author Nikolay Kovenko <nikolay.kovenko@gmail.com>
 * @date 17.12.14
 */

use Codeception\Util\Debug;
use \app\ncmscore\widgets\DetailView;
use \app\ncmscore\widgets\GridView;
use app\ncmscore\widgets\ActiveForm;

/**
 * Тестирование виджетов ядра
 */
class CoreWidgetsTest extends \yii\codeception\TestCase
{

    /**
     * @var \app\models\Categories
     */
    protected $model;

    protected function setUp()
    {
        parent::setUp();

        $this->model = $this->getMock('\app\models\Categories', null);
        Yii::$app->controller = new \app\controllers\AdminController('admin', Yii::$app);

        $request = $this->getMock('\yii\web\Request', ['resolveRequestUri']);
        $request
            ->expects($this->any())
            ->method('resolveRequestUri')
            ->willReturn('');

        $request->cookieValidationKey = 'someValue';

        Yii::$app->set('request', $request);
    }


    /**
     * Тестирование виджета детального просмотра
     */
    public function testDetailView()
    {
        $model = $this->model;
        $item = $model::find()->one();

        $result = DetailView::widget([
            'model' => $item,
        ]);

        $this->assertRegExp("/<tr><th>ID<\/th><td>{$item->id}<\/td><\/tr>/", $result);
        $this->assertRegExp("/<tr><th>Caption<\/th><td>" . preg_quote($item->caption) . "<\/td><\/tr>/", $result);
        $this->assertRegExp("/<a[\s]+href=\"[^\"]+delete[^\"]+id={$item->id}\"/", $result);
        $this->assertRegExp("/<a[\s]+href=\"[^\"]+update[^\"]+id={$item->id}\"/", $result);
    }

    /**
     * Тестирование виджета списка
     */
    public function testGridView()
    {
        $model = $this->model;
        $firstItem = $model::find()->one();
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $model::find(),
        ]);
        $result = GridView::widget([
            'dataProvider' => $dataProvider,
        ]);


        $trCount = preg_match_all("/<tr data-key=/", $result);

        $this->assertRegExp("/<tr data-key=\"{$firstItem->id}\">/", $result);
        $this->assertRegExp("/<td>" . preg_quote($firstItem->caption) . "<\/td>/", $result);
        $this->assertRegExp("/<a[\s]+href=\"[^\"]+delete[^\"]+id={$firstItem->id}\"/", $result);
        $this->assertRegExp("/<a[\s]+href=\"[^\"]+update[^\"]+id={$firstItem->id}\"/", $result);
        $this->assertLessThanOrEqual($dataProvider->pagination->pageSize, $trCount);
    }

    /**
     * Тестирование виджета активной формы
     */
    public function testActiveForm()
    {
        $model = $this->model;
        $firstItem = $model::find()->one();

        $createForm = ActiveForm::widget([
            'model' => $model,
        ]);

        $updateForm = ActiveForm::widget([
            'model' => $firstItem,
        ]);


        $this->assertContains('Создать', $createForm);
        $this->assertContains('Обновить', $updateForm);

        $this->assertNotRegExp("/<input[^\>]+type=\"text\"[^\>]+value=\"[^\"]+\"/", $createForm);
        $this->assertRegExp("/<input[^\>]+type=\"text\"[^\>]+value=\"[^\"]+\"/", $updateForm);
    }
}