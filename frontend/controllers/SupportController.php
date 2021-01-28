<?php
namespace frontend\controllers;

use common\models\SupportRequest;
use frontend\models\SendRequest;

class SupportController extends FrontendController
{

    public function actionIndex(){
        $model = new SupportRequest();

        if($model->load(\Yii::$app->request->post())){
            if($model->send()){
                $this->setMessage(true,'Your request successfully sent.');
                return $this->redirect(['support/index']);
            }else{
                $this->setMessage(false,'Your request unsuccessfully sent.');
            }
        }
        return $this->render('index',compact('model'));
    }

}