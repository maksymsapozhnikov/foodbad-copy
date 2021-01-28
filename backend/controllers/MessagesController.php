<?php

namespace backend\controllers;

use backend\models\search\NotificationSearch;
use backend\models\search\SupportRequestSearch;
use common\models\SupportRequest;
use Yii;
use common\models\Messages;
use backend\models\search\MessagesSearch;
use yii\web\NotFoundHttpException;

/**
 * MessagesController implements the CRUD actions for Messages model.
 */
class MessagesController extends BackendController
{
    /* Support request */

    public function actionSupportRequests()
    {
        $searchModel = new SupportRequestSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('support-requests', [
           'searchModel' => $searchModel,
           'dataProvider' => $dataProvider,
        ]);
    }

    /* Notifications */

    /*public function actionNotifications()
    {
        $searchModel = new NotificationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('notifications', [
           'searchModel' => $searchModel,
           'dataProvider' => $dataProvider,
        ]);
    }*/

    /**
     * Displays a single Messages model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findRequest($id);
        $model->updateAttributes(['status' => Messages::STATUS_READ]);
        return $this->render('view', [
           'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Messages model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDeleteRequest($id)
    {
        $this->findRequest($id)->delete();
        return $this->redirect(['support-requests']);
    }

    /**
     * Finds the Messages model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Messages the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findRequest($id)
    {
        if (($model = SupportRequest::find()->where(['id' => $id, 'category' => SupportRequest::CATEGORY_SUPPORT_REQUEST])->with('fromUser', 'requestImages')->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
