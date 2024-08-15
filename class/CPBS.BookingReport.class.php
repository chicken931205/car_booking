<?php

/******************************************************************************/
/******************************************************************************/

class CPBSBookingReport
{
	/**************************************************************************/

	function __construct()
	{
	
	}

	/**************************************************************************/

	function sendEmail()
	{
		/***/
		
		global $cpbs_phpmailer;
		
		$Email=new CPBSEmail();
		$Validation=new CPBSValidation();
		$EmailAccount=new CPBSEmailAccount();
				
		if((int)CPBSOption::getOption('email_report_status')!=1) return(false);
	   		
		if(($emailAccount=$EmailAccount->getDictionary(array('email_account_id'=>CPBSOption::getOption('email_report_sender_email_account_id'))))===false) return(false);
		
		$emailRecipient=preg_split('/;/',CPBSOption::getOption('email_report_recipient_email_address'));
		foreach($emailRecipient as $index=>$value)
		{
			if(!$Validation->isEmailAddress($value,false))
				unset($emailRecipient[$index]);
		}
		if(!count($emailRecipient)) return(false);
		
		$dictionary=$this->getBooking();
		if(!count($dictionary)) return(false);
		
		$emailAccount=$emailAccount[CPBSOption::getOption('email_report_sender_email_account_id')];
		
		$cpbs_phpmailer['sender_name']=$emailAccount['meta']['sender_name'];
		$cpbs_phpmailer['sender_email_address']=$emailAccount['meta']['sender_email_address'];
		
		$cpbs_phpmailer['smtp_auth_enable']=$emailAccount['meta']['smtp_auth_enable'];
		$cpbs_phpmailer['smtp_auth_debug_enable']=$emailAccount['meta']['smtp_auth_debug_enable'];
		
		$cpbs_phpmailer['smtp_auth_username']=$emailAccount['meta']['smtp_auth_username'];
		$cpbs_phpmailer['smtp_auth_password']=$emailAccount['meta']['smtp_auth_password'];
		
		$cpbs_phpmailer['smtp_auth_host']=$emailAccount['meta']['smtp_auth_host'];
		$cpbs_phpmailer['smtp_auth_port']=$emailAccount['meta']['smtp_auth_port'];
		
		$cpbs_phpmailer['smtp_auth_secure_connection_type']=$emailAccount['meta']['smtp_auth_secure_connection_type'];
				
		/***/

		$data['style']=$Email->getEmailStyle();
		$data['booking']=$dictionary;

		/***/
		
		$Template=new CPBSTemplate($data,PLUGIN_CPBS_TEMPLATE_PATH.'email_report.php');
		$body=$Template->output();
		
		/***/
		
		$recipient=preg_split('/;/',CPBSOption::getOption('email_report_recipient_email_address'));
		$Email->send($recipient,esc_html__('Car Park Booking System Report','car-park-booking-system'),$body);
	}
	
	/**************************************************************************/
	
	function generateCSVFile()
	{
		$booking=$this->getBooking();
		if(!count($booking)) return(false);		
		
		$data=array();
		
		$document=null;
	
		$data[]=__('Booking Id','car-park-booking-system');
		$data[]=__('Entry/Exit','car-park-booking-system');
		$data[]=__('Location','car-park-booking-system');
		$data[]=__('Space type','car-park-booking-system');
		$data[]=__('Entry date','car-park-booking-system');
		$data[]=__('Entry time','car-park-booking-system');
		$data[]=__('Exit date','car-park-booking-system');
		$data[]=__('Exit time','car-park-booking-system');
		$data[]=__('Client first name','car-park-booking-system');
		$data[]=__('Client last name','car-park-booking-system');
		$data[]=__('Client e-mail address','car-park-booking-system');
		$data[]=__('Client phone number','car-park-booking-system');
		
		$document.=implode(chr(9),$data)."\r\n";
		
		foreach($booking as $index=>$value)
		{
			$data=array();
			
			$data[]=$index;
			
			$data[]=$this->getBookingEntryStatus($value['meta']);
			
			$data[]=$value['meta']['location_name'];
			$data[]=$value['meta']['place_type_name'];
			
			$data[]=$value['meta']['entry_date'];
			$data[]=$value['meta']['entry_time'];
			$data[]=$value['meta']['exit_date'];
			$data[]=$value['meta']['exit_time'];

			$data[]=$value['meta']['client_contact_detail_first_name'];
			$data[]=$value['meta']['client_contact_detail_last_name'];
			$data[]=$value['meta']['client_contact_detail_email_address'];
			$data[]=$value['meta']['client_contact_detail_phone_number'];
			
			array_walk($data,function(&$value,&$key)
			{
				$value=preg_replace('/\s+/',' ',$value);
			});
				
			$document.=implode(chr(9),$data)."\r\n";
		}
		
		header($_SERVER['SERVER_PROTOCOL'].' 200 OK');
		header('Cache-Control: public');
		header('Content-Type: text/csv');
		header('Content-Transfer-Encoding: Binary');
		header('Content-Disposition: attachment;filename=booking.csv');
		echo $document;
		die();
	}
	
	/**************************************************************************/
	
	function getBookingEntryStatus($meta)
	{
		$label=null;
		
		$currentDate=((int)CPBSOption::getOption('email_report_date_range')===1 ? date_i18n('d-m-Y',strtotime('+1 day')) : date_i18n('d-m-Y'));
		
		if(($meta['entry_date']===$currentDate) && ($meta['exit_date']===$currentDate)) 
			$label=__('Entry and exit','car-park-boking-system');
		else if($meta['entry_date']===$currentDate) 
			$label=__('Entry','car-park-boking-system');
		else if($meta['exit_date']===$currentDate) 
			$label=__('Exit','car-park-boking-system');		
		
		return($label);
	}
	
	/**************************************************************************/
	
	function getBooking()
	{
		global $post;
		
		$dictionary=array();
		$Booking=new CPBSBooking();
		
		CPBSHelper::preservePost($post,$bPost);
		
		$currentDate=((int)CPBSOption::getOption('email_report_date_range')===1 ? date_i18n('d-m-Y',strtotime('+1 day')) : date_i18n('d-m-Y'));
		
		$argument=array
		(
			'post_type'=>CPBSBooking::getCPTName(),
			'post_status'=>'publish',
			'posts_per_page'=>-1,
			'orderby'=>array('menu_order'=>'asc','title'=>'asc'),
			'suppress_filters'=>true,
			'meta_query'=>array
			(
				'relation'=>'OR',
				array
				(
					'key'=>PLUGIN_CPBS_CONTEXT.'_entry_date',
					'value'=>$currentDate,
					'compare'=>'='
				),
				array
				(
					'key'=>PLUGIN_CPBS_CONTEXT.'_exit_date',
					'value'=>$currentDate,
					'compare'=>'='
				)
			)
		);

		$query=new WP_Query($argument);
		if($query===false) return($dictionary);
		
		$status=CPBSOption::getOption('booking_status_nonblocking');
		
		while($query->have_posts())
		{
			$query->the_post();
			if(is_null($post)) continue;

			$id=$post->ID;
			
			$dictionary[$id]=$Booking->getBooking($id);
			
			if(is_array($status))
			{
				if(in_array($dictionary[$id]['meta']['booking_status_id'],$status))
				{
					unset($dictionary[$id]);
				}
			}
		}

		CPBSHelper::preservePost($post,$bPost,0);	
		
		return($dictionary);
	}
	
	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/