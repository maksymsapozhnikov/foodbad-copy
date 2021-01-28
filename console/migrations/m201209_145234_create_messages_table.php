<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%messages}}`.
 */
class m201209_145234_create_messages_table extends Migration
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
        $this->createTable('{{%messages}}', [
           'id' => $this->primaryKey(),
           'status' => $this->tinyInteger(1),
           'category' => $this->tinyInteger(1),
           'parent_id' => $this->integer(11),
           'title' => $this->string(255),
           'body' => $this->string(1024),
           'to' => $this->integer(11),
           'from' => $this->integer(11),
           'created_at' => $this->integer(11)->unsigned(),
           'updated_at' => $this->integer(11)->unsigned(),
        ], $tableOptions);
        $this->addForeignKey('fk-parent_id-messages-id','{{%messages}}','parent_id','{{%messages}}','id','CASCADE','CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%messages}}');
    }
}
