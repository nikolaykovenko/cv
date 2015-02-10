<?php
namespace app\ncmscore\models;

use app\models\User;
use Yii;
use yii\base\InvalidValueException;
use yii\base\Model;
use yii\filters\auth\AuthInterface;

/**
 * Форма авторизции
 */
class LoginForm extends Model
{

    /**
     * @var string
     */
    public $username;

    /**
     * @var string
     */
    public $password;

    /**
     * @var bool
     */
    public $rememberMe = true;

    /**
     * @var User модель, отвечающая за хранение учетных записей
     */
    private $userModel;

    /**
     * @var bool|AuthInterface учетная запись пользователя
     */
    private $user = false;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     */
    public function validatePassword($attribute)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->user === false) {
            $model = $this->getUserModel();
            $this->user = $model::findByUsername($this->username);
        }

        return $this->user;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Логин',
            'password' => 'Пароль',
            'rememberMe' => 'Запомнить меня',
        ];
    }

    /**
     * Возвращает модель, отвечающую за хранение учетных записей
     * @return User
     */
    public function getUserModel()
    {
        if (empty($this->userModel)) {
            throw new InvalidValueException('user model not fount');
        }
        
        return $this->userModel;
    }

    /**
     * Устанавливает модель, отвечающую за хранение учетных записей
     * @param User $userModel
     * @return $this
     */
    public function setUserModel(User $userModel)
    {
        $this->userModel = $userModel;

        return $this;
    }
}
