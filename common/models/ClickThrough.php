<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "click_through".
 *
 * @property int $id
 * @property int $delivery_id
 * @property int $quantity
 * @property int $created_at
 *
 * @property Restaurant $delivery
 */
class ClickThrough extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'click_through';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
           [['delivery_id', 'quantity', 'created_at'], 'required'],
           [['delivery_id', 'quantity', 'created_at'], 'integer'],
           [['delivery_id'], 'exist', 'skipOnError' => true, 'targetClass' => Delivery::class, 'targetAttribute' => ['delivery_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
           'id' => 'ID',
           'delivery_id' => 'Delivery ID',
           'quantity' => 'Quantity',
           'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Delivery]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDelivery()
    {
        return $this->hasOne(Delivery::class, ['id' => 'delivery_id']);
    }

    public static function addClick(int $deliveryID)
    {
        $model = ClickThrough::find()->where(['delivery_id' => $deliveryID])->andWhere(['between', 'created_at', strtotime('today'), strtotime('tomorrow')])->limit(1)->one();
        if ($model !== null) {
            return $model->updateCounters(['quantity' => 1]);
        }
        $model = new ClickThrough();
        $model->setAttributes([
           'delivery_id' => $deliveryID,
           'quantity' => 1,
           'created_at' => time(),
        ]);
        return $model->save();
    }
}
