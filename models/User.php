<?php

namespace app\models;

use app\ncmscore\models\ActiveModel;

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
        return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        foreach (self::$users as $user) {
            if (strcasecmp($user['username'], $username) === 0) {
                return new static($user);
            }
        }

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
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
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
     * @inheritdoc
     */
    public function update($runValidation = true, $attributeNames = null)
    {
//        TODO: Провести рефакторинг, добавить тесты
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
//        TODO: Провести рефакторинг, добавить тесты
        
        if (!empty($this->password_hash) and $this->password_hash == $this->password_hash_repeat) {
            $this->password_hash = \Yii::$app->helpers->generatePasswordHash($this->password_hash);
            $this->password_hash_repeat = $this->password_hash;
        }
        
        return parent::insert($runValidation, $attributes);
    }
}
