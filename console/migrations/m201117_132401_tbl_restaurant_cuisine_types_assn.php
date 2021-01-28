<?php

use yii\db\Migration;

/**
 * Class m201117_132401_tbl_restaurant_cuisine_types_assn
 */
class m201117_132401_tbl_restaurant_cuisine_types_assn extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%restaurant_cuisine_types_assn}}', [
           'id' => $this->primaryKey(),
           'restaurant_id' => $this->integer(11)->notNull(),
           'cuisine_type_id' => $this->integer(11)->notNull(),
        ], $tableOptions);

        $this->createIndex('idx-assn-restaurant_id','{{%restaurant_cuisine_types_assn}}','restaurant_id');
        $this->createIndex('idx-assn-cuisine_type_id','{{%restaurant_cuisine_types_assn}}','cuisine_type_id');

        $this->addForeignKey('fk-restaurant_id-restaurant-id','{{%restaurant_cuisine_types_assn}}','restaurant_id','{{%delivery}}','id','CASCADE','CASCADE');
        $this->addForeignKey('fk-cuisine_type_id-cuisine_types-id','{{%restaurant_cuisine_types_assn}}','cuisine_type_id','{{%cuisine_types}}','id','CASCADE','CASCADE');

    }

    public function down()
    {
        $this->dropTable('{{%restaurant_cuisine_types_assn}}');
    }
}
