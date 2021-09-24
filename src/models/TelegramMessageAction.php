<?php

namespace zafarjonovich\YiiTelegramAction\models;

use Yii;
use zafarjonovich\YiiTelegramAction\base\Action;

/**
 * This is the model class for table "telegram_message_action".
 *
 * @property int $id
 * @property int|null $class
 * @property string|null $key
 * @property string|null $options
 * @property int|null $status
 * @property string $created_at
 * @property string $updated_at
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
        $object->created_at = date('Y-m-d H:i:s');
        $object->updated_at = date('Y-m-d H:i:s');

        return $object;
    }
    
    public static function findWaitingAction($key)
    {
        return TelegramMessageAction::findOne([
            'status' => TelegramMessageAction::STATUS_WAITING, 
            'key' => $key
        ]);
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

    public function run($options = [])
    {
        if(!$this->class)
            throw new \Exception('Not instanced');

        $handler = new Action($this);

        return $handler->run($options);
    }
}
