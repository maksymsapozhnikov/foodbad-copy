<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'FoodBud | Reset password';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bg-image auth-page">

   <header>
      <div class="header-wrapper">
         <div class="header-logo">
            <div class="sign-up-logo-img"></div>
            <img src="/images/Foodbud-Logo.png" alt="">
         </div>
      </div>
   </header>
   <main>
      <section class="sign-up-prompting">
         <h1 class="request-password-title">Please choose your new password:</h1>
      </section>
      <section class="sign-in-form m-t-40">
          <?php $form = ActiveForm::begin() ?>
          <?= $form->field($model, 'password')->passwordInput([]) ?>
          <?= Html::submitButton('Save', ['class' => 'sign-in-submit btn-lg']) ?>
          <?php ActiveForm::end() ?>
      </section>
   </main>
</div>
