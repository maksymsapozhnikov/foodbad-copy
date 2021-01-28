<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "delivery".
 *
 * @property int $id
 * @property int $platform_id
 * @property int $state_id
 * @property int $suburb_id
 * @property int $restaurant_id
 * @property string $title
 * @property float|null $rating
 * @property float|null $delivery_fee
 * @property string|null $delivery_time
 * @property int|null $average_delivery_time
 * @property string|null $image_link
 * @property string|null $image
 * @property int|null $status
 * @property int|null $restaurant_suburb
 * @property string|null $link
 * @property string|null $clean_link
 * @property string|null $pre_order_times
 * @property string|null $cuisine
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Platform $platform
 * @property Suburb $state
 * @property Suburb $suburb
 */
class Delivery extends \yii\db\ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    public static function tableName()
    {
        return 'delivery';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['platform_id', 'state_id', 'suburb_id', 'title'], 'required'],
            [['platform_id', 'state_id', 'suburb_id', 'average_delivery_time', 'status', 'restaurant_suburb', 'created_at', 'updated_at'], 'integer'],
            [['rating', 'delivery_fee'], 'number'],
            [['title', 'delivery_time', 'pre_order_times'], 'string', 'max' => 100],
            [['image_link', 'link', 'clean_link'], 'string', 'max' => 512],
            [['cuisine'], 'string', 'max' => 256],
            [['title', 'delivery_time', 'pre_order_times','image_link', 'link', 'clean_link','cuisine'],'filter','filter' => 'strip_tags'],
            [['image'], 'string', 'max' => 30],
            [['platform_id'], 'exist', 'skipOnError' => true, 'targetClass' => Platform::class, 'targetAttribute' => ['platform_id' => 'id']],
            [['state_id'], 'exist', 'skipOnError' => true, 'targetClass' => Suburb::class, 'targetAttribute' => ['state_id' => 'id']],
            [['suburb_id'], 'exist', 'skipOnError' => true, 'targetClass' => Suburb::class, 'targetAttribute' => ['suburb_id' => 'id']],
            [['restaurant_id'], 'exist', 'skipOnError' => true, 'targetClass' => Restaurant::class, 'targetAttribute' => ['restaurant_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'platform_id' => 'Platform',
            'state_id' => 'State',
            'suburb_id' => 'Suburb',
            'title' => 'Title',
            'rating' => 'Rating',
            'delivery_fee' => 'Delivery Fee',
            'delivery_time' => 'Delivery Time',
            'average_delivery_time' => 'Average Delivery Time',
            'image_link' => 'Image Link',
            'image' => 'Image',
            'status' => 'Status',
            'restaurant_suburb' => 'Restaurant Suburb',
            'link' => 'Link',
            'clean_link' => 'Clean Link',
            'pre_order_times' => 'Pre Order Times',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
           TimestampBehavior::class,
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
     * Gets query for [[Platform]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPlatform()
    {
        return $this->hasOne(Platform::class, ['id' => 'platform_id']);
    }

    public function getRestaurants()
    {
        return $this->hasOne(Restaurant::class, ['id' => 'restaurant_id']);
    }

    /**
     * Gets query for [[State]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getState()
    {
        return $this->hasOne(Suburb::class, ['id' => 'state_id']);
    }

    /**
     * Gets query for [[Suburb]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSuburb()
    {
        return $this->hasOne(Suburb::class, ['id' => 'suburb_id']);
    }

    /**
     * Gets query for [[RestaurantCuisineTypesAssn]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRestaurantCuisineTypesAssn()
    {
        return $this->hasMany(RestaurantCuisineTypesAssn::class, ['restaurant_id' => 'id']);
    }

    public function getCuisineTypes(){
        return $this->hasMany(CuisineTypesAssn::class,['tag_id' => 'cuisine_type_id'])->via('restaurantCuisineTypesAssn');
    }

    public function getClickThroughs()
    {
        return $this->hasMany(ClickThrough::class, ['delivery_id' => 'id']);
    }
}
