<?php

/******************************************************************************/
/******************************************************************************/

class CPBSDemo
{
	/**************************************************************************/
	
	/**************************************************************************/
	
	function __construct()
	{
		$this->pluginWPImportPath='wordpress-importer/wordpress-importer.php';
	}
	
	/**************************************************************************/
	
	function importStart(&$pluginWPImportActive)
	{
		if(($pluginWPImportActive=is_plugin_active($this->pluginWPImportPath))!==false)
		{
			deactivate_plugins($this->pluginWPImportPath);		
		}
	}
	
	/**************************************************************************/
	
	function importStop($pluginWPImportActive)
	{
		if($pluginWPImportActive)
		{
			activate_plugin($this->pluginWPImportPath);		
		}
	}
	
	/**************************************************************************/
	
	function import()
	{
		error_reporting(E_ALL);
		
		ob_start();
		ob_clean();
		
		$pluginWPImportActive=false;
		
		$this->importStart($pluginWPImportActive);
		
		/***/
		
		if(!defined('WP_LOAD_IMPORTERS')) define('WP_LOAD_IMPORTERS',true);

		CPBSInclude::includeFile(ABSPATH.'wp-admin/includes/import.php');

		$includeClass=array
		(
			array
			(
				'class'=>'WP_Import',
				'path'=>PLUGIN_CPBS_LIBRARY_PATH.'wordpress-importer/wordpress-importer.php'				
			)
		);

		foreach($includeClass as $value)
		{
			$r=CPBSInclude::includeClass($value['path'],array($value['class']));
			if($r!==true) break;
		}

		if($r===false) 
		{
			$this->importStop($pluginWPImportActive);
			return(false);
		}

		/***/
		
		$Import=new WP_Import();
		$Import->fetch_attachments=true;
		$Import->import(PLUGIN_CPBS_DEMO_PATH.'demo.xml.gz');
	
		/***/
		
		$BookingFormStyle=new CPBSBookingFormStyle();
		$BookingFormStyle->createCSSFile();
		
		/***/
		
		$buffer=ob_get_clean();
		if(ob_get_contents()) ob_end_clean();
		
		$this->importStop($pluginWPImportActive);
		
		return($buffer);
	}
	
	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/