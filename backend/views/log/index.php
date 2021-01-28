<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\LogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Logs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-index box box-primary">
		<div class="box-header with-border">
			<h3 class="box-title"><?=  $this->title ?></h3>
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
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                'level',
                'category',
                'log_time:datetime',
                'prefix:ntext',
                //'message:ntext',

					[
					'class' => 'yii\grid\ActionColumn',
					'template' => '{delete} &nbsp; {view}'
					],
            ],
        ]); ?>
    </div>
</div>
