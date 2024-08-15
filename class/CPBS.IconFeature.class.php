<?php

/******************************************************************************/
/******************************************************************************/

class CPBSIconFeature
{
	/**************************************************************************/
	
	function __construct()
	{
		$this->icon=array
		(
			'01'=>array(esc_html__('Car 01','car-park-booking-system')),
			'02'=>array(esc_html__('Car 02','car-park-booking-system')),
			'03'=>array(esc_html__('Camper','car-park-booking-system')),
			'04'=>array(esc_html__('Truck','car-park-booking-system')),
			'05'=>array(esc_html__('Heavy truck','car-park-booking-system')),
			'06'=>array(esc_html__('Bus','car-park-booking-system')),
			'07'=>array(esc_html__('Two-wheeled vehicle','car-park-booking-system')),
			'08'=>array(esc_html__('Scooter','car-park-booking-system')),
			'09'=>array(esc_html__('Bike','car-park-booking-system')),
			'10'=>array(esc_html__('Caravan','car-park-booking-system')),
			'11'=>array(esc_html__('Reserved space','car-park-booking-system')),
			'12'=>array(esc_html__('Locked space','car-park-booking-system')),
			'13'=>array(esc_html__('Privileged space','car-park-booking-system')),
			'14'=>array(esc_html__('Electric car','car-park-booking-system')),
			'15'=>array(esc_html__('Private space','car-park-booking-system')),
			'16'=>array(esc_html__('Covered space','car-park-booking-system')),
			'17'=>array(esc_html__('Guarded space','car-park-booking-system'))
		);
	}
	
	/**************************************************************************/
	
	function getIcon($icon=null)
	{
		if($icon===null) return($this->icon);
		else return($this->icon[$icon]);
	}

	/**************************************************************************/
	
	function isIcon($icon)
	{
		return(array_key_exists($icon,$this->icon));
	}
		
	/**************************************************************************/
	
	function getDefaultIcon()
	{
		return(key($this->icon));
	}
	
	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/