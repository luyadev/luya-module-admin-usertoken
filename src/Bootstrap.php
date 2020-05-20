<?php

namespace luya\admin\usertoken;

use luya\admin\components\AdminUser;
use luya\admin\events\UserAccessTokenLoginEvent;
use luya\admin\models\User;
use luya\admin\usertoken\models\Token;
use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $app->adminuser->on('eventUserAccessTokenLogin', [
            $this, 'loginByToken'
        ]); // replace by constant
    }

    public function loginByToken(UserAccessTokenLoginEvent $event)
    {
        $token = Token::find()->where(['token' => $event->token])->one();

        if ($token) {
            $event->setUser(User::findOne($token->user_id));
        }
    }
}