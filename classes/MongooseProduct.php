<?php
$supplier_name = 'no';

class MongooseProduct extends ObjectModel
{
	public $id;
	public $id_mongoose_product;
	public $id_product_from_supplier;
	public $reference;
	public $ean13;
	public $date_add;
	public $date_upd;
	public $price = 0;
	public $wholesale_price = 0;
	public $quantity = 0;
	public $pics_list;
	public $depth = 0;
	public $width = 0;
	public $height = 0;
	public $weight = 0;
	public $supplier;
	public $id_mongoose_category;
	public $id_mongoose_manufacturer;
	public $name;
	public $description;
	public $link_rewrite;

	

	public static $definition = array(
		'table' => 'mongoose_'.$supplier_name.'_product',
		'primary' => 'id_mongoose_'.$supplier_name.'_product',
		'multilang' => TRUE,
		'fields' => array(
			'id_product_'.$supplier_name.'_supplier' =>			array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt', 'required' => true),
			'id_supplier' => 					array('type' => self::TYPE_INT, 'validate' => 'isInt', 'required' => true),
			'reference' => 						array('type' => self::TYPE_STRING,'validate' => 'isReference'),
			'ean13' => 							array('type' => self::TYPE_STRING, 'validate' => 'isEan13'),
			'date_add' => 						array('type' => self::TYPE_DATE, 'validate' => 'isDateFormat'),
			'date_upd' => 						array('type' => self::TYPE_DATE, 'validate' => 'isDateFormat'),
			'price' => 							array('type' => self::TYPE_FLOAT, 'validate' => 'isPrice', 'required' => true),
			'wholesale_price' =>				array('type' => self::TYPE_FLOAT, 'validate' => 'isPrice'),
			'quantity' =>						array('type' => self::TYPE_INT,'validate' => 'isUnsignedInt'),
			'pics_list' => 						array('type' => self::TYPE_STRING,'validate' => 'isString'),
			'depth' => 							array('type' => self::TYPE_FLOAT, 'validate' => 'isUnsignedFloat'),
			'width' => 							array('type' => self::TYPE_FLOAT, 'validate' => 'isUnsignedFloat'),
			'height' => 						array('type' => self::TYPE_FLOAT, 'validate' => 'isUnsignedFloat'),
			'weight' => 						array('type' => self::TYPE_FLOAT, 'validate' => 'isUnsignedFloat'),
			'id_default_category_supplier' =>	array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
			'id_manufacturer_supplier' => 		array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),

			/* Lang fields */
			'name' =>						array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isString', 'required' => true),
			'description' =>				array('type' => self::TYPE_HTML, 'lang' => true, 'validate' => 'isCleanHtml'),
			'link_rewrite' =>				array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isLinkRewrite',  'required' => true)
		)
	);

	public static function count(){
		return Db::getInstance()->getValue('SELECT FOUND_ROWS() AS `'._DB_PREFIX_.'mongoose_product'.'`', false);
	}
	
}