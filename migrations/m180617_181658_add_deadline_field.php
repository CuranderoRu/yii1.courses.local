<?php

use yii\db\Migration;

/**
 * Class m180617_181658_add_deadline_field
 */
class m180617_181658_add_deadline_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('task', 'deadline', 'DATETIME');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('task','deadline');

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180617_181658_add_deadline_field cannot be reverted.\n";

        return false;
    }
    */
}
