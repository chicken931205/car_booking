<?php

/******************************************************************************/
/******************************************************************************/

class CPBSBookingForm
{
	/**************************************************************************/
	
	function __construct()
	{
		$this->fieldMandatory=array
		(
			'client_contact_detail_phone_number'=>array
			(
				'label'=>esc_html__('Phone number','car-park-booking-system'),
				'mandatory'=>0
			),
			'client_billing_detail_company_name'=>array
			(
				'label'=>esc_html__('Company registered name','car-park-booking-system'),
				'mandatory'=>0
			),
			'client_billing_detail_tax_number'=>array
			(
				'label'=>esc_html__('Tax number','car-park-booking-system'),
				'mandatory'=>0
			),
			'client_billing_detail_street_name'=>array
			(
				'label'=>esc_html__('Street name','car-park-booking-system'),
				'mandatory'=>1
			),
			'client_billing_detail_street_number'=>array
			(
				'label'=>esc_html__('Street number','car-park-booking-system'),
				'mandatory'=>0
			),
			'client_billing_detail_city'=>array
			(
				'label'=>esc_html__('City','car-park-booking-system'),
				'mandatory'=>1
			),
			'client_billing_detail_state'=>array
			(
				'label'=>esc_html__('State','car-park-booking-system'),
				'mandatory'=>0
			),
			'client_billing_detail_postal_code'=>array
			(
				'label'=>esc_html__('Postal code','car-park-booking-system'),
				'mandatory'=>1
			),
			'client_billing_detail_country_code'=>array
			(
				'label'=>esc_html__('Country','car-park-booking-system'),
				'mandatory'=>1
			)
		);
		
		$this->placeSortingType=array
		(
			1=>array(esc_html__('Price ascending','car-park-booking-system')),
			2=>array(esc_html__('Price descending','car-park-booking-system')),
			3=>array(esc_html__('Space number ascending','car-park-booking-system')),
			4=>array(esc_html__('Space number descending','car-park-booking-system')),
		);
	}
		
	/**************************************************************************/
	
	public function init()
	{
		$this->registerCPT();
	}
	
	/**************************************************************************/

	public static function getCPTName()
	{
		return(PLUGIN_CPBS_CONTEXT.'_booking_form');
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
					'name'=>esc_html__('Booking Forms','car-park-booking-system'),
					'singular_name'=>esc_html__('Booking Form','car-park-booking-system'),
					'add_new'=>esc_html__('Add New','car-park-booking-system'),
					'add_new_item'=>esc_html__('Add New Booking Form','car-park-booking-system'),
					'edit_item'=>esc_html__('Edit Booking Form','car-park-booking-system'),
					'new_item'=>esc_html__('New Booking Form','car-park-booking-system'),
					'all_items'=>esc_html__('Booking Forms','car-park-booking-system'),
					'view_item'=>esc_html__('View Booking Form','car-park-booking-system'),
					'search_items'=>esc_html__('Search Booking Forms','car-park-booking-system'),
					'not_found'=>esc_html__('No Booking Forms Found','car-park-booking-system'),
					'not_found_in_trash'=>esc_html__('No Booking Forms Found in Trash','car-park-booking-system'),
					'parent_item_colon'=>'',
					'menu_name'=>esc_html__('Booking Forms','car-park-booking-system')
				),
				'public'=>false,
				'show_ui'=>true,
				'show_in_menu'=>'edit.php?post_type='.CPBSBooking::getCPTName(),
				'capability_type'=>'post',
				'menu_position'=>2,
				'hierarchical'=>false,
				'rewrite'=>false,
				'supports'=>array('title')
			)
		);
		
		add_action('save_post',array($this,'savePost'));
		add_action('add_meta_boxes_'.self::getCPTName(),array($this,'addMetaBox'));
		add_filter('postbox_classes_'.self::getCPTName().'_cpbs_meta_box_booking_form',array($this,'adminCreateMetaBoxClass'));
		
		add_shortcode(PLUGIN_CPBS_CONTEXT.'_booking_form',array($this,'createBookingForm'));
		
		add_filter('manage_edit-'.self::getCPTName().'_columns',array($this,'manageEditColumns')); 
		add_action('manage_'.self::getCPTName().'_posts_custom_column',array($this,'managePostsCustomColumn'));
		add_filter('manage_edit-'.self::getCPTName().'_sortable_columns',array($this,'manageEditSortableColumns'));
	}
	
	/**************************************************************************/
	
	static function getShortcodeName()
	{
		return(PLUGIN_CPBS_CONTEXT.'_booking_form');
	}
	
	/**************************************************************************/
	
	function addMetaBox()
	{
		add_meta_box(PLUGIN_CPBS_CONTEXT.'_meta_box_booking_form',esc_html__('Main','car-park-booking-system'),array($this,'addMetaBoxMain'),self::getCPTName(),'normal','low');		
	}
	
	/**************************************************************************/
	
	function addMetaBoxMain()
	{
		global $post;
		
		$Country=new CPBSCountry();
		$Location=new CPBSLocation();
		$Currency=new CPBSCurrency();
		$GoogleMap=new CPBSGoogleMap();
		$BookingStatus=new CPBSBookingStatus();
		$BookingFormStyle=new CPBSBookingFormStyle();
		$BookingFormElement=new CPBSBookingFormElement();
		
		$data=array();
		
		$data['meta']=CPBSPostMeta::getPostMeta($post);
		
		$data['nonce']=CPBSHelper::createNonceField(PLUGIN_CPBS_CONTEXT.'_meta_box_booking_form');
		
		$data['dictionary']['color']=$BookingFormStyle->getColor();
		
		$data['dictionary']['location']=$Location->getDictionary();
		
		$data['dictionary']['country']=$Country->getCountry();
	   
		$data['dictionary']['currency']=$Currency->getCurrency();
		
		$data['dictionary']['booking_status']=$BookingStatus->getBookingStatus();
		
		$data['dictionary']['form_element_panel']=$BookingFormElement->getPanel($data['meta']);
		
		$data['dictionary']['google_map']['position']=$GoogleMap->getPosition();
		$data['dictionary']['google_map']['map_type_control_id']=$GoogleMap->getMapTypeControlId();
		$data['dictionary']['google_map']['map_type_control_style']=$GoogleMap->getMapTypeControlStyle();
		
		$data['dictionary']['field_mandatory']=$this->fieldMandatory;
		$data['dictionary']['place_sorting_type']=$this->placeSortingType;
		
		$data['dictionary']['field_type']=$BookingFormElement->getFieldType();
		
		$Template=new CPBSTemplate($data,PLUGIN_CPBS_TEMPLATE_PATH.'admin/meta_box_booking_form.php');
		echo $Template->output();			
	}
	
	/**************************************************************************/
	
	function adminCreateMetaBoxClass($class) 
	{
		array_push($class,'to-postbox-1');
		return($class);
	}
	
	/**************************************************************************/
	
	function savePost($postId)
	{	  
		if(!$_POST) return(false);
		
		if(CPBSHelper::checkSavePost($postId,PLUGIN_CPBS_CONTEXT.'_meta_box_booking_form_noncename','savePost')===false) return(false);
		
		$Date=new CPBSDate();
		$Location=new CPBSLocation();
		$Currency=new CPBSCurrency();
		$GoogleMap=new CPBSGoogleMap();
		$Validation=new CPBSValidation();
		$BookingStatus=new CPBSBookingStatus();
		$BookingFormStyle=new CPBSBookingFormStyle();
		
		/***/
		
		$option=CPBSHelper::getPostOption();

		$dictionary=$Location->getDictionary();
		if(is_array($option['location_id']))
		{
			foreach($option['location_id'] as $index=>$value)
			{
				if(!array_key_exists($value,$dictionary))
					unset($option['location_id'][$index]);
			}
		}
		
		if(is_array($option['location_id']))
		{
			if(!count($option['location_id']))
				$option['location_id']=array(-1); 
		}

		/***/
		
		if(!$BookingStatus->isBookingStatus($option['booking_status_id_default']))
			$option['booking_status_id_default']=1;
		
		/***/
		
		if(!array_key_exists('geolocation_enable',$option))
			$option['geolocation_enable']=array();
			
		foreach($option['geolocation_enable'] as $index=>$value)
		{
			if(!in_array($value,array(1,2)))
				unset($option['geolocation_enable'][$index]);
		}

		if(!is_array($option['geolocation_enable']))
			$option['geolocation_enable']=array();		
		
		/***/
		
		if(!$Validation->isBool($option['woocommerce_enable']))
			$option['woocommerce_enable']=0; 
		if(!in_array($option['woocommerce_account_enable_type'],array(0,1,2)))
			$option['woocommerce_account_enable_type']=1;	
		
		if(!$Validation->isBool($option['coupon_enable']))
			$option['coupon_enable']=0; 
		
		if(!array_key_exists($option['place_sorting_type'],$this->placeSortingType))
			$option['place_sorting_type']=1;
		
		if(!$Validation->isEmpty($option['date_number_value']))
		{
			if(!$Validation->isNumber($option['date_number_value'],1,99))
				$option['date_number_value']='';	
		}
		
		if(!$Validation->isNumber($option['date_number_interval'],1,9999))
			$option['date_number_interval']=30;
		
		if(!$Validation->isNumber($option['full_day_rounding_hour_number'],0,23))
			$option['full_day_rounding_hour_number']=0;		
		
		/***/
		
		$option['currency']=(array)$option['currency'];
		if(in_array(-1,$option['currency']))
		{
			$option['currency']=array(-1);
		}
		else
		{
			foreach($Currency->getCurrency() as $index=>$value)
			{
				if(!$Currency->isCurrency($index))
					unset($option['currency'][$index]);
			}
		}
		
		if(!count($option['currency']))
			$option['currency']=array(-1); 
		
		/***/
		
		if(!$Validation->isPrice($option['order_value_minimum']))
			$option['order_value_minimum']=0.00;   
		
		/***/
		
		if(!$Validation->isBool($option['booking_summary_hide_fee']))
			$option['booking_summary_hide_fee']=0;		 
		
		if(!$Validation->isBool($option['booking_summary_display_net_price']))
			$option['booking_summary_display_net_price']=0;	   
		
		/***/
		
		if(!$Validation->isBool($option['time_field_enable']))
			$option['time_field_enable']=1;
		
		if(!$Validation->isBool($option['location_single_display_enable']))
			$option['location_single_display_enable']=1;	

		if(!is_array($option['location_detail_window_open_action']))
			$option['location_detail_window_open_action']=array();
		
		foreach($option['location_detail_window_open_action'] as $index=>$value)
		{
			if(!in_array($value,array(1,2,3)))
				unset($option['location_detail_window_open_action'][$index]);
		}
		
		if(!in_array($option['billing_detail_state'],array(1,2,3,4)))
			$option['billing_detail_state']=1; 

		if(!$Validation->isBool($option['thank_you_page_enable']))
			$option['thank_you_page_enable']=0;		
	 
		if(!$Validation->isNumber($option['timepicker_step'],1,9999))
			$option['timepicker_step']=30;		
		
		if(!in_array($option['timepicker_today_start_time_type'],array(1,2)))
			$option['timepicker_today_start_time_type']=1;		
		
		if(!$Validation->isBool($option['summary_sidebar_sticky_enable']))
			$option['summary_sidebar_sticky_enable']=0;
		
		$option['field_mandatory']=(array)$option['field_mandatory'];
		foreach($option['field_mandatory'] as $index=>$value)
		{
			if(!array_key_exists($value,$this->fieldMandatory))
				unset($option['field_mandatory'][$index]);
		}
		
		if(!$Validation->isBool($option['booking_extra_step_3_enable']))
			$option['booking_extra_step_3_enable']=0;	 
		
		if(!$Validation->isBool($option['form_preloader_enable']))
			$option['form_preloader_enable']=0;	   
		
		if(!$Validation->isBool($option['navigation_top_enable']))
			$option['navigation_top_enable']=1;   
		if(!$Validation->isBool($option['scroll_to_booking_extra_after_select_place_enable']))
			$option['scroll_to_booking_extra_after_select_place_enable']=1;   
		if(!$Validation->isBool($option['redirect_to_next_step_after_select_place_enable']))
			$option['redirect_to_next_step_after_select_place_enable']=1; 
		if(!$Validation->isBool($option['second_step_next_button_enable']))
			$option['second_step_next_button_enable']=0; 
		if(!$Validation->isBool($option['car_park_space_type_list_space_dimension_enable']))
			$option['car_park_space_type_list_space_dimension_enable']=0; 
		if(!$Validation->isBool($option['car_park_space_type_list_space_number_available_enable']))
			$option['car_park_space_type_list_space_number_available_enable']=0; 		

		/***/
		
		foreach($option['style_color'] as $index=>$value)
		{
			if(!$BookingFormStyle->isColor($index))
			{
				unset($option['style_color'][$index]);
				continue;
			}
			
			if(!$Validation->isColor($value,true))
				$option['style_color'][$index]='';
		}
		
		/***/

		$FormElement=new CPBSBookingFormElement();
		$FormElement->save($postId);
		
		/***/
 
		if(!$Validation->isBool($option['google_map_enable']))
			$option['google_map_enable']=1;	
		if(!$Validation->isBool($option['google_map_scrollwheel_enable']))
			$option['google_map_scrollwheel_enable']=1;			 
 
		if(!array_key_exists($option['google_map_map_type_control_id'],$GoogleMap->getMapTypeControlId()))
			$option['google_map_map_type_control_id']='ROADMAP';		
		
		if(!$Validation->isNumber($option['google_map_zoom_control_level'],1,21))
			$option['google_map_zoom_control_position']=6;   
		
		/***/
		
		$key=array
		(
			'location_id',
			'booking_status_id_default',
			'geolocation_enable',
			'woocommerce_enable',
			'woocommerce_account_enable_type',			
			'coupon_enable',
			'place_sorting_type',
			'date_number_value',
			'date_number_interval',
			'full_day_rounding_hour_number',
			'currency',
			'order_value_minimum',
			'booking_summary_hide_fee',
			'booking_summary_display_net_price',
			'time_field_enable',
			'location_single_display_enable',
			'location_detail_window_open_action',
			'billing_detail_state',
			'thank_you_page_enable',
			'thank_you_page_button_back_to_home_label',
			'thank_you_page_button_back_to_home_url_address',
			'timepicker_step',
			'timepicker_today_start_time_type',
			'summary_sidebar_sticky_enable',
			'field_mandatory',
			'booking_extra_step_3_enable',
			'form_preloader_enable',
			'navigation_top_enable',
			'scroll_to_booking_extra_after_select_place_enable',
			'redirect_to_next_step_after_select_place_enable',
			'second_step_next_button_enable',
			'car_park_space_type_list_space_dimension_enable',
			'car_park_space_type_list_space_number_available_enable',
			'style_color',
			'google_map_enable',
			'google_map_draggable_enable',
			'google_map_scrollwheel_enable',
			'google_map_map_type_control_enable',
			'google_map_map_type_control_id',
			'google_map_map_type_control_style',
			'google_map_map_type_control_position',
			'google_map_zoom_control_enable',
			'google_map_zoom_control_position',
			'google_map_zoom_control_level',
			'google_map_style'
		);

		foreach($key as $value)
			CPBSPostMeta::updatePostMeta($postId,$value,$option[$value]);
		
		$BookingFormStyle->createCSSFile();
	}
	
	/**************************************************************************/
	
	function setPostMetaDefault(&$meta)
	{
		CPBSHelper::setDefault($meta,'location_id',array());
		CPBSHelper::setDefault($meta,'booking_status_id_default',1);
		CPBSHelper::setDefault($meta,'geolocation_enable',array());
		CPBSHelper::setDefault($meta,'woocommerce_enable',0);
		CPBSHelper::setDefault($meta,'woocommerce_account_enable_type',1);
		CPBSHelper::setDefault($meta,'coupon_enable',0);
		CPBSHelper::setDefault($meta,'place_sorting_type',0);
		CPBSHelper::setDefault($meta,'full_day_rounding_hour_number',0);
		
		CPBSHelper::setDefault($meta,'date_number_value','');
		CPBSHelper::setDefault($meta,'date_number_interval','30');
		
		CPBSHelper::setDefault($meta,'booking_extra_day_enable',0); 
		CPBSHelper::setDefault($meta,'booking_extra_day_time',''); 
		CPBSHelper::setDefault($meta,'booking_extra_day_number',0); 
		
		CPBSHelper::setDefault($meta,'currency',array(-1));
		CPBSHelper::setDefault($meta,'order_value_minimum',0.00);
		CPBSHelper::setDefault($meta,'booking_summary_hide_fee',0); 
		CPBSHelper::setDefault($meta,'booking_summary_display_net_price',0); 
		
		CPBSHelper::setDefault($meta,'time_field_enable',1);
		CPBSHelper::setDefault($meta,'location_single_display_enable',1);
		CPBSHelper::setDefault($meta,'location_detail_window_open_action',array(1,3));
		CPBSHelper::setDefault($meta,'billing_detail_state',1);
		CPBSHelper::setDefault($meta,'thank_you_page_enable',1);
		CPBSHelper::setDefault($meta,'thank_you_page_button_back_to_home_label',esc_html__('Back To Home','car-park-booking-system'));
		CPBSHelper::setDefault($meta,'thank_you_page_button_back_to_home_url_address','');
		CPBSHelper::setDefault($meta,'summary_sidebar_sticky_enable',0);
		
		CPBSHelper::setDefault($meta,'timepicker_step',30);
		CPBSHelper::setDefault($meta,'timepicker_today_start_time_type',1);
		
		$fieldMandatory=array();
		foreach($this->fieldMandatory as $index=>$value)
		{
			if((int)$value['mandatory']===1)
				$fieldMandatory[]=$index;
		}	
		
		CPBSHelper::setDefault($meta,'field_mandatory',$fieldMandatory);
		CPBSHelper::setDefault($meta,'booking_extra_step_3_enable',0);
		CPBSHelper::setDefault($meta,'form_preloader_enable',1);
		CPBSHelper::setDefault($meta,'navigation_top_enable',1);
		CPBSHelper::setDefault($meta,'scroll_to_booking_extra_after_select_place_enable',1);
		CPBSHelper::setDefault($meta,'redirect_to_next_step_after_select_place_enable',0);
		CPBSHelper::setDefault($meta,'second_step_next_button_enable',0);
		CPBSHelper::setDefault($meta,'car_park_space_type_list_space_dimension_enable',1);
		CPBSHelper::setDefault($meta,'car_park_space_type_list_space_number_available_enable',1);
		
		$BookingFormStyle=new CPBSBookingFormStyle();
		CPBSHelper::setDefault($meta,'style_color',array_fill(1,count($BookingFormStyle->getColor()),'')); 
		
		CPBSHelper::setDefault($meta,'google_map_enable',1);
		CPBSHelper::setDefault($meta,'google_map_scrollwheel_enable',1);
		
		CPBSHelper::setDefault($meta,'google_map_map_type_control_id','ROADMAP');
		
		CPBSHelper::setDefault($meta,'google_map_zoom_control_level',6);
		
		CPBSHelper::setDefault($meta,'google_map_style','');
	}
	
	/**************************************************************************/
	
	function getDictionary($attr=array())
	{
		global $post;
		
		$dictionary=array();
		
		$default=array
		(
			'booking_form_id'=>0
		);
		
		$attribute=shortcode_atts($default,$attr);
		
		CPBSHelper::preservePost($post,$bPost);
		
		$argument=array
		(
			'post_type'=>self::getCPTName(),
			'post_status'=>'publish',
			'posts_per_page'=>-1,
			'orderby'=>array('menu_order'=>'asc','title'=>'asc'),
			'suppress_filters'=>true
		);
		
		if($attribute['booking_form_id'])
			$argument['p']=$attribute['booking_form_id'];
		
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
			'title'=>esc_html__('Title','car-park-booking-system')
		);
   
		return($column);	  
	}
	
	/**************************************************************************/
	
	function managePostsCustomColumn($column)
	{

	}
	
	/**************************************************************************/
	
	function manageEditSortableColumns($column)
	{
		return($column);	   
	}
	
	/**************************************************************************/
	
	function createBookingForm($attr)
	{
		$TaxRate=new CPBSTaxRate();
		$Validation=new CPBSValidation();
		$BookingFormStyle=new CPBSBookingFormStyle();
		
		$action=CPBSHelper::getGetValue('action',false);
		if($action==='ipn')
		{
			$PaymentPaypal=new CPBSPaymentPaypal();
			$PaymentPaypal->handleIPN();
			return(null);
		}
				
		$default=array
		(
			'booking_form_id'=>0,
			'currency'=>'',
			'widget_mode'=>0,
			'widget_booking_form_url'=>'',
			'widget_booking_form_style_id'=>1
		);
		
		$data=array();
		
		$attribute=shortcode_atts($default,$attr);			   
		
		if(!is_array($data=$this->checkBookingForm($attribute['booking_form_id'],$attribute['currency'],true))) return;

		$data['ajax_url']=admin_url('admin-ajax.php');
		
		$data['booking_form_post_id']=$attribute['booking_form_id'];
		$data['booking_form_html_id']=CPBSHelper::createId('cpbs_booking_form');
	   
		$data['dictionary']['tax_rate']=$TaxRate->getDictionary();
	   
		$color=$BookingFormStyle->getColor();
		
		foreach($color as $index=>$value)
		{
			$data['booking_form_color'][$index]=$data['meta']['style_color'][$index];
			if($Validation->isEmpty($data['booking_form_color'][$index])) $data['booking_form_color'][$index]=$value['color'];
		}
		
		$data['widget_mode']=(int)$attribute['widget_mode'];
		$data['widget_booking_form_url']=$attribute['widget_booking_form_url'];
		$data['widget_booking_form_style_id']=$attribute['widget_booking_form_style_id'];
				
		$Template=new CPBSTemplate($data,PLUGIN_CPBS_TEMPLATE_PATH.'public/public.php');
		return($Template->output());
	}
	
	/**************************************************************************/
	
	function bookingFormDisplayError($message,$displayError)
	{
		if(!$displayError) return;
		echo '<div class="cpbs-booking-form-error">'.esc_html($message).'</div>';
	}
	
	/**************************************************************************/
	
	function checkBookingForm($bookingFormId,$currency=null,$displayError=false)
	{
		$data=array();	  
		
		$PlaceType=new CPBSPlaceType();
		$Validation=new CPBSValidation();
		$GeoLocation=new CPBSGeoLocation();
		$WooCommerce=new CPBSWooCommerce();
	   
		$bookingForm=$this->getDictionary(array('booking_form_id'=>$bookingFormId));
		if(!count($bookingForm)) 
		{
			$this->bookingFormDisplayError(esc_html__('Booking form with provided ID doesn\'t exist.','car-park-booking-system'),$displayError);
			return(-1);
		}
		
		$data['post']=$bookingForm[$bookingFormId]['post'];
		$data['meta']=$bookingForm[$bookingFormId]['meta'];
	   
		/****/ 
		
		$data['dictionary']['place_type']=$PlaceType->getDictionary(array(),$data['meta']['place_sorting_type']);
		if(!count($data['dictionary']['place_type'])) 
		{
			$this->bookingFormDisplayError(esc_html__('Plugin cannot find at least single car park space type.','car-park-booking-system'),$displayError);
			return(-2);
		}
		
		/****/		
		
		$data['dictionary']['location']=$this->getBookingFormLocation($data['meta']);
		if(!count($data['dictionary']['location'])) 
		{		
			$this->bookingFormDisplayError(esc_html__('Plugin cannot find location. Please make sure that you created at least one location and set coordinates for it.','car-park-booking-system'),$displayError);
			return(-3);
		}
		
		/***/
		
		$locationId=$this->getSelectedLocationId($data);
		
		$data['dictionary']['location_place']=$this->getBookingFormLocationPlace($data);
		if(!count($data['dictionary']['location_place'])) 
		{
			$this->bookingFormDisplayError(esc_html__('Plugin cannot find at least one available car park space.','car-park-booking-system'),$displayError);
			return(-4);
		}
		
		/***/

		$data['dictionary']['payment']=array();
		$data['dictionary']['payment_woocommerce']=array();
		
		if($WooCommerce->isEnable($data['meta']))
		{
			if((int)$data['dictionary']['location'][$locationId]['meta']['payment_woocommerce_step_3_enable']===1)
				$data['dictionary']['payment_woocommerce']=$WooCommerce->getPaymentDictionary();
		}
		else 
		{
			$data['dictionary']['payment']=$this->getBookingFormPayment($data['dictionary']['location'][$locationId]['meta']);
		}
		
		/***/
		
		if($Validation->isEmpty($currency))
			$currency=CPBSHelper::getGetValue('currency',false);
		
		if(in_array($currency,$data['meta']['currency']))
			$data['currency']=$currency;
		else $data['currency']=CPBSOption::getOption('currency');
		
		/***/
		
		$data['dictionary']['booking_extra']=$this->getBookingFormExtra();
		
		/****/
		
		if(in_array(2,$data['meta']['geolocation_enable']))
		{		 
			$data['client_coordinate']=$GeoLocation->getCoordinate();
			$data['client_country_code']=$GeoLocation->getCountryCode();
		}
		else
		{
			$data['client_coordinate']=array('lat'=>0,'lng'=>0);
			$data['client_country_code']='';
		}
		
		/***/

		$TaxRate=new CPBSTaxRate();
		$Country=new CPBSCountry();
		$PriceRule=new CPBSPriceRule();
		
		$data['dictionary']['country']=$Country->getCountry();
		$data['dictionary']['tax_rate']=$TaxRate->getDictionary();
		$data['dictionary']['price_rule']=$PriceRule->getDictionary();
		 
		foreach($data['dictionary']['location'] as $index=>$value)
		{
			$data['location_date_exclude'][$index]=$value['meta']['date_exclude'];
			
			$data['location_business_hour']['entry'][$index]=$this->getBookingFormBusinessHour($value['meta']['business_hour'],2);
			$data['location_business_hour']['exit'][$index]=$this->getBookingFormBusinessHour($value['meta']['business_hour'],3);

			$data['location_entry_period'][$index]=$this->getBookingFormEntryPeriod($value['meta'],$data['meta']);
			$data['location_entry_period_format'][$index]['min']=date_i18n(CPBSOption::getOption('date_format'),strtotime($data['location_entry_period'][$index]['min']));
			
			if(is_null($data['location_entry_period'][$index]['max'])) $data['location_entry_period_format'][$index]['max']=null;
			else $data['location_entry_period_format'][$index]['max']=date_i18n(CPBSOption::getOption('date_format'),strtotime($data['location_entry_period'][$index]['max']));
			
			$data['location_payment_paypal_redirect_duration'][$index]=$value['meta']['payment_paypal_redirect_duration'];
			
			if(($Validation->isNotEmpty($value['meta']['coordinate_latitude'])) && ($Validation->isNotEmpty($value['meta']['coordinate_longitude'])))
				$data['location_coordinate'][$index]=array('lat'=>$value['meta']['coordinate_latitude'],'lng'=>$value['meta']['coordinate_longitude']);
		}
		
		/****/
		
		$data['step']=array();
		
		$data['step']['dictionary']=array
		(
			1=>array
			(
				'navigation'=>array
				(
					'number'=>esc_html__('1','car-park-booking-system'),
					'label'=>esc_html__('Select Dates','car-park-booking-system'),
				),
				'button'=>array
				(
					'next'=>esc_html__('Get My Quote','car-park-booking-system')
				)
			),
			2=>array
			(
				'navigation'=>array
				(
					'number'=>esc_html__('2','car-park-booking-system'),
					'label'=>esc_html__('Parking Space','car-park-booking-system')
				),
				'button'=>array
				(
					'prev'=>esc_html__('Select Dates','car-park-booking-system'),
					'next'=>esc_html__('Customer Details','car-park-booking-system')
				)
			),
			3=>array
			(
				'navigation'=>array
				(
					'number'=>esc_html__('3','car-park-booking-system'),
					'label'=>esc_html__('Customer Details','car-park-booking-system')
				),
				'button'=>array
				(
					'prev'=>esc_html__('Parking Space','car-park-booking-system'),
					'next'=>esc_html__('Booking Summary','car-park-booking-system')
				)
			),
			4=>array
			(
				'navigation'=>array
				(
					'number'=>esc_html__('4','car-park-booking-system'),
					'label'=>esc_html__('Booking Summary','car-park-booking-system')
				),
				'button'=>array
				(
					'prev'=>esc_html__('Customer Details','car-park-booking-system'),
					'next'=>esc_html__('Book Now','car-park-booking-system')
				)
			)
		);
		
		/***/
		
		$data['location_id']=$this->getLocationId(CPBSHelper::getPostOption(),$data);
		$data['enable_select_location']=CPBSBookingHelper::enableSelectLocation($data);
	
		/***/
		
		$data['google_map_enable']=!(int)$Validation->isEmpty(CPBSOption::getOption('google_map_api_key')) && $data['meta']['google_map_enable'];
		
		/***/
		
		$data['location_field_enable']=(is_array($data['dictionary']['location']) && count($data['dictionary']['location']) && ($data['enable_select_location'])) ? true : false;

		/***/
		
		return($data);
	}
	
	/**************************************************************************/
	
	function getBookingFormLocation($meta)
	{
		$Location=new CPBSLocation();
		$Validation=new CPBSValidation();
		
		$dictionary=$Location->getDictionary();
		
		if(!is_array($meta['location_id'])) return(array());
		
		foreach($dictionary as $index=>$value)
		{
			if(!in_array($index,$meta['location_id']))
			   unset($dictionary[$index]);
			else
			{
				if(($Validation->isEmpty($dictionary[$index]['meta']['coordinate_latitude'])) || ($Validation->isEmpty($dictionary[$index]['meta']['coordinate_longitude'])))
				{
					unset($dictionary[$index]);
				}
			}
		}
		
	   return($dictionary);
	}
	   
	/**************************************************************************/
	
	function getSelectedLocationId($bookingForm)
	{
		$option=CPBSHelper::getPostOption();
		
		$locationId=0;
		
		if(array_key_exists('location_id',$option))
			$locationId=$option['location_id'];
		
		if(!array_key_exists($locationId,$bookingForm['dictionary']['location']))
			$locationId=key($bookingForm['dictionary']['location']);
		
		return($locationId);
	}
	
	/**************************************************************************/
	
	function getSelectedPlaceTypeId($bookingForm)
	{
		$option=CPBSHelper::getPostOption();
		
		$placeTypeId=0;
		
		if(array_key_exists('place_type_id',$option))
			$placeTypeId=$option['place_type_id'];
		
		if(!array_key_exists($placeTypeId,$bookingForm['dictionary']['place_type']))
			$placeTypeId=0;
		
		return($placeTypeId);
	}
	
	/**************************************************************************/
	
	function getBookingFormExtra()
	{
		$BookingExtra=new CPBSBookingExtra();
		
		$dictionary=$BookingExtra->getDictionary();
   
		return($dictionary);		
	}
	
	/**************************************************************************/
	
	function getBookingFormLocationPlace($bookingForm,$locationId=-1)
	{
		$place=array();
		
		$Date=new CPBSDate();
		
		$data=CPBSHelper::getPostOption();
		$data=CPBSBookingHelper::formatDateTimeToStandard($data,$bookingForm);
		
		$locationPlaceOccupy=$this->getLocationPlaceOccupancy($bookingForm);
		
		foreach($bookingForm['dictionary']['location'] as $locationIndex=>$locationValue)
		{
			$locationPlace=$locationValue['meta']['place_type_quantity'];
			
			foreach($bookingForm['dictionary']['place_type'] as $placeTypeIndex=>$placeTypeValue)
			{
				if(!isset($locationPlace[$placeTypeIndex])) continue;
				
				if((int)$locationPlace[$placeTypeIndex]<=0) continue;
				
				$place[$locationIndex][$placeTypeIndex]['place_all']=(int)$locationPlace[$placeTypeIndex];
				
				$place[$locationIndex][$placeTypeIndex]['place_occupy']=0;
				if(isset($locationPlaceOccupy[$locationIndex][$placeTypeIndex]))
					$place[$locationIndex][$placeTypeIndex]['place_occupy']=(int)$locationPlaceOccupy[$locationIndex][$placeTypeIndex];
				
				/***/
				
				$minPlaceAll=-1;
				
				if(isset($locationValue['meta']['place_type_quantity_period']))
				{
					if(is_array($locationValue['meta']['place_type_quantity_period']))
					{
						foreach($locationValue['meta']['place_type_quantity_period'] as $quantityPeriodIndex=>$quantityPeriodValue)
						{
							if($quantityPeriodValue['place_type_id']==$placeTypeIndex)
							{
								$b=array(false,false);

								CPBSHelper::removeUIndex($data,'time_start');
								
								$b[0]=$Date->dateInRange(trim($data['entry_date'].' '.$data['entry_time']),trim($quantityPeriodValue['date_start'].' '.$data['time_start']),trim($quantityPeriodValue['date_stop'].' '.$quantityPeriodValue['time_stop']));
								$b[1]=$Date->dateInRange(trim($data['exit_date'].' '.$data['exit_time']),trim($quantityPeriodValue['date_start'].' '.$data['time_start']),trim($quantityPeriodValue['date_stop'].' '.$quantityPeriodValue['time_stop']));

								if(in_array(true,$b,true))
								{
									if($minPlaceAll===-1) $minPlaceAll=$quantityPeriodValue['quantity'];
									if($quantityPeriodValue['quantity']<$minPlaceAll) $minPlaceAll=$quantityPeriodValue['quantity'];
								}
							}
						}
					}
				}
				
				/***/
				
				if($minPlaceAll>-1)
				{
					$place[$locationIndex][$placeTypeIndex]['place_free']=(int)$minPlaceAll-(int)$place[$locationIndex][$placeTypeIndex]['place_occupy'];
				}
				else $place[$locationIndex][$placeTypeIndex]['place_free']=(int)$place[$locationIndex][$placeTypeIndex]['place_all']-(int)$place[$locationIndex][$placeTypeIndex]['place_occupy'];

				if($place[$locationIndex][$placeTypeIndex]['place_free']<0)
					$place[$locationIndex][$placeTypeIndex]['place_free']=0;				
			}
		}

		return($place);
	}
	   
	/**************************************************************************/
	
	function getBookingFormPayment($meta)
	{
		$Payment=new CPBSPayment();
				
		$payment=$Payment->getPayment();
		
		foreach($payment as $index=>$value)
		{
			if(!in_array($index,$meta['payment_id']))
			   unset($payment[$index]);
		}
		
		return($payment);
	}

	/**************************************************************************/

	function goToStep()
	{		 
		$response=array();
		
		$Date=new CPBSDate();
		$User=new CPBSUser();
		$Payment=new CPBSPayment();
		$Country=new CPBSCountry();
		$Validation=new CPBSValidation();
		$WooCommerce=new CPBSWooCommerce();
		$BookingFormElement=new CPBSBookingFormElement();
	   
		$data=CPBSHelper::getPostOption();
	 
		if(!is_array($bookingForm=$this->checkBookingForm($data['booking_form_id'])))
		{
			if($bookingForm===-3)
			{
				$response['step']=1;
				$this->setErrorGlobal($response,esc_html__('Cannot find at least one space available in selected time period.','car-park-booking-system'));
				CPBSHelper::createJSONResponse($response);
			}
		}
	   
		if((!in_array($data['step_request'],array(2,3,4,5))) || (!in_array($data['step'],array(1,2,3,4))))
		{
			$response['step']=1;
			CPBSHelper::createJSONResponse($response);			
		}
		
		/***/
		/***/
	
		if($data['step_request']>1)
		{
			$locationId=$this->getLocationId($data,$bookingForm);		
			$data['location_id']=$locationId;
			
			$data=CPBSBookingHelper::formatDateTimeToStandard($data,$bookingForm);
			
			$placeTypeId=(int)$this->getSelectedPlaceTypeId($bookingForm);
			
			if(!array_key_exists($locationId,$bookingForm['dictionary']['location']))
				$this->setErrorLocal($response,CPBSHelper::getFormName('location_id',false),esc_html__('Enter a valid location.','car-park-booking-system'));   
			
			if(!isset($response['error']))
			{
				$dateTimeError=false;

				/***/

				if(!$Validation->isDate($data['entry_date']))
				{
					$dateTimeError=true;
					$this->setErrorLocal($response,CPBSHelper::getFormName('entry_date',false),esc_html__('Enter a valid date.','car-park-booking-system'));
				}
				if((int)$bookingForm['meta']['time_field_enable']===1)
				{
					if(!$Validation->isTime($data['entry_time']))
					{   
						$dateTimeError=true;
						$this->setErrorLocal($response,CPBSHelper::getFormName('entry_time',false),esc_html__('Enter a valid time.','car-park-booking-system'));
					}
				}
				if(!$Validation->isDate($data['exit_date']))
				{
					$dateTimeError=true;
					$this->setErrorLocal($response,CPBSHelper::getFormName('exit_date',false),esc_html__('Enter a valid date.','car-park-booking-system'));
				}
				if((int)$bookingForm['meta']['time_field_enable']===1)
				{
					if(!$Validation->isTime($data['exit_time']))
					{   
						$dateTimeError=true;
						$this->setErrorLocal($response,CPBSHelper::getFormName('exit_time',false),esc_html__('Enter a valid time.','car-park-booking-system'));
					}
				}

				/***/

				if(!$dateTimeError)
				{
					$currentDate=date_i18n('d-m-Y G:i');
					
					if(in_array($Date->compareDate($data['entry_date'].' '.$data['entry_time'],$currentDate),array(2)))
					{
						$dateTimeError=true;
						$this->setErrorLocal($response,CPBSHelper::getFormName('entry_date',false),esc_html__('Entry date/time has to be later than current date.','car-park-booking-system'));					
					}
				}

				if(!$dateTimeError)
				{
					if(in_array($Date->compareDate($data['entry_date'].' '.$data['entry_time'],$data['exit_date'].' '.$data['exit_time']),array(0,1)))
					{
						$dateTimeError=true;
						$this->setErrorLocal($response,CPBSHelper::getFormName('exit_date',false),esc_html__('Exit date/time has to be later than entry date/time.','car-park-booking-system'));					
					}
				}

				/***/

				if(!$dateTimeError)
				{
					if(is_array($bookingForm['dictionary']['location'][$locationId]['meta']['date_exclude']))
					{
						foreach($bookingForm['dictionary']['location'][$locationId]['meta']['date_exclude'] as $index=>$value)
						{
							if($Date->dateInRange($data['entry_date'],$value['start'],$value['stop']))
							{
								$this->setErrorLocal($response,CPBSHelper::getFormName('entry_date',false),sprintf(esc_html__('It is not possible to rent a car park space between %s and %s.','car-park-booking-system'),$value['start'],$value['stop']));
								$dateTimeError=true;
								break;
							}
						}
					}
				}

				/***/

				for($i=0;$i<2;$i++)
				{
					if(!$dateTimeError)
					{	
						$found=false;
						
						$businessHour=$this->getBookingFormBusinessHour($bookingForm['dictionary']['location'][$locationId]['meta']['business_hour'],$i+2);	
						$businessHourIndex=null;
						
						$date=$i===0 ? $data['entry_date'] : $data['exit_date'];
						$time=$i===0 ? $data['entry_time'] : $data['exit_time'];
						
						$number=$Date->getDayNumberOfWeek($date);

						if(isset($businessHour['available'][$date])) $businessHourIndex=$date;
						elseif(isset($businessHour['available'][$number])) $businessHourIndex=$number;

						if(!is_null($businessHourIndex))
						{
							foreach($businessHour['available'][$businessHourIndex] as $index=>$value)
							{
								if($Date->timeInRange($time,$value['start'],$value['stop']))
								{
									$found=true;
									break;
								}
							}
						}
						
						if(!$found)
						{
							$this->setErrorLocal($response,CPBSHelper::getFormName(($i===0 ? 'entry_time' : 'exit_time'),false),esc_html__('Enter a valid time.','car-park-booking-system'));
							$dateTimeError=true;
						}
					}
				}
								
				/***/
				
				if(!$dateTimeError)
				{
					$entryPeriodFrom=$bookingForm['dictionary']['location'][$locationId]['meta']['entry_period_from'];
					if(!$Validation->isNumber($entryPeriodFrom,0,9999))
						$entryPeriodFrom=0;

					list($date1,$date2)=$this->getDateEntryPeriod($data,$bookingForm['dictionary']['location'][$locationId],$entryPeriodFrom);
					if($Date->compareDate($date1,$date2)===2)
					{
						$this->setErrorLocal($response,CPBSHelper::getFormName('entry_date',false),__('Enter a valid date.','car-park-booking-system'));
						$dateTimeError=true;                    
					}       
					
					if(!$dateTimeError)
					{
						$entryPeriodTo=$bookingForm['dictionary']['location'][$locationId]['meta']['entry_period_to'];
						if($Validation->isNumber($entryPeriodTo,0,9999))
						{
							$entryPeriodTo+=$entryPeriodFrom;

							list($date1,$date2)=$this->getDateEntryPeriod($data,$bookingForm['dictionary']['location'][$locationId],$entryPeriodTo);    
							if($Date->compareDate($date1,$date2)===1)
							{
								$this->setErrorLocal($response,CPBSHelper::getFormName('entry_date',false),__('Enter a valid date.','car-park-booking-system'));
								$dateTimeError=true;                    
							}                               
						}
					}
				}
				
				/***/
	
				if(!$dateTimeError)
				{
					$bookingPeriod=CPBSBookingHelper::calculateBookingPeriod($data['entry_date'],$data['entry_time'],$data['exit_date'],$data['exit_time'],$bookingForm,CPBSOption::getOption('billing_type'));
						
					$bookingPeriodTime=0;
					$bookingPeriodUnit=esc_html__('days','car-park-booking-system');

					switch(CPBSOption::getOption('billing_type'))
					{
						case 1:
						case 4:

							$bookingPeriodTime=$bookingPeriod['hour']*60+$bookingPeriod['minute'];
							$bookingPeriodUnit=esc_html__('minutes','car-park-booking-system');

						break;

						case 2:
						case 5:
						case 7:

							$bookingPeriodTime=$bookingPeriod['day']*24+$bookingPeriod['hour'];
							$bookingPeriodUnit=esc_html__('hours','car-park-booking-system');

						break;

						case 3:
						case 6:

							$bookingPeriodTime=$bookingPeriod['day'];

						break;
					}
				}
				
				$bookingPeriodDateUse=false;
				
				if(!$dateTimeError)
				{
					if(isset($bookingForm['dictionary']['location'][$locationId]['meta']['booking_period_date']))
					{
						$bookingPeriodDate=$bookingForm['dictionary']['location'][$locationId]['meta']['booking_period_date'];
						
						if(count($bookingPeriodDate))
						{
							foreach($bookingPeriodDate as $index=>$value)
							{
								if($Date->dateInRange($data['entry_date'],$value['date_from'],$value['date_to']))
								{
									$bookingPeriodDateUse=true;
									
									if($Validation->isNotEmpty($value['unit_from']))
									{
										if($value['unit_from']<=$bookingPeriodTime)
										{
											
										}
										else
										{
											$this->setErrorLocal($response,CPBSHelper::getFormName('entry_date',false),sprintf(__('Minimum number of %s to rent a car park space  is %s.','car-park-booking-system'),$bookingPeriodUnit,$value['unit_from']));
											$dateTimeError=true;
										}
									}
										
									if(!$dateTimeError)
									{
										if($Validation->isNotEmpty($value['unit_to']))
										{
											if($value['unit_to']>=$bookingPeriodTime)
											{
												
											}
											else
											{
												$this->setErrorLocal($response,CPBSHelper::getFormName('exit_date',false),sprintf(__('Maximum number of %s to rent a car park space is %s.','car-park-booking-system'),$bookingPeriodUnit,$value['unit_to']));
												$dateTimeError=true;
											}
										}											
									}
								}
							}
						}
					}
				}
				
				if((!$dateTimeError) && (!$bookingPeriodDateUse))
				{
					$bookingFormPeriodFrom=$bookingForm['dictionary']['location'][$locationId]['meta']['booking_period_from'];
					$bookingFormPeriodTo=$bookingForm['dictionary']['location'][$locationId]['meta']['booking_period_to'];
					
					if(($Validation->isNotEmpty($bookingFormPeriodFrom)) || ($Validation->isNotEmpty($bookingFormPeriodTo)))
					{					
						if(($Validation->isNotEmpty($bookingFormPeriodFrom)) && ($Validation->isNotEmpty($bookingFormPeriodTo)))
						{
							if(!(($bookingFormPeriodFrom<=$bookingPeriodTime) && ($bookingFormPeriodTo>=$bookingPeriodTime)))
							{
								$this->setErrorLocal($response,CPBSHelper::getFormName('entry_date',false),sprintf(esc_html__('Booking period should be between %s and %s %s.','car-park-booking-system'),$bookingFormPeriodFrom,$bookingFormPeriodTo,$bookingPeriodUnit));
								$dateTimeError=true;
							}							
						}
						else if($Validation->isNotEmpty($bookingFormPeriodFrom))
						{
							if($bookingFormPeriodFrom>$bookingPeriodTime)
							{
								$this->setErrorLocal($response,CPBSHelper::getFormName('entry_date',false),sprintf(esc_html__('Booking period should not be less than %s %s.','car-park-booking-system'),$bookingFormPeriodFrom,$bookingPeriodUnit));
								$dateTimeError=true;							
							}
						}
						else if($Validation->isNotEmpty($bookingFormPeriodTo))
						{
							if($bookingFormPeriodTo<$bookingPeriodTime)
							{
								$this->setErrorLocal($response,CPBSHelper::getFormName('entry_date',false),sprintf(esc_html__('Booking period should not be more than %s %s.','car-park-booking-system'),$bookingFormPeriodTo,$bookingPeriodUnit));
								$dateTimeError=true;							
							}
						}
					}
				}
				
				/***/
				
				if(!$dateTimeError)
				{
					if($Validation->isNotEmpty($bookingForm['meta']['date_number_value']))
					{
						$number=$this->getBookingCount($data,$bookingForm);
					
						if($number>=$bookingForm['meta']['date_number_value'])
						{
							$this->setErrorLocal($response,CPBSHelper::getFormName('entry_date',false),esc_html__('All park spaces are booked. Please select different entry/exit date/time.','car-park-booking-system'));
							$dateTimeError=true;							
						}
					}
				}
			}
			
			/***/
			
			if(isset($response['error']))
			{
				$response['step']=1;
				CPBSHelper::createJSONResponse($response);
			}
		}  
		
		/***/
		 
		if($data['step_request']>2)
		{
			$error=false;
			
			if(!array_key_exists($placeTypeId,$bookingForm['dictionary']['place_type']))
			{
				$error=true;
				$data['step']=2;
				$data['step_request']=2;
				$this->setErrorGlobal($response,esc_html__('Select a space.','car-park-booking-system'));
			}
			
			if(!$error)
			{
				$placeAvailable=(int)$bookingForm['dictionary']['location_place'][$locationId][$placeTypeId]['place_free'];
				$placeAvailableCheckEnable=(int)$bookingForm['dictionary']['location'][$locationId]['meta']['place_type_availability_check_enable'];
				
				if(($placeAvailableCheckEnable===1) && ($placeAvailable===0))
				{
					$error=true;
					$this->setErrorGlobal($response,esc_html__('Space is not available in this location. Select a different one.','car-park-booking-system'));
				}
			}
			
			if(!$error)
			{
				if($bookingForm['meta']['order_value_minimum']>0)
				{
					$Booking=new CPBSBooking();

					$data['booking_form']=$bookingForm;

					if(($price=$Booking->calculatePrice($data))!==false)	  
					{
						$orderValueMinimum=number_format($bookingForm['meta']['order_value_minimum']*CPBSCurrency::getExchangeRate(),2,'.','');
						
						if($orderValueMinimum>$price['total']['sum']['gross']['value'])
						{
							$this->setErrorGlobal($response,sprintf(esc_html__('Minimum value of order is %s.','car-park-booking-system'),CPBSPrice::format($orderValueMinimum,CPBSCurrency::getFormCurrency())));
						}
					}
				}
			}
			
			if(isset($response['error'])) $response['step']=2;
		}
		
		/***/
				
		if(!isset($response['error']))
		{
			if($data['step_request']>3)
			{
				$error=false;
				
				if($WooCommerce->isEnable($bookingForm['meta']))
				{
					if(!$User->isSignIn())
					{
						if(((int)$data['client_account']===0) && ((int)$bookingForm['meta']['woocommerce_account_enable_type']===2))
						{
							$this->setErrorGlobal($response,esc_html__('Login to your account or provide all needed details.','car-park-booking-system'));   
						}
					}
				}				
				
				if(!$error)
				{				
					if($Validation->isEmpty($data['client_contact_detail_first_name']))
						$this->setErrorLocal($response,CPBSHelper::getFormName('client_contact_detail_first_name',false),esc_html__('Enter your first name','car-park-booking-system'));
					if($Validation->isEmpty($data['client_contact_detail_last_name']))
						$this->setErrorLocal($response,CPBSHelper::getFormName('client_contact_detail_last_name',false),esc_html__('Enter your last name','car-park-booking-system'));
					if(!$Validation->isEmailAddress($data['client_contact_detail_email_address']))
						$this->setErrorLocal($response,CPBSHelper::getFormName('client_contact_detail_email_address',false),esc_html__('Enter valid e-mail address','car-park-booking-system'));
					if(in_array('client_contact_detail_phone_number',$bookingForm['meta']['field_mandatory']))
					{
						if($Validation->isEmpty($data['client_contact_detail_phone_number']))
							$this->setErrorLocal($response,CPBSHelper::getFormName('client_contact_detail_phone_number',false),esc_html__('Please enter valid phone number.','car-park-booking-system'));
					}
					
					if((int)$bookingForm['meta']['billing_detail_state']!==4)
					{
						if(((int)$data['client_billing_detail_enable']===1) || ((int)$bookingForm['meta']['billing_detail_state']===3))
						{
							if(in_array('client_billing_detail_company_name',$bookingForm['meta']['field_mandatory']))
							{							
								if($Validation->isEmpty($data['client_billing_detail_company_name']))
									$this->setErrorLocal($response,CPBSHelper::getFormName('client_billing_detail_company_name',false),esc_html__('Enter valid company name.','car-park-booking-system'));			   
							}
							if(in_array('client_billing_detail_tax_number',$bookingForm['meta']['field_mandatory']))
							{							
								if($Validation->isEmpty($data['client_billing_detail_tax_number']))
									$this->setErrorLocal($response,CPBSHelper::getFormName('client_billing_detail_tax_number',false),esc_html__('Enter valid tax number.','car-park-booking-system'));			   
							}						
							if(in_array('client_billing_detail_street_name',$bookingForm['meta']['field_mandatory']))
							{
								if($Validation->isEmpty($data['client_billing_detail_street_name']))
									$this->setErrorLocal($response,CPBSHelper::getFormName('client_billing_detail_street_name',false),esc_html__('Enter valid street name.','car-park-booking-system'));			   
							}
							if(in_array('client_billing_detail_street_number',$bookingForm['meta']['field_mandatory']))
							{
								if($Validation->isEmpty($data['client_billing_detail_street_number']))
									$this->setErrorLocal($response,CPBSHelper::getFormName('client_billing_detail_street_number',false),esc_html__('Enter valid street number.','car-park-booking-system'));			   
							}						
							if(in_array('client_billing_detail_city',$bookingForm['meta']['field_mandatory']))
							{
								if($Validation->isEmpty($data['client_billing_detail_city']))
									$this->setErrorLocal($response,CPBSHelper::getFormName('client_billing_detail_city',false),esc_html__('Enter valid city name.','car-park-booking-system'));				 
							}
							if(in_array('client_billing_detail_state',$bookingForm['meta']['field_mandatory']))
							{
								if($Validation->isEmpty($data['client_billing_detail_state']))
									$this->setErrorLocal($response,CPBSHelper::getFormName('client_billing_detail_state',false),esc_html__('Enter valid state name.','car-park-booking-system'));				
							}
							if(in_array('client_billing_detail_postal_code',$bookingForm['meta']['field_mandatory']))	
							{
								if($Validation->isEmpty($data['client_billing_detail_postal_code']))
									$this->setErrorLocal($response,CPBSHelper::getFormName('client_billing_detail_postal_code',false),esc_html__('Enter valid postal code.','car-park-booking-system'));				  
							}
							if(in_array('client_billing_detail_country_code',$bookingForm['meta']['field_mandatory']))
							{
								if(!$Country->isCountry($data['client_billing_detail_country_code']))
									$this->setErrorLocal($response,CPBSHelper::getFormName('client_billing_detail_country_code',false),esc_html__('Enter valid country name.','car-park-booking-system')); 
							}
						}
					}
					
					if($WooCommerce->isEnable($bookingForm['meta']))
					{
						if(!$User->isSignIn())
						{
							if(((int)$data['client_sign_up_enable']===1) || ((int)$bookingForm['meta']['woocommerce_account_enable_type']===2))
							{
								$validationResult=$User->validateCreateUser($data['client_contact_detail_email_address'],$data['client_sign_up_login'],$data['client_sign_up_password'],$data['client_sign_up_password_retype']);

								if(in_array('EMAIL_INVALID',$validationResult))
									$this->setErrorLocal($response,CPBSHelper::getFormName('client_contact_detail_email_address',false),esc_html__('E-mail address is invalid.','car-park-booking-system')); 
								if(in_array('EMAIL_EXISTS',$validationResult))
									$this->setErrorLocal($response,CPBSHelper::getFormName('client_contact_detail_email_address',false),esc_html__('E-mail address already exists','car-park-booking-system'));							 

								if(in_array('LOGIN_INVALID',$validationResult))
									$this->setErrorLocal($response,CPBSHelper::getFormName('client_sign_up_login',false),esc_html__('Login cannot be empty.','car-park-booking-system'));							 
								if(in_array('LOGIN_EXISTS',$validationResult))
									$this->setErrorLocal($response,CPBSHelper::getFormName('client_sign_up_login',false),esc_html__('Login already exists.','car-park-booking-system'));							   

								if(in_array('PASSWORD1_INVALID',$validationResult))
									$this->setErrorLocal($response,CPBSHelper::getFormName('client_sign_up_password',false),esc_html__('Password cannot be empty.','car-park-booking-system'));							   
								if(in_array('PASSWORD2_INVALID',$validationResult))
									$this->setErrorLocal($response,CPBSHelper::getFormName('client_sign_up_password_retype',false),esc_html__('Password cannot be empty.','car-park-booking-system'));							 
								if(in_array('PASSWORD_MISMATCH',$validationResult))
									$this->setErrorLocal($response,CPBSHelper::getFormName('client_sign_up_password_retype',false),esc_html__('Passwords are not the same.','car-park-booking-system'));							  
							}
						}
					}
				
					$error=$BookingFormElement->validateField($bookingForm['meta'],$data);
					foreach($error as $errorValue)
						$this->setErrorLocal($response,$errorValue['name'],$errorValue['message_error']); 

					if(!CPBSBookingHelper::isPayment($data['payment_id'],$bookingForm['meta'],$bookingForm['dictionary']['location'][$locationId]['meta']))
						$this->setErrorGlobal($response,esc_html__('Select a payment method.','car-park-booking-system'));

					$error=$BookingFormElement->validateAgreement($bookingForm['meta'],$data);
					if($error)
						$this->setErrorGlobal($response,esc_html__('Approve all agreements.','car-park-booking-system'));			  
				}
				
				if(isset($response['error']))
				{
					$data['step']=3;
					$data['step_request']=3;
					$response['step']=3;
				} 
			}
		}
		
		/***/
		
		if(!isset($response['error']))
		{
			if($data['step_request']>4)
			{
				$Booking=new CPBSBooking();
				$WooCommerce=new CPBSWooCommerce();
				
				$bookingId=$Booking->sendBooking($data,$bookingForm);
				
				if((int)$bookingForm['dictionary']['location'][$locationId]['meta']['payment_processing_enable']===1)
				{
					$response['step']=5;
					
					if(!$WooCommerce->isEnable($bookingForm['meta']))
					{
						if(!$Payment->isPayment($data['payment_id']))
							$data['payment_id']=0;
						
						if($data['payment_id']!=0)
						{
							$payment=$Payment->getPayment($data['payment_id']);

							$response['payment_info']=esc_html($bookingForm['dictionary']['location'][$locationId]['meta']['payment_'.$payment[1].'_info']);

							$response['button_back_to_home_label']=esc_html($bookingForm['meta']['thank_you_page_button_back_to_home_label']);
							$response['button_back_to_home_url_address']=esc_url($bookingForm['meta']['thank_you_page_button_back_to_home_url_address']);

							$response['payment_prefix']=$payment[1];
						}
							
						$response['payment_id']=$data['payment_id'];  

						if(in_array($data['payment_id'],array(2,3)))
						{
							$booking=$Booking->getBooking($bookingId);
							$bookingBilling=$Booking->createBilling($bookingId);			  
						}

						if($data['payment_id']==3)
						{
							$response['form']['item_name']=$booking['post']->post_title;
							
							$response['form']['booking_id']=$booking['post']->ID;
							$response['form']['item_number']=$booking['post']->ID;
							
							$response['form']['currency_code']=$booking['meta']['currency_id'];

							$response['form']['amount']=$bookingBilling['summary']['value_gross'];
							
							if((int)$bookingForm['dictionary']['location'][$locationId]['meta']['payment_paypal_booking_summary_page_id']>0)
							{
								if(($urlAddress=get_permalink((int)$bookingForm['dictionary']['location'][$locationId]['meta']['payment_paypal_booking_summary_page_id']))!==false)
								{
									$BookingSummary=new CPBSBookingSummary();
									$response['form']['return']=CPBSHelper::buildURLAddress($urlAddress,array('booking_id'=>$booking['post']->ID,'access_token'=>$BookingSummary->getAccessToken($booking['post']->ID)));
								}
							}
						}
						elseif($data['payment_id']==2)
						{
							$PaymentStripe=new CPBSPaymentStripe();
							
							$sessionId=$PaymentStripe->createSession($booking,$bookingBilling,$bookingForm);
							
							$response['stripe_session_id']=$sessionId;
							$response['stripe_redirect_duration']=$bookingForm['dictionary']['location'][$locationId]['meta']['payment_stripe_redirect_duration'];
							$response['stripe_publishable_key']=$bookingForm['dictionary']['location'][$locationId]['meta']['payment_stripe_api_key_publishable'];
							
							if($sessionId===false)
							{
								$this->setErrorGlobal($response,__('An error occurs during processing this payment. Plugin cannot continue the work.','car-park-booking-system'));
							}
						}
					}
					else
					{
						$response['payment_url']=$WooCommerce->sendBooking($bookingId,$bookingForm,$data);

						if($Validation->isNotEmpty($response['payment_url']))
							$response['thank_you_page_enable']=$bookingForm['meta']['thank_you_page_enable'];
						else $response['thank_you_page_enable']=1;
						
						$response['payment_id']=-1;
					}
				}
				else
				{
					$response['step']=5;
					$response['payment_id']=-2;	   
					
					$response['button_back_to_home_label']=$bookingForm['meta']['thank_you_page_button_back_to_home_label'];
					$response['button_back_to_home_url_address']=$bookingForm['meta']['thank_you_page_button_back_to_home_url_address'];
				}
			}
		}
				  
		/***/
		/***/		

		if($data['step_request']==2)
		{
			if(($locationPlaceHtml=$this->locationPlaceFilter(false,$bookingForm))!==false);
				$response['place']=$locationPlaceHtml;
			
			$response['booking_extra']=$this->createBookingExtra($data,$bookingForm);
		}   
		
		/***/
		
		if($data['step_request']==3)
		{
			$userData=array();
			
			$User=new CPBSUser();
			$WooCommerce=new CPBSWooCommerce();
			
			if(($WooCommerce->isEnable($bookingForm['meta'])) && ($User->isSignIn()))
			{
				if(!array_key_exists('client_contact_detail_first_name',$data))
					$userData=$WooCommerce->getUserData();
			}
			
			if(!array_key_exists('client_contact_detail_first_name',$data))
			{
				$userData['client_billing_detail_country_code']=$bookingForm['client_country_code'];
			}
			
			$response['client_form_sign_id']=$this->createClientFormSignIn($bookingForm);
			$response['client_form_sign_up']=$this->createClientFormSignUp($bookingForm,$userData);
		}
		
		/***/
		
		if(!isset($response['error']))
		{
			$response['step']=$data['step_request'];
			$data['step']=$response['step'];
		}
		else 
		{
			$data['step_request']=$data['step'];
		}
					   
		$response['summary']=$this->createSummary($data,$bookingForm);

		$response['payment']=$this->createPayment($data,$bookingForm['dictionary']['payment'],$bookingForm['dictionary']['payment_woocommerce'],$data['payment_id'],$bookingForm['dictionary']['location'][$locationId]['meta']);
		
		CPBSHelper::createJSONResponse($response);
		
		/***/
	}
	
	/**************************************************************************/
	
	function getBookingCount($data,$bookingForm)
	{
		global $post;
		
		$Date=new CPBSDate();
	
		$argument=array
		(
			'post_type'=>CPBSBooking::getCPTName(),
			'post_status'=>'publish',
			'posts_per_page'=>-1,
			'suppress_filters'=>true,
			'meta_query'=>array
			(
				'relation'=>'OR',
				array
				(
					'key'=>PLUGIN_CPBS_CONTEXT.'_entry_date',
					'value'=>$data['entry_date'],
					'compare'=>'='
				),
				array
				(
					'key'=>PLUGIN_CPBS_CONTEXT.'_exit_date',
					'value'=>$data['entry_date'],
					'compare'=>'='
				),
				array
				(
					'key'=>PLUGIN_CPBS_CONTEXT.'_entry_date',
					'value'=>$data['exit_date'],
					'compare'=>'='
				),
				array
				(
					'key'=>PLUGIN_CPBS_CONTEXT.'_exit_date',
					'value'=>$data['exit_date'],
					'compare'=>'='
				)
			)
		);
		
		$query=new WP_Query($argument);
		if($query===false) return(0);
		
		$count=0;
		
		$entryTime1=date_i18n('H:i',strtotime($data['entry_time'].' -'.(int)$bookingForm['meta']['date_number_interval'].' minutes'));
		$entryTime2=date_i18n('H:i',strtotime($data['entry_time'].' +'.(int)$bookingForm['meta']['date_number_interval'].' minutes'));
		$exitTime1=date_i18n('H:i',strtotime($data['exit_time'].' -'.(int)$bookingForm['meta']['date_number_interval'].' minutes'));
		$exitTime2=date_i18n('H:i',strtotime($data['exit_time'].' +'.(int)$bookingForm['meta']['date_number_interval'].' minutes'));
		
		while($query->have_posts())
		{
			$query->the_post();
			if(is_null($post)) continue;
			
			$meta=CPBSPostMeta::getPostMeta($post);
			
			if($data['entry_date']==$meta['entry_date'])
			{
				if($Date->timeInRange($meta['entry_time'],$entryTime1,$entryTime2)) $count++;
			}
			if($data['entry_date']==$meta['exit_date'])
			{
				if($Date->timeInRange($meta['entry_time'],$exitTime1,$exitTime2)) $count++;
			}
			if($data['exit_date']==$meta['entry_date'])
			{
				if($Date->timeInRange($meta['exit_time'],$entryTime1,$entryTime2)) $count++;
			}			
			if($data['exit_date']==$meta['exit_date'])
			{
				if($Date->timeInRange($meta['exit_time'],$exitTime1,$exitTime2)) $count++;
			}				
		}		

		return($count);
	}

	/**************************************************************************/
	
	function setErrorLocal(&$response,$field,$message)
	{
		if(!isset($response['error']))
		{
			$response['error']['local']=array();
			$response['error']['global']=array();
		}
		
		array_push($response['error']['local'],array('field'=>$field,'message'=>$message));
	}
	
	/**************************************************************************/
	
	function setErrorGlobal(&$response,$message)
	{
		if(!isset($response['error']))
		{
			$response['error']['local']=array();
			$response['error']['global']=array();
		}
		
		array_push($response['error']['global'],array('message'=>$message));
	}
	
	/**************************************************************************/
	
	function createSummaryPriceElementAjax()
	{
		$response=array();
		
		$data=CPBSHelper::getPostOption();
		
		if(!is_array($bookingForm=$this->checkBookingForm($data['booking_form_id'])))
		{
			$response['html']=null;
			CPBSHelper::createJSONResponse($response);
		}
		
		$data=CPBSBookingHelper::formatDateTimeToStandard($data,$bookingForm);
		
		$data['location_id']=$this->getLocationId($data,$bookingForm);
		
		$response['html']=$this->createSummaryPriceElement($data,$bookingForm);
		
		CPBSHelper::createJSONResponse($response);
	}
	
	/**************************************************************************/
	
	function createSummaryPriceElement($data,$bookingForm)
	{
		$html=null;
		$Booking=new CPBSBooking();
		
		$data['booking_form']=$bookingForm;
		
		if(($price=$Booking->calculatePrice($data,null,$bookingForm['meta']['booking_summary_hide_fee']))===false) return(null);
		
		$netGross=(int)$bookingForm['meta']['booking_summary_display_net_price']===1 ? 'net' : 'gross';
		
		/***/
		
		$bookingPeriodHTML=null;
		if($data['step_request']>=4)
		{
			$bookingPeriod=CPBSBookingHelper::calculateBookingPeriod($data['entry_date'],$data['entry_time'],$data['exit_date'],$data['exit_time'],$bookingForm);
			$bookingPeriodHTML=' ('.esc_html(CPBSBookingHelper::displayBookingPeriod($bookingPeriod)).')';
		}
		
		/***/
		
		if($price['place']['sum'][$netGross]['value']!=0)
		{
			$html.=
			'
				<div>
					<span>'.esc_html__('Space','car-park-booking-system').$bookingPeriodHTML.'</span>
					<span>'.esc_html($price['place']['sum'][$netGross]['format']).'</span>
				</div>
			';
		}
 
		if((int)$data['booking_form']['meta']['booking_summary_hide_fee']===0)
		{		
			if($price['initial']['sum'][$netGross]['value']!=0)
			{
				$html.=
				'
					<div>
						<span>'.esc_html__('Initial fee','car-park-booking-system').'</span>
						<span>'.esc_html($price['initial']['sum'][$netGross]['format']).'</span>
					</div>
				';
			}
		}
		
		if($price['booking_extra']['sum'][$netGross]['value']!=0)
		{		
			$html.=
			'
				<div>
					<span>'.esc_html__('Extra options','car-park-booking-system').'</span>
					<span>'.esc_html($price['booking_extra']['sum'][$netGross]['format']).'</span>
				</div>
			';
		}
		
		if(($price['total']['tax']['value']!=0) && ((int)$bookingForm['meta']['booking_summary_display_net_price']===1))
		{
			$html.=
			'
				<div>
					<span>'.esc_html__('Tax','car-park-booking-system').'</span>
					<span>'.esc_html($price['total']['tax']['format']).'</span>
				</div>
			';			  
		}
		
		$html.=
		'
			<div class="cpbs-summary-price-element-total">
				<div class="cpbs-header cpbs-header-style-4">'.esc_html__('Total','car-park-booking-system').'</div>
				<div class="cpbs-header cpbs-header-style-3">'.esc_html($price['total']['sum']['gross']['format']).'</div>
			</div>
		';

		$html=
		'
			<div class="cpbs-summary-price-element">
				'.$html.'
			</div>
		';

		return($html);
	}
	
	/**************************************************************************/
	
	function getLocationPlaceOccupancy($bookingForm)
	{
		global $post;
		
		$dateTime=array();
		$locationPlace=array();
		
		$Booking=new CPBSBooking();
		$Validation=new CPBSValidation();
		
		$data=CPBSHelper::getPostOption();
		$data=CPBSBookingHelper::formatDateTimeToStandard($data,$bookingForm);
		
		if(!$Validation->isDate($data['entry_date'])) return($locationPlace);
		if(!$Validation->isTime($data['entry_time'])) return($locationPlace);
		if(!$Validation->isDate($data['exit_date'])) return($locationPlace);
		if(!$Validation->isTime($data['exit_time'])) return($locationPlace);
		
		$dateTime[0]=strtotime($data['entry_date'].' '.$data['entry_time']);
		$dateTime[1]=strtotime($data['exit_date'].' '.$data['exit_time']);
		
		$argument=array
		(
			'post_type'=>$Booking::getCPTName(),
			'post_status'=>'publish',
			'posts_per_page'=>-1
		);
		
		/***/
		
		$status=CPBSOption::getOption('booking_status_nonblocking');
		if(is_array($status))
		{
			$argument['meta_query'][]=array
			(
				'key'=>PLUGIN_CPBS_CONTEXT.'_booking_status_id',
				'value'=>$status,
				'compare'=>'NOT IN'
			);
		}
		
		/***/
		
		CPBSHelper::preservePost($post,$bPost);

		$query=new WP_Query($argument);
		if($query===false) return($locationPlace);
				
		while($query->have_posts())
		{
			$query->the_post();
			
			$meta=CPBSPostMeta::getPostMeta($post);
			
			$locationId=$meta['location_id'];
			$placeTypeId=$meta['place_type_id'];
		
			$dateTime[2]=strtotime($meta['entry_datetime']);
			$dateTime[3]=strtotime($meta['exit_datetime']);
				
			$b=array_fill(0,4,false);
			
			$b[0]=$dateTime[0]<=$dateTime[2] && $dateTime[1]>=$dateTime[3];			
			$b[1]=$dateTime[0]>=$dateTime[2] && $dateTime[1]<=$dateTime[3];	
			$b[2]=$dateTime[0]>=$dateTime[2] && $dateTime[0]<=$dateTime[3];	
			$b[3]=$dateTime[1]>=$dateTime[2] && $dateTime[1]<=$dateTime[3];
			
			if(in_array(true,$b,true))
			{
				if(!is_array($locationPlace[$locationId]))
					$locationPlace[$locationId]=array();
				
				if(!isset($locationPlace[$locationId][$placeTypeId]))
					$locationPlace[$locationId][$placeTypeId]=0;
				
				$locationPlace[$locationId][$placeTypeId]++;
			}
		}
		
		return($locationPlace);
	}
	
	/**************************************************************************/
	
	function createSummary($data,$bookingForm)
	{
		$response=array(null,null,null);
		
		$Date=new CPBSDate();
		$User=new CPBSUser();
		$Validation=new CPBSValidation();
		$WooCommerce=new CPBSWooCommerce();
		
		/***/
				
		$priceHTML=$this->createSummaryPriceElement($data,$bookingForm);
   
		/***/
		
		$entryDate=$Date->formatDateToDisplay($data['entry_date']);
		$entryTime=$Date->formatTimeToDisplay($data['entry_time']);

		$exitDate=$Date->formatDateToDisplay($data['exit_date']);
		$exitTime=$Date->formatTimeToDisplay($data['exit_time']);
		
		$entryDateTimeHtml=$entryDate.', '.$entryTime;
		$exitDateTimeHtml=$exitDate.', '.$exitTime;
		
		if(!CPBSBookingHelper::enableTimeField($bookingForm))
		{
			$entryDateTimeHtml=$entryDate;
			$exitDateTimeHtml=$exitDate;			
		}
		
		/***/
		
		$userHTML=null;
		if($WooCommerce->isEnable($bookingForm['meta']))
		{
			if($User->isSignIn())
			{
				$userData=$User->getCurrentUserData();
				
				$userHTML=
				'
					<div class="cpbs-header cpbs-header-style-4">'.esc_html__('Logged as','car-park-booking-system').'</div>
					<div>'.esc_html($userData->data->display_name).'</div>
				';
			}
		}
		
		/***/
				
		$clientContactDetailPhoneNumberHTML='-';
		if($Validation->isNotEmpty($data['client_contact_detail_phone_number']))
			$clientContactDetailPhoneNumberHTML=$data['client_contact_detail_phone_number'];
		
		$commentHTML='-';
		if($Validation->isNotEmpty($data['comment']))
			$commentHTML=$data['comment'];		
		
		$clientContactDetailCompanyNameHTML='-';
		if($Validation->isNotEmpty($data['client_billing_detail_company_name']))
			$clientContactDetailCompanyNameHTML=$data['client_billing_detail_company_name'];			
		
		$clientContactDetailTaxNumberHTML='-';
		if($Validation->isNotEmpty($data['client_billing_detail_tax_number']))
			$clientContactDetailTaxNumberHTML=$data['client_billing_detail_tax_number'];			
		
		$clientContactDetailBillingAdressHTML='-';
		if($data['client_billing_detail_enable']==1)
		{		
			$dataAddress=array
			(
				'street'=>$data['client_billing_detail_street_name'],
				'street_number'=>$data['client_billing_detail_street_number'],
				'postcode'=>$data['client_billing_detail_postal_code'],
				'city'=>$data['client_billing_detail_city'],
				'state'=>$data['client_billing_detail_state'],
				'country'=>$data['client_billing_detail_country_code']
			);
			   
			$clientContactDetailBillingAdressHTML=CPBSHelper::displayAddress($dataAddress);
		}
		
		/***/
		
		$paymentNameHTML=esc_html(CPBSBookingHelper::getPaymentName($data['payment_id'],-1,$bookingForm['meta']));
		
		/***/
		
		$locationId=$data['location_id'];
		$locationData=$bookingForm['dictionary']['location'][$locationId];
		
		$locationNameHTML=esc_html($locationData['post']->post_title);
		
		$dataAddress=array
		(
			'street'=>$locationData['meta']['address_street'],
			'street_number'=>$locationData['meta']['address_street_number'],
			'postcode'=>$locationData['meta']['address_postcode'],
			'city'=>$locationData['meta']['address_city'],
			'state'=>$locationData['meta']['address_state'],
			'country'=>$locationData['meta']['address_country']
		);
			   
		$locationAdressHTML=CPBSHelper::displayAddress($dataAddress);		
		
		/***/
		
		$bookingPeriod=CPBSBookingHelper::calculateBookingPeriod($data['entry_date'],$data['entry_time'],$data['exit_date'],$data['exit_time'],$bookingForm);
		$bookingPeriodHTML=esc_html(CPBSBookingHelper::displayBookingPeriod($bookingPeriod));
		
		/***/
		
		switch($data['step_request'])
		{
			case 2:
				
				$response[0]=
				'
					'.$userHTML.'
					<div class="cpbs-header cpbs-header-style-4">'.esc_html__('Booking Dates','car-park-booking-system').'</div>					
					<div class="cpbs-rental-date-box">
						<div>
							<span>'.esc_html__('Entry date','car-park-booking-system').'</span>
							<span>'.$entryDateTimeHtml.'</span>
						</div>
						<div>
							<span>'.esc_html__('Exit date','car-park-booking-system').'</span>
							<span>'.$exitDateTimeHtml.'</span>
						</div>
					</div>
					<div class="cpbs-header cpbs-header-style-4">'.esc_html__('Booking period','car-park-booking-system').'</div>
					<div>'.$bookingPeriodHTML.'</div>
					<div class="cpbs-header cpbs-header-style-4">'.esc_html__('Order summary','car-park-booking-system').'</div>	
					<div class="cpbs-summary-price-element">'.$priceHTML.'</div>
				';	
				
				
				$response[0]='<div class="cpbs-summary-box">'.$response[0].'</div>';
				
			break;
		
			case 3:
				
				$response[0]=
				'
					'.$userHTML.'
					<div class="cpbs-header cpbs-header-style-4">'.esc_html__('Booking Dates','car-park-booking-system').'</div>					
					<div class="cpbs-rental-date-box">
						<div>
							<span>'.esc_html__('Entry date','car-park-booking-system').'</span>
							<span>'.$entryDateTimeHtml.'</span>
						</div>
						<div>
							<span>'.esc_html__('Exit date','car-park-booking-system').'</span>
							<span>'.$exitDateTimeHtml.'</span>
						</div>
					</div>
					<div class="cpbs-header cpbs-header-style-4">'.esc_html__('Booking period','car-park-booking-system').'</div>
					<div>'.$bookingPeriodHTML.'</div>
					<div class="cpbs-header cpbs-header-style-4">'.esc_html__('Order summary','car-park-booking-system').'</div>	
					<div class="cpbs-summary-price-element">'.$priceHTML.'</div>
				';
				
				$response[0]='<div class="cpbs-summary-box">'.$response[0].'</div>';
				
			break;
		
			case 4:
				
				$response[0]=
				'
					<div class="cpbs-header cpbs-header-style-3">'.esc_html__('Customer Details','car-park-booking-system').'</div>
					<div class="cpbs-attribute-field">
						<div class="cpbs-layout-50x50 cpbs-clear-fix">
							<div class="cpbs-layout-column-left">	 
								<div class="cpbs-attribute-field-name">'.esc_html__('First name','car-park-booking-system').'</div>
								<div class="cpbs-attribute-field-value">'.esc_html($data['client_contact_detail_first_name']).'</div>							
							</div>
							<div class="cpbs-layout-column-right">	 
								<div class="cpbs-attribute-field-name">'.esc_html__('Last name','car-park-booking-system').'</div>
								<div class="cpbs-attribute-field-value">'.esc_html($data['client_contact_detail_last_name']).'</div>								
							</div>						
						</div>
					</div>
					<div class="cpbs-attribute-field">
						<div class="cpbs-layout-50x50 cpbs-clear-fix">
							<div class="cpbs-layout-column-left">	 
								<div class="cpbs-attribute-field-name">'.esc_html__('E-mail address','car-park-booking-system').'</div>
								<div class="cpbs-attribute-field-value">'.esc_html($data['client_contact_detail_email_address']).'</div>							
							</div>
							<div class="cpbs-layout-column-right">	 
								<div class="cpbs-attribute-field-name">'.esc_html__('Phone number','car-park-booking-system').'</div>
								<div class="cpbs-attribute-field-value">'.esc_html($clientContactDetailPhoneNumberHTML).'</div>								
							</div>						
						</div>
					</div>
					<div class="cpbs-attribute-field">
						<div class="cpbs-clear-fix">
							<div class="cpbs-attribute-field-name">'.esc_html__('Comments','car-park-booking-system').'</div>
							<div class="cpbs-attribute-field-value">'.esc_html($commentHTML).'</div>							
						</div>
					</div>					
				';
				
				if($data['client_billing_detail_enable']==1)
				{
					$response[0].=
					'
						<div class="cpbs-header cpbs-header-style-3">'.esc_html__('Billing Details','car-park-booking-system').'</div>	
						<div class="cpbs-attribute-field">
							<div class="cpbs-layout-50x50 cpbs-clear-fix">
								<div class="cpbs-layout-column-left">	 
									<div class="cpbs-attribute-field-name">'.esc_html__('Company registered name','car-park-booking-system').'</div>
									<div class="cpbs-attribute-field-value">'.esc_html($clientContactDetailCompanyNameHTML).'</div>							
								</div>
								<div class="cpbs-layout-column-right">	 
									<div class="cpbs-attribute-field-name">'.esc_html__('Tax number','car-park-booking-system').'</div>
									<div class="cpbs-attribute-field-value">'.esc_html($clientContactDetailTaxNumberHTML).'</div>								
								</div>						
							</div>
						</div>
						<div class="cpbs-attribute-field">
							<div class="cpbs-clear-fix">
								<div class="cpbs-attribute-field-name">'.esc_html__('Billing Address','car-park-booking-system').'</div>
								<div class="cpbs-attribute-field-value">'.$clientContactDetailBillingAdressHTML.'</div>							
							</div>
						</div>	
					';
				}
				
				if($Validation->isNotEmpty($paymentNameHTML))
				{
					$response[0].=
					'
						<div class="cpbs-header cpbs-header-style-3">'.esc_html__('Payment Method','car-park-booking-system').'</div>	
						<div class="cpbs-attribute-field">
							<div class="cpbs-clear-fix">
								<div class="cpbs-attribute-field-name">'.esc_html__('Selected payment method','car-park-booking-system').'</div>
								<div class="cpbs-attribute-field-value">'.$paymentNameHTML.'</div>							
							</div>
						</div>							
					';
				}
				
				/***/
				
				$googleMapPeriodHTML=null;
				
				$rentalDateBoxHTML=
				'
					<div class="cpbs-rental-date-box">
						<div>
							<span>'.esc_html__('Entry date','car-park-booking-system').'</span>
							<span>'.$entryDateTimeHtml.'</span>
						</div>
						<div>
							<span>'.esc_html__('Exit date','car-park-booking-system').'</span>
							<span>'.$exitDateTimeHtml.'</span>
						</div>
					</div>
				';
				
				if((int)$bookingForm['google_map_enable']===1)
				{
					$googleMapPeriodHTML=
					'
						<div class="cpbs-layout-50x50">
							<div class="cpbs-layout-column-left">
								<div class="cpbs-google-map-summary"></div>
							</div>
							<div class="cpbs-layout-column-right">
								'.$rentalDateBoxHTML.'
							</div>							
						</div>						
					';
				}
				else
				{
					$googleMapPeriodHTML=
					'
						<div>
							'.$rentalDateBoxHTML.'
						</div>						
					';					
				}
						
				
				/***/
				
				$response[1].=
				'
					<div class="cpbs-header cpbs-header-style-3">'.$locationNameHTML.'</div>	
					<div class="cpbs-attribute-field">
						<div class="cpbs-clear-fix">
							<div class="cpbs-attribute-field-value">'.$locationAdressHTML.'</div>							
						</div>
					</div>
					<div class="cpbs-clear-fix cpbs-margin-top-30">
						'.$googleMapPeriodHTML.'
					</div>
					<div class="cpbs-header cpbs-header-style-3 cpbs-margin-top-40">'.esc_html__('Order summary','car-park-booking-system').'</div>
				';
				
				if((int)$bookingForm['meta']['coupon_enable']===1)
				{
					$response[1].=
					'
						<div class="cpbs-clear-fix cpbs-coupon-code-section">
							<div class="cpbs-form-field">
								<label>'.esc_html__('Do you have a discount code?','car-park-booking-system').'</label>
								<input maxlength="32" name="'.CPBSHelper::getFormName('coupon_code',false).'" value="" type="text">
							</div>
							<a href="#" class="cpbs-button cpbs-button-style-1">
								'.esc_html__('Apply code','car-park-booking-system').'
							</a>
						</div>
					';
				}	
				
				$response[1].=
				'
					<div class="cpbs-summary-price-element">'.$priceHTML.'</div>
				';
			
			break;
		}
		
		return($response);
	}
	
	/**************************************************************************/ 
	
	function createPlace($data,&$priceToSort)
	{
		$html=null;
		
		$PlaceType=new CPBSPlaceType();
		$LengthUnit=new CPBSLengthUnit();
		$Validation=new CPBSValidation();
		
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
		
		$price=$PlaceType->calculatePrice($argument);
		
		/***/
		
		$placeTypeId=$data['place_type_id'];
		$placeTypeData=$data['booking_form']['dictionary']['place_type'][$placeTypeId];
		
		$locationId=$data['location_id'];
		$locationData=$data['booking_form']['dictionary']['location'][$locationId];
		
		/***/
		
		$thumbnail=get_the_post_thumbnail_url($placeTypeId,PLUGIN_CPBS_CONTEXT.'_place_type');
		$thumbnailHTML=null;
		
		if($thumbnail!==false)
			$thumbnailHTML='<img src="'.esc_url($thumbnail).'" alt=""/>';		
		
		/***/
		
		$buttonLabel=esc_html__('Select','car-park-booking-system');
		$buttonClass=array('cpbs-button','cpbs-button-style-1','cpbs-place-select-button');
		
		$placeTypeIdSelected=(int)$this->getSelectedPlaceTypeId($data['booking_form']);
		
		$placeAvailable=(int)$data['booking_form']['dictionary']['location_place'][$locationId][$placeTypeId]['place_free'];
		$placeAvailableCheckEnable=(int)$data['booking_form']['dictionary']['location'][$locationId]['meta']['place_type_availability_check_enable'];
				
		if(($placeAvailableCheckEnable===1) && ($placeAvailable===0))
		{
			array_push($buttonClass,'cpbs-state-disabled');
			$buttonLabel=esc_html__('Sold Out','car-park-booking-system');
		}
		else
		{
			if($placeTypeIdSelected===$placeTypeId)
				array_push($buttonClass,'cpbs-state-selected');
		}
		
		/***/
		
		$width=$LengthUnit->convertLengthUnit($placeTypeData['meta']['dimension_width'],1,CPBSOption::getOption('length_unit'));
		$length=$LengthUnit->convertLengthUnit($placeTypeData['meta']['dimension_length'],1,CPBSOption::getOption('length_unit'));	
		
		/***/
		
		$moreDetailsHtml=null;
		if(in_array(3,$data['booking_form']['meta']['location_detail_window_open_action']))
			$moreDetailsHtml='&nbsp;&nbsp;&nbsp;<a href="#">'.esc_html__('More details','car-park-booking-system').'</a>';
		
		/***/
		
		$attributeHtml=array(null,null);
		
		if((int)$data['booking_form']['meta']['car_park_space_type_list_space_dimension_enable']===1)
		{
			$attributeHtml[0]=
			'
				<div class="cpbs-place-attribute-1">
					<div class="cpbs-attribute-field">
						<div class="cpbs-attribute-field-name">'.esc_html__('Parking space','car-park-booking-system').'</div>
						<div class="cpbs-attribute-field-value">'.sprintf(esc_html__('%sx%s %s','car-park-booking-system'),$width,$length,$LengthUnit->getLengthUnitShortName(CPBSOption::getOption('length_unit'))).'</div>
					</div>
				</div>			
			';
		}
		
		if((int)$data['booking_form']['meta']['car_park_space_type_list_space_number_available_enable']===1)
		{
			$attributeHtml[1]=
			'
				<div class="cpbs-place-attribute-2">
					<div class="cpbs-attribute-field">
						<div class="cpbs-attribute-field-name">'.esc_html__('Spaces available','car-park-booking-system').'</div>
						<div class="cpbs-attribute-field-value">'.sprintf(esc_html__('%s of %s available','car-park-booking-system'),$data['booking_form']['dictionary']['location_place'][$locationId][$placeTypeId]['place_free'],$data['booking_form']['dictionary']['location_place'][$locationId][$placeTypeId]['place_all']).'</div>
					</div>
				</div>			
			';
		}
		
		/***/
		
		$placeTypeDescriptionHtml=get_the_content(null,null,$data['place_type_id']);
		
		if($Validation->isNotEmpty($placeTypeDescriptionHtml))
		{
			$placeTypeDescriptionHtml='<div'.CPBSHelper::createCSSClassAttribute(array('cpbs-place-layout-column-right-line-bottom')).'>'.apply_filters('the_content',$placeTypeDescriptionHtml).'</div>';
		}
		
		/***/
		
		$html=
		'
			<div'.CPBSHelper::createCSSClassAttribute(array('cpbs-place')).' data_location_id="'.esc_attr($locationId).'" data-place_type_id="'.esc_attr($placeTypeId).'">
				
				<div'.CPBSHelper::createCSSClassAttribute(array('cpbs-place-layout-column-left')).'>
					<div'.CPBSHelper::createCSSClassAttribute(array('cpbs-place-image')).'>
						'.$thumbnailHTML.'
					</div>
				</div>

				<div'.CPBSHelper::createCSSClassAttribute(array('cpbs-place-layout-column-right')).'>

					<div'.CPBSHelper::createCSSClassAttribute(array('cpbs-place-layout-column-right-line-top')).'>
						
						<div>
							<div'.CPBSHelper::createCSSClassAttribute(array('cpbs-header','cpbs-header-style-3','cpbs-place-name')).'>'.esc_html($placeTypeData['post']->post_title).'</div>
							<div'.CPBSHelper::createCSSClassAttribute(array('cpbs-place-location-name')).'>'.esc_html($locationData['post']->post_title).$moreDetailsHtml.'</div>
						</div>
						
						<div>
							<div'.CPBSHelper::createCSSClassAttribute(array('cpbs-header','cpbs-header-style-2','cpbs-place-price')).'>
								'.esc_html($price['price']['sum']['gross']['format']).'
							</div>
						</div>

					</div>
					
					<div class="testt">
					<div'.CPBSHelper::createCSSClassAttribute(array('cpbs-place-layout-column-right-line-middle')).'>
						
						'.$attributeHtml[0].'
						
						'.$attributeHtml[1].'
						
						<div>
							<a'.CPBSHelper::createCSSClassAttribute($buttonClass).' href="#">'.esc_html($buttonLabel).'</a>
						</div>

					</div>
					
					'.$placeTypeDescriptionHtml.'
					</div>
				</div>

			</div>
		';
		
		 $priceToSort=$price['price']['sum']['gross']['value'];
		
		return($html);
	}
	
	/**************************************************************************/
	
	static function getLocationId($data,$bookingForm)
	{
		CPBSHelper::removeUIndex($data,'location_id');
		
		$locationId=(int)$data['location_id'];
		
		if(!array_key_exists($locationId,$bookingForm['dictionary']['location']))
			$locationId=0;
		
		if(!CPBSBookingHelper::enableSelectLocation($bookingForm))
			$locationId=key($bookingForm['dictionary']['location']);
		
		return($locationId);
	}
	
	/**************************************************************************/
	
	function createBookingExtra($data,$bookingForm)
	{
		$html=null;
		
		$Validation=new CPBSValidation();
		$BookingExtra=new CPBSBookingExtra();

		$locationId=self::getLocationId($data,$bookingForm);
		
		$bookingExtraId=preg_split('/,/',$data['booking_extra_id']);
		
		if(count($bookingForm['dictionary']['booking_extra']))
		{
			foreach($bookingForm['dictionary']['booking_extra'] as $index=>$value)
			{
				$quantityFieldName=CPBSHelper::getFormName('booking_extra_'.$index.'_quantity',false);
				
				$quantityFieldValue=$BookingExtra->validateQuantity($data,$bookingForm,$index,$value);
				
				$quantityFieldClass=array('cpbs-quantity');
				
				if(!in_array($index,$bookingExtraId))
					array_push($quantityFieldClass,'cpbs-state-disabled');
				if((int)$value['meta']['quantity_readonly_enable']===1)
					array_push($quantityFieldClass,'cpbs-state-readonly');
				
				/***/
				
				$price=$BookingExtra->calculatePrice($value,$bookingForm['dictionary']['tax_rate'],$bookingForm['dictionary']['location']);
				
				$priceLocation=array();
				foreach($price as $priceIndex=>$priceValue)
				{
					$priceLocation[$priceIndex]=array
					(
						'enable'=>$priceValue['enable'],
						'price_gross'=>$priceValue['price']['gross']['value'],
						'price_gross_format'=>$priceValue['price']['gross']['format'].' '.$priceValue['suffix'],
					);
				}
				
				$priceHTML=null;
				if(array_key_exists($locationId,$priceLocation)) $priceHTML=$priceLocation[$locationId]['price_gross_format'];
				
				/***/
				
				$buttonClass=array('cpbs-button','cpbs-button-style-1');
				
				if((int)$value['meta']['button_select_default_state']==1)
					array_push($buttonClass,'cpbs-state-selected');
				if((int)$value['meta']['button_select_default_state']==2)
					array_push($buttonClass,'cpbs-state-selected','cpbs-state-selected-mandatory');				
				if(in_array($index,$bookingExtraId))
					array_push($buttonClass,'cpbs-state-selected');
				
				array_unique($buttonClass);
				
				/***/
				
				$bookingExtraClass=array();
				
				if((int)$priceLocation[$locationId]['enable']!==1) array_push($bookingExtraClass,'cpbs-hidden');
				
				/***/

				$quantityHTML=
				'
					<div '.CPBSHelper::createCSSClassAttribute($quantityFieldClass).' data-default="'.esc_attr($value['meta']['quantity_default']).'" data-min="'.esc_attr($value['meta']['quantity_minimum']).'" data-max="'.esc_attr($value['meta']['quantity_maximum']).'">
						<a href="#" class="cpbs-quantity-minus">'.esc_html__('-','car-park-booking-system').'</a>
						<input type="text" maxlength="4" name="'.esc_attr($quantityFieldName).'" value="'.esc_attr($quantityFieldValue).'">
						<a href="#" class="cpbs-quantity-plus">'.esc_html__('+','car-park-booking-system').'</a>
						<span></span>
					</div>
				';
				
				/***/
				
				$descriptionHTML=null;
				
				if($Validation->isNotEmpty($value['meta']['description']))
					$descriptionHTML='<p class="cpbs-booking-extra-description">'.esc_html($value['meta']['description']).'</p>';
				
				/***/
				
				$html.=
				'
					<li'.CPBSHelper::createCSSClassAttribute($bookingExtraClass).' data-id="'.esc_attr($index).'" data-location=\''.json_encode($priceLocation).'\'>
						<div>
							<div class="cpbs-header cpbs-header-style-4 cpbs-booking-extra-name">'.get_the_title($index).'</div>
							<div class="cpbs-header cpbs-header-style-4 cpbs-booking-extra-price">'.esc_html($priceHTML).'</div>
							'.$descriptionHTML.'
						</div>
						<div>
							'.$quantityHTML.'
						</div>
						<div>
							<a href="#"'.CPBSHelper::createCSSClassAttribute($buttonClass).'>'.esc_html__('Select','car-park-booking-system').'</a>
						</div>
					</li>
				';
			}
		}
		
		if(!is_null($html))
		{
			$html=
			'
				<div class="cpbs-header cpbs-header-style-3">
					'.esc_html__('Add-on options','car-park-booking-system').'
				</div>	
				<div class="cpbs-booking-extra-list">
					<ul class="cpbs-list-reset">
						'.$html.'
					</ul>
				</div>
			';
		}
		
		return($html);
	}
	
	/**************************************************************************/
	
	function createPayment($data,$payment,$paymentWooCommerce,$paymentIdSelected,$locationMeta)
	{
		$html=null;
		
		$Payment=new CPBSPayment();
		$Validation=new CPBSValidation();
		
		$paymentMain=count($paymentWooCommerce) ? $paymentWooCommerce : $payment;
		
		if(!count($paymentMain)) return($html);
		
		if(!count($paymentWooCommerce))
		{
			if(!$Payment->isPayment($paymentIdSelected))
				$paymentIdSelected=$locationMeta['payment_default_id'];
		}
		
		foreach($paymentMain as $index=>$value)
		{		
			$class=array('cpbs-form-checkbox');

			if($paymentIdSelected==$index)
				array_push($class,'cpbs-state-selected');
				
			$html.=
			'
				<li>
					<span'.CPBSHelper::createCSSClassAttribute($class).' data-group="payment" data-value="'.esc_attr($index).'">
						<span class="cpbs-meta-icon-tick"></span>
					</span>
					<input type="hidden" data-rel-field="'.CPBSHelper::getFormName('payment_id',false).'" value="'.esc_attr($paymentIdSelected==$index ? $index : 0).'"/>
			';
			
			if(count($paymentWooCommerce))
			{
				$html.=
				'
					<div class="cpbs-header cpbs-header-style-4">'.esc_html($value->{'method_title'}).'</div>
				';
			}
			else
			{
				if($Validation->isNotEmpty($locationMeta['payment_'.$value[1].'_logo_src']))
				{
					$html.=
					'
						<img src="'.esc_attr($locationMeta['payment_'.$value[1].'_logo_src']).'" alt="">				
					';
				}
				else
				{
					$html.=
					'
						<div class="cpbs-header cpbs-header-style-4">'.esc_html($value[0]).'</div>				
					';
				}				
			}
			
			$html.=
			'
				</li>
			';
		}
		
		$html=
		'
			<div class="cpbs-header cpbs-header-style-3">'.esc_html__('Payment Method','car-park-booking-system').'</div>
				
			<ul class="cpbs-payment cpbs-list-reset">
				'.$html.'
			</ul>
		';
		
		return($html);
	}
	
	/**************************************************************************/
	
	function locationPlaceFilter($ajax=true,$bookingForm=null)
	{		   
		if(!is_bool($ajax)) $ajax=true;
		
		$html=null;
		$response=array();
		
		$Validation=new CPBSValidation();
		
		$data=CPBSHelper::getPostOption();
		$data=CPBSBookingHelper::formatDateTimeToStandard($data,$bookingForm);
		
		if(is_null($bookingForm))
		{
			if(!is_array($bookingForm=$this->checkBookingForm($data['booking_form_id'])))
			{
				if(!$ajax) return(false);

				$this->setErrorGlobal($response,esc_html__('There are no car park spaces which match your filter criteria.','car-park-booking-system'));
				CPBSHelper::createJSONResponse($response);
			}
		}
		
		$placeHTML=array();
		$placePrice=array();
		
		$locationId=$this->getLocationId($data,$bookingForm);
		
		foreach($bookingForm['dictionary']['location_place'] as $aIndex=>$aValue)
		{
			if($locationId!=$aIndex) continue;
			
			foreach($aValue as $bIndex=>$bValue)
			{
				// argument
				$argument=array
				(
					'booking_form_id'=>$bookingForm['post']->ID,
					'booking_form'=>$bookingForm,
					'place_type_id'=>$bIndex,
					'location_id'=>$aIndex,
					'entry_date'=>$data['entry_date'],
					'entry_time'=>$data['entry_time'],
					'exit_date'=>$data['exit_date'],
					'exit_time'=>$data['exit_time'],
				);

				$price=0;

				$placeHTML[$aIndex.'_'.$bIndex]=$this->createPlace($argument,$price);
				$placePrice[$aIndex.'_'.$bIndex]=$price;
			}
		}
	
		if(in_array((int)$bookingForm['meta']['place_sorting_type'],array(1,2)))
		{
			asort($placePrice);		 
			if((int)$bookingForm['meta']['place_sorting_type']===2)
				$placePrice=array_reverse($placePrice,true);
		}
	
		foreach($placePrice as $index=>$value)
			$html.='<li>'.$placeHTML[$index].'</li>';
		
		$html=
		'
			<div'.CPBSHelper::createCSSClassAttribute(array('cpbs-header','cpbs-header-style-3')).'>'.esc_html__('Parking Space','car-park-booking-system').'</div>
			<div>'.sprintf(esc_html__('%s Results Found','car-park-booking-system'),count($placeHTML)).'</div>
			<ul class="cpbs-list-reset">
				'.$html.'
			</ul>
		';
		
		$response['html']=$html;
		
		if($Validation->isEmpty($html))
		{
			if($ajax)
			{
				$this->setErrorGlobal($response,esc_html__('There are no car park spaces which match your filter criteria.','car-park-booking-system'));
				CPBSHelper::createJSONResponse($response);
			}
		}
		
		if(!$ajax) return($html);
		
		CPBSHelper::createJSONResponse($response);
	}
	
	/**************************************************************************/
	
	function checkCouponCode()
	{		
		$response=array();
		
		$data=CPBSHelper::getPostOption();
		
		if(!is_array($bookingForm=$this->checkBookingForm($data['booking_form_id'])))
		{
			$response['html']=null;
			CPBSHelper::createJSONResponse($response);
		}
		
		$data['location_id']=$bookingForm['location_id'];
		$data=CPBSBookingHelper::formatDateTimeToStandard($data,$bookingForm);
		
		$response['html']=$this->createSummaryPriceElement($data,$bookingForm);
		
		$Coupon=new CPBSCoupon();
		$coupon=$Coupon->checkCode();
		
		$response['error']=$coupon===false ? 1 : 0;
		
		if($response['error']===1)
		   $response['message']=esc_html__('Provided coupon is invalid.','car-park-booking-system'); 
		else 
			$response['message']=esc_html__('Provided coupon is valid. Discount has been granted.','car-park-booking-system');
		
		CPBSHelper::createJSONResponse($response);
	}
	
	/**************************************************************************/   
   
	function createClientFormSignIn($bookingForm)
	{
		$User=new CPBSUser();
		$WooCommerce=new CPBSWooCommerce();
		
		if(!$WooCommerce->isEnable($bookingForm['meta'])) return;
		if($User->isSignIn()) return;
		
		if((int)$bookingForm['meta']['woocommerce_account_enable_type']===0) return;
		
		$data=CPBSHelper::getPostOption();
		
		$html=
		'
			<div class="cpbs-client-form-sign-in">

				<div class="cpbs-form-panel">

					<div class="cpbs-header cpbs-header-style-3">'.esc_html__('Sign In','car-park-booking-system').'</div>

					<div class="cpbs-form-panel-content cpbs-clear-fix">					

						<div class="cpbs-clear-fix">
							<div class="cpbs-form-field cpbs-form-field-width-50">
								<label>'.esc_html__('Login *','car-park-booking-system').'</label>
								<input type="text" name="'.CPBSHelper::getFormName('client_sign_in_login',false).'" value=""/>
							</div>
							<div class="cpbs-form-field cpbs-form-field-width-50">
								<label>'.esc_html__('Password *','car-park-booking-system').'</label>
								<input type="password" name="'.CPBSHelper::getFormName('client_sign_in_password',false).'" value=""/>
							</div>
						</div>

					</div>
				</div>
			
				<div class="cpbs-clear-fix cpbs-float-right">

				   <a href="#" class="cpbs-button cpbs-button-style-2 cpbs-button-sign-up">
						'.esc_html__('Don\'t Have an Account?','car-park-booking-system').'
				   </a> 

				   <a href="#" class="cpbs-button cpbs-button-style-1 cpbs-button-sign-in">
					   '.esc_html__('Sign In','car-park-booking-system').'
				   </a> 

				   <input type="hidden" name="'.CPBSHelper::getFormName('client_account',false).'" value="'.(int)$data['client_account'].'"/> 

				</div>

			</div>
		';
		
		return($html);
	}
	
	/**************************************************************************/
	
	function createClientFormSignUp($bookingForm,$userData=array())
	{
		$User=new CPBSUser();
		$WooCommerce=new CPBSWooCommerce();
		$BookingFormElement=new CPBSBookingFormElement();
		
		/***/
		
		$data=CPBSHelper::getPostOption();
		if(count($userData)) $data=$userData;

		/***/
		
		$html=null;
		$htmlElement=array(null,null,null,null,null,null);
		
		$htmlElementCountry=null;
		
		foreach($bookingForm['dictionary']['country'] as $index=>$value)
			$htmlElementCountry.='<option value="'.esc_attr($index).'" '.($data['client_billing_detail_country_code']==$index ? 'selected' : null).'>'.esc_html($value[0]).'</option>';
		
		$htmlElement[1]=$BookingFormElement->createField(1,$bookingForm['meta']);
		
		$htmlElement[2]=$BookingFormElement->createField(2,$bookingForm['meta']);
		
		$panel=$BookingFormElement->getPanel($bookingForm['meta']);
		foreach($panel as $index=>$value)
		{
			if(in_array($value['id'],array(1,2))) continue;
			$htmlElement[3].=$BookingFormElement->createField($value['id'],$bookingForm['meta']);
		}
		
		if($WooCommerce->isEnable($bookingForm['meta']))
		{
			if(!$User->isSignIn())
			{
				if(in_array((int)$bookingForm['meta']['woocommerce_account_enable_type'],array(1,2)))
				{
					$class=array(array('cpbs-form-checkbox'),array('cpbs-disable-section'));
					
					if(in_array((int)$bookingForm['meta']['woocommerce_account_enable_type'],array(2)))
					{
						
					}
					else
					{
						if((int)$data['client_sign_up_enable']===1)
						{
							array_push($class[1],'cpbs-hidden');
							array_push($class[0],'cpbs-state-selected');
						}
						else
						{
							
						}
					}			
					
					$htmlElement[4].=
					'
						<div class="cpbs-form-panel">
					';
					
					if(in_array((int)$bookingForm['meta']['woocommerce_account_enable_type'],array(2)))
					{
						unset($class[1][0]);
						$htmlElement[4].='<div class="cpbs-header cpbs-header-style-3">'.esc_html__('New account','car-park-booking-system').'</div>';
					}
					else
					{
						$htmlElement[4].=
						'
							<div>
								<span'.CPBSHelper::createCSSClassAttribute($class[0]).' data-value="1">
									<span class="cpbs-meta-icon-tick"></span>
								</span>
								<input type="hidden" name="'.CPBSHelper::getFormName('client_sign_up_enable',false).'" value="'.esc_attr((int)$data['client_sign_up_enable']).'"/> 
								<div class="cpbs-header cpbs-header-style-3">'.esc_html__('Create an Account?','car-park-booking-system').'</div>
							</div>
						';						
					}					
	
					$htmlElement[4].=
					'
							<div class="cpbs-form-panel-content cpbs-clear-fix">			   

								<div>

									<div class="cpbs-clear-fix">
										<div class="cpbs-form-field cpbs-form-field-width-33">
											<label>'.esc_html__('Login','car-park-booking-system').'</label>
											<input type="text" name="'.CPBSHelper::getFormName('client_sign_up_login',false).'"/>
										</div>
										<div class="cpbs-form-field cpbs-form-field-width-33">
											<label>
												'.esc_html__('Password','car-park-booking-system').'
												&nbsp;
												<a href="#" class="cpbs-sign-up-password-generate">'.esc_html__('Generate','car-park-booking-system').'</a>
												<a href="#" class="cpbs-sign-up-password-show">'.esc_html__('Show','car-park-booking-system').'</a>
											</label>
											<input type="password" name="'.CPBSHelper::getFormName('client_sign_up_password',false).'"/>
										</div>
										<div class="cpbs-form-field cpbs-form-field-width-33">
											<label>'.esc_html__('Re-type password','car-park-booking-system').'</label>
											<input type="password" name="'.CPBSHelper::getFormName('client_sign_up_password_retype',false).'"/>
										</div>
									</div>

								</div>

								<div'.CPBSHelper::createCSSClassAttribute($class[1]).'></div>

							</div>

						</div>
					';
				}
			}
		}
		
		/***/
		
		$class=array(array('cpbs-client-form-sign-up','cpbs-hidden'),array('cpbs-form-checkbox'),array('cpbs-disable-section'));
		
		if($WooCommerce->isEnable($bookingForm['meta']))
		{
			if(($User->isSignIn()) || ((int)$data['client_account']===1) || ((int)$bookingForm['meta']['woocommerce_account_enable_type']===0)) unset($class[0][1]);
		}  
		else unset($class[0][1]);
		
		if((int)$bookingForm['meta']['billing_detail_state']===3)
		{
			$data['client_billing_detail_enable']=1;
			array_push($class[1],'cpbs-state-selected-mandatory');
		}
		elseif((int)$bookingForm['meta']['billing_detail_state']===2)
		{
			if(!array_key_exists('client_billing_detail_enable',$data))
				$data['client_billing_detail_enable']=1;
		}
		
		if((int)$data['client_billing_detail_enable']===1)
		{
			array_push($class[1],'cpbs-state-selected');
			array_push($class[2],'cpbs-hidden');
		}
		
		$html=
		'
			<div'.CPBSHelper::createCSSClassAttribute($class[0]).'>

				<div class="cpbs-form-panel">
 
					<div class="cpbs-header cpbs-header-style-3">'.esc_html__('Customer Details','car-park-booking-system').'</div>

					<div class="cpbs-form-panel-content cpbs-clear-fix">

						<div class="cpbs-clear-fix">
							<div class="cpbs-form-field cpbs-form-field-width-50">
								<label>'.esc_html__('First name *','car-park-booking-system').'</label>
								<input type="text" name="'.CPBSHelper::getFormName('client_contact_detail_first_name',false).'" value="'.esc_attr($data['client_contact_detail_first_name']).'"/>
							</div>
							<div class="cpbs-form-field cpbs-form-field-width-50">
								<label>'.esc_html__('Last name *','car-park-booking-system').'</label>
								<input type="text" name="'.CPBSHelper::getFormName('client_contact_detail_last_name',false).'" value="'.esc_attr($data['client_contact_detail_last_name']).'"/>
							</div>
						</div>

						<div class="cpbs-clear-fix">
							<div class="cpbs-form-field cpbs-form-field-width-50">
								<label>'.esc_html__('E-mail address *','car-park-booking-system').'</label>
								<input type="text" name="'.CPBSHelper::getFormName('client_contact_detail_email_address',false).'"  value="'.esc_attr($data['client_contact_detail_email_address']).'"/>
							</div>
							<div class="cpbs-form-field cpbs-form-field-width-50">
								<label>'.esc_html__('Phone number','car-park-booking-system').(in_array('client_contact_detail_phone_number',$bookingForm['meta']['field_mandatory']) ? ' *' : '').'</label>
								<input type="text" name="'.CPBSHelper::getFormName('client_contact_detail_phone_number',false).'"  value="'.esc_attr($data['client_contact_detail_phone_number']).'"/>
							</div>
						</div>

						'.$htmlElement[5].'

						<div class="cpbs-clear-fix">
							<div class="cpbs-form-field">
								<label>'.esc_html__('Comments','car-park-booking-system').'</label>
								<textarea name="'.CPBSHelper::getFormName('comment',false).'">'.esc_html($data['comment']).'</textarea>
							</div>
						</div>

						'.$htmlElement[1].'
													  
					</div>
					
				</div>
				
				'.$htmlElement[4].'
		';
		
		/***/
		
		if((int)$bookingForm['meta']['billing_detail_state']===4) return($html.$htmlElement[3].'</div>');
		
		/***/
		
		$html.=
		'      
				<div class="cpbs-form-panel">
 
					<div>
						<span'.CPBSHelper::createCSSClassAttribute($class[1]).' data-value="1">
							<span class="cpbs-meta-icon-tick"></span>
						</span>
						<input type="hidden" name="'.CPBSHelper::getFormName('client_billing_detail_enable',false).'" value="'.esc_attr((int)$data['client_billing_detail_enable']).'"/> 
						<div class="cpbs-header cpbs-header-style-3">'.esc_html__('Billing Address','car-park-booking-system').'</div>
					</div>

					<div class="cpbs-form-panel-content cpbs-clear-fix">

						<div class="cpbs-clear-fix">
							<div class="cpbs-form-field cpbs-form-field-width-50">
								<label>'.esc_html__('Company registered name','car-park-booking-system').(in_array('client_billing_detail_company_name',$bookingForm['meta']['field_mandatory']) ? ' *' : '').'</label>
								<input type="text" name="'.CPBSHelper::getFormName('client_billing_detail_company_name',false).'" value="'.esc_attr($data['client_billing_detail_company_name']).'"/>
							</div>
							<div class="cpbs-form-field cpbs-form-field-width-50">
								<label>'.esc_html__('Tax number','car-park-booking-system').(in_array('client_billing_detail_tax_number',$bookingForm['meta']['field_mandatory']) ? ' *' : '').'</label>
								<input type="text" name="'.CPBSHelper::getFormName('client_billing_detail_tax_number',false).'" value="'.esc_attr($data['client_billing_detail_tax_number']).'"/>
							</div>
						</div>

						<div class="cpbs-clear-fix">
							<div class="cpbs-form-field cpbs-form-field-width-33">
								<label>'.esc_html__('Street','car-park-booking-system').(in_array('client_billing_detail_street_name',$bookingForm['meta']['field_mandatory']) ? ' *' : '').'</label>
								<input type="text" name="'.CPBSHelper::getFormName('client_billing_detail_street_name',false).'" value="'.esc_attr($data['client_billing_detail_street_name']).'"/>
							</div>
							<div class="cpbs-form-field cpbs-form-field-width-33">
								<label>'.esc_html__('Street number','car-park-booking-system').(in_array('client_billing_detail_street_number',$bookingForm['meta']['field_mandatory']) ? ' *' : '').'</label>
								<input type="text" name="'.CPBSHelper::getFormName('client_billing_detail_street_number',false).'" value="'.esc_attr($data['client_billing_detail_street_number']).'"/>
							</div>
							<div class="cpbs-form-field cpbs-form-field-width-33">
								<label>'.esc_html__('City','car-park-booking-system').(in_array('client_billing_detail_city',$bookingForm['meta']['field_mandatory']) ? ' *' : '').'</label>
								<input type="text" name="'.CPBSHelper::getFormName('client_billing_detail_city',false).'" value="'.esc_attr($data['client_billing_detail_city']).'"/>
							</div>					
						</div>

						<div class="cpbs-clear-fix">
							<div class="cpbs-form-field cpbs-form-field-width-33">
								<label>'.esc_html__('State','car-park-booking-system').(in_array('client_billing_detail_state',$bookingForm['meta']['field_mandatory']) ? ' *' : '').'</label>
								<input type="text" name="'.CPBSHelper::getFormName('client_billing_detail_state',false).'" value="'.esc_attr($data['client_billing_detail_state']).'"/>
							</div>
							<div class="cpbs-form-field cpbs-form-field-width-33">
								<label>'.esc_html__('Postal code','car-park-booking-system').(in_array('client_billing_detail_postal_code',$bookingForm['meta']['field_mandatory']) ? ' *' : '').'</label>
								<input type="text" name="'.CPBSHelper::getFormName('client_billing_detail_postal_code',false).'" value="'.esc_attr($data['client_billing_detail_postal_code']).'"/>
							</div>
							<div class="cpbs-form-field cpbs-form-field-width-33">
								<label>'.esc_html__('Country','car-park-booking-system').(in_array('client_billing_detail_country_code',$bookingForm['meta']['field_mandatory']) ? ' *' : '').'</label>
								<select name="'.CPBSHelper::getFormName('client_billing_detail_country_code',false).'" value="'.esc_attr($data['client_billing_detail_country_code']).'">
								'.$htmlElementCountry.'
								</select>
							</div>					
						</div>  

						'.$htmlElement[2].'
							
						<div'.CPBSHelper::createCSSClassAttribute($class[2]).'></div>
					
					</div>
					
				</div>
				
				'.$htmlElement[3].'
				
			</div>
		';
		
		return($html);
	}
	
	/**************************************************************************/
	
	function userSignIn()
	{
		$data=CPBSHelper::getPostOption();
		
		$response=array('user_sign_in'=>0);
		
		if(!is_array($bookingForm=$this->checkBookingForm($data['booking_form_id'])))
		{
			$this->setErrorGlobal($response,esc_html__('Login error.','car-park-booking-system'));
			CPBSHelper::createJSONResponse($response);
		}
		
		$data=CPBSBookingHelper::formatDateTimeToStandard($data,$bookingForm);
		
		$User=new CPBSUser();
		$WooCommerce=new CPBSWooCommerce();
		
		if(!$User->signIn($data['client_sign_in_login'],$data['client_sign_in_password']))
			$this->setErrorGlobal($response,esc_html__('Login error.','car-park-booking-system'));
		else 
		{
			$userData=$WooCommerce->getUserData();
			
			$response['user_sign_in']=1;  
			
			$response['summary']=$this->createSummary($data,$bookingForm);
			$response['client_form_sign_up']=$this->createClientFormSignUp($bookingForm,$userData);
		}
		
		CPBSHelper::createJSONResponse($response);
	}
	
	/**************************************************************************/
	
	function getBookingFormBusinessHour($businessHourMeta,$type=1)
	{
		$Date=new CPBSDate();
		
		$businessHour=array();
		
		/***/
		
		foreach($businessHourMeta as $index=>$value)
		{
			if(!array_key_exists('hour_type',$value)) $businessHourMeta[$index]['hour_type']=1;
			
			if((int)$businessHourMeta[$index]['hour_type']!==1)
			{
				if((int)$businessHourMeta[$index]['hour_type']!==$type)
					unset($businessHourMeta[$index]);
			}
		}
		
		/***/
		
		foreach($businessHourMeta as $value)
		{
			$index=$value['period_type']===0 ? $value['date'] : $value['day_number'];
			$businessHour[$index]['time'][]=array('time_start'=>$value['time_start'],'time_stop'=>$value['time_stop']);
		}
		
		/***/
		
		foreach($businessHour as $businessHourIndex=>$businessHourValue)
		{
			$time=$businessHourValue['time'];
			
			$businessHour[$businessHourIndex]['timestamp_list']=array();
			
			foreach($time as $timeIndex=>$timeValue)
			{
				for($i=0;$i<2;$i++)
				{
					$found=false;
					$index=($i==0 ? 'time_start' : 'time_stop');
				
					foreach($time as $timeIndex2=>$timeValue2)
					{
						if($timeIndex==$timeIndex2) continue;
						if($Date->timeInRange($timeValue[$index],$timeValue2['time_start'],$timeValue2['time_stop'])) 
						{
							$found=true;
							break;
						}
					}

					if(!$found) $businessHour[$businessHourIndex]['timestamp_list'][]=strtotime($timeValue[$index]);
				}
			}
			
			sort($businessHour[$businessHourIndex]['timestamp_list']);
			
			foreach($businessHour[$businessHourIndex]['timestamp_list'] as $value)
				$businessHour[$businessHourIndex]['time_list'][]=date('H:i',$value);
			
			$j=0;
			$count=0;
			
			if(is_array($businessHour[$businessHourIndex]['time_list']))
				$count=count($businessHour[$businessHourIndex]['time_list']);
			
			for($i=0;$i<$count;$i+=2)
			{
				$businessHour[$businessHourIndex]['time_range'][$j]['start']=$businessHour[$businessHourIndex]['time_list'][$i];
				$businessHour[$businessHourIndex]['time_range'][$j]['stop']=$businessHour[$businessHourIndex]['time_list'][$i+1];

				$j++;
			}
		}
		
		$data=array();
		foreach($businessHour as $index=>$value)
			$data['available'][$index]=$value['time_range'];
		
		if((array_key_exists('available',$data)) && (is_array($data['available'])))
		{
			foreach($data['available'] as $dataIndex=>$dataValue)
			{
				$j=0;
				$start='00:00';

				if(is_array($dataValue))
				{
					foreach($dataValue as $index=>$value)
					{
						$data['unavailable'][$dataIndex][$j]['start']=$start;
						$data['unavailable'][$dataIndex][$j]['stop']=$value['start'];

						$start=$value['stop'];

						$j++;
					}
				}

				$data['unavailable'][$dataIndex][$j]['start']=$start;
				$data['unavailable'][$dataIndex][$j]['stop']='24:00';		
			}
		}

		return($data);
	}
	
	/**************************************************************************/
	
	function getBookingFormEntryPeriod($locationMeta,$bookingFormMeta)
	{
		$date=array();

		$Date=new CPBSDate();
		$Validation=new CPBSValidation();

		$type=array(1=>'days',2=>'hours',3=>'minutes');

		/***/

		$timeStart=date_i18n('G:i');
		$dateStart=date_i18n('d-m-Y');
		
		$dateTimeStart=$dateStart.' '.$timeStart;
		
		$dayNumber=$Date->getDayNumberOfWeek($dateTimeStart);
		
		$businessHour=$this->getBookingFormBusinessHour($locationMeta['business_hour']);
		
		for($i=1;$i<=7;$i++)
		{		
			$businessHourStart=null;
			$businessHourStop=null;
			
			if(isset($businessHour['available'][$dayNumber]))
			{
				$count=count($businessHour['available'][$dayNumber]);
				$businessHourStart=$businessHour['available'][$dayNumber][0]['start'];
				$businessHourStop=$businessHour['available'][$dayNumber][$count-1]['stop'];
			}
			
			if(($Validation->isNotEmpty($businessHourStart)) && ($Validation->isNotEmpty($businessHourStop)))
			{
				if(($i===1) && ($Date->timeInRange($timeStart,$businessHourStart,$businessHourStop)))
				{
					break;
				}
				else
				{					
					$dateTimeStart=date('d-m-Y',strtotime($dateStart.' +'.($i-1).' day')).' '.$businessHourStart;
					break;
				}
			}
			
			$dayNumber++;
			if($dayNumber===7) $dayNumber=1;
		}
		
		$dateStart=$dateTimeStart;
		
		/***/
		
		$step=$bookingFormMeta['timepicker_step'];
		
		if((int)$bookingFormMeta['timepicker_today_start_time_type']===2)
		{
			if($step<=0) $step=1;

			$i=0;
			while(1)
			{
				$dateTemp=strtotime($dateStart.' '.$i.' minute');
				$minute=date_i18n('i',$dateTemp);
				if($minute%$step==0) break;
				$i++;
			}
			
			$dateTemp=date_i18n('d-m-Y H:i:s',$dateTemp);
		}
		else $dateTemp=$dateStart;
		
		/***/
		
		$dateStart=strtotime($dateTemp.' + '.(int)$locationMeta['entry_period_from'].' '.$type[(int)$locationMeta['entry_period_type']]);
		$dateStart=date_i18n('d-m-Y H:i:s',$dateStart);
		
		/***/

		if($Validation->isEmpty($locationMeta['entry_period_to'])) $dateStop=null;
		else $dateStop=strtotime($dateStart.' + '.(int)$locationMeta['entry_period_to'].' '.$type[(int)$locationMeta['entry_period_type']]);

		/***/

		$date['min']=$dateStart;
		$date['max']=is_null($dateStop) ? null : date_i18n('d-m-Y H:i:s',$dateStop);

		return($date);
	}

	/**************************************************************************/

	function getDateEntryPeriod($data,$location,$delta)
	{
		$date=array();
		$type='entry';

		if((int)$location['meta']['entry_period_type']===1)
		{
			$date[0]=$data[$type.'_date'];
			$date[1]=date_i18n('d-m-Y',CPBSDate::strtotime('+'.$delta.' days'));
		}
		elseif((int)$location['meta']['entry_period_type']===2)
		{
			$date[0]=$data[$type.'_date'].' '.$data[$type.'_time'];
			$date[1]=date_i18n('d-m-Y H:i',CPBSDate::strtotime('+'.$delta.' hours'));                            
		}
		elseif((int)$location['meta']['entry_period_type']===3)
		{
			$date[0]=$data[$type.'_date'].' '.$data[$type.'_time'];
			$date[1]=date_i18n('d-m-Y H:i',CPBSDate::strtotime('+'.$delta.' minutes'));                            
		} 

		return($date);
	}
	
	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/