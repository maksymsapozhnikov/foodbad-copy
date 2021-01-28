<?php

use yii\db\Migration;

/**
 * Class m201114_155020_tbl_delivery
 */
class m201114_155020_tbl_delivery extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%delivery}}', [
           'id' => $this->primaryKey(),
           'platform_id' => $this->integer(11)->notNull(),
           'state_id' => $this->integer(11)->notNull(),
           'suburb_id' => $this->integer(11)->notNull(),
           'restaurant_id' => $this->integer(11)->defaultValue(null),
           'title' => $this->string(100)->notNull(),
           'rating' => $this->double(1),
           'delivery_fee' => $this->double(2),
           'delivery_time' => $this->string(100),
           'average_delivery_time' => $this->integer()->defaultValue(null),
           'image_link' => $this->string(512),
           'image' => $this->string(30),
           'status' => $this->tinyInteger(1)->defaultValue(1),
           'restaurant_suburb' => $this->integer(11),
           'link' => $this->string(512),
           'clean_link' => $this->string(512),
           'pre_order_times' => $this->string(100),
           'cuisine' => $this->string(255),
           'created_at' => $this->integer(11)->unsigned(),
           'updated_at' => $this->integer(11)->unsigned(),
        ], $tableOptions);

        $this->createIndex('idx-delivery-platform_id', '{{%delivery}}', 'platform_id');
        $this->createIndex('idx-delivery-state_id', '{{%delivery}}', 'state_id');
        $this->createIndex('idx-delivery-average_delivery_time', '{{%delivery}}', 'average_delivery_time');
        $this->createIndex('idx-delivery-delivery_fee', '{{%delivery}}', 'delivery_fee');

        $this->addForeignKey('fk-delivery-state_id-suburb-id', '{{%delivery}}', 'state_id', '{{%suburb}}', 'id', 'CASCADE',
           'CASCADE');
        $this->addForeignKey('fk-delivery-suburb_id-suburb-id', '{{%delivery}}', 'suburb_id', '{{%suburb}}', 'id', 'CASCADE',
           'CASCADE');
        $this->addForeignKey('fk-delivery-platform_id-platform-id', '{{%delivery}}', 'platform_id', '{{%platform}}', 'id',
           'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-delivery-restaurant_id-restaurant-id', '{{%delivery}}', 'restaurant_id', '{{%restaurant}}', 'id',
           'SET NULL', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {$this->dropTable('{{%delivery}}');
    }
}
