<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "suburb".
 *
 * @property int $id
 * @property string $title
 * @property int|null $is_state
 * @property int|null $state_id
 *
 * @property Restaurant[] $restaurants
 */
class Suburb extends \yii\db\ActiveRecord
{

    const IS_STATE  = 1;
    const IS_SUBURB = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'suburb';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
           [['title', 'state_id'], 'required'],
           [['title'], 'filter', 'filter' => 'trim'],
           [['title'], 'filter', 'filter' => 'strip_tags'],
           [['is_state', 'state_id'], 'integer'],
           [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
           'id' => 'ID',
           'title' => 'Title',
           'is_state' => 'Is State',
           'state_id' => 'State ID',
        ];
    }

    /**
     * Gets query for [[Restaurants]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRestaurants()
    {
        return $this->hasMany(Restaurant::class, ['suburb_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getState()
    {
        return $this->hasOne(self::class, ['id' => 'state_id']);
    }

    public static function statesList(){
        return self::find()->select('title')->where(['is_state' => self::IS_STATE])->indexBy('id')->column();
    }

    /**
     * Gets query for [[Restaurants0]].
     *
     * @return \yii\db\ActiveQuery
     */
    /*public function getRestaurants0()
    {
        return $this->hasMany(Restaurant::className(), ['suburb_id' => 'id']);
    }*/
}
