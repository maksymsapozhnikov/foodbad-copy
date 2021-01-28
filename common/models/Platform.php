<?php

namespace common\models;

use common\components\FileUpload;
use Yii;

/**
 * This is the model class for table "platform".
 *
 * @property int $id
 * @property string $code_api
 * @property string $title
 * @property string $image
 * @property int|null $status
 * @property int|null $commission_min
 * @property int|null $commission_max
 *
 * @property Restaurant[] $restaurants
 */
class Platform extends \yii\db\ActiveRecord
{
    use FileUpload;

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE   = 1;

    public static function tableName()
    {
        return 'platform';
    }

    public function init() {
        $this->directory = '/platforms/';
        parent::init();
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
           [['code_api', 'title'], 'required'],
           [['status', 'commission_min', 'commission_max'], 'integer'],
           ['status', 'default', 'value' => self::STATUS_ACTIVE],
           ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE]],
           [['code_api', 'title'], 'string', 'max' => 100],
           [['image'], 'string', 'max' => 50],
           [['code_api', 'title'], 'filter', 'filter' => 'strip_tags'],
           [['code_api', 'title'], 'filter', 'filter' => 'trim'],

           [['uploadImage'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
           'id' => 'ID',
           'code_api' => 'Code Api',
           'title' => 'Title',
           'status' => 'Status',
        ];
    }

    public function beforeSave($insert)
    {
        $this->uploadImg(100);
        return parent::beforeSave($insert);
    }

    /**
     * @return array
     */
    public static function statusList()
    {
        return [
           self::STATUS_INACTIVE => 'Inactive',
           self::STATUS_ACTIVE => 'Active'
        ];
    }

    /**
     * Gets query for [[Restaurants]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRestaurants()
    {
        return $this->hasMany(Restaurant::class, ['platform_id' => 'id']);
    }

    public function getDeliveries()
    {
        return $this->hasMany(Delivery::class, ['platform_id' => 'id']);
    }

    public static function platformList()
    {
        return self::find()->select('title')->indexBy('id')->column();
    }
}
