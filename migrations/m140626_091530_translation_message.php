<?php

use yii\db\Schema;

class m140626_091530_translation_message extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('source_message', [
            'id'    => 'INTEGER PRIMARY KEY AUTO_INCREMENT',
            'category'  => 'VARCHAR(32)',
            'message'   => 'TEXT'
        ]);
        $this->createTable('message', [
            'id'    => 'INTEGER',
            'language'  => 'VARCHAR(16)',
            'translation'   => 'TEXT'
        ]);
        $this->addPrimaryKey('pk', 'message', 'id, language');
        $this->addForeignKey('fk_message_source_message', 'message', 'id', 'source_message', 'id');
    }

    public function down()
    {
        $this->dropForeignKey('fk_message_source_message', 'message');
        $this->dropTable('message');
        $this->dropTable('source_message');

        return true;
    }
}
