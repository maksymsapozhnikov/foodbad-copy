<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%page}}`.
 */
class m201231_104438_create_page_table extends Migration
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
        $this->createTable('{{%page}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255),
            'status' => $this->tinyInteger(),
            'body' => $this->text(),
        ],$tableOptions);

        Yii::$app->db->createCommand('INSERT INTO `page` (title,status) VALUES ("FAQs",1)')->execute();
        Yii::$app->db->createCommand('INSERT INTO `page` (title,status) VALUES ("About Foodbud",1)')->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%page}}');
    }
}
