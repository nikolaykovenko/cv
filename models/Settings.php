<?php

namespace app\models;

use \app\ncmscore\models\ActiveModel;
use Yii;

/**
 * This is the model class for table "settings".
 *
 * @property integer $id
 * @property string $param
 * @property string $value
 * @property bool $locked
 */
class Settings extends ActiveModel
{
    
    /**
     * @inheritdoc
     */
    protected $fieldTypes = [
        'id' => 'integer',
        'param' => 'text',
        'value' => 'text',
        'locked' => 'boolean',
    ];

    /**
     * @inheritdoc
     */
    protected $hiddenFields = [
        'id' => ['update', 'create'],
        'locked' => ['update', 'create'],
    ];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        
        $this->on(static::EVENT_BEFORE_DELETE, function () {
            if ($this->locked) {
                throw new \Exception('Вы не можете удалить системную переменную');
            }
        });
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'settings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['param', 'value'], 'required'],
            [['value'], 'string'],
            [['param'], 'match', 'pattern' => '/^[a-zA-Z0-9-_]+$/'],
            [['param'], 'changeLockedParamValidation', 'when' => function (ActiveModel $model, $attribute) {
                return ((bool) $model->locked and $model->getOldAttribute($attribute) != $model->$attribute);
            }],
            [['param'], 'string', 'max' => 255],
            [['param'], 'unique'],
            [['locked'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'param' => 'Параметр',
            'value' => 'Значение',
            'locked' => 'Системная переменная',
        ];
    }

    /**
     * @inheritdoc
     */
    public static function find()
    {
        return parent::find()->orderBy('param');
    }

    /**
     * Правило валидации. Попытка изменить системный параметр
     * @param string $attribute параметр
     * @return bool
     */
    public function changeLockedParamValidation($attribute)
    {
        $this->addError($attribute, 'Извините, Вы не можете изменять системные параметры');
        return false;
    }
}
