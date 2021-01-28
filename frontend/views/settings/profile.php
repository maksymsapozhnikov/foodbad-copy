<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

/* @var $model \common\models\User */
?>
    <div class="settings-paper">
        <header class="settings-header">
            <div class="container">
                <div class="header-wrapper">
                    <a href="<?= Url::to(['site/index']) ?>" class="back-button">
                        <svg width="16" height="24" viewBox="0 0 16 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0.500002 11.52C0.499183 10.8848 0.783393 10.28 1.28 9.86016L12.432 0.441598C13.2006 -0.177534 14.3435 -0.0943976 15.0061 0.628846C15.6687 1.35209 15.6088 2.45089 14.871 3.10368L5.119 11.3395C5.06485 11.3851 5.03379 11.4509 5.03379 11.52C5.03379 11.5891 5.06485 11.6549 5.119 11.7005L14.871 19.9363C15.3843 20.3498 15.6241 20.9978 15.4975 21.6296C15.3709 22.2613 14.8978 22.7776 14.2613 22.9788C13.6248 23.18 12.9247 23.0344 12.432 22.5984L1.284 13.1827C0.786191 12.7622 0.500631 12.1566 0.500002 11.52Z" fill="#25322F"/>
                        </svg>
                    </a>
                    <span class="settings-title">Profile</span>
                </div>
            </div>
        </header>
        <main class="settings-main">
            <div class="container">
                <div class="img-logo-user text-center">
                    <?php if (!empty($model->image) && is_file($model->fullPath() . $model->image)): ?>
                        <?= Html::img(Yii::$app->params['img_user'] . $model->image, ['id' => 'img-user']) ?>
                    <?php else: ?>
                        <?= Html::img(Yii::$app->params['frontend_url'] . '/images/default.png', ['id' => 'img-user']) ?>
                    <?php endif; ?>
                </div>

                <?php $form = ActiveForm::begin() ?>
                <?= $form->field($model, 'uploadImage')->fileInput(['style' => 'display:none'])->label(false) ?>
                <?= $form->field($model, 'username')->textInput(['placeholder' => 'Name']) ?>
                <?= $form->field($model, 'last_name')->textInput(['placeholder' => 'Last Name']) ?>
                <?= $form->field($model, 'email')->textInput(['placeholder' => 'Email']) ?>
                <?= $form->field($model, 'phone')->widget(MaskedInput::class, ['mask' => '9 (999) 999-99-99']) ?>
                <?= $form->field($model, 'address')->textInput(['placeholder' => 'Address']) ?>
                <div class="text-center"><?= Html::submitButton('Save', ['class' => 'settings-button settings-button-active']) ?></div>
                <?php ActiveForm::end() ?>
            </div>
        </main>
    </div>


<?php
$js = <<<JS
$('.settings-main .img-logo-user img').on('click',function(e) {
  e.preventDefault();
  $('.settings-main #user-uploadimage').click();
});

$('.settings-main #user-uploadimage').change(function (e) {
  var preview = document.getElementById('img-user');
  var file    = document.getElementById('user-uploadimage').files[0];
  var reader  = new FileReader();
    reader.onloadend = function () {
      preview.src = reader.result;
    }
    if (file) {
      reader.readAsDataURL(file);
    } else {
      preview.src = "";
    }
    preview.style.height = '110px';
});

JS;
$this->registerJs($js);
?>