<?php

namespace common\models;

use common\components\FileUpload;
use Yii;

/**
 * This is the model class for table "cuisine_types".
 *
 * @property int $id
 * @property string $code_api
 * @property string $title
 * @property string $image
 * @property int|null $status
 * @property int|null $category
 *
 * @property RestaurantCuisineTypesAssn[] $restaurantCuisineTypesAssn
 */
class CuisineTypes extends \yii\db\ActiveRecord
{
    use FileUpload;

    public function init()
    {
        $this->directory = '/categories/';
        parent::init();
    }


    const STATUS_ACTIVE   = 1;
    const STATUS_INACTIVE = 0;

    const CATEGORY_MAIN = 1;
    const CATEGORY_TAG  = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cuisine_types';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
           [['code_api', 'title'], 'required'],
           [['status', 'category'], 'integer'],
           [['code_api', 'title'], 'string', 'max' => 255],
           [['image'], 'string', 'max' => 30],
           [['code_api', 'title'], 'filter', 'filter' => 'strip_tags'],
           [['code_api', 'title'], 'filter', 'filter' => 'trim'],
           [['code_api'], 'unique'],

           [['uploadImage'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif'],
        ];
    }

    public function beforeSave($insert)
    {
        $this->uploadImg();
        return parent::beforeSave($insert);
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
           'alias' => 'Alias',
        ];
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
     * Gets query for [[RestaurantCuisineTypesAssn]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRestaurantCuisineTypesAssn()
    {
        return $this->hasMany(RestaurantCuisineTypesAssn::class, ['cuisine_type_id' => 'id']);
    }

    /**
     * Gets query for [[CuisineTypesAssn]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCuisineTypesAssn()
    {
        return $this->hasMany(CuisineTypesAssn::class, ['type_id' => 'id']);
    }

    /**
     * @return array
     */
    public static function cuisineTypesList()
    {
        return self::find()->where(['status' => self::STATUS_ACTIVE, 'category' => self::CATEGORY_MAIN])->indexBy('id')->column();
    }
}
