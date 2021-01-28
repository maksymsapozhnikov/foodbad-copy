<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%cuisine_types_assn}}`.
 */
class m201119_114329_create_cuisine_types_assn_table extends Migration
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

        $this->createTable('{{%cuisine_types_assn}}', [
            'id' => $this->primaryKey(),
            'type_id' => $this->integer(11),
            'tag_id' => $this->integer(11),
        ],$tableOptions);

        $this->createIndex('idx-cuisine_types_assn-type_id','{{%cuisine_types_assn}}','type_id');
        $this->createIndex('idx-cuisine_types_assn-tag_id','{{%cuisine_types_assn}}','tag_id');

        $this->addForeignKey('fk-type_id-cuisine_types-id','{{%cuisine_types_assn}}','type_id','{{%cuisine_types}}','id','CASCADE','CASCADE');
        $this->addForeignKey('fk-tag_id-cuisine_types-id','{{%cuisine_types_assn}}','tag_id','{{%cuisine_types}}','id','CASCADE','CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%cuisine_types_assn}}');
    }
}
