<?php

namespace app\models;

use app\ncmscore\models\ActiveModel;
use yii\db\ActiveRecord;

/**
 * Модель администратора
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_hash_repeat
 */
class User extends ActiveModel implements \yii\web\IdentityInterface
{
    /**
     * @var string
     */
    public $password_hash_repeat = '';
    
    /**
     * @inheritdoc
     */
    protected $fieldTypes = [
        'id' => 'integer',
        'password_hash' => 'password',
    ];

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return false;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
//        TODO: Добавить тесты валидации модели
        return [
            [['username', 'password_hash', 'password_hash_repeat'], 'required'],
            [['username', 'password_hash', 'password_hash_repeat'], 'string', 'max' => 255],
            [['password_hash'], 'compare', 'compareAttribute' => 'password_hash_repeat'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Логин',
            'password_hash' => 'Пароль',
            'password_hash_repeat' => 'Повторение пароля',
        ];
    }

    /**
     * @inheritdoc
     */
    public static function find()
    {
        return parent::find()->orderBy('id');
    }

    /**
     * Поиск пользователя по имени
     * @param string $username
     * @return ActiveRecord|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * Проверяет введенный пароль с текущим паролем пользователя
     * @param string $password
     * @return bool
     * @throws \yii\base\InvalidConfigException
     */
    public function validatePassword($password)
    {
        return \Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * @inheritdoc
     */
    public function update($runValidation = true, $attributeNames = null)
    {
//        TODO: Провести рефакторинг, добавить тесты, function beforeSave
        if (empty($this->password_hash) and empty($this->password_hash_repeat)) {
            $this->password_hash = $this->getOldAttribute('password_hash');
            $this->password_hash_repeat = $this->password_hash;
        } elseif (!empty($this->password_hash) and $this->password_hash == $this->password_hash_repeat) {
            $this->password_hash = \Yii::$app->helpers->generatePasswordHash($this->password_hash);
            $this->password_hash_repeat = $this->password_hash;
        }
        
        return parent::update($runValidation, $attributeNames);
    }

    /**
     * @inheritdoc
     */
    public function insert($runValidation = true, $attributes = null)
    {
//        TODO: Провести рефакторинг, добавить тесты, function beforeSave
        
        if (!empty($this->password_hash) and $this->password_hash == $this->password_hash_repeat) {
            $this->password_hash = \Yii::$app->helpers->generatePasswordHash($this->password_hash);
            $this->password_hash_repeat = $this->password_hash;
        }
        
        return parent::insert($runValidation, $attributes);
    }
}
