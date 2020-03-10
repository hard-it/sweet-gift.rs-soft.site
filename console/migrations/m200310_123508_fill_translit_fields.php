<?php

use yii\db\Migration;

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
        $this->buildAllAliases('ProductCategory', 'Id', 'Name', 'Alias');
        $this->buildAllAliases('ProductType', 'Id', 'Name', 'Alias');

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

    /**
     * @param string $tableName
     * @param string $idField
     * @param string $name
     * @param string $slug
     *
     * @throws \yii\db\Exception
     */
    protected function buildAllAliases(string $tableName, string $idField, string $name, string $slug)
    {
        $connection = $this->getDb();

        $command = $connection->createCommand("
         SELECT $idField, $name FROM $tableName   
        ");

        $records = $command->queryAll();
        foreach ($records as $record) {
            $id       = $record[$idField];
            $slugData = \yii\helpers\Inflector::slug($record[$name]);
            $connection->createCommand("
         UPDATE $tableName SET $slug = '$slugData' WHERE $idField = $id;   
        ")->execute();

        }
    }
}
