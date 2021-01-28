<?php

namespace backend\controllers;

use backend\models\search\DeliverySearch;
use common\models\Platform;
use common\models\Suburb;
use Yii;
use common\models\Restaurant;
use backend\models\search\RestaurantSearch;
use yii\web\NotFoundHttpException;

/**
 * DeliveryController implements the CRUD actions for Restaurant model.
 */
class DeliveryController extends BackendController
{

    /**
     * Lists all Restaurant models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DeliverySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
           'searchModel' => $searchModel,
           'dataProvider' => $dataProvider,
           'platforms' => Platform::platformList(),
           'states' => Suburb::statesList(),
        ]);
    }

    /**
     * Displays a single Restaurant model.
     * @param integer $id
     * @return mixed
     */
    /*public function actionView($id)
    {
        return $this->render('view', [
           'model' => $this->findModel($id),
           'platforms' => Platform::platformList(),

        ]);
    }*/

    /**
     * Creates a new Restaurant model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    /*public function actionCreate()
    {
        $model = new Restaurant();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }else {
            return $this->render('create', [
               'model' => $model,
            ]);
        }
    }*/

    /**
     * Updates an existing Restaurant model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
   /* public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }else {
            return $this->render('update', [
               'model' => $model,
            ]);
        }
    }*/

    /**
     * Deletes an existing Restaurant model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    /*public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }*/

    /**
     * Finds the Restaurant model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Restaurant the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Restaurant::findOne($id)) !== null) {
            return $model;
        }else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
