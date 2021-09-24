<?php


namespace zafarjonovich\YiiTelegramAction\base;


use zafarjonovich\YiiTelegramAction\models\TelegramMessageAction;
use \yii\base\Action as YiiAction;

class Action
{
    public $action;

    public function __construct(TelegramMessageAction $action)
    {
        $this->action = $action;
    }

    public function run($options = [])
    {
        if($this->action->status == TelegramMessageAction::STATUS_WAITING) {

            $mainProperties = [
                'class' => $this->action->class,
                'parent' => $this,
            ];

            $properties = array_merge(
                $mainProperties,
                $options,
                $this->action->options
            );

            /**
             * @var Actionable $handler
             */
            $handler = \Yii::createObject($properties);

            $result = $handler->run();

            $this->action->status = TelegramMessageAction::STATUS_RUN;
            $this->action->save();

            return $result;
        }

        return false;
    }
}