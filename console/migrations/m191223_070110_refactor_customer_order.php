<?php

use yii\db\Migration;

/**
 * Class m191223_070110_refactor_customer_order
 */
class m191223_070110_refactor_customer_order extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('CustomerOrder', 'CreatedAt');
        $this->dropColumn('CustomerOrder', 'UpdatedAt');
        $this->dropColumn('CustomerOrder', 'DeletedAt');
        $this->dropColumn('CustomerOrder', 'ClosedAt');
        $this->dropColumn('CustomerOrder', 'State');
        $this->addColumn('CustomerOrder', 'State', 'JSON');
        $this->addCommentOnColumn('CustomerOrder', 'State', 'Состояние заказа');

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191223_070110_refactor_customer_order cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191223_070110_refactor_customer_order cannot be reverted.\n";

        return false;
    }
    */
}
