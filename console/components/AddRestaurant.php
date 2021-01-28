<?php

namespace console\components;

use common\models\Restaurant;
use Yii;
use yii\helpers\FileHelper;

class AddRestaurant
{

    public function setRestaurant()
    {
        try{
            foreach (\common\models\Delivery::find()->where(['restaurant_id' => null])->batch(50) as $deliveries) {
                if (!empty($deliveries)) {
                    foreach ($deliveries as $delivery) {
                        $this->saveRestaurant($delivery);
                    }
                }
            }
        }catch (\ErrorException $e){
            Yii::error('Error adding a new restaurant', 'AddRestaurant');
        }
    }

    /**
     * @param \common\models\Delivery $delivery
     * @return bool
     */
    protected function saveRestaurant($delivery)
    {
        $model = Restaurant::find()->where([
           'title' => $delivery->title,
           'suburb_id' => $delivery->suburb_id
        ])->one();

        if ($model != null) {
            $delivery->updateAttributes(['restaurant_id' => $model->id]);
            return true;
        }

        $img = $this->addImg($delivery->image);
        $model = new Restaurant();
        $model->setAttributes([
           'platform_id' => $delivery->platform_id,
           'state_id' => $delivery->state_id,
           'suburb_id' => $delivery->suburb_id,
           'title' => $delivery->title,
           'image' => $img,
           'status' => Restaurant::STATUS_ACTIVE,
        ]);
        if ($model->save()) {
            $delivery->updateAttributes(['restaurant_id' => $model->id]);
            return true;
        }
        return false;
    }

    protected function addImg($string)
    {
        FileHelper::createDirectory(Yii::getAlias('@uploadImgRestaurant'));
        if ($string && is_file(Yii::getAlias('@uploadImgDelivery') . DIRECTORY_SEPARATOR . $string)) {
            if (copy(Yii::getAlias('@uploadImgDelivery') . DIRECTORY_SEPARATOR . $string, Yii::getAlias('@uploadImgRestaurant') . DIRECTORY_SEPARATOR . $string)) {
                return $string;
            }
        }
        return '';
    }
}