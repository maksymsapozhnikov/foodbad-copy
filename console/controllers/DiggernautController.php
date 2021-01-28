<?php

namespace console\controllers;

use console\components\AddRestaurant;
use console\components\Diggernaut;
use console\helpers\CategoriesInit;
use yii\console\Controller;

class DiggernautController extends Controller
{

    public function actionGetData()
    {
        (new Diggernaut())->run();
    }

    public function actionCreateRestaurant()
    {
        (new AddRestaurant())->setRestaurant();
    }

    public function actionCategoriesInit(){
        (new CategoriesInit())->link();
    }


}
