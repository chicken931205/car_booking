<?php

/******************************************************************************/
/******************************************************************************/

class CPBSBookingExtra
{
	/**************************************************************************/
	
	function __construct()
	{
		$this->priceType=array
		(
			1=>array(esc_html__('Price per entire rental period','car-park-booking-system')),
			2=>array(esc_html__('Price per single quantity','car-park-booking-system'))
		);
	}
	
	/**************************************************************************/
	
	public function getPriceType()
	{
		return($this->priceType);
	}
	
	/**************************************************************************/
	
	public function isPriceType($piceTypeId)
	{
		return(array_key_exists($piceTypeId,$this->priceType) ? true : false);
	}
	
	/**************************************************************************/
	
	public function getPriceTypeName($piceTypeId)
	{
		if(!$this->isPriceType($piceTypeId)) return('');
		return($this->priceType[$piceTypeId][0]);
	}
		
	/**************************************************************************/
	
	public function init()
	{
		$this->registerCPT();
	}
	
	/**************************************************************************/

	public static function getCPTName()
	{
		return(PLUGIN_CPBS_CONTEXT.'_booking_extra');
	}
	
	/**************************************************************************/
	
	public static function getCPTCategoryName()
	{
		return(self::getCPTName().'_c');
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
					'name'=>esc_html__('Booking Extras','car-park-booking-system'),
					'singular_name'=>esc_html__('Booking Extra','car-park-booking-system'),
					'add_new'=>esc_html__('Add New','car-park-booking-system'),
					'add_new_item'=>esc_html__('Add New Booking Add-on','car-park-booking-system'),
					'edit_item'=>esc_html__('Edit Booking Extra','car-park-booking-system'),
					'new_item'=>esc_html__('New Booking Extra','car-park-booking-system'),
					'all_items'=>esc_html__('Booking Extras','car-park-booking-system'),
					'view_item'=>esc_html__('View Booking Extra','car-park-booking-system'),
					'search_items'=>esc_html__('Search Booking Extras','car-park-booking-system'),
					'not_found'=>esc_html__('No Booking Extras Found','car-park-booking-system'),
					'not_found_in_trash'=>esc_html__('No Booking Extras Found in Trash','car-park-booking-system'),
					'parent_item_colon'=>'',
					'menu_name'=>esc_html__('Booking Extras','car-park-booking-system')
				),
				'public'=>false,
				'show_ui'=>true,
				'show_in_menu'=>'edit.php?post_type='.CPBSBooking::getCPTName(),
				'capability_type'=>'post',
				'menu_position'=>2,
				'hierarchical'=>false,
				'rewrite'=>false,
				'supports'=>array('title','page-attributes')
			)
		);
		
		add_action('save_post',array($this,'savePost'));
		add_action('add_meta_boxes_'.self::getCPTName(),array($this,'addMetaBox'));
		add_filter('postbox_classes_'.self::getCPTName().'_cpbs_meta_box_booking_extra',array($this,'adminCreateMetaBoxClass'));
		
		add_filter('manage_edit-'.self::getCPTName().'_columns',array($this,'manageEditColumns')); 
		add_action('manage_'.self::getCPTName().'_posts_custom_column',array($this,'managePostsCustomColumn'));
		add_filter('manage_edit-'.self::getCPTName().'_sortable_columns',array($this,'manageEditSortableColumns'));
	}

	/**************************************************************************/
	
	function addMetaBox()
	{
		add_meta_box(PLUGIN_CPBS_CONTEXT.'_meta_box_booking_extra',esc_html__('Main','car-park-booking-system'),array($this,'addMetaBoxMain'),self::getCPTName(),'normal','low');		
	}
	
	/**************************************************************************/
	
	function addMetaBoxMain()
	{
		global $post;
		
		$data=array();
		
		$TaxRate=new CPBSTaxRate();
		$Location=new CPBSLocation();
		
		$data['meta']=CPBSPostMeta::getPostMeta($post);
		
		$data['nonce']=CPBSHelper::createNonceField(PLUGIN_CPBS_CONTEXT.'_meta_box_booking_extra');
		
		$data['dictionary']['tax_rate']=$TaxRate->getDictionary();
		$data['dictionary']['location']=$Location->getDictionary();
		$data['dictionary']['price_type']=$this->getPriceType();
		
		$Template=new CPBSTemplate($data,PLUGIN_CPBS_TEMPLATE_PATH.'admin/meta_box_booking_extra.php');
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
		$Location=new CPBSLocation();
		
		CPBSHelper::setDefault($meta,'location_id',array());
		
		CPBSHelper::setDefault($meta,'description','');
		
		CPBSHelper::setDefault($meta,'quantity_minimum','1');
		CPBSHelper::setDefault($meta,'quantity_default','1');
		CPBSHelper::setDefault($meta,'quantity_maximum','9999');
		CPBSHelper::setDefault($meta,'quantity_equal_rental_day_number',0);
		CPBSHelper::setDefault($meta,'quantity_readonly_enable',0);
		
		CPBSHelper::setDefault($meta,'button_select_default_state',0);
		
		CPBSHelper::setDefault($meta,'price','0.00');
		CPBSHelper::setDefault($meta,'tax_rate_id',$TaxRate->getDefaultTaxPostId());
		CPBSHelper::setDefault($meta,'price_type',1);
		
		$dictionary=CPBSGlobalData::setGlobalData('location_dictionary',array($Location,'getDictionary'));
		
		foreach($dictionary as $index=>$value)
		{
			if(isset($meta['location'][$index])) continue;
			
			$meta['location'][$index]['enable']=1;
			$meta['location'][$index]['price']='';
			$meta['location'][$index]['tax_rate_id']=-1;
		}
	}
	
	/**************************************************************************/
	
	function savePost($postId)
	{	  
		if(!$_POST) return(false);
		
		if(CPBSHelper::checkSavePost($postId,PLUGIN_CPBS_CONTEXT.'_meta_box_booking_extra_noncename','savePost')===false) return(false);
		
		$TaxRate=new CPBSTaxRate();
		$Location=new CPBSLocation();
		$Validation=new CPBSValidation();
		
		$option=CPBSHelper::getPostOption();
	  
		/***/
   
		if(!$Validation->isNumber($option['quantity_minimum'],1,9999))
			$option['quantity_minimum']=1;
		if(!$Validation->isNumber($option['quantity_default'],1,9999))
			$option['quantity_default']=1;	
		if(!$Validation->isNumber($option['quantity_maximum'],1,9999))
			$option['quantity_maximum']=9999;			
		
		if($option['quantity_minimum']>$option['quantity_maximum'])
			$option['quantity_minimum']=1;
		if(!(($option['quantity_default']>$option['quantity_minimum']) && ($option['quantity_default']<$option['quantity_maximum'])))
			$option['quantity_default']=$option['quantity_minimum'];
		
		if(!$Validation->isBool($option['quantity_equal_rental_day_number']))
			$option['quantity_equal_rental_day_number']=0;		
		if(!$Validation->isBool($option['quantity_readonly_enable']))
			$option['quantity_readonly_enable']=0;		
		
		/***/
		
		if(!in_array($option['button_select_default_state'],array(0,1,2)))
			$option['button_select_default_state']=0;
		
		/***/

		if(!$Validation->isPrice($option['price'],false))
		   $option['price']=0.00;  
		if(!$TaxRate->isTaxRate($option['tax_rate_id']))
			$option['tax_rate_id']=0;
		if(!$this->isPriceType($option['price_type']))
			$option['price_type']=1;		
		
		/***/
		
		$key=array
		(
			'description',
			'quantity_minimum',
			'quantity_default',
			'quantity_maximum',
			'quantity_equal_rental_day_number',
			'quantity_readonly_enable',
			'button_select_default_state',
			'price',
			'tax_rate_id',
			'price_type'
		);
		
		foreach($key as $value)
			CPBSPostMeta::updatePostMeta($postId,$value,$option[$value]);
		
		/***/
		
		$location=array();
		$locationDictionary=$Location->getDictionary();
		
		foreach($locationDictionary as $index=>$value)
		{
			if(!isset($option['location'][$index])) continue;
			
			if(!$Validation->isBool($option['location'][$index]['enable']))
				$option['location'][$index]['enable']=0;
			
			if(!$Validation->isPrice($option['location'][$index]['price'],false))
				$option['location'][$index]['price']='';
			
			if(!$TaxRate->isTaxRate($option['location'][$index]['tax_rate_id']))
				$option['location'][$index]['tax_rate_id']=0;
			
			$location[$index]=array
			(
				'enable'=>$option['location'][$index]['enable'],
				'price'=>$option['location'][$index]['price'],
				'tax_rate_id'=>$option['location'][$index]['tax_rate_id']
			);
		}
		
		CPBSPostMeta::updatePostMeta($postId,'location',$location);
	}
	
	/**************************************************************************/
	
	function getDictionary($attr=array())
	{
		global $post;
		
		$dictionary=array();
		
		$default=array
		(
			'booking_extra_id'=>0,
			'category_id'=>array()
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
		
		if($attribute['booking_extra_id'])
			$argument['p']=$attribute['booking_extra_id'];

		if(!is_array($attribute['category_id']))
			$attribute['category_id']=array($attribute['category_id']);

		if(array_sum($attribute['category_id']))
		{
			$argument['tax_query']=array
			(
				array
				(
					'taxonomy'=>self::getCPTCategoryName(),
					'field'=>'term_id',
					'terms'=>$attribute['category_id'],
					'operator'=>'IN'
				)
			);
		}

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
	
	function calculatePrice($bookingExtra,$taxRate,$location)
	{
		$Currency=new CPBSCurrency();
		$Validation=new CPBSValidation();
		
		/***/
	
		$price=array();
		$currency=$Currency->getCurrency(CPBSCurrency::getFormCurrency());
		
		/***/
		
		foreach($location as $locationIndex=>$locationValue)
		{
			$priceNetValue=$bookingExtra['meta']['price'];
			$taxRateId=$bookingExtra['meta']['tax_rate_id'];
			
			if(array_key_exists($locationIndex,$bookingExtra['meta']['location']))
			{
				if($Validation->isPrice($bookingExtra['meta']['location'][$locationIndex]['price']))
					$priceNetValue=$bookingExtra['meta']['location'][$locationIndex]['price'];
				if(array_key_exists($bookingExtra['meta']['location'][$locationIndex]['tax_rate_id'],$taxRate))
					$taxRateId=$bookingExtra['meta']['location'][$locationIndex]['tax_rate_id'];
			}
			
			$taxRateValue=0;
			if(isset($taxRate[$taxRateId]))
				$taxRateValue=$taxRate[$taxRateId]['meta']['tax_rate_value'];		
			
			/***/
			
			$priceNetValue=number_format($priceNetValue*CPBSCurrency::getExchangeRate(),2,'.',''); 
			$priceGrossValue=CPBSPrice::calculateGross($priceNetValue,$taxRateId);

			$sumNetValue=$priceNetValue;
			$sumGrossValue=$priceGrossValue;

			$priceGrossFormat=CPBSPrice::format($priceGrossValue,CPBSCurrency::getFormCurrency());
			$sumGrossFormat=CPBSPrice::format($sumGrossValue,CPBSCurrency::getFormCurrency());

			$priceNetValue=number_format($priceNetValue,2,'.','');
			$priceGrossValue=number_format($priceGrossValue,2,'.','');	   
				
			/***/
			
			$suffix=null;

			if((int)$bookingExtra['meta']['price_type']==1)
			{
				$suffix=esc_html__(' per entire period','car-park-booking-system');
			}
			else 
			{
				$suffix=esc_html__(' per quantity','car-park-booking-system'); 
			}
			
			/***/
		
			$price[$locationIndex]=array
			(
				'price'=>array
				(
					'net'=>array
					(
						'value'=>$priceNetValue,
					),
					'gross'=>array
					(
						'value'=>$priceGrossValue,
						'format'=>$priceGrossFormat
					)
				),
				'sum'=>array
				(
					'net'=>array
					(
						'value'=>$sumNetValue,
					),
					'gross'=>array
					(
						'value'=>$sumGrossValue,
						'format'=>$sumGrossFormat
					)
				),
				'tax_rate_id'=>$taxRateId,
				'enable'=>$bookingExtra['meta']['location'][$locationIndex]['enable'],
				'suffix'=>$suffix,
				'currency'=>$currency
			);
		}
		
		/***/
		
		return($price);
	}
	
	/**************************************************************************/
	
	function validateQuantity($data,$bookingForm,$bookingExtraId,$bookingExtra)
	{
		$Validation=new CPBSValidation();
		
		$name='booking_extra_'.$bookingExtraId.'_quantity';
		
		$quantity=1;
		
		if(in_array(CPBSOption::getOption('billing_type'),array(3,6)))
		{
			if((int)$bookingExtra['meta']['quantity_equal_rental_day_number']===1)
			{
				$period=CPBSBookingHelper::calculateBookingPeriod($data['entry_date'],$data['entry_time'],$data['exit_date'],$data['exit_time'],$bookingForm);
				
				$quantity=$period['day'];
				
				if((int)$bookingExtra['meta']['quantity_readonly_enable']===1) return($quantity);
			}
		}
		
		if(array_key_exists($name,$data)) $quantity=(int)$data[$name];
		
		if(!$Validation->isNumber($quantity,1,9999)) $quantity=(int)$bookingExtra['meta']['quantity_default'];
		
		if(!(($quantity>=$bookingExtra['meta']['quantity_minimum']) && ($quantity<=$bookingExtra['meta']['quantity_maximum'])))
			$quantity=(int)$bookingExtra['meta']['quantity_default'];
		
		return($quantity);
	}
	
	/**************************************************************************/
	
	function validate($data,$bookingForm,$taxRateDictionary)
	{
		$bookingExtraDictionary=$bookingForm['dictionary']['booking_extra'];
		
		$bookingExtra=array();
		$bookingExtraId=preg_split('/,/',$data['booking_extra_id']);
		
		foreach($bookingExtraDictionary as $index=>$value)
		{
			if((int)$value['meta']['button_select_default_state']===2)
				array_push($bookingExtraId,$index);
		}
		
		$bookingExtraId=array_unique($bookingExtraId,SORT_NUMERIC);
		$locationId=CPBSBookingForm::getLocationId($data,$bookingForm);
		
		foreach($bookingExtraId as $value)
		{
			if(array_key_exists($value,$bookingExtraDictionary))
			{
				if(!array_key_exists('booking_extra_'.$value.'_quantity',$data)) continue;
				
				$quantity=$this->validateQuantity($data,$bookingForm,$value,$bookingExtraDictionary[$value]);
		
				/***/
				
				$priceLocation=$this->calculatePrice($bookingExtraDictionary[$value],$bookingForm['dictionary']['tax_rate'],$bookingForm['dictionary']['location']);

				$price=$priceLocation[$locationId]['price']['net']['value'];
				$taxRateId=$priceLocation[$locationId]['tax_rate_id'];
				
				/***/
				
				if(CPBSCurrency::getBaseCurrency()!=CPBSCurrency::getFormCurrency())
				{				
					$rate=0;
					$dictionary=CPBSOption::getOption('currency_exchange_rate');
					
					if(array_key_exists(CPBSCurrency::getFormCurrency(),$dictionary))
						$rate=$dictionary[CPBSCurrency::getFormCurrency()];

					$price*=$rate;
				}
				
				/***/
				
				$sumNet=$price*$quantity;
				
				if($bookingExtraDictionary[$value]['meta']['price_type']==3)
				{
					$period=CPBSBookingHelper::calculateBookingPeriod($data['entry_date'],$data['entry_time'],$data['exit_date'],$data['exit_time'],$bookingForm,CPBSOption::getOption('billing_type'));
					$sumNet*=$period['day'];
				}
				
				$taxValue=0;
				if(isset($taxRateDictionary[$taxRateId]))
					$taxValue=$taxRateDictionary[$taxRateId]['meta']['tax_rate_value'];

				/***/
				
				$sumGross=CPBSPrice::calculateGross($sumNet,0,$taxValue);
				
				array_push($bookingExtra,array
				(
					'id'=>$value,
					'name'=>$bookingExtraDictionary[$value]['post']->post_title,
					'price'=>$price,
					'price_gross'=>CPBSPrice::calculateGross($price,$taxRateId),
					'price_type'=>$bookingExtraDictionary[$value]['meta']['price_type'],
					'quantity'=>$quantity,
					'tax_rate_value'=>$taxValue,
					'sum_net'=>$sumNet,
					'sum_gross'=>$sumGross
				));
			}
		}

		return($bookingExtra);
	}
	
	/**************************************************************************/
	
	function manageEditColumns($column)
	{
		$column=array
		(
			'cb'=>$column['cb'],
			'title'=>esc_html__('Title','car-park-booking-system'),
			'quantity'=>esc_html__('Quantity','car-park-booking-system'),
			'price'=>esc_html__('Price','car-park-booking-system'),
		);
   
		return($column);		  
	}
	
	/**************************************************************************/
	
	function managePostsCustomColumn($column)
	{
		global $post;
		
		$meta=CPBSPostMeta::getPostMeta($post);
		
		switch($column) 
		{
			case 'quantity':
				
				echo 
				'
					<table class="to-table-post-list">
						<tr>
							<td>'.esc_html__('Default','car-park-booking-system').'</td>
							<td>'.esc_html($meta['quantity_default']).'</td>
						</tr>
						<tr>
							<td>'.esc_html__('Minimum','car-park-booking-system').'</td>
							<td>'.esc_html($meta['quantity_minimum']).'</td>
						</tr>
						<tr>
							<td>'.esc_html__('Maximum','car-park-booking-system').'</td>
							<td>'.esc_html($meta['quantity_maximum']).'</td>
						</tr>
						<tr>
							<td>'.esc_html__('Readonly ','car-park-booking-system').'</td>
							<td>'.esc_html(CPBSHelper::mapBoolValue($meta['quantity_readonly_enable'])).'</td>
						</tr>
						<tr>
							<td>'.esc_html__('Equal to number of rental days','car-park-booking-system').'</td>
							<td>'.esc_html(CPBSHelper::mapBoolValue($meta['quantity_equal_rental_day_number'])).'</td>
						</tr>
					</table>
				';
				
			break;
		
			case 'price':
		
				echo 
				'
					<table class="to-table-post-list">
						<tr>
							<td>'.esc_html__('Net price','car-park-booking-system').'</td>
							<td>'.esc_html(CPBSPrice::format($meta['price'],CPBSOption::getOption('currency'))).'</td>
						</tr>
						<tr>
							<td>'.esc_html__('Price type','car-park-booking-system').'</td>
							<td>'.esc_html($this->getPriceTypeName($meta['price_type'])).'</td>
						</tr>
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
}

/******************************************************************************/
/******************************************************************************/