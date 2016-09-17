<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class RegisterForm extends Model
{
    public $id;
    public $first_name;
    public $last_name;
    public $username;
    public $password;
    public $email;
    public $data;
    public $phone;
    public $avatar;

    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['first_name', 'last_name', 'username', 'password', 'email', 'data', 'phone'], 'required'],
            // rememberMe must be a boolean value
            ['email', 'email'],
            ['data', 'validateData'],
            ['phone', 'validatePhone'],
            // password is validated by validatePassword()
            //['password', 'validatePassword'],
            [['avatar'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Логин или Пароль введены не правильно!');
            }
        }
    }

    public function validateData($attribute){
        if (!$this->hasErrors()) {
            if(!preg_match('/^\d{4}\-d{2}-\d{2}$/', $this->data)){
                $this->addError($attribute, 'Дата должна быть в формате гггг-мм-дд!');
            }
        }
    }

    public function validatePhone($attribute){
        if (!$this->hasErrors()) {
            if(!preg_match('/^\d{3}\-d{7}$/', $this->data)){
                $this->addError($attribute, 'Дата должна быть в формате ***-*******!');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function update($id)
    {
        if ($this->validate()) {

            $this->id = $id;
            $user = $this->getUser();
            $user->save();
            return true;

            //return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
        }
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByPk($this->id);
        }

        return $this->_user;
    }

    public function upload()
    {
        if ($this->validate()) {
            $this->avatar->saveAs('uploads/' . $this->avatar->baseName . '.' . $this->avatar->extension);
            return true;
        } else {
            return false;
        }
    }
}
