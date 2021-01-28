<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Admin */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="container-fluid">
	<div class="admin-form box box-primary">
		<div class="box-header with-border">
			<h3 class="box-title"></h3>
			<div class="box-tools pull-right">
             <?= Html::a('<span class="fa fa-reply"></span> Close', ['index'], ['class' => 'btn btn-sm btn-warning btn-flat']) ?>
			</div>
		</div>
       <?php $form = ActiveForm::begin(); ?>
		<div class="box-body table-responsive">
			<div class="row">
				<div class="col-sm-6"><?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?></div>
				<div class="col-sm-6"><?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?></div>
			</div>
			<div class="row">
				<div class="col-sm-4"><?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?></div>
				<div class="col-sm-4"><?= $form->field($model, 'password')->textInput(['maxlength' => true]) ?></div>
			</div>
		</div>
		<div class="box-footer text-center">
          <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-flat']) ?>
		</div>
       <?php ActiveForm::end(); ?>
	</div>
</div>
