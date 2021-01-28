<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%favorite}}`.
 */
class m201126_094650_create_favorite_assn_table extends Migration
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
        $this->createTable('{{%favorite_assn}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(11),
            'restaurant_id' => $this->integer(11),
        ],$tableOptions);

        $this->addForeignKey('fk-favorite-user_id-user-id','{{%favorite_assn}}','user_id','{{%user}}','id','CASCADE','CASCADE');
        $this->addForeignKey('fk-favorite-restaurant_id-restaurant-id','{{%favorite_assn}}','restaurant_id','{{%restaurant}}','id','CASCADE','CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%favorite_assn}}');
    }
}
