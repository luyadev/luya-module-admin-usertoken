<?php

namespace luya\admin\usertoken\apis;

/**
 * Token Controller.
 *
 * @since 1.0.0
 * @author Basil Suter <git@nadar.io>
 */
class TokenController extends \luya\admin\ngrest\base\Api
{
    /**
     * @var string The path to the model which is the provider for the rules and fields.
     */
    public $modelClass = 'luya\admin\usertoken\models\Token';
}
