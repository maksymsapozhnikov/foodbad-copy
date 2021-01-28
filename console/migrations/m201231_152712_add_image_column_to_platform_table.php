<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%platform}}`.
 */
class m201231_152712_add_image_column_to_platform_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%platform}}', 'image', $this->string(50));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%platform}}', 'image');
    }
}
