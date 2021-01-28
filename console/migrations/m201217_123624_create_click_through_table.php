<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%click_through}}`.
 */
class m201217_123624_create_click_through_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%click_through}}', [
           'id' => $this->primaryKey(),
           'delivery_id' => $this->integer()->notNull(),
           'quantity' => $this->integer()->notNull(),
           'created_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('idx-click_statistics-delivery_id','{{%click_through}}','delivery_id');
        $this->createIndex('idx-click_statistics-created_at','{{%click_through}}','created_at');
        $this->addForeignKey('fk-delivery_id-delivery-id','{{%click_through}}','delivery_id','{{%delivery}}','id','CASCADE','CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%click_through}}');
    }
}
