<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/**
 * @var $model \frontend\models\ChangePassword
 */
?>
<div class="settings-paper security-page">
    <header class="settings-header">
        <div class="container">
            <div class="header-wrapper">
                <a href="<?= Url::to(['site/index']) ?>" class="back-button">
                    <svg width="16" height="24" viewBox="0 0 16 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0.500002 11.52C0.499183 10.8848 0.783393 10.28 1.28 9.86016L12.432 0.441598C13.2006 -0.177534 14.3435 -0.0943976 15.0061 0.628846C15.6687 1.35209 15.6088 2.45089 14.871 3.10368L5.119 11.3395C5.06485 11.3851 5.03379 11.4509 5.03379 11.52C5.03379 11.5891 5.06485 11.6549 5.119 11.7005L14.871 19.9363C15.3843 20.3498 15.6241 20.9978 15.4975 21.6296C15.3709 22.2613 14.8978 22.7776 14.2613 22.9788C13.6248 23.18 12.9247 23.0344 12.432 22.5984L1.284 13.1827C0.786191 12.7622 0.500631 12.1566 0.500002 11.52Z" fill="#25322F"/>
                    </svg>
                </a>
                <span class="settings-title">Privacy & Security</span>
            </div>
        </div>
    </header>
    <main class="settings-main">
        <div class="container">
            <?php $form = ActiveForm::begin([
               'enableClientValidation' => false,
               'enableAjaxValidation' => true,
            ]) ?>
            <?= $form->field($model, 'current_password')->passwordInput()->label() ?>
            <p>If you forgot your password you can <?= Html::a('reset it', ['settings/password-reset']) ?>.</p>
            <?= $form->field($model, 'new_password')->passwordInput()->label() ?>
            <?= $form->field($model, 'retype_password')->passwordInput()->label() ?>
            <?= Html::submitButton('Submit', ['class' => 'settings-button settings-button-active']) ?>
            <?php ActiveForm::end() ?>
        </div>
    </main>
</div>