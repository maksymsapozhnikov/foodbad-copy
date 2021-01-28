<?php

namespace frontend\controllers;

use common\models\Page;
use frontend\models\ChangePassword;
use Yii;
use yii\base\DynamicModel;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

class SettingsController extends FrontendController
{

    public function actionProfile()
    {
        $model = Yii::$app->user->identity;
        if ($model->load(Yii::$app->request->post())) {
            $this->setMessage($model->save());
            return $this->redirect('profile');
        }

        return $this->render('profile', [
           'model' => $model,
        ]);
    }

    public function actionSecurity()
    {
        $model = new ChangePassword();
        if (\Yii::$app->request->isAjax) {
            if ($model->load(\Yii::$app->request->post())) {
                \Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
        }
        if (\Yii::$app->request->isPost && $model->load(\Yii::$app->request->post())) {
            if ($model->change()) {
                $this->setMessage(true, 'Your password has been changed successfully');
                return $this->redirect('security');
            }else {
                $this->setMessage(false);
            }
        }

        return $this->render('security', compact('model'));
    }

    public function actionPage(int $id)
    {
        if (($model = Page::findOne($id)) !== null) {
            return $this->render('page', compact('model'));
        }else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionPasswordReset()
    {
        Yii::$app->user->logout();
        return $this->redirect('/auth/request-password-reset');
    }
}