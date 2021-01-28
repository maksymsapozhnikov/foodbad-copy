<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Messages */

$this->title = 'Update Messages: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Messages', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="messages-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
