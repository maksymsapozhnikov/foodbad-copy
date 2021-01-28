<?php

namespace backend\controllers;

use Yii;
use backend\models\Admin;
use backend\models\search\AdminSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AdminController implements the CRUD actions for Admin model.
 */
class AdminController extends BackendController
{

    /**
     * Lists all Admin models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AdminSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
           'searchModel' => $searchModel,
           'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Creates a new Admin model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Admin();
        $model->scenario = Admin::SCENARIO_CREATE;
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                $this->setMessage(true);
                return $this->redirect(['index']);
            }else {
                $this->setMessage(false);
            }

        }
        return $this->render('create', [
           'model' => $model,
        ]);
    }

    /**
     * Updates an existing Admin model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->setMessage(true);
            return $this->redirect(['index']);
        }else {
            return $this->render('update', [
               'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Admin model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if ($id != Yii::$app->user->identity->getId()) {
            $this->findModel($id)->delete();
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the Admin model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Admin the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Admin::findOne($id)) !== null) {
            return $model;
        }else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionSetStatus($id, $status)
    {
        if (!empty($id) && !empty($status) && $id != Yii::$app->user->identity->getId()) {
            $model = $this->findModel($id);
            if ($model !== null) {
                $model->status = (int)$status;
                $this->setMessage($model->save());
            }
        }
        return $this->redirect(Yii::$app->request->referrer);
    }
}
