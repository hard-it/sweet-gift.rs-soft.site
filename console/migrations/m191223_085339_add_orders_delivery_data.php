<?php

use yii\db\Migration;

/**
 * Class m191223_085339_add_orders_delivery_data
 */
class m191223_085339_add_orders_delivery_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('CustomerPoint', 'OrderPoint', 'POINT');
        $this->addCommentOnColumn('CustomerPoint', 'OrderPoint', 'Точка доставки');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191223_085339_add_orders_delivery_data cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191223_085339_add_orders_delivery_data cannot be reverted.\n";

        return false;
    }
    */
}
