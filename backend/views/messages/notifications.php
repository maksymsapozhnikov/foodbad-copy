<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\MessagesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Notifications';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="messages-index box box-primary">
		<div class="box-header with-border">
			<h3 class="box-title"></h3>
			<div class="box-tools pull-right">
				<?//= Html::a('<span class="fa fa-refresh"></span>', ['notifications'], ['class' => 'btn btn-sm btn-warning btn-flat']) ?>
				<?//= Html::a('<span class="fa fa-plus"></span>', ['create'], ['class' => 'btn btn-success btn-sm btn-flat']) ?>
			</div>
		</div>

	<div class="box-body table-responsive no-padding">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'layout' => "{summary}\n{items}\n{pager}",
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'id',
                'status',
                'title',
                'body',
                'created_at:datetime',
                'updated_at:datetime',
					[
					'class' => 'yii\grid\ActionColumn',
					'template' => ''
					],
            ],
        ]); ?>
    </div>
</div>
