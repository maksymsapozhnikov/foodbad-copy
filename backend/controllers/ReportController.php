<?php

namespace backend\controllers;

use backend\models\Report;
use common\models\CuisineTypesAssn;
use common\models\Restaurant;
use common\models\Suburb;
use Yii;
use kartik\mpdf\Pdf;

class ReportController extends BackendController
{
    public function actionGeneral()
    {
        $model = new Report();
        $dataProvider = $model->search(Yii::$app->request->queryParams);
        return $this->render('general', compact('model', 'dataProvider'));
    }

    public function actionPdf(){
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        $model = new Report();
        $dataProvider = $model->search(Yii::$app->request->queryParams);
        $content = $this->renderPartial('render-report', compact('model', 'dataProvider'));
        $pdf = new Pdf([
           'mode' => Pdf::MODE_CORE, // leaner size using standard fonts
           'destination' => Pdf::DEST_BROWSER,
           //'cssFile' => Yii::getAlias('@backend') . '/web/css/kv-mpdf-bootstrap.css',
           'content' => $content,
           'options' => [],
           'methods' => [
              'SetTitle' => 'Foodbud Delivery Stats - ' . Yii::$app->params['frontend_url'],
              'SetHeader' => ['Generated On: ' . date("r")],
              'SetFooter' => ['|Page {PAGENO}|'],
              'SetAuthor' => 'FoodBud',
           ]
        ]);
        $headers = Yii::$app->response->headers;
        $headers->add('Content-Type', 'application/pdf');
        return $pdf->render();
    }

    public function actionRestaurantList()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $string = Yii::$app->request->get('string', null);
        $suburbs = Yii::$app->request->get('suburbs', null);
        $cuisines = Yii::$app->request->get('cuisines', null);
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($string)) {
            $query = Restaurant::find();
            $query->joinWith('suburb',false);
            $query->select([Restaurant::tableName() . '.id', "CONCAT(" . Restaurant::tableName() . ".title,' > '," . Suburb::tableName() . ".title) as text"])
               ->where(['like', Restaurant::tableName() . '.title', $string])
               ->andFilterWhere(['IN', Restaurant::tableName() . '.suburb_id', $suburbs])
               ->asArray()->limit(20);
            if($cuisines){
                $query->joinWith('deliveries.restaurantCuisineTypesAssn.tagsInCategory', false);
                $query->andWhere(['IN',CuisineTypesAssn::tableName() . '.type_id',$cuisines]);
            }
            $data = $query->all();
            $out['results'] = array_values($data);
        }
        return $out;
    }
}