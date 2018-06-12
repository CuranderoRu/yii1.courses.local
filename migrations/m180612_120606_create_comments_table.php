<?php

use yii\db\Migration;

/**
 * Handles the creation of table `comments`.
 */
class m180612_120606_create_comments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('comments', [
            'id' => $this->primaryKey(),
            'task_id' => $this->integer(),
            'user_id' => $this->integer(),
            'body' => $this->text(),
            'image_name' => $this->string(250),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);

        $this->addForeignKey('fk_comment_task', 'comments', 'task_id', 'task', 'id');
        $this->addForeignKey('fk_comment_user', 'comments', 'user_id', 'users', 'id');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('comments');
    }
}
