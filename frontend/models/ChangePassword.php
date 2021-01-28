<?php

namespace frontend\models;

use common\models\User;
use Yii;
use yii\base\Model;

class ChangePassword extends Model
{
    public $current_password;
    public $new_password;
    public $retype_password;

    public function rules()
    {
        return [
           [['current_password', 'new_password', 'retype_password'], 'required'],
           [['current_password', 'new_password', 'retype_password'], 'filter', 'filter' => 'trim'],
           [['current_password', 'new_password', 'retype_password'], 'string', 'min' => Yii::$app->params['user.passwordMinLength']],
           [['current_password'], 'validatePassword'],
           [['retype_password','new_password'], 'validateCompare'],
        ];
    }

    /**
     * @param $attribute
     * @param $params
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = Yii::$app->user->identity;
            if (!$user || !$user->validatePassword($this->current_password)) {
                $this->addError($attribute, 'Incorrect password.');
            }
        }
    }

    /**
     * @param $attribute
     */
    public function validateCompare($attribute)
    {
        if (!$this->hasErrors()) {
            if ($this->new_password !== $this->retype_password) {
                $this->addError($attribute, 'Passwords do not match.');
            }
        }
    }

    /**
     * @return bool
     */
    public function change(){
        /**@var $user User */
        if($this->validate()){
            $user = Yii::$app->user->identity;
            $user->setPassword($this->new_password);
            return $user->save();
        }
        return false;
    }
}