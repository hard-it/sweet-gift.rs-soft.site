<?php

use yii\db\Migration;
use common\models\ProductCategory;
use common\models\ProductType;

/**
 * Class m200310_123508_fill_translit_fields
 */
class m200310_123508_fill_translit_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $categories = ProductCategory::find()->all();
        foreach ($categories as $category) {
            if (!$category->save()) {
                return false;
            }
        }

        $products = ProductType::find()->all();

        foreach ($products as $product) {
            if (!$product->save()) {
                return false;
            }
        }

        return true;

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200310_123508_fill_translit_fields cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200310_123508_fill_translit_fields cannot be reverted.\n";

        return false;
    }
    */
}
