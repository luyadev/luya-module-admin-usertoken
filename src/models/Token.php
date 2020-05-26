<?php

namespace luya\admin\usertoken\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * Token
 *
 * @property int $id
 * @property int $user_id
 * @property int $app_id
 * @property string|null $token
 * @property int|null $login_count
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class Token extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'admin_usertoken_token';
    }

    public function behaviors()
    {
        return [
            ['class' => TimestampBehavior::class],
        ];
    }

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'app_id' => 'App ID',
            'token' => 'Token',
            'login_count' => 'Login Count',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
