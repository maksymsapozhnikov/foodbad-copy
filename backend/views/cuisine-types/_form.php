<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model common\models\CuisineTypes */
/* @var $form yii\widgets\ActiveForm */
$types = $types ?? [];
$typesAssn = $typesAssn ?? [];
?>
<?php if (!$model->isNewRecord): ?>
	<script>var category = <?= $model->id ?></script>
<?php endif; ?>

<div class="cuisine-types-form box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title"></h3>
		<div class="box-tools pull-right">
          <?= Html::a('<span class="fa fa-reply"></span> Close', ['index'], ['class' => 'btn btn-sm btn-warning btn-flat']) ?>
		</div>
	</div>
	<div class="box-body">
       <?php $form = ActiveForm::begin(); ?>
		<div class="row">
			<div class="col-sm-6"><?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?></div>
			<div class="col-sm-1"><?= ($model->image && is_file($model->fullPath() . $model->image)) ? Html::img(Yii::$app->params['img_categories'] . $model->image,['style' => 'width:100%']) : '' ?></div>
			<div class="col-sm-2"><?= $form->field($model, 'uploadImage')->fileInput(['maxlength' => true])->label('Image') ?></div>
			<div class="col-sm-3"><?= Html::submitButton('Save', ['class' => 'btn btn-success btn-block', 'style' => 'margin-top:23px']) ?></div>
		</div>
	</div>
    <?php ActiveForm::end(); ?>
    <?php if (!$model->isNewRecord): ?>
		 <div class="block-assign box-body">
			 <div class="col-sm-3">
				 <div class="box">
					 <div class="box-header with-border">
						 <h3 class="box-title">Tags in category</h3>
					 </div>
					 <div class="box-body selected-cuisine-types" style="min-height: 260px">
                    <?php foreach ($typesAssn as $id): ?>
                        <?php if (key_exists($id, $types)): ?>
								  <span data-id="<?= $id ?>" class="cuisine-item"><?= $types[$id]->title ?></span>
                        <?php endif; ?>
                    <?php endforeach; ?>
					 </div>
                 <?= Html::button('Update', ['id' => 'update-assn', 'class' => 'btn btn-primary btn-block']) ?>
					 <!-- /.box-body -->
				 </div>
			 </div>
			 <div class="col-sm-1 text-center">
				 <h1 class=""><span class="glyphicon glyphicon-transfer"></span></h1>
			 </div>
			 <div class="col-sm-8">
				 <div class="box">
					 <div class="box-header with-border">
						 <h3 class="box-title">All tags</h3>
					 </div>
					 <div class="box-body all-tags">
                    <?php foreach ($types as $type): ?>
                        <?php if (key_exists($type->id, $typesAssn)) {
                            continue;
                        } ?>
							  <span data-id="<?= $type->id ?>" class="cuisine-item"><?= $type->title ?></span>
                    <?php endforeach; ?>
					 </div>
				 </div>
			 </div>
		 </div>
    <?php endif; ?>
</div>
<?php
$js = <<<JS
	$('.all-tags span, .selected-cuisine-types span').on('click',function(e) {
	  e.preventDefault();
	  var c = ($(this).parent().hasClass('all-tags')) ? '.selected-cuisine-types' : '.all-tags';  
	  $(c).append(this);
	})
	
	$('button#update-assn').on('click',function(e) {
	  var ids = [];
	  $('.selected-cuisine-types span').map(function(idx,el) {
	    ids.push($(el).attr('data-id'));
	  });
	  $.ajax({
	   type:"POST",
	   data:{'ids':ids,'category':category},
	   url:'/admin/cuisine-types/category-assn',
	   error:function() {},
	   success:function(data) {
	     if(data){
	       window.location.href = '/admin/cuisine-types/update?alert=1&id=' + category;
	     }
	   }
	  });
	});
JS;
$this->registerJs($js)

?>
