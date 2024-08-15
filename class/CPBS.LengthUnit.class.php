<?php

/******************************************************************************/
/******************************************************************************/

class CPBSLengthUnit
{
	/**************************************************************************/
	
	function __construct()
	{
		$this->lengthUnit=array
		(
			1=>array(__('Meters','car-park-booking-system'),__('m','car-park-booking-system')),
			2=>array(__('Feets','car-park-booking-system'),__('ft','car-park-booking-system'))
		);
	}
	
	/**************************************************************************/
	
	function getLengthUnit($lengthUnit=null)
	{
		if($lengthUnit===null)
			return($this->lengthUnit);
		else return($this->lengthUnit[$lengthUnit]);
	}
	
	/**************************************************************************/
	
	function getLengthUnitName($lengthUnit)
	{
		if(!$this->isLengthUnit($lengthUnit)) return($this->lengthUnit[1][0]);
		return($this->lengthUnit[$lengthUnit][0]);
	}
	
	/**************************************************************************/
	
	function getLengthUnitShortName($lengthUnit)
	{
		if(!$this->isLengthUnit($lengthUnit)) return($this->lengthUnit[1][1]);
		return($this->lengthUnit[$lengthUnit][1]);
	}	
	
	/**************************************************************************/
	
	function isLengthUnit($lengthUnit)
	{
		return(array_key_exists($lengthUnit,$this->getLengthUnit()));
	}
	
	/**************************************************************************/
	
	function format($value,$lengthUnit=-1)
	{
		if($lengthUnit==-1) $lengthUnit=CPBSOption::getOption('length_unit');
		
		if(!$this->isLengthUnit($lengthUnit)) $lengthUnit=1;
		
		if($lengthUnit==2) $value=round($this->convertLengthUnit($value),2);
		
		$value=$value.' '.$this->$lengthUnit[$lengthUnit][1];
		return($value);
	}
	
	/**************************************************************************/
	
	function convertLengthUnit($value,$from=1,$to=2)
	{
		if(($from==1) && ($to==2))
		{
			$value/=3.2808399;
		}
		else if(($from==2) && ($to==1))
		{
			$value*=3.2808399;
		}
		
		return(number_format(round((float)$value,2),2,'.',''));
	}
	
	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/