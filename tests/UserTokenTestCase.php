<?php

namespace luya\admin\usertoken\tests;

use luya\admin\Module;
use luya\testsuite\cases\WebApplicationTestCase;
use luya\testsuite\traits\AdminDatabaseTableTrait;

class UserTokenTestCase extends WebApplicationTestCase
{
    use AdminDatabaseTableTrait;

    public function getConfigArray()
    {
        return [
            'id' => 'usertokentestcase',
            'basePath' => __DIR__,
            'language' => 'en',
            'modules' => [
                'admin' => [
                    'class' => Module::class,
                ],
                'usertoken' => [
                    'class' => 'luya\admin\usertoken\Module',
                ]
            ],
            'components' => [
                'db' => ['class' => 'yii\db\Connection', 'dsn' => 'sqlite::memory:'],
            ]
        ];
    }
}
