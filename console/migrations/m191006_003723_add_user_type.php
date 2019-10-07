<?php

use yii\db\Migration;

/**
 * Class m191006_003723_add_user_type
 */
class m191006_003723_add_user_type extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'user_type', 'INTEGER');
        $this->addCommentOnColumn('user', 'user_type', 'Тип регистрации пользователя');

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user', 'user_type');

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191006_003723_add_user_type cannot be reverted.\n";

        return false;
    }
    */
}
