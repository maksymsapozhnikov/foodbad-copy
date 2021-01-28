<?php

use backend\models\Admin;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\AdminSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Admins';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-index box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title"></h3>
		<div class="box-tools pull-right">
          <?= Html::a('<span class="fa fa-refresh"></span>', ['index'], ['class' => 'btn btn-sm btn-warning btn-flat']) ?>
          <?= Html::a('<span class="fa fa-plus"></span>', ['create'], ['class' => 'btn btn-success btn-sm btn-flat']) ?>
		</div>
	</div>

	<div class="box-body table-responsive no-padding">
       <?= GridView::widget([
          'dataProvider' => $dataProvider,
          'filterModel' => $searchModel,
          'layout' => "{summary}\n{items}\n{pager}",
          'columns' => [
             'username',
             'last_name',
             [
                'attribute' => 'status',
                'filter' => Admin::statusList(),
                'format' => 'raw',
                'value' => function (Admin $model) {
                    return ($model->status == Admin::STATUS_ACTIVE) ? Html::a('Disable', ['admin/set-status', 'id' => $model->id, 'status' => Admin::STATUS_INACTIVE], ['class' => 'btn btn-danger btn-block btn-xs']) : Html::a('Enable', ['admin/set-status', 'id' => $model->id, 'status' => Admin::STATUS_ACTIVE], ['class' => 'btn btn-success btn-block btn-xs']);
                }
             ],
             'email:email',
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
                'template' => '{delete} &nbsp; {update}'
             ],
          ],
       ]); ?>
	</div>
</div>
