<?php

namespace luya\admin\usertoken;

use luya\admin\components\AdminUser;
use luya\admin\events\UserAccessTokenLoginEvent;
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
        
    }
}