<?php

namespace zafarjonovich\YiiTelegramAction\models;

use Yii;

/**
 * This is the model class for table "telegram_message_action".
 *
 * @property int $id
 * @property int|null $class
 * @property string|null $key
 * @property string|null $options
 * @property int|null $status
 *
 * @property TelegramMessageActionChild[] $telegramMessageActionChildren
 */
class TelegramMessageAction extends \yii\db\ActiveRecord
{
    public const STATUS_DELETED = 0;
    public const STATUS_WAITING = 1;
    public const STATUS_RUN = 2;

    public static function create($key,$class,$options = [])
    {
        $object = new TelegramMessageAction();
        $object->class = $class;
        $object->key = $key;
        $object->options = $options;
        $object->status = self::STATUS_WAITING;
        $object->save();

        return $object;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'telegram_message_action';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['options'], 'safe'],
            [['key'], 'string','max' => 75],
            [['class'], 'string','max' => 150],
        ];
    }


    /**
     * Gets query for [[TelegramMessageActionChildren]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTelegramMessageActionChildren()
    {
        return $this->hasMany(TelegramMessageActionChild::className(), ['parent_id' => 'id']);
    }
}
