<?php

namespace app\models;

use \yii\db\ActiveRecord;

class User extends ActiveRecord implements \yii\web\IdentityInterface
{
    public static function tableName(){
        return 'tbl_user';
    }

    public function attributeLabels(){
        return [
            'first_name' => 'Имя',
            'last_name' => 'Фамилия',
            'username' => 'Логин',
            'password' => 'Пароль',
            'email' => 'Почта',
            'data' => 'Дата рождения',
            'phone' => 'Телефон',
            'avatar' => 'Фото',
        ];
    }

    public function rules()
    {
        return [
            // username and password are both required
            [['first_name', 'last_name', 'username', 'password', 'email', 'data', 'phone'], 'required'],
            // password is validated by validatePassword()
            //['password', 'updatePassword'],
            ['email', 'email'],
            ['data', 'validateData'],
            ['phone', 'validatePhone'],
        ];
    }

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
        //return static::findOne(['access_token' => $token]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
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
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return \Yii::$app->security->validatePassword($password, $this->password);
    }

    public function generateAuthKey(){
        $this->auth_key = \Yii::$app->security->generateRandomString();
    }

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
}
