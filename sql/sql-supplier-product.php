<?php
// Init
$sql = array();


//depth x width x height = packing from EDC XML

//Create intermediate table for the products
$sql[$module_name.'_'.$supplier_name.'_product'] = 'DROP TABLE IF EXISTS `'._DB_PREFIX_.$module_name.'_'.$supplier_name.'_product`;
	CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.$module_name.'_'.$supplier_name.'_product` (
		`id_'.$module_name.'_'.$supplier_name.'_product` int(10) unsigned NOT NULL AUTO_INCREMENT,
		`id_product_supplier` int(10) NOT NULL,
		`id_default_category_supplier` int(10) NOT NULL,
		`id_'.$module_name.'_'.$supplier_name.'_manufacturer` int(10) NOT NULL,
		`reference` varchar(32) DEFAULT NULL,
		`ean13` varchar(13) DEFAULT NULL,
		`date_add` datetime NOT NULL,
		`date_upd` datetime NOT NULL,
		`price` decimal(20,6) NOT NULL DEFAULT \'0.000000\',
		`wholesale_price` decimal(20,6) NOT NULL DEFAULT \'0.000000\',
		`quantity` int(10) NOT NULL DEFAULT \'0\',
		`pics_list` text NOT NULL,
		`depth` DECIMAL(20, 6) NOT NULL DEFAULT \'0\',
		`width` DECIMAL(20, 6) NOT NULL DEFAULT \'0\',
		`height`DECIMAL(20, 6) NOT NULL DEFAULT \'0\',
		`weight` DECIMAL(20, 6) NOT NULL DEFAULT \'0\',
		`supplier` varchar(55),
		`do_update` tinyint(1) NOT NULL DEFAULT \'0\',
  		PRIMARY KEY (`id_'.$module_name.'_'.$supplier_name.'_product`)
	) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;';
$sql[$module_name.'_'.$supplier_name.'_product_shop'] = 'DROP TABLE IF EXISTS `'._DB_PREFIX_.$module_name.'_'.$supplier_name.'_product_shop`;
	CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.$module_name.'_'.$supplier_name.'_product_shop` (
		`id_'.$module_name.'_'.$supplier_name.'_product` int(10) unsigned NOT NULL AUTO_INCREMENT,
		`id_shop` int(10) unsigned NOT NULL,
		PRIMARY KEY (`id_'.$module_name.'_'.$supplier_name.'_product`,`id_shop`)
	) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;';
$sql[$module_name.'_'.$supplier_name.'_product_lang'] = 'DROP TABLE IF EXISTS `'._DB_PREFIX_.$module_name.'_'.$supplier_name.'_product_lang`;
	CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.$module_name.'_'.$supplier_name.'_product_lang` (
		`id_'.$module_name.'_'.$supplier_name.'_product` int(10) unsigned NOT NULL AUTO_INCREMENT,
		`id_lang` int(10) unsigned NOT NULL,
		`name` varchar(255) NOT NULL,
		`description` text,
		`link_rewrite` varchar(128) NOT NULL,
		PRIMARY KEY (`id_'.$module_name.'_'.$supplier_name.'_product`,`id_lang`)
	) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;';

$sql[$module_name.'_'.$supplier_name.'_category_product'] = 'DROP TABLE IF EXISTS `'._DB_PREFIX_.$module_name.'_'.$supplier_name.'_category_product`;
	CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.$module_name.'_'.$supplier_name.'_category_product` (
		`id_'.$module_name.'_'.$supplier_name.'_category` int(10) unsigned NOT NULL,
		`id_'.$module_name.'_'.$supplier_name.'_product` int(10) unsigned NOT NULL,
		PRIMARY KEY (`id_'.$module_name.'_'.$supplier_name.'_category`,`id_'.$module_name.'_'.$supplier_name.'_product`)
	) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;';

//Create intermediate table for the category
$sql[$module_name.'_'.$supplier_name.'_category'] = 'DROP TABLE IF EXISTS `'._DB_PREFIX_.$module_name.'_'.$supplier_name.'_category`;
	CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.$module_name.'_'.$supplier_name.'_category` (
		`id_'.$module_name.'_'.$supplier_name.'_category` int(10) unsigned NOT NULL AUTO_INCREMENT,
		`id_category_from_supplier` int(10) NOT NULL,
		`id_category_parent` int(11),
		PRIMARY KEY (`id_'.$module_name.'_'.$supplier_name.'_category`)
	) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;';
$sql[$module_name.'_'.$supplier_name.'_category_shop'] = 'DROP TABLE IF EXISTS `'._DB_PREFIX_.$module_name.'_'.$supplier_name.'_category_shop`;
	CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.$module_name.'_'.$supplier_name.'_category_shop` (
		`id_'.$module_name.'_'.$supplier_name.'_category` int(10) unsigned NOT NULL AUTO_INCREMENT,
		`id_shop` int(10) unsigned NOT NULL,
		PRIMARY KEY (`id_'.$module_name.'_'.$supplier_name.'_category`,`id_shop`)
	) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;';
$sql[$module_name.'_'.$supplier_name.'_category_lang'] = 'DROP TABLE IF EXISTS `'._DB_PREFIX_.$module_name.'_'.$supplier_name.'_category_lang`;
	CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.$module_name.'_'.$supplier_name.'_category_lang` (
		`id_'.$module_name.'_'.$supplier_name.'_category` int(10) unsigned NOT NULL AUTO_INCREMENT,
		`id_lang` int(10) unsigned NOT NULL,
		`title` varchar(255) NOT NULL,
		PRIMARY KEY (`id_'.$module_name.'_'.$supplier_name.'_category`,`id_lang`)
	) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;';

//Create intermediate table for the Manufacturers
$sql[$module_name.'_'.$supplier_name.'_manufacturer'] = 'DROP TABLE IF EXISTS `'._DB_PREFIX_.$module_name.'_'.$supplier_name.'_manufacturer`;
	CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.$module_name.'_'.$supplier_name.'_manufacturer` (
		`id_'.$module_name.'_'.$supplier_name.'_manufacturer` int(10) unsigned NOT NULL AUTO_INCREMENT,
		`id_manufacturer_from_supplier` int(10) NOT NULL,
		PRIMARY KEY (`id_'.$module_name.'_'.$supplier_name.'_manufacturer`)
	) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;';
$sql[$module_name.'_'.$supplier_name.'_manufacturer_shop'] = 'DROP TABLE IF EXISTS `'._DB_PREFIX_.$module_name.'_'.$supplier_name.'_manufacturer_shop`;
	CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.$module_name.'_'.$supplier_name.'_manufacturer_shop` (
		`id_'.$module_name.'_'.$supplier_name.'_manufacturer` int(10) unsigned NOT NULL AUTO_INCREMENT,
		`id_shop` int(10) unsigned NOT NULL,
		PRIMARY KEY (`id_'.$module_name.'_'.$supplier_name.'_manufacturer`,`id_shop`)
	) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;';
$sql[$module_name.'_'.$supplier_name.'_manufacturer_lang'] = 'DROP TABLE IF EXISTS `'._DB_PREFIX_.$module_name.'_'.$supplier_name.'_manufacturer_lang`;
	CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.$module_name.'_'.$supplier_name.'_manufacturer_lang` (
		`id_'.$module_name.'_'.$supplier_name.'_manufacturer` int(10) unsigned NOT NULL AUTO_INCREMENT,
		`id_lang` int(10) unsigned NOT NULL,
		`title` varchar(255) NOT NULL,
		PRIMARY KEY (`id_'.$module_name.'_'.$supplier_name.'_manufacturer`,`id_lang`)
	) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;';


//Create intermediate attribute table
$sql[$module_name.'_'.$supplier_name.'_attribute'] = 'DROP TABLE IF EXISTS `'._DB_PREFIX_.$module_name.'_'.$supplier_name.'_attribute`;
	CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.$module_name.'_'.$supplier_name.'_attribute` (
		`id_'.$module_name.'_'.$supplier_name.'_attribute` int(10) unsigned NOT NULL AUTO_INCREMENT,
		`id_'.$module_name.'_'.$supplier_name.'_attribute_group` int(10) NOT NULL,
		PRIMARY KEY (`id_'.$module_name.'_'.$supplier_name.'_attribute`)
	) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;';
$sql[$module_name.'_'.$supplier_name.'_attribute_shop'] = 'DROP TABLE IF EXISTS `'._DB_PREFIX_.$module_name.'_'.$supplier_name.'_attribute_shop`;
	CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.$module_name.'_'.$supplier_name.'_attribute_shop` (
		`id_'.$module_name.'_'.$supplier_name.'_attribute` int(10) unsigned NOT NULL AUTO_INCREMENT,
		`id_shop` int(10) NOT NULL,
		PRIMARY KEY (`id_'.$module_name.'_'.$supplier_name.'_attribute`,`id_shop`)
	) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;';
$sql[$module_name.'_'.$supplier_name.'_attribute_lang'] = 'DROP TABLE IF EXISTS `'._DB_PREFIX_.$module_name.'_'.$supplier_name.'_attribute_lang`;
	CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.$module_name.'_'.$supplier_name.'_attribute_lang` (
		`id_'.$module_name.'_'.$supplier_name.'_attribute` int(10) unsigned NOT NULL AUTO_INCREMENT,
		`id_lang` int(10) NOT NULL,
		`name` varchar(255) NOT NULL,
		PRIMARY KEY (`id_'.$module_name.'_'.$supplier_name.'_attribute`,`id_lang`)
	) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;';

//Create intermdiate attribute group table
$sql[$module_name.'_'.$supplier_name.'_attribute_group'] = 'DROP TABLE IF EXISTS `'._DB_PREFIX_.$module_name.'_'.$supplier_name.'_attribute_group`;
	CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.$module_name.'_'.$supplier_name.'_attribute_group` (
		`id_'.$module_name.'_'.$supplier_name.'_attribute_group` int(10) unsigned NOT NULL AUTO_INCREMENT,
		`group_type` enum(\'select\', \'radio\', \'color\')  DEFAULT \'select\',
		PRIMARY KEY (`id_'.$module_name.'_'.$supplier_name.'_attribute_group`)
	) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;';
$sql[$module_name.'_'.$supplier_name.'_attribute_group_shop'] = 'DROP TABLE IF EXISTS `'._DB_PREFIX_.$module_name.'_'.$supplier_name.'_attribute_group_shop`;
	CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.$module_name.'_'.$supplier_name.'_attribute_group_shop` (
		`id_'.$module_name.'_'.$supplier_name.'_attribute_group` int(10) unsigned NOT NULL AUTO_INCREMENT,
		`id_shop` int(10) unsigned NOT NULL,
		PRIMARY KEY (`id_'.$module_name.'_'.$supplier_name.'_attribute_group`,`id_shop`)
	) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;';
$sql[$module_name.'_'.$supplier_name.'_attribute_group_lang'] = 'DROP TABLE IF EXISTS `'._DB_PREFIX_.$module_name.'_'.$supplier_name.'_attribute_group_lang`;
	CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.$module_name.'_'.$supplier_name.'_attribute_group_lang` (
		`id_'.$module_name.'_'.$supplier_name.'_attribute_group` int(10) unsigned NOT NULL AUTO_INCREMENT,
		`id_lang` int(10) unsigned NOT NULL,
		`name` varchar(128) NOT NULL,
		`public_name` varchar(64) NOT NULL,
		PRIMARY KEY (`id_'.$module_name.'_'.$supplier_name.'_attribute_group`,`id_lang`)
	) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;';

$sql[$module_name.'_'.$supplier_name.'_product_attribute'] = 'DROP TABLE IF EXISTS `'._DB_PREFIX_.$module_name.'_'.$supplier_name.'_product_attribute`;
	CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.$module_name.'_'.$supplier_name.'_product_attribute` (
		`id_'.$module_name.'_'.$supplier_name.'_product_attribute` int(10) unsigned NOT NULL AUTO_INCREMENT,
		`id_product_from_supplier` int(10) NOT NULL,
		`id_'.$module_name.'_'.$supplier_name.'_product` int(10) NOT NULL,
		`id_'.$module_name.'_'.$supplier_name.'_attribute` int(10) NOT NULL,
		`reference` varchar(32) DEFAULT NULL,
		`ean13` varchar(13) DEFAULT NULL,
		`quantity` int(10) NOT NULL DEFAULT \'0\',
		PRIMARY KEY (`id_'.$module_name.'_'.$supplier_name.'_product_attribute`)
	) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;';