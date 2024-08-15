<?php

/******************************************************************************/
/******************************************************************************/

class CPBSBooking
{
	/**************************************************************************/
	
	function __construct()
	{
		
	}
		
	/**************************************************************************/
	
	public function init()
	{
		$this->registerCPT();
	}
	
	/**************************************************************************/

	public static function getCPTName()
	{
		return(PLUGIN_CPBS_CONTEXT.'_booking');
	}
	
	/**************************************************************************/
	
	private function registerCPT()
	{
		register_post_type
		(
			self::getCPTName(),array
			(
				'labels'=>array
				(
					'name'=>esc_html__('Bookings','car-park-booking-system'),
					'singular_name'=>esc_html__('Booking','car-park-booking-system'),
					'edit_item'=>esc_html__('Edit Booking','car-park-booking-system'),
					'all_items'=>esc_html__('Bookings','car-park-booking-system'),
					'view_item'=>esc_html__('View Booking','car-park-booking-system'),
					'search_items'=>esc_html__('Search Bookings','car-park-booking-system'),
					'not_found'=>esc_html__('No Bookings Found','car-park-booking-system'),
					'not_found_in_trash'=>esc_html__('No Bookings Found in Trash','car-park-booking-system'),
					'parent_item_colon'=>'',
					'menu_name'=>esc_html__('Car Park Booking System','car-park-booking-system')
				),
				'public'=>false,
				'menu_icon'=>'dashicons-calendar-alt',
				'show_ui'=>true,
				'capability_type'=>'post',
				'capabilities'=>array
				(
					'create_posts'=>'do_not_allow',
				),
				'map_meta_cap'=>true,
				'menu_position'=>100,
				'hierarchical'=>false,
				'rewrite'=>false,
				'supports'=>array('title')
			)
		);
		
		add_action('save_post',array($this,'savePost'));

		add_action('add_meta_boxes_'.self::getCPTName(),array($this,'addMetaBox'));
		add_filter('postbox_classes_'.self::getCPTName().'_cpbs_meta_box_booking_form',array($this,'adminCreateMetaBoxClass'));

		add_filter('manage_edit-'.self::getCPTName().'_columns',array($this,'manageEditColumns')); 
		add_action('manage_'.self::getCPTName().'_posts_custom_column',array($this,'managePostsCustomColumn'));
		add_filter('manage_edit-'.self::getCPTName().'_sortable_columns',array($this,'manageEditSortableColumns'));

		add_action('restrict_manage_posts',array($this,'restrictManagePosts'));
		add_filter('parse_query',array($this,'parseQuery'));
	}
	
	/**************************************************************************/
	
	function addMetaBox()
	{
		add_meta_box(PLUGIN_CPBS_CONTEXT.'_meta_box_booking_form',esc_html__('Main','car-park-booking-system'),array($this,'addMetaBoxMain'),self::getCPTName(),'normal','low');
		add_meta_box(PLUGIN_CPBS_CONTEXT.'_meta_box_booking_form_woocommerce',esc_html__('WooCommerce','car-park-booking-system'),array($this,'addMetaBoxWooCommerce'),self::getCPTName(),'side','low');		
	}
	
	/**************************************************************************/
	
	function addMetaBoxMain()
	{
		global $post;
				
		$data=$this->getBooking($post->ID);
			
		$data['nonce']=CPBSHelper::createNonceField(PLUGIN_CPBS_CONTEXT.'_meta_box_booking');
		
		$data['billing']=$this->createBilling($post->ID);
		
		$Template=new CPBSTemplate($data,PLUGIN_CPBS_TEMPLATE_PATH.'admin/meta_box_booking.php');
		echo $Template->output();			
	}
	
	/**************************************************************************/
	
	function addMetaBoxWooCommerce()
	{
		global $post;
		
		$booking=$this->getBooking($post->ID);
		
		if((int)$booking['meta']['woocommerce_booking_id']>0)
		{
			echo 
			'
				<div>
					<div>'.esc_html__('This booking has corresponding wooCommerce order. Click on button below to see its details in new window.','car-park-booking-system').'</div>
					<br/>
					<a class="button button-primary" href="'.esc_url(get_edit_post_link($booking['meta']['woocommerce_booking_id'])).'" target="_blank">'.esc_html__('Open booking','car-park-booking-system').'</a>
				</div>
			';
		}
		else
		{
			echo 
			'
				<div>
					<div>'.esc_html__('This booking hasn\'t corresponding wooCommerce order.','car-park-booking-system').'</div>
				</div>
			';			
		}
	}
	
	/**************************************************************************/
	
	function getBooking($bookingId)
	{
		$post=get_post($bookingId);
		if(is_null($post)) return(false);
		
		$booking=array();
		
		$Payment=new CPBSPayment();
		$Country=new CPBSCountry();
		$Location=new CPBSLocation();
		$BookingStatus=new CPBSBookingStatus();
		
		$booking['post']=$post;
		$booking['meta']=CPBSPostMeta::getPostMeta($post);		
  
		if($booking['meta']['client_billing_detail_enable']==1)
		{
			$country=$Country->getCountry($booking['meta']['client_billing_detail_country_code']);
			$booking['client_billing_detail_country_name']=$country[0];
		}
		
		if($Payment->isPayment($booking['meta']['payment_id']))
		{
			$payment=$Payment->getPayment($booking['meta']['payment_id']);
			$booking['payment_name']=$payment[0];
		}
		
		if($BookingStatus->isBookingStatus($booking['meta']['booking_status_id']))
		{
			$bookingStatus=$BookingStatus->getBookingStatus($booking['meta']['booking_status_id']);
			$booking['booking_status_name']=$bookingStatus[0];
		}
		  
		/***/
		
		$locationId=$booking['meta']['location_id'];
		if($locationId>0)
		{
			$dictionary=$Location->getDictionary();
			if((is_array($dictionary)) && (array_key_exists($locationId,$dictionary)))
			{
				$booking['booking_email_notification_extra_information']=$dictionary[$locationId]['meta']['booking_email_notification_extra_information'];
			}
		}
		
		/***/
		
		$booking['dictionary']['booking_status']=$BookingStatus->getBookingStatus();

		/***/
		
		$period=CPBSBookingHelper::calculateBookingPeriod($booking['meta']['entry_date'],$booking['meta']['entry_time'],$booking['meta']['exit_date'],$booking['meta']['exit_time'],$booking,$booking['meta']['billing_type']);
		$booking['rental_period']=CPBSBookingHelper::displayBookingPeriod($period,$booking['meta']['billing_type']);
		
		/***/
		
		return($booking);
	}
	
	/**************************************************************************/
	
	function adminCreateMetaBoxClass($class) 
	{
		array_push($class,'to-postbox-1');
		return($class);
	}
	
	/**************************************************************************/
	
	function sendBooking($data,$bookingForm)
	{	  
		$bookingId=wp_insert_post(array
		(
			'post_type'=>self::getCPTName(),
			'post_status'=>'publish'
		));
		
		if($bookingId===0) return(false);
		
		wp_update_post(array
		(
 			'ID'=>$bookingId,
			'post_title'=>$this->getBookingTitle($bookingId)
		));
		
		/***/
		
		$WPML=new CPBSWPML();
		$Date=new CPBSDate();
		$TaxRate=new CPBSTaxRate();
		$PlaceType=new CPBSPlaceType();
		$PriceRule=new CPBSPriceRule();
		$WooCommerce=new CPBSWooCommerce();
		$BookingStatus=new CPBSBookingStatus();
		$BookingFormElement=new CPBSBookingFormElement();
		
		$taxRateDictionary=$TaxRate->getDictionary();

		/***/
		
		$locationId=CPBSBookingForm::getLocationId($data,$bookingForm);
		
		/***/
		
		CPBSPostMeta::updatePostMeta($bookingId,'woocommerce_enable',$WooCommerce->isEnable($bookingForm['meta']));
		
		CPBSPostMeta::updatePostMeta($bookingId,'billing_type',CPBSOption::getOption('billing_type'));
		
		CPBSPostMeta::updatePostMeta($bookingId,'booking_status_id',$bookingForm['meta']['booking_status_id_default']);
		
		CPBSPostMeta::updatePostMeta($bookingId,'booking_form_id',$data['booking_form_id']);
		
		CPBSPostMeta::updatePostMeta($bookingId,'currency_id',CPBSCurrency::getFormCurrency());
		
		CPBSPostMeta::updatePostMeta($bookingId,'time_field_enable',$bookingForm['meta']['time_field_enable']);
		
		CPBSPostMeta::updatePostMeta($bookingId,'full_day_rounding_hour_number',$bookingForm['meta']['full_day_rounding_hour_number']);
		
		/***/
		
		CPBSPostMeta::updatePostMeta($bookingId,'entry_date',$data['entry_date']);
		CPBSPostMeta::updatePostMeta($bookingId,'entry_time',$data['entry_time']);
		CPBSPostMeta::updatePostMeta($bookingId,'exit_date',$data['exit_date']);
		CPBSPostMeta::updatePostMeta($bookingId,'exit_time',$data['exit_time']);

		CPBSPostMeta::updatePostMeta($bookingId,'entry_datetime',$data['entry_date'].' '.$data['entry_time']);
		CPBSPostMeta::updatePostMeta($bookingId,'exit_datetime',$data['exit_date'].' '.$data['exit_time']);
		
		CPBSPostMeta::updatePostMeta($bookingId,'entry_datetime_2',$Date->reverseDate($data['entry_date']).' '.$data['entry_time']);
		CPBSPostMeta::updatePostMeta($bookingId,'exit_datetime_2',$Date->reverseDate($data['exit_date']).' '.$data['exit_time']);		
		
		/***/
		
		CPBSPostMeta::updatePostMeta($bookingId,'location_id',$locationId);
		CPBSPostMeta::updatePostMeta($bookingId,'location_name',$bookingForm['dictionary']['location'][$locationId]['post']->post_title);
		
		CPBSPostMeta::updatePostMeta($bookingId,'place_type_id',$data['place_type_id']);
		CPBSPostMeta::updatePostMeta($bookingId,'place_type_name',$bookingForm['dictionary']['place_type'][$data['place_type_id']]['post']->post_title);
		
		/***/
		
		$argument=array
		(
			'booking_form_id'=>$bookingForm['post']->ID,
			'booking_form'=>$bookingForm,
			'place_type_id'=>$data['place_type_id'],
			'location_id'=>$locationId,
			'entry_date'=>$data['entry_date'],
			'entry_time'=>$data['entry_time'],
			'exit_date'=>$data['exit_date'],
			'exit_time'=>$data['exit_time'],
		);
		
		$discountPercentage=0;
		$placePriceBooking=array();
		
		$placePrice=$PlaceType->calculatePrice($argument,$discountPercentage);	
		
		foreach($PriceRule->getPriceUseType() as $index=>$value)
		{
			$placePriceBooking['price_'.$index.'_value']=CPBSPrice::formatToSave($placePrice['price']['base']['price_'.$index.'_value']);
			$placePriceBooking['price_'.$index.'_tax_rate_value']=$TaxRate->getTaxRateValue($placePrice['price']['base']['price_'.$index.'_tax_rate_id'],$taxRateDictionary);
		}
			 
		foreach($placePriceBooking as $index=>$value)
			CPBSPostMeta::updatePostMeta($bookingId,$index,$value);
		
		/***/

		if(((int)CPBSOption::getOption('booking_status_sum_zero')===1) && ($placePrice['price']['sum']['net']['value']==0.00) && ($BookingStatus->isBookingStatus(CPBSOption::getOption('booking_status_payment_success'))))
		{
			CPBSPostMeta::updatePostMeta($bookingId,'booking_status_id',CPBSOption::getOption('booking_status_payment_success'));
		}		
		
		/***/
		
		$BookingFormElement->sendBookingField($bookingId,$bookingForm['meta'],$data);
		$BookingFormElement->sendBookingAgreement($bookingId,$bookingForm['meta'],$data);
		
		/***/
		
		$BookingExtra=new CPBSBookingExtra();
		$bookingExtra=$BookingExtra->validate($data,$bookingForm,$taxRateDictionary);
		
		CPBSPostMeta::updatePostMeta($bookingId,'booking_extra',$bookingExtra);
		
		/***/
		
		$data['client_contact_detail_email_address']=trim($data['client_contact_detail_email_address']);
		
		$field=array('first_name','last_name','email_address','phone_number');
		foreach($field as $value)
			CPBSPostMeta::updatePostMeta($bookingId,'client_contact_detail_'.$value,$data['client_contact_detail_'.$value]);
		
		CPBSPostMeta::updatePostMeta($bookingId,'client_billing_detail_enable',(int)$data['client_billing_detail_enable']);   
		
		if((int)$data['client_billing_detail_enable']===1)
		{
			$field=array('company_name','tax_number','street_name','street_number','city','state','postal_code','country_code');
			foreach($field as $value)
				CPBSPostMeta::updatePostMeta($bookingId,'client_billing_detail_'.$value,$data['client_billing_detail_'.$value]);			
		}
		
		/***/
		
		CPBSPostMeta::updatePostMeta($bookingId,'comment',$data['comment']);
		
		/***/
		
		$paymentId=$data['payment_id'];
		if(!CPBSBookingHelper::isPayment($paymentId,$bookingForm['meta'],$bookingForm['dictionary']['location'][$locationId])) $paymentId=0;
		
		CPBSPostMeta::updatePostMeta($bookingId,'payment_id',$paymentId);
		CPBSPostMeta::updatePostMeta($bookingId,'payment_name',CPBSBookingHelper::getPaymentName($paymentId,-1,$bookingForm['meta']));
		
		/***/
		
		$Coupon=new CPBSCoupon();
		$code=$Coupon->checkCode();
		
		if($code===false)
		{
			CPBSPostMeta::updatePostMeta($bookingId,'coupon_code','');
			CPBSPostMeta::updatePostMeta($bookingId,'coupon_discount_percentage',0);
		}
		else
		{
			CPBSPostMeta::updatePostMeta($bookingId,'coupon_code',$code['meta']['code']);
			CPBSPostMeta::updatePostMeta($bookingId,'coupon_discount_percentage',$discountPercentage);			
		}
		
		CPBSPostMeta::updatePostMeta($bookingId,'language',$WPML->getCurrentLanguage());
		
		/***/
		
		$locationSelectedMeta=$bookingForm['dictionary']['location'][$locationId]['meta'];
		
		$recipient=array();
		$recipient[0]=array($data['client_contact_detail_email_address']);
		$recipient[1]=preg_split('/;/',$locationSelectedMeta['booking_new_recipient_email_address']);
		
		$subject=sprintf(__('New booking "%s" is received','car-park-booking-system'),$this->getBookingTitle($bookingId));
		
		global $cpbs_logEvent;

		$b=array(false,false);
		
		$b[0]=((int)$locationSelectedMeta['booking_new_customer_email_notification']===1) && (((int)$locationSelectedMeta['booking_new_customer_email_notification_payment_success']===0) || (((int)$locationSelectedMeta['booking_new_customer_email_notification_payment_success']===1) && (!in_array($paymentId,array(2,3)))));
		$b[1]=((int)$locationSelectedMeta['booking_new_admin_email_notification']===1) && (((int)$locationSelectedMeta['booking_new_admin_email_notification_payment_success']===0) || (((int)$locationSelectedMeta['booking_new_admin_email_notification_payment_success']===1) && (!in_array($paymentId,array(2,3)))));

		if($b[0])
		{	
			$cpbs_logEvent=1;
			$this->sendEmail($bookingId,$locationSelectedMeta['booking_new_sender_email_account_id'],'booking_new_client',$recipient[0],$subject);
		}
		
		if($b[1])
		{
			$cpbs_logEvent=2;
			$this->sendEmail($bookingId,$locationSelectedMeta['booking_new_sender_email_account_id'],'booking_new_admin',$recipient[1],$subject);
		}
		
		if($locationSelectedMeta['nexmo_sms_enable']==1)
		{
			$Nexmo=new CPBSNexmo();
			$Nexmo->sendSMS($locationSelectedMeta['nexmo_sms_api_key'],$locationSelectedMeta['nexmo_sms_api_key_secret'],$locationSelectedMeta['nexmo_sms_sender_name'],$locationSelectedMeta['nexmo_sms_recipient_phone_number'],$locationSelectedMeta['nexmo_sms_message']);
		}
		
		if($locationSelectedMeta['twilio_sms_enable']==1)
		{
			$Twilio=new CPBSTwilio();
			$Twilio->sendSMS($locationSelectedMeta['twilio_sms_api_sid'],$locationSelectedMeta['twilio_sms_api_token'],$locationSelectedMeta['twilio_sms_sender_phone_number'],$locationSelectedMeta['twilio_sms_recipient_phone_number'],$locationSelectedMeta['twilio_sms_message']);
		}
		
 		if($locationSelectedMeta['telegram_enable']==1)
		{
			$Telegram=new CPBSTelegram();
			$Telegram->sendMessage($locationSelectedMeta['telegram_token'],$locationSelectedMeta['telegram_group_id'],$locationSelectedMeta['telegram_message']);
		}
		
		/***/
		
		$GoogleCalendar=new CPBSGoogleCalendar();
		$GoogleCalendar->sendBooking($bookingId);

		/***/
		
		return($bookingId);
	}
	
	/**************************************************************************/
	
	function getBookingTitle($bookingId)
	{
		return(sprintf(esc_html__('Booking #%s','car-park-booking-system'),$bookingId));
	}
	
	/**************************************************************************/
	
	function setPostMetaDefault(&$meta)
	{
		CPBSHelper::setDefault($meta,'time_field_enable',1);
		
		CPBSHelper::setDefault($meta,'woocommerce_enable',0);
		CPBSHelper::setDefault($meta,'woocommerce_booking_id',0);
		
		CPBSHelper::setDefault($meta,'billing_type',2);
		CPBSHelper::setDefault($meta,'booking_status_id',1);
		
		CPBSHelper::setDefault($meta,'coupon_code','');
		CPBSHelper::setDefault($meta,'coupon_discount_percentage',0);
		
		CPBSHelper::setDefault($meta,'entry_datetime_2','0000-00-00 00:00');
		CPBSHelper::setDefault($meta,'exit_datetime_2','0000-00-00 00:00');
		
		CPBSHelper::setDefault($meta,'full_day_rounding_hour_number',0);

		$PriceRule=new CPBSPriceRule();
		
		foreach($PriceRule->getPriceUseType() as $priceUseTypeIndex=>$priceUseTypeValue)
		{
			CPBSHelper::setDefault($meta,'price_'.$priceUseTypeIndex.'_value',0);
			CPBSHelper::setDefault($meta,'price_'.$priceUseTypeIndex.'_tax_rate_value',0);			
		}
	}
	
	/**************************************************************************/
	
	function savePost($postId)
	{		
        if(!$_POST) return(false);
        
        if(CPBSHelper::checkSavePost($postId,PLUGIN_CPBS_CONTEXT.'_meta_box_booking_noncename','savePost')===false) return(false);
	
		$bookingOld=$this->getBooking($postId);
		
		$BookingStatus=new CPBSBookingStatus();
        if($BookingStatus->isBookingStatus(CPBSHelper::getPostValue('booking_status_id')))
           CPBSPostMeta::updatePostMeta($postId,'booking_status_id',CPBSHelper::getPostValue('booking_status_id')); 
          
		$bookingNew=$this->getBooking($postId);
		
		$emailSend=false;
		
		$WooCommerce=new CPBSWooCommerce();
		$WooCommerce->changeStatus(-1,$postId,$emailSend);
		
		if(!$emailSend)
			$this->sendEmailBookingChangeStatus($bookingOld,$bookingNew);
	}

	/**************************************************************************/
	
	function manageEditColumns($column)
	{
		$addColumn=array
		(
			'status'=>esc_html__('Booking status','car-park-booking-system'),
			'location'=>esc_html__('Location','car-park-booking-system'),
			'place_type'=>esc_html__('Space type','car-park-booking-system'),
			'booking_period'=>esc_html__('Booking period','car-park-booking-system'),
			'client'=>esc_html__('Client','car-park-booking-system'),
			'price'=>esc_html__('Price','car-park-booking-system'),
			'date'=>$column['date']
		);
   
		unset($column['date']);
		
		foreach($addColumn as $index=>$value)
			$column[$index]=$value;
		
		return($column);		  
	}
	
	/**************************************************************************/
	
	function managePostsCustomColumn($column)
	{
		global $post;
		
		$Date=new CPBSDate();
		$BookingStatus=new CPBSBookingStatus();
		
		$meta=CPBSPostMeta::getPostMeta($post);
		
		$billing=$this->createBilling($post->ID);
		
		switch($column) 
		{
			case 'status':
				
				$bookingStatus=$BookingStatus->getBookingStatus($meta['booking_status_id']);
				echo '<div class="to-booking-status to-booking-status-'.(int)$meta['booking_status_id'].'">'.esc_html($bookingStatus[0]).'</div>';
				
			break;
		
			case 'location':
				
				echo esc_html($meta['location_name']);
				
			break;
		
			case 'place_type':
				
				echo esc_html($meta['place_type_name']);
				
			break;
		
			case 'booking_period':
				
				echo esc_html($Date->formatDateToDisplay($meta['entry_date']).' '.$Date->formatTimeToDisplay($meta['entry_time']));
				echo ' - ';
				echo esc_html($Date->formatDateToDisplay($meta['exit_date']).' '.$Date->formatTimeToDisplay($meta['exit_time']));
				
			break;
		
			case 'client':
				
				echo esc_html($meta['client_contact_detail_first_name'].' '.$meta['client_contact_detail_last_name']);
				
			break;
   
			case 'price':
				
				echo esc_html(CPBSPrice::format($billing['summary']['value_gross'],$meta['currency_id']));
				
			break;
		}
	}
	
	/**************************************************************************/
	
	function manageEditSortableColumns($column)
	{
		return($column);	   
	}
	
	/**************************************************************************/
	
	function restrictManagePosts()
	{
 		if(!is_admin()) return;
		if(CPBSHelper::getGetValue('post_type',false)!==self::getCPTName()) return;	   
		
		$html=null;
		
		/***/
		
		$BookingStatus=new CPBSBookingStatus();
		$bookingStatusDirectory=$BookingStatus->getBookingStatus();
		
		$directory=array();
		foreach($bookingStatusDirectory as $index=>$value)
			$directory[$index]=$value[0];
		
		$directory[-2]=esc_html__('New & accepted','car-park-booking-system');
		
		asort($directory,SORT_STRING);
		
		if(!array_key_exists('booking_status_id',$_GET))
			$_GET['booking_status_id']=-2;
		
 		foreach($directory as $index=>$value)
			$html.='<option value="'.(int)$index.'" '.(((int)CPBSHelper::getGetValue('booking_status_id',false)==$index) ?  'selected' : null).'>'.esc_html($value).'</option>';
		
		$html=
		'
			<select name="booking_status_id">
				<option value="0">'.esc_html__('All statuses','car-park-booking-system').'</option>
				'.$html.'
			</select>
		';
		
		/***/
		
		echo $html;
	}
	
	/**************************************************************************/
	
	function parseQuery($query)
	{
		if(!is_admin()) return;
		if(CPBSHelper::getGetValue('post_type',false)!==self::getCPTName()) return;
		if($query->query['post_type']!==self::getCPTName()) return;	   
		
		$metaQuery=array();
		$Validation=new CPBSValidation();
		
		$bookingStatusId=CPBSHelper::getGetValue('booking_status_id',false);
		if($Validation->isEmpty($bookingStatusId)) $bookingStatusId=-2;

		if($bookingStatusId!=0)
		{
			array_push($metaQuery,array
			(
				'key'=>PLUGIN_CPBS_CONTEXT.'_booking_status_id',
				'value'=>$bookingStatusId== -2 ? array(1,2) : array($bookingStatusId),
				'compare'=>'IN'
			));
		}  
		
		$order=CPBSHelper::getGetValue('order',false);
		$orderby=CPBSHelper::getGetValue('orderby',false);
		
		if($orderby=='title')
		{
			$query->set('orderby','title');
		}
		elseif($orderby=='date')
		{
			$query->set('orderby','date');
		}
		else
		{
			switch($orderby)
			{
				default:

					$query->set('meta_key',PLUGIN_CPBS_CONTEXT.'_entry_datetime_2');
					$query->set('meta_type','DATETIME');

					if($Validation->isEmpty($order)) $order='asc';
			}

			$query->set('orderby','meta_value');
		}

		$query->set('order',$order);

		if(count($metaQuery)) $query->set('meta_query',$metaQuery);
	}
	
	/**************************************************************************/
	
	function calculatePrice($data=null,$placePrice=null,$hideFee=false)
	{		
		$TaxRate=new CPBSTaxRate();
		$BookingExtra=new CPBSBookingExtra();
		
		$taxRateDictionary=$TaxRate->getDictionary();
		
		/***/
		
		$component=array('place','initial','booking_extra','total');
		
		foreach($component as $value)
		{
			$price[$value]=array
			(
				'sum'=>array
				(
					'net'=>array
					(
						'value'=>0.00
					),
					'gross'=>array
					(
						'value'=>0.00,
						'format'=>0.00
					)
				)
			);
		}
		
		/***/
		
		if(array_key_exists($data['place_type_id'],$data['booking_form']['dictionary']['place_type']))
		{
			// argument
			$argument=array
			(
				'booking_form_id'=>$data['booking_form']['post']->ID,
				'booking_form'=>$data['booking_form'],
				'place_type_id'=>$data['place_type_id'],
				'location_id'=>$data['location_id'],
				'entry_date'=>$data['entry_date'],
				'entry_time'=>$data['entry_time'],
				'exit_date'=>$data['exit_date'],
				'exit_time'=>$data['exit_time'],
			);
		 
			if(is_null($placePrice))
			{
				$PlaceType=new CPBSPlaceType();
				
				$discountPercentage=0;
				$placePrice=$PlaceType->calculatePrice($argument,$discountPercentage,false);
			}
			
			$price['place']['sum']['gross']['value']=$placePrice['price']['sum']['gross']['value'];		
			$price['place']['sum']['gross']['format']=$placePrice['price']['sum']['gross']['format'];  
			$price['place']['sum']['net']['value']=$placePrice['price']['sum']['net']['value'];		
			$price['place']['sum']['net']['format']=$placePrice['price']['sum']['net']['format'];		   
					
			$price['initial']['sum']['gross']['value']=$placePrice['price']['initial']['gross']['value']; 
			$price['initial']['sum']['gross']['format']=$placePrice['price']['initial']['gross']['format'];		  
			$price['initial']['sum']['net']['value']=$placePrice['price']['initial']['net']['value']; 
			$price['initial']['sum']['net']['format']=$placePrice['price']['initial']['net']['format'];   
			
			if($hideFee)
			{
				$price['place']['sum']['gross']['value']+=$price['initial']['sum']['gross']['value'];
				$price['place']['sum']['gross']['format']=CPBSPrice::format($price['place']['sum']['gross']['value'],CPBSCurrency::getFormCurrency());
				
				$price['place']['sum']['net']['value']+=$price['initial']['sum']['net']['value'];
				$price['place']['sum']['net']['format']=CPBSPrice::format($price['place']['sum']['net']['value'],CPBSCurrency::getFormCurrency());
			}
		}
		
		/***/

		$bookingExtra=$BookingExtra->validate($data,$data['booking_form'],$taxRateDictionary); 
		
		foreach($bookingExtra as $value)
		{
			$price['booking_extra']['sum']['gross']['value']+=$value['sum_gross'];
			$price['booking_extra']['sum']['net']['value']+=$value['sum_net'];
		}
		
		$price['booking_extra']['sum']['gross']['format']=CPBSPrice::format($price['booking_extra']['sum']['gross']['value'],CPBSCurrency::getFormCurrency());
		$price['booking_extra']['sum']['net']['format']=CPBSPrice::format($price['booking_extra']['sum']['net']['value'],CPBSCurrency::getFormCurrency());
		
		/***/
	  
		if($hideFee)
		{
			$price['total']['sum']['gross']['value']=$price['place']['sum']['gross']['value']+$price['booking_extra']['sum']['gross']['value'];
			$price['total']['sum']['net']['value']=$price['place']['sum']['net']['value']+$price['booking_extra']['sum']['net']['value'];
		}
		else 
		{
			$price['total']['sum']['gross']['value']=$price['place']['sum']['gross']['value']+$price['initial']['sum']['gross']['value']+$price['booking_extra']['sum']['gross']['value'];
			$price['total']['sum']['net']['value']=$price['place']['sum']['net']['value']+$price['initial']['sum']['net']['value']+$price['booking_extra']['sum']['net']['value'];
		}
			
		$price['total']['tax']['value']=$price['total']['sum']['gross']['value']-$price['total']['sum']['net']['value'];
		$price['total']['tax']['format']=CPBSPrice::format($price['total']['tax']['value'],CPBSCurrency::getFormCurrency());
		
		$price['total']['sum']['gross']['format']=CPBSPrice::format($price['total']['sum']['gross']['value'],CPBSCurrency::getFormCurrency());
		$price['total']['sum']['net']['format']=CPBSPrice::format($price['total']['sum']['net']['value'],CPBSCurrency::getFormCurrency());

		return($price);
	}
		
	/**************************************************************************/
	
	function createResponse($response)
	{
		echo json_encode($response);
		exit;			 
	}
	
	/**************************************************************************/
	
	function createBilling($bookingId)
	{
		$billing=array();
		$billing['detail']=array();
		
		if(($booking=$this->getBooking($bookingId))===false) return($billing);

		/***/

		$period=CPBSBookingHelper::calculateBookingPeriod($booking['meta']['entry_date'],$booking['meta']['entry_time'],$booking['meta']['exit_date'],$booking['meta']['exit_time'],$booking,$booking['meta']['billing_type']);
		
		if($booking['meta']['price_initial_value']>0)
		{
			$billing['detail'][]=array
			(
				'type'=>'initial',
				'name'=>esc_html__('Initial fee','car-park-booking-system'),
				'unit'=>esc_html__('Item','car-park-booking-system'),
				'quantity'=>1,
				'price_net'=>$booking['meta']['price_initial_value'],
				'value_net'=>$booking['meta']['price_initial_value'],
				'tax_value'=>$booking['meta']['price_initial_tax_rate_value'],
				'value_gross'=>CPBSPrice::calculateGross($booking['meta']['price_initial_value'],0,$booking['meta']['price_initial_tax_rate_value'])
			);
		}  
		
		if(in_array($booking['meta']['billing_type'],array(1,4)))
		{	  
			$valueNet=$booking['meta']['price_rental_minute_value']*$period['minute'];
			if($valueNet>0.00)
			{
				$billing['detail'][]=array
				(
					'type'=>'rental_per_minute',
					'name'=>esc_html__('Rental fee per minute','car-park-booking-system'),
					'unit'=>esc_html__('No. of minutes','car-park-booking-system'),
					'quantity'=>$period['minute'],
					'price_net'=>$booking['meta']['price_rental_minute_value'],
					'value_net'=>$valueNet,
					'tax_value'=>$booking['meta']['price_rental_minute_tax_rate_value'],
					'value_gross'=>CPBSPrice::calculateGross($valueNet,0,$booking['meta']['price_rental_minute_tax_rate_value'])
				);
			}			
		} 
		
		if(in_array($booking['meta']['billing_type'],array(2,4,5,7)))
		{	  
			$valueNet=$booking['meta']['price_rental_hour_value']*$period['hour'];
			if($valueNet>0.00)
			{
				$billing['detail'][]=array
				(
					'type'=>'rental_per_hour',
					'name'=>esc_html__('Rental fee per hour','car-park-booking-system'),
					'unit'=>esc_html__('No. of hours','car-park-booking-system'),
					'quantity'=>$period['hour'],
					'price_net'=>$booking['meta']['price_rental_hour_value'],
					'value_net'=>$valueNet,
					'tax_value'=>$booking['meta']['price_rental_hour_tax_rate_value'],
					'value_gross'=>CPBSPrice::calculateGross($valueNet,0,$booking['meta']['price_rental_hour_tax_rate_value'])
				);
			}			
		} 		
		
		if(in_array($booking['meta']['billing_type'],array(3,5,6,7)))
		{	  
			$valueNet=$booking['meta']['price_rental_day_value']*$period['day'];
			
			if($valueNet>0.00)
			{
				$billing['detail'][]=array
				(
					'type'=>'rental_per_day',
					'name'=>esc_html__('Rental fee per day','car-park-booking-system'),
					'unit'=>esc_html__('No. of days','car-park-booking-system'),
					'quantity'=>$period['day'],
					'price_net'=>$booking['meta']['price_rental_day_value'],
					'value_net'=>$valueNet,
					'tax_value'=>$booking['meta']['price_rental_day_tax_rate_value'],
					'value_gross'=>CPBSPrice::calculateGross($valueNet,0,$booking['meta']['price_rental_day_tax_rate_value'])
				);
			}			
		} 
		
		/***/
		
		if(is_array($booking['meta']['booking_extra']))
		{
			foreach($booking['meta']['booking_extra'] as $value)
			{
				$priceNet=$value['price'];
				$quantity=$value['quantity'];
				
				if($value['price_type']==3)
					$priceNet*=$period['day'];
						
				$valueNet=$priceNet*$quantity;

				$billing['detail'][]=array
				(
					'type'=>'booking_extra',
					'id'=>$value['id'],
					'name'=>$value['name'],
					'unit'=>esc_html__('Item','car-park-booking-system'),
					'quantity'=>$quantity,
					'price_net'=>$priceNet,
					'value_net'=>$valueNet,
					'tax_value'=>$value['tax_rate_value'],
					'value_gross'=>CPBSPrice::calculateGross($valueNet,0,$value['tax_rate_value'])
				);				   
			}
		}
		
		/***/
		
		$billing['summary']['duration']=0;
		$billing['summary']['distance']=0;
		$billing['summary']['value_net']=0;
		$billing['summary']['value_gross']=0;
		
		foreach((array)$billing['detail'] as $value)
		{
			$billing['summary']['value_net']+=$value['value_net'];
			$billing['summary']['value_gross']+=$value['value_gross'];
		}

		foreach($billing['summary'] as $aIndex=>$aValue)
		{
			if(in_array($aIndex,array('value_net','value_gross')))
				$billing['summary'][$aIndex]=number_format(round($aValue,2),2,'.','');
		}	  
		
		/***/
				
		foreach($billing['detail'] as $aIndex=>$aValue)
		{
			foreach($aValue as $bIndex=>$bValue)
			{
				if(in_array($bIndex,array('price_net','value_net','value_gross','tax_value')))
					$billing['detail'][$aIndex][$bIndex]=number_format(round($bValue,2),2,'.','');
			}
		}

		/***/
		
		return($billing);
	}
	
	/**************************************************************************/
	
	function sendEmail($bookingId,$emailAccountId,$template,$recipient,$subject)
	{
		$Email=new CPBSEmail();
		$EmailAccount=new CPBSEmailAccount();
		
		if(($booking=$this->getBooking($bookingId))===false) return(false);
		
		if(($emailAccount=$EmailAccount->getDictionary(array('email_account_id'=>$emailAccountId)))===false) return(false);
		
		if(!isset($emailAccount[$emailAccountId])) return(false);
		
		$data=array();
		
		$emailAccount=$emailAccount[$emailAccountId];
		
		/***/
		
		global $cpbs_phpmailer;
		
		$cpbs_phpmailer['sender_name']=$emailAccount['meta']['sender_name'];
		$cpbs_phpmailer['sender_email_address']=$emailAccount['meta']['sender_email_address'];
		
		$cpbs_phpmailer['smtp_auth_enable']=$emailAccount['meta']['smtp_auth_enable'];
		$cpbs_phpmailer['smtp_auth_debug_enable']=$emailAccount['meta']['smtp_auth_debug_enable'];
		
		$cpbs_phpmailer['smtp_auth_username']=$emailAccount['meta']['smtp_auth_username'];
		$cpbs_phpmailer['smtp_auth_password']=$emailAccount['meta']['smtp_auth_password'];
		
		$cpbs_phpmailer['smtp_auth_host']=$emailAccount['meta']['smtp_auth_host'];
		$cpbs_phpmailer['smtp_auth_port']=$emailAccount['meta']['smtp_auth_port'];
		
		$cpbs_phpmailer['smtp_auth_secure_connection_type']=$emailAccount['meta']['smtp_auth_secure_connection_type'];
		
		/***/
		
		if(in_array($template,array('booking_new_admin','booking_new_client','booking_change_status')))
		{
			$templateFile='email_booking.php';
			
			$booking['booking_title']=$booking['post']->post_title;
			if($template==='booking_new_admin')
				$booking['booking_title']='<a href="'.esc_url(get_edit_post_link($booking['post']->ID)).'">'.esc_html($booking['booking_title']).'</a>';		
		}
		
		/***/
		
		$data['style']=$Email->getEmailStyle();
		
		$data['booking']=$booking;
		$data['booking']['billing']=$this->createBilling($bookingId);
		
		/***/

		$Template=new CPBSTemplate($data,PLUGIN_CPBS_TEMPLATE_PATH.$templateFile);
		$body=$Template->output();
		
		/***/
		
		$Email->send($recipient,$subject,$body);
	}
	
	/**************************************************************************/
	
	/**************************************************************************/
	
	function sendEmailBookingChangeStatus($bookingOld,$bookingNew)
	{
		if($bookingOld['meta']['booking_status_id']==$bookingNew['meta']['booking_status_id']) return;
		
		$BookingStatus=new CPBSBookingStatus();
        $bookingStatus=$BookingStatus->getBookingStatus($bookingNew['meta']['booking_status_id']);
		
            
        $recipient=array();
        $recipient[0]=array($bookingNew['meta']['client_contact_detail_email_address']);
		$recipient[1]=array("tpkc@trueparkings.com");
		$recipient[2]=array("npatel@trueparkings.com");
		// Line Above is needed.
       
        $subject=sprintf(__('Booking "%s" has changed status to "%s"','car-park-booking-system'),$bookingNew['post']->post_title,$bookingStatus[0]);
        
		global $cpbs_logEvent;
        
		$cpbs_logEvent=3;
        $this->sendEmail($bookingNew['post']->ID,CPBSOption::getOption('sender_default_email_account_id'),'booking_change_status',$recipient[0],$subject);
		$this->sendEmail($bookingNew['post']->ID,CPBSOption::getOption('sender_default_email_account_id'),'booking_change_status',$recipient[1],$subject);
		$this->sendEmail($bookingNew['post']->ID,CPBSOption::getOption('sender_default_email_account_id'),'booking_change_status',$recipient[2],$subject);

		//Line above is needed.
	}
	
	/**************************************************************************/
	
	function getCouponCodeUsageCount($couponCode)
	{
		$argument=array
		(
			'post_type'=>self::getCPTName(),
			'post_status'=>'publish',
			'posts_per_page'=>-1,
			'meta_key'=>PLUGIN_CPBS_CONTEXT.'_coupon_code',
			'meta_value'=>$couponCode,
			'meta_compare'=>'='
		);
		
		$query=new WP_Query($argument);
		if($query===false) return(false); 
		
		return($query->found_posts);
	}
	
	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/