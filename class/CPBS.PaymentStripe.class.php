<?php

/******************************************************************************/
/******************************************************************************/

class CPBSPaymentStripe
{
	/**************************************************************************/
	
	function __construct()
	{
		$this->apiVersion='2020-08-27';
		
		$this->paymentMethod=array
		(
			'alipay'=>array(__('Alipay','car-park-booking-system')),
			'card'=>array(__('Cards','car-park-booking-system')),			
			'ideal'=>array(__('iDEAL','car-park-booking-system')),
			'fpx'=>array(__('FPX','car-park-booking-system')),
			'bacs_debit'=>array(__('Bacs Direct Debit','car-park-booking-system')),
			'bancontact'=>array(__('Bancontact','car-park-booking-system')),
			'giropay'=>array(__('Giropay','car-park-booking-system')),
			'p24'=>array(__('Przelewy24','car-park-booking-system')),
			'eps'=>array(__('EPS','car-park-booking-system')),
			'sofort'=>array(__('Sofort','car-park-booking-system')),
			'sepa_debit'=>array(__('SEPA Direct Debit','car-park-booking-system'))
		);
		
		$this->event=array
		(
			'payment_intent.canceled',
			'payment_intent.created',
			'payment_intent.payment_failed',
			'payment_intent.processing',
			'payment_intent.requires_action',
			'payment_intent.succeeded',
			'payment_method.attached'
		);
		
		asort($this->paymentMethod);
	}
	
	/**************************************************************************/
	
	function getPaymentMethod()
	{
		return($this->paymentMethod);
	}
	
	/**************************************************************************/
	
	function isPaymentMethod($paymentMethod)
	{
		return(array_key_exists($paymentMethod,$this->paymentMethod) ? true : false);
	}
	
	/**************************************************************************/
	
	function getWebhookEndpointUrlAdress()
	{
		$address=add_query_arg('action','payment_stripe',home_url().'/');
		return($address);
	}
	
	/**************************************************************************/
	
	function createWebhookEndpoint($location)
	{
		$StripeClient=new \Stripe\StripeClient(['api_key'=>$location['meta']['payment_stripe_api_key_secret'],'stripe_version'=>$this->apiVersion]);
		
		$webhookEndpoint=$StripeClient->webhookEndpoints->create(['url'=>$this->getWebhookEndpointUrlAdress(),'enabled_events'=>$this->event]);		
		
		CPBSOption::updateOption(array('payment_stripe_webhook_endpoint_id'=>$webhookEndpoint->id));
	}
	
	/**************************************************************************/
	
	function updateWebhookEndpoint($location,$webhookEndpointId)
	{
		$StripeClient=new \Stripe\StripeClient(['api_key'=>$location['meta']['payment_stripe_api_key_secret'],'stripe_version'=>$this->apiVersion]);
		
		$StripeClient->webhookEndpoints->update($webhookEndpointId,['url'=>$this->getWebhookEndpointUrlAdress()]);
	}
	
	/**************************************************************************/
	
	function createSession($booking,$bookingBilling,$bookingForm)
	{
        try
		{
			\Stripe\Stripe::setApiVersion($this->apiVersion);
			
			$Validation=new CPBSValidation();

			$locationId=$booking['meta']['location_id'];

			$location=$bookingForm['dictionary']['location'][$locationId];

			/***/

			Stripe\Stripe::setApiKey($location['meta']['payment_stripe_api_key_secret']);

			/***/

			$webhookEndpointId=CPBSOption::getOption('payment_stripe_webhook_endpoint_id');

			if($Validation->isEmpty($webhookEndpointId)) $this->createWebhookEndpoint($location);
			else
			{
				try
				{
					$this->updateWebhookEndpoint($location,$webhookEndpointId);
				} 
				catch (Exception $ex) 
				{
					$this->createWebhookEndpoint($location);
				}
			}

			/***/

			$productId=$location['meta']['payment_stripe_product_id'];

			if($Validation->isEmpty($productId))
			{
				$product=\Stripe\Product::create(
				[
					'name'=>__('Car Park Service','car-park-booking-system')
				]);		

				$productId=$product->id;

				CPBSPostMeta::updatePostMeta($locationId,'payment_stripe_product_id',$productId);
			}

			/***/

			$price=\Stripe\Price::create(
			[
				'product'=>$productId,
				'unit_amount'=>$bookingBilling['summary']['value_gross']*100,
				'currency'=>$booking['meta']['currency_id'],
			]);

			/***/

			$currentURLAddress=home_url();
	
			if($Validation->isEmpty($location['meta']['payment_stripe_cancel_url_address']))
				$location['meta']['payment_stripe_cancel_url_address']=$currentURLAddress;
			
			if((int)$location['meta']['payment_stripe_booking_summary_page_id']>0)
			{
				if(($urlAddress=get_permalink((int)$location['meta']['payment_stripe_booking_summary_page_id']))!==false)
				{
					$BookingSummary=new CPBSBookingSummary();
					$location['meta']['payment_stripe_success_url_address']=CPBSHelper::buildURLAddress($urlAddress,array('booking_id'=>$booking['post']->ID,'access_token'=>$BookingSummary->getAccessToken($booking['post']->ID)));
				}
			}
			
			if($Validation->isEmpty($location['meta']['payment_stripe_success_url_address']))
				$location['meta']['payment_stripe_success_url_address']=$currentURLAddress;

			/***/
				
			$session=\Stripe\Checkout\Session::create
			(
				[
					'payment_method_types'=>$location['meta']['payment_stripe_method'],
					'mode'=>'payment',
					'line_items'=>
					[
						[
							'price'=>$price->id,
							'quantity'=>1
						]
					],
					'success_url'=>$location['meta']['payment_stripe_success_url_address'],
					'cancel_url'=>$location['meta']['payment_stripe_cancel_url_address'],
					'customer_email'=>$booking['meta']['client_contact_detail_email_address']
				]		
			);

			CPBSPostMeta::updatePostMeta($booking['post']->ID,'payment_stripe_intent_id',$session->payment_intent);

			return($session->id);
        }
  		catch(Exception $ex) 
		{
			$LogManager=new CPBSLogManager();
			$LogManager->add('stripe',1,$ex->__toString());
			return(false);
		}
	}
	
	/**************************************************************************/
	
	function receivePayment()
	{
		$LogManager=new CPBSLogManager();
		
		if(!array_key_exists('action',$_REQUEST)) return(false);
		
		if($_REQUEST['action']=='payment_stripe')
		{
			$LogManager->add('stripe',2,__('[1] Receiving a payment.','car-park-booking-system'));	
			
			global $post;
			
			$event=null;
			$content=@file_get_contents('php://input');
	
			try 
			{
				$event=\Stripe\Event::constructFrom(json_decode($content,true));
			} 
			catch(\UnexpectedValueException $e) 
			{
				$LogManager->add('stripe',2,__('[2] Error during parsing data in JSON format.','car-park-booking-system'));	
				http_response_code(400);
				exit();
			}	
			
			if(in_array($event->type,$this->event))
			{
				$LogManager->add('stripe',2,__('[4] Checking a booking.','car-park-booking-system'));	
				
				$Booking=new CPBSBooking();
				$Location=new CPBSLocation();
				$BookingStatus=new CPBSBookingStatus();
				
				$argument=array
				(
                    'post_type'=>CPBSBooking::getCPTName(),
                    'posts_per_page'=>-1,
                    'meta_query'=>array
                    (
                        array
                        (
                            'key'=>PLUGIN_CPBS_CONTEXT.'_payment_stripe_intent_id',
                            'value'=>$event->data->object->id
                        )                      
                    )
				);
				
                CPBSHelper::preservePost($post,$bPost);
				
	            $query=new WP_Query($argument);
                if($query!==false) 
                {
					if($query->found_posts)
					{
						$LogManager->add('stripe',2,sprintf(__('[6] Booking %s is found.','car-park-booking-system'),$event->data->object->id));	
					
						while($query->have_posts())
						{
							$query->the_post();

							$meta=CPBSPostMeta::getPostMeta($post);

							if(!array_key_exists('payment_stripe_data',$meta)) $meta['payment_stripe_data']=array();

							$meta['payment_stripe_data'][]=$event;

							CPBSPostMeta::updatePostMeta($post->ID,'payment_stripe_data',$meta['payment_stripe_data']);

							$LogManager->add('stripe',2,__('[7] Updating a booking about transaction details.','car-park-booking-system'));
							
							if($event->type=='payment_intent.succeeded')
							{
								if(CPBSOption::getOption('booking_status_payment_success')!=-1)
								{
									if($BookingStatus->isBookingStatus(CPBSOption::getOption('booking_status_payment_success')))
									{
										$LogManager->add('stripe',2,__('[11] Updating booking status.','car-park-booking-system'));
										
										$bookingOld=$Booking->getBooking($post->ID);

										CPBSPostMeta::updatePostMeta($post->ID,'booking_status_id',CPBSOption::getOption('booking_status_payment_success'));

										$bookingNew=$Booking->getBooking($post->ID);

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
										$LogManager->add('stripe',2,__('[10] Cannot find a valid booking status.','car-park-booking-system'));	
									}
								}
								else
								{
									$LogManager->add('stripe',2,__('[9] Changing status of the booking after successful payment is off.','car-park-booking-system'));	
								}
							}
							else
							{
								$LogManager->add('stripe',2,sprintf(__('[8] Event %s is not supported.','car-park-booking-system'),$event->type));	
							}

							break;
						}
					}
					else
					{
						$LogManager->add('stripe',2,sprintf(__('[5] Booking %s is not found.','car-park-booking-system'),$event->data->object->id));	
					}
				}
			
				CPBSHelper::preservePost($post,$bPost,0);
			}
			else 
			{
				$LogManager->add('stripe',2,sprintf(__('[3] Event %s is not supported.','car-park-booking-system'),$event->type));	
			}
			
			http_response_code(200);
			exit();
		}
	}
	
	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/