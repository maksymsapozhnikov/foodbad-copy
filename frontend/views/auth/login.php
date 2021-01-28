<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = 'FoodBud | SignIn';
?>
<div class="bg-image  auth-page">

    <header>
        <div class="header-wrapper">
            <div class="header-logo">
                <div class="sign-up-logo-img"></div>
                <img src="/images/Foodbud-Logo.png" alt="">
            </div>
            <div class="header-button">
                <button href="#" class="sign-up-button">Sign in</button>
            </div>
        </div>

    </header>
    <main>
        <section class="sign-up-prompting">
            <h1 class="sign-up-title">Nice to see <br> you again.</h1>
        </section>
        <section class="sign-in-form m-t-40">
            <?php $form = ActiveForm::begin() ?>
            <?= $form->field($model, 'email')->textInput(['placeholder' => 'Enter email']) ?>

            <div class="form-group position-relative password-sign-in">
                <a class="password-forgot brink-link-hover" href="<?= Url::to(['/auth/request-password-reset']) ?>">Forgot it?</a>
                <label class="default-label" for="password">password</label>
                <a class="password-eye" href="#">
                        <span class="password-eye-open d-none">
                            <svg width="23" height="16" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="11.5" cy="8" r="3" stroke="#B39445" stroke-width="2"/><path d="M20.5 8l.83.558.375-.558-.375-.557L20.5 8zm0 0l.83.558v.001l-.002.002-.003.005-.012.017a7.41 7.41 0 01-.188.265 20.644 20.644 0 01-2.583 2.888C16.858 13.286 14.37 15 11.5 15s-5.359-1.715-7.041-3.264a20.648 20.648 0 01-2.584-2.888 12.317 12.317 0 01-.188-.265l-.012-.017-.003-.005-.001-.002h0C1.67 8.557 1.67 8.557 2.5 8m18 0l.83-.558h0l-.002-.002-.003-.005-.012-.017a7.41 7.41 0 00-.188-.266 20.64 20.64 0 00-2.583-2.888C16.858 2.716 14.37 1 11.5 1S6.141 2.715 4.459 4.265a20.645 20.645 0 00-2.584 2.887 12.317 12.317 0 00-.188.266l-.012.017-.003.005-.001.002h0L2.5 8m0 0l-.83.558L1.295 8l.375-.557L2.5 8z" stroke="#B39445" stroke-width="2"/></svg>
                        </span>
                    <span class="password-eye-close ">
                            <svg width="23" height="20" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="11.5" cy="9" r="3" stroke="#B39445" stroke-width="2"/><path d="M20.5 9l.83.558.375-.558-.375-.557L20.5 9zm0 0l.83.558h0l-.002.003-.003.005-.012.016a7.41 7.41 0 01-.188.266 20.634 20.634 0 01-2.583 2.888C16.858 14.286 14.37 16 11.5 16s-5.359-1.715-7.041-3.264a20.638 20.638 0 01-2.584-2.888 12.317 12.317 0 01-.188-.266l-.012-.016-.003-.005-.001-.002h0C1.67 9.557 1.67 9.557 2.5 9m18 0l.83-.558h0l-.002-.002-.003-.006-.012-.016a7.41 7.41 0 00-.188-.266 20.64 20.64 0 00-2.583-2.888C16.858 3.716 14.37 2 11.5 2S6.141 3.715 4.459 5.265a20.645 20.645 0 00-2.584 2.887 12.317 12.317 0 00-.188.266l-.012.016-.003.006-.001.001v.001L2.5 9m0 0l-.83.558L1.295 9l.375-.557L2.5 9z" stroke="#B39445" stroke-width="2"/><g filter="url(#filter0_d)"><path d="M19.5 1l-16 16" stroke="#B39445" stroke-width="2"/></g><defs><filter id="filter0_d" x="2.793" y=".293" width="18.814" height="18.814" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"><feFlood flood-opacity="0" result="BackgroundImageFix"/><feColorMatrix in="SourceAlpha" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"/><feOffset dx="1.4" dy="1.4"/><feColorMatrix values="0 0 0 0 1 0 0 0 0 0.984314 0 0 0 0 0.933333 0 0 0 1 0"/><feBlend in2="BackgroundImageFix" result="effect1_dropShadow"/><feBlend in="SourceGraphic" in2="effect1_dropShadow" result="shape"/></filter></defs></svg>
                        </span>
                </a>
                <?= $form->field($model, 'password',['options' => ['class' => '']])->passwordInput(['placeholder' => 'Enter a password','class' => 'form-control default-input default-input-password','id' => 'password'])->label(false) ?>
            </div>
            <?= Html::submitButton('Sign in', ['class' => 'sign-in-submit btn-lg']) ?>
            <?php ActiveForm::end() ?>
        </section>
    </main>
    <footer>
        <div class="footer-text-block footer-height">
            <span class="sign-up-text">Don’t have an account? <a class="sign-in-link brink-link-hover" href="<?= Url::to(['auth/signup']) ?>">Sign up</a></span>
        </div>
    </footer>
</div>
