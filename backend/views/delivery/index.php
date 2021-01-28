<?php

use common\models\Delivery;
use kartik\grid\GridView;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $platforms array */
/* @var $states array */
/* @var $searchModel backend\models\search\RestaurantSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Delivery';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="restaurant-index box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title"></h3>
		<div class="box-tools pull-right">
          <?= Html::a('<span class="fa fa-refresh"></span>', ['index'], ['class' => 'btn btn-sm btn-warning btn-flat']) ?>
		</div>
	</div>

	<div class="box-body table-responsive no-padding">
       <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
       <?= GridView::widget([
          'dataProvider' => $dataProvider,
          'filterModel' => $searchModel,
          'layout' => "{summary}\n{items}\n{pager}",
          'columns' => [
             [
                'class' => \kartik\grid\ExpandRowColumn::class,
                'value' => function ($model, $key, $index, $column) {
                    return GridView::ROW_COLLAPSED;
                },

                'detail' => function ($model, $key, $index, $column) {
                    return Yii::$app->controller->renderPartial('_parts/delivery-details', ['model' => $model]);
                }
             ],
             [
                'attribute' => 'id',
                'headerOptions' => ['width' => '80px']
             ],
             [
                'attribute' => 'platform_id',
                'filter' => $platforms,
                'value' => function (Delivery $model) use ($platforms) {
                    return key_exists($model->platform_id, $platforms) ? $platforms[$model->platform_id] : $model->platform_id;
                }
             ],
             [
                'attribute' => 'state_id',
                'filter' => $states,
                'value' => function (Delivery $model) use ($states) {
                    return key_exists($model->state_id, $states) ? $states[$model->state_id] : $model->state_id;
                }

             ],
             [
                'attribute' => 'suburbTitle',
                'value' => function (Delivery $model) {
                    return $model->suburb->title ?? 'Not Set';
                }
             ],
             'title',
             'rating',
             [
                'attribute' => 'status',
	              'format' => 'raw',
                'filter' => Delivery::statusList(),
                'value' => function (Delivery $model) {
       	            return $model->status ? '<span class="text-success">Active</span>' : '<span class="text-danger">Inactive</span>';
                }
             ],
             'delivery_fee',
             'delivery_time',
             'pre_order_times',
             'cuisine',
             [
                'attribute' => 'image',
                'filter' => false,
                'content' => function (Delivery $model) {
                    return $model->image ? Html::img(Yii::$app->params['img_delivery'] . $model->image, ['style' => 'height:60px']) : '';
                }
             ],
             [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
                'buttons' => [
                   'view' => function ($key, $model, $index) {
                       return !empty($model->clean_link) ? Html::a('<span class="fa fa-truck"></span>', $model->clean_link, ['target' => '_blank', 'title' => 'Clean link']) : '';
                   }
                ],
             ],
          ],
       ]); ?>
	</div>
</div>
