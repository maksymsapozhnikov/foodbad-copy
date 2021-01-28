<?php

use yii\db\Migration;

/**
 * Class m201114_145405_tbl_suburbs
 */
class m201114_145405_tbl_suburb extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%suburb}}', [
           'id' => $this->primaryKey(),
           'title' => $this->string()->notNull(),
           'is_state' => $this->tinyInteger(1)->defaultValue(0),
           'state_id' => $this->tinyInteger(10)->null()
        ], $tableOptions);

        $this->createIndex('idx-suburbs-title', '{{%suburb}}', 'title');

        foreach (['ACT', 'NSW', 'NT', 'QLD', 'SA', 'TAS', 'VIC', 'WA'] as $title) {
            Yii::$app->db->createCommand("INSERT INTO {{%suburb}} (title,is_state,state_id) VALUES ('{$title}',1,NULL)")->execute();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('{{%suburb}}');
    }

}
