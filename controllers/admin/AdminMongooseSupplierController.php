<?php

require_once (dirname(__FILE__) . '/../../classes/MongooseSupplier.php');
require_once (dirname(__FILE__) . '/../../classes/MongooseSupplierConfig.php');

class AdminMongooseSupplierController extends ModuleAdminController
{
	
	public function __construct()
	{
		$this->table = 'mongoose_supplier';
		$this->className = 'MongooseSupplier';

		$this->fields_list = array(
			'id_mongoose_supplier' => array(
				'title' => $this->l('ID'),
				'width' => 45,
				'align' => 'left',
				'type' => 'int'
			),
			'name' => array(
				'title' => $this->l('Supplier name'),
				'width' => 'auto',
				'align' => 'left',
				'type' => 'text'
			),
			'active' => array(
				'title' => $this->l('Active'),
				'width' => 50,
				'align' => 'center',
				'type' => 'bool',
				'active' => 'status',
				'ajax' => false
			)
		);
		parent::__construct();
		$this->bootstrap = true;
	}

	public function renderList()
	{
		$this->addRowAction('edit');
		$this->addRowAction('delete');
		return parent::renderList();
	}

	public function renderForm()
	{
		$this->fields_form = array(
			'legend' => array(
				'title' => $this->l('Add supplier'),
			),
			'input' => array(
				array(
					'type' => 'text',
					'label' => $this->l('Supplier name'),
					'name' => 'name',
					'required' => TRUE,
				),
				array(
					'type' => 'text',
					'label' => $this->l('URL website of the supplier'),
					'name' => 'general_url',
				),
				array(
					'type' => 'radio',
					'label' => $this->l('Active'),
					'name' => 'active',
					'is_bool' => true,
					'values'    => array(                                 
					    array(
					      	'id'    => 'active_on',
					      	'value' => 1,
					      	'label' => $this->l('Enabled')
					    ),
					    array(
					      	'id'    => 'active_off',
					      	'value' => 0,
					      	'label' => $this->l('Disabled')
					    )
					 ),
				),
			),
			'submit' => array('title' => $this->l('Save'),'class' => 'btn btn-default pull-right')
		);

		return parent::renderForm();
	}

	/**
	* Override the processDelete function to delete supplierproduct table
	*
	*/
	public function processDelete()
	{
		if (Validate::isLoadedObject($object = $this->loadObject()))
		{
			if (!$this->uninstallSqlDb(Tools::link_rewrite($object->name)))
				$this->errors[] = Tools::displayError('Can\'t delete the supplier product table');
		}
		else
		{
			$this->errors[] = Tools::displayError('An error occurred while deleting the object.').
				' <b>'.$this->table.'</b> '.
				Tools::displayError('(cannot load object)');
		}

		parent::processDelete();
	}


	/**
	* Override the proccessSave function to create the tables for the supplier and add a supplier config entry
	*
	*/
	public function processAdd()
	{

		// Transform the supplier name in an url-friendly style. 
		// This name will be the namespace in the name of the table (ps_{MODULE_NAME}_{SUPPLIER_NAME}_xxxxx)
		if(!$this->installSqlDb(Tools::link_rewrite($_POST['name'])))
			$this->errors[] = Tools::displayError('Can\'t install the supplier product table');
		if(!$object = parent::processAdd())
			return false;
		$supplier_config = new MongooseSupplierConfig();
		$supplier_config->id_mongoose_supplier = $object->id;
		if(!$supplier_config->add())
			return false;
		return true;
	}
	

	/**
	* Override the processAdd function to modify the name of the supplier table, that we create with processAdd (see above). and rename the config entry name table
	*
	*/
	public function processUpdate()
	{
		$object = $this->loadObject();
		if (!$this->renameTable(Tools::link_rewrite($object->name),Tools::link_rewrite($_POST['name'])))
			$this->errors[] = Tools::displayError('Can\'t rename the supplier product table');
		if(parent::processUpdate())
			return false;
		return true;
	}

	/**
	* Create the tables for the import of supplier
	* 
	* @param string $supplier_name
	*/

	private function installSqlDb($supplier_name)
	{
		$module_name = $this->module->name;
		$return = true;
		include (dirname(__FILE__).'/../../sql/sql-supplier-product.php');
		foreach ($sql as $s) {
			Db::getInstance()->execute($s);
			$erreur_sql = Db::getInstance()->getMsgError();
			if (!empty($erreur_sql))
			{
				$return = false;
				throw new Exception("Erreur installation sql supplier : $erreur_sql");	
			}
		}
		return $return;
	}

	/**
	* Rename the table with the modified supplier
	*
	*/
	private function renameTable($supplier_name,$new_supplier_name)
	{
		$module_name = $this->module->name;
		include (dirname(__FILE__).'/../../sql/sql-supplier-product.php');
		foreach($sql as $name => $v)
			Db::getInstance()->execute('RENAME TABLE '._DB_PREFIX_.$name.' TO '._DB_PREFIX_.str_replace($supplier_name, $new_supplier_name, $name).';');
		return true;
	}
	
	/**
	* Delete the supplierproduct table
	*
	*/
	public function uninstallSqlDb($supplier_name)
	{
		$return = array();
		$module_name = $this->module->name;
		include (dirname(__FILE__).'/../../sql/sql-supplier-product.php');
		foreach ($sql as $name => $v){
			Db::getInstance()->execute('DROP TABLE IF EXISTS '._DB_PREFIX_.$name.';');
			$erreur_sql = Db::getInstance()->getMsgError();
			if (!empty($erreur_sql))
			{
				$return = false;
				throw new Exception("Erreur installation sql supplier : $erreur_sql");	
			}
		}
			
		return $return;
	}
}