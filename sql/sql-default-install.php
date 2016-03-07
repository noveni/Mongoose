<?php

$sql = array();

$sql[$module_name.'_supplier'] = 'DROP TABLE IF EXISTS `'._DB_PREFIX_.$module_name.'_supplier`;
	CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.$module_name.'_supplier` (
		`id_'.$module_name.'_supplier` int(10) unsigned NOT NULL AUTO_INCREMENT,
		`name` varchar(255) NOT NULL,
		`general_url` varchar(255),
		`active` tinyint(1),
		PRIMARY KEY (`id_'.$module_name.'_supplier`)
	) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;';

$sql[$module_name.'_supplier_config'] = 'DROP TABLE IF EXISTS `'._DB_PREFIX_.$module_name.'_supplier_config`;
	CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.$module_name.'_supplier_config` (
		`id_'.$module_name.'_supplier_config` int(10) unsigned NOT NULL AUTO_INCREMENT,
		`id_'.$module_name.'_supplier` int(10),
		`src_file` varchar(255),
		`src_line_total` int(10),
		`src_id_lang` int(10),
		`src_current_line` int(10),
		PRIMARY KEY (`id_'.$module_name.'_supplier_config`)
	) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;';