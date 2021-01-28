<?php

namespace backend\controllers;

use Yii;
use backend\models\User;
use backend\models\search\UserSearch;
use yii\web\NotFoundHttpException;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends BackendController
{

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->request->isPost && Yii::$app->request->post('User')) {
            $model = $this->findModel(Yii::$app->request->post('User')['id']);
            if ($model != null && $model->load(Yii::$app->request->post())) {
                if ($model->save()) {
                    $this->setMessage(true);
                    return $this->redirect('index');
                }
            }
            $this->setMessage(false);
        }

        $searchModel = new UserSearch();
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
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }else {
            return $this->render('update', [
               'model' => $model,
            ]);
        }
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne((int)$id)) !== null) {
            return $model;
        }else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @param $id integer
     * @param $status integer
     * @return \yii\web\Response
     */
    public function actionSetStatus($id, $status)
    {
        if (!empty($id) && !empty($status)) {
            $model = $this->findModel($id);
            if ($model !== null) {
                $model->status = (int)$status;
                $this->setMessage($model->save());
            }
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * @return \yii\web\Response
     */
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
