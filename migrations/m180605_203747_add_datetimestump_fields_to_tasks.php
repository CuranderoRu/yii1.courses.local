<?php

use yii\db\Migration;

/**
 * Class m180605_203747_add_datetimestump_fields_to_tasks
 */
class m180605_203747_add_datetimestump_fields_to_tasks extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('task', 'created_at', 'timestamp');
        $this->addColumn('task', 'updated_at', 'timestamp');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('task','created_at');
        $this->dropColumn('task','updated_at');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180605_203747_add_datetimestump_fields_to_tasks cannot be reverted.\n";

        return false;
    }
    */
}
