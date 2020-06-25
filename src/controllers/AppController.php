<?php

namespace luya\admin\usertoken\controllers;

/**
 * App Controller.
 * 
 * File has been created with `crud/create` command. 
 */
class AppController extends \luya\admin\ngrest\base\Controller
{
    /**
     * @var string The path to the model which is the provider for the rules and fields.
     */
    public $modelClass = 'luya\admin\usertoken\models\App';

    public function getDescription()
    {
        return 'Register an App which will be use as an Identifier for the given Application. Afterwards use the APIs to login a given user in a certain App.';
    }
}