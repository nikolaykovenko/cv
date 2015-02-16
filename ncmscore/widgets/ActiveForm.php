<?php
/**
 * @package NCMS
 * @author Nikolay Kovenko <nikolay.kovenko@gmail.com>
 * @date 18.11.14
 */

namespace app\ncmscore\widgets;

use app\ncmscore\core\ModelColumnsExploder;
use app\ncmscore\models\ActiveModel;
use yii\base\Exception;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveField;

/**
 * Автоматическое построение стандартной формы на основе модели
 */
class ActiveForm extends \yii\widgets\ActiveForm
{

    /**
     * @var bool флаг отображения кнопки submit
     */
    public $showSubmit = true;

    /**
     * @var ActiveModel|null
     */
    protected $model;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        ob_start();
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        parent::run();
        echo $this->generateInputs() . ob_get_clean();
    }


    /**
     * Устанавливает
     * @param ActiveModel|null $model
     * @return $this
     */
    public function setModel(ActiveModel $model = null)
    {
        $this->model = $model;

        return $this;
    }


    /**
     * Генерирует список полея для ввода
     * @return string
     * @throws Exception
     */
    protected function generateInputs()
    {
        if (is_null($this->model)) {
            throw new Exception('Model error');
        }

        /** @var \app\ncmscore\core\Helpers $helpers */
        $helpers = \Yii::$app->helpers;
        $result = '';

        $attributes = ModelColumnsExploder::getAttributes($this->model);
        foreach ($this->model->attributes as $attr => $value) {
            if ($helpers->isFieldVisible($attr, $this->model)) {
                $attrItem = $attributes[$attr];

                $result .= $this->makeField($attr, $attrItem);
            }
        }

        if ($this->showSubmit) {
            $result .= '<div class="form-group">' .
                Html::submitButton(
                    $this->model->isNewRecord ? 'Создать' : 'Обновить',
                    ['class' => $this->model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
                ) .
                '</div>';
        }

        return $result;
    }


    /**
     * Генерирует activeField нужного типа
     * @param string $attr
     * @param array $attrItem
     * @return \yii\widgets\ActiveField
     */
    private function makeField($attr, $attrItem)
    {
        $result = $this->field($this->model, $attr);

        switch ($attrItem['type']) {
            case 'boolean':
                $result->checkbox();
                break;

            case 'integer':
                $result->input('number');
                break;

            case 'email':
                $result->input($attrItem['type']);
                break;

            case 'relation':
                $getterName = ModelColumnsExploder::getterAttributeMethodName($attr);

                /** @var ActiveQuery $query */
                $className = $this->model->$getterName()->modelClass;
                /** @var ActiveModel $obj */
                $model = new $className();

                $dropDown = ArrayHelper::getColumn(
                    $model::find()->select(['id', 'caption'])->indexBy('id')->asArray()->all(),
                    'caption'
                );
                $result->dropDownList($dropDown);
                break;

            case 'longhtml':
                $result->textarea();
                break;
            
            case 'password':
                $repeatAttr = $attr . '_repeat';
                
                $this->model->$attr = '';
                $this->model->$repeatAttr = '';
                $result->passwordInput();
                
                $repeatPass = $this->field($this->model, $repeatAttr)->passwordInput();
                $result = $result . $repeatPass;
                
                break;
        }

        return $result;
    }
}
