<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\CuisineTypes */

$this->title = 'Create Category';
$this->params['breadcrumbs'][] = ['label' => 'Cuisine Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cuisine-types-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
