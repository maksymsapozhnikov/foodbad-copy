<?php

namespace console\components;

use common\models\Delivery as BaseModel;
use common\models\RestaurantCuisineTypesAssn;
use GuzzleHttp\Client;
use Imagine\Image\Box;
use Yii;
use yii\helpers\FileHelper;
use yii\imagine\Image;


class Delivery extends BaseModel
{
    /** @var  \common\models\Delivery $_model */

    public $_model;
    public $tags;
    const UPLOAD_IMAGES = true;
    protected $httpClient;

    function init()
    {
        $this->httpClient = new Client();
        parent::init();
    }

    public function beforeSave($insert)
    {
        if (self::UPLOAD_IMAGES) {
            if ($insert) {
                $this->upload($this->image_link);
            }else {
                $this->status = self::STATUS_ACTIVE;
                if (!empty($this->image_link) && $this->_model->image_link != $this->image_link) {
                    $this->upload($this->image_link);
                    $this->deleteImage();
                }
            }
        }

        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        $this->tags($insert);
    }

    /**
     * @param $insert boolean
     * @return bool
     */
    protected function tags($insert)
    {

        if (!$insert) {
            if ($this->cuisine == $this->_model->cuisine) {
                return true;
            }else {
                RestaurantCuisineTypesAssn::deleteAll(['restaurant_id' => $this->id]);
            }
        }
        if (is_array($this->tags)) {
            foreach ($this->tags as $tag) {
                $model = new RestaurantCuisineTypesAssn();
                $model->setAttributes([
                   'restaurant_id' => $this->id,
                   'cuisine_type_id' => $tag
                ]);
                $model->save();
            }
        }
        return true;
    }

    protected function upload($source)
    {
        if (!empty($source)) {
            $response = $this->httpClient->get($source);
            $headers = $response->getHeaders();
            if ($response->getStatusCode() == 200 && in_array($headers['Content-Type'][0], ['image/png', 'image/jpeg', 'application/octet-stream']) && $headers['Content-Length'][0] < 10485760) {
                $name = Yii::$app->security->generateRandomString(20) . '.jpg';
                FileHelper::createDirectory(Yii::getAlias('@uploadImgDelivery'));
                if(file_put_contents(Yii::getAlias('@uploadImgDelivery') . DIRECTORY_SEPARATOR . $name,$response->getBody()->getContents())){
                    $this->image = $name;
                    $this->resizeImage();
                }

            }
        }
    }

    protected function deleteImage()
    {
        if ($this->_model->image) {
            @unlink(Yii::getAlias('@uploadImgDelivery') . DIRECTORY_SEPARATOR . $this->_model->image);
        }
        return true;
    }

    protected function resizeImage()
    {
        $file = Yii::getAlias('@uploadImgDelivery') . DIRECTORY_SEPARATOR . $this->image;
        $imagine = Image::getImagine();
        $size = getimagesize($file);
        $height = 300;
        if (!empty($size[1]) && $size[1] > $height) {
            $width = $size[0] * $height / $size[1];
            $image = $imagine->open($file);
            $image->resize(new Box($width, $height))->save($file, ['quality' => 80]);
        }
    }

}