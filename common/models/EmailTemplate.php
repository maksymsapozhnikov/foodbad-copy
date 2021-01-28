<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "email_template".
 *
 * @property int $id
 * @property int|null $category
 * @property string|null $title
 * @property string|null $body
 */
class EmailTemplate extends \yii\db\ActiveRecord
{
    const CATEGORY_SUPPORT_REQUEST        = 1;
    const CATEGORY_REQUEST_PASSWORD_RESET = 2;
    const CATEGORY_SIGN_UP                = 3;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'email_template';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
           [['category'], 'integer'],
           [['body'], 'string'],
           [['title'], 'string', 'max' => 256],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
           'id' => 'ID',
           'category' => 'Category',
           'title' => 'Subject',
           'body' => 'Body',
        ];
    }

    public static function categoriesList()
    {
        return [
           self::CATEGORY_SUPPORT_REQUEST => 'Support request',
           self::CATEGORY_REQUEST_PASSWORD_RESET => 'Request password reset',
           self::CATEGORY_SIGN_UP => 'New sign up'
        ];
    }

    public static function notices()
    {
        return [
           self::CATEGORY_SUPPORT_REQUEST => '{{link}} - Link to request in the admin panel (Required attribute)',
           self::CATEGORY_REQUEST_PASSWORD_RESET => '{{link}} - Password reset link (Required attribute)<br />{{username}} - Username (Required attribute)',
           self::CATEGORY_SIGN_UP => '{{username}} - Username (Required attribute)'
        ];
    }
}
