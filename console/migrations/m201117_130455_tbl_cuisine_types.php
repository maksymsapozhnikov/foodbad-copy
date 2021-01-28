<?php

use yii\db\Migration;

/**
 * Class m201117_130455_tbl_cuisine_types
 */
class m201117_130455_tbl_cuisine_types extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%cuisine_types}}', [
           'id' => $this->primaryKey(),
           'code_api' => $this->string(255)->unique()->notNull(),
           'title' => $this->string(255)->notNull(),
           'status' => $this->tinyInteger(1),
           'category' => $this->tinyInteger(1)->defaultValue(2),
        ], $tableOptions);

        $this->createIndex('idx-cuisine_types-title','{{%cuisine_types}}','title');

        $types = ['American','Asian','Bakery','Burgers','Cafe','Fast food','European','Indian','British','Italian','Japanese','Health Food','Mexican','Middle eastern','Mediterranean','Vegan','Desserts','Convenience','South east asian','Latin american','Other'];
        foreach ($types as $type){
            Yii::$app->db->createCommand("INSERT INTO cuisine_types (code_api, title, status, category) VALUES ('". strtolower($type) ."','". $type ."',1,1);")->execute();
        }
    }


    public function down()
    {
        $this->dropTable('{{%cuisine_types}}');
    }

}
