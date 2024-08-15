<?php

/******************************************************************************/
/******************************************************************************/

class CPBSLogManager
{
	/**************************************************************************/
	
	function __construct()
	{
		$this->type=array
		(
			'mail'=>array
			(
				1=>array
				(
					'description'=>esc_html__('Sending an notification about new booking to the customer.','car-park-booking-system')
				),
				2=>array
				(
					'description'=>esc_html__('Sending an notification about new booking on defined e-mail addresses.','car-park-booking-system')
				),
				3=>array
				(
					'description'=>esc_html__('Sending an notification about new changes in the booking to the customer.','car-park-booking-system')
				)
			),
			'nexmo'=>array
			(
				1=>array
				(
					'description'=>esc_html__('Sending an notification about new booking on defined phone number.','car-park-booking-system')
				)
			),
			'twilio'=>array
			(
				1=>array
				(
					'description'=>esc_html__('Sending an notification about new booking on defined phone number.','car-park-booking-system')
				)
			),
			'telegram'=>array
			(
				1=>array
				(
					'description'=>esc_html__('Sending an notification about new booking on defined phone number.','car-park-booking-system')
				)
			),
			'google_calendar'=>array
			(
				1=>array
				(
					'description'=>esc_html__('Adding a new event to the calendar.','car-park-booking-system')
				),
				2=>array
				(
					'description'=>__('Getting a calendar list.','car-park-booking-system')
				),
				3=>array
				(
					'description'=>__('Getting token.','car-park-booking-system')
				)
			),
			'geolocation'=>array
			(
				1=>array
				(
					'description'=>esc_html__('Getting country information based on customer IP address.','car-park-booking-system')
				)
			),
			'stripe'=>array
			(
				1=>array
				(
					'description'=>esc_html__('Creating a payment.','car-park-booking-system')
				),
				2=>array
				(
					'description'=>esc_html__('Receiving a payment.','car-park-booking-system')
				)	
			),
			'paypal'=>array
			(
				1=>array
				(
					'description'=>esc_html__('Creating a payment.','car-park-booking-system')
				),
				2=>array
				(
					'description'=>esc_html__('Receiving a payment.','car-park-booking-system')
				)	
			),
			'fixerio'=>array
			(
				1=>array
				(
					'description'=>esc_html__('Importing an exchange rates.','car-park-booking-system')
				)	
			)
		);
	}
		
	/**************************************************************************/
	
	function add($type,$event,$message)
	{	
		$Validation=new CPBSValidation();
		
		if($Validation->isEmpty($message)) return;
		
		$logType=$this->get($type);
		
		array_unshift($logType,array
		(
			'event'=>$event,
			'timestamp'=>strtotime('now'),
			'message'=>$message
		));
		
		if(count($logType)>9) $logType=array_slice($logType,0,10);
		
		$logFull=$this->get();
		$logFull[$type]=$logType;
		
		update_option(PLUGIN_CPBS_OPTION_PREFIX.'_log',$logFull);
	}
	
	/**************************************************************************/
	
	function get($type=null)
	{
		$log=get_option(PLUGIN_CPBS_OPTION_PREFIX.'_log');

		if(!is_array($log)) $log=array();
		if(is_null($type)) return($log);
		
		if(!array_key_exists($type,$log)) $log[$type]=array();
		if(!is_array($log[$type])) $log[$type]=array();
		
		return($log[$type]);
	}
	
	/**************************************************************************/
	
	function show($type)
	{
		$log=$this->get($type);
		
		if(!count($log)) return;
		
		$Validation=new CPBSValidation();
		
		$i=0;
		$html=null;
		
		foreach($log as $value)
		{
			if($Validation->isNotEmpty($html)) $html.='<br/>';
			if(!array_key_exists($value['event'],$this->type[$type])) continue;
			
			$html.=
			'
				<li>
					<div class="to-field-disabled to-field-disabled-full-width">
						['.esc_html(++$i).']['.date_i18n('d-m-Y G:i:s',$value['timestamp']).']<br/>
						<b>'.esc_html($this->type[$type][$value['event']]['description']).'</b><br/><br/>
						'.nl2br(esc_html($value['message'])).'
					</div>
				</li>
			';
		}
		
		$html='<ul>'.$html.'</ul>';
		
		return($html);
	}
	
	/**************************************************************************/

	function logWPMailError($wp_error)
	{
		global $cpbs_logEvent;
		
		$this->add('mail',$cpbs_logEvent,print_r($wp_error,true));
	}

	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/