<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%request_images}}`.
 */
class m201210_162707_create_request_images_table extends Migration
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

        $this->createTable('{{%request_images}}', [
           'id' => $this->primaryKey(),
           'request_id' => $this->integer(11),
           'image' => $this->string(30)
        ], $tableOptions);
        $this->addForeignKey('fk-request_id-messages-id', '{{%request_images}}', 'request_id', '{{%messages}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%request_images}}');
    }
}
