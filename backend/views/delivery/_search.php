<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\search\RestaurantSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="restaurant-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'platform_id') ?>

    <?= $form->field($model, 'state_id') ?>

    <?= $form->field($model, 'suburb_id') ?>

    <?= $form->field($model, 'title') ?>

    <?php // echo $form->field($model, 'rating') ?>

    <?php // echo $form->field($model, 'delivery_fee') ?>

    <?php // echo $form->field($model, 'delivery_time') ?>

    <?php // echo $form->field($model, 'average_delivery_time') ?>

    <?php // echo $form->field($model, 'image_link') ?>

    <?php // echo $form->field($model, 'image') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'restaurant_suburb') ?>

    <?php // echo $form->field($model, 'link') ?>

    <?php // echo $form->field($model, 'clean_link') ?>

    <?php // echo $form->field($model, 'pre_order_times') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'cuisine') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
