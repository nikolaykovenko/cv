<?php

namespace app\models;

use Yii;

/**
 * Таблица скилов
 *
 * @property integer $id
 * @property integer $external_parent
 * @property string $caption
 * @property integer $years
 * @property string $level
 * @property integer $rate
 *
 * @property ParameterValues $externalParent
 */
class Skills extends \app\ncmscore\models\ActiveModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'skills';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['external_parent', 'caption', 'years', 'level'], 'required'],
            [['external_parent', 'years', 'rate'], 'integer'],
            [['caption'], 'string', 'max' => 255],
            [['level'], 'string', 'max' => 32]
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
            'years' => 'Years',
            'level' => 'Level',
            'rate' => 'Rate',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExternalParent()
    {
        return $this->hasOne(ParameterValues::className(), ['id' => 'external_parent'])->orderBy('rate desc');
    }
}
