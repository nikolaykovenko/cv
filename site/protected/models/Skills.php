<?php

/**
 * This is the model class for table "skills".
 *
 * The followings are the available columns in table 'skills':
 * @property string $id
 * @property string $external_parent
 * @property string $caption
 * @property string $years
 * @property string $level
 * @property integer $rate
 *
 * The followings are the available model relations:
 * @property ParameterValues $externalParent
 */
class Skills extends BaseActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'skills';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('external_parent, caption, years, level', 'required'),
			array('rate', 'numerical', 'integerOnly'=>true),
			array('external_parent, years', 'length', 'max'=>10),
			array('caption', 'length', 'max'=>255),
			array('level', 'length', 'max'=>32),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, external_parent, caption, years, level, rate', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'externalParent' => array(self::BELONGS_TO, 'ParameterValues', 'external_parent'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'external_parent' => 'External Parent',
			'caption' => 'Caption',
			'years' => 'Years',
			'level' => 'Level',
			'rate' => 'Rate',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('external_parent',$this->external_parent,true);
		$criteria->compare('caption',$this->caption,true);
		$criteria->compare('years',$this->years,true);
		$criteria->compare('level',$this->level,true);
		$criteria->compare('rate',$this->rate);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Skills the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
