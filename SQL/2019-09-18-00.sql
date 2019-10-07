/*
Created: 04.08.2019
Modified: 18.09.2019
Model: RE MySQL 5.7
Database: MySQL 5.7
*/


-- Create tables section -------------------------------------------------

-- Table authassignment

CREATE TABLE `authassignment`
(
  `item_name` Varchar(64) NOT NULL,
  `user_id` Varchar(64) NOT NULL,
  `created_at` Int
) ENGINE = InnoDB
 ROW_FORMAT = Dynamic
;

CREATE INDEX `idx-auth_assignment-user_id` USING BTREE ON `authassignment` (`user_id`)
;

ALTER TABLE `authassignment` ADD PRIMARY KEY (`item_name`,`user_id`)
;

-- Table authitem

CREATE TABLE `authitem`
(
  `name` Varchar(64) NOT NULL,
  `type` Smallint NOT NULL,
  `description` Text,
  `rule_name` Varchar(64),
  `data` Blob,
  `created_at` Int,
  `updated_at` Int
) ENGINE = InnoDB
 ROW_FORMAT = Dynamic
;

CREATE INDEX `rule_name` USING BTREE ON `authitem` (`rule_name`)
;

CREATE INDEX `idx-auth_item-type` USING BTREE ON `authitem` (`type`)
;

ALTER TABLE `authitem` ADD PRIMARY KEY (`name`)
;

-- Table authitemchild

CREATE TABLE `authitemchild`
(
  `parent` Varchar(64) NOT NULL,
  `child` Varchar(64) NOT NULL
) ENGINE = InnoDB
 ROW_FORMAT = Dynamic
;

CREATE INDEX `child` USING BTREE ON `authitemchild` (`child`)
;

ALTER TABLE `authitemchild` ADD PRIMARY KEY (`parent`,`child`)
;

-- Table authrule

CREATE TABLE `authrule`
(
  `name` Varchar(64) NOT NULL,
  `data` Blob,
  `created_at` Int,
  `updated_at` Int
) ENGINE = InnoDB
 ROW_FORMAT = Dynamic
;

ALTER TABLE `authrule` ADD PRIMARY KEY (`name`)
;

-- Table migration

CREATE TABLE `migration`
(
  `version` Varchar(180) NOT NULL,
  `apply_time` Int
) ENGINE = InnoDB
 ROW_FORMAT = Dynamic
;

ALTER TABLE `migration` ADD PRIMARY KEY (`version`)
;

-- Table user

CREATE TABLE `user`
(
  `id` Int NOT NULL AUTO_INCREMENT,
  `username` Varchar(255) NOT NULL,
  `auth_key` Varchar(32) NOT NULL,
  `password_hash` Varchar(255) NOT NULL,
  `password_reset_token` Varchar(255),
  `email` Varchar(255) NOT NULL,
  `status` Smallint NOT NULL DEFAULT 10,
  `created_at` Int NOT NULL,
  `updated_at` Int NOT NULL,
  `verification_token` Varchar(255),
  PRIMARY KEY (`id`)
) ENGINE = InnoDB
 AUTO_INCREMENT = 3
 ROW_FORMAT = Dynamic
;

CREATE UNIQUE INDEX `username` USING BTREE ON `user` (`username`)
;

CREATE UNIQUE INDEX `email` USING BTREE ON `user` (`email`)
;

CREATE UNIQUE INDEX `password_reset_token` USING BTREE ON `user` (`password_reset_token`)
;

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
 COMMENT = 'Категория товара'
;

CREATE UNIQUE INDEX `ui_code` ON `ProductCategory` (`Code`)
;

CREATE UNIQUE INDEX `ui_name` ON `ProductCategory` (`Name`)
;

-- Table ProductType

CREATE TABLE `ProductType`
(
  `Id` Int NOT NULL AUTO_INCREMENT
 COMMENT 'Идентификатор записи',
  `Category` Int
 COMMENT 'Категория товара',
  `Code` Varchar(10)
 COMMENT 'Код',
  `Name` Varchar(128)
 COMMENT 'Наименование',
  `MinimalQuantity` Int
 COMMENT 'Минимальное количество',
  `ShelfLife` Datetime
 COMMENT 'Срок хранения',
  `Cost` Decimal(12,2)
 COMMENT 'Цена',
  `Description` Text
 COMMENT 'Описание',
  PRIMARY KEY (`Id`)
)
 COMMENT = 'Тип товара'
;

CREATE INDEX `ix_category` ON `ProductType` (`Category`)
;

CREATE UNIQUE INDEX `ui_category_code` ON `ProductType` (`Category`,`Code`)
;

CREATE UNIQUE INDEX `ui_category_name` ON `ProductType` (`Category`,`Name`)
;

CREATE INDEX `idx_name` ON `ProductType` (`Name`)
;

CREATE INDEX `idx_code` ON `ProductType` (`Code`)
;

-- Table Order

CREATE TABLE `Order`
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
 COMMENT = 'Заказы'
;

CREATE INDEX `ix_customer` ON `Order` (`Customer`)
;

CREATE UNIQUE INDEX `ui_number` ON `Order` (`Number`)
;

CREATE UNIQUE INDEX `ui_customer_number` ON `Order` (`Customer`,`Number`)
;

-- Table OrderProduct

CREATE TABLE `OrderProduct`
(
  `Id` Int NOT NULL AUTO_INCREMENT
 COMMENT 'Идентификатор записи',
  `Order` Int
 COMMENT 'Заказ',
  `Product` Int
 COMMENT 'Продукт',
  `Quantity` Int
 COMMENT 'Количество',
  `Cost` Decimal(12,2)
 COMMENT 'Стоимость',
  PRIMARY KEY (`Id`)
)
 COMMENT = 'Товары/продукты, которые вошли в заказ'
;

CREATE INDEX `ix_order` ON `OrderProduct` (`Order`)
;

CREATE INDEX `ix_product` ON `OrderProduct` (`Product`)
;

-- Table Customer

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
  `Fullname` Varchar(128) GENERATED ALWAYS AS (CONCAT(Firstname,' ',Lastname)) 
 COMMENT 'Полное имя',
  `SocialNetType` Int DEFAULT 0
 COMMENT 'Тип социальной сети',
  `SocialNets` Json
 COMMENT 'Данные по социальным сетям',
  PRIMARY KEY (`Id`)
)
 COMMENT = 'Заказчик'
;

CREATE UNIQUE INDEX `ui_phone` ON `Customer` (`Phone`)
;

CREATE INDEX `ix_fullname` ON `Customer` (`Fullname`)
;

-- Create foreign keys (relationships) section ------------------------------------------------- 


ALTER TABLE `authassignment` ADD CONSTRAINT `authassignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `authitem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
;


ALTER TABLE `authitem` ADD CONSTRAINT `authitem_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `authrule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
;


ALTER TABLE `authitemchild` ADD CONSTRAINT `authitemchild_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `authitem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
;


ALTER TABLE `authitemchild` ADD CONSTRAINT `authitemchild_ibfk_2` FOREIGN KEY (`child`) REFERENCES `authitem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
;


ALTER TABLE `Order` ADD CONSTRAINT `fk_customer_order` FOREIGN KEY (`Customer`) REFERENCES `Customer` (`Id`) ON DELETE RESTRICT ON UPDATE NO ACTION
;


ALTER TABLE `OrderProduct` ADD CONSTRAINT `fk_order_orderproduct` FOREIGN KEY (`Order`) REFERENCES `Order` (`Id`) ON DELETE RESTRICT ON UPDATE NO ACTION
;


ALTER TABLE `ProductType` ADD CONSTRAINT `fk_productcategory_producttype` FOREIGN KEY (`Category`) REFERENCES `ProductCategory` (`Id`) ON DELETE RESTRICT ON UPDATE NO ACTION
;


