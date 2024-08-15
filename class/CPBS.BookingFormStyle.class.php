<?php

/******************************************************************************/
/******************************************************************************/

class CPBSBookingFormStyle
{
	/**************************************************************************/
	
	function __construct()
	{
		$this->color=array
		(
			1=>array
			(
				'color'=>'004280'
			),
			2=>array
			(
				'color'=>'F9BE57'
			),
			3=>array
			(
				'color'=>'FFFFFF'
			),
			4=>array
			(
				'color'=>'778591'
			),
			5=>array
			(
				'color'=>'EAECEE'
			),
			6=>array
			(
				'color'=>'2C3E50'
			),
			7=>array
			(
				'color'=>'F0F2F8'
			),
			8=>array
			(
				'color'=>'9EA8B2'
			),
			9=>array
			(
				'color'=>'556677'
			),
			10=>array
			(
				'color'=>'C0C8D1'
			),
		);
	}
	
	/**************************************************************************/
	
	function isColor($color)
	{
		return(array_key_exists($color,$this->getColor()));
	}
	
	/**************************************************************************/
	
	function getColor()
	{
		return($this->color);
	}
	
	/**************************************************************************/
	
	function createCSSFile()
	{
		$path=array
		(
			CPBSFile::getMultisiteBlog()
		);
		
		foreach($path as $pathData)
		{
			if(!CPBSFile::dirExist($pathData)) @mkdir($pathData);			
			if(!CPBSFile::dirExist($pathData)) return(false);
		}
				
		/***/
		
		$content=null;
		
		$Validation=new CPBSValidation();
		$BookingForm=new CPBSBookingForm();
		
		$dictionary=$BookingForm->getDictionary();
		
		foreach($dictionary as $dictionaryIndex=>$dictionaryValue)
		{
			$meta=$dictionaryValue['meta'];

			foreach($this->getColor() as $colorIndex=>$colorValue)
			{
				if((!isset($meta['style_color'][$colorIndex])) || (!$Validation->isColor($meta['style_color'][$colorIndex]))) 
					$meta['style_color'][$colorIndex]=$colorValue['color'];
			}
			
			$data=array();
		
			$data['color']=$meta['style_color'];
			$data['main_css_class']='.cpbs-booking-form-id-'.$dictionaryIndex;

			$Template=new CPBSTemplate($data,PLUGIN_CPBS_TEMPLATE_PATH.'public/style.php');
		
			$content.=$Template->output();
		}
		
		if($Validation->isNotEmpty($content))
			file_put_contents(CPBSFile::getMultisiteBlogCSS(),$content); 
	}
	
	/**************************************************************************/
	
	function getDefaultColor()
	{
		return($this->color[1]['color']);
	}
	
	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/