<?php

namespace luya\admin\usertoken\tests\crud;

use luya\admin\usertoken\apis\LoginController;
use luya\admin\usertoken\models\App;
use luya\admin\usertoken\models\Token;
use luya\admin\usertoken\tests\UserTokenTestCase;
use luya\testsuite\fixtures\NgRestModelFixture;
use yii\base\InvalidArgumentException;

class LoginControllerTest extends UserTokenTestCase
{
    /**
     * @var LoginController
     */
    public $controller;

    public $appFixture;

    public $tokenFixture;

    public function afterSetup()
    {
        parent::afterSetup();
        $this->createAdminLangFixture();
        $this->appFixture = new NgRestModelFixture(['modelClass' => App::class]);
        $this->tokenFixture = new NgRestModelFixture(['modelClass' => Token::class]);
        $this->controller = new LoginController('login', $this->app->getModule('admin'));
    }

    public function testUnknownApp()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->controller->actionIndex();
    }
}