<?php

namespace zafarjonovich\YiiTelegramAction\models;

use Yii;

/**
 * This is the model class for table "telegram_message_action_child".
 *
 * @property int $id
 * @property int|null $parent_id
 * @property int|null $chat_id
 * @property int|null $message_id
 * @property int|null $status
 *
 * @property TelegramMessageAction $parent
 */
class TelegramMessageActionChild extends \yii\db\ActiveRecord
{
    public const STATUS_DELETED = 0;
    public const STATUS_WAITING = 1;
    public const STATUS_RUN = 2;
    public const STATUS_FAILED = 3;

    public static function create($actionId,$chatId,$messageId = null)
    {
        $object = new TelegramMessageActionChild();
        $object->parent_id = $actionId;
        $object->chat_id = $chatId;
        $object->message_id = $messageId;
        $object->status = self::STATUS_WAITING;
        $object->save();

        return $object;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'telegram_message_action_child';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id', 'chat_id', 'message_id', 'status'], 'integer'],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => TelegramMessageAction::className(), 'targetAttribute' => ['parent_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'chat_id' => Yii::t('app', 'Chat ID'),
            'message_id' => Yii::t('app', 'Message ID'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * Gets query for [[Parent]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(TelegramMessageAction::className(), ['id' => 'parent_id']);
    }
}
