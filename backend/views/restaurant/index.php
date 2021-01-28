<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\RestaurantSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Restaurants';
$this->params['breadcrumbs'][] = $this->title;

/** @var array $statesList */
/** @var array $platformsList */
?>
<div class="restaurant-index box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title"></h3>
		<div class="box-tools pull-right">
          <?= Html::a('<span class="fa fa-refresh"></span>', ['index'], ['class' => 'btn btn-sm btn-warning btn-flat']) ?>
		</div>
	</div>

	<div class="box-body table-responsive no-padding">
       <?php
       // echo $this->render('_search', ['model' => $searchModel]); ?>
       <?= GridView::widget(
          [
             'dataProvider' => $dataProvider,
             'filterModel' => $searchModel,
             'layout' => "{summary}\n{items}\n{pager}",
             'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                [
                   'attribute' => 'id',
                   'headerOptions' => ['style' => 'width:60px']

                ],
                [
                   'attribute' => 'state_id',
                   'filter' => $statesList,
                   'value' => function ($model) {
                       return (!empty($model->state->title)) ? $model->state->title : $model->state_id;
                   }
                ],
                [
                   'attribute' => 'suburbTitle',
                   'label' => 'Suburbs',
                   'value' => function ($model) {
                       return (!empty($model->suburb->title)) ? $model->suburb->title : $model->suburb_id;
                   }
                ],
                'title',
                [
                   'attribute' => 'status',
                   'format' => 'raw',
                   'filter' => \common\models\Restaurant::statusList(),
                   'value' => function ($model) {
                       return $model->status ? '<span class="text-success">Active</span>' : '<span class="text-danger">Inactive</span>';
                   }
                ],
                [
                   'label' => 'Click through',
                   'attribute' => 'date',
                   'width' => '230px',
                   'filterType' => GridView::FILTER_DATE_RANGE,
                   'filterWidgetOptions' => [
                      'startAttribute' => 'startDate',
                      'endAttribute' => 'endDate',
                       //'presetDropdown' => true,
                      'convertFormat' => true,
                      'hideInput' => true,
                      'pluginOptions' => [
                         'locale' => [
                            'format' => 'd.m.Y',
                            'separator' => ' - ',
                         ],
                      ]
                   ],
                    //'filter' => true,
                   'format' => 'raw',
                   'value' => function ($model) use ($platformsList) {
                       $string = '';
                       if (!empty($model->deliveries)) {
                           foreach ($model->deliveries as $delivery) {
                               $string .= (key_exists($delivery->platform_id, $platformsList)) ? $platformsList[$delivery->platform_id] . ': ' : 'Platform: ';
                               $string .= (!empty($delivery->clickThroughs)) ? array_sum(ArrayHelper::getColumn($delivery->clickThroughs, 'quantity')) : 0;
                               $string .= '<br />';
                           }
                       }
                       return $string;
                   }
                ],
                [
                   'label' => 'Cuisines and tags',
                   'value' => function ($model) {
                       $string = '';
                       $tags = [];
                       if (!empty($model->deliveries)) {
                           foreach ($model->deliveries as $delivery) {
                               if (!empty($delivery->restaurantCuisineTypesAssn)) {
                                   foreach ($delivery->restaurantCuisineTypesAssn as $tag) {
                                       $tags[] = $tag['title'];
                                   }
                               }
                           }
                           $string = \backend\components\Helpers::arrayToString(array_unique($tags));
                       }
                       return $string;
                   }
                ],
                [
                   'attribute' => 'image',
                   'filter' => false,
                   'content' => function ($model) {
                       return $model->image ? Html::img(Yii::$app->params['img_restaurant'] . $model->image, ['style' => 'height:60px']) : '';
                   }
                ],
                [
                   'attribute' => 'created_at',
                   'filter' => false,
                   'format' => 'date'
                ],
                 /*[
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{delete} &nbsp; {update}'
                 ],*/
             ],
          ]
       ); ?>
	</div>
</div>
