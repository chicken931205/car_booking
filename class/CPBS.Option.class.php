<?php

/******************************************************************************/
/******************************************************************************/

class CPBSOption
{
	/**************************************************************************/
	
	static function createOption($refresh=false)
	{
		return(CPBSGlobalData::setGlobalData(PLUGIN_CPBS_CONTEXT,array('CPBSOption','createOptionObject'),$refresh));				
	}
		
	/**************************************************************************/
	
	static function createOptionObject()
	{	
		return((array)get_option(PLUGIN_CPBS_OPTION_PREFIX.'_option'));
	}
	
	/**************************************************************************/
	
	static function refreshOption()
	{
		return(self::createOption(true));
	}
	
	/**************************************************************************/
	
	static function getOption($name)
	{
		global $cpbsGlobalData;

		self::createOption();

		if(!array_key_exists($name,$cpbsGlobalData[PLUGIN_CPBS_CONTEXT])) return(null);
		return($cpbsGlobalData[PLUGIN_CPBS_CONTEXT][$name]);		
	}

	/**************************************************************************/
	
	static function getOptionObject()
	{
		global $cpbsGlobalData;
		return($cpbsGlobalData[PLUGIN_CPBS_CONTEXT]);
	}
	
	/**************************************************************************/
	
	static function updateOption($option)
	{
		$nOption=array();
		foreach($option as $index=>$value) $nOption[$index]=$value;
		
		$oOption=self::refreshOption();

		update_option(PLUGIN_CPBS_OPTION_PREFIX.'_option',array_merge($oOption,$nOption));
		
		self::refreshOption();
	}
	
	/**************************************************************************/
	
	static function resetOption()
	{
		update_option(PLUGIN_CPBS_OPTION_PREFIX.'_option',array());
		self::refreshOption();		
	}
	
	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/