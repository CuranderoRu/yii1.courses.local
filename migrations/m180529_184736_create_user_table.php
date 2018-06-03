<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user`.
 */
class m180529_184736_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('roles', [
            'id' => $this->primaryKey(),
            'name' => $this->string(250),
            'level' => $this->integer()->notNull(),
        ]);


        $this->createTable('users', [
            'id' => $this->primaryKey(),
            'name' => $this->string(250),
            'login' => $this->string(250)->notNull()->unique(),
            'password' => $this->string(100)->notNull(),
            'role_id' => $this->integer()->defaultValue(0),
        ]);

        $this->addForeignKey('FK_ROLES', 'users', 'role_id', 'roles', 'id', 'SET NULL', 'CASCADE');


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('users');
        $this->dropTable('roles');
    }
}
