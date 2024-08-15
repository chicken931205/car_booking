<?php

/******************************************************************************/
/******************************************************************************/

class CPBSBillingType
{
	/**************************************************************************/

	function __construct()
	{
		$this->billingType=array
		(
			1=>array(esc_html__('Minute','car-park-booking-system')),
			2=>array(esc_html__('Hour','car-park-booking-system')),
			3=>array(esc_html__('Day','car-park-booking-system')),
			6=>array(esc_html__('Day II','car-park-booking-system')),
			4=>array(esc_html__('Hour + minute','car-park-booking-system')),
			5=>array(esc_html__('Day + hour','car-park-booking-system')),
			7=>array(esc_html__('Day + hour II','car-park-booking-system'))
		);
	}

	/**************************************************************************/

	function getDictionary()
	{
		return($this->billingType);
	}

	/**************************************************************************/

	function isBillingType($billingType)
	{
		return(array_key_exists($billingType,$this->billingType));
	}

	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/