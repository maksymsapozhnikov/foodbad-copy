<?php

use backend\components\CKEditor;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Page */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Update Page: ' . $model->title;
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="page-form box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"></h3>
        <div class="box-tools pull-right"> </div>
    </div>
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body table-responsive">

        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'body')->widget(CKEditor::class, [
           'options' => ['rows' => 6],
           'preset' => 'basic'
        ]) ?>

    </div>
    <div class="box-footer text-center">
        <?= Html::submitButton('Update', ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
