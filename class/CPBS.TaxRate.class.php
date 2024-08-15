<?php

/******************************************************************************/
/******************************************************************************/

class CPBSTaxRate
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
		return(PLUGIN_CPBS_CONTEXT.'_tax_rate');
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
					'name'=>esc_html__('Tax Rates','car-park-booking-system'),
					'singular_name'=>esc_html__('Tax Rates','car-park-booking-system'),
					'add_new'=>esc_html__('Add New','car-park-booking-system'),
					'add_new_item'=>esc_html__('Add New Tax Rate','car-park-booking-system'),
					'edit_item'=>esc_html__('Edit Tax Rate','car-park-booking-system'),
					'new_item'=>esc_html__('New Tax Rate','car-park-booking-system'),
					'all_items'=>esc_html__('Tax Rates','car-park-booking-system'),
					'view_item'=>esc_html__('View Tax Rate','car-park-booking-system'),
					'search_items'=>esc_html__('Search Tax Rates','car-park-booking-system'),
					'not_found'=>esc_html__('No Tax Rates Found','car-park-booking-system'),
					'not_found_in_trash'=>esc_html__('No Tax Rates in Trash','car-park-booking-system'),
					'parent_item_colon'=>'',
					'menu_name'=>esc_html__('Tax Rates','car-park-booking-system')
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
		add_filter('postbox_classes_'.self::getCPTName().'_cpbs_meta_box_tax_rate',array($this,'adminCreateMetaBoxClass'));
		
		add_filter('manage_edit-'.self::getCPTName().'_columns',array($this,'manageEditColumns')); 
		add_action('manage_'.self::getCPTName().'_posts_custom_column',array($this,'managePostsCustomColumn'));
		add_filter('manage_edit-'.self::getCPTName().'_sortable_columns',array($this,'manageEditSortableColumns'));
	}

	/**************************************************************************/
	
	function addMetaBox()
	{
		add_meta_box(PLUGIN_CPBS_CONTEXT.'_meta_box_tax_rate',esc_html__('Main','car-park-booking-system'),array($this,'addMetaBoxMain'),self::getCPTName(),'normal','low');		
	}
	
	/**************************************************************************/
	
	function addMetaBoxMain()
	{
		global $post;
		
		$data=array();
		
		$data['meta']=CPBSPostMeta::getPostMeta($post);
		
		$data['nonce']=CPBSHelper::createNonceField(PLUGIN_CPBS_CONTEXT.'_meta_box_tax_rate');
		
		$Template=new CPBSTemplate($data,PLUGIN_CPBS_TEMPLATE_PATH.'admin/meta_box_tax_rate.php');
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
		CPBSHelper::setDefault($meta,'tax_rate_value','23.00');
		CPBSHelper::setDefault($meta,'tax_rate_default','0');
	}
	
	/**************************************************************************/
	
	function savePost($postId)
	{	  
		if(!$_POST) return(false);
		
		if(CPBSHelper::checkSavePost($postId,PLUGIN_CPBS_CONTEXT.'_meta_box_tax_rate_noncename','savePost')===false) return(false);
		
		$Validation=new CPBSValidation();
		
		$option=CPBSHelper::getPostOption();
		
		if(!$Validation->isFloat($option['tax_rate_value'],0,100))
			$option['tax_rate_value']=0.00;
		if(!$Validation->isBool($option['tax_rate_default']))
			$option['tax_rate_default']=0;

		/***/
		
		if($option['tax_rate_default']==1)
		{
			$id=$this->getDefaultTaxPostId();
			if($id!=0) CPBSPostMeta::updatePostMeta($id,'tax_rate_default',0);
		}
		
		/***/
		
		$field=array
		(
			'tax_rate_value',
			'tax_rate_default'
		);

		foreach($field as $value)
			CPBSPostMeta::updatePostMeta($postId,$value,$option[$value]);		
	}
	
	/**************************************************************************/
	
	function getDictionary($attr=array())
	{
		global $post;
		
		$dictionary=array();
		
		$default=array
		(
			'tax_rate_id'=>0
		);
		
		$attribute=shortcode_atts($default,$attr);
		CPBSHelper::preservePost($post,$bPost);
		
		$argument=array
		(
			'post_type'=>self::getCPTName(),
			'post_status'=>'publish',
			'posts_per_page'=>-1,
			'meta_key'=>PLUGIN_CPBS_CONTEXT.'_tax_rate_value',
			'orderby'=>'meta_value_num',
			'order'=>'asc'
		);
		
		if($attribute['tax_rate_id'])
			$argument['p']=$attribute['tax_rate_id'];

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
	
	function getDefaultTaxPostId($taxRate=null)
	{
		if(is_null($taxRate))
			$taxRate=CPBSGlobalData::setGlobalData('tax_rate_dictionary',array(new CPBSTaxRate(),'getDictionary'));
		
		foreach($taxRate as $index=>$value)
		{
			if($value['meta']['tax_rate_default']==1)
				return($index);
		}
		
		return(0);
	}
	
	/**************************************************************************/
	
	function getTaxRateValue($taxRateId,$taxRate)
	{
		if(!isset($taxRate[$taxRateId])) return(0);
		return($taxRate[$taxRateId]['meta']['tax_rate_value']);
	}
	
	/**************************************************************************/
	
	function isTaxRate($taxRateId)
	{
		$dictionary=$this->getDictionary();
		return(array_key_exists($taxRateId,$dictionary));
	}
	
	/**************************************************************************/
	
	function manageEditColumns($column)
	{
		$column=array
		(
			'cb'=>$column['cb'],
			'title'=>esc_html__('Title','car-park-booking-system'),
			'value'=>esc_html__('Value','car-park-booking-system')
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
			case 'value':
				
				echo esc_html($meta['tax_rate_value']).'%';
				
				if((int)$meta['tax_rate_default']===1)
					esc_html_e(' (default)','car-park-booking-system');
				
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