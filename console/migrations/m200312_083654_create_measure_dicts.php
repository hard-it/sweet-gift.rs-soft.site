<?php

use yii\db\Migration;

/**
 * Class m200312_083654_create_measure_dicts
 */
class m200312_083654_create_measure_dicts extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->getDb()->createCommand("
        CREATE TABLE `VolumeMeasure`
            (
              `Id` Int NOT NULL AUTO_INCREMENT
             COMMENT 'Идентификатор записи',
              `ShortName` Varchar(20)
             COMMENT 'Сокращение',
              `OneName` Varchar(64)
             COMMENT 'Один',
              `SomeName` Varchar(64)
             COMMENT 'Несколько',
              `ManyName` Varchar(64)
             COMMENT 'Много',
              PRIMARY KEY (`Id`)
            )
             COMMENT = 'Единицы измерения'
            ;

        CREATE UNIQUE INDEX `ui_volumemeasure_shortname` ON `VolumeMeasure` (`ShortName`)
        ;
        ")->execute();

        $this->addColumn('ProductType', 'VolumeSize', 'Decimal(10,3)');
        $this->addCommentOnColumn('ProductType', 'VolumeSize', 'Объём товара');

        $this->addColumn('ProductType', 'VolumeSizeMeasure', 'Int');
        $this->addCommentOnColumn('ProductType', 'VolumeSizeMeasure', 'Единица измерения объёма товара');

        $this->createIndex('idx_volumesizemeasure', 'ProductType', 'VolumeSizeMeasure');

        $this->getDb()->createCommand("
            ALTER TABLE `ProductType` ADD CONSTRAINT `fk_volumemeasure_producttype` FOREIGN KEY (`VolumeSizeMeasure`) REFERENCES `VolumeMeasure` (`Id`) ON DELETE RESTRICT ON UPDATE NO ACTION;
        ")->execute();

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200312_083654_create_measure_dicts cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200312_083654_create_measure_dicts cannot be reverted.\n";

        return false;
    }
    */
}
