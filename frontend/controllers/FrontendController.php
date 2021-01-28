<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class FrontendController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
           'access' => [
              'class' => AccessControl::class,
              'rules' => [
                 [
                    'actions' => ['error'],
                    'allow' => true,
                 ],
                 [
                    'actions' => ['login', 'signup','request-password-reset','reset-password'],
                    'allow' => true,
                    'roles' => ['?'],
                 ],
                 [
                    'controllers' => ['*'],
                    'allow' => true,
                    'roles' => ['@'],
                 ],
              ],
           ],
        ];
    }

    protected function setMessage($status, $message = '')
    {
        if ($message == '') {
            $message = ($status) ? 'All data was successfully saved.' : 'Some error occurred during saving data';
        }
        $status = ($status) ? 'success-message' : 'error-message';
        Yii::$app->session->setFlash($status, $message);
    }
}