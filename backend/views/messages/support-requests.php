<?php

use backend\models\search\SupportRequestSearch;
use common\models\SupportRequest;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\MessagesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Support Requests';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="messages-index box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title"></h3>
		<div class="box-tools pull-right">
          <?= Html::a('<span class="fa fa-refresh"></span>', ['support-requests'], ['class' => 'btn btn-sm btn-warning btn-flat']) ?>
		</div>
	</div>

	<div class="box-body table-responsive no-padding">
       <?= GridView::widget([
          'dataProvider' => $dataProvider,
          'filterModel' => $searchModel,
          'layout' => "{summary}\n{items}\n{pager}",
          'tableOptions' => ['class' => 'table'],
          'rowOptions' => function ($model) {
              if ($model->status == SupportRequestSearch::STATUS_UNREAD) {
                  return ['class' => 'bg-danger'];
              }elseif ($model->status == SupportRequestSearch::STATUS_READ) {
                  return ['class' => 'bg-default'];
              }elseif ($model->status == SupportRequestSearch::STATUS_CLOSED) {
                  return ['class' => 'bg-success'];
              }
          },
          'columns' => [
             [
                'attribute' => 'id',
                'headerOptions' => ['width' => '60px']
             ],
             [
                'attribute' => 'name',
                'value' => function (SupportRequestSearch $model) {
                    return $model->fromUser->username ?? null;
                }
             ],
             [
                'attribute' => 'lastName',
                'value' => function (SupportRequestSearch $model) {
                    return $model->fromUser->last_name ?? null;
                }
             ],
             [
                'attribute' => 'status',
                'filter' => SupportRequest::statusListForRequest(),
                'value' => function (SupportRequestSearch $model) {
                    return key_exists($model->status, SupportRequest::statusListForRequest()) ? SupportRequest::statusListForRequest()[$model->status] : $model->status;
                }
             ],
             [
                'attribute' => 'body',
                'value' => function (SupportRequestSearch $model) {
                    return substr($model->body, 0, 50) . '...';
                }
             ],
             [
                'attribute' => 'created_at',
                'format' => 'datetime',
                'filter' => false
             ],
             [
                'attribute' => 'updated_at',
                'format' => 'datetime',
                'filter' => false
             ],
             [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete-request} &nbsp; {view}',
                'buttons' => [
                   'delete-request' => function ($key, $model, $index) {
                       return Html::a('<span class="fa fa-remove"></span>', $key, [
                          'data' => [
                             'confirm' => 'Are you sure you want to delete this item?',
                             'method' => 'post',
                          ]
                       ]);
                   }
                ],
             ],
          ],
       ]); ?>
	</div>
</div>
