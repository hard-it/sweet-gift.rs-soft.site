<?php

use yii\db\Migration;

/**
 * Class m191018_014856_add_product_category_json
 */
class m191018_014856_add_product_category_json extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('ProductCategory', 'Tags', 'JSON');
        $this->addColumn('ProductCategory', 'Keywords', 'JSON');

        $this->addCommentOnColumn('ProductCategory', 'Tags', 'Тэги');
        $this->addCommentOnColumn('ProductCategory', 'Keywords', 'Ключевые слова');

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191018_014856_add_product_category_json cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191018_014856_add_product_category_json cannot be reverted.\n";

        return false;
    }
    */
}
