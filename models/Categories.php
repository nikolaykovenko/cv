<?php

namespace app\models;

use Yii;

/**
 * Модель категорий
 *
 * @property integer $id
 * @property integer $rate
 * @property string $static
 * @property string $caption
 * @property integer $skills_matrix
 *
 * @property ParameterValues[] $parameterValues
 */
class Categories extends \app\ncmscore\models\ActiveModel
{
	/**
	 * @inheritdoc
	 */
	protected $fieldTypes = [
		'skills_matrix' => 'boolean',
		'rate' => 'integer',
        'id' => 'integer',
	];
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'categories';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rate', 'skills_matrix'], 'integer'],
            [['static', 'caption'], 'required'],
            [['static', 'caption'], 'string', 'max' => 255],
            [['static'], 'unique']
        ];
    }

	/**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'rate' => 'Rate',
            'static' => 'Static',
            'caption' => 'Caption',
            'skills_matrix' => 'Skills Matrix',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParameterValues()
    {
        return $this->hasMany(ParameterValues::className(), ['external_parent' => 'id']);
    }
}
