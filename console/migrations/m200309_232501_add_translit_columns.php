<?php

use yii\db\Migration;

/**
 * Class m200309_232501_add_translit_columns
 */
class m200309_232501_add_translit_columns extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('ProductCategory', 'Alias', 'VARCHAR(255)');
        $this->addCommentOnColumn('ProductCategory', 'Alias', 'СЕО наименование');
        $this->createIndex('ui_productcategory_alias', 'ProductCategory', 'Alias', true);

        $this->addColumn('ProductType', 'Alias', 'VARCHAR(255)');
        $this->addCommentOnColumn('ProductType', 'Alias', 'СЕО наименование');
        $this->createIndex('ui_producttype_alias', 'ProductType', 'Alias', true);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200309_232501_add_translit_columns cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200309_232501_add_translit_columns cannot be reverted.\n";

        return false;
    }
    */
}
