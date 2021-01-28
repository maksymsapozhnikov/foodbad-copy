<?php

use backend\models\search\EmailTemplateSearch;
use common\models\EmailTemplate;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\EmailTemplateSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Manage emails';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="email-template-index box box-primary">
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
          'layout' => "{items}\n{summary}\n{pager}",
          'columns' => [
             ['class' => 'yii\grid\SerialColumn'],

             [
                'attribute' => 'id',
                'headerOptions' => ['style' => 'width:60px']
             ],
             [
                'attribute' => 'category',
                'filter' => EmailTemplate::categoriesList(),
                'value' => function (EmailTemplate $model) {
						return (key_exists($model->id,EmailTemplate::categoriesList())) ? EmailTemplate::categoriesList()[$model->id] : '';
                }
             ],
             'title',
             'body:ntext',

             [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}'
             ],
          ],
       ]); ?>
	</div>
</div>
