<?php

/******************************************************************************/
/******************************************************************************/

class CPBSPlaceType
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
		return(PLUGIN_CPBS_CONTEXT.'_place_type');
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
					'name'=>esc_html__('Space Type','car-park-booking-system'),
					'singular_name'=>esc_html__('Space Types','car-park-booking-system'),
					'add_new'=>esc_html__('Add New','car-park-booking-system'),
					'add_new_item'=>esc_html__('Add New Space Type','car-park-booking-system'),
					'edit_item'=>esc_html__('Edit Space Type','car-park-booking-system'),
					'new_item'=>esc_html__('New Space Type','car-park-booking-system'),
					'all_items'=>esc_html__('Space Types','car-park-booking-system'),
					'view_item'=>esc_html__('View Space Type','car-park-booking-system'),
					'search_items'=>esc_html__('Search Space Types','car-park-booking-system'),
					'not_found'=>esc_html__('No Space Types Found','car-park-booking-system'),
					'not_found_in_trash'=>esc_html__('No Space Types in Trash','car-park-booking-system'),
					'parent_item_colon'=>'',
					'menu_name'=>esc_html__('Space Types','car-park-booking-system')
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
		add_filter('postbox_classes_'.self::getCPTName().'_cpbs_meta_box_place_type',array($this,'adminCreateMetaBoxClass'));
		
		add_filter('manage_edit-'.self::getCPTName().'_columns',array($this,'manageEditColumns')); 
		add_action('manage_'.self::getCPTName().'_posts_custom_column',array($this,'managePostsCustomColumn'));
		add_filter('manage_edit-'.self::getCPTName().'_sortable_columns',array($this,'manageEditSortableColumns'));
	}

	/**************************************************************************/
	
	function addMetaBox()
	{
		add_meta_box(PLUGIN_CPBS_CONTEXT.'_meta_box_place_type',esc_html__('Main','car-park-booking-system'),array($this,'addMetaBoxMain'),self::getCPTName(),'normal','low');		
	}
	
	/**************************************************************************/
	
	function addMetaBoxMain()
	{
		global $post;
		
		$TaxRate=new CPBSTaxRate();
		$IconFeature=new CPBSIconFeature();
		
		$data=array();
		
		$data['meta']=CPBSPostMeta::getPostMeta($post);
		
		$data['dictionary']['tax_rate']=$TaxRate->getDictionary();
		$data['dictionary']['icon_feature']=$IconFeature->getIcon();
		
		$data['nonce']=CPBSHelper::createNonceField(PLUGIN_CPBS_CONTEXT.'_meta_box_place_type');
		
		$Template=new CPBSTemplate($data,PLUGIN_CPBS_TEMPLATE_PATH.'admin/meta_box_place_type.php');
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
		$TaxRate=new CPBSTaxRate();
		$PriceRule=new CPBSPriceRule();
		$IconFeature=new CPBSIconFeature();
		$BookingFormStyle=new CPBSBookingFormStyle();
		
		CPBSHelper::setDefault($meta,'dimension_width','');
		CPBSHelper::setDefault($meta,'dimension_length','');
		
		CPBSHelper::setDefault($meta,'icon',$IconFeature->getDefaultIcon());
		CPBSHelper::setDefault($meta,'color',$BookingFormStyle->getDefaultColor());
		
		foreach($PriceRule->getPriceUseType() as $index=>$value)
		{
			CPBSHelper::setDefault($meta,'price_'.$index.'_value','0.00');
			CPBSHelper::setDefault($meta,'price_'.$index.'_tax_rate_id',$TaxRate->getDefaultTaxPostId());   
		}
	}
	
	/**************************************************************************/
	
	function savePost($postId)
	{	  
		if(!$_POST) return(false);
		
		if(CPBSHelper::checkSavePost($postId,PLUGIN_CPBS_CONTEXT.'_meta_box_place_type_noncename','savePost')===false) return(false);
		
		$TaxRate=new CPBSTaxRate();
		$PriceRule=new CPBSPriceRule();
		$LengthUnit=new CPBSLengthUnit();
		$Validation=new CPBSValidation();
		$IconFeature=new CPBSIconFeature();
		$BookingFormStyle=new CPBSBookingFormStyle();
		
		$option=CPBSHelper::getPostOption();
		
		if(!$Validation->isFloat($option['dimension_width'],0.00,999999999.99))
			$option['dimension_width']=1.00;
		if(!$Validation->isFloat($option['dimension_length'],0.00,999999999.99))
			$option['dimension_length']=1.00;

		if(!$IconFeature->isIcon($option['icon']))
			$option['icon']=$IconFeature->getDefaultIcon();
		if(!$Validation->isColor($option['color'],true))
			$option['color']=$BookingFormStyle->getDefaultColor();
		
		/***/
		
		foreach($PriceRule->getPriceUseType() as $index=>$value)
		{
			if(!$Validation->isPrice($option['price_'.$index.'_value'],false))
				$option['price_'.$index.'_value']=0.00;
			if(!$TaxRate->isTaxRate($option['price_'.$index.'_tax_rate_id']))
				$option['price_'.$index.'_tax_rate_id']=0; 
			
			$option['price_'.$index.'_value']=CPBSPrice::formatToSave($option['price_'.$index.'_value']);
		}
		
		$option['dimension_width']=preg_replace('/,/','.',$option['dimension_width']);
		$option['dimension_length']=preg_replace('/,/','.',$option['dimension_length']);
		
		$option['dimension_width']=$LengthUnit->convertLengthUnit($option['dimension_width'],CPBSOption::getOption('length_unit'),1);
		$option['dimension_length']=$LengthUnit->convertLengthUnit($option['dimension_length'],CPBSOption::getOption('length_unit'),1);

		$field=array
		(
			'dimension_width',
			'dimension_length',
			'icon',
			'color'
		);
		
	   foreach($PriceRule->getPriceUseType() as $index=>$value)
			array_push($field,'price_'.$index.'_value','price_'.$index.'_tax_rate_id');

		foreach($field as $value)
			CPBSPostMeta::updatePostMeta($postId,$value,$option[$value]);	
	}
	
	/**************************************************************************/
	
	function getDictionary($attr=array(),$sortingType=1)
	{
		global $post;
		
		$dictionary=array();
		
		$default=array
		(
			'place_type_id'=>0
		);
		
		$attribute=shortcode_atts($default,$attr);
		CPBSHelper::preservePost($post,$bPost);
		
		$argument=array
		(
			'post_type'=>self::getCPTName(),
			'post_status'=>'publish',
			'posts_per_page'=>-1
		);
		
		$orderby=array('menu_order'=>'asc','title'=>'asc');
		
		if((int)$sortingType===4) $orderby['menu_order']='desc';
		
		$argument['orderby']=$orderby;
		
		if($attribute['place_type_id'])
			$argument['p']=$attribute['place_type_id'];

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
			'thumbnail'=>esc_html__('Thumbnail','car-park-booking-system'),
			'dimension'=>esc_html__('Dimension','car-park-booking-system'),
			'price'=>esc_html__('Prices','car-park-booking-system')
		);
   
		return($column);		  
	}
	
	/**************************************************************************/
	
	function managePostsCustomColumn($column)
	{
		global $post;
		
		$meta=CPBSPostMeta::getPostMeta($post);
		
		$PriceRule=new CPBSPriceRule();
		$LengthUnit=new CPBSLengthUnit();
		
		switch($column) 
		{
			case 'thumbnail':
				
				echo get_the_post_thumbnail($post,array(200,133));
				
			break;			
				
			case 'dimension':
				
				$width=$LengthUnit->convertLengthUnit($meta['dimension_width'],1,CPBSOption::getOption('length_unit'));
				$length=$LengthUnit->convertLengthUnit($meta['dimension_length'],1,CPBSOption::getOption('length_unit'));
				
				echo esc_html(sprintf(__('%sx%s %s','car-park-booking-system'),$width,$length,$LengthUnit->getLengthUnitShortName(CPBSOption::getOption('length_unit'))));
				
			break;
		
			case 'price':
				
				echo 
				'
					<table class="to-table-post-list">
				';
				
				foreach($PriceRule->getPriceUseType() as $index=>$value)
				{
					echo 
					'
						<tr>
							<td>'.esc_html($value[0]).'</td>
							<td>'.CPBSPrice::format($meta['price_'.$index.'_value'],CPBSOption::getOption('currency')).'</td>
						</tr>	
					';
				}
				
				echo
				'
					</table>
				';
				
			break;
		}
	}
	
	/**************************************************************************/
	
	function manageEditSortableColumns($column)
	{
		return($column);	   
	}
	
	/**************************************************************************/
	
	function calculatePrice($data,&$discountPercentage=0,$calculateHiddenFee=true)
	{	
		$Currency=new CPBSCurrency();
		$PriceRule=new CPBSPriceRule();
		
		/***/
		
		$placeTypeId=$data['place_type_id'];
		
		$priceBase=$PriceRule->extractPriceFromData(array(),$data['booking_form']['dictionary']['place_type'][$placeTypeId]['meta']);
		
		// argument
		$argument=array
		(
			'booking_form_id'=>(int)$data['booking_form_id'],
			'booking_form'=>$data['booking_form'],
			'place_type_id'=>$data['place_type_id'],
			'location_id'=>$data['location_id'],
			'entry_date'=>$data['entry_date'],
			'entry_time'=>$data['entry_time'],
			'exit_date'=>$data['exit_date'],
			'exit_time'=>$data['exit_time'],
		);
			
		$priceBase=$PriceRule->getPriceFromRule($argument,$priceBase);
		
		/***/
		
		$currency=$Currency->getCurrency(CPBSCurrency::getFormCurrency());
		
		$rate=CPBSCurrency::getExchangeRate(); 
		foreach($priceBase as $index=>$value)
		{
			if(preg_match('/\_value$/',$index,$result))
				$priceBase[$index]=CPBSPrice::formatToSave($priceBase[$index])*$rate;
		} 
				
		/***/
  
		$price=array();
		
		$period=CPBSBookingHelper::calculateBookingPeriod($data['entry_date'],$data['entry_time'],$data['exit_date'],$data['exit_time'],$data['booking_form']);

		/***/
		
		$Coupon=new CPBSCoupon();
		$coupon=$Coupon->checkCode();
		
		if($coupon!==false)
		{
			$discountPercentage=$coupon['meta']['discount_percentage'];
			$discountFixed=$coupon['meta']['discount_fixed'];
			
			if(in_array(CPBSOption::getOption('billing_type'),array(3,6)))
			{
				if(array_key_exists('discount_rental_day_count',$coupon['meta']))
				{
					if(is_array($coupon['meta']['discount_rental_day_count']))
					{
						foreach($coupon['meta']['discount_rental_day_count'] as $index=>$value)
						{
							if((($value['start']<=$period['day']) && ($value['stop']>=$period['day'])))
							{
								if($value['discount_percentage']>0)
								{
									$discountPercentage=$value['discount_percentage'];
								}
								elseif($value['discount_fixed']>0)
								{
									$discountPercentage=0;
									$discountFixed=$value['discount_fixed'];
								}
								
								break;
							}
						}
					}
				}
			}
			
			if($discountPercentage==0)
			{
				if($discountFixed>0)
				{
					$discountPercentage=$Coupon->calculateDiscountPercentage($discountFixed,$period['day'],$period['hour'],$period['minute'],$priceBase['price_rental_day_value'],$priceBase['price_rental_hour_value'],$priceBase['price_rental_minute_value']);
				}
			}
			
			$priceBase['price_initial_value']=CPBSPrice::formatToSave($priceBase['price_initial_value']*(1-$discountPercentage/100));
			$priceBase['price_rental_day_value']=CPBSPrice::formatToSave($priceBase['price_rental_day_value']*(1-$discountPercentage/100));
			$priceBase['price_rental_hour_value']=CPBSPrice::formatToSave($priceBase['price_rental_hour_value']*(1-$discountPercentage/100));
			$priceBase['price_rental_minute_value']=CPBSPrice::formatToSave($priceBase['price_rental_minute_value']*(1-$discountPercentage/100));
		}
		
		/***/
		
		$sumNetPerDay=$priceBase['price_rental_day_value']*$period['day'];
		$sumNetPerHour=$priceBase['price_rental_hour_value']*$period['hour'];
		$sumNetPerMinute=$priceBase['price_rental_minute_value']*$period['minute'];
		
		$price['price']['sum']['net']['value']=$sumNetPerDay+$sumNetPerHour+$sumNetPerMinute;
		$price['price']['sum']['net']['format']=CPBSPrice::format($price['price']['sum']['net']['value'],CPBSCurrency::getFormCurrency());
		
		$price['price']['sum']['gross']['value']=CPBSPrice::calculateGross($sumNetPerDay,$priceBase['price_rental_day_tax_rate_id'])+CPBSPrice::calculateGross($sumNetPerHour,$priceBase['price_rental_hour_tax_rate_id'])+CPBSPrice::calculateGross($sumNetPerMinute,$priceBase['price_rental_minute_tax_rate_id']);  
		$price['price']['sum']['gross']['format']=CPBSPrice::format($price['price']['sum']['gross']['value'],CPBSCurrency::getFormCurrency());
		
		/***/

		$price['price']['initial']['net']['value']=$priceBase['price_initial_value'];
		$price['price']['initial']['net']['format']=CPBSPrice::format($price['price']['initial']['net']['value'],CPBSCurrency::getFormCurrency());
		$price['price']['initial']['gross']['value']=CPBSPrice::calculateGross($price['price']['initial']['net']['value'],$priceBase['price_initial_tax_rate_id']);  
		$price['price']['initial']['gross']['format']=CPBSPrice::format($price['price']['initial']['gross']['value'],CPBSCurrency::getFormCurrency());

		/***/
		
		$price['currency']=$currency;

		/***/
	   
		if(((int)$data['booking_form']['meta']['booking_summary_hide_fee']===1) && ($calculateHiddenFee))
		{
			$Booking=new CPBSBooking();
			$priceBooking=$Booking->calculatePrice($data,$price,true);
			
			$price['price']['sum']['gross']['value']=number_format($priceBooking['place']['sum']['gross']['value'],2,'.','');
			$price['price']['sum']['net']['value']=number_format($priceBooking['place']['sum']['net']['value'],2,'.','');
			
			$price['price']['sum']['gross']['format']=CPBSPrice::format($price['price']['sum']['gross']['value'],CPBSCurrency::getFormCurrency());
			$price['price']['sum']['net']['format']=CPBSPrice::format($price['price']['sum']['net']['value'],CPBSCurrency::getFormCurrency());
		}
		
		/***/
		
		$price['price']['base']=$priceBase;
		
		return($price);
	}
	
	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/