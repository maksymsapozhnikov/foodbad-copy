<?php

namespace frontend\models;

use common\models\SendEmail;
use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $last_name;
    public $email;
    public $password;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
           [['username', 'last_name'], 'trim'],
           [['username', 'last_name'], 'required'],
           [['username', 'last_name'], 'string', 'min' => 2, 'max' => 255],
           [['username', 'last_name'], 'filter', 'filter' => 'strip_tags'],
           ['email', 'trim'],
           ['email', 'required'],
           ['email', 'email'],
           ['email', 'string', 'max' => 255],
           [
              'email',
              'unique',
              'targetClass' => '\common\models\User',
              'message' => 'This email address has already been taken.'
           ],

           ['password', 'required'],
           ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],
        ];
    }

    public function attributeLabels()
    {
        return [
           'username' => 'First name',
           'last_name' => 'Last name',
           'email' => 'Email',
           'password' => 'Password'
        ];
    }


    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->last_name = $this->last_name;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();
        if($user->save()){
            Yii::$app->user->login($user, 3600 * 24 * 30);
            (new SendEmail())->sendSignUp($user);
            return true;
        }
        return false;

    }
}
