<?php

namespace console\components;

use common\models\RestaurantImages;
use GuzzleHttp\Client;
use Yii;
use yii\helpers\FileHelper;

class UploadImagesFromGoogle
{
    //maxwidth=400&photoreference=

    const HTTP_URL = 'https://maps.googleapis.com/maps/api/place/photo?';
    const MAXWIDTH = 300;
    const MAXHEIGHT = 300;

    protected $httpClient;

    function __construct()
    {
        $this->httpClient = new Client();
    }

    public function setImages($restaurant_id)
    {
        $models = RestaurantImages::find()->where([
           'restaurant_id' => (int)$restaurant_id,
           'status' => RestaurantImages::ADDED_GOOGLE_PHOTO,
           'image' => null
        ])->all();

        if ($models != []) {
            foreach ($models as $model) {
                $source = self::HTTP_URL . 'maxwidth=' . self::MAXWIDTH . '&key=' . \Yii::$app->params['google_api_key'] . '&photoreference=' . $model->photo_reference;
                $fileName = $this->upload($source,$restaurant_id);
                if($fileName){
                    $model->updateAttributes([
                       'image' => $fileName
                    ]);
                }
            }
        }
    }

    protected function upload($source,$restaurant_id)
    {
        $response = $this->httpClient->get($source);
        $headers = $response->getHeaders();
        if ($response->getStatusCode() == 200 && in_array($headers['Content-Type'][0], ['image/png', 'image/jpeg', 'application/octet-stream']) && $headers['Content-Length'][0] < 10485760) {
            $name = Yii::$app->security->generateRandomString(20) . '.jpg';
            $path = Yii::getAlias('@uploadImgRestaurantPlaces') . DIRECTORY_SEPARATOR . $restaurant_id;
            FileHelper::createDirectory($path);
            if (file_put_contents($path . DIRECTORY_SEPARATOR . $name, $response->getBody()->getContents())) {
                return $name;
            }
        }
        return false;
    }
}