<?php use yii\db\Schema;
use yii\db\Migration;

class m140707_081835_message_language extends Migration
{
    public function up()
    {
        $this->createTable('message_language', [
            'id'    => Schema::TYPE_PK,
            'title' => Schema::TYPE_STRING
        ]);
    }

    public function down()
    {
        $this->dropTable('message_language');

        return true;
    }
}