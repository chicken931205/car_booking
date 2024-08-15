<?php

/******************************************************************************/
/******************************************************************************/

class CPBSEmail
{
	/**************************************************************************/
	
	function __construct()
	{

	}
	
	/**************************************************************************/
	
	function phpMailerInit($mail)
	{
		global $cpbs_phpmailer;
		
		$mail->CharSet='UTF-8';
		$mail->SetFrom($cpbs_phpmailer['sender_email_address'],$cpbs_phpmailer['sender_name']);
		
		if($cpbs_phpmailer['smtp_auth_enable'])
		{
			$mail->IsSMTP();
			$mail->SMTPAuth=true; 
			
			if($cpbs_phpmailer['smtp_auth_debug_enable']==1) $mail->SMTPDebug=1;
			
			$mail->Username=$cpbs_phpmailer['smtp_auth_username'];
			$mail->Password=$cpbs_phpmailer['smtp_auth_password'];
			
			$mail->Host=$cpbs_phpmailer['smtp_auth_host'];
			$mail->Port=$cpbs_phpmailer['smtp_auth_port'];
			
			$mail->SMTPSecure=$cpbs_phpmailer['smtp_auth_secure_connection_type'];
		}		
	}
	
	/**************************************************************************/
	
	function send($recipient,$subject,$body)
	{
		$Validation=new CPBSValidation();
		foreach($recipient as $recipientIndex=>$recipientData)
		{
			if(!$Validation->isEmailAddress($recipientData))
				unset($recipient[$recipientIndex]);
		}
		
		if(!is_array($recipient)) $recipient=array();
		if(!count($recipient)) return;
		
		$header=array();
		$header[]='Content-type: text/html';	
		
		add_action('phpmailer_init',array($this,'phpMailerInit'));
		
		$result=wp_mail($recipient,$subject,$body,$header);

		return($result); 
	}
	
	/**************************************************************************/
	
	function getEmailStyle($type=1)
	{
		$style=array();
		
		/***/
		
		if(in_array($type,array(1,2)))
		{
			$style['separator'][1]='style="padding:0px;height:45px"';
			$style['separator'][2]='style="padding:0px;height:30px"';
			$style['separator'][3]='style="padding:0px;height:15px"';
		}
		else
		{
			$style['separator'][1]='class="cpbs-email-template-separator-style-1"';
			$style['separator'][2]='class="cpbs-email-template-separator-style-2"';
			$style['separator'][3]='class="cpbs-email-template-separator-style-3"';			
		}
		
		/***/
		
		if($type===1)
		{
			$style['base']='style="font-family:Arial;font-size:15px;color:#777777;line-height:150%;" bgcolor="#EEEEEE"';
		}
		elseif($type===2)
		{
			$style['base']='style="font-family:Arial;font-size:13px;color:#333333;line-height:150%;"';
		}
		elseif($type===3)
		{
			$style['base']='class="cpbs-email-template-base"';
		}
		
		/***/
		
		if(in_array($type,array(1,2)))
		{
			$style['cell'][1]='style="padding:0px 5px 0px 0px;width:250px;vertical-align:top;text-align:left;"';
			$style['cell'][2]='style="padding:0px 0px 0px 5px;width:300px;vertical-align:top;text-align:left;"';
			$style['cell'][3]='style="vertical-align:top;text-align:left;"';
		}
		elseif($type===3)
		{
			$style['cell'][1]='class="cpbs-email-template-cell-style-1"';
			$style['cell'][2]='class="cpbs-email-template-cell-style-2"';
			$style['cell'][3]='class="cpbs-email-template-cell-style-3"';			
		}
		
		/***/
			
		if($type===1)
		{
			$style['header']='style="padding:0px 0px 5px 0px;font-weight:bold;color:#444444;border-bottom:dotted 1px #AAAAAA;text-transform:uppercase;text-align:left;"';
		}
		elseif($type===2)
		{
			$style['header']='style="padding:0px 0px 5px 0px;font-weight:bold;color:#444444;text-transform:uppercase;text-align:left;"';
		}
		elseif($type===3)
		{
			$style['header']='class="cpbs-email-template-header-style-1"';
		}
		
		/***/
		
		if(in_array($type,array(1,2)))
		{
			$style['image']='style="max-width:100%;height:auto;"';
		}
		elseif($type===3)
		{
			$style['image']='class="cpbs-email-template-image-style-1"';
		}
		
		/***/
		
		if($type===1)
		{
			$style['table']='style="border:solid 1px #E1E8ED;padding:50px" width="600px"';
		}
		elseif($type===2) 
		{
			$style['table']='style="padding:50px"';
		}
		elseif($type===3)
		{
			$style['table']='class="cpbs-email-template-table-style-1"';
		}

		/***/
		
		return($style);
	}
	
	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/