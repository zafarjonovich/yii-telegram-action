<?php


namespace zafarjonovich\YiiTelegramAction\base;


use zafarjonovich\YiiTelegramAction\models\TelegramMessageAction;

class ChildAction implements Actionable
{
    /**
     * @var Action $parent
     */
    public $parent;

    public function run()
    {
        return false;
    }
}