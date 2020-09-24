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

    /**
     * @var NgRestModelFixture
     */
    public $appFixture;

    /**
     * @var NgRestModelFixture
     */
    public $tokenFixture;

    public function afterSetup()
    {
        parent::afterSetup();
        $this->createAdminLangFixture();
        $this->createAdminNgRestLogFixture();
        $this->appFixture = new NgRestModelFixture(['modelClass' => App::class]);
        $this->tokenFixture = new NgRestModelFixture(['modelClass' => Token::class]);
        $this->controller = new LoginController('login', $this->app->getModule('admin'));
    }

    public function testUnknownApp()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->controller->actionIndex();
    }

    public function testFindApp()
    {
        $model = $this->appFixture->newModel;
        $model->name = 'test';
        $model->is_multiple_auth_allowed = 1;
        $model->save();
        $this->assertNotEmpty($model->token);

        $this->app->request->setBodyParams(['app' => $model->token]);

        $this->controller->actionIndex();

        // validation error because of missing email and password
        $this->assertSame(422, $this->app->response->statusCode);
    }
}