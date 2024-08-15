<?php

/******************************************************************************/
/******************************************************************************/

class CPBSFixerIo
{
	/**************************************************************************/
	
	function __construct()
	{
		
	}
	
	/**************************************************************************/
	
	function getRate()
	{		
		$LogManager=new CPBSLogManager();
		
		$url='http://data.fixer.io/api/latest?access_key='.CPBSOption::getOption('fixer_io_api_key').'&base='.CPBSCurrency::getBaseCurrency();
		
		if(($content=file_get_contents($url))===false)
		{
			$LogManager->add('fixerio',1,$content);	
			return(false);
		}
		
		$data=json_decode($content);
		
		if($data->{'success'})
		{
			return($data->{'rates'});
		}
		
		$LogManager->add('fixerio',1,print_r($data,true));	
		
		return(false);
	}

	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/