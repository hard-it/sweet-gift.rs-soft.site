<?php

use yii\db\Migration;

/**
 * Class m200101_132008_add_order_product_sum
 */
class m200101_132008_add_order_product_sum extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('OrderProduct', 'Sum', 'DECIMAL(10,2)');
        $this->addCommentOnColumn('OrderProduct', 'Sum', 'Сумма');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200101_132008_add_order_product_sum cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200101_132008_add_order_product_sum cannot be reverted.\n";

        return false;
    }
    */
}
