<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "parameter_values".
 *
 * @property integer $id
 * @property integer $external_parent
 * @property string $caption
 * @property string $value
 * @property integer $rate
 * @property integer $in_new_column
 *
 * @property Categories $externalParent
 * @property Skills[] $skills
 */
class ParameterValues extends \app\ncmscore\models\ActiveModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'parameter_values';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['external_parent', 'caption', 'value'], 'required'],
            [['external_parent', 'rate', 'in_new_column'], 'integer'],
            [['caption', 'value'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'external_parent' => 'External Parent',
            'caption' => 'Caption',
            'value' => 'Value',
            'rate' => 'Rate',
            'in_new_column' => 'In New Column',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExternalParent()
    {
        return $this->hasOne(Categories::className(), ['id' => 'external_parent']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSkills()
    {
        return $this->hasMany(Skills::className(), ['external_parent' => 'id']);
    }
}
