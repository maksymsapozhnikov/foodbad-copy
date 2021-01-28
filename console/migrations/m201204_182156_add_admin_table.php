<?php

use yii\db\Migration;

/**
 * Class m201204_182156_add_admin_table
 */
class m201204_182156_add_admin_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%admin}}', [
           'id' => $this->primaryKey(),
           'username' => $this->string()->notNull(),
           'last_name' => $this->string()->notNull(),
           'auth_key' => $this->string(32)->notNull(),
           'password_hash' => $this->string()->notNull(),
           'email' => $this->string()->notNull()->unique(),
           'status' => $this->smallInteger()->notNull()->defaultValue(10),
           'created_at' => $this->integer(),
           'updated_at' => $this->integer(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%admin}}');
    }
}
