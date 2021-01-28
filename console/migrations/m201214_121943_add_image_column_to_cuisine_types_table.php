<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%cuisine_types}}`.
 */
class m201214_121943_add_image_column_to_cuisine_types_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%cuisine_types}}', 'image', $this->string(30));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%cuisine_types}}', 'image');
    }
}
