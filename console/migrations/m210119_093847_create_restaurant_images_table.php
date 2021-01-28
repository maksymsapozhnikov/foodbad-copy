<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%restaurant_images}}`.
 */
class m210119_093847_create_restaurant_images_table extends Migration
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

        $this->createTable('{{%restaurant_images}}', [
           'id' => $this->primaryKey(),
           'restaurant_id' => $this->integer(),
           'status' => $this->tinyInteger(1)->defaultValue(1),
           'platform' => $this->tinyInteger(1),
           'image' => $this->string(50),
           'photo_reference' => $this->string(512),
           'created_at' => $this->integer()
        ], $tableOptions);

        $this->createIndex('restaurant_images-restaurant_id', '{{%restaurant_images}}', 'restaurant_id');
        $this->addForeignKey('restaurant_id-restaurant-id', '{{%restaurant_images}}', 'restaurant_id', '{{%restaurant}}', 'id', 'CASCADE', 'CASCADE');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%restaurant_images}}');
    }
}
