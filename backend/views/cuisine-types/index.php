<?php

use backend\components\Helpers;
use common\models\CuisineTypes;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\CuisineTypesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Categories';
$this->params['breadcrumbs'][] = $this->title;

//dd($tagsWithoutCategory);
?>
<div class="cuisine-types-index box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title"></h3>
		<div class="box-tools pull-right">
          <?= Html::a('<span class="fa fa-refresh"></span>', ['index'], ['class' => 'btn btn-sm btn-warning btn-flat']) ?>
          <?= Html::a('<span class="fa fa-plus"></span>', ['create'], ['class' => 'btn btn-success btn-sm btn-flat']) ?>
		</div>
	</div>
	<?php if(!empty($tagsWithoutCategory)): ?>
		<div class="pad margin no-print">
			<div class="callout callout-default" style="margin-bottom: 0!important;">
				<h5>Tags without categories:</h5>
				<?= Helpers::arrayToString(ArrayHelper::getColumn($tagsWithoutCategory,'title')) ?>
			</div>
		</div>
	<?php endif; ?>

	<div class="box-body table-responsive no-padding">
       <?= kartik\grid\GridView::widget([
          'dataProvider' => $dataProvider,
          'filterModel' => $searchModel,
          'layout' => "{summary}\n{items}\n{pager}",
          'columns' => [
             [
                'attribute' => 'id',
                'headerOptions' => ['width' => '60px']
             ],
             'title',
             [
                'attribute' => 'status',
                'filter' => CuisineTypes::statusList(),
                'format' => 'raw',
                'value' => function (CuisineTypes $model) {
                    return ($model->status == CuisineTypes::STATUS_ACTIVE) ? Html::a('Disable', ['cuisine-types/set-status', 'id' => $model->id, 'status' => CuisineTypes::STATUS_INACTIVE], ['class' => 'btn btn-danger btn-block btn-xs']) : Html::a('Enable', ['cuisine-types/set-status', 'id' => $model->id, 'status' => CuisineTypes::STATUS_ACTIVE], ['class' => 'btn btn-success btn-block btn-xs']);
                }
             ],
             [
	           	 'label' => 'Images',
	              'content' => function(CuisineTypes $model){
       	            return ($model->image && is_file($model->fullPath() . $model->image)) ? Html::img(Yii::$app->params['img_categories'] . $model->image,['style' => 'height:60px']) : '' ;
	              }

             ],
             [
                'attribute' => 'tags',
                'format' => 'raw',
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => $tags,
                'filterWidgetOptions' => [
                   'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Any tags', 'multiple' => false],
                'value' => function (CuisineTypes $model) {
                    $html = '';
                    if (!empty($model['cuisineTypesAssn'])) {
                        foreach ($model['cuisineTypesAssn'] as $item) {
                            $html .= "<span class='cuisine-item'>{$item['title']}</span>";
                        }
                    }
                    return $html;
                }
             ],
             [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete} &nbsp; {update}'
             ],
          ],
       ]); ?>
	</div>
</div>
