<?php

/******************************************************************************/
/******************************************************************************/

class CPBSRequest
{
	/**************************************************************************/
	
	static function get($name,$attribute=true)
	{
		if(array_key_exists($name,$_GET))
		{
			if($attribute) return(esc_attr(CPBSHelper::stripslashes($_GET[$name])));
			return(CPBSHelper::stripslashes($_GET[$name]));
		}
		return;
	}

	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/