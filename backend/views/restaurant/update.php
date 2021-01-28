<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Restaurant */

$this->title = 'Update Restaurant: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Restaurants', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="restaurant-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
