<?php

use backend\components\CKEditor;
use common\models\EmailTemplate;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\EmailTemplate */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="email-template-form box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title"></h3>
		<div class="box-tools pull-right">
          <?= Html::a('<span class="fa fa-reply"></span> Close', ['index'], ['class' => 'btn btn-sm btn-warning btn-flat']) ?>
		</div>
	</div>
	<?php if(key_exists($model->id, EmailTemplate::notices())): ?>
	<div class="pad margin no-print">
		<div class="callout callout-info" style="margin-bottom: 0!important;">
			<h4><i class="fa fa-info"></i> Note:</h4>
			<?= EmailTemplate::notices()[$model->id] ?>
		</div>
	</div>
	<?php endif; ?>
    <?php $form = ActiveForm::begin(); ?>
	<div class="box-body table-responsive">

       <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

       <?= $form->field($model, 'body')->widget(CKEditor::class, [
          'options' => ['rows' => 8],
          'preset' => 'basic'
       ]) ?>

	</div>
	<div class="box-footer text-center">
       <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-flat']) ?>
	</div>
    <?php ActiveForm::end(); ?>
</div>
