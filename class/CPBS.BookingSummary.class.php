<?php

/******************************************************************************/
/******************************************************************************/

class CPBSBookingSummary
{
	/**************************************************************************/
	   
	function __construct()
	{
		
	}
	
	/**************************************************************************/
	
	function getAccessToken($bookingId)
	{
		$accessToken=strtoupper(md5($bookingId.'_'.CPBSOption::getOption('security_code_1')));
		return($accessToken);
	}
	
	/**************************************************************************/
	
	function getData($bookingFormId=0)
	{
		$data=array();
		
		$Validation=new CPBSValidation();
		
		$Booking=new CPBSBooking();
		$BookingForm=new CPBSBookingForm();
			
		/***/
			
		$id=(int)CPBSHelper::getGetValue('booking_id',false);
		$bookingId=$id<=0 ? (int)CPBSHelper::getPostValue('booking_id',true) : $id;
		
		$id=(int)CPBSHelper::getPostValue('booking_form_id',true);
		$bookingFormId=$id<=0 ? $bookingFormId : $id;
		
		$accessToken=CPBSHelper::getGetValue('access_token',false);
		if($Validation->isEmpty($accessToken))
			$accessToken=CPBSHelper::getPostValue('access_token',true);
			
		if(($bookingId<=0) || ($bookingFormId<=0) || ($Validation->isEmpty($accessToken))) return(false);
		
		/***/
		
		if(($booking=$Booking->getBooking($bookingId))===false) return(false);
		
		$bookingFormDictionary=$BookingForm->getDictionary();
		if(!array_key_exists($bookingFormId,$bookingFormDictionary)) return(false);
		
		if(strcmp($accessToken,$this->getAccessToken($bookingId))!=0) return(false);
		
		/***/
		
		
		$data['access_token']=$accessToken;
		
		$data['booking_id']=$bookingId;
		$data['booking_form_id']=$bookingFormId;
		
		$data['booking']=$booking;
		$data['booking_form']=$bookingFormDictionary[$bookingFormId];
		
		/***/
		
		return($data);
	}
	
	/**************************************************************************/
	
	function createBookingSummaryPage($attr)
	{
		$Email=new CPBSEmail();
		$Booking=new CPBSBooking();
		
		/***/
		
		$default=array
		(
			'booking_form_id'=>0
		);
		
		$attribute=shortcode_atts($default,$attr);	
		
		/***/
		
		if(($data=$this->getData($attribute['booking_form_id']))===false) return(false);
	
		/***/
		
		$emailData=array();
		$templateData=array();
		
		/***/
		
		$emailData['style']=$Email->getEmailStyle(3);
		
		$emailData['booking']=$data['booking'];
		$emailData['booking']['billing']=$Booking->createBilling($data['booking_id']);
		
		$emailData['booking']['booking_title']=$data['booking']['post']->post_title;
		
		$emailData['document_header_exclude']=1;
		
		$Template=new CPBSTemplate($emailData,PLUGIN_CPBS_TEMPLATE_PATH.'email_booking.php');
		$templateData['email_body']=$Template->output();
		
		/***/
		
		$templateData['access_token']=$data['access_token'];
		
		$templateData['booking_id']=$data['booking_id'];
		$templateData['booking_form_id']=$data['booking_form_id'];
		
		$Template=new CPBSTemplate($templateData,PLUGIN_CPBS_TEMPLATE_PATH.'public/booking_summary.php');
		echo $Template->output();			
	}
	
	/**************************************************************************/
	
	function createBookingSummaryDocument()
	{
		if(!$_POST) return;
		
		if(($data=$this->getData())===false) return(false);
		
		require_once(PLUGIN_CPBS_LIBRARY_PATH.'tcpdf/tcpdf.php');
		
		$Email=new CPBSEmail();
		$Booking=new CPBSBooking();
		
		$Document=new TCPDF(PDF_PAGE_ORIENTATION,PDF_UNIT,PDF_PAGE_FORMAT,true,'UTF-8',false);

		$Document->AddPage();
		
		$Document->setPrintHeader(false);
		$Document->setPrintFooter(false);
		
		$Document->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		
		$emailData['style']=$Email->getEmailStyle(2);
		
		$emailData['booking']=$data['booking'];
		$emailData['booking']['billing']=$Booking->createBilling($data['booking_id']);
		
		$emailData['booking']['booking_title']=$data['booking']['post']->post_title;
		
		$emailData['document_header_exclude']=1;
		
		/***/

		$Template=new CPBSTemplate($emailData,PLUGIN_CPBS_TEMPLATE_PATH.'email_booking.php');
		$body=$Template->output();

		$Document->writeHTML($body,true,false,false,false,'');
		$Document->Output('booking_summary.pdf','I');
	}
	
	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/