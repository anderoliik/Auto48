<?php
/**
 * Created by PhpStorm.
 * User: andero.liik
 * Date: 21.02.2017
 * Time: 9:35
 */

$create_user = "CREATE TABLE `TAK15_Liik`.`katus_users`( 
  `ID` SERIAL, 
  `username` VARCHAR(50) NOT NULL, 
  `password` VARCHAR(60) NOT NULL, 
  `firstName` VARCHAR(50) NOT NULL, 
  `lastName` VARCHAR(50) NOT NULL, 
  `alias` VARCHAR(50) NOT NULL, 
  `lang` VARCHAR(2) NOT NULL, 
  `group` VARCHAR(50) NOT NULL, 
  `added` DATETIME NOT NULL, 
  `edited` DATETIME ON UPDATE CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, 
  `status` INT(1) NOT NULL 
) ENGINE = InnoDB;";


$create_categories = "CREATE TABLE `TAK15_Liik`.`katus_categories`( 
  `ID` SERIAL, 
  `name` VARCHAR(100) NOT NULL, 
  `parent` INT NOT NULL, 
  `added` DATETIME NOT NULL, 
  `edited` DATETIME ON UPDATE CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, 
  `status` INT(1) NOT NULL 
) ENGINE = InnoDB;";

$create_products = "CREATE TABLE `TAK15_Liik`.`katus_products`( 
  `ID` SERIAL, 
  `name` VARCHAR(100) NOT NULL, 
  `price` DECIMAL(6, 2) NOT NULL, 
  `description` TEXT NOT NULL, 
  `category_id` INT NOT NULL, 
  `added` DATETIME NOT NULL, 
  `added_by` int NOT NULL, 
  `edited` DATETIME ON UPDATE CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, 
  `edited_by` INT NOT NULL, 
  `status` INT NOT NULL 
) ENGINE = InnoDB;";

$create_pictures = "CREATE TABLE `TAK15_Liik`.`katus_pictures`( 
  `ID` SERIAL, 
  `product_id` INT NOT NULL, 
  `name` VARCHAR(255) NOT NULL, 
  `added_by` INT NOT NULL, 
  `added` DATETIME NOT NULL, 
  `edited` DATETIME ON UPDATE CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, 
  `edited_by` INT NOT NULL, 
  `status` INT NOT NULL 
) ENGINE = InnoDB;";

$create_product_lang = "CREATE TABLE `TAK15_Liik`.`katus_products_lang`( 
  `ID` SERIAL, 
  `product_id` INT NOT NULL, 
  `tabel_column` VARCHAR(255) NOT NULL, 
  `column_value` TEXT NOT NULL, 
  `language` VARCHAR(2) NOT NULL, 
  `added` DATETIME NOT NULL, 
  `added_by` INT NOT NULL, 
  `edited` DATETIME ON UPDATE CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, 
  `edited_by` INT NOT NULL, 
  `status` INT NOT NULL 
) ENGINE = InnoDB;";