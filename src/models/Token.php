<?php

namespace luya\admin\usertoken\models;

use luya\admin\models\User;
use Yii;
use luya\admin\ngrest\base\NgRestModel;
use luya\admin\ngrest\plugins\SelectRelationActiveQuery;
use yii\behaviors\TimestampBehavior;

/**
 * Token.
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $app_id
 * @property string $token
 * @property integer $login_count
 * @property integer $created_at
 * @property integer $updated_at
 * @property-read integer $originalUserId
 * 
 * @since 1.0.0
 * @author Basil Suter <git@nadar.io>
 */
class Token extends NgRestModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%admin_usertoken_token}}';
    }

    /**
     * {@inheritDoc}
     */
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
        return 'api-usertoken-token';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'app_id' => Yii::t('app', 'App ID'),
            'token' => Yii::t('app', 'Token'),
            'login_count' => Yii::t('app', 'Login Count'),
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
            [['user_id', 'app_id'], 'required'],
            [['user_id', 'app_id', 'login_count', 'created_at', 'updated_at'], 'integer'],
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
            'user_id' => ['class' => SelectRelationActiveQuery::class, 'query' => $this->getUser(), 'relation' => 'user', 'labelField' => 'email'],
            'app_id' => ['class' => SelectRelationActiveQuery::class, 'query' => $this->getApp(), 'relation' => 'app', 'labelField' => 'name'],
            'token' => 'text',
            'login_count' => 'number',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * @inheritdoc
     */
    public function ngRestScopes()
    {
        return [
            ['list', ['user_id', 'app_id','login_count', 'created_at', 'updated_at']],
            ['delete', false],
        ];
    }
    
    /**
     * @return string The user id before relation is populated
     * @since 1.3.0
     */
    public function getOriginalUserId()
    {
        return $this->getOldAttribute('user_id');
    }
    
    /**
     * App Relation
     *
     * @return App
     */
    public function getApp()
    {
        return $this->hasOne(App::class, ['id' => 'app_id']);
    }

    /**
     * User Relation
     *
     * @return User
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'originalUserId']);
    }
}
