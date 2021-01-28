<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "restaurant".
 *
 * @property int $id
 * @property int $platform_id
 * @property int $state_id
 * @property int $suburb_id
 * @property string $title
 * @property string|null $place_details
 * @property string|null $image
 * @property int|null $status
 * @property int|null $price_level
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $place_details_updated_at
 *
 * @property Delivery[] $deliveries
 * @property FavoriteAssn[] $favoriteAssns
 * @property Platform $platform
 * @property Suburb $state
 * @property Suburb $suburb
 */
class Restaurant extends \yii\db\ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE   = 1;

    const DETAILS_CACHE_EXPIRE_TIME_BD = 3600 * 24 * 10; //10 days
    const DETAILS_ENABLED_CACHE        = true;
    const DETAILS_UPLOAD_IMG_GOOGLE    = true;
    const COUNT_IMAGES_SLIDER = 5;

    const DEFAULT_PRICE_LEVEL = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'restaurant';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
           [['platform_id', 'state_id', 'suburb_id', 'title'], 'required'],
           [['platform_id', 'state_id', 'suburb_id', 'status', 'created_at', 'updated_at', 'place_details_updated_at', 'price_level'], 'integer'],
           [['title'], 'string', 'max' => 100],
           [['image'], 'string', 'max' => 30],
           ['place_details', 'string'],
           [['platform_id'], 'exist', 'skipOnError' => true, 'targetClass' => Platform::class, 'targetAttribute' => ['platform_id' => 'id']],
           [['state_id'], 'exist', 'skipOnError' => true, 'targetClass' => Suburb::class, 'targetAttribute' => ['state_id' => 'id']],
           [['suburb_id'], 'exist', 'skipOnError' => true, 'targetClass' => Suburb::class, 'targetAttribute' => ['suburb_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
           'id' => 'ID',
           'platform_id' => 'Platform ID',
           'state_id' => 'State ID',
           'suburb_id' => 'Suburb ID',
           'title' => 'Title',
           'image' => 'Image',
           'status' => 'Status',
           'created_at' => 'Created At',
           'updated_at' => 'Updated At',
        ];
    }

    public function behaviors()
    {
        return [
           TimestampBehavior::class,
        ];
    }

    public static function statusList()
    {
        return [
           self::STATUS_INACTIVE => 'Inactive',
           self::STATUS_ACTIVE => 'Active'
        ];
    }

    /**
     * Gets query for [[Deliveries]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDeliveries()
    {
        return $this->hasMany(Delivery::class, ['restaurant_id' => 'id']);
    }

    /**
     * Gets query for [[FavoriteAssns]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFavoriteAssns()
    {
        return $this->hasMany(FavoriteAssn::class, ['restaurant_id' => 'id']);
    }

    public function getFavoriteWithUser()
    {
        return $this->hasMany(FavoriteAssn::class, ['restaurant_id' => 'id'])->andWhere(['user_id' => Yii::$app->user->identity->id]);
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

    public function getImages(){
        return $this->hasMany(RestaurantImages::class,['restaurant_id' => 'id']);
    }
    
    public function getImagesConfirmed(){
        return $this->getImages()->where(['status' => RestaurantImages::STATUS_ACTIVE])->limit(self::COUNT_IMAGES_SLIDER);
    }

    /**
     * @return string
     */
    public function priceLevel()
    {
        switch ($level = $this->price_level ? $this->price_level : self::DEFAULT_PRICE_LEVEL) {
            case 1 :
                return '$';
                break;
            case 3 :
                return '$$$';
                break;
            case 4 :
                return '$$$$';
                break;
            default :
                return '$$';
        }
    }

    public function categories($deliveries,$cuisines){

        foreach ($deliveries as $delivery){
            if(!empty($delivery->cuisineTypes[0]) && key_exists($delivery->cuisineTypes[0]['type_id'],$cuisines)){
                return [
                   'id' => $delivery->cuisineTypes[0]['type_id'],
                   'title' => $cuisines[$delivery->cuisineTypes[0]['type_id']]
                ];
            }
        }

        return [];
    }
}
