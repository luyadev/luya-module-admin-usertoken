<?php

namespace luya\admin\usertoken\tests;

use luya\testsuite\cases\WebApplicationTestCase;

class PackageTestCase extends WebApplicationTestCase
{
    public function getConfigArray()
    {
        return [
            'id' => 'packagetest',
            'basePath' => __DIR__,
            'language' => 'en',
        ];
    }
}
