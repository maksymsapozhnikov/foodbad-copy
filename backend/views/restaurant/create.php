<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Restaurant */

$this->title = 'Create Restaurant';
$this->params['breadcrumbs'][] = ['label' => 'Restaurants', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="restaurant-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
