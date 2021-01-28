<?php

namespace backend\models;

use common\models\User as BaseModel;

class User extends BaseModel
{
    public $password;

    public function rules()
    {
        $rules =  parent::rules();
        $rules[] = ['password','string','min' => 8];
        return $rules;
    }

    public static function statusList()
    {
        return [
           self::STATUS_INACTIVE => 'Inactive',
           self::STATUS_ACTIVE => 'Active'
        ];
    }

    public function beforeSave($insert)
    {
        if (!empty($this->password)) {
            $this->setPassword($this->password);
        }
        return parent::beforeSave($insert);
    }
}