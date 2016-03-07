<?php

class MongooseSupplier extends ObjectModel
{
	public $id;
	public $id_mongoose_supplier;
	public $name;
	public $general_url;
	public $active;

	public static $definition = array(
		'table' => 'mongoose_supplier',
		'primary' => 'id_mongoose_supplier',
		'multilang' => FALSE,
		'fields' => array(
			'name' 			=> array('type' => self::TYPE_STRING, 'validate' => 'isString', 'required' => true),
			'general_url' 	=> array('type' => self::TYPE_STRING, 'validate' => 'isUrl'),
			'active' 		=> array('type' => self::TYPE_BOOL)
		)
	);
}