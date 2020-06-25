<?php

namespace luya\admin\usertoken\controllers;

/**
 * Token Controller.
 * 
 * File has been created with `crud/create` command. 
 */
class TokenController extends \luya\admin\ngrest\base\Controller
{
    /**
     * @var string The path to the model which is the provider for the rules and fields.
     */
    public $modelClass = 'luya\admin\usertoken\models\Token';

    public function getDescription()
    {
        return 'Display all users which have requested a login token for the given App.';
    }
}