<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = 'FoodBud | Request password reset';
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
         <h1 class="request-password-title">Please fill out your email. A link to reset password will be sent there.</h1>
      </section>
      <section class="sign-in-form m-t-40">
          <?php $form = ActiveForm::begin() ?>
          <?= $form->field($model, 'email')->textInput() ?>
          <?= Html::submitButton('Submit', ['class' => 'sign-in-submit btn-lg']) ?>
          <?php ActiveForm::end() ?>
      </section>
   </main>
</div>
