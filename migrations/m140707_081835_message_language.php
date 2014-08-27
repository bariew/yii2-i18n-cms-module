<?php use yii\db\Schema;
use yii\db\Migration;
use \bariew\i18nModule\models\MessageLanguage;

class m140707_081835_message_language extends Migration
{
    public function up()
    {
        return $this->createTable(MessageLanguage::tableName(), [
            'id'    => Schema::TYPE_PK,
            'title' => Schema::TYPE_STRING
        ]);
    }

    public function down()
    {
        return $this->dropTable(MessageLanguage::tableName());
    }
}