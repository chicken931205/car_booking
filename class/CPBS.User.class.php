<?php

/******************************************************************************/
/******************************************************************************/

class CPBSUser
{
	
	/**************************************************************************/
	
	function __construct()
	{
		$this->userLoginStatus=array
		(
			1=>array(__('Logged','car-park-booking-system')),
			2=>array(__('Non-logged','car-park-booking-system'))
		);
	}
	
	/**************************************************************************/
	
	function getUserLoginStatus()
	{
		return($this->userLoginStatus);
	}
	
	/**************************************************************************/
	
	function isUserLoginStatus($status)
	{
		$r=array_key_exists($status,$this->userLoginStatus);
		return($r);
	}	
	
	/**************************************************************************/
	
	function getUserLoginStatusName($status)
	{
		if(!$this->isUserLoginStatus($status)) return(null);
		
		$dictionary=$this->getUserLoginStatus();
		
		return($dictionary[$status][0]);
	}	
	
	/**************************************************************************/
	
	public function init()
	{
		$this->registerPT();
	}
	
	/**************************************************************************/

	public static function getPTName()
	{
		return('user');
	}
	
	/**************************************************************************/
	
	public static function getPTCategoryName()
	{
		return(self::getPTName().'_group');
	}
	
	/**************************************************************************/
	
	private function registerPT()
	{
		register_taxonomy
		(
			self::getPTCategoryName(),
			self::getPTName(),
			array
			( 
				'public'=>true,
				'labels'=>array
				(
					'name'=>__('User Groups','car-park-booking-system'),
					'singular_name'=>__('User Group','car-park-booking-system'),
					'menu_name'=>__('User Groups','car-park-booking-system'),
					'search_items'=>__('Search User Groups','car-park-booking-system'),
					'popular_items'=>__('Popular User Groups','car-park-booking-system'),
					'all_items'=>__('All User Groups','car-park-booking-system'),
					'edit_item'=>__('Edit User Group','car-park-booking-system'),
					'update_item'=>__('Update User Group','car-park-booking-system'),
					'add_new_item'=>__('Add New User Group','car-park-booking-system'),
					'new_item_name'=>__('New User Group Name','car-park-booking-system')
				),
				'update_count_callback' => function() { return; }
			)
		);
	}

	/**************************************************************************/
	
	function isSignIn()
	{
		$user=$this->getCurrentUserData();
		return((int)$user->id>0 ? true : false);
	}
	
	/**************************************************************************/
	
	function signOut()
	{
		
	}
	
	/**************************************************************************/
	
	function signIn($login,$password)
	{
		if($this->isSignIn()) $this->signOut();
   
		$credentials=array
		(
			'user_login'=>$login,
			'user_password'=>$password,
			'remember'=>true
		);
 
		$user=wp_signon($credentials,true);

		if(is_wp_error($user)) return(false);
		
		wp_set_current_user($user->ID);
		
		return(true);
	}
	
	/**************************************************************************/
	
	function getCurrentUserData()
	{
		return(wp_get_current_user());
	}
	
	/**************************************************************************/
	
	function getUserPostMeta($user=null)
	{
		if(is_null($user))
		{
			if($this->isSignIn()===false) return(false);
			else $user=wp_get_current_user();
		}
		
		$userId=$user->ID;
		
		$userMeta=get_user_meta($userId);
		
		$userMetaUserGroupKey=PLUGIN_CPBS_OPTION_PREFIX.'_user_group_id';
		
		$userMeta[$userMetaUserGroupKey]=maybe_unserialize($userMeta[$userMetaUserGroupKey][0]);
		
		return($userMeta);
	}
	
	/**************************************************************************/
	
	function validateCreateUser($email,$login,$password1,$password2)
	{
		$result=array();
		
		$Validation=new CPBSValidation();
		
		if(!$Validation->isEmailAddress($email)) $result[]='EMAIL_INVALID';
		else
		{
			if(email_exists($email)) $result[]='EMAIL_EXISTS';
		}
		
		if($Validation->isEmpty($login)) $result[]='LOGIN_INVALID';
		else
		{
			if(username_exists($login)) $result[]='LOGIN_EXISTS';				
		}
		
		if($Validation->isEmpty($password1)) $result[]='PASSWORD1_INVALID';
		if($Validation->isEmpty($password2)) $result[]='PASSWORD2_INVALID';
		
		if((!in_array('PASSWORD1_INVALID',$result)) && (!in_array('PASSWORD2_INVALID',$result)))
		{
			if(strcmp($password1,$password2)!==0)
				$result[]='PASSWORD_MISMATCH'; 
		}

		return($result);
	}
	
	/**************************************************************************/
	
	function createUser($email,$login,$password)
	{
		$data=array
		(
			'user_login'=>$login,
			'user_pass'=>$password,
			'user_email'=>$email,
			'role'=>'customer'
		);
		
		$userId=wp_insert_user($data);
		
		if(!is_wp_error($userId))
		{
			wp_set_current_user($userId);
			wp_set_auth_cookie($userId);
		}
		
		return($userId);
	}
	
	/**************************************************************************/
	
	function getUserCategory()
	{
		$category=array();
		
		$result=get_terms(array('taxonomy'=>self::getPTCategoryName(),'hide_empty'=>0));
		if(is_wp_error($result)) return($category);
		
		foreach($result as $value)
			$category[$value->{'term_id'}]=array('name'=>$value->{'name'});
		
		return($category);
	}
	
	/**************************************************************************/
	
	function editUserField($user)
	{
		$html=array(null,null);
		
		$dictionaryUserCategory=$this->getUserCategory();
		
		$userMeta=get_user_meta($user->ID);
		
		$userMetaUserGroupKey=PLUGIN_CPBS_OPTION_PREFIX.'_user_group_id';
		
		$userMeta[$userMetaUserGroupKey]=maybe_unserialize($userMeta[$userMetaUserGroupKey][0]);
		
		foreach($dictionaryUserCategory as $index=>$value)
			$html[1].='<option value="'.$index.'"'.CPBSHelper::selectedIf($userMeta[$userMetaUserGroupKey],$index,false).'>'.esc_html($value['name']).'</option>';
		
		$html[0]=
		'		
			<table class="form-table">
				<tr>
					<th>
						<label>'.esc_html('User group','car-park-booking-system').'</label>
					</th>
					<td>
						<select multiple="multiple" class="to-dropkick-disable" name="'.CPBSHelper::getFormName('user_group_id[]',false).'">
							<option value="-1"'.CPBSHelper::selectedIf($userMeta[$userMetaUserGroupKey],-1,false).'>'.esc_html__('- None -','car-park-booking-system').'</option>
							'.$html[1].'
						</select>
					</td>
				</tr>
			</table>							
		';
		
		echo $html[0];
	}
	
	/**************************************************************************/
	
	function saveUserField($user_id)
	{
		$option=CPBSHelper::getPostOption();
		
		$dictionaryUserCategory=$this->getUserCategory();
		
		if(!is_array($option['user_group_id']))
			$option['user_group_id']=array();
		
		if(in_array(-1,$option['user_group_id']))
			$option['user_group_id']=array(-1);
		else
		{
			foreach($option['user_group_id'] as $index=>$value)
			{
				if(!array_key_exists($value,$dictionaryUserCategory))
					unset($option['user_group_id'][$index]);
			}
		}
		
		if(!count($option['user_group_id']))
			$option['user_group_id']=array(-1);
		
		update_user_meta($user_id,PLUGIN_CPBS_OPTION_PREFIX.'_user_group_id',$option['user_group_id']);
	}

	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/