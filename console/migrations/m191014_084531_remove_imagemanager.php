<?php

use yii\db\Migration;

/**
 * Class m191014_084531_remove_imagemanager
 */
class m191014_084531_remove_imagemanager extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropTable('{{%ImageManager}}');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191014_084531_remove_imagemanager cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191014_084531_remove_imagemanager cannot be reverted.\n";

        return false;
    }
    */
}
