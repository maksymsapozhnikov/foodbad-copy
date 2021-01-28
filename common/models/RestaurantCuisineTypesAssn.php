<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "restaurant_cuisine_types_assn".
 *
 * @property int $id
 * @property int $restaurant_id
 * @property int $cuisine_type_id
 *
 * @property CuisineTypes $cuisineType
 * @property Restaurant $restaurant
 */
class RestaurantCuisineTypesAssn extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'restaurant_cuisine_types_assn';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
           [['restaurant_id', 'cuisine_type_id'], 'required'],
           [['restaurant_id', 'cuisine_type_id'], 'integer'],
           [
              ['cuisine_type_id'],
              'exist',
              'skipOnError' => true,
              'targetClass' => CuisineTypes::class,
              'targetAttribute' => ['cuisine_type_id' => 'id']
           ],
           [
              ['restaurant_id'],
              'exist',
              'skipOnError' => true,
              'targetClass' => Delivery::class,
              'targetAttribute' => ['restaurant_id' => 'id']
           ],
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
           'cuisine_type_id' => 'Cuisine Type ID',
        ];
    }

    /**
     * Gets query for [[CuisineType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCuisineType()
    {
        return $this->hasOne(CuisineTypes::class, ['id' => 'cuisine_type_id']);
    }

    /**
     * Gets query for [[Restaurant]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDelivery()
    {
        return $this->hasOne(Delivery::class, ['id' => 'restaurant_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTagsInCategory(){
        return $this->hasMany(CuisineTypesAssn::class,['tag_id' => 'cuisine_type_id']);
    }
}
