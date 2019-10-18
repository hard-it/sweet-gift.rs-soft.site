<?php

use yii\db\Migration;

/**
 * Class m191018_030043_add_product_type_json
 */
class m191018_030043_add_product_type_json extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('ProductType', 'Tags', 'JSON');
        $this->addColumn('ProductType', 'Keywords', 'JSON');

        $this->addCommentOnColumn('ProductType', 'Tags', 'Тэги');
        $this->addCommentOnColumn('ProductType', 'Keywords', 'Ключевые слова');

        return true;

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191018_030043_add_product_type_json cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191018_030043_add_product_type_json cannot be reverted.\n";

        return false;
    }
    */
}
