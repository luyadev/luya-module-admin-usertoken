<?php

namespace luya\admin\usertoken\tests\crud;

use luya\admin\usertoken\apis\AppController;
use luya\admin\usertoken\controllers\AppController as ControllersAppController;
use luya\admin\usertoken\models\App;
use luya\testsuite\cases\NgRestTestCase;

class AppTest extends NgRestTestCase
{
    public $modelClass = App::class;

    public $apiClass = AppController::class;

    public $controllerClass = ControllersAppController::class;

    public function getConfigArray()
    {
        return [
            'id' => 'ngresttest',
            'basePath' => dirname(__DIR__),
        ];
    }
}