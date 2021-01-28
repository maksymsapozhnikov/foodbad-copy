<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CuisineTypes */

$this->title = 'Update Category: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Cuisine Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="cuisine-types-update">

    <?= $this->render('_form', [
        'model' => $model,
	     'types' => $types,
	     'typesAssn' => $typesAssn,
    ]) ?>

</div>
