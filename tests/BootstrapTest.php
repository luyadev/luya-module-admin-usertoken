<?php

namespace luya\admin\usertoken\tests;

use luya\admin\events\UserAccessTokenLoginEvent;
use luya\admin\usertoken\Bootstrap;
use luya\admin\usertoken\models\Token;
use luya\testsuite\fixtures\NgRestModelFixture;

class BootstrapTest extends UserTokenTestCase
{
    public function testBootstrap()
    {
        $bootstrap = new Bootstrap();
        
        $this->assertEmpty($bootstrap->bootstrap($this->app));

        new NgRestModelFixture(['modelClass' => Token::class]);
        
        $bootstrap->loginByToken(new UserAccessTokenLoginEvent());
        
    }
}