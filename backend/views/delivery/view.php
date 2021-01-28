<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Restaurant */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Delivery', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="restaurant-view box box-primary">
    <div class="box-header">

    </div>
    <div class="box-body table-responsive no-padding">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'platform_id',
                'state_id',
                'suburb_id',
                'title',
                'rating',
                'delivery_fee',
                'delivery_time',
                'average_delivery_time:datetime',
                'image_link',
                'image',
                'status',
                'restaurant_suburb',
                'link',
                'clean_link',
                'pre_order_times',
                'created_at:datetime',
                'updated_at:datetime',
                'cuisine',
            ],
        ]) ?>
    </div>
</div>
