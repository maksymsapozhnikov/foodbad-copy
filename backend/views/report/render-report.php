<?php

use backend\models\Report;
use kartik\grid\GridView;

$suburbs = [];
$cuisines = [];
if (!empty($model->suburbIds)) {
    foreach ($model->suburbIds as $id) {
        if (key_exists($id, $model->suburbsList)) {
            $suburbs[] = $model->suburbsList[$id];
        }
    }
}
if (!empty($model->cuisineIds)) {
    foreach ($model->cuisineIds as $id) {
        if (key_exists($id, $model->cuisinesList)) {
            $cuisines[] = $model->cuisinesList[$id];
        }
    }
}
?>
<div class="report-show">
	<p>&nbsp;</p>
	<h4 style="margin: 15px 0 15px">Foodbud Delivery Stats</h4>
	<h5><span class="filter-title">Restaurants:</span> <strong><?= $model->arrayToString($model->restaurantsList) ?: 'All' ?></strong></h5>
	<h5><span class="filter-title">Locations:</span> <strong><?= (!empty($suburbs)) ? $model->arrayToString($suburbs) : 'All' ?></strong></h5>
	<h5><span class="filter-title">Cuisines:</span> <strong><?= (!empty($cuisines)) ? $model->arrayToString($cuisines) : 'All' ?></strong></h5>
	<h5><span class="filter-title">Time Period:</span> <strong><?= date('F d, Y', strtotime($model->startDate)) ?></strong> to <strong><?= date('F d, Y', strtotime($model->endDate)) ?> </strong></h5>

    <?= GridView::widget([
       'dataProvider' => $dataProvider,
       'layout' => "{items}",
       'columns' => [
          [
             'attribute' => 'title',
             'label' => 'Services'
          ],
          [
             'label' => 'Click through',
             'hAlign' => GridView::ALIGN_CENTER,
             'value' => function ($data) {
                 return $data['through'];
             },
             'contentOptions' => ['style' => 'text-align:center'],
          ],
          [
             'label' => 'Commission paid on average $' . Report::AVERAGE_ORDER . ' order',
             'hAlign' => GridView::ALIGN_CENTER,
	          'contentOptions' => ['style' => 'text-align:center'],
             'value' => function ($data) use ($model) {
                 if (!$data['through']) {
                     return '-';
                 }
                 $string = '';
                 $string .= (!empty($data['commission_min'])) ? '$' . number_format(($data['through'] * $model::AVERAGE_ORDER) / 100 * $data['commission_min'], 2) : '';
                 $string .= (!empty($data['commission_max'])) ? ' to $' . number_format(($data['through'] * $model::AVERAGE_ORDER) / 100 * $data['commission_max'], 2) : '';
                 return $string;
             }
          ],
          [
             'label' => 'Cost if you used FoodBud',
             'hAlign' => GridView::ALIGN_CENTER,
             'value' => function ($data) use ($model) {
                 $month = floor((((strtotime($model->endDate) + 3600 * 24) - strtotime($model->startDate)) / 86400) / 30);
                 if ($month >= 1) {
                     return '$' . $month * $model::SERVICE_COST;
                 }
                 return '$' . 0;
             },
             'contentOptions' => ['style' => 'text-align:center']
          ],
       ],
    ]); ?>
</div>
