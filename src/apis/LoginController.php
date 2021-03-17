<?php

namespace luya\admin\usertoken\apis;

use luya\admin\base\RestController;
use luya\admin\models\LoginForm;
use luya\admin\ngrest\base\actions\OptionsAction;
use luya\admin\usertoken\models\App;
use luya\admin\usertoken\models\Token;
use Yii;
use yii\base\InvalidArgumentException;

/**
 * Login Controller
 * 
 * @since 1.0.0
 * @author Basil Suter <git@nadar.io>
 */
class LoginController extends RestController
{
    public $authOptional = ['index', 'options'];

    /**
     * {@inheritDoc}
     */
    public function actions()
    {
        return [
            'options' => OptionsAction::class,
        ];
    }

    /**
     * User Login
     * 
     * Login an user by email and password with a valid application token. The data must be submited by POST and requires `app`, `email` and `password` data.
     * 
     * @return Token If successfull the token object is returned.
     * @uses string email
     * @uses string password
     * @uses string app
     */
    public function actionIndex()
    {
        $app = App::find()->where(['token' => trim(Yii::$app->request->getBodyParam('app'))])->one();

        if (!$app) {
            throw new InvalidArgumentException("Unable to find the given app \"{$app}\" to authorize the given user.");
        }

        $form = new LoginForm();
        $form->lockoutTime = $this->module->loginAttemptLockoutTime;
        $form->allowedAttempts = $this->module->loginAttempts;
        $form->email = Yii::$app->request->getBodyParam('email');
        $form->password = Yii::$app->request->getBodyParam('password');
        
        if ($form->validate()) {

            // Check for an existing token and udpate the token with a new value.
            if (!$app->is_multiple_auth_allowed) {
                if ($token = Token::find()->where(['user_id' => $form->user->id, 'app_id' => $app->id])->one()) {
                    $token->token = Yii::$app->security->generateRandomString(64);
                    $token->updateCounters(['login_count' => 1]);
                    if ($token->update()) {
                        return $token;
                    }
                }
            }

            // remove expired tokens
            if ($app->expires_in) {
                // remove tokens, which have a create date higher the expires_in
                $deleted = Token::deleteAll([
                    'and',
                    ['=', 'user_id', $form->user->id],
                    ['=', 'app_id', $app->id],
                    ['<=', 'created_at', time() - $app->expires_in]
                ]);

                Yii::debug("Deleted {$deleted} expired tokens for the given User", __METHOD__);
            }

            $model = new Token();
            $model->token = Yii::$app->security->generateRandomString(64);
            $model->app_id = $app->id;
            $model->user_id = $form->user->id;
            $model->login_count = 1;
            if ($model->save()) {
                return $model;
            }
        }

        return $this->sendModelError($form);
    }
}