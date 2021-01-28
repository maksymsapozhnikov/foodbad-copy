<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div class="container-fluid">
	<div class="platform-form box box-warning">
		<div class="box-header with-border">
			<h3 class="box-title"><?= $model->title ?></h3>
		</div>
       <?php $form = ActiveForm::begin(['action' => '/admin/platform/update']); ?>
		<div class="box-body">
			<div class="row">
				<div class="col-sm-4">
                <?= $form->field($model, 'title')->textInput(['id' => 'title_' . $model->id]) ?>
                <?= $form->field($model, 'id')->hiddenInput(['id' => 'id_' . $model->id])->label(false) ?>
				</div>
				<div class="col-sm-2">
                <?= $form->field($model, 'commission_min')->textInput(['id' => 'min_' . $model->id]) ?>
				</div>
				<div class="col-sm-2">
                <?= $form->field($model, 'commission_max')->textInput(['id' => 'max_' . $model->id]) ?>
				</div>
				<div class="col-sm-4 image-block">
                <?php if ($model->image && is_file($model->fullPath() . $model->image)): ?>
						 <img src="<?= Yii::$app->params['img_platform'] . $model->image ?>" alt="" style="height: 132px">
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
		<div class="box-footer text-center">
          <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-flat']) ?>
		</div>
       <?php ActiveForm::end(); ?>
	</div>
</div>
<?php
$js = <<<JS
$('.platform-form button.img-upload').on('click', function () { console.log(111);
  $('input#upload_' + $(this).attr('data-id')).click()
})

$('.platform-form button.img-remove').on('click', function () {
  if (confirm('Are you sure you want to delete this image?')) {
    var b = $(this);
    $.ajax({
      type:'POST',
      url:'/admin/platform/image-remove',
      data:{id:b.attr('data-id')},
      error:function () {},
      success:function (data) {
        if(data){
          b.parents('div.image-control').siblings('img').remove();
        }
      }
    })
  }
})
JS;
$this->registerJs($js)
?>