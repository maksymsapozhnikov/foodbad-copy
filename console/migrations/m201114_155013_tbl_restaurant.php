<?php

use yii\db\Migration;

/**
 * Class m201114_155013_tbl_restaurant
 */
class m201114_155013_tbl_restaurant extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%restaurant}}', [
           'id' => $this->primaryKey(),
           'platform_id' => $this->integer(11)->notNull(),
           'state_id' => $this->integer(11)->notNull(),
           'suburb_id' => $this->integer(11)->notNull(),
           'title' => $this->string(100)->notNull(),
           'image' => $this->string(30),
           'status' => $this->tinyInteger(1)->defaultValue(1),
           'created_at' => $this->integer(11)->unsigned(),
           'updated_at' => $this->integer(11)->unsigned(),
        ], $tableOptions);

        $this->createIndex('idx-restaurant-platform_id', '{{%restaurant}}', 'platform_id');
        $this->createIndex('idx-restaurant-suburb_id', '{{%restaurant}}', 'suburb_id');
        $this->createIndex('idx-restaurant-title', '{{%restaurant}}', 'title');

        $this->addForeignKey('fk-state_id-suburb-id', '{{%restaurant}}', 'state_id', '{{%suburb}}', 'id', 'CASCADE',
           'CASCADE');
        $this->addForeignKey('fk-suburb_id-suburb-id', '{{%restaurant}}', 'suburb_id', '{{%suburb}}', 'id', 'CASCADE',
           'CASCADE');
        $this->addForeignKey('fk-platform_id-platform-id', '{{%restaurant}}', 'platform_id', '{{%platform}}', 'id',
           'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('{{%restaurant}}');
    }
}
