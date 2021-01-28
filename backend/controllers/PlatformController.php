<?php

namespace backend\controllers;

use Yii;
use common\models\Platform;
use backend\models\search\PlatformSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PlatformController implements the CRUD actions for Platform model.
 */
class PlatformController extends BackendController
{

    /**
     * Lists all Platform models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PlatformSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
           'searchModel' => $searchModel,
           'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate()
    {
        if (Yii::$app->request->post('Platform', false)) {
            $model = $this->findModel((int)Yii::$app->request->post('Platform')['id']);
            if ($model->load(Yii::$app->request->post())) {
                $this->setMessage($model->save());
            }
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the Platform model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Platform the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Platform::findOne($id)) !== null) {
            return $model;
        }else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionSetStatus($id, $status)
    {
        if (!empty($id) && isset($status)) {
            $model = $this->findModel($id);
            if ($model !== null) {
                $model->status = (int)$status;
                $this->setMessage($model->save());
            }
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionImageRemove(){
        if(Yii::$app->request->isPost && !empty($id = Yii::$app->request->post('id',false))){
            $model = $this->findModel((int) $id);
            $model->deleteImage();
            $model->updateAttributes(['image' => null]);
            return 1;
        }
        return false;
    }
}
