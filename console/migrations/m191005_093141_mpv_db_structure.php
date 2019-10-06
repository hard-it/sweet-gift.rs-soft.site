<?php

use yii\db\Migration;

/**
 * Class m191005_093141_mpv_db_structure
 */
class m191005_093141_mpv_db_structure extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->getDb()->createCommand("
        -- Table ProductCategory

CREATE TABLE `ProductCategory`
(
  `Id` Int NOT NULL AUTO_INCREMENT
 COMMENT 'Идентификатор записи',
  `Code` Varchar(10)
 COMMENT 'Код категории',
  `Name` Varchar(128)
 COMMENT 'Наименование',
  `Description` Text
 COMMENT 'Описание',
  PRIMARY KEY (`Id`)
)
 COMMENT = 'Категория товара';

CREATE UNIQUE INDEX `ui_code` ON `ProductCategory` (`Code`);

CREATE UNIQUE INDEX `ui_name` ON `ProductCategory` (`Name`);

CREATE TABLE `ProductType`
(
  `Id` Int NOT NULL AUTO_INCREMENT
 COMMENT 'Идентификатор записи',
  `Category` Int
 COMMENT 'Категория товара',
  `Code` Varchar(21)
 COMMENT 'Код',
  `Name` Varchar(128)
 COMMENT 'Наименование',
  `MinimalQuantity` Int
 COMMENT 'Минимальное количество',
  `ShelfLife` Int
 COMMENT 'Срок хранения, сек',
  `Measure` Int
 COMMENT 'Единица измерения',
  `Cost` Decimal(12,2)
 COMMENT 'Цена',
  `Description` Text
 COMMENT 'Описание',
  PRIMARY KEY (`Id`)
)
 COMMENT = 'Тип товара';

CREATE INDEX `ix_category` ON `ProductType` (`Category`);

CREATE UNIQUE INDEX `ui_category_code` ON `ProductType` (`Category`,`Code`);

CREATE UNIQUE INDEX `ui_category_name` ON `ProductType` (`Category`,`Name`);

CREATE INDEX `idx_name` ON `ProductType` (`Name`);

CREATE INDEX `idx_code` ON `ProductType` (`Code`);

CREATE TABLE `CustomerOrder`
(
  `Id` Int NOT NULL AUTO_INCREMENT
 COMMENT 'Идентификатор записи',
  `Number` Varchar(20)
 COMMENT 'Номер заказа',
  `Customer` Int
 COMMENT 'Заказчик',
  `Delivery` Json
 COMMENT 'Информация о доставке',
  `State` Int DEFAULT 0
 COMMENT 'Состояние заказа',
  `Sum` Decimal(12,2)
 COMMENT 'Сумма заказа',
  `CreatedAt` Int
 COMMENT 'Время создания',
  `UpdatedAt` Int
 COMMENT 'Время обновления',
  `DeletedAt` Int
 COMMENT 'Время удаления',
  `ClosedAt` Int
 COMMENT 'Заказ закончен',
  PRIMARY KEY (`Id`)
)
 COMMENT = 'Заказы';

CREATE INDEX `ix_customer` ON `CustomerOrder` (`Customer`);

CREATE UNIQUE INDEX `ui_number` ON `CustomerOrder` (`Number`);

CREATE UNIQUE INDEX `ui_customer_number` ON `CustomerOrder` (`Customer`,`Number`);

CREATE TABLE `OrderProduct`
(
  `Id` Int NOT NULL AUTO_INCREMENT
 COMMENT 'Идентификатор записи',
  `CustomerOrder` Int
 COMMENT 'Заказ',
  `Product` Int
 COMMENT 'Продукт',
  `Quantity` Int
 COMMENT 'Количество',
  `Cost` Decimal(12,2)
 COMMENT 'Стоимость',
  `Comment` Text
 COMMENT 'Примечание',
  PRIMARY KEY (`Id`)
)
 COMMENT = 'Товары/продукты, которые вошли в заказ';

CREATE INDEX `ix_order` ON `OrderProduct` (`CustomerOrder`);

CREATE INDEX `ix_product` ON `OrderProduct` (`Product`);

CREATE TABLE `Product`
(
  `Id` Int NOT NULL AUTO_INCREMENT
 COMMENT 'Идентификатор записи',
  `ProductCategory` Int
 COMMENT 'Категория продукта',
  `ProductType` Int
 COMMENT 'Тип продукта',
  `Quantity` Int
 COMMENT 'Количество',
  `State` Json
 COMMENT 'Множество состояний продукта в JSON.',
  PRIMARY KEY (`Id`)
)
 COMMENT = 'Продукт';

CREATE INDEX `ix_product_producttype` ON `Product` (`ProductType`);

CREATE INDEX `ix_prodyctcategory` ON `Product` (`ProductCategory`);

CREATE TABLE `Customer`
(
  `Id` Int NOT NULL AUTO_INCREMENT
 COMMENT 'Идентификатор записи',
  `Phone` Varchar(20)
 COMMENT 'Телефон',
  `Firstname` Varchar(64)
 COMMENT 'Имя',
  `Lastname` Varchar(64)
 COMMENT 'Фамилия',
  `User` Int
 COMMENT 'Пользователь',
  PRIMARY KEY (`Id`)
)
 COMMENT = 'Заказчик';

CREATE UNIQUE INDEX `ui_phone` ON `Customer` (`Phone`);

CREATE INDEX `ix_user` ON `Customer` (`User`);

CREATE TABLE `ProductPart`
(
  `Id` Int NOT NULL AUTO_INCREMENT
 COMMENT 'Идентификатор записи',
  `Product` Int NOT NULL
 COMMENT 'Продукт',
  `OrderProduct` Int NOT NULL
 COMMENT 'Продукт заказа',
  `Quantity` Int
 COMMENT 'Количество',
  `State` Json
 COMMENT 'Состояние части продукта'
);

ALTER TABLE `ProductPart` ADD PRIMARY KEY (`Product`,`OrderProduct`,`Id`);

CREATE TABLE `Tag`
(
  `Name` Varchar(64) NOT NULL
 COMMENT 'Наименование'
)
 COMMENT = 'Тэги';

ALTER TABLE `Tag` ADD PRIMARY KEY (`Name`);

CREATE TABLE `Keyword`
(
  `Name` Varchar(64) NOT NULL
 COMMENT 'Наименование'
)
 COMMENT = 'Тэги';

ALTER TABLE `Keyword` ADD PRIMARY KEY (`Name`);


ALTER TABLE `CustomerOrder` ADD CONSTRAINT `fk_customer_order` FOREIGN KEY (`Customer`) REFERENCES `Customer` (`Id`) ON DELETE RESTRICT ON UPDATE NO ACTION;
ALTER TABLE `OrderProduct` ADD CONSTRAINT `fk_order_orderproduct` FOREIGN KEY (`CustomerOrder`) REFERENCES `CustomerOrder` (`Id`) ON DELETE RESTRICT ON UPDATE NO ACTION;
ALTER TABLE `ProductType` ADD CONSTRAINT `fk_productcategory_producttype` FOREIGN KEY (`Category`) REFERENCES `ProductCategory` (`Id`) ON DELETE RESTRICT ON UPDATE NO ACTION;
ALTER TABLE `ProductPart` ADD CONSTRAINT `fk_product_productpart` FOREIGN KEY (`Product`) REFERENCES `Product` (`Id`) ON DELETE CASCADE ON UPDATE NO ACTION;
ALTER TABLE `ProductPart` ADD CONSTRAINT `fk_productorder_productpart` FOREIGN KEY (`OrderProduct`) REFERENCES `OrderProduct` (`Id`) ON DELETE CASCADE ON UPDATE NO ACTION;
ALTER TABLE `Product` ADD CONSTRAINT `fk_producttype_product` FOREIGN KEY (`ProductType`) REFERENCES `ProductType` (`Id`) ON DELETE CASCADE ON UPDATE NO ACTION;
ALTER TABLE `Product` ADD CONSTRAINT `fk_productcategory_product` FOREIGN KEY (`ProductCategory`) REFERENCES `ProductCategory` (`Id`) ON DELETE RESTRICT ON UPDATE NO ACTION;
ALTER TABLE `Customer` ADD CONSTRAINT `fk_user_customer` FOREIGN KEY (`User`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
        ")->execute();

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191005_093141_mpv_db_structure cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191005_093141_mpv_db_structure cannot be reverted.\n";

        return false;
    }
    */
}
