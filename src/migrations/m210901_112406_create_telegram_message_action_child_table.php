<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%telegram_message_action_child}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%telegram_message_action}}`
 */
class m210901_112406_create_telegram_message_action_child_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%telegram_message_action_child}}', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer(),
            'chat_id' => $this->integer(20),
            'message_id' => $this->integer(25),
            'status' => $this->smallInteger(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime()
        ]);

        // creates index for column `parent_id`
        $this->createIndex(
            '{{%idx-telegram_message_action_child-parent_id}}',
            '{{%telegram_message_action_child}}',
            'parent_id'
        );

        // add foreign key for table `{{%telegram_message_action}}`
        $this->addForeignKey(
            '{{%fk-telegram_message_action_child-parent_id}}',
            '{{%telegram_message_action_child}}',
            'parent_id',
            '{{%telegram_message_action}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%telegram_message_action}}`
        $this->dropForeignKey(
            '{{%fk-telegram_message_action_child-parent_id}}',
            '{{%telegram_message_action_child}}'
        );

        // drops index for column `parent_id`
        $this->dropIndex(
            '{{%idx-telegram_message_action_child-parent_id}}',
            '{{%telegram_message_action_child}}'
        );

        $this->dropTable('{{%telegram_message_action_child}}');
    }
}
