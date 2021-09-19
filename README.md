# Yii telegram action

This component helps to run telegram actions with async

## Installation

`php yii migrate --migrationPath="@vendor/zafarjonovich/yii-telegram-action/src/migrations"`


## Working with component

```php
use zafarjonovich\YiiTelegramAction\models\TelegramMessageAction;
use \zafarjonovich\YiiTelegramAction\models\TelegramMessageActionChild;
use zafarjonovich\YiiTelegramAction\base\ChildAction;
use \zafarjonovich\YiiTelegramAction\base\Action;

class SendNotification extends ChildAction
{
    public function run(){
    
        $children = $this->parent->action->getTelegramMessageActionChildren()->all();
        
        $options = $this->parent->action->options;
        
        foreach ($children as $child) {
            \Yii::$app->telegram->sendMessage($child->chat_id,$options['text']);
        }
    }
}

$options = [
    'text' => 'Hello world'
];

$action = TelegramMessageAction::create('UniqueKey',SendNotification::class,$options);

// id = 7
TelegramMessageActionChild::create($action->id,666000111);


// For run action

class SomeControllerAction extends \yii\base\Action
{
    
}

$controllerAction = new SomeControllerAction();

$asyncAction = new Action($action,$controllerAction);
$asyncAction->run();
```


