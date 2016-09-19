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
    public $first_name;
    public $last_name;
    public $username;
    public $password;
    public $email;
    public $data;
    public $phone;
    public $verifyCode;

    private $_pass;


    public function attributeLabels(){
        return [
            'first_name' => 'Имя',
            'last_name' => 'Фамилия',
            'username' => 'Логин',
            'password' => 'Пароль',
            'email' => 'Почта',
            'data' => 'Дата рождения',
            'phone' => 'Телефон',
            'verifyCode' => 'Код проверки',
        ];
    }

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
            ['verifyCode', 'captcha'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */

    public function validateData($attribute){
        if (!$this->hasErrors()) {
            if(!preg_match('/^\d{4}\-\d{2}\-\d{2}$/', $this->data)){
                $this->addError($attribute, 'Дата должна быть в формате гггг-мм-дд!');
            }
        }
    }

    public function validatePhone($attribute, $phone){
        if (!$this->hasErrors()) {
            if(!preg_match('/^\d{3}\-\d{7}$/', $this->phone)){
                $this->addError($attribute, 'Дата должна быть в формате ***-*******!');
            }
        }
    }

    public function sendMail(){
        Yii::$app->mailer->compose()
            ->setFrom('eugeniymalakhov@gmail.com')
            ->setTo($this->email)
            ->setSubject('Успешная регистрация')
            ->setTextBody('Спасибо большое за регистрацию на нашем сайте!')
            ->setHtmlBody('<b>http://evgeniy.resume.ua</b>')
            ->send();
    }

    /**
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function save()
    {
        if ($this->validate()) {
            Yii::$app->db->createCommand()->insert('tbl_user', [
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'username' => $this->username,
                'password' => Yii::$app->getSecurity()->generatePasswordHash($this->password),
                'email' => $this->email,
                'data' => $this->data,
                'phone' => $this->phone,
                'avatar' => 'no-avatar.png',
            ])->execute();
            return true;
            //return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
        }
        return false;
    }
}
