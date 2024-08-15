<?php

/******************************************************************************/
/******************************************************************************/

class CPBSGoogleMap
{
	/**************************************************************************/

	function __construct()
	{
		$this->position=array
		(
			'TOP_CENTER'=>esc_html__('Top center','car-park-booking-system'),
			'TOP_LEFT'=>esc_html__('Top left','car-park-booking-system'),
			'TOP_RIGHT'=>esc_html__('Top right','car-park-booking-system'),
			'LEFT_TOP'=>esc_html__('Left top','car-park-booking-system'),
			'RIGHT_TOP'=>esc_html__('Right top','car-park-booking-system'),
			'LEFT_CENTER'=>esc_html__('Left center','car-park-booking-system'),
			'RIGHT_CENTER'=>esc_html__('Right center','car-park-booking-system'),
			'LEFT_BOTTOM'=>esc_html__('Left bottom','car-park-booking-system'),
			'RIGHT_BOTTOM'=>esc_html__('Right bottom','car-park-booking-system'),
			'BOTTOM_CENTER'=>esc_html__('Bottom center','car-park-booking-system'),
			'BOTTOM_LEFT'=>esc_html__('Bottom left','car-park-booking-system'),
			'BOTTOM_RIGHT'=>esc_html__('Bottom right','car-park-booking-system')
		);
		
		$this->mapTypeControlId=array
		(
			'ROADMAP'=>esc_html__('Roadmap','car-park-booking-system'),
			'SATELLITE'=>esc_html__('Satellite','car-park-booking-system'),
			'HYBRID'=>esc_html__('Hybrid','car-park-booking-system'),
			'TERRAIN'=>esc_html__('Terrain','car-park-booking-system')
		);
		
		$this->mapTypeControlStyle=array
		(
			'DEFAULT'=>esc_html__('Default','car-park-booking-system'),
			'HORIZONTAL_BAR'=>esc_html__('Horizontal Bar','car-park-booking-system'),
			'DROPDOWN_MENU'=>esc_html__('Dropdown Menu','car-park-booking-system')
		);
		
		$this->routeAvoid=array
		(
			'tolls'=>esc_html__('Tolls','car-park-booking-system'),
			'highways'=>esc_html__('Highways','car-park-booking-system'),
			'ferries'=>esc_html__('Ferries','car-park-booking-system')
		);
	}
	
	/**************************************************************************/
	
	function getMapTypeControlStyle()
	{
		return($this->mapTypeControlStyle);
	}
   
	 /**************************************************************************/
	
	function getPosition()
	{
		return($this->position);
	}
	
	/**************************************************************************/
	
	function getMapTypeControlId()
	{
		return($this->mapTypeControlId);
	}
	
	/**************************************************************************/
	
	function getRouteAvoid()
	{
		return($this->routeAvoid);
	}

	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/