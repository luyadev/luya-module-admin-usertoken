<?php

namespace luya\admin\usertoken\apis;

use luya\admin\base\RestController;
use luya\admin\models\LoginForm;
use luya\admin\usertoken\models\App;
use luya\admin\usertoken\models\Token;
use Yii;
use yii\base\InvalidArgumentException;

class LoginController extends RestController
{
    public $authOptional = ['index'];

    public function actionIndex()
    {
        $app = App::find()->where(['token' => trim(Yii::$app->request->getBodyParam('app'))])->one();

        if (!$app) {
            throw new InvalidArgumentException("Unable to find the given app.");
        }

        $form = new LoginForm();
        $form->email = Yii::$app->request->getBodyParam('email');
        $form->password = Yii::$app->request->getBodyParam('password');
        
        if ($form->validate()) {

            $model = new Token();
            $model->token = Yii::$app->security->generateRandomString(64);
            $model->app_id = $app->id;
            $model->user_id = $form->user->id;
            if ($model->save()) {
                return $model;
            }
        }

        return $this->sendModelError($form);
        
    }
}