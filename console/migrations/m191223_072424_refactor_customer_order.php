<?php

use yii\db\Migration;

/**
 * Class m191223_072424_refactor_customer_order
 */
class m191223_072424_refactor_customer_order extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('CustomerOrder', 'Delivery');

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191223_072424_refactor_customer_order cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191223_072424_refactor_customer_order cannot be reverted.\n";

        return false;
    }
    */
}
