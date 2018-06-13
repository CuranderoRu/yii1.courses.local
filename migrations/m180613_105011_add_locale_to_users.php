<?php

use yii\db\Migration;

/**
 * Class m180613_105011_add_locale_to_users
 */
class m180613_105011_add_locale_to_users extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('users', 'locale', 'VARCHAR(30)');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('users','locale');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180613_105011_add_locale_to_users cannot be reverted.\n";

        return false;
    }
    */
}
