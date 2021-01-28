<?php

namespace backend\components;

use yii\helpers\Url;

/*
 <?= $form->field($model, 'body')->widget(CKEditor::className(), [
			'options' => ['rows' => 6],
			'preset' => 'basic'
		]) ?>
 */

class CKEditor extends \dosamigos\ckeditor\CKEditor {

	/**
	 * @inheritdoc
	 */
	public function init () {
		$this->preset = 'custom';
		$this->clientOptions = [
			'language' => \Yii::$app->language,
			'extraPlugins' => 'autogrow',
			'autoGrow_onStartup' => true,
			'autoGrow_maxHeight' => 1000,
			'autoGrow_bottomSpace' => 50,
			'contentsCss' => [
				//\Yii::getAlias('@web/frontend/static/css/bootstrap.css'),
			],
			'toolbarGroups' => [
				['name' => 'document', 'groups' => ['mode', 'document', 'doctools']],
				['name' => 'clipboard', 'groups' => ['clipboard', 'undo']],
				['name' => 'basicstyles', 'groups' => ['basicstyles', 'colors', 'cleanup']],
				['name' => 'paragraph', 'groups' => ['list', 'indent', 'blocks', 'align']],
				['name' => 'links', 'groups' => ['links']],
				['name' => 'insert'],
				['name' => 'styles'],
				['name' => 'colors'],
				['name' => 'tools'],
			],
			'removeButtons' => 'Subscript,Superscript,About,SpecialChar,Anchor',
		];
		parent::init();
	}
}