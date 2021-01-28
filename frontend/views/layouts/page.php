<?php

/* @var $this \yii\web\View */

/* @var $content string */

use common\widgets\Alert;
use yii\helpers\Html;
use frontend\assets\AppAsset;

\frontend\assets\PageAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link href="/images/favicon.png" rel="shortcut icon" type="image/x-icon">
    <link href="/images/webclip.png" rel="apple-touch-icon">
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div id="container_wrapper">
    <?= Alert::widget() ?>
    <?= $content ?>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
