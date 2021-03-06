<?php

namespace luya\admin\usertoken;

use luya\admin\events\UserAccessTokenLoginEvent;
use luya\admin\models\User;
use luya\admin\Module;
use luya\admin\usertoken\models\Token;
use yii\base\BootstrapInterface;

/**
 * Bootstrap login by token.
 * 
 * @author Basil Suter <git@nadar.io>
 * @since 1.0.0
 */
class Bootstrap implements BootstrapInterface
{
    /**
     * {@inheritDoc}
     */
    public function bootstrap($app)
    {
        $app->on(Module::EVENT_USER_ACCESS_TOKEN_LOGIN, [$this, 'loginByToken']);
    }

    /**
     * Login by Token
     *
     * @param UserAccessTokenLoginEvent $event
     */
    public function loginByToken(UserAccessTokenLoginEvent $event)
    {
        $token = Token::find()->where(['token' => $event->token])->one();

        if ($token) {
            $event->login(User::findOne($token->user_id));
        }
    }
}