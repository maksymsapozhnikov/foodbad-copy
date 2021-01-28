<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Log */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="log-form box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title"><?=  $this->title ?></h3>
		<div class="box-tools pull-right">
			<?=  Html::a('<span class="fa fa-reply"></span> Close', ['index'], ['class' => 'btn btn-sm btn-warning btn-flat']) ?>
		</div>
	</div>
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body table-responsive">

        <?= $form->field($model, 'level')->textInput() ?>

        <?= $form->field($model, 'category')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'log_time')->textInput() ?>

        <?= $form->field($model, 'prefix')->textarea(['rows' => 6]) ?>

        <?= $form->field($model, 'message')->textarea(['rows' => 6]) ?>

    </div>
    <div class="box-footer text-center">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
