<?php

namespace backend\controllers;

use common\models\Page;
use yii\helpers\Url;

class PageController extends BackendController
{
    /**
     * @param int $id
     * @var $model Page
     * @return string
     */
    public function actionUpdate(int $id)
    {
        $model = $this->findModel($id);
        if($model->load(\Yii::$app->request->post())){
            if($model->save()){
                $this->setMessage(true);
                $this->redirect(Url::to(['update','id' => $model->id]));
            }else{
                $this->setMessage(false);
            }
        }
        return $this->render('update',compact('model'));
    }

    /**
     * @param int $id
     * @return Page the loaded model
     */
    protected function findModel(int $id)
    {
        if (($model = Page::findOne($id)) !== null) {
            return $model;
        }else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}