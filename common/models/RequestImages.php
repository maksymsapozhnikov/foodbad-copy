<?php

namespace common\models;

use common\components\FileUpload;
use Yii;

/**
 * This is the model class for table "request_images".
 *
 * @property int $id
 * @property int|null $request_id
 * @property string|null $image
 *
 * @property Messages $request
 */
class RequestImages extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'request_images';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['request_id'], 'integer'],
            [['image'], 'string', 'max' => 30],
            [['request_id'], 'exist', 'skipOnError' => true, 'targetClass' => Messages::class, 'targetAttribute' => ['request_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'request_id' => 'Request ID',
            'image' => 'Image',
        ];
    }

    /**
     * Gets query for [[Request]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRequest()
    {
        return $this->hasOne(Messages::class, ['id' => 'request_id']);
    }
}
