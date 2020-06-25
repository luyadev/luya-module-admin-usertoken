<?php

namespace luya\admin\usertoken;

use luya\admin\base\Module as BaseModule;

class Module extends BaseModule
{
    public $apis = [
        'api-usertoken-app' => 'luya\admin\usertoken\apis\AppController',
        'api-usertoken-login' => 'luya\admin\usertoken\apis\LoginController',
    ];

    public $apiRules = [
        'api-usertoken-login' => [
            'patterns' => [
                'POST' => 'index',
            ]
        ],
    ];
    
    public function getMenu()
    {
        return (new \luya\admin\components\AdminMenuBuilder($this))
            ->node('User Tokens', 'lock')
                ->group('Group')
                    ->itemApi('Apps', 'usertoken/app/index', 'label', 'api-usertoken-app');
    }

}