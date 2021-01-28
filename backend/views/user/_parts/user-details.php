<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

/** @var $model \backend\models\User */
?>
<?php $form = ActiveForm::begin(['action' => ['user/index']]) ?>
<div class="container-fluid user-index">
	<div class="row">
		<div class="col-sm-9">
			<div class="row">
				<div class="col-sm-3"><?= $form->field($model, 'username')->textInput(['id' => 'username_' . $model->id]) ?></div>
				<div class="col-sm-3"><?= $form->field($model, 'last_name')->textInput(['id' => 'last_name_' . $model->id]) ?></div>
				<div class="col-sm-3"><?= $form->field($model, 'email')->textInput(['id' => 'email_' . $model->id]) ?></div>
				<div class="col-sm-3">
                <?= $form->field($model, 'phone')->widget(MaskedInput::class, ['mask' => '9 (999) 999-99-99','id' => 'phone_' . $model->id]) ?>
				</div>

			</div>
			<div class="row">
				<div class="col-sm-6">
                <?= $form->field($model, 'address')->textInput(['id' => 'address_' . $model->id]) ?>
				</div>
				<div class="col-sm-3">
                <?= $form->field($model, 'password')->passwordInput(['id' => 'pass_' . $model->id]) ?>
                <?= $form->field($model, 'id')->hiddenInput(['id' => 'id_' . $model->id])->label(false) ?>
				</div>
				<div class="col-sm-3" style="padding-top: 23px">
                <?= Html::submitButton('Update', ['class' => 'btn btn-primary btn-block']) ?>
				</div>
			</div>
		</div>
		<div class="col-sm-3 image-block">
          <?php if ($model->image && is_file($model->fullPath() . $model->image)): ?>
				 <img src="<?= Yii::$app->params->frontend_url . '/storage/users/' . $model->image ?>" alt="" style="height: 132px">
				 <div class="image-control">
                 <?= Html::button('<span class="fa fa-remove"></span>', [
                    'class' => 'btn btn-danger img-remove',
                    'data-id' => $model->id,

                 ]) ?>
                 <?= Html::button('<span class="fa fa-upload"></span>', ['class' => 'btn btn-primary img-upload','data-id' => $model->id]) ?>
                 <?= $form->field($model, 'uploadImage')->fileInput(['style' => 'display:none','id' => 'upload_' . $model->id])->label(false) ?>
				 </div>
          <?php else: ?>
              <?= Html::button('<span class="fa fa-upload"></span>', ['data-id' => $model->id,'class' => 'btn btn-warning img-upload', 'title' => 'Upload image','id' => 'img_' . $model->id]) ?>
              <?= $form->field($model, 'uploadImage')->fileInput(['style' => 'display:none','id' => 'upload_' . $model->id])->label(false) ?>
          <?php endif; ?>
		</div>
	</div>
</div>
<?php ActiveForm::end() ?>
