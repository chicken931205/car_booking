<?php

/******************************************************************************/
/******************************************************************************/

class CPBSPaymentPaypal
{
	/**************************************************************************/
	
	function __construct()
	{

	}
	
	/**************************************************************************/
	
	function createPaymentForm($postId,$locationId,$location)
	{
		$Validation=new CPBSValidation();
		
		$formURL='https://www.paypal.com/cgi-bin/webscr';
		if((int)$location['meta']['payment_paypal_sandbox_mode_enable']===1)
			$formURL='https://www.sandbox.paypal.com/cgi-bin/webscr';
		
		$successUrl=$location['meta']['payment_paypal_success_url_address'];
		if($Validation->isEmpty($successUrl)) $successUrl=add_query_arg('action','success',get_the_permalink($postId));
		
		$cancelUrl=$location['meta']['payment_paypal_cancel_url_address'];
		if($Validation->isEmpty($cancelUrl)) $cancelUrl=add_query_arg('action','cancel',get_the_permalink($postId));	
		
		$html=
		'
			<form action="'.esc_attr($formURL).'" method="post" name="cpbs-form-paypal" data-location-id="'.(int)$locationId.'">
				<input type="hidden" name="cmd" value="_xclick">
				<input type="hidden" name="business" value="'.esc_attr($location['meta']['payment_paypal_email_address']).'">				
				<input type="hidden" name="item_name" value="">
				<input type="hidden" name="item_number" value="0">
				<input type="hidden" name="amount" value="0.00">	
				<input type="hidden" name="currency_code" value="'.esc_attr(CPBSOption::getOption('currency')).'">
				<input type="hidden" value="1" name="no_shipping">
				<input type="hidden" value="'.esc_url(get_the_permalink($postId)).'?action=ipn" name="notify_url">				
				<input type="hidden" value="'.esc_url($successUrl).'?action=success" name="return">
				<input type="hidden" value="'.esc_url($cancelUrl).'?action=cancel" name="cancel_return">
			</form>
		';
		
		return($html);
	}
	
	/**************************************************************************/
	
	function handleIPN()
	{
		$Booking=new CPBSBooking();
		$Location=new CPBSLocation();
		$BookingStatus=new CPBSBookingStatus();
		
		$LogManager=new CPBSLogManager();
		
		$LogManager->add('paypal',2,__('[1] Receiving a payment.','car-park-booking-system'));	
		
		$bookingId=(int)$_POST['item_number'];
		
		$booking=$Booking->getBooking($bookingId);
		if((!is_array($booking)) || (!count($booking))) 
		{
			$LogManager->add('paypal',2,sprintf(__('[2] Booking %s is not found.','car-park-booking-system'),$bookingId));	
			return;
		}
		
		$locationId=$booking['meta']['location_id'];
		$dictionary=$Location->getDictionary(array('location_id'=>$locationId));
		
		if((!is_array($dictionary)) || (count($dictionary)!=1))
		{	
			$LogManager->add('paypal',2,sprintf(__('[3] Location %s is not found.','car-park-booking-system'),$locationId));	
			return;
		}
		
		$request='cmd='.urlencode('_notify-validate');
		
		$postData=CPBSHelper::stripslashes($_POST);
		
		foreach($postData as $key=>$value) 
			$request.='&'.$key.'='.urlencode($value);

		$address='https://ipnpb.paypal.com/cgi-bin/webscr';
		if($dictionary[$locationId]['meta']['payment_paypal_sandbox_mode_enable']==1)
			$address='https://ipnpb.sandbox.paypal.com/cgi-bin/webscr';
		
		$LogManager->add('paypal',2,sprintf(__('[4] Sending a request: %s on address: %s.','car-park-booking-system'),$request,$address));
		
		$ch=curl_init();
		curl_setopt($ch,CURLOPT_URL,$address);
		curl_setopt($ch,CURLOPT_POST,1);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch,CURLOPT_POSTFIELDS,$request);
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,1);
		curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,2);
		$response=curl_exec($ch);
		 
		if(curl_errno($ch)) 
		{	
			$LogManager->add('paypal',2,sprintf(__('[5] Error %s during processing cURL request.','car-park-booking-system'),curl_error($ch)));	
			return;
		}
		
		if(!strcmp(trim($response),'VERIFIED')==0)
		{
			$LogManager->add('paypal',2,sprintf(__('[6] Request cannot be verified: %s.','car-park-booking-system'),$response));	
			return;
		}
		
		$meta=CPBSPostMeta::getPostMeta($bookingId);
				
		if(!((array_key_exists('payment_paypal_data',$meta)) && (is_array($meta['payment_paypal_data']))))
            $meta['payment_paypal_data']=array();
		
		$meta['payment_paypal_data'][]=$postData;
		
        CPBSPostMeta::updatePostMeta($bookingId,'payment_paypal_data',$meta['payment_paypal_data']);
		
		$LogManager->add('paypal',2,__('[7] Updating a booking about transaction details.','car-park-booking-system'));
		
		if($postData['payment_status']=='Completed')
		{
			if(CPBSOption::getOption('booking_status_payment_success')!=-1)
			{
				if($BookingStatus->isBookingStatus(CPBSOption::getOption('booking_status_payment_success')))
				{
					$LogManager->add('paypal',2,__('[11] Updating booking status.','car-park-booking-system'));
					
					$bookingOld=$Booking->getBooking($bookingId);

					CPBSPostMeta::updatePostMeta($bookingId,'booking_status_id',CPBSOption::getOption('booking_status_payment_success'));

					$bookingNew=$Booking->getBooking($bookingId);

					$emailAdminSend=false;
					$emailClientSend=false;

					$locationDictionary=$Location->getDictionary();

					if(array_key_exists($bookingNew['meta']['location_id'],$locationDictionary))
					{
						$location=$locationDictionary[$bookingNew['meta']['location_id']];

						$subject=sprintf(__('New booking "%s" has been received','car-park-booking-system'),$bookingNew['post']->post_title);

						if(((int)$location['meta']['booking_new_customer_email_notification']===1) && ((int)$location['meta']['booking_new_customer_email_notification_payment_success']===1))
						{
							$cpbs_logEvent=1;
							$emailClientSend=true;
							$Booking->sendEmail($post->ID,$location['meta']['booking_new_sender_email_account_id'],'booking_new_client',array($bookingNew['meta']['client_contact_detail_email_address']),$subject);
						}

						if(((int)$location['meta']['booking_new_admin_email_notification']===1) && ((int)$location['meta']['booking_new_admin_email_notification_payment_success']===1))
						{
							$cpbs_logEvent=2;
							$emailAdminSend=true;
							$Booking->sendEmail($post->ID,$location['meta']['booking_new_sender_email_account_id'],'booking_new_admin',preg_split('/;/',$location['meta']['booking_new_recipient_email_address']),$subject);
						}
					}

					if(!$emailClientSend)
					{
						$emailSend=false;

						$WooCommerce=new CPBSWooCommerce();
						$WooCommerce->changeStatus(-1,$post->ID,$emailSend);									

						if(!$emailSend)
							$Booking->sendEmailBookingChangeStatus($bookingOld,$bookingNew);
					}					
				}
				else
				{
					$LogManager->add('paypal',2,__('[10] Cannot find a valid booking status.','car-park-booking-system'));	
				}
			}
			else
			{
				$LogManager->add('paypal',2,__('[9] Changing status of the booking after successful payment is off.','car-park-booking-system'));
			}		
		}
		else
		{
			$LogManager->add('paypal',2,sprintf(__('[8] Payment status %s is not supported.','car-park-booking-system'),$postData['payment_status']));
		}
	}
	
	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/