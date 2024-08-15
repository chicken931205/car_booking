<?php

/******************************************************************************/
/******************************************************************************/

class CPBSPlugin
{
	/**************************************************************************/
	
	private $optionDefault;
	private $libraryDefault;

	/**************************************************************************/	
	
	function __construct()
	{
		/***/
		
		$this->libraryDefault=array
		(
			'script'=>array
			(
				'use'=>1,
				'inc'=>true,
				'path'=>PLUGIN_CPBS_SCRIPT_URL,
				'file'=>'',
				'in_footer'=>true,
				'dependencies'=>array('jquery'),
			),
			'style'=>array
			(
				'use'=>1,
				'inc'=>true,
				'path'=>PLUGIN_CPBS_STYLE_URL,
				'file'=>'',
				'dependencies'=>array()
			)
		);
		
		/***/
		
		$this->optionDefault=array
		(
			'billing_type'=>3,
			'logo'=>'',
			'google_map_api_key'=>'',
			'google_map_duplicate_script_remove'=>'0',
			'currency'=>'USD',
			'length_unit'=>'1',
			'date_format'=>'d-m-Y',
			'time_format'=>'G:i',
			'sender_default_email_account_id'=>'-1',
			'coupon_generate_count'=>'1',
			'coupon_generate_usage_limit'=>'1',
			'coupon_generate_discount_percentage'=>'0',
			'coupon_generate_discount_fixed'=>'0',
			'coupon_generate_active_date_start'=>'',
			'coupon_generate_active_date_stop'=>'',
			'attachment_woocommerce_email'=>'',
			'geolocation_server_id'=>'1',
			'geolocation_server_id_3_api_key'=>'',
			'email_report_status'=>'0',
			'email_report_sender_email_account_id'=>'-1',
			'email_report_recipient_email_address'=>'',
			'email_report_date_range'=>0,
			'currency_exchange_rate'=>array(),
			'fixer_io_api_key'=>'',
			'booking_status_payment_success'=>'-1',
			'booking_status_synchronization'=>'1',
			'payment_stripe_webhook_endpoint_id'=>'',
			'run_code'=>CPBSHelper::createRandomString(),
			'security_code_1'=>CPBSHelper::createRandomString(),
			'booking_status_nonblocking'=>array(3,6),
			'booking_status_sum_zero'=>'0'
		);
		
		/***/
	}
	
	/**************************************************************************/
	
	private function prepareLibrary()
	{
		$this->library=array
		(
			'script' => array
			(
				'jquery-ui-core'=>array
				(
					'path'=>''
				),
				'jquery-ui-tabs'=>array
				(
					'use'=>3,
					'path'=>''
				),
				'jquery-ui-button'=>array
				(
					'path'=>''
				),
				'jquery-ui-slider'=>array
				(
					'path'=>''
				),
				'jquery-ui-selectmenu'=>array
				(
					'use'=>2,
					'path'=>''
				),
				'jquery-ui-sortable'=>array
				(
					'path'=>''
				),
				'jquery-ui-widget'=>array
				(
					'use'=>2,
					'path'=>''
				),
				'jquery-ui-datepicker'=>array
				(
					'use'=>3,
					'path'=>''
				),
				'jquery-colorpicker'=>array
				(
					'file'=>'jquery.colorpicker.js'
				),
				'jquery-actual'=>array
				(
					'use'=>2,
					'file'=>'jquery.actual.min.js'
				),
				'jquery-timepicker'=>array
				(
					'use'=>3,
					'file'=>'jquery.timepicker.min.js'
				),
				'jquery-dropkick'=>array
				(
					'file'=>'jquery.dropkick.min.js'
				),
				'jquery-qtip'=>array
				(
					'use'=>3,
					'file'=>'jquery.qtip.min.js'
				),
				'jquery-blockUI'=>array
				(
					'file'=>'jquery.blockUI.js'
				),
				'resizesensor'=>array
				(
					'use'=>2,
					'file'=>'ResizeSensor.min.js'
				),				
				'jquery-theia-sticky-sidebar'=>array
				(
					'use'=>2,
					'file'=>'jquery.theia-sticky-sidebar.min.js'
				),
				'jquery-table'=>array
				(
					'file'=>'jquery.table.js'
				),
				'jquery-infieldlabel'=>array
				(
					'file'=>'jquery.infieldlabel.min.js'
				),
				'jquery-scrollTo'=>array
				(
					'use'=>3,
					'file'=>'jquery.scrollTo.min.js'
				),
				'jquery-slick'=>array
				(
					'use'=>3,
					'file'=>'slick.js'
				),
				'clipboard'=>array
				(
					'file'=>'clipboard.min.js'
				),
				'jquery-themeOption'=>array
				(
					'file'=>'jquery.themeOption.js'
				),
				'jquery-themeOptionElement'=>array
				(
					'file'=>'jquery.themeOptionElement.js'
				),
				'cpbs-helper'=>array
				(
					'use'=>3,
					'file'=>'CPBSHelper.js'
				),
				'cpbs-booking-calendar'=>array
				(
					'use'=>1,
					'file'=>'CPBSBookingCalendar.js'
				),
				'cpbs-admin'=>array
				(
					'file'=>'admin.js'
				),
				'cpbs-booking-form'=>array
				(
					'use'=>2,
					'file'=>'jquery.CPBSBookingForm.js'
				),
				'google-map'=>array
				(
					'use'=>3,
					'path'=>'',
					'in_footer'=>false,
					'file'=>add_query_arg(array('key'=>urlencode(CPBSOption::getOption('google_map_api_key')),'callback'=>'Function.prototype','libraries'=>'places,drawing'),'//maps.google.com/maps/api/js'),
				),
			),
			'style'=>array
			(
				'google-font-source-sans-pro'=>array
				(
					'use'=>2,
					'path'=>'',
					'file'=>add_query_arg(array('family'=>urlencode('Source Sans Pro:ital,wght@0,200;0,300;0,400;0,600;0,700;0,900;1,200;1,300;1,400;1,600;1,700;1,900'),'subset'=>'cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese'),'//fonts.googleapis.com/css')
				),
				'google-font-lato'=>array
				(
					'use'=>2,
					'path'=>'',
					'file'=>add_query_arg(array('family'=>urlencode('Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900'),'subset'=>'latin-ext'),'//fonts.googleapis.com/css')
				),
				'jquery-ui'=>array
				(
					'use'=>3,
					'file'=>'jquery.ui.min.css',
				),
				'jquery-qtip'=>array
				(
					'use'=>3,
					'file'=>'jquery.qtip.min.css',
				),
				'jquery-dropkick'=>array
				(
					'file'=>'jquery.dropkick.css',
				),
				'jquery-dropkick-rtl'=>array
				(
					'inc'=>false,
					'file'=>'jquery.dropkick.rtl.css',
				),
				'jquery-colorpicker'=>array
				(
					'file'=>'jquery.colorpicker.css',
				),
				'jquery-timepicker'=>array
				(
					'use'=>3,
					'file'=>'jquery.timepicker.min.css',
				),
				'jquery-slick'=>array
				(
					'use'=>3,
					'file'=>'slick.css'
				),
				'jquery-themeOption'=>array
				(
					'file'=>'jquery.themeOption.css'
				),
				'jquery-themeOption-rtl'=>array
				(
					'inc'=>false,
					'file'=>'jquery.themeOption.rtl.css',
				),
				'cpbs-jquery-themeOption-overwrite'=>array
				(
					'file'=>'jquery.themeOption.overwrite.css'
				),
				'cpbs-public'=>array
				(
					'use'=>2,
					'file'=>'public.css'
				),
				'cpbs-public-rtl'=>array
				(
					'use'=>2,
					'inc'=>false,
					'file'=>'public.rtl.css'
				),
				'cpbs-public-booking-form'=>array
				(
					'use'=>2,
					'path'=>'',
					'file'=>CPBSFile::getMultisiteBlogCSS('url')
				)
			)
		);		
	}	
	
	/**************************************************************************/
	
	private function addLibrary($type,$use)
	{
		$Validation=new CPBSValidation();
		
		if($type==='style')
		{
			if(!CPBSFile::fileExist(CPBSFile::getMultisiteBlogCSS()))
				$this->library['style']['cpbs-public-booking-form']['inc']=0;
		}
		
		if($type==='script')
		{
			if($Validation->isEmpty(CPBSOption::getOption('google_map_api_key')))
				$this->library['script']['google-map']['inc']=0;
		}
		
		foreach($this->library[$type] as $index=>$value)
			$this->library[$type][$index]=array_merge($this->libraryDefault[$type],$value);
		
		foreach($this->library[$type] as $index=>$data)
		{
			if(!$data['inc']) continue;
			
			if($data['use']!=3)
			{
				if($data['use']!=$use) continue;
			}			
			
			if($type=='script')
			{
				wp_enqueue_script($index,$data['path'].$data['file'],$data['dependencies'],null,$data['in_footer']);
			}
			else 
			{
				wp_enqueue_style($index,$data['path'].$data['file'],$data['dependencies'],null);
			}
		}
	}
	
	/**************************************************************************/
	
	public function pluginActivation()
	{	
		CPBSOption::createOption();
		
		$optionSave=array();
		$optionCurrent=CPBSOption::getOptionObject();
			 
		foreach($this->optionDefault as $index=>$value)
		{
			if(!array_key_exists($index,$optionCurrent))
				$optionSave[$index]=$value;
		}
		
		$optionSave=array_merge((array)$optionSave,$optionCurrent);
		foreach($optionSave as $index=>$value)
		{
			if(!array_key_exists($index,$this->optionDefault))
				unset($optionSave[$index]);
		}
		
		CPBSOption::resetOption();
		CPBSOption::updateOption($optionSave);
		
		/****/
		
		$Location=new CPBSLocation();
		$dictionary=$Location->getDictionary();
		
		foreach($dictionary as $dictionaryIndex=>$dictionaryValue)
		{
			$businessHour=$dictionaryValue['meta']['business_hour'];
			
			if((is_array($businessHour[1])) && (array_key_exists('start',$businessHour[1])))
			{
				$t=array();
				
				foreach($businessHour as $index=>$value)
				{
					$t[]=array('period_type'=>1,'day_number'=>$index,'date'=>'','time_start'=>$value['start'],'time_stop'=>$value['stop']);
				}
				
				CPBSPostMeta::updatePostMeta($dictionaryIndex,'business_hour',$t);
			}
		}
		
		/***/
		
		$Date=new CPBSDate();
		
		$argument=array
		(
			'post_type'=>CPBSBooking::getCPTName(),
			'post_status'=>'any',
			'posts_per_page'=>-1
		);
		
		$query=new WP_Query($argument);
		if($query!==false)
		{
			while($query->have_posts())
			{
				$query->the_post();
				
				$meta=CPBSPostMeta::getPostMeta(get_the_ID());
				
				$b=array(false,false);
				
				$b[0]=(!array_key_exists('entry_datetime_2',$meta)) || (!array_key_exists('exit_datetime_2',$meta));
				$b[1]=($meta['entry_datetime_2']=='0000-00-00 00:00') || ($meta['exit_datetime_2']=='0000-00-00 00:00');
				
				if(in_array(true,$b,true))
				{
					CPBSPostMeta::updatePostMeta(get_the_ID(),'entry_datetime_2',$Date->reverseDate($meta['entry_date']).' '.$meta['entry_time']);
					CPBSPostMeta::updatePostMeta(get_the_ID(),'exit_datetime_2',$Date->reverseDate($meta['exit_date']).' '.$meta['exit_time']);
				}
			}
		}
		
		/***/
		
		$BookingFormStyle=new CPBSBookingFormStyle();
		$BookingFormStyle->createCSSFile();
	}
	
	/**************************************************************************/
	
	public function pluginDeactivation()
	{

	}
	
	/**************************************************************************/
	
	public function init()
	{  
		$Booking=new CPBSBooking();
		$BookingForm=new CPBSBookingForm();
		$BookingExtra=new CPBSBookingExtra();
		$BookingCalendar=new CPBSBookingCalendar();

		$PriceRule=new CPBSPriceRule();
		
		$Location=new CPBSLocation();
		$PlaceType=new CPBSPlaceType();
		
		$Coupon=new CPBSCoupon();
		
		$TaxRate=new CPBSTaxRate();
		$EmailAccount=new CPBSEmailAccount();
		
		$LogManager=new CPBSLogManager();
		$ExchangeRateProvider=new CPBSExchangeRateProvider();
		
		$PaymentStripe=new CPBSPaymentStripe();
		
		$BookingSummary=new CPBSBookingSummary();
		
		$WPML=new CPBSWPML();
		
		$User=new CPBSUser();
		
		$Booking->init();
		$BookingForm->init();
		$BookingExtra->init();
		
		$PriceRule->init();
		
		$Location->init();
		$PlaceType->init();
		
		$Coupon->init();
		
		$TaxRate->init();
		$EmailAccount->init();
		
		$WPML->init();
		
		$User->init();
			
		add_filter('submenu_file',array($this,'submenuFile'));
		add_filter('custom_menu_order',array($this,'adminCustomMenuOrder'));
				
		add_action('admin_init',array($this,'adminInit'));
		add_action('admin_menu',array($this,'adminMenu'));
		
		add_action('wp_ajax_'.PLUGIN_CPBS_CONTEXT.'_option_page_save',array($this,'adminOptionPanelSave'));
		
		add_action('wp_ajax_'.PLUGIN_CPBS_CONTEXT.'_go_to_step',array($BookingForm,'goToStep'));
		add_action('wp_ajax_nopriv_'.PLUGIN_CPBS_CONTEXT.'_go_to_step',array($BookingForm,'goToStep'));
		
		add_action('wp_ajax_'.PLUGIN_CPBS_CONTEXT.'_coupon_code_check',array($BookingForm,'checkCouponCode'));
		add_action('wp_ajax_nopriv_'.PLUGIN_CPBS_CONTEXT.'_coupon_code_check',array($BookingForm,'checkCouponCode'));  
		
		add_action('wp_ajax_'.PLUGIN_CPBS_CONTEXT.'_option_page_import_demo',array($this,'importDemo'));
		
		add_action('wp_ajax_'.PLUGIN_CPBS_CONTEXT.'_create_summary_price_element',array($BookingForm,'createSummaryPriceElementAjax'));
		add_action('wp_ajax_nopriv_'.PLUGIN_CPBS_CONTEXT.'_create_summary_price_element',array($BookingForm,'createSummaryPriceElementAjax'));
		
		add_action('wp_ajax_'.PLUGIN_CPBS_CONTEXT.'_option_page_create_coupon_code',array($Coupon,'create'));
		
		add_action('wp_ajax_'.PLUGIN_CPBS_CONTEXT.'_user_sign_in',array($BookingForm,'userSignIn'));
		add_action('wp_ajax_nopriv_'.PLUGIN_CPBS_CONTEXT.'_user_sign_in',array($BookingForm,'userSignIn'));  
		
		add_action('wp_ajax_'.PLUGIN_CPBS_CONTEXT.'_option_page_import_exchange_rate',array($ExchangeRateProvider,'importExchangeRate'));
		
		add_action('wp_ajax_'.PLUGIN_CPBS_CONTEXT.'_test_email_send',array($EmailAccount,'sendTestEmail'));
		
		add_action('wp_ajax_'.PLUGIN_CPBS_CONTEXT.'_booking_calendar_ajax',array($BookingCalendar,'ajax'));
		
		add_action('admin_notices',array($this,'adminNotice'));
		
		add_action('wp_mail_failed',array($LogManager,'logWPMailError'));
		
		add_action('template_redirect',array($BookingSummary,'createBookingSummaryDocument'));
		
		add_shortcode(PLUGIN_CPBS_CONTEXT.'_booking_summary',array($BookingSummary,'createBookingSummaryPage'));
		
		if((int)CPBSOption::getOption('google_map_duplicate_script_remove')===1)
			add_action('wp_print_scripts',array($this,'removeMultipleGoogleMap'),100);		
		
		add_theme_support('post-thumbnails');
		
		add_image_size(PLUGIN_CPBS_CONTEXT.'_place_type',460,306); 
		
		if(!is_admin())
		{
			add_action('wp_enqueue_scripts',array($this,'publicInit'));
			add_action('wp_loaded',array($PaymentStripe,'receivePayment'));
		}
		
		add_action('show_user_profile',array($User,'editUserField'));
		add_action('edit_user_profile',array($User,'editUserField'));
		
		add_action('personal_options_update',array($User,'saveUserField'));
		add_action('edit_user_profile_update',array($User,'saveUserField'));		
		
		
		$WooCommerce=new CPBSWooCommerce();
		$WooCommerce->addAction();
	}
	
	/**************************************************************************/
	

	public function publicInit()
	{
		$this->prepareLibrary();
		
		if(is_rtl())
			$this->library['style']['cpbs-public-rtl']['inc']=true;
		
		$this->addLibrary('style',2);
		$this->addLibrary('script',2);
	}
	
	/**************************************************************************/
	
	public function adminInit()
	{
		$this->prepareLibrary();
		
		if(is_rtl())
		{
			$this->library['style']['jquery-themeOption-rtl']['inc']=true;
			$this->library['style']['jquery-dropkick-rtl']['inc']=true;
		}
		
		$this->addLibrary('style',1);
		$this->addLibrary('script',1);
		
		$data=array();
		
		$data['jqueryui_buttonset_enable']=(int)PLUGIN_CPBS_JQUERYUI_BUTTONSET_ENABLE;
		
		wp_localize_script('jquery-themeOption','cpbsData',array('l10n_print_after'=>'cpbsData='.json_encode($data).';'));
	}
	
	/**************************************************************************/
	
	public function adminMenu()
	{
		add_options_page(esc_html__('Car Park Booking System','car-park-booking-system'),esc_html__('Car Park Booking System','car-park-booking-system'),'edit_theme_options',PLUGIN_CPBS_CONTEXT,array($this,'adminCreateOptionPage'));
		add_submenu_page('edit.php?post_type='.CPBSBooking::getCPTName(),esc_html__('Bookings Calendar','car-park-booking-system'),esc_html__('Calendar','car-park-booking-system'),'edit_theme_options',PLUGIN_CPBS_CONTEXT.'_booking_calendar', array($this,'adminCreateBookingCalendarPage'));

		$taxonomy=get_taxonomy(CPBSUser::getPTCategoryName());
		add_users_page
		(
			esc_attr($taxonomy->labels->menu_name),
			esc_attr($taxonomy->labels->menu_name),
			$taxonomy->cap->manage_terms,
			'edit-tags.php?taxonomy='.$taxonomy->name
		);
	}
	
	/**************************************************************************/
	
	public function adminCreateBookingCalendarPage()
	{
		$data=array();
		
		$BookingCalendar=new CPBSBookingCalendar();
		
		$date=$BookingCalendar->getDate();
		
		$data['header_date']=$BookingCalendar->createHeaderDate($date['booking_calendar_year_number'],$date['booking_calendar_month_name']);
		$data['header_location']=$BookingCalendar->createHeaderLocation();
		
		$data['calendar']=$BookingCalendar->createBookingCalendar($date['booking_calendar_year_number'],$date['booking_calendar_month_number']);
		
		$data['booking_calendar_year_number']=$date['booking_calendar_year_number'];
		$data['booking_calendar_month_number']=$date['booking_calendar_month_number'];
		
		$Template=new CPBSTemplate($data,PLUGIN_CPBS_TEMPLATE_PATH.'admin/booking_calendar.php');
		echo $Template->output();			
	}
	
	/**************************************************************************/
	
	public function adminCreateOptionPage()
	{
		$data=array();
		
		$Currency=new CPBSCurrency();
		$LengthUnit=new CPBSLengthUnit();
		$GeoLocation=new CPBSGeoLocation();
		$BillingType=new CPBSBillingType();
		$EmailAccount=new CPBSEmailAccount();
		$BookingStatus=new CPBSBookingStatus();
		$ExchangeRateProvider=new CPBSExchangeRateProvider();
		
		$data['option']=CPBSOption::getOptionObject();
		
		$data['dictionary']['currency']=$Currency->getCurrency();
		$data['dictionary']['length_unit']=$LengthUnit->getLengthUnit();
		
		$data['dictionary']['billing_type']=$BillingType->getDictionary();
		$data['dictionary']['email_account']=$EmailAccount->getDictionary();
		
		$data['dictionary']['geolocation_server']=$GeoLocation->getServer();
		
		$data['dictionary']['exchange_rate_provider']=$ExchangeRateProvider->getProvider();
		
		$data['dictionary']['booking_status']=$BookingStatus->getBookingStatus();
        $data['dictionary']['booking_status_synchronization']=$BookingStatus->getBookingStatusSynchronization();		
		
		wp_enqueue_media();
		
		$Template=new CPBSTemplate($data,PLUGIN_CPBS_TEMPLATE_PATH.'admin/option.php');
		echo $Template->output();	
	}
	
	/**************************************************************************/
	
	public function adminOptionPanelSave()
	{		
		$option=CPBSHelper::getPostOption();

		$response=array('global'=>array('error'=>1));

		$Notice=new CPBSNotice();
		$Currency=new CPBSCurrency();
		$LengthUnit=new CPBSLengthUnit();
		$Validation=new CPBSValidation();
		$BillingType=new CPBSBillingType();
		$BookingStatus=new CPBSBookingStatus();
		
		$invalidValue=esc_html__('This field includes invalid value.','car-park-booking-system');
		
		/* General */
		if(!$BillingType->isBillingType($option['billing_type']))
			$Notice->addError(CPBSHelper::getFormName('billing_type',false),$invalidValue);	
		if(!$Validation->isBool($option['google_map_duplicate_script_remove']))
			$Notice->addError(CPBSHelper::getFormName('google_map_duplicate_script_remove',false),$invalidValue);	
		if(!$Currency->isCurrency($option['currency']))
			$Notice->addError(CPBSHelper::getFormName('currency',false),$invalidValue);	
		if(!$LengthUnit->isLengthUnit($option['length_unit']))
			$Notice->addError(CPBSHelper::getFormName('length_unit',false),$invalidValue);
		if($Validation->isEmpty($option['date_format']))
			$Notice->addError(CPBSHelper::getFormName('date_format',false),$invalidValue);
		if($Validation->isEmpty($option['time_format']))
			$Notice->addError(CPBSHelper::getFormName('time_format',false),$invalidValue);		
		if(!$Validation->isBool($option['email_report_status']))
			$Notice->addError(CPBSHelper::getFormName('email_report_status',false),$invalidValue);
		if(!in_array($option['email_report_date_range'],array(0,1)))
			$Notice->addError(CPBSHelper::getFormName('email_report_date_range',false),$invalidValue);
		
		if(is_array($option['booking_status_nonblocking']))
		{
			foreach($option['booking_status_nonblocking'] as $value)
			{
				if(!$BookingStatus->isBookingStatus($value))
				{
					$Notice->addError(CPBSHelper::getFormName('booking_status_nonblocking',false),$invalidValue);	
					break;
				}
			}
		}
		else $option['booking_status_nonblocking']=array();
		
		/* Payment */
		if((int)$option['booking_status_payment_success']!==-1)
		{
			if(!$BookingStatus->isBookingStatus($option['booking_status_payment_success']))
				$Notice->addError(CPBSHelper::getFormName('booking_status_payment_success',false),$invalidValue);	
		}
		if(!$Validation->isBool($option['booking_status_sum_zero']))
			$Notice->addError(CPBSHelper::getFormName('booking_status_sum_zero',false),$invalidValue);		
		if(!$BookingStatus->isBookingStatusSynchronization($option['booking_status_synchronization']))
            $Notice->addError(CPBSHelper::getFormName('booking_status_synchronization',false),$invalidValue);	
		
		/* Currency */
		foreach($option['currency_exchange_rate'] as $index=>$value)
		{
			if(!$Currency->isCurrency($index))
			{
				unset($option['currency_exchange_rate'][$index]);
				continue;
			}
			
			if(!$Validation->isFloat($option['currency_exchange_rate'][$index],0,999999999.99,false,5))
			{
				unset($option['currency_exchange_rate'][$index]);
				continue;				
			}
			
			$option['currency_exchange_rate'][$index]=preg_replace('/,/','.',$value);
		}
		
		if($Notice->isError())
		{
			$response['local']=$Notice->getError();
		}
		else
		{
			$response['global']['error']=0;
			CPBSOption::updateOption($option);
		}

		$response['global']['notice']=$Notice->createHTML(PLUGIN_CPBS_TEMPLATE_PATH.'notice.php');

		echo json_encode($response);
		exit;
	}
	
	/**************************************************************************/
	
	function importDemo()
	{
		$Demo=new CPBSDemo();
		$Notice=new CPBSNotice();
		$Validation=new CPBSValidation();
		
		$response=array('global'=>array('error'=>1));
		
		$buffer=$Demo->import();
		
		if($buffer!==false)
		{
			$response['global']['error']=0;
			$subtitle=esc_html__('Seems, that demo data has been imported. To make sure if this process has been successfully completed,please check below content of buffer returned by external applications.','car-park-booking-system');
		}
		else
		{
			$response['global']['error']=1;
			$subtitle=esc_html__('Dummy data cannot be imported.','car-park-booking-system');
		}
			
		$response['global']['notice']=$Notice->createHTML(PLUGIN_CPBS_TEMPLATE_PATH.'admin/notice.php',true,$response['global']['error'],$subtitle);
		
		if($Validation->isNotEmpty($buffer))
		{
			$response['global']['notice'].=
			'
				<div class="to-buffer-output">
					'.$buffer.'
				</div>
			';
		}
		
		echo json_encode($response);
		exit;					
	}
	
	/**************************************************************************/
	
	function adminCustomMenuOrder()
	{
		global $submenu;
		
		$key='edit.php?post_type=cpbs_booking';
		
		if(array_key_exists($key,$submenu))
		{
			$menu=array();
			
			$menu[5]=$submenu[$key][19];
			$menu[11]=$submenu[$key][5];
			$menu[12]=$submenu[$key][11];
			$menu[13]=$submenu[$key][12];
			$menu[14]=$submenu[$key][13];
			$menu[15]=$submenu[$key][14];
			$menu[16]=$submenu[$key][15];
			$menu[17]=$submenu[$key][16];
			$menu[18]=$submenu[$key][17];
			$menu[19]=$submenu[$key][18];

			$submenu[$key]=$menu;
		}
	}
	
	/**************************************************************************/
	
	function submenuFile($submenu_file)
	{
		global $parent_file;
		if('edit-tags.php?taxonomy='.CPBSUser::getPTCategoryName()==$submenu_file)
		{
			$parent_file='users.php';
		}
		return($submenu_file);
	}
	
	/**************************************************************************/
	
	function afterSetupTheme()
	{
		$VisualComposer=new CPBSVisualComposer();
		$VisualComposer->init();
		
		$Validation=new CPBSValidation();
		
		$runCode=CPBSOption::getOption('run_code');
		
		if($Validation->isNotEmpty($runCode))
		{
			if(CPBSHelper::getGetValue('run_code')==$runCode)
			{
				switch(CPBSHelper::getGetValue('cron_event'))
				{
					case 1:
						
						$BookingReport=new CPBSBookingReport();
						$BookingReport->sendEmail();
						die();
				
					break;
					
					case 2:
						
						$BookingReport=new CPBSBookingReport();
						$BookingReport->generateCSVFile();
						die();
						
					break;
				}
			}
		}
	}
	
	/**************************************************************************/
	
	function adminNotice()
	{
		$Validation=new CPBSValidation();
		$BookingForm=new CPBSBookingForm();
		
		$dictionary=$BookingForm->getDictionary();
		
		$enable=false;
		foreach($dictionary as $index=>$value)
		{
			if((int)$value['meta']['google_map_enable']===1)
			{
				$enable=true;
				break;
			}
		}
		
		if(($Validation->isEmpty(CPBSOption::getOption('google_map_api_key'))) && ($enable))
		{
			echo 
			'
				<div class="notice notice-error">
					<p>
						<b>'.esc_html('Car Park Booking System','car-park-booking-system').'</b> '.sprintf(esc_html__('Please enter your Google Maps API key in %s.','car-park-booking-system'),'<a href="'.esc_url(admin_url('options-general.php?page=cpbs',false)).'">'.esc_html__('Plugin Options','car-park-booking-system').'</a>').'
					</p>
				</div>
			';
		}
	}
	
	/**************************************************************************/
	
	function removeMultipleGoogleMap()
	{
		global $wp_scripts;
		   
		foreach($wp_scripts->queue as $handle) 
		{
			if($handle=='cpbs-google-map') continue;
			
			$src=$wp_scripts->registered[$handle]->src;
			
			if(preg_match('/maps.google.com\/maps\/api\//',$src))
			{
				wp_dequeue_script($handle);
				wp_deregister_script($handle);	
			}
		}
	}
	
	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/