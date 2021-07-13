<?php

namespace luya\admin\usertoken;

use luya\admin\base\Module as BaseModule;

/**
 * User Token Module
 * 
 * @since 1.0.0
 * @author Basil Suter <git@nadar.io>
 */
class Module extends BaseModule
{
    /**
     * @var string If defined this user language will be set whenever the user login is authenticated.
     * @since 1.2.0
     */
    public $forceUserLanguage;

    /**
     * @var integer The number of login attempts a user can do trough login api.
     * @since 1.1.0
     */
    public $loginAttempts = 10;

    /**
     * @var integer The number of seconds the user will be locked out after {{$loginAttemps}} has exceeded.
     * @since 1.1.0
     */
    public $loginAttemptLockoutTime = 1800; 

    /**
     * {@inheritDoc}
     */
    public $apis = [
        'api-usertoken-app' => 'luya\admin\usertoken\apis\AppController',
        'api-usertoken-login' => 'luya\admin\usertoken\apis\LoginController',
        'api-usertoken-token' => 'luya\admin\usertoken\apis\TokenController',
    ];

    /**
     * {@inheritDoc}
     */
    public $apiRules = [
        'api-usertoken-login' => [
            'patterns' => [
                'POST' => 'index',
                'OPTIONS' => 'options',
            ]
        ],
    ];
    
    /**
     * {@inheritDoc}
     */
    public function getMenu()
    {
        return (new \luya\admin\components\AdminMenuBuilder($this))
            ->node('User Tokens', 'lock')
                ->group('Group')
                    ->itemApi('Apps', 'usertoken/app/index', 'apps', 'api-usertoken-app')
                    ->itemApi('Login Tokens', 'usertoken/token/index', 'lock', 'api-usertoken-token');
    }

}