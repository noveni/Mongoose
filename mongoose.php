<?php

// table mongosse config supplier, xml_curent_key etc



// Pour la page feed, il faut une partie pour importer par fournisseur les produits dans différentes langues
// Une partie qui liste les fournisseur et le nb de produits, et on a le loisir de cliquer sur le fournisseur et de lister les produits de ce fournisseur
// la partie qui importe les produits par fournisseur, s'occcupe donc (dans la step1) de télécharger un fichier source (XML, :TODO: CSV), 
// et puis (dans la step 2) d'importer les produits dans une base intermediaire dédié au supplier.
// et puis (dans la step 3) d'importer les produits de la table intermediare vers la table product. 
// Et si le programme rencontre dans la step 2 ou la step 3 une entrée qui existe déjà, il vérifie si elle est à jour 
// et si la langue dont laquelle n'existe pas et/ou les données ne sont pas à jour il la met à jour et/ou ajoute les données

require_once (dirname(__FILE__) . '/classes/MongooseSupplier.php');
if (!defined('_PS_VERSION_'))
	exit;

class Mongoose extends Module
{
	public function __construct()
	{
		$this->name = 'mongoose';
		$this->tab = 'quick_bulk_update';
		$this->version = '1.0.0';
		$this->author = 'noveni';
		$this->need_instance = 0; // indicates wether to load the module's class when "Modules" page is call in back-office
		$this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
		$this->bootstrap = true;

		parent::__construct();

		$this->displayName = $this->l('Mongoose - Dropshipping module');
		$this->description = $this->l('This module handle the dropshipping feature from external supplier');

		$this->confirmUninstall = $this->l('Are you sure you want to uninstall?');

	}
	//We need to do now the part for the rest fucking bitch

	public function install()
	{
		if (Shop::isFeatureActive())
			Shop::setContext(Shop::CONTEXT_ALL);

		//Ajout d'un onglet à la racine du site
		$parentTab = Tab::getIdFromClassName('AdminMongoose');
		if (empty($parentTab))
			$parentTab = self::createTab(0,$this->name,'Mongoose - Dropshipping ','AdminMongoose');
		self::createTab($parentTab, $this->name, 'Supplier', 'AdminMongooseSupplier');
		self::createTab($parentTab, $this->name, 'Products import', 'AdminMongooseImport');
		// self::createTab($parentTab, $this->name, 'Supplier products', 'AdminMongooseProducts');

		// Configuration::updateValue('MONGOOSE_CURRENT_IMPORT_STEP', 		0);
		// Configuration::updateValue('MONGOOSE_CURRENT_KEY_IN_XML', 0);
		// Configuration::updateValue('MONGOOSE_XML_FILENAME','');
		// Configuration::updateValue('MONGOOSE_XML_LINECOUNT');
		// Configuration::updateValue('MONGOOSE_XML_LANG');

		if (!parent::install() || 
			!$this->installDefaultDb() ||
			!$this->setTheConfiguration()
		)
			return false;
		return true;
	}
	

	public function uninstall()
	{
		// Configuration::deleteByName('MONGOOSE_CURRENT_IMPORT_STEP');
		// Configuration::deleteByName('MONGOOSE_CURRENT_KEY_IN_XML');
		// Configuration::deleteByName('MONGOOSE_XML_FILENAME');
		// Configuration::deleteByName('MONGOOSE_XML_LINECOUNT');
		// Configuration::deleteByName('MONGOOSE_XML_LANG');

		$this->uninstallModuleTab('AdminMongoose');
		$this->uninstallModuleTab('AdminMongooseSupplier');
		$this->uninstallModuleTab('AdminMongooseImport');
		// $this->uninstallModuleTab('AdminMongooseProducts');

		if (!parent::uninstall() ||
			!$this->uninstallDb() ||
			!$this->unsetTheConfiguration()
		)
			return false;
		return true;
	}

	private function setTheConfiguration()
	{
		// Configuration::updateValue(strtoupper($this->name).'_');
		return true;
	}

	private function unsetTheConfiguration()
	{
		// Configuration::deleteByName(strtoupper($this->name).'_');
		return true;
	}

	/**
	* Create the tables for the module
	* 
	*/
	public function installDefaultDb()
	{
		$module_name = $this->name;
		$return = true;
		include (dirname(__FILE__).'/sql/sql-default-install.php');
		
		foreach ($sql as $s) {
			Db::getInstance()->execute($s);
			$erreur_sql = Db::getInstance()->getMsgError();
			if (!empty($erreur_sql))
			{
				$this->uninstall();
				$return = false;
				throw new Exception("Erreur installation SQL : $erreur_sql");
			}
		}
		return $return;
	}
	

	/**
	* Delete the default tables of the module
	*/
	public function uninstallDb()
	{
		$return = true;
		if(!$this->uninstallSupplierProductTable())
			$return = false;
		$module_name = $this->name;
		include(dirname (__FILE__) . '/sql/sql-default-install.php');
		foreach ($sql as $name => $v) {
			Db::getInstance()->execute('DROP TABLE IF EXISTS '._DB_PREFIX_.$name.';');
			$erreur_sql = Db::getInstance()->getMsgError();
			if (!empty($erreur_sql))
			{
				$return = false;
				throw new Exception("Erreur suppression sql supplier $name : $erreur_sql");	
			}
		}
		return $return;
	}

	/**
	* Delete the table create by the controller for the supplierproduct
	*
	*/
	private function uninstallSupplierProductTable()
	{
		$return = true;
		$module_name = $this->name;
		$sql_exec = 'SELECT `name` FROM '._DB_PREFIX_.$module_name.'_supplier';
		if($results = Db::getInstance()->executeS($sql_exec)){
			foreach ($results as $row) 
			{
				$supplier_name = Tools::link_rewrite($row['name']);
				include (dirname(__FILE__).'/sql/sql-supplier-product.php');
				foreach ($sql as $name => $v) 
				{
					Db::getInstance()->execute('DROP TABLE IF EXISTS '._DB_PREFIX_.$name.';');
					$erreur_sql = Db::getInstance()->getMsgError();
					if (!empty($erreur_sql))
					{
						$return = false;
						throw new Exception("Erreur suppression sql supplier $name : $erreur_sql");	
					}
				}
			}
		}
		return $return;

	}

	static function createTab($id_parent, $module, $name, $class_name)
	{
		$Tab = new Tab();
		$Tab->module = $module;
		foreach (Language::getLanguages(true) as $languages)
		{
			$Tab->name[$languages["id_lang"]] = $name;
		}

		$Tab->id_parent = $id_parent;
		$Tab->class_name = $class_name;
		$r = $Tab->save();

		if ($r == false)
			return false;

		return $Tab->id;
	}

	private function uninstallModuleTab($tabClass)
	{
		$idTab = Tab::getIdFromClassName($tabClass);
		if ($idTab != 0)
		{
			$tab = new Tab($idTab);
			$tab->delete();
			return true;
		}
		return false;
	}

}