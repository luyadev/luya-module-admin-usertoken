<?php

namespace luya\admin\usertoken\tests;

use luya\testsuite\traits\MigrationFileCheckTrait;

class MigrationTest extends UserTokenTestCase
{
    use MigrationFileCheckTrait;

    public function testMigrationFile()
    {
        $this->checkMigrationFolder('@usertoken/migrations');
    }
}