<?php

use common\models\Platform;
use kartik\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\PlatformSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Platforms';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="platform-index box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title"><?= $this->title ?></h3>
		<div class="box-tools pull-right">
          <?= Html::a('<span class="fa fa-refresh"></span>', ['index'], ['class' => 'btn btn-sm btn-warning btn-flat']) ?>
		</div>
	</div>

	<div class="box-body table-responsive no-padding">
       <?= GridView::widget([
          'dataProvider' => $dataProvider,
          'filterModel' => $searchModel,
          'layout' => "{items}\n{summary}\n{pager}",
          'columns' => [
             [
                'class' => \kartik\grid\ExpandRowColumn::class,
                'value' => function ($model, $key, $index, $column) {
                    return GridView::ROW_COLLAPSED;
                },
                'detail' => function ($model, $key, $index, $column) {
                    return Yii::$app->controller->renderPartial('_parts/platform-details', ['model' => $model]);
                }
             ],
             [
                'attribute' => 'id',
                'headerOptions' => ['width' => '80px']
             ],
             'title',
             [
                'attribute' => 'status',
                'format' => 'raw',
                'filter' => Platform::statusList(),
                'value' => function (Platform $model) {
                    return ($model->status == Platform::STATUS_ACTIVE) ? Html::a('Disable', ['platform/set-status', 'id' => $model->id, 'status' => Platform::STATUS_INACTIVE], ['class' => 'btn btn-danger btn-block btn-xs']) : Html::a('Enable', ['platform/set-status', 'id' => $model->id, 'status' => Platform::STATUS_ACTIVE], ['class' => 'btn btn-success btn-block btn-xs']);
                }
             ],
             'commission_min',
             'commission_max',
             [
                'label' => 'Logo',
                'format' => 'raw',
                'value' => function (Platform $model) {
                    if ($model->image && is_file($model->fullPath() . $model->image)) {
                        return Html::img(Yii::$app->params['img_platform'] . $model->image, ['style' => 'width:60px']);
                    }
                }
             ]

          ],
       ]); ?>
	</div>
</div>
