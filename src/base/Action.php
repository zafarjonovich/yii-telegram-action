<?php


namespace zafarjonovich\YiiTelegramAction\base;


use zafarjonovich\YiiTelegramAction\models\TelegramMessageAction;
use \yii\base\Action as YiiAction;

class Action
{
    public $action;

    /**
     * @var YiiAction $controllerAction
     */
    public $controllerAction;

    /**
     * @var Actionable $handler
     */
    private $handler;

    public function __construct(TelegramMessageAction $action,YiiAction &$controllerAction)
    {
        $this->action = $action;
        $this->controllerAction = $controllerAction;

        /**
         * @var Actionable $handler
         */
        $this->handler = \Yii::createObject([
            'class' => $action->class,
            'parent' => $this,
        ]);
    }

    public function run()
    {
        $result = $this->handler->run();

        $this->action->status = TelegramMessageAction::STATUS_RUN;
        $this->action->save();

        return $result;
    }
}