<?php

use yii\db\Migration;

/**
 * Class m180530_195436_add_authKey_to_users
 */
class m180530_195436_add_authKey_to_users extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('users', 'authKey', 'VARCHAR(150) AFTER `role_id`');
        $this->addColumn('users', 'accessToken', 'VARCHAR(150) AFTER `authKey`');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('users','authKey');
        $this->dropColumn('users','accessToken');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180530_195436_add_authKey_to_users cannot be reverted.\n";

        return false;
    }
    */
}
