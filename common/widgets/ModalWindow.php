<?php

namespace common\widgets;

use Yii;
use yii\bootstrap4\Modal;

class ModalWindow extends \yii\bootstrap\Widget
{
    public $alertTypes = [
       'error-message' => 'alert-danger',
       'success-message' => 'alert-success',
       'info-message' => 'alert-info',
    ];

    public $closeButton = [];

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $session = Yii::$app->session;
        $flashes = $session->getAllFlashes();
        $flash = null;

        foreach ($flashes as $type => $value) {
            $flash = (isset($this->alertTypes[$type])) ? $value : null;
            $session->removeFlash($type);
        }

        return $this->render('modal-window', [
           'flash' => $flash,
           'type' => $type
        ]);
    }
}
