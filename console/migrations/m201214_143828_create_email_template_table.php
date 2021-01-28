<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%email_template}}`.
 */
class m201214_143828_create_email_template_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%email_template}}', [
            'id' => $this->primaryKey(),
            'category' => $this->tinyInteger(),
            'title' => $this->string(256),
            'body' => $this->text(),
        ]);

        $i = 1;
        while ($i <= 10){
            Yii::$app->db->createCommand("INSERT INTO{{%email_template}} (category) VALUES ({$i})")->execute();
            $i++;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%email_template}}');
    }
}
