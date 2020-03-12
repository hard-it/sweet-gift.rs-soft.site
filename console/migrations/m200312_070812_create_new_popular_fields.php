<?php

use yii\db\Migration;

/**
 * Class m200312_070812_create_new_popular_fields
 */
class m200312_070812_create_new_popular_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('ProductType', 'IsNew', 'BOOL DEFAULT 1');
        $this->addCommentOnColumn('ProductType', 'IsNew', 'Новинка');

        $this->addColumn('ProductType', 'IsPopular', 'BOOL DEFAULT 0');
        $this->addCommentOnColumn('ProductType', 'IsPopular', 'Популярный');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200312_070812_create_new_popular_fields cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200312_070812_create_new_popular_fields cannot be reverted.\n";

        return false;
    }
    */
}
