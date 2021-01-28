<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Restaurant */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="restaurant-form box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title"><?=  $this->title ?></h3>
		<div class="box-tools pull-right">
			<?=  Html::a('<span class="fa fa-reply"></span> Close', ['index'], ['class' => 'btn btn-sm btn-warning btn-flat']) ?>
		</div>
	</div>
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body table-responsive">

        <?= $form->field($model, 'platform_id')->textInput() ?>

        <?= $form->field($model, 'state_id')->textInput() ?>

        <?= $form->field($model, 'suburb_id')->textInput() ?>

        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'rating')->textInput() ?>

        <?= $form->field($model, 'delivery_fee')->textInput() ?>

        <?= $form->field($model, 'delivery_time')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'average_delivery_time')->textInput() ?>

        <?= $form->field($model, 'image_link')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'image')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'status')->textInput() ?>

        <?= $form->field($model, 'restaurant_suburb')->textInput() ?>

        <?= $form->field($model, 'link')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'clean_link')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'pre_order_times')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'created_at')->textInput() ?>

        <?= $form->field($model, 'updated_at')->textInput() ?>

        <?= $form->field($model, 'cuisine')->textInput(['maxlength' => true]) ?>

    </div>
    <div class="box-footer text-center">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
