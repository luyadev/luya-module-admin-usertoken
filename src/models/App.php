<?php

namespace luya\admin\usertoken\models;

use Yii;
use luya\admin\ngrest\base\NgRestModel;
use yii\behaviors\TimestampBehavior;

/**
 * App.
 * 
 * File has been created with `crud/create` command. 
 *
 * @property integer $id
 * @property string $name
 * @property string $token
 * @property tinyint $is_multiple_auth_allowed
 * @property integer $expires_in
 * @property integer $created_at
 * @property integer $updated_at
 */
class App extends NgRestModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%admin_usertoken_app}}';
    }

    public function behaviors()
    {
        return [
            ['class' => TimestampBehavior::class],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function ngRestApiEndpoint()
    {
        return 'api-usertoken-app';
    }

    public function init()
    {
        parent::init();

        $this->on(self::EVENT_BEFORE_VALIDATE, function() {
            if ($this->isNewRecord) {
                $this->token = Yii::$app->security->generateRandomString(64);
            }
        });
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'token' => Yii::t('app', 'Token'),
            'is_multiple_auth_allowed' => Yii::t('app', 'Is Multiple Auth Allowed'),
            'expires_in' => Yii::t('app', 'Expires In'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['is_multiple_auth_allowed', 'expires_in', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['token'], 'string', 'max' => 190],
            [['token'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function ngRestAttributeTypes()
    {
        return [
            'name' => 'text',
            'token' => 'text',
            'is_multiple_auth_allowed' => 'toggleStatus',
            'expires_in' => 'number',
            'created_at' => 'number',
            'updated_at' => 'number',
        ];
    }

    /**
     * @inheritdoc
     */
    public function ngRestScopes()
    {
        return [
            ['list', ['name', 'token', 'is_multiple_auth_allowed', 'expires_in', 'created_at', 'updated_at']],
            [['create', 'update'], ['name', 'is_multiple_auth_allowed', 'expires_in', 'created_at', 'updated_at']],
            ['delete', false],
        ];
    }
}
