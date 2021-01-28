<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%restaurant}}`.
 */
class m210112_090310_add_place_details_and_place_details_updated_at_columns_to_restaurant_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%restaurant}}', 'place_details', $this->text());
        $this->addColumn('{{%restaurant}}', 'place_details_updated_at', $this->integer()->null());
        $this->addColumn('{{%restaurant}}', 'price_level', $this->tinyInteger()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%restaurant}}', 'place_details');
        $this->dropColumn('{{%restaurant}}', 'place_details_updated_at');
        $this->dropColumn('{{%restaurant}}', 'price_level');
    }
}
