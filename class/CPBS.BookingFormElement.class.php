<?php

/******************************************************************************/
/******************************************************************************/

class CPBSBookingFormElement
{
	/**************************************************************************/
	
	function __construct()
	{
		$this->fieldType=array
		(
			1=>array(__('Text','car-park-booking-system')),
			2=>array(__('Select list','car-park-booking-system')),
			3=>array(__('Select list with empty first option','car-park-booking-system'))
		);		
	}
	
	/**************************************************************************/
	
	function getFieldType()
	{
		return($this->fieldType);
	}
	
	/**************************************************************************/
	
	function isFieldType($fieldType)
	{
		return(array_key_exists($fieldType,$this->getFieldType()) ? true : false);
	}
	
	/**************************************************************************/
	   
	function save($bookingFormId)
	{
		/***/
		
		$formElementPanel=array();
		$formElementPanelPost=CPBSHelper::getPostValue('form_element_panel');
		
		if(isset($formElementPanelPost['id']))
		{
			$Validation=new CPBSValidation();
			
			foreach($formElementPanelPost['id'] as $index=>$value)
			{
				if($Validation->isEmpty($formElementPanelPost['label'][$index])) continue;
				
				if($Validation->isEmpty($value))
					$value=CPBSHelper::createId();
				
				$formElementPanel[]=array('id'=>$value,'label'=>$formElementPanelPost['label'][$index]);
			}
		}
		
		CPBSPostMeta::updatePostMeta($bookingFormId,'form_element_panel',$formElementPanel); 
		
		$meta=CPBSPostMeta::getPostMeta($bookingFormId);
		
		/***/
		
		$formElementField=array();
		$formElementFieldPost=CPBSHelper::getPostValue('form_element_field');			
		
		if(isset($formElementFieldPost['id']))
		{
			$Validation=new CPBSValidation();
			
			$panelDictionary=$this->getPanel($meta);
			
			foreach($formElementFieldPost['id'] as $index=>$value)
			{
				if(!isset($formElementFieldPost['label'][$index],$formElementFieldPost['type'][$index],$formElementFieldPost['mandatory'][$index],$formElementFieldPost['dictionary'][$index],$formElementFieldPost['message_error'][$index],$formElementFieldPost['panel_id'][$index])) continue;
				
				if($Validation->isEmpty($formElementFieldPost['label'][$index])) continue;
				
				if(!$this->isFieldType($formElementFieldPost['type'][$index])) continue;
				
				if((int)$formElementFieldPost['type'][$index]===2)
				{
					if($Validation->isEmpty($formElementFieldPost['dictionary'][$index])) continue;
				}
				
				if(!$Validation->isBool((int)$formElementFieldPost['mandatory'][$index])) continue;
				else 
				{
					if($formElementFieldPost['mandatory'][$index]==1)
					{	
						if($Validation->isEmpty($formElementFieldPost['message_error'][$index])) continue;
					}
				}
				
				if(!$this->isPanel($formElementFieldPost['panel_id'][$index],$panelDictionary)) continue;
				
				if($Validation->isEmpty($value))
					$value=CPBSHelper::createId();
				
				$formElementField[]=array('id'=>$value,'label'=>$formElementFieldPost['label'][$index],'type'=>$formElementFieldPost['type'][$index],'mandatory'=>$formElementFieldPost['mandatory'][$index],'dictionary'=>$formElementFieldPost['dictionary'][$index],'message_error'=>$formElementFieldPost['message_error'][$index],'panel_id'=>$formElementFieldPost['panel_id'][$index]);
			}
		}
		
		CPBSPostMeta::updatePostMeta($bookingFormId,'form_element_field',$formElementField); 
		
		/***/
		
		$formElementAgreement=array();
		$formElementAgreementPost=CPBSHelper::getPostValue('form_element_agreement');		
		
		if(isset($formElementAgreementPost['id']))
		{
			$Validation=new CPBSValidation();
			
			foreach($formElementAgreementPost['id'] as $index=>$value)
			{
				if(!isset($formElementAgreementPost['text'][$index])) continue;
				if($Validation->isEmpty($formElementAgreementPost['text'][$index])) continue;
				
				if($Validation->isEmpty($value))
					$value=CPBSHelper::createId();
				
				$formElementAgreement[]=array('id'=>$value,'text'=>$formElementAgreementPost['text'][$index]);
			}
		}		
		
		CPBSPostMeta::updatePostMeta($bookingFormId,'form_element_agreement',$formElementAgreement);		
	}
	
	/**************************************************************************/
	
	function getPanel($meta)
	{
		$panel=array
		(
			array
			(
				'id'=>1,
				'label'=>esc_html__('- Contact details -','car-park-booking-system')
			),
			array
			(
				'id'=>2,
				'label'=>esc_html__('- Billing address -','car-park-booking-system')
			)
		);
			 
		if(isset($meta['form_element_panel']))
		{
			foreach($meta['form_element_panel'] as $value)
				$panel[]=$value;
		}
		
		return($panel);
	}

	/**************************************************************************/
	
	function isPanel($panelId,$panelDictionary)
	{
		foreach($panelDictionary as $value)
		{
			if($value['id']==$panelId) return(true);
		}
		
		return(false);
	}
	
	/**************************************************************************/
	
	function createField($panelId,$meta)
	{
		$html=array(null,null);
		
		$Validation=new CPBSValidation();
		
		if(!array_key_exists('form_element_field',$meta)) return(null);
		
		foreach($meta['form_element_field'] as $value)
		{
			if($value['panel_id']==$panelId)
			{
				$name='form_element_field_'.$value['id'];
				
				$html[1].=
				'
					<div class="cpbs-clear-fix">
						<div class="cpbs-form-field cpbs-form-field-width-100">
							<label>'.esc_html($value['label']).((int)$value['mandatory']===1 ? ' *' : '').'</label>
				';
				
				if(in_array((int)$value['type'],array(2,3)))
				{
					$fieldHtml=null;
					$fieldValue=preg_split('/;/',$value['dictionary']);

					foreach($fieldValue as $fieldValueValue)
					{
						if($Validation->isNotEmpty($fieldValueValue))
							$fieldHtml.='<option value="'.esc_attr($fieldValueValue).'"'.CPBSHelper::selectedIf($fieldValueValue,CPBSHelper::getPostValue($name),false).'>'.esc_html($fieldValueValue).'</option>';
					}

					$html[1].=
					'
						<select name="'.CPBSHelper::getFormName($name,false).'">
							'.$fieldHtml.'
						</select>
					';	
				}
				elseif((int)$value['type']===1)
				{
					$html[1].=
					'
						<input type="text" name="'.CPBSHelper::getFormName($name,false).'"  value="'.esc_attr(CPBSHelper::getPostValue($name)).'"/>
					';
				}

				$html[1].=
				'							
						</div>						
					</div>
				';
			}
		}
		
		if(array_key_exists('form_element_panel',$meta))
		{
			if(!in_array($panelId,array(1,2)))
			{
				foreach($meta['form_element_panel'] as $value)
				{
					if($value['id']==$panelId)
					{
						$html[0].=
						'
							<label class="cpbs-form-panel-label">'.esc_html($value['label']).'</label> 
						';
					}
				}
			}
		}
		
		if($Validation->isNotEmpty($html[0]))
		{
			$html=
			'
				<div class="cpbs-form-panel">
					'.$html[0].'
					<div class="cpbs-form-panel-content cpbs-clear-fix">
						'.$html[1].'
					</div>
				</div>
			';
		}
		else $html=$html[1];
		
		return($html);
	}
	
	/**************************************************************************/
	
	function createAgreement($meta)
	{
		$html=null;
		$Validation=new CPBSValidation();
		
		if(!array_key_exists('form_element_agreement',$meta)) return($html);
		
		foreach($meta['form_element_agreement'] as $value)
		{
			$html.=
			'
				<div class="cpbs-clear-fix">
					<span class="cpbs-form-checkbox cpbs-state-selected"  data-value="1">
						<span class="cpbs-meta-icon-tick"></span>
					</span>
					<span>'.$value['text'].'</span>
					<input type="hidden" name="'.CPBSHelper::getFormName('form_element_agreement_'.$value['id'],false).'" value="1"/> 
				</div>	  
			';
		}
		
		if($Validation->isNotEmpty($html))
		{
			$html=
			'
				<div class="cpbs-header cpbs-header-style-3">'.esc_html__('Agreements','car-park-booking-system').'</div>
				<div class="cpbs-agreement">
					'.$html.'
				</div>
			';
		}
		
		return($html);
	}
	
	/**************************************************************************/
	
	function validateField($meta,$data)
	{
		$error=array();
		
		$Validation=new CPBSValidation();
		
		if(!array_key_exists('form_element_field',$meta)) return($error);
		
		foreach($meta['form_element_field'] as $value)
		{
			$name='form_element_field_'.$value['id'];
			
			if((int)$value['mandatory']===1)
			{
				if(array_key_exists($name,$data))
				{
					if($value['panel_id']==2)
					{
						if((int)$data['client_billing_detail_enable']===1)
						{
							if($Validation->isEmpty($data[$name]))
								$error[]=array('name'=>CPBSHelper::getFormName($name,false),'message_error'=>$value['message_error']);							
						}
					}
					else
					{
						if((int)$value['type']===3)
						{
							$dictionary=preg_split('/;/',$value['dictionary']);
							if($dictionary[0]==$data[$name])
								$error[]=array('name'=>CPBSHelper::getFormName($name,false),'message_error'=>$value['message_error']);
						}
						else
						{
							if($Validation->isEmpty($data[$name]))
								$error[]=array('name'=>CPBSHelper::getFormName($name,false),'message_error'=>$value['message_error']);
						}
					}
				}
			}
		}
		
		return($error);
	}
	
	/**************************************************************************/
	
	function validateAgreement($meta,$data)
	{
		if(!array_key_exists('form_element_agreement',$meta)) return(false);
		
		foreach($meta['form_element_agreement'] as $value)
		{
			$name='form_element_agreement_'.$value['id'];  
			
			if((!array_key_exists($name,$data)) || ((int)$data[$name]!==1))
				return(true);
		}
		
		return(false);
	}
	
	/**************************************************************************/
	
	function sendBookingField($bookingId,$meta,$data)
	{
		if(!array_key_exists('form_element_field',$meta)) return;
		
		foreach($meta['form_element_field'] as $index=>$value)
		{
			$name='form_element_field_'.$value['id']; 
			$meta['form_element_field'][$index]['value']=$data[$name];
		}
		
		CPBSPostMeta::updatePostMeta($bookingId,'form_element_panel',$meta['form_element_panel']);
		CPBSPostMeta::updatePostMeta($bookingId,'form_element_field',$meta['form_element_field']);
	}
	
	/**************************************************************************/
	
	function sendBookingAgreement($bookingId,$meta,$data)
	{
		if(!array_key_exists('form_element_agreement',$meta)) return;
		
		foreach($meta['form_element_agreement'] as $index=>$value)
		{
			$meta['form_element_agreement'][$index]['value']=1;
			$meta['form_element_agreement'][$index]['text']=$value['text'];
		}
		
		CPBSPostMeta::updatePostMeta($bookingId,'form_element_agreement',$meta['form_element_agreement']);
	}
	
	/**************************************************************************/
	
	function displayField($panelId,$meta,$type=1,$argument=array())
	{
		$html=null;
		
		if(!array_key_exists('form_element_field',$meta)) return($html);
		
		foreach($meta['form_element_field'] as $value)
		{
			if($value['panel_id']==$panelId)
			{
				if($type==1)
				{
					$html.=
					'
						<div>
							<span class="to-legend-field">'.esc_html($value['label']).'</span>
							<div class="to-field-disabled">'.esc_html($value['value']).'</div>								
						</div>	
					';
				}
				elseif($type==2)
				{
					$html.=
					'
						<tr>
							<td '.$argument['style']['cell'][1].'>'.esc_html($value['label']).'</td>
							<td '.$argument['style']['cell'][2].'>'.esc_html($value['value']).'</td>
						</tr>
					';					
				}
			}
		}
		
		return($html);
	}

	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/