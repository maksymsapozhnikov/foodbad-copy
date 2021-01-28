<?php

use backend\models\User;
use kartik\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title"></h3>
		<div class="box-tools pull-right">
          <?= Html::a('<span class="fa fa-refresh"></span>', ['index'], ['class' => 'btn btn-sm btn-warning btn-flat']) ?>
		</div>
	</div>

	<div class="box-body table-responsive no-padding">
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
                    return Yii::$app->controller->renderPartial('_parts/user-details', ['model' => $model]);
                }
             ],


             [
                'attribute' => 'id',
                'headerOptions' => ['width' => '60px']
             ],
             'username',
             'last_name',
             [
                'attribute' => 'status',
                'filter' => User::statusList(),
                'format' => 'raw',
                'value' => function (User $model) {
                    return ($model->status == User::STATUS_ACTIVE) ? Html::a('Disable', ['user/set-status', 'id' => $model->id, 'status' => User::STATUS_INACTIVE], ['class' => 'btn btn-danger btn-block btn-xs']) : Html::a('Enable', ['user/set-status', 'id' => $model->id, 'status' => User::STATUS_ACTIVE], ['class' => 'btn btn-success btn-block btn-xs']);
                }
             ],
             'email:email',
             'phone',
             [
                'attribute' => 'updated_at',
                'format' => 'datetime',
                'filter' => false
             ],
             [
                'attribute' => 'created_at',
                'format' => 'datetime',
                'filter' => false
             ],
             [
                'class' => 'yii\grid\ActionColumn',
                'template' => ''
             ],
          ],
       ]); ?>
	</div>
</div>
