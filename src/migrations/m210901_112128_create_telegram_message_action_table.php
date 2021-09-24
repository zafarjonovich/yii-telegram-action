<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%telegram_message_action}}`.
 */
class m210901_112128_create_telegram_message_action_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%telegram_message_action}}', [
            'id' => $this->primaryKey(),
            'class' => $this->string(150),
            'key' => $this->char(75),
            'options' => $this->json(),
            'status' => $this->smallInteger(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%telegram_message_action}}');
    }
}
