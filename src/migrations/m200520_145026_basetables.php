<?php

use yii\db\Migration;

/**
 * Class m200520_145026_basetables
 */
class m200520_145026_basetables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%admin_usertoken_app}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'token' => $this->string(190)->unique(),
            'is_multiple_auth_allowed' => $this->boolean()->defaultValue(false),
            'expires_in' => $this->integer()->defaultValue(0),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->createTable('{{%admin_usertoken_token}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'app_id' => $this->integer()->notNull(),
            'token' => $this->string(190)->unique(),
            'login_count' => $this->integer()->defaultValue(0),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->createIndex('user_id', '{{%admin_usertoken_token}}', 'user_id');
        $this->createIndex('app_id', '{{%admin_usertoken_token}}', 'app_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%admin_usertoken_app}}');

        $this->dropTable('{{%admin_usertoken_token}}');
    }
}
