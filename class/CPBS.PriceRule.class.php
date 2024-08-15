<?php

/******************************************************************************/
/******************************************************************************/

class CPBSPriceRule
{
	/**************************************************************************/
	
	function __construct()
	{
		$this->priceSourceType=array
		(
			1=>array(esc_html__('Set directly in rule','car-park-booking-system')),
			2=>array(esc_html__('Calculation based on rental dates','car-park-booking-system')),
			3=>array(esc_html__('Calculation based on rental days quantity (all ranges)','car-park-booking-system')),
			4=>array(esc_html__('Calculation based on rental days quantity (exact range)','car-park-booking-system')),
			5=>array(esc_html__('Calculation based on rental hours quantity (all ranges)','car-park-booking-system')),
			6=>array(esc_html__('Calculation based on rental hours quantity (exact range)','car-park-booking-system')),
			7=>array(esc_html__('Calculation based on rental minutes quantity (all ranges)','car-park-booking-system')),
			8=>array(esc_html__('Calculation based on rental minutes quantity (exact range)','car-park-booking-system')),
		);

		$this->priceAlterType=array
		(
			1=>array(esc_html__('- Inherited -','car-park-booking-system')),
			2=>array(esc_html__('Set value','car-park-booking-system')),
			3=>array(esc_html__('Increase by value','car-park-booking-system')),
			4=>array(esc_html__('Decrease by value','car-park-booking-system')),
			5=>array(esc_html__('Increase by percentage','car-park-booking-system')),
			6=>array(esc_html__('Decrease by percentage','car-park-booking-system'))
		);

		$this->priceUseType=array
		(
			'initial'=>array(esc_html__('Initial','car-park-booking-system')),
			'rental_day'=>array(esc_html__('Rental per day','car-park-booking-system')),
			'rental_hour'=>array(esc_html__('Rental per hour','car-park-booking-system')),
			'rental_minute'=>array(esc_html__('Rental per minute','car-park-booking-system'))
		);
		
		$this->dateDependency=array
		(
			'1'=>array(esc_html__('The same dates (days)','car-park-booking-system')),
			'2'=>array(esc_html__('Different dates (days)','car-park-booking-system'))
		);
	}
	
	/**************************************************************************/
	
	function getPriceIndexName($index,$type='value')
	{
		return('price_'.$index.'_'.$type);
	}
	
	/**************************************************************************/
	
	function getPriceAlterType()
	{
		return($this->priceAlterType);
	}
	
	/**************************************************************************/
	
	function isPriceAlterType($priceAlterType)
	{
		return(array_key_exists($priceAlterType,$this->priceAlterType));
	}
	
	/**************************************************************************/
	
	function getPriceUseType()
	{
		return($this->priceUseType);
	}
	
	/**************************************************************************/
	
	function isPriceUseType($priceUseType)
	{
		return(array_key_exists($priceUseType,$this->priceUseType));
	}
	
	/**************************************************************************/
	
	function getPriceSourceType()
	{
		return($this->priceSourceType);
	}
	
	/**************************************************************************/
	
	function isPriceSourceType($type)
	{
		return(array_key_exists($type,$this->getPriceSourceType()));
	}
	
	/**************************************************************************/
	
	function getPriceSourceTypeName($type)
	{
		if(!$this->isPriceSourceType($type)) return('');
		return($this->priceSourceType[$type][0]);
	}
	
	/**************************************************************************/
	
	function getDateDependency()
	{
		return($this->dateDependency);
	}
	
	/**************************************************************************/
	
	function isDateDependency($type)
	{
		return(array_key_exists($type,$this->getDateDependency()));
	}
	
	/**************************************************************************/
	
	function getDateDependencyName($type)
	{
		if(!$this->isDateDependency($type)) return('');
		return($this->dateDependency[$type][0]);
	}

	/**************************************************************************/
	
	function extractPriceFromData($price,$data)
	{
		$priceComponent=array('value','alter_type_id','tax_rate_id');
		
		foreach($this->getPriceUseType() as $priceUseTypeIndex=>$priceUseTypeValue)
		{
			foreach($priceComponent as $priceComponentIndex=>$priceComponentValue)
			{
				$key=$this->getPriceIndexName($priceUseTypeIndex,$priceComponentValue);
				if(isset($data[$key])) $price[$key]=$data[$key];
				else
				{
					if($priceComponentValue==='alter_type_id') $price[$key]=2;
				}
			}
		}
		
		return($price);
	}

	/**************************************************************************/
	
	public function init()
	{
		$this->registerCPT();
	}
	
	/**************************************************************************/

	public static function getCPTName()
	{
		return(PLUGIN_CPBS_CONTEXT.'_price_rule');
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
					'name'=>esc_html__('Pricing Rules','car-park-booking-system'),
					'singular_name'=>esc_html__('Pricing Rule','car-park-booking-system'),
					'add_new'=>esc_html__('Add New','car-park-booking-system'),
					'add_new_item'=>esc_html__('Add New Pricing Rule','car-park-booking-system'),
					'edit_item'=>esc_html__('Edit Pricing Rule','car-park-booking-system'),
					'new_item'=>esc_html__('New Pricing Rule','car-park-booking-system'),
					'all_items'=>esc_html__('Pricing Rules','car-park-booking-system'),
					'view_item'=>esc_html__('View Pricing Rule','car-park-booking-system'),
					'search_items'=>esc_html__('Search Pricing Rules','car-park-booking-system'),
					'not_found'=>esc_html__('No Pricing Rules Found','car-park-booking-system'),
					'not_found_in_trash'=>esc_html__('No Pricing Rules in Trash','car-park-booking-system'),
					'parent_item_colon'=>'',
					'menu_name'=>esc_html__('Pricing Rules','car-park-booking-system')
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
		add_filter('postbox_classes_'.self::getCPTName().'_cpbs_meta_box_price_rule',array($this,'adminCreateMetaBoxClass'));
		
		add_filter('manage_edit-'.self::getCPTName().'_columns',array($this,'manageEditColumns')); 
		add_action('manage_'.self::getCPTName().'_posts_custom_column',array($this,'managePostsCustomColumn'));
		add_filter('manage_edit-'.self::getCPTName().'_sortable_columns',array($this,'manageEditSortableColumns'));
	}

	/**************************************************************************/
	
	function addMetaBox()
	{
		add_meta_box(PLUGIN_CPBS_CONTEXT.'_meta_box_price_rule',esc_html__('Main','car-park-booking-system'),array($this,'addMetaBoxMain'),self::getCPTName(),'normal','low');		
	}
	
	/**************************************************************************/
	
	function addMetaBoxMain()
	{
		global $post;
		
		$data=array();
		
		$User=new CPBSUser();
		$TaxRate=new CPBSTaxRate();
		$Location=new CPBSLocation();
		$PlaceType=new CPBSPlaceType();
		$BookingForm=new CPBSBookingForm();
		
		$data['meta']=CPBSPostMeta::getPostMeta($post);
		
		$data['nonce']=CPBSHelper::createNonceField(PLUGIN_CPBS_CONTEXT.'_meta_box_price_rule');

		$data['dictionary']['tax_rate']=$TaxRate->getDictionary();
		$data['dictionary']['place_type']=$PlaceType->getDictionary();
		$data['dictionary']['booking_form']=$BookingForm->getDictionary();

		$data['dictionary']['price_alter_type']=$this->getPriceAlterType();
		$data['dictionary']['price_source_type']=$this->getPriceSourceType();
		
		$data['dictionary']['location']=$Location->getDictionary();
		
		$data['dictionary']['date_dependency']=$this->getDateDependency();
		
		$data['dictionary']['user_group']=$User->getUserCategory();
		$data['dictionary']['user_login_status']=$User->getUserLoginStatus();
		
		$Template=new CPBSTemplate($data,PLUGIN_CPBS_TEMPLATE_PATH.'admin/meta_box_price_rule.php');
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
		
		CPBSHelper::setDefault($meta,'booking_form_id',array(-1));
		
		CPBSHelper::setDefault($meta,'location_id',array(-1));
		CPBSHelper::setDefault($meta,'place_type_id',array(-1));
		
		CPBSHelper::setDefault($meta,'entry_day_number',array(-1));
		
		CPBSHelper::setDefault($meta,'date_entry_exit_dependency',-1);
		
		CPBSHelper::setDefault($meta,'rental_date',array());
		CPBSHelper::setDefault($meta,'rental_day_quantity',array());
		CPBSHelper::setDefault($meta,'rental_hour_quantity',array());
		CPBSHelper::setDefault($meta,'rental_minute_quantity',array());
		
		CPBSHelper::setDefault($meta,'user_login_status',-1);
		CPBSHelper::setDefault($meta,'user_group_id',array(-1));
		
		CPBSHelper::setDefault($meta,'price_source_type',1);
		
		CPBSHelper::setDefault($meta,'process_next_rule_enable',0);
		
		foreach($this->getPriceUseType() as $index=>$value)
		{
			CPBSHelper::setDefault($meta,'price_'.$index.'_value','0.00');
			CPBSHelper::setDefault($meta,'price_'.$index.'_alter_type_id',2);
			CPBSHelper::setDefault($meta,'price_'.$index.'_tax_rate_id',$TaxRate->getDefaultTaxPostId());   
		}
	}
	
	/**************************************************************************/
	
	function savePost($postId)
	{	  
		if(!$_POST) return(false);
		
		if(CPBSHelper::checkSavePost($postId,PLUGIN_CPBS_CONTEXT.'_meta_box_price_rule_noncename','savePost')===false) return(false);
		
		$User=new CPBSUser();
		$Date=new CPBSDate();
		$TaxRate=new CPBSTaxRate();
		$Location=new CPBSLocation();
		$PlaceType=new CPBSPlaceType();
		$Validation=new CPBSValidation();
		$BookingForm=new CPBSBookingForm();
		
		$option=CPBSHelper::getPostOption();
		
		$userCategoryDictionary=$User->getUserCategory();
		
		/***/
		
		$dictionary=array
		(
			'booking_form_id'=>array
			(
				'dictionary'=>$BookingForm->getDictionary()
			),
			'location_id'=>array
			(
				'dictionary'=>$Location->getDictionary()
			),
			'place_type_id'=>array
			(
				'dictionary'=>$PlaceType->getDictionary()
			),
			'entry_day_number'=>array
			(
				'dictionary'=>array(1,2,3,4,5,6,7)
			),
		);
		
		foreach($dictionary as $dIndex=>$dValue)
		{
			$option[$dIndex]=(array)CPBSHelper::getPostValue($dIndex);
			if(in_array(-1,$option[$dIndex]))
			{
				$option[$dIndex]=array(-1);
			}
			else
			{
				foreach($option[$dIndex] as $oIndex=>$oValue)
				{
					if(!isset($dValue['dictionary']))
						unset($option[$dIndex][$oIndex]);				
				}
			}			 
		}
		
		/***/
		
		if(!$this->isDateDependency($option['date_entry_exit_dependency']))
			$option['date_entry_exit_dependency']=-1;
		
		/***/
		
		$date=array();
	   
		foreach($option['rental_date']['start'] as $index=>$value)
		{
			$d=array($value,$option['rental_date']['stop'][$index],$option['rental_date']['price'][$index]);
			
			$d[0]=$Date->formatDateToStandard($d[0]);
			$d[1]=$Date->formatDateToStandard($d[1]);
			
			if(!$Validation->isDate($d[0])) continue;
			if(!$Validation->isDate($d[1])) continue;
			
			if($Date->compareDate($d[0],$d[1])==1) continue;
			
			if(!$Validation->isPrice($d[2],true)) $d[2]=0.00;
			
			array_push($date,array('start'=>$d[0],'stop'=>$d[1],'price'=>$d[2]));
		}

		$option['rental_date']=$date;

		/***/
		
		$number=array();
	   
		foreach($option['rental_day_quantity']['start'] as $index=>$value)
		{
			$d=array($value,$option['rental_day_quantity']['stop'][$index],$option['rental_day_quantity']['price'][$index]);
			
			if(!$Validation->isNumber($d[0],0,99999)) continue;
			if(!$Validation->isNumber($d[1],0,99999)) continue;
  
			if(!$Validation->isPrice($d[2],true)) $d[2]=0.00;
			
			array_push($number,array('start'=>$d[0],'stop'=>$d[1],'price'=>$d[2]));
		}
		
		$option['rental_day_quantity']=$number;
		
		/***/
		
		$number=array();
		foreach($option['rental_hour_quantity']['start'] as $index=>$value)
		{
			$d=array($value,$option['rental_hour_quantity']['stop'][$index],$option['rental_hour_quantity']['price'][$index]);
			
			$d[0]=CPBSDate::fillTime($d[0]);
			$d[1]=CPBSDate::fillTime($d[1]);
			
			if(!$Validation->isTimeDuration($d[0])) continue;
			
			if(!$Validation->isTimeDuration($d[1])) continue;
			
			if(!$Validation->isPrice($d[2],true)) $d[2]=0.00;
			
			array_push($number,array('start'=>CPBSDate::fillTime($d[0],4),'stop'=>CPBSDate::fillTime($d[1],4),'price'=>$d[2]));
		}
		
		$option['rental_hour_quantity']=$number;

		/***/
		
		/***/
		
		$number=array();
	   
		foreach($option['rental_minute_quantity']['start'] as $index=>$value)
		{
			$d=array($value,$option['rental_minute_quantity']['stop'][$index],$option['rental_minute_quantity']['price'][$index]);
			
			if(!$Validation->isNumber($d[0],0,99999)) continue;
			if(!$Validation->isNumber($d[1],0,99999)) continue;
			
			if(!$Validation->isPrice($d[2],true)) $d[2]=0.00;
  
			array_push($number,array('start'=>$d[0],'stop'=>$d[1],'price'=>$d[2]));
		}
		
		$option['rental_minute_quantity']=$number;

		/***/
		
		if(!$User->isUserLoginStatus($option['user_login_status']))
			$option['user_login_status']=-1;
		
		if(!is_array($option['user_group_id']))
			$option['user_group_id']=array(-1);
		
		if(in_array(-1,$option['user_group_id']))
			$option['user_group_id']=array(-1);
		else 
		{
			foreach($option['user_group_id'] as $index=>$value)
			{
				if(!array_key_exists($value,$userCategoryDictionary))
					unset($option['user_group_id'][$index]);
			}
		}
		
		if(!count($option['user_group_id']))
			$option['user_group_id']=array(-1);	
		
		/***/
		
		if(!$this->isPriceSourceType($option['price_source_type']))
			$option['price_source_type']=1;
		if(!$Validation->isBool($option['process_next_rule_enable']))
			$option['process_next_rule_enable']=0;
		
		/***/
		
		foreach($this->getPriceUseType() as $index=>$value)
		{
			if(!$Validation->isPrice($option['price_'.$index.'_value'],false))
				$option['price_'.$index.'_value']=0.00;
			if(!$this->isPriceAlterType($option['price_'.$index.'_alter_type_id']))
				$option['price_'.$index.'_alter_type_id']=1;
			
			if(in_array($option['price_'.$index.'_alter_type_id'],array(5,6)))
			{
				if(!$Validation->isNumber($option['price_'.$index.'_alter_type_id'],0,100))
					$option['price_'.$index.'_alter_type_id']=0;
			}
		 
			if((int)$option['price_'.$index.'_tax_rate_id']===-1)
				$option['price_'.$index.'_tax_rate_id']=-1;
			else
			{
				if(!$TaxRate->isTaxRate($option['price_'.$index.'_tax_rate_id']))
					$option['price_'.$index.'_tax_rate_id']=0; 
			}
			
			$option['price_'.$index.'_value']=CPBSPrice::formatToSave($option['price_'.$index.'_value']);
		}
	
		/***/

		$key=array
		(
			'booking_form_id',
			'location_id',
			'place_type_id',
			'entry_day_number',
			'date_entry_exit_dependency',
			'rental_date',
			'rental_day_quantity',
			'rental_hour_quantity',
			'rental_minute_quantity',
			'user_login_status',
			'user_group_id',
			'price_source_type',
			'process_next_rule_enable'
		);
		
		foreach($this->getPriceUseType() as $index=>$value)
			array_push($key,'price_'.$index.'_value','price_'.$index.'_alter_type_id','price_'.$index.'_tax_rate_id');
		
		array_unique($key);
		
		foreach($key as $value)
			CPBSPostMeta::updatePostMeta($postId,$value,$option[$value]);
	}
	
	/**************************************************************************/

	function manageEditColumns($column)
	{
		$column=array
		(
			'cb'=>$column['cb'],
			'title'=>$column['title'],
			'condition'=>esc_html__('Conditions and details','car-park-booking-system'),
			'price'=>esc_html__('Prices','car-park-booking-system')
		);
   
		return($column);		   
	}
	
	/**************************************************************************/
	
	function getPricingRuleAdminListDictionary()
	{
		$dictionary=array();
	
		$Date=new CPBSDate();
		$Location=new CPBSLocation();
		$PlaceType=new CPBSPlaceType();
		$BookingForm=new CPBSBookingForm();
		
		$dictionary['location']=$Location->getDictionary();
		$dictionary['place_type']=$PlaceType->getDictionary();
		$dictionary['booking_form']=$BookingForm->getDictionary();

		$dictionary['day']=$Date->day;
		
		return($dictionary);
	}
	
	/**************************************************************************/
	
	function displayPricingRuleAdminListValue($data,$dictionary,$link=false,$sort=false)
	{
		if(in_array(-1,$data)) return('');
		
		$html=null;
		
		$dataSort=array();

		foreach($data as $value)
		{
			if(!array_key_exists($value,$dictionary)) continue;

			if(array_key_exists('post',$dictionary[$value]))
				$label=$dictionary[$value]['post']->post_title;
			else $label=$dictionary[$value][0];			

			$dataSort[$value]=$label;
		}

		if($sort) asort($dataSort);

		$data=$dataSort;
		
		foreach($data as $index=>$value)
		{
			$label=$value;
			
			if($link) $label='<a href="'.esc_url(get_edit_post_link($index)).'">'.esc_html($value).'</a>';
			$html.='<div>'.$label.'</div>';
		}
		
		return($html);
	}
	
	/**************************************************************************/
	
	function managePostsCustomColumn($column)
	{
		global $post;
		
		$User=new CPBSUser();
		$Date=new CPBSDate();
		$Validation=new CPBSValidation();
		
		$meta=CPBSPostMeta::getPostMeta($post);
		
		$dictionary=CPBSGlobalData::setGlobalData('pricing_rule_admin_list_dictionary',array($this,'getPricingRuleAdminListDictionary'));
		
		switch($column) 
		{
			case 'condition':
				
				$html=array
				(
					'rental_date'=>'',
					'rental_day_quantity'=>'',
					'rental_hour_quantity'=>'',
					'rental_minute_quantity'=>'',
					'date_dependency'=>'',
					'user_login_status'=>'',
					'user_group'=>''
				);
				
				if((isset($meta['rental_date'])) && (count($meta['rental_date'])))
				{
					foreach($meta['rental_date'] as $value)
					{
						if(!$Validation->isEmpty($html['rental_date'])) $html['rental_date'].='<br>';
						$html['rental_date'].=$Date->formatDateToDisplay($value['start']).' - '.$Date->formatDateToDisplay($value['stop']);	  
						
						if((int)$meta['price_source_type']===2)
							$html['rental_date'].=' ('.CPBSPrice::format($value['price'],CPBSOption::getOption('currency')).')';
					}
				}   
				
				if((isset($meta['rental_day_quantity'])) && (count($meta['rental_day_quantity'])))
				{
					foreach($meta['rental_day_quantity'] as $value)
					{
						if(!$Validation->isEmpty($html['rental_day_quantity'])) $html['rental_day_quantity'].='<br>';
						$html['rental_day_quantity'].=esc_html($value['start']).' - '.esc_html($value['stop']);	  
						
						if(in_array((int)$meta['price_source_type'],array(3,4)))
							$html['rental_day_quantity'].=' ('.CPBSPrice::format($value['price'],CPBSOption::getOption('currency')).')';
					}
				}				
				
				if((isset($meta['rental_hour_quantity'])) && (count($meta['rental_hour_quantity'])))
				{
					foreach($meta['rental_hour_quantity'] as $value)
					{
						if(!$Validation->isEmpty($html['rental_hour_quantity'])) $html['rental_hour_quantity'].='<br>';
						$html['rental_hour_quantity'].=esc_html($value['start']).' - '.esc_html($value['stop']);	
						
						if(in_array((int)$meta['price_source_type'],array(5,6)))
							$html['rental_hour_quantity'].=' ('.CPBSPrice::format($value['price'],CPBSOption::getOption('currency')).')';
					}
				}   
				
				if((isset($meta['rental_minute_quantity'])) && (count($meta['rental_minute_quantity'])))
				{
					foreach($meta['rental_minute_quantity'] as $value)
					{
						if(!$Validation->isEmpty($html['rental_minute_quantity'])) $html['rental_minute_quantity'].='<br>';
						$html['rental_minute_quantity'].=esc_html($value['start']).' - '.esc_html($value['stop']);	  
				
						if(in_array((int)$meta['price_source_type'],array(7,8)))
							$html['rental_minute_quantity'].=' ('.CPBSPrice::format($value['price'],CPBSOption::getOption('currency')).')';
					}
				}	 
				
				if($this->isDateDependency($meta['date_entry_exit_dependency']))
					$html['date_dependency']=$this->getDateDependencyName($meta['date_entry_exit_dependency']);
				
				if($User->isUserLoginStatus($meta['user_login_status']))
					$html['user_login_status']=$User->getUserLoginStatusName($meta['user_login_status']);
				
				if(!in_array(-1,$meta['user_group_id']))
				{
					$userGroupDictionary=$User->getUserCategory();
				
					foreach($meta['user_group_id'] as $index=>$value)
					{
						if(!array_key_exists($value,$userGroupDictionary)) continue;
						
						if($Validation->isNotEmpty($html['user_group'])) $html['user_group'].=', ';
						$html['user_group'].=$userGroupDictionary[$value]['name'];
					}
				}
				
				/***/
				
				echo 
				'
					<table class="to-table-post-list">
						<tr>
							<td>'.esc_html__('Booking forms','car-park-booking-system').'</td>
							<td>'.$this->displayPricingRuleAdminListValue($meta['booking_form_id'],$dictionary['booking_form'],true,true).'</td>
						</tr>
						<tr>
							<td>'.esc_html__('Locations','car-park-booking-system').'</td>
							<td>'.$this->displayPricingRuleAdminListValue($meta['location_id'],$dictionary['location'],true,true).'</td>
						</tr>
						<tr>
							<td>'.esc_html__('Park space types','car-park-booking-system').'</td>
							<td>'.$this->displayPricingRuleAdminListValue($meta['place_type_id'],$dictionary['place_type'],true,true).'</td>
						</tr>
						<tr>
							<td>'.esc_html__('Entry day numbers','car-park-booking-system').'</td>
							<td>'.$this->displayPricingRuleAdminListValue($meta['entry_day_number'],$dictionary['day'],true,true).'</td>
						</tr>
						<tr>
							<td>'.esc_html__('Dependency between dates','car-park-booking-system').'</td>
							<td>'.$html['date_dependency'].'</td>
						</tr>						
						<tr>
							<td>'.esc_html__('Rental dates','car-park-booking-system').'</td>
							<td>'.$html['rental_date'].'</td>
						</tr>
						<tr>
							<td>'.esc_html__('Rental days quantity','car-park-booking-system').'</td>
							<td>'.$html['rental_day_quantity'].'</td>
						</tr>
						<tr>
							<td>'.esc_html__('Rental hours quantity','car-park-booking-system').'</td>
							<td>'.$html['rental_hour_quantity'].'</td>
						</tr>
						<tr>
							<td>'.esc_html__('Rental minutes quantity','car-park-booking-system').'</td>
							<td>'.$html['rental_minute_quantity'].'</td>
						</tr>
						<tr>
							<td>'.esc_html__('User login status','car-park-booking-system').'</td>
							<td>'.$html['user_login_status'].'</td>
						</tr>						
						<tr>
							<td>'.esc_html__('User group','car-park-booking-system').'</td>
							<td>'.$html['user_group'].'</td>
						</tr>	
						<tr>
							<td>'.esc_html__('Priority','car-park-booking-system').'</td>
							<td>'.(int)$post->menu_order.'</td>
						</tr>
						<tr>
							<td>'.esc_html__('Next rule processing','car-park-booking-system').'</td>
							<td>'.((int)$meta['process_next_rule_enable']===1 ? esc_html__('Enable','car-park-booking-system') : esc_html__('Disable','car-park-booking-system')).'</td>
						</tr>
					</table>
				';

			break;
		
			case 'price':
				
				echo 
				'
					<table class="to-table-post-list">
						<tr>
							<td>'.esc_html__('Price source type','car-park-booking-system').'</td>
							<td>'.$this->getPriceSourceTypeName($meta['price_source_type']).'</td>
						</tr>  
				';
				
				foreach($this->getPriceUseType() as $index=>$value)
				{
					echo 
					'
						<tr>
							<td>'.esc_html($value[0]).'</td>
							<td>'.self::displayPriceAlter($meta,$index).'</td>
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
	
	function getDictionary($attr=array())
	{
		global $post;
		
		$dictionary=array();
		
		$default=array
		(
			'price_rule_id'=>0
		);
		
		$attribute=shortcode_atts($default,$attr);
		CPBSHelper::preservePost($post,$bPost);
		
		$argument=array
		(
			'post_type'=>self::getCPTName(),
			'post_status'=>'publish',
			'posts_per_page'=>-1,
			'orderby'=>array('menu_order'=>'desc')
		);
		
		if($attribute['price_rule_id'])
			$argument['p']=$attribute['price_rule_id'];
			   
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
	
	static function displayPriceAlter($meta,$priceUseType)
	{
		$charBefore=null;
		
		if(in_array($meta['price_'.$priceUseType.'_alter_type_id'],array(3,5)))
			$charBefore='+ ';
		if(in_array($meta['price_'.$priceUseType.'_alter_type_id'],array(4,6)))
			$charBefore='- ';		
		
		if(in_array($meta['price_'.$priceUseType.'_alter_type_id'],array(1)))
		{
			return(esc_html__('Inherited','car-park-booking-system'));
		}
		elseif(in_array($meta['price_'.$priceUseType.'_alter_type_id'],array(2)))
		{
			return(CPBSPrice::format($meta['price_'.$priceUseType.'_value'],CPBSOption::getOption('currency')));
		}
		elseif(in_array($meta['price_'.$priceUseType.'_alter_type_id'],array(3,4)))
		{
			return($charBefore.CPBSPrice::format($meta['price_'.$priceUseType.'_value'],CPBSOption::getOption('currency')));
		}
		elseif(in_array($meta['price_'.$priceUseType.'_alter_type_id'],array(5,6)))
		{
			return($charBefore.$meta['price_'.$priceUseType.'_value'].'%');
		}
	}
	
	/**************************************************************************/
	
	function manageEditSortableColumns($column)
	{
		return($column);	   
	}
	
	/**************************************************************************/
	
	function getPriceFromRule($bookingData,$priceRule)
	{
		$User=new CPBSUser();
		$Date=new CPBSDate();
		
		$rule=$bookingData['booking_form']['dictionary']['price_rule'];
		if($rule===false) return($priceRule);

		foreach($rule as $ruleData)
		{
			$pricePerUnit=-1;
			$pricePerUnitKey=null;
			
			if(!in_array(-1,$ruleData['meta']['booking_form_id']))
			{
				if(!in_array($bookingData['booking_form_id'],$ruleData['meta']['booking_form_id'])) continue;
			}
			
			if(!in_array(-1,$ruleData['meta']['location_id']))
			{
				if(!in_array($bookingData['location_id'],$ruleData['meta']['location_id'])) continue;
			}
			
			if(!in_array(-1,$ruleData['meta']['place_type_id']))
			{
				if(!in_array($bookingData['place_type_id'],$ruleData['meta']['place_type_id'])) continue;
			}			
	
			if(!in_array(-1,$ruleData['meta']['entry_day_number']))
			{
				$date=$bookingData['entry_date'];

				if(!in_array(date_i18n('N',strtotime($date)),$ruleData['meta']['entry_day_number'])) continue;
			}
			
			if((int)$ruleData['meta']['date_entry_exit_dependency']===1)
			{
				if($bookingData['entry_date']!=$bookingData['exit_date']) continue;
			}
			else if((int)$ruleData['meta']['date_entry_exit_dependency']===2)
			{
				if($bookingData['entry_date']==$bookingData['exit_date']) continue;
			}		
			
			/***/
			
			if((int)$ruleData['meta']['user_login_status']!==-1)
			{
				$b=false;
				
				if(((int)$ruleData['meta']['user_login_status']===1) && ($User->isSignIn())) $b=true;
				if(((int)$ruleData['meta']['user_login_status']===2) && (!$User->isSignIn())) $b=true;
				
				if(!$b) continue;
			}
			
			/***/
			
			if((is_array($ruleData['meta']['user_group_id'])) && (!in_array(-1,$ruleData['meta']['user_group_id'])) && (count($ruleData['meta']['user_group_id'])) && ($User->isSignIn()))
			{
				$b=false;
				
				$userMeta=$User->getUserPostMeta();
				
				$userMetaUserGroupKey=PLUGIN_CPBS_OPTION_PREFIX.'_user_group_id';
				
				if(is_array($userMeta[$userMetaUserGroupKey]))
				{
					foreach($userMeta[$userMetaUserGroupKey] as $index=>$value)
					{
						if(in_array($value,$ruleData['meta']['user_group_id']))
						{
							$b=true;
							break;
						}
					}
				}
				
				if(!$b) continue;
			}
			
			/***/
			
			if(is_array($ruleData['meta']['rental_date']))
			{
				if(count($ruleData['meta']['rental_date']))
				{
					$match=false;
					
					if(((int)$ruleData['meta']['price_source_type']===2) && (in_array((int)CPBSOption::getOption('billing_type'),array(3,6))))
					{
						$sum=0;
						$match=true;

						$dateStart=$bookingData['entry_date'];
						
						$period=CPBSBookingHelper::calculateBookingPeriod($bookingData['entry_date'],$bookingData['entry_time'],$bookingData['exit_date'],$bookingData['exit_time'],$bookingData['booking_form']);

						for($i=0;$i<$period['day'];$i++)
						{
							$date=date_i18n('d-m-Y',strtotime('+'.$i.' day', strtotime($dateStart)));
								
							$dateIndex=-1;
							
							foreach($ruleData['meta']['rental_date'] as $index=>$value)
							{
								if($Date->dateInRange($date,$value['start'],$value['stop']))
								{
									$dateIndex=$index;
									break;
								}
							}
							
							if($dateIndex!=-1)
							{
								$sum+=$ruleData['meta']['rental_date'][$dateIndex]['price'];
							}
							else
							{
								$match=false;
								break;
							}
						}
						
						if($match)
						{
							if($period['day']>0)
							{
								$pricePerUnit=$sum/$period['day'];
								$pricePerUnitKey='day';
							}
						}
					}
					else
					{
						$date=$bookingData['entry_date'];
						foreach($ruleData['meta']['rental_date'] as $value)
						{
							if($Date->dateInRange($date,$value['start'],$value['stop']))
							{
								$match=true;
								break;
							}
						}
					}

					if(!$match) continue;
				}
			}
			
			if(in_array((int)CPBSOption::getOption('billing_type'),array(3,5,6,7)))
			{
				if(is_array($ruleData['meta']['rental_day_quantity']))
				{
					if(count($ruleData['meta']['rental_day_quantity']))
					{
						$match=false;

						$period=CPBSBookingHelper::calculateBookingPeriod($bookingData['entry_date'],$bookingData['entry_time'],$bookingData['exit_date'],$bookingData['exit_time'],$bookingData['booking_form']);

						if((int)$ruleData['meta']['price_source_type']===3)
						{
							$sum=0;
							$match=true;
							
							for($i=1;$i<=$period['day'];$i++)
							{
								foreach($ruleData['meta']['rental_day_quantity'] as $value)
								{
									if(($value['start']<=$i) && ($value['stop']>=$i))
									{
										$sum+=$value['price'];
										break;
									}
								}		
							}
							
							if($period['day']>0)
							{
								$pricePerUnit=$sum/$period['day'];
								$pricePerUnitKey='day';
							}
						}
						else if((int)$ruleData['meta']['price_source_type']===4)
						{
							foreach($ruleData['meta']['rental_day_quantity'] as $value)
							{
								if(($value['start']<=$period['day']) && ($value['stop']>=$period['day']))
								{
									$match=true;
									$pricePerUnit=$value['price'];
									$pricePerUnitKey='day';
									break;
								}
							}		
						}
						else
						{
							foreach($ruleData['meta']['rental_day_quantity'] as $value)
							{
								if(($value['start']<=$period['day']) && ($period['day']<=$value['stop']))
								{
									$match=true;
									break;						
								}
							}
						}
						
						if(!$match) continue;
					}
				}  
			}
				
			if(in_array((int)CPBSOption::getOption('billing_type'),array(2,4,5,7)))
			{
				if(is_array($ruleData['meta']['rental_hour_quantity']))
				{
					if(count($ruleData['meta']['rental_hour_quantity']))
					{
						$match=false;

						$period=CPBSBookingHelper::calculateBookingPeriod($bookingData['entry_date'],$bookingData['entry_time'],$bookingData['exit_date'],$bookingData['exit_time'],$bookingData['booking_form']);

						$hourToMinute=$period['hour']*60;
						
						if((int)$ruleData['meta']['price_source_type']===5)
						{
							$sum=0;
							$match=true;

							for($i=1;$i<=$hourToMinute;$i++)
							{
								foreach($ruleData['meta']['rental_hour_quantity'] as $value)
								{
									$startHourToMinute=CPBSDate::convertTimeDurationToMinute($value['start']);
									$stopHourToMinute=CPBSDate::convertTimeDurationToMinute($value['stop']);
									
									if(($startHourToMinute<=$i) && ($stopHourToMinute>=$i))
									{
										$sum+=$value['price'];
										break;
									}
								}		
							}
							
							if($hourToMinute>0)
							{
								$pricePerUnit=$sum/$hourToMinute;
								$pricePerUnitKey='hour';
							}
						}
						else if((int)$ruleData['meta']['price_source_type']===6)
						{
							foreach($ruleData['meta']['rental_hour_quantity'] as $value)
							{
								$startHourToMinute=CPBSDate::convertTimeDurationToMinute($value['start']);
								$stopHourToMinute=CPBSDate::convertTimeDurationToMinute($value['stop']);
								
								if(($startHourToMinute<=$hourToMinute) && ($stopHourToMinute>=$hourToMinute))
								{
									$match=true;
									$pricePerUnit=$value['price'];
									$pricePerUnitKey='hour';
									break;
								}
							}		
						}
						else
						{
							foreach($ruleData['meta']['rental_hour_quantity'] as $value)
							{
								$startHourToMinute=CPBSDate::convertTimeDurationToMinute($value['start']);
								$stopHourToMinute=CPBSDate::convertTimeDurationToMinute($value['stop']);
								
								if(($startHourToMinute<=$hourToMinute) && ($stopHourToMinute>=$hourToMinute))
								{
									$match=true;
									break;		
								}								
							}
						}
						
						if(!$match) continue;
					}
				}  
			}			
			
			if(in_array((int)CPBSOption::getOption('billing_type'),array(1,4)))
			{
				if(is_array($ruleData['meta']['rental_minute_quantity']))
				{
					if(count($ruleData['meta']['rental_minute_quantity']))
					{
						$match=false;

						$period=CPBSBookingHelper::calculateBookingPeriod($bookingData['entry_date'],$bookingData['entry_time'],$bookingData['exit_date'],$bookingData['exit_time'],$bookingData['booking_form']);

						if((int)$ruleData['meta']['price_source_type']===7)
						{
							$sum=0;
							$match=true;
							
							for($i=1;$i<=$period['minute'];$i++)
							{
								foreach($ruleData['meta']['rental_minute_quantity'] as $value)
								{
									if(($value['start']<=$i) && ($value['stop']>=$i))
									{
										$sum+=$value['price'];
										break;
									}
								}		
							}
							
							if($period['minute']>0)
							{
								$pricePerUnit=$sum/$period['minute'];
								$pricePerUnitKey='minute';
							}
						}
						else if((int)$ruleData['meta']['price_source_type']===8)
						{
							foreach($ruleData['meta']['rental_minute_quantity'] as $value)
							{
								if(($value['start']<=$period['minute']) && ($value['stop']>=$period['minute']))
								{
									$match=true;
									$pricePerUnit=$value['price'];
									$pricePerUnitKey='minute';
									break;
								}
							}		
						}
						else
						{
							foreach($ruleData['meta']['rental_minute_quantity'] as $value)
							{
								if(($value['start']<=$period['minute']) && ($period['minute']<=$value['stop']))
								{
									$match=true;
									break;						
								}
							}
						}
						
						if(!$match) continue;
					}
				}  
			}	

			if($pricePerUnit!=-1)
			{
				$priceRule['price_rental_'.$pricePerUnitKey.'_value']=$pricePerUnit;
				$pricePerUnit=-1;
				$pricePerUnitKey=null;
			}
			else
			{
				foreach($this->getPriceUseType() as $index=>$value)
				{
					if((int)$ruleData['meta']['price_'.$index.'_alter_type_id']===2)
					{
						$priceRule['price_'.$index.'_value']=$ruleData['meta']['price_'.$index.'_value'];
					}
					elseif(in_array((int)$ruleData['meta']['price_'.$index.'_alter_type_id'],array(3,4))) 
					{
						if((int)$ruleData['meta']['price_'.$index.'_alter_type_id']===3)
							$priceRule['price_'.$index.'_value']+=$ruleData['meta']['price_'.$index.'_value'];
						if((int)$ruleData['meta']['price_'.$index.'_alter_type_id']===4)
							$priceRule['price_'.$index.'_value']-=$ruleData['meta']['price_'.$index.'_value'];
					}
					elseif(in_array((int)$ruleData['meta']['price_'.$index.'_alter_type_id'],array(5,6)))
					{
						if((int)$ruleData['meta']['price_'.$index.'_alter_type_id']===5)
						{
							$priceRule['price_'.$index.'_value']=$priceRule['price_'.$index.'_value']*(1+$ruleData['meta']['price_'.$index.'_value']/100); 
						}
						elseif((int)$ruleData['meta']['price_'.$index.'_alter_type_id']===6)
							$priceRule['price_'.$index.'_value']=$priceRule['price_'.$index.'_value']*(1-$ruleData['meta']['price_'.$index.'_value']/100); 
					}

					if($priceRule['price_'.$index.'_value']<0)
						$priceRule['price_'.$index.'_value']=0;
				}
			}
			
			foreach($this->getPriceUseType() as $index=>$value)
			{
				if((int)$ruleData['meta']['price_'.$index.'_tax_rate_id']!==0)
					$priceRule['price_'.$index.'_tax_rate_id']=$ruleData['meta']['price_'.$index.'_tax_rate_id'];			
			}

			if((int)$ruleData['meta']['process_next_rule_enable']!==1) return($priceRule);
		}
		
		return($priceRule);
	}
		
	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/