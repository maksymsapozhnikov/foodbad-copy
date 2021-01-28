<?php
namespace console\controllers;

use console\components\UploadImagesFromGoogle;
use yii\console\Controller;

class UploadImagesController extends Controller
{
    public function actionUpload($restaurant_id){
        (new UploadImagesFromGoogle)->setImages($restaurant_id);
    }
}