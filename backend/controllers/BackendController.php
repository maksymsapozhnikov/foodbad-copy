<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class BackendController extends Controller
{

    public function behaviors()
    {
        return [
           'access' => [
              'class' => AccessControl::class,
              'rules' => [
                 [
                    'actions' => ['login'],
                    'allow' => true,
                    'roles' => ['?'],
                 ],
                 [
                    'actions' => ['logout'],
                    'allow' => true,
                    'roles' => ['@'],
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
        $status = ($status) ? 'success' : 'danger';
        Yii::$app->session->setFlash($status, $message);
    }

}