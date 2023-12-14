<?php

namespace luya\admin\usertoken\tests\crud;

use luya\admin\usertoken\apis\TokenController;
use luya\admin\usertoken\controllers\TokenController as ControllersTokenController;
use luya\admin\usertoken\models\Token;
use luya\testsuite\cases\NgRestTestCase;

class TokenTest extends NgRestTestCase
{
    public $modelClass = Token::class;

    public $apiClass = TokenController::class;

    public $controllerClass = ControllersTokenController::class;

    public function getConfigArray()
    {
        return [
            'id' => 'ngresttest',
            'basePath' => dirname(__DIR__),
        ];
    }
}
