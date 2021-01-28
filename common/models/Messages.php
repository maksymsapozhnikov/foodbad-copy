<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "messages".
 *
 * @property int $id
 * @property int|null $status
 * @property int|null $category
 * @property int|null $parent_id
 * @property string|null $title
 * @property string|null $body
 * @property int|null $to
 * @property int|null $from
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Messages $parent
 * @property Messages[] $messages
 */
class Messages extends \yii\db\ActiveRecord
{
    const STATUS_DRAFT     = 0;
    const STATUS_PUBLISHED = 1;
    const STATUS_UNREAD    = 2;
    const STATUS_READ      = 3;
    const STATUS_CONTACTED = 4;
    const STATUS_APPROVED  = 5;
    const STATUS_REJECTED  = 6;
    const STATUS_CLOSED    = 7;
    const STATUS_TRASH     = 8;
    const STATUS_DELETED   = 9;

    const CATEGORY_SUPPORT_REQUEST = 1;
    const CATEGORY_NOTIFICATION    = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'messages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
           [['status', 'category', 'parent_id', 'to', 'from', 'created_at', 'updated_at'], 'integer'],
           [['title'], 'string', 'max' => 255],
           [['body'], 'string', 'max' => 1024],
           [['body', 'title'], 'filter', 'filter' => 'strip_tags'],
           [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Messages::class, 'targetAttribute' => ['parent_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
           'id' => 'ID',
           'status' => 'Status',
           'category' => 'Category',
           'parent_id' => 'Parent ID',
           'title' => 'Title',
           'body' => 'Body',
           'to' => 'To',
           'from' => 'From',
           'created_at' => 'Created At',
           'updated_at' => 'Updated At',
        ];
    }

    public function behaviors()
    {
        return [
           TimestampBehavior::class,
        ];
    }

    /**
     * Gets query for [[Parent]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Messages::class, ['id' => 'parent_id']);
    }

    /**
     * Gets query for [[Messages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Messages::class, ['parent_id' => 'id']);
    }

    /**
     * @return array
     */
    public static function statusList()
    {
        return [
           self::STATUS_DRAFT => 'Draft',
           self::STATUS_PUBLISHED => 'Published/Active',
           self::STATUS_UNREAD => 'Unread',
           self::STATUS_READ => 'Read',
           self::STATUS_CONTACTED => 'Contacted',
           self::STATUS_APPROVED => 'Approved',
           self::STATUS_REJECTED => 'Rejected',
           self::STATUS_CLOSED => 'Closed',
           self::STATUS_TRASH => 'Trash',
           self::STATUS_DELETED => 'Deleted',
        ];
    }

    /**
     * @return array
     */
    public static function statusListForRequest()
    {
        return [
           self::STATUS_UNREAD => 'Unread',
           self::STATUS_READ => 'Read',
           self::STATUS_CLOSED => 'Closed',
        ];
    }

    public function getFromUser(){
        return $this->hasOne(User::class,['id' => 'from']);
    }

    public function getRequestImages(){
        return $this->hasMany(RequestImages::class,['request_id' => 'id']);
    }

}
