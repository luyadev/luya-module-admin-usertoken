<?php

namespace luya\admin\usertoken\controllers;

/**
 * App Controller.
 * 
 * @since 1.0.0
 * @author Basil Suter <git@nadar.io>
 */
class AppController extends \luya\admin\ngrest\base\Controller
{
    /**
     * @var string The path to the model which is the provider for the rules and fields.
     */
    public $modelClass = 'luya\admin\usertoken\models\App';

    /**
     * {@inheritDoc}
     */
    public function getDescription()
    {
        return 'Register an App which will generate an Identifier and can be used to make User Login calls.';
    }
}