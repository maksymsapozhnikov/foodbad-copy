<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%user}}`.
 */
class m201120_210414_add_suburb_id_column_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'suburb_id', $this->integer(11)->defaultValue(null));

        $this->addForeignKey('fk-user-suburb_id-suburb-id','{{%user}}','suburb_id','{{%suburb}}','id','SET NULL','CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%user}}', 'suburb_id');
    }
}
