<?php

use kartik\file\FileInput;

?>
<?php if (!$customCss): ?>
	<style>
		.img-upload-block{
		}
	</style>
<?php endif; ?>

<div class="img-upload-block">
    <?php echo $form->field($model, $attributeName)->widget(FileInput::class, [
       'options' => [
          'accept' => 'image/*',
          'multiple' => $multiple,
	       'id' => 'input-upload-image',
          'maxFileCount' => 3,
	        //allowedFileExtensions: ["jpg", "png", "gif"],
       ],
       'pluginOptions' => [
          'showPreview' => true,
          'showCaption' => false,
          'showRemove' => false,
          'showUpload' => false,
          'initialPreview' => [],
          'initialPreviewAsData' => true,
          'overwriteInitial' => false,
          'maxFileSize' => 6144,
          'hideThumbnailContent' => false,
          'showClose' => false,
          'showBrowse' => true,

          'dropZoneEnabled' => false,

       ]
    ])->label(false);
    ?>
</div>

<?php
$js = <<<JS
$('.{$buttonBrowseClass}').on('click',function() {
  $('#input-upload-image').click();
});
JS;
$this->registerJs($js);
?>

