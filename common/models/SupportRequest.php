<?php

namespace common\models;

use common\components\FileUpload;
use common\models\Messages;
use common\models\RequestImages;
use Yii;
use yii\web\UploadedFile;

class SupportRequest extends Messages
{
    use FileUpload;

    public function init()
    {
        $this->directory = '/support/';
        $this->path = '@backendStorage';
        $this->category = self::CATEGORY_SUPPORT_REQUEST;
        parent::init();
    }

    public function rules()
    {
        $rules = parent::rules();
        $rules[] = [['uploadImages'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif', 'maxFiles' => 5];
        $rules[] = [['body'], 'required','message' => 'Cannot be blank'];
        return $rules;
    }


    function afterDelete()
    {
        if(!empty($this->requestImages)){
            /** @var RequestImages $item */
            foreach ($this->requestImages as $item){
                $this->deleteMultipleImage($item->image);
            }
        }
    }

    /**
     * @return bool
     */
    public function send()
    {
        $this->status = self::STATUS_UNREAD;
        $this->from = \Yii::$app->user->identity->getId();
        if ($this->save()) {
            $this->uploadMultipleImg();
            (new SendEmail())->sendSupportRequest($this->id);
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    protected function uploadMultipleImg()
    {
        $this->uploadImages = UploadedFile::getInstances($this, 'uploadImages');
        if ($this->uploadImages == null) {
            return true;
        }
        foreach ($this->uploadImages as $file) {
            $imgName = $this->upload($file, 460);
            if ($imgName) {
                $this->saveImg($imgName);
            }
        }
    }

    /**
     * @param string $name
     * @return bool
     */
    protected function saveImg($name)
    {
        $model = new RequestImages();
        $model->setAttributes([
           'request_id' => $this->id,
           'image' => $name
        ]);
        return $model->save();
    }

}
