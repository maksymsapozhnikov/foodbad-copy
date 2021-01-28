<?php

use yii\db\Migration;

/**
 * Class m201114_153550_tbl_platform
 */
class m201114_153550_tbl_platform extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%platform}}', [
           'id' => $this->primaryKey(),
           'code_api' => $this->string(100)->notNull(),
           'title' => $this->string(100)->notNull(),
           'status' => $this->tinyInteger(1)->defaultValue(1),
           'commission_min' => $this->integer()->null(),
           'commission_max' => $this->integer()->null(),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('{{%platform}}');
    }
}
