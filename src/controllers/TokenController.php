<?php

namespace luya\admin\usertoken\controllers;

/**
 * Token Controller.
 *
 * @since 1.0.0
 * @author Basil Suter <git@nadar.io>
 */
class TokenController extends \luya\admin\ngrest\base\Controller
{
    /**
     * @var string The path to the model which is the provider for the rules and fields.
     */
    public $modelClass = 'luya\admin\usertoken\models\Token';

    /**
     * {@inheritDoc}
     */
    public function getDescription()
    {
        return 'List all users that have requested a login token for the given app.';
    }
}
