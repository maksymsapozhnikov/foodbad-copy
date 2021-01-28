<?php

namespace common\components;

use Imagine\Image\Box;
use Yii;
use yii\helpers\FileHelper;
use yii\imagine\Image;
use yii\web\UploadedFile;

trait FileUpload
{
    public $uploadImage;
    public $uploadImages;
    public $directory = '/images/';
    public $path = '@storage';

    /**
     * @param bool|int $resizeHeight
     * @return bool
     */
    private function uploadImg($resizeHeight = false)
    {
        try{
            $this->uploadImage = UploadedFile::getInstance($this, 'uploadImage');
            if ($this->uploadImage == null) {
                return true;
            }
            $newName = Yii::$app->security->generateRandomString(20) . '.' . 'jpeg';
            FileHelper::createDirectory($this->fullPath());
            if ($this->uploadImage->saveAs($this->fullPath() . $newName)) {
                $this->deleteImage();
                $this->image = $newName;
                if ($resizeHeight) {
                    $this->resizeImage($this->fullPath() . $this->image, $resizeHeight);
                }
                return true;
            }
        }catch (\Exception $e){
            Yii::error('Error uploading image', 'FileUpload');
            return false;
        }

    }

    /**
     * @param param bool|int $resizeHeight
     * @return bool|string
     * @internal param string $attributeName
     */
    private function upload($fileInstance, $resizeHeight = false)
    {
        try{
            $newName = Yii::$app->security->generateRandomString(20) . '.' . 'jpeg';
            FileHelper::createDirectory($this->fullPath());

            if ($fileInstance->saveAs($this->fullPath() . $newName)) {
                if ($resizeHeight) {
                    $this->resizeImage($this->fullPath() . $newName, $resizeHeight);
                }
                return $newName;
            }
        }catch (\Exception $e){
            Yii::error('Error uploading images', 'FileUpload');
            return false;
        }
    }

    public function fullPath()
    {
        return Yii::getAlias($this->path) . $this->directory;
    }

    public function deleteImage()
    {
        if (!empty($this->image) && is_file($this->fullPath() . $this->image)) {
            @unlink($this->fullPath() . $this->image);
        }
    }

    public function deleteMultipleImage($name)
    {
        if (is_file($this->fullPath() . $name)) {
            @unlink($this->fullPath() . $name);
        }
    }

    protected function resizeImage($file, $height = 200)
    {
        $imagine = Image::getImagine();
        $size = getimagesize($file);
        if (!empty($size[1]) && $size[1] > $height) {
            $width = $size[0] * $height / $size[1];
            $image = $imagine->open($file);
            $image->resize(new Box($width, $height))->save($file, ['quality' => 90]);
        }
    }

    /*public function uploadMultipleImg()
    {
        $this->uploadImages = UploadedFile::getInstances($this, 'uploadImages');
        if ($this->uploadImages == null) {
            return true;
        }
        foreach ($this->uploadImages as $file) {
            $this->upload($file,260);
        }
    }*/

}
