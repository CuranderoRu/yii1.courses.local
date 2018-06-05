<?php

use yii\db\Migration;

/**
 * Class m180605_201431_add_email_field_to_users
 */
class m180605_201431_add_email_field_to_users extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('users', 'email', 'VARCHAR(150)');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('users','email');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180605_201431_add_email_field_to_users cannot be reverted.\n";

        return false;
    }
    */
}
