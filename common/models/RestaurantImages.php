<?php

namespace common\models;

use common\components\FileUpload;
use Yii;

/**
 * This is the model class for table "restaurant_images".
 *
 * @property int $id
 * @property int|null $restaurant_id
 * @property int|null $status
 * @property int|null $platform
 * @property string|null $image
 * @property string|null $photo_reference
 * @property int|null $created_at
 *
 * @property Restaurant $restaurant
 */
class RestaurantImages extends \yii\db\ActiveRecord
{

    use FileUpload;

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE   = 1;

    const ADDED_GOOGLE_PHOTO = 1;
    const ADDED_MANUALLY     = 2;

    public function init()
    {
        $this->directory = '/restaurant/places/';
        parent::init();
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'restaurant_images';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
           [['restaurant_id', 'status', 'platform', 'created_at'], 'integer'],
           [['image'], 'string', 'max' => 50],
           [['photo_reference'], 'string', 'max' => 512],
           [['restaurant_id'], 'exist', 'skipOnError' => true, 'targetClass' => Restaurant::class, 'targetAttribute' => ['restaurant_id' => 'id']],

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
           'restaurant_id' => 'Restaurant ID',
           'status' => 'Status',
           'platform' => 'Platform',
           'image' => 'Image',
           'photo_reference' => 'Photo Reference',
           'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Restaurant]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRestaurant()
    {
        return $this->hasOne(Restaurant::class, ['id' => 'restaurant_id']);
    }
}
