<?php

/******************************************************************************/
/******************************************************************************/

class CPBSCoupon
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
		return(PLUGIN_CPBS_CONTEXT.'_coupon');
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
					'name'=>esc_html__('Coupons','car-park-booking-system'),
					'singular_name'=>esc_html__('Coupons','car-park-booking-system'),
					'add_new'=>esc_html__('Add New','car-park-booking-system'),
					'add_new_item'=>esc_html__('Add New Coupon','car-park-booking-system'),
					'edit_item'=>esc_html__('Edit Coupon','car-park-booking-system'),
					'new_item'=>esc_html__('New Coupon','car-park-booking-system'),
					'all_items'=>esc_html__('Coupons','car-park-booking-system'),
					'view_item'=>esc_html__('View Coupon','car-park-booking-system'),
					'search_items'=>esc_html__('Search Coupons','car-park-booking-system'),
					'not_found'=>esc_html__('No Coupons Found','car-park-booking-system'),
					'not_found_in_trash'=>esc_html__('No Coupons in Trash','car-park-booking-system'),
					'parent_item_colon'=>'',
					'menu_name'=>esc_html__('Coupons','car-park-booking-system')
				),
				'public'=>false,
				'show_ui'=>true,
				'show_in_menu'=>'edit.php?post_type='.CPBSBooking::getCPTName(),
				'capability_type'=>'post',
				'menu_position'=>2,
				'hierarchical'=>false,
				'rewrite'=>false,
				'supports'=>false
			)
		);
		
		add_action('save_post',array($this,'savePost'));
		add_action('add_meta_boxes_'.self::getCPTName(),array($this,'addMetaBox'));
		add_filter('postbox_classes_'.self::getCPTName().'_cpbs_meta_box_coupon',array($this,'adminCreateMetaBoxClass'));
		
		add_filter('manage_edit-'.self::getCPTName().'_columns',array($this,'manageEditColumns')); 
		add_action('manage_'.self::getCPTName().'_posts_custom_column',array($this,'managePostsCustomColumn'));
		add_filter('manage_edit-'.self::getCPTName().'_sortable_columns',array($this,'manageEditSortableColumns'));
	}

	/**************************************************************************/
	
	function addMetaBox()
	{
		add_meta_box(PLUGIN_CPBS_CONTEXT.'_meta_box_coupon',esc_html__('Main','car-park-booking-system'),array($this,'addMetaBoxMain'),self::getCPTName(),'normal','low');		
	}
	
	/**************************************************************************/
	
	function addMetaBoxMain()
	{
		global $post;
		
		$User=new CPBSUser();
		$Booking=new CPBSBooking();
		
		$data=array();
			   
		$data['meta']=CPBSPostMeta::getPostMeta($post);
		
		$data['nonce']=CPBSHelper::createNonceField(PLUGIN_CPBS_CONTEXT.'_meta_box_coupon');
		
		if(!isset($data['meta']['code']))
		{
			$code=$this->generateCode();
			
			wp_update_post(array('ID'=>$post->ID,'post_title'=>$code));
			
			CPBSPostMeta::updatePostMeta($post->ID,'code',$code);
			CPBSPostMeta::updatePostMeta($post->ID,'usage_count',0);
			
			$data['meta']=CPBSPostMeta::getPostMeta($post);
		}
		
		$data['meta']['usage_count']=$Booking->getCouponCodeUsageCount($data['meta']['code']);
		
		$data['dictionary']['user_group']=$User->getUserCategory();
		$data['dictionary']['user_login_status']=$User->getUserLoginStatus();
		
		$Template=new CPBSTemplate($data,PLUGIN_CPBS_TEMPLATE_PATH.'admin/meta_box_coupon.php');
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
		CPBSHelper::setDefault($meta,'usage_limit','');
		
		CPBSHelper::setDefault($meta,'discount_percentage',0);
		CPBSHelper::setDefault($meta,'discount_fixed',0);
		
		CPBSHelper::setDefault($meta,'active_date_start','');
		CPBSHelper::setDefault($meta,'active_date_stop','');
	
		CPBSHelper::setDefault($meta,'discount_rental_day_count',array());
		
		CPBSHelper::setDefault($meta,'user_login_status',-1);
		CPBSHelper::setDefault($meta,'user_group_id',array(-1));
	}
	
	/**************************************************************************/
	
	function savePost($postId)
	{	  
		if(!$_POST) return(false);
		
		if(CPBSHelper::checkSavePost($postId,PLUGIN_CPBS_CONTEXT.'_meta_box_coupon_noncename','savePost')===false) return(false);
		
		$User=new CPBSUser();
		$Date=new CPBSDate();
		$Validation=new CPBSValidation();
		
		$userCategoryDictionary=$User->getUserCategory();
		
		$option=CPBSHelper::getPostOption();
			 
		/**/
		
		if(($this->existCode($option['code'],$postId)) || (!$this->validCode($option['code'])))
			$option['code']=$this->generateCode();
		
		if(!$Validation->isNumber($option['usage_limit'],1,9999))
			$option['usage_limit']='';
		 
		/***/
		
		
		$option['active_date_start']=$Date->formatDateToStandard($option['active_date_start']);
		$option['active_date_stop']=$Date->formatDateToStandard($option['active_date_stop']);
		
		if(!$Validation->isDate($option['active_date_start']))
			$option['active_date_start']='';
		if(!$Validation->isDate($option['active_date_stop']))
			$option['active_date_stop']='';
		if(($Validation->isDate($option['active_date_start'])) && ($Validation->isDate($option['active_date_stop'])))
		{
			if($Date->compareDate($option['active_date_start'],$option['active_date_stop'])==1)
			{
				$option['active_date_start']='';
				$option['active_date_stop']='';
			}
		}	
		
		/***/
		
		if($Validation->isNumber($option['discount_percentage'],1,100,false))
		{
			$option['discount_fixed']=0;
		}
		else $option['discount_percentage']=0;
		
		if(($Validation->isPrice($option['discount_fixed'])) && ($option['discount_fixed']>0))
		{
			$option['discount_percentage']=0;
		}
		else $option['discount_fixed']=0;		
		
		/***/		

		$number=array();
	   
		foreach($option['discount_rental_day_count']['start'] as $index=>$value)
		{
			$d=array
			(
				$value,
				$option['discount_rental_day_count']['stop'][$index],
				$option['discount_rental_day_count']['discount_percentage'][$index],
				$option['discount_rental_day_count']['discount_fixed'][$index]
			);
			
			if(!$Validation->isNumber($d[0],0,99999)) continue;
			if(!$Validation->isNumber($d[1],0,99999)) continue;
  
			if($Validation->isNumber($d[2],1,100,false)) $d[3]=0;
			
			if(($Validation->isPrice($d[3])) && ($d[3]>0)) $d[2]=0;
			else $d[3]=0;
			
			if($d[0]>$d[1]) continue;
			
			array_push($number,array('start'=>$d[0],'stop'=>$d[1],'discount_percentage'=>$d[2],'discount_fixed'=>$d[3]));
		}
		
		$option['discount_rental_day_count']=$number;
		
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
		
		$key=array
		(
			'code',
			'usage_limit',
			'active_date_start',
			'active_date_stop',
			'discount_percentage',
			'discount_fixed',
			'discount_rental_day_count',
			'user_login_status',
			'user_group_id'
		);
		
		foreach($key as $index)
			CPBSPostMeta::updatePostMeta($postId,$index,$option[$index]);
		
		/***/
		
		wp_update_post(array('ID'=>$postId,'post_title'=>$option['code']));
	}
	
	/**************************************************************************/
	
	function existCode($code,$postId)
	{
		$argument=array
		(
			'post_type'=>self::getCPTName(),
			'post_status'=>'any',
			'post__not_in'=>array($postId),
			'posts_per_page'=>-1,
			'meta_key'=>PLUGIN_CPBS_CONTEXT.'_code',
			'meta_value'=>$code,
			'meta_compare'=>'='
		);

		$query=new WP_Query($argument);
		if($query===false) return(false);

		/***/

		if($query->found_posts!=1) return(false);        

		return(true);
	}
    
    /**************************************************************************/
    
	function validCode($code)
	{
		$Validation=new CPBSValidation();

		if($Validation->isEmpty($code)) return(false);

		if(strlen($code)>32) return(false);

		return(true);
	}
	
	/**************************************************************************/
	
	function manageEditColumns($column)
	{
		$column=array
		(
			'cb'=>$column['cb'],
			'title'=>esc_html__('Code','car-park-booking-system'),
			'usage'=>esc_html__('Usage','car-park-booking-system'),
			'discount_percentage'=>esc_html__('Percentage discount','car-park-booking-system'),
			'discount_fixed'=>esc_html__('Fixed discount','car-park-booking-system'),
			'active'=>esc_html__('Active','car-park-booking-system'),
			'user'=>esc_html__('Users','car-park-booking-system')
		);
   
		return($column);		  
	}
	
	/**************************************************************************/
	
	function managePostsCustomColumn($column)
	{
		global $post;
		
		$User=new CPBSUser();
		$Date=new CPBSDate();
		$Validation=new CPBSValidation();
		
		$meta=CPBSPostMeta::getPostMeta($post);
		
		switch($column) 
		{
			case 'usage':
				
				echo sprintf(esc_html__('Used %s from %s','car-park-booking-system'),$meta['usage_count'],($Validation->isEmpty($meta['usage_limit']) ? 'unlimited' : $meta['usage_limit']));
				
			break;
		
			case 'discount_percentage':
				
				echo esc_html($meta['discount_percentage'].'%');
				if(count($meta['discount_rental_day_count']))
					echo esc_html__(' (depends on rental days)','car-park-booking-system'); 
				
			break;
		
			case 'discount_fixed':
				
				echo CPBSPrice::format($meta['discount_fixed'],CPBSOption::getOption('currency'));
				if(count($meta['discount_rental_day_count']))
					echo esc_html__(' (depends on rental days)','car-park-booking-system'); 
				
			break;
		
			case 'active':

				echo esc_html(CPBSHelper::displayDatePeriod($Date->formatDateToDisplay($meta['active_date_start']),$Date->formatDateToDisplay($meta['active_date_stop'])));
				
			break;	
		
			case 'user':
				
				$html=array(esc_html__('Login status: ','car-park-booking-system'),esc_html__('Groups: ','car-park-booking-system'),null);

				/***/
				
				if($User->isUserLoginStatus($meta['user_login_status']))
					$html[0].=$User->getUserLoginStatusName($meta['user_login_status']);

				/****/
				
				if(!in_array(-1,$meta['user_group_id']))
				{
					$userGroupDictionary=$User->getUserCategory();
				
					foreach($meta['user_group_id'] as $index=>$value)
					{
						if(!array_key_exists($value,$userGroupDictionary)) continue;
						
						if($Validation->isNotEmpty($html[2])) $html[2].=', ';
						$html[2].=$userGroupDictionary[$value]['name'];
					}
					
					$html[1].=$html[2];
				}
				
				echo $html[0].'<br>'.$html[1];
				
			break;
		}
	}
	
	/**************************************************************************/
	
	function manageEditSortableColumns($column)
	{
		return($column);	   
	}
	
	/**************************************************************************/
	
	function create()
	{
		$option=CPBSHelper::getPostOption();

		$response=array('global'=>array('error'=>1));

		$Date=new CPBSDate();
		$Coupon=new CPBSCoupon();
		$Notice=new CPBSNotice();
		$Validation=new CPBSValidation();
		
		$invalidValue=esc_html__('This field includes invalid value.','car-park-booking-system');
		
		if(!$Validation->isNumber($option['coupon_generate_count'],1,999))
			$Notice->addError(CPBSHelper::getFormName('coupon_generate_count',false),$invalidValue);			
		if(!$Validation->isNumber($option['coupon_generate_usage_limit'],1,9999,true))
			$Notice->addError(CPBSHelper::getFormName('coupon_generate_usage_limit',false),$invalidValue);			
		
		$option['coupon_generate_active_date_start']=$Date->formatDateToStandard($option['coupon_generate_active_date_start']);
		$option['coupon_generate_active_date_stop']=$Date->formatDateToStandard($option['coupon_generate_active_date_stop']);
		
		if(!$Validation->isDate($option['coupon_generate_active_date_start'],true))
			$Notice->addError(CPBSHelper::getFormName('coupon_generate_active_date_start',false),$invalidValue);	  
		else if(!$Validation->isDate($option['coupon_generate_active_date_stop'],true))
			$Notice->addError(CPBSHelper::getFormName('coupon_generate_active_date_stop',false),$invalidValue);			  
		else
		{
			if($Date->compareDate($option['coupon_generate_active_date_start'],$option['coupon_generate_active_date_stop'])==1)
			{
				$Notice->addError(CPBSHelper::getFormName('coupon_generate_active_date_start',false),esc_html__('Invalid dates range.','car-park-booking-system'));
				$Notice->addError(CPBSHelper::getFormName('coupon_generate_active_date_stop',false),esc_html__('Invalid dates range.','car-park-booking-system')); 
			}			
		}
		
		if($Notice->isError())
		{
			$response['local']=$Notice->getError();
		}
		else
		{
			$Coupon->generate($option);
			$response['global']['error']=0;
		}

		$response['global']['notice']=$Notice->createHTML(PLUGIN_CPBS_TEMPLATE_PATH.'notice.php');

		echo json_encode($response);
		exit;
	}
	
	/**************************************************************************/
	
	function generate($data)
	{
		$Validation=new CPBSValidation();
		
		for($i=0;$i<$data['coupon_generate_count'];$i++)
		{
			$couponCode=$this->generateCode();
			
			$couponId=wp_insert_post
			(
				array
				(
					'comment_status'=>'closed',
					'ping_status'=>'closed',
					'post_author'=>get_current_user_id(),
					'post_title'=>$couponCode,
					'post_status'=>'publish',
					'post_type'=>self::getCPTName()
				)
			);
			
			if($couponId>0)
			{
				$discountPercentage=$data['coupon_generate_discount_percentage'];
				$discountFixed=$data['coupon_generate_discount_fixed'];
				
				if($Validation->isNumber($discountPercentage,1,100,true))
				{
					$discountFixed=0;
				}
				else 
				{
					$discountPercentage=0;
					if($Validation->isPrice($discountFixed))
					{
						$discountPercentage=0;
					}
					else $discountFixed=0;					 
				}
				
				CPBSPostMeta::updatePostMeta($couponId,'code',$couponCode);
				
				CPBSPostMeta::updatePostMeta($couponId,'usage_count',0);
				CPBSPostMeta::updatePostMeta($couponId,'usage_limit',$data['coupon_generate_usage_limit']);
				
				CPBSPostMeta::updatePostMeta($couponId,'discount_percentage',$discountPercentage);
				CPBSPostMeta::updatePostMeta($couponId,'discount_fixed',$discountFixed);
				
				CPBSPostMeta::updatePostMeta($couponId,'active_date_start',$data['coupon_generate_active_date_start']);
				CPBSPostMeta::updatePostMeta($couponId,'active_date_stop',$data['coupon_generate_active_date_stop']);
			}
		}
	}
	
	/**************************************************************************/
	
	function generateCode($length=12)
	{
		$code=null;
		
		$char='0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charLength=strlen($char);
		
		for($i=0;$i<$length;$i++)
			$code.=$char[rand(0,$charLength-1)];
		return($code);
	}
	
	/**************************************************************************/
	
	function checkCode()
	{
		global $post;
		
		$User=new CPBSUser();
		$Date=new CPBSDate();
		$Booking=new CPBSBooking();
		$Validation=new CPBSValidation();
		
		$data=CPBSHelper::getPostOption();
		
		if(!array_key_exists('coupon_code',$data)) return(false);
		
		if($Validation->isEmpty($data['coupon_code'])) return(false);
		
		/***/
		
		$argument=array
		(
			'post_type'=>self::getCPTName(),
			'post_status'=>'publish',
			'posts_per_page'=>-1,
			'meta_key'=>PLUGIN_CPBS_CONTEXT.'_code',
			'meta_value'=>isset($data['coupon_code']) ? $data['coupon_code'] : '',
			'meta_compare'=>'='
		);
		
		$query=new WP_Query($argument);
		if($query===false) return(false);
		
		/***/
		
		if($query->found_posts!=1) return(false);
		
		$query->the_post();
		
		$meta=CPBSPostMeta::getPostMeta($post);
		
		/***/
		
		if($Validation->isNotEmpty($meta['usage_limit']))
		{	
		   $count=$Booking->getCouponCodeUsageCount($data['coupon_code']);
	  
		   if($count===false) return(false);
		   if($count>=$meta['usage_limit']) return(false);
		}
		
		/***/
		
		if($Validation->isNotEmpty($meta['active_date_start']))
		{
			if($Date->compareDate(date_i18n('Y-m-d'),$meta['active_date_start'])===2) return(false);
		}
		
		if($Validation->isNotEmpty($meta['active_date_stop']))
		{
			if($Date->compareDate($meta['active_date_stop'],date_i18n('Y-m-d'))===2) return(false);
		}

		/***/
		
		if((int)$meta['user_login_status']!==-1)
		{
			$b=false;

			if(((int)$meta['user_login_status']===1) && ($User->isSignIn())) $b=true;
			if(((int)$meta['user_login_status']===2) && (!$User->isSignIn())) $b=true;

			if(!$b) return(false);
		}		
		
		/***/
		
		if((is_array($meta['user_group_id'])) && (!in_array(-1,$meta['user_group_id'])) && (count($meta['user_group_id'])) && ($User->isSignIn()))
		{
			$b=false;

			$userMeta=$User->getUserPostMeta();

			$userMetaUserGroupKey=PLUGIN_CPBS_OPTION_PREFIX.'_user_group_id';

			if(is_array($userMeta[$userMetaUserGroupKey]))
			{
				foreach($userMeta[$userMetaUserGroupKey] as $index=>$value)
				{
					if(in_array($value,$meta['user_group_id']))
					{
						$b=true;
						break;
					}
				}
			}

			if(!$b) return(false);
		}
		
		/***/
		
		return(array('post'=>$post,'meta'=>$meta));
	}
	
	/**************************************************************************/
	
	function calculateDiscountPercentage($discountFixed,$quantityDay,$quantityHour,$quantityMinute,$priceDay,$priceHour,$priceMinute)
	{
		if($discountFixed==0) return(0);
		
		$sum=$quantityDay*$priceDay+$quantityHour*$priceHour+$quantityMinute*$priceMinute;
		
		if($sum<=$discountFixed) return(0);
		
		$discountPercentage=($discountFixed/$sum)*100;

		return($discountPercentage);
	}
	
	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/