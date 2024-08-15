<?php

/******************************************************************************/
/******************************************************************************/

class CPBSLocation
{
	/**************************************************************************/
	
	function __construct()
	{
		$this->businessHourType=array
		(
			1=>array(__('Entry and exit','car-park-booking-system')),
			2=>array(__('Entry','car-park-booking-system')),
			3=>array(__('Exit','car-park-booking-system'))
		);
	}
	
	/**************************************************************************/
	
	function getBusinessHourType()
	{
		return($this->businessHourType);
	}
	
	/**************************************************************************/
	
	function isBusinessHourType($type)
	{
		return(array_key_exists($type,$this->getBusinessHourType()) ? true : false);
	}
	
	/**************************************************************************/
	
	function getBusinessHourTypeName($type)
	{
		if($this->isBusinessHourType($type)) return($this->businessHourType[$type][0]);
	}
	
	/**************************************************************************/
	
	public function init()
	{
		$this->registerCPT();
	}
	
	/**************************************************************************/

	public static function getCPTName()
	{
		return(PLUGIN_CPBS_CONTEXT.'_location');
	}
		
	/**************************************************************************/
	
	private function registerCPT()
	{
		register_post_type
		(
			self::getCPTName(),
			array
			(
				'labels'=>array
				(
					'name'=>esc_html__('Locations','car-park-booking-system'),
					'singular_name'=>esc_html__('Locations','car-park-booking-system'),
					'add_new'=>esc_html__('Add New','car-park-booking-system'),
					'add_new_item'=>esc_html__('Add New Location','car-park-booking-system'),
					'edit_item'=>esc_html__('Edit Location','car-park-booking-system'),
					'new_item'=>esc_html__('New Location','car-park-booking-system'),
					'all_items'=>esc_html__('Locations','car-park-booking-system'),
					'view_item'=>esc_html__('View Location','car-park-booking-system'),
					'search_items'=>esc_html__('Search Locations','car-park-booking-system'),
					'not_found'=>esc_html__('No Locations Found','car-park-booking-system'),
					'not_found_in_trash'=>esc_html__('No Locations in Trash','car-park-booking-system'),
					'parent_item_colon'=>'',
					'menu_name'=>esc_html__('Locations','car-park-booking-system')
				),
				'public'=>false,
				'show_ui'=>true,
				'show_in_menu'=>'edit.php?post_type='.CPBSBooking::getCPTName(),
				'capability_type'=>'post',
				'menu_position'=>2,
				'hierarchical'=>false,
				'rewrite'=>false,
				'supports'=>array('title','thumbnail','editor','page-attributes')
			)
		);
		
		add_action('save_post',array($this,'savePost'));
		add_action('add_meta_boxes_'.self::getCPTName(),array($this,'addMetaBox'));
		add_filter('postbox_classes_'.self::getCPTName().'_cpbs_meta_box_location',array($this,'adminCreateMetaBoxClass'));
		
		add_filter('manage_edit-'.self::getCPTName().'_columns',array($this,'manageEditColumns')); 
		add_action('manage_'.self::getCPTName().'_posts_custom_column',array($this,'managePostsCustomColumn'));
		add_filter('manage_edit-'.self::getCPTName().'_sortable_columns',array($this,'manageEditSortableColumns'));
	}

	/**************************************************************************/
	
	function addMetaBox()
	{
		add_meta_box(PLUGIN_CPBS_CONTEXT.'_meta_box_location',esc_html__('Main','car-park-booking-system'),array($this,'addMetaBoxMain'),self::getCPTName(),'normal','low');		
	}
	
	/**************************************************************************/
	
	function addMetaBoxMain()
	{
		wp_enqueue_media();
		
		global $post;
		
		$Country=new CPBSCountry();
		$Payment=new CPBSPayment();
		$PlaceType=new CPBSPlaceType();
		$EmailAccount=new CPBSEmailAccount();
		$PaymentStripe=new CPBSPaymentStripe();
		
		$data=array();
		
		$data['meta']=CPBSPostMeta::getPostMeta($post);
		
		$data['nonce']=CPBSHelper::createNonceField(PLUGIN_CPBS_CONTEXT.'_meta_box_location');
		
		$data['dictionary']['country']=$Country->getCountry();
		$data['dictionary']['payment']=$Payment->getPayment();
		$data['dictionary']['place_type']=$PlaceType->getDictionary();
		
		$data['dictionary']['email_account']=$EmailAccount->getDictionary();
		
		$data['dictionary']['payment_stripe_method']=$PaymentStripe->getPaymentMethod();
		
		$data['dictionary']['business_hour_type']=$this->getBusinessHourType();
		
		$Template=new CPBSTemplate($data,PLUGIN_CPBS_TEMPLATE_PATH.'admin/meta_box_location.php');
		echo $Template->output();			
	}
	
	 /**************************************************************************/
	
	function adminCreateMetaBoxClass($class) 
	{
		array_push($class,'to-postbox-1');
		return($class);
	}

	/**************************************************************************/
	
	function setPostMetaDefault(&$meta)
	{
		$PlaceType=new CPBSPlaceType();
		
		$dictionary=CPBSGlobalData::setGlobalData('place_type_dictionary',array($PlaceType,'getDictionary'));
		
		foreach($dictionary as $index=>$value)
		{
			if(!isset($meta['place_type_quantity'][$index]))
				$meta['place_type_quantity'][$index]=0;	
		}
		
		CPBSHelper::setDefault($meta,'place_type_availability_check_enable',1);
		CPBSHelper::setDefault($meta,'place_type_quantity_period',array());
		
		CPBSHelper::setDefault($meta,'entry_period_from','');
		CPBSHelper::setDefault($meta,'entry_period_to','');
		CPBSHelper::setDefault($meta,'entry_period_type','1');
		
		CPBSHelper::setDefault($meta,'booking_period_from','');
		CPBSHelper::setDefault($meta,'booking_period_to','');

		if(!array_key_exists('booking_period_date',$meta))
			$meta['booking_period_date']=array();		
		
		CPBSHelper::setDefault($meta,'address_street','');
		CPBSHelper::setDefault($meta,'address_street_number','');
		CPBSHelper::setDefault($meta,'address_postcode','');
		CPBSHelper::setDefault($meta,'address_city','');
		CPBSHelper::setDefault($meta,'address_state','');
		CPBSHelper::setDefault($meta,'address_country','');
	  
		CPBSHelper::setDefault($meta,'contact_detail_phone_number','');
		CPBSHelper::setDefault($meta,'contact_detail_fax_number','');
		CPBSHelper::setDefault($meta,'contact_detail_email_address','');
		
		CPBSHelper::setDefault($meta,'coordinate_latitude','');
		CPBSHelper::setDefault($meta,'coordinate_longitude','');
		
		if(!array_key_exists('business_hour',$meta))
			$meta['business_hour']=array();
		if(!array_key_exists('date_exclude',$meta))
			$meta['date_exclude']=array();
		
		CPBSHelper::setDefault($meta,'payment_mandatory_enable',0);
		
		CPBSHelper::setDefault($meta,'payment_id',array(1));
		CPBSHelper::setDefault($meta,'payment_default_id',-1);
		CPBSHelper::setDefault($meta,'payment_processing_enable',1);
		CPBSHelper::setDefault($meta,'payment_woocommerce_step_3_enable',1);
		
		CPBSHelper::setDefault($meta,'payment_cash_logo_src','');
		CPBSHelper::setDefault($meta,'payment_cash_info','');

		CPBSHelper::setDefault($meta,'payment_stripe_api_key_secret','');
		CPBSHelper::setDefault($meta,'payment_stripe_api_key_publishable','');
		CPBSHelper::setDefault($meta,'payment_stripe_method',array('card'));
		
		CPBSHelper::setDefault($meta,'payment_stripe_product_id','');
		CPBSHelper::setDefault($meta,'payment_stripe_redirect_duration','5');
		CPBSHelper::setDefault($meta,'payment_stripe_success_url_address','');
		CPBSHelper::setDefault($meta,'payment_stripe_cancel_url_address','');
		CPBSHelper::setDefault($meta,'payment_stripe_booking_summary_page_id','0');
		CPBSHelper::setDefault($meta,'payment_stripe_logo_src','');
		CPBSHelper::setDefault($meta,'payment_stripe_info','');
		
		CPBSHelper::setDefault($meta,'payment_paypal_email_address','');
		CPBSHelper::setDefault($meta,'payment_paypal_redirect_duration','5');
		CPBSHelper::setDefault($meta,'payment_paypal_success_url_address','');
		CPBSHelper::setDefault($meta,'payment_paypal_cancel_url_address','');
		CPBSHelper::setDefault($meta,'payment_paypal_booking_summary_page_id','0');
		CPBSHelper::setDefault($meta,'payment_paypal_sandbox_mode_enable',0);
		CPBSHelper::setDefault($meta,'payment_paypal_logo_src','');        
		CPBSHelper::setDefault($meta,'payment_paypal_info','');

		CPBSHelper::setDefault($meta,'payment_wire_transfer_logo_src','');
		CPBSHelper::setDefault($meta,'payment_wire_transfer_info','');
		
		CPBSHelper::setDefault($meta,'booking_new_sender_email_account_id',-1);
		CPBSHelper::setDefault($meta,'booking_new_recipient_email_address','');
		CPBSHelper::setDefault($meta,'booking_new_woocommerce_email_notification',0);
		
		CPBSHelper::setDefault($meta,'booking_new_customer_email_notification',1);
		CPBSHelper::setDefault($meta,'booking_new_customer_email_notification_payment_success',0);
		CPBSHelper::setDefault($meta,'booking_new_admin_email_notification',1);
		CPBSHelper::setDefault($meta,'booking_new_admin_email_notification_payment_success',0);
		
		CPBSHelper::setDefault($meta,'booking_email_notification_extra_information','');
		
		CPBSHelper::setDefault($meta,'nexmo_sms_enable',0);
		CPBSHelper::setDefault($meta,'nexmo_sms_api_key','');
		CPBSHelper::setDefault($meta,'nexmo_sms_api_key_secret','');
		CPBSHelper::setDefault($meta,'nexmo_sms_sender_name','');
		CPBSHelper::setDefault($meta,'nexmo_sms_recipient_phone_number','');
		CPBSHelper::setDefault($meta,'nexmo_sms_message',esc_html__('New booking is received.','car-park-booking-system'));
		
		CPBSHelper::setDefault($meta,'twilio_sms_enable',0);
		CPBSHelper::setDefault($meta,'twilio_sms_api_sid','');
		CPBSHelper::setDefault($meta,'twilio_sms_api_token','');
		CPBSHelper::setDefault($meta,'twilio_sms_sender_phone_number','');
		CPBSHelper::setDefault($meta,'twilio_sms_recipient_phone_number','');
		CPBSHelper::setDefault($meta,'twilio_sms_message',esc_html__('New booking is received.','car-park-booking-system'));
		
		CPBSHelper::setDefault($meta,'telegram_enable',0);
		CPBSHelper::setDefault($meta,'telegram_token','');
		CPBSHelper::setDefault($meta,'telegram_group_id','');
		CPBSHelper::setDefault($meta,'telegram_message','');
		
		CPBSHelper::setDefault($meta,'google_calendar_enable',0);
		CPBSHelper::setDefault($meta,'google_calendar_id','');
		CPBSHelper::setDefault($meta,'google_calendar_settings','');
		CPBSHelper::setDefault($meta,'google_calendar_server_reply_1','');
	}
	
	/**************************************************************************/
	
	function savePost($postId)
	{	  
		if(!$_POST) return(false);
		
		if(CPBSHelper::checkSavePost($postId,PLUGIN_CPBS_CONTEXT.'_meta_box_location_noncename','savePost')===false) return(false);
				
		$Date=new CPBSDate();
		$Payment=new CPBSPayment();
		$Country=new CPBSCountry();
		$PlaceType=new CPBSPlaceType();
		$Validation=new CPBSValidation();
		$EmailAccount=new CPBSEmailAccount();
		$PaymentStripe=new CPBSPaymentStripe();
		
		$data=CPBSHelper::getPostOption();
		
		$dataIndex=array
		(
			'place_type_availability_check_enable',
			'place_type_quantity',
			'place_type_quantity_period',
			'entry_period_from',
			'entry_period_to',
			'entry_period_type',
			'booking_period_from',
			'booking_period_to',
			'booking_period_date',
			'address_street',
			'address_street_number',
			'address_postcode',
			'address_city',
			'address_state',
			'address_country',
			'contact_detail_phone_number',
			'contact_detail_fax_number',
			'contact_detail_email_address',
			'coordinate_latitude',
			'coordinate_longitude',
			'business_hour',
			'date_exclude',
			'payment_mandatory_enable',
			'payment_processing_enable',
			'payment_woocommerce_step_3_enable',
			'payment_default_id',
			'payment_id',
			'payment_cash_logo_src',
			'payment_cash_info',
			'payment_stripe_api_key_secret',
			'payment_stripe_api_key_publishable',
			'payment_stripe_method',
			'payment_stripe_product_id',
			'payment_stripe_redirect_duration',
			'payment_stripe_success_url_address',
			'payment_stripe_cancel_url_address',
			'payment_stripe_booking_summary_page_id',
			'payment_stripe_logo_src',
			'payment_stripe_info',
			'payment_paypal_email_address',
			'payment_paypal_redirect_duration',
			'payment_paypal_success_url_address',
			'payment_paypal_cancel_url_address',
			'payment_paypal_booking_summary_page_id',
			'payment_paypal_sandbox_mode_enable',
			'payment_paypal_logo_src',
			'payment_paypal_info',	
			'payment_wire_transfer_logo_src',
			'payment_wire_transfer_info',
			'nexmo_sms_enable',
			'nexmo_sms_api_key',
			'nexmo_sms_api_key_secret',
			'nexmo_sms_sender_name',
			'nexmo_sms_recipient_phone_number',
			'nexmo_sms_message',
			'twilio_sms_enable',
			'twilio_sms_api_sid',
			'twilio_sms_api_token',
			'twilio_sms_sender_phone_number',
			'twilio_sms_recipient_phone_number',
			'twilio_sms_message',	
			'telegram_enable',
			'telegram_token',
			'telegram_group_id',
			'telegram_message',
			'booking_new_sender_email_account_id',
			'booking_new_recipient_email_address',
			'booking_new_woocommerce_email_notification',
			'booking_new_customer_email_notification',
			'booking_new_customer_email_notification_payment_success',
			'booking_new_admin_email_notification',
			'booking_new_admin_email_notification_payment_success',
			'booking_email_notification_extra_information',
			'google_calendar_enable',
			'google_calendar_id',
			'google_calendar_settings'
		);
		
		/***/
		
		if(!$Validation->isBool($data['place_type_availability_check_enable']))
			$data['place_type_availability_check_enable']=0;   
		
		/***/
		
		$place=array();
		$dictionary=$PlaceType->getDictionary();
		
		foreach($dictionary as $index=>$value)
		{
			if($Validation->isNumber($data['place_type_quantity'][$index],0,9999))
				$place[$index]=$data['place_type_quantity'][$index];
			else $place[$index]=0;
		}
		
		$data['place_type_quantity']=$place;
		
		/***/
					   
		$placeTypeQuantityPeriod=array();
	   
		foreach($data['place_type_quantity_period']['place_type_id'] as $index=>$value)
		{
			$data['place_type_quantity_period']['date_start'][$index]=$Date->formatDateToStandard($data['place_type_quantity_period']['date_start'][$index]);
			$data['place_type_quantity_period']['time_start'][$index]=$Date->formatTimeToStandard($data['place_type_quantity_period']['time_start'][$index]);
			$data['place_type_quantity_period']['date_stop'][$index]=$Date->formatDateToStandard($data['place_type_quantity_period']['date_stop'][$index]);
			$data['place_type_quantity_period']['time_stop'][$index]=$Date->formatTimeToStandard($data['place_type_quantity_period']['time_stop'][$index]);
				
			$d=array($value,$data['place_type_quantity_period']['date_start'][$index],
							$data['place_type_quantity_period']['time_start'][$index],
							$data['place_type_quantity_period']['date_stop'][$index],
							$data['place_type_quantity_period']['time_stop'][$index],
							$data['place_type_quantity_period']['quantity'][$index]);
			
			if(!array_key_exists($d[0],$dictionary)) continue;
			
			if(!$Validation->isDate($d[1])) continue;
			if(!$Validation->isTime($d[2])) continue;
			if(!$Validation->isDate($d[3])) continue;
			if(!$Validation->isTime($d[4])) continue;
			
			if(!$Validation->isNumber($d[5],0,9999)) continue;
			
			array_push($placeTypeQuantityPeriod,array('place_type_id'=>$d[0],'date_start'=>$d[1],'time_start'=>$d[2],'date_stop'=>$d[3],'time_stop'=>$d[4],'quantity'=>$d[5]));
		}

		$data['place_type_quantity_period']=$placeTypeQuantityPeriod;
		
		/***/
		
		if(!$Validation->isNumber($data['entry_period_from'],0,9999))
			$data['entry_period_from']='';		  
		if(!$Validation->isNumber($data['entry_period_to'],0,9999))
			$data['entry_period_to']='';  
		if(!in_array($data['entry_period_type'],array(1,2,3)))
			$data['entry_period_type']=1;	
		
		if(!$Validation->isNumber($data['booking_period_from'],0,9999))
			$data['booking_period_from']='';		  
		if(!$Validation->isNumber($data['booking_period_to'],0,9999))
			$data['booking_period_to']='';  
		
		/***/
		
		$bookingPeriodDate=array();
		$bookingPeriodDatePost=CPBSHelper::getPostValue('booking_period_date');
	  
		$count=count($bookingPeriodDatePost['date_from']);
		
		for($i=0;$i<$count;$i++)
		{
			$bookingPeriodDatePost['date_from'][$i]=$Date->formatDateToStandard($bookingPeriodDatePost['date_from'][$i]);
			$bookingPeriodDatePost['date_to'][$i]=$Date->formatDateToStandard($bookingPeriodDatePost['date_to'][$i]);
			
			if(!$Validation->isDate($bookingPeriodDatePost['date_from'][$i])) continue;
			if(!$Validation->isDate($bookingPeriodDatePost['date_to'][$i])) continue;

			if($Date->compareDate($bookingPeriodDatePost['date_from'][$i],$bookingPeriodDatePost['date_to'][$i])==1) continue;
			if($Date->compareDate(date_i18n('d-m-Y'),$bookingPeriodDatePost['date_to'][$i])==1) continue;
			
			if(!$Validation->isNumber($bookingPeriodDatePost['unit_from'][$i],1,9999,true)) continue;
			if(!$Validation->isNumber($bookingPeriodDatePost['unit_to'][$i],1,9999,true)) continue;
			
			if(($Validation->isEmpty($bookingPeriodDatePost['unit_to'][$i])) && ($Validation->isEmpty($bookingPeriodDatePost['unit_from'][$i]))) continue;
			
			if(($Validation->isNotEmpty($bookingPeriodDatePost['unit_to'][$i])) && ($Validation->isNotEmpty($bookingPeriodDatePost['unit_from'][$i])))
			{
				if($bookingPeriodDatePost['unit_from'][$i]>$bookingPeriodDatePost['unit_to'][$i]) continue;
			}
			
			$bookingPeriodDate[]=array
			(
				'date_from'=>$bookingPeriodDatePost['date_from'][$i],
				'date_to'=>$bookingPeriodDatePost['date_to'][$i],
				'unit_from'=>$bookingPeriodDatePost['unit_from'][$i],
				'unit_to'=>$bookingPeriodDatePost['unit_to'][$i]
			);
		}

		$data['booking_period_date']=$bookingPeriodDate;
		
		/***/
		
		if(!$Country->isCountry($data['address_country']))
			$data['address_country']='US';	   
		if(!$Validation->isEmailAddress($data['contact_detail_email_address']))
			$data['contact_detail_email_address']='';
		
		/***/
		
		$businessHour=array();
		$businessHourPost=CPBSHelper::getPostValue('business_hour');

		foreach($businessHourPost['period_type'] as $index=>$value)
		{
			$businessHourPost['date'][$index]=$Date->formatDateToStandard($businessHourPost['date'][$index]);
			$businessHourPost['time_start'][$index]=$Date->formatTimeToStandard($businessHourPost['time_start'][$index]);
			$businessHourPost['time_stop'][$index]=$Date->formatTimeToStandard($businessHourPost['time_stop'][$index]);
			
			$bh=array('day_number'=>'','date'=>'');
			
			$t=array($value,$businessHourPost['date'][$index],$businessHourPost['time_start'][$index],$businessHourPost['time_stop'][$index],$businessHourPost['hour_type'][$index]);
			
			if((int)$t[0]===0)
			{
				if(!$Validation->isDate($t[1])) continue;
				if($Date->compareDate(date_i18n('d-m-Y'),$t[1])==1) continue;
				$bh['period_type']=0;
				$bh['date']=$t[1];
			}
			else
			{
				if(!$Date->isDay($t[0])) continue;
				$bh['period_type']=1;
				$bh['day_number']=$t[0];
			}
			
			if(!$Validation->isTime($t[2],false)) continue;
			if(!$Validation->isTime($t[3],false)) continue;
			
			$result=$Date->compareTime($t[2],$t[3]);

			if($result!=2) continue;
			
			if(!$this->isBusinessHourType($t[4])) $t[4]=1;
			
			/***/
			
			$bh['time_start']=$t[2];
			$bh['time_stop']=$t[3];
			$bh['hour_type']=$t[4];
			
			array_push($businessHour,$bh);
		}
		
		$data['business_hour']=$businessHour;
	
		/***/
		
		$dateExclude=array();
		$dateExcludePost=array();
		
		$dateExcludePostStart=CPBSHelper::getPostValue('date_exclude_start');
		$dateExcludePostStop=CPBSHelper::getPostValue('date_exclude_stop');
		
		foreach($dateExcludePostStart as $index=>$value)
		{			
			if(isset($dateExcludePostStop[$index]))
				$dateExcludePost[]=array($dateExcludePostStart[$index],$dateExcludePostStop[$index]);
		}
	  
		foreach($dateExcludePost as $index=>$value)
		{
			$value[0]=$Date->formatDateToStandard($value[0]);
			$value[1]=$Date->formatDateToStandard($value[1]);
			
			if(!$Validation->isDate($value[0],true)) continue;
			if(!$Validation->isDate($value[1],true)) continue;

			if($Date->compareDate($value[0],$value[1])==1) continue;
			if($Date->compareDate(date_i18n('d-m-Y'),$value[1])==1) continue;
			
			$dateExclude[]=array('start'=>$value[0],'stop'=>$value[1]);
		}
		
		$data['date_exclude']=$dateExclude;
		
		/***/
		
		if(!$Validation->isBool($data['payment_mandatory_enable']))
			$data['payment_mandatory_enable']=0;	 
		if(!$Validation->isBool($data['payment_processing_enable']))
			$data['payment_processing_enable']=1; 
		if(!$Validation->isBool($data['payment_woocommerce_step_3_enable']))
			$data['payment_woocommerce_step_3_enable']=1; 		
		if(!$Payment->isPayment($data['payment_default_id']))
			$data['payment_default_id']=-1;
		
		foreach((array)$data['payment_id'] as $index=>$value)
		{
			if($Payment->isPayment($value)) continue;
			unset($data['payment_id'][$value]);
		}
		
		/***/
		
		if(is_array($data['payment_stripe_method']))
		{
			foreach($data['payment_stripe_method'] as $index=>$value)
			{
				if(!$PaymentStripe->isPaymentMethod($value))
					unset($data['payment_stripe_method'][$index]);
			}
		}
			
		if((!is_array($data['payment_stripe_method'])) || (!count($data['payment_stripe_method'])))
			$data['payment_stripe_method']=array('card');
		
		if(!$Validation->isNumber($data['payment_stripe_redirect_duration'],-1,99))
			$data['payment_stripe_redirect_duration']=5;	
		
		if(!$Validation->isNumber($data['payment_stripe_booking_summary_page_id'],1,999999999))
			$data['payment_stripe_booking_summary_page_id']=0;			
			
		/***/
		
		if(!$Validation->isBool($data['payment_paypal_sandbox_mode_enable']))
			$data['payment_paypal_sandbox_mode_enable']=0;   
		
		if(!$Validation->isNumber($data['payment_paypal_redirect_duration'],-1,99))
			$data['payment_paypal_redirect_duration']=5;
		
		if(!$Validation->isNumber($data['payment_paypal_booking_summary_page_id'],1,999999999))
			$data['payment_paypal_booking_summary_page_id']=0;	
		
		/***/
			 
		if(!$Validation->isBool($data['nexmo_sms_enable']))
			$data['nexmo_sms_enable']=0;
			   
		/***/
		
		if(!$Validation->isBool($data['twilio_sms_enable']))
			$data['twilio_sms_enable']=0;
				
		/***/
		
		if(!$Validation->isBool($data['telegram_enable']))
			$data['telegram_enable']=0;		
		
		/***/
		
		$dictionary=$EmailAccount->getDictionary();
		
		if(!array_key_exists($data['booking_new_sender_email_account_id'],$dictionary))
			$data['booking_new_sender_email_account_id']=-1;
		
		$recipient=preg_split('/;/',$data['booking_new_recipient_email_address']);
		
		$data['booking_new_recipient_email_address']='';
		
		foreach($recipient as $index=>$value)
		{
			if($Validation->isEmailAddress($value))
			{
				if($Validation->isNotEmpty($data['booking_new_recipient_email_address'])) $data['booking_new_recipient_email_address'].=';';
				$data['booking_new_recipient_email_address'].=$value;
			}
		} 
		
		if(!$Validation->isBool($data['booking_new_woocommerce_email_notification']))
			$data['booking_new_woocommerce_email_notification']=0;   

		if(!$Validation->isBool($data['booking_new_customer_email_notification']))
			$data['booking_new_customer_email_notification']=0;  
		if(!$Validation->isBool($data['booking_new_customer_email_notification_payment_success']))
			$data['booking_new_customer_email_notification_payment_success']=0;  
		if(!$Validation->isBool($data['booking_new_admin_email_notification']))
			$data['booking_new_admin_email_notification']=0;  
		if(!$Validation->isBool($data['booking_new_admin_email_notification_payment_success']))
			$data['booking_new_admin_email_notification_payment_success']=0;  
		
		/***/
		
		$data['google_calendar_settings']=CPBSHelper::getPostValue('google_calendar_settings');
		
		if(!$Validation->isBool($data['google_calendar_enable']))
			$data['google_calendar_enable']=0;  
		
		/***/
		
		foreach($dataIndex as $index)
			CPBSPostMeta::updatePostMeta($postId,$index,$data[$index]); 
	}
	
	/**************************************************************************/
	
	function getDictionary($attr=array())
	{
		global $post;
		
		$dictionary=array();
		
		$default=array
		(
			'location_id'=>0
		);
		
		$attribute=shortcode_atts($default,$attr);
		CPBSHelper::preservePost($post,$bPost);
		
		$argument=array
		(
			'post_type'=>self::getCPTName(),
			'post_status'=>'publish',
			'posts_per_page'=>-1,
			'orderby'=>array('menu_order'=>'asc','title'=>'asc')
		);
		
		if($attribute['location_id'])
			$argument['p']=$attribute['location_id'];

		$query=new WP_Query($argument);
		if($query===false) return($dictionary);
		
		while($query->have_posts())
		{
			$query->the_post();
			$dictionary[$post->ID]['post']=$post;
			$dictionary[$post->ID]['meta']=CPBSPostMeta::getPostMeta($post);
		}
		
		CPBSHelper::preservePost($post,$bPost,0);	
		
		return($dictionary);		
	}
	
	/**************************************************************************/
	
	function manageEditColumns($column)
	{
		$column=array
		(
			'cb'=>$column['cb'],
			'title'=>esc_html__('Title','car-park-booking-system'),
			'address'=>esc_html__('Address','car-park-booking-system'),
		);
   
		return($column);		  
	}
	
	/**************************************************************************/
	
	function managePostsCustomColumn($column)
	{
		global $post;
		
		switch($column) 
		{
			case 'address':
				
				echo self::displayAddress($post->ID);
				
			break;
		}
	}
	
	/**************************************************************************/
	
	function manageEditSortableColumns($column)
	{
		return($column);	   
	}

	/**************************************************************************/
	
	function displayAddress($locationId)
	{
		$html=null;
		
		$dictionary=$this->getDictionary(array('location_id'=>$locationId));
		if(!count($dictionary)) return($html);
		
		$location=$dictionary[$locationId];
		
		$data=array
		(
			'name'=>$location['post']->post_title,
			'street'=>$location['meta']['address_street'],
			'street_number'=>$location['meta']['address_street_number'],
			'postcode'=>$location['meta']['address_postcode'],
			'city'=>$location['meta']['address_city'],
			'state'=>$location['meta']['address_state'],
			'country'=>$location['meta']['address_country']
		);

		$html=CPBSHelper::displayAddress($data);
		
		return($html);
	}
	
	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/