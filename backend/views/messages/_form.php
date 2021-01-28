<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Messages */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="messages-form box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title"><?=  $this->title ?></h3>
		<div class="box-tools pull-right">
			<?=  Html::a('<span class="fa fa-reply"></span> Close', ['index'], ['class' => 'btn btn-sm btn-warning btn-flat']) ?>
		</div>
	</div>
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body table-responsive">

        <?= $form->field($model, 'status')->textInput() ?>

        <?= $form->field($model, 'category')->textInput() ?>

        <?= $form->field($model, 'parent_id')->textInput() ?>

        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'body')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'to')->textInput() ?>

        <?= $form->field($model, 'from')->textInput() ?>

        <?= $form->field($model, 'created_at')->textInput() ?>

        <?= $form->field($model, 'updated_at')->textInput() ?>

    </div>
    <div class="box-footer text-center">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
