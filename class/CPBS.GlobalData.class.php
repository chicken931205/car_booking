<?php

/******************************************************************************/
/******************************************************************************/

class CPBSGlobalData
{
	/**************************************************************************/
	
	static function setGlobalData($name,$functionCallback,$refresh=false)
	{
		global $cpbsGlobalData;
		
		if(isset($cpbsGlobalData[$name]) && (!$refresh)) return($cpbsGlobalData[$name]);
		
		if(is_callable($functionCallback)) $cpbsGlobalData[$name]=call_user_func($functionCallback);
		else $cpbsGlobalData[$name]=$functionCallback;
		
		return($cpbsGlobalData[$name]);
	}
	
	/**************************************************************************/
	
	static function isSetGlobalData($name)
	{
		global $cpbsGlobalData;
		return(isset($cpbsGlobalData[$name]));
	}
	
	/**************************************************************************/
	
	static function getGlobalData($name)
	{
		global $cpbsGlobalData;
		
		if((is_array($cpbsGlobalData)) && (isset($cpbsGlobalData[$name]))) return($cpbsGlobalData[$name]);
		
		return(null);
	}

	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/