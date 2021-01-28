<?php

namespace common\widgets;

use yii\base\Widget;

class FileInput extends Widget
{
    public $model;
    public $attributeName;
    public $form;
    public $options = [];
    public $multiple = false;
    public $customCss = false;

    public function run()
    {
        return $this->render('file-input', [
           'model' => $this->model,
           'attributeName' => $this->attributeName,
           'options' => $this->options,
           'multiple' => $this->multiple,
           'form' => $this->form,
           'customCss' => $this->customCss,
           'buttonBrowseClass' => $this->buttonBrowseClass
        ]);
    }
}