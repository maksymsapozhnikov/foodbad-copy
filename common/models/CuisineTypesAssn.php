<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cuisine_types_assn".
 *
 * @property int $id
 * @property int|null $type_id
 * @property int|null $tag_id
 *
 * @property CuisineTypes $tag
 * @property CuisineTypes $type
 */
class CuisineTypesAssn extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cuisine_types_assn';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
           [['type_id', 'tag_id'], 'integer'],
           [['tag_id'], 'exist', 'skipOnError' => true, 'targetClass' => CuisineTypes::class, 'targetAttribute' => ['tag_id' => 'id']],
           [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => CuisineTypes::class, 'targetAttribute' => ['type_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
           'id' => 'ID',
           'type_id' => 'Type ID',
           'tag_id' => 'Tag ID',
        ];
    }

    /**
     * Gets query for [[Tag]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTag()
    {
        return $this->hasOne(CuisineTypes::class, ['id' => 'tag_id']);
    }

    /**
     * Gets query for [[Type]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(CuisineTypes::class, ['id' => 'type_id']);
    }
}
