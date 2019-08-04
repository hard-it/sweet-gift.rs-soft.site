<?php

use yii\db\Migration;
use common\models\User;

/**
 * Class m190804_061901_add_admin_record
 */
class m190804_061901_add_admin_record extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $user = new User();

        $user->username = 'admin';
        $user->email    = 'softarts@mail.ru';
        $user->status   = User::STATUS_ACTIVE;
        
        $user->setPassword('1q2w3e4r5t');
        $user->generateAuthKey();

        $result = $user->save();

        if (!$result) {
            var_dump($user->errors);
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190804_061901_add_admin_record cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190804_061901_add_admin_record cannot be reverted.\n";

        return false;
    }
    */
}
