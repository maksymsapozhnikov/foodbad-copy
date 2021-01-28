<?php

/* @var $this \yii\web\View */

/* @var $content string */

use kartik\alert\Alert;
use yii\helpers\Html;
use frontend\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="robots" content="index, follow">
    <meta name="google" content="notranslate">
    <link href="https://fonts.googleapis.com/css2?family=Spartan&display=swap" rel="stylesheet">
    <title><?= Html::encode($this->title) ?></title>

    <!-- All-cuisines.html -->
    <meta name="msapplication-TileColor" content="#009774">
    <meta name="theme-color" content="#009774">
    <!-- end/ -->

    <link href="/images/favicon.png" rel="shortcut icon" type="image/x-icon">
    <link href="/images/webclip.png" rel="apple-touch-icon">
    <?php $this->registerCsrfMetaTags() ?>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="paper">
    <?= \common\widgets\Alert::widget() ?>
    <?= $content ?>
</div>
<?php $this->endBody() ?>
</body>
<?= \common\widgets\ModalWindow::widget() ?>
</html>
<?php $this->endPage() ?>
