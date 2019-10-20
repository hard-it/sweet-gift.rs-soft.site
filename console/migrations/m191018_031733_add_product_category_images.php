<?php

use yii\db\Migration;

/**
 * Class m191018_031733_add_product_category_images
 */
class m191018_031733_add_product_category_images extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('ProductCategory', 'Images', 'JSON');
        $this->addCommentOnColumn('ProductCategory', 'Images', 'Изображения');

        $this->addColumn('ProductType', 'Images', 'JSON');
        $this->addCommentOnColumn('ProductType', 'Images', 'Изображения');

        return true;

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191018_031733_add_product_category_images cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191018_031733_add_product_category_images cannot be reverted.\n";

        return false;
    }
    */
}
