<?php

namespace luya\admin\usertoken\tests\crud;

use luya\admin\models\User;
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

    /**
     * @var NgRestModelFixture
     */
    public $appFixture;

    /**
     * @var NgRestModelFixture
     */
    public $tokenFixture;

    /**
     * @var App
     */
    public $appModel;

    public $userPw = 'FooBar2020!Test!123@';

    /**
     * @var User
     */
    public $userModel;

    public function afterSetup()
    {
        parent::afterSetup();
        $this->createAdminLangFixture();
        $this->createAdminNgRestLogFixture();

        $this->appFixture = new NgRestModelFixture(['modelClass' => App::class]);
        $this->tokenFixture = new NgRestModelFixture(['modelClass' => Token::class]);

        $this->appModel = $this->appFixture->newModel;
        $this->appModel->name = 'test';
        $this->appModel->is_multiple_auth_allowed = 1;
        $this->appModel->save();

        $this->createAdminUserFixture([
            1 => [
                'id' => 1,
                'email' => 'john@luya.io',
                'password' => $this->userPw,
                'firstname' => 'Basil',
                'is_deleted' => 0,
                'is_api_user' => 0,
            ]
        ]);

        $this->userModel = User::findOne(1);
        $this->userModel->encodePassword();
        $this->userModel->update(true, ['password', 'password_salt']);

        $this->controller = new LoginController('login', $this->app->getModule('usertoken'));
    }

    public function testUnknownApp()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->controller->actionIndex();
    }

    public function testFindAppEmptyUserLoginCredentials()
    {
        $this->app->request->setBodyParams(['app' => $this->appModel->token]);

        $this->controller->actionIndex();

        $this->assertNotEmpty($this->controller->actions());

        // validation error because of missing email and password
        $this->assertSame(422, $this->app->response->statusCode);
    }

    public function testSuccessfullUserAuth()
    {
        $this->app->request->setBodyParams([
            'app' => $this->appModel->token,
            'email' => 'john@luya.io',
            'password' => $this->userPw,
        ]);

        // multi auth allowed generates new tokens
        $r = $this->controller->actionIndex();
        $this->assertSame(1, $r->login_count);
        $this->assertSame(1, $r->id);

        $r = $this->controller->actionIndex();
        $this->assertSame(1, $r->login_count);
        $this->assertSame(2, $r->id);
    }

    public function testSuccessfullNotMultipleAuth()
    {
        $this->appModel->is_multiple_auth_allowed = 0;
        $this->appModel->update();

        $this->app->request->setBodyParams([
            'app' => $this->appModel->token,
            'email' => 'john@luya.io',
            'password' => $this->userPw,
        ]);

        // multi auth allowed generates new tokens
        $r = $this->controller->actionIndex();
        $this->assertSame(1, $r->login_count);
        $this->assertSame(1, $r->id);

        $r = $this->controller->actionIndex();
        $this->assertSame(2, $r->login_count);
        $this->assertSame(1, $r->id);
    }

    public function testDeleteOldTokens()
    {
        $this->appModel->expires_in = 2;
        $this->appModel->update();

        $this->app->request->setBodyParams([
            'app' => $this->appModel->token,
            'email' => 'john@luya.io',
            'password' => $this->userPw,
        ]);

        // multi auth allowed generates new tokens
        $r = $this->controller->actionIndex();
        $this->assertSame(1, $r->login_count);
        $this->assertSame(1, $r->id);

        $r = $this->controller->actionIndex();
        $this->assertSame(1, $r->login_count);
        $this->assertSame(2, $r->id);

        $this->assertSame("2", Token::find()->count());
        sleep(3);

        $r = $this->controller->actionIndex();
        $this->assertSame(1, $r->login_count);
        $this->assertSame(3, $r->id);

        $this->assertSame("1", Token::find()->count());
    }
}
