<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull(),
            'name' => $this->string()->notNull(),
            'surname' => $this->string()->notNull(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'status_id' => $this->integer(),
            'role_id' => $this->integer(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createTable('{{%publication}}', [
            'id' => $this->primaryKey(),
            'slug' => $this->string()->notNull(),
            'title' => $this->string()->notNull(),
            'icon' => $this->string(),
            'annotation' => $this->text(),
            'content' => $this->text(),
            'created_at' => $this->bigInteger()->notNull(),
            'updated_at' => $this->bigInteger()->notNull(),
            'status_id' => $this->smallInteger()->notNull()->defaultValue(1)
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
        $this->dropTable('{{%publication}}');
    }
}
