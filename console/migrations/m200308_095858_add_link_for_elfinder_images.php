<?php

use yii\db\Migration;

/**
 * Class m200308_095858_add_link_for_elfinder_images
 */
class m200308_095858_add_link_for_elfinder_images extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        //mklink /D  "E:\www\sweet-gift.rs-soft.site/\frontend\web\files" "E:\www\sweet-gift.rs-soft.site\backend\web\files"
        $srcReal= './../../backend/web/files';
        $dstReal= './../../frontend/web/files';
        if (static::isWindows()) {
            $command = "mklink /D  \"{$dstReal}\" \"{$srcReal}\"";
        } else {
            $command = "ln -sf  {$srcReal} {$dstReal}";
        }

        echo $command;
        exec($command);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200308_095858_add_link_for_elfinder_images cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200308_095858_add_link_for_elfinder_images cannot be reverted.\n";

        return false;
    }
    */

    /**
     * @return bool
     */
    public static function isWindows()
    {
        return (substr(php_uname(), 0, 7) == "Windows");
    }
}
