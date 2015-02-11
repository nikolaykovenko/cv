<?php

use yii\db\Schema;
use yii\db\Migration;

/**
 * Создание таблицы настроек
 */
class m150211_060947_add_settings_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('settings', [
            'id' => Schema::TYPE_PK,
            'param' => Schema::TYPE_STRING . ' NOT NULL',
            'value' => Schema::TYPE_TEXT . ' NOT NULL',
            'locked' => Schema::TYPE_BOOLEAN . ' DEFAULT 0',
        ]);
        
        $this->createIndex('param_index', 'settings', 'param', true);
    }

    public function safeDown()
    {
        $this->dropTable('settings');

        return true;
    }
}
