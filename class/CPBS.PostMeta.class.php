<?php

/******************************************************************************/
/******************************************************************************/

class CPBSPostMeta
{
	/**************************************************************************/
	
	static function getPostMeta($post)
	{
		$data=array();
		
		$prefix=PLUGIN_CPBS_CONTEXT.'_';
		
		if(!is_object($post)) $post=get_post($post);
		
		$meta=get_post_meta($post->ID);
		
		if(!is_array($meta)) $meta=array();
		
		foreach($meta as $metaIndex=>$metaData)
		{
			if(preg_match('/^'.$prefix.'/',$metaIndex))
				$data[preg_replace('/'.$prefix.'/','',$metaIndex)]=$metaData[0];
		}
		
		switch($post->post_type)
		{
			case PLUGIN_CPBS_CONTEXT.'_booking_extra':
				
				self::unserialize($data,array('location'));
				
				$BookingExtra=new CPBSBookingExtra();
				$BookingExtra->setPostMetaDefault($data);
				
			break;
		
			case PLUGIN_CPBS_CONTEXT.'_booking_form':
				
				self::unserialize($data,array('location_id','currency','field_mandatory','style_color','form_element_panel','form_element_field','form_element_agreement','geolocation_enable','location_detail_window_open_action'));
  
				$BookingForm=new CPBSBookingForm();
				$BookingForm->setPostMetaDefault($data);
				
			break;
		
			case PLUGIN_CPBS_CONTEXT.'_booking':
				
				self::unserialize($data,array('booking_extra','coordinate','payment_stripe_data','payment_paypal_data','form_element_panel','form_element_field','form_element_agreement'));
  
				$Booking=new CPBSBooking();
				$Booking->setPostMetaDefault($data);
				
			break;
		
			case PLUGIN_CPBS_CONTEXT.'_price_rule':
				
				self::unserialize($data,array('booking_form_id','location_id','place_type_id','entry_day_number','rental_date','rental_day_quantity','rental_hour_quantity','rental_minute_quantity','user_group_id'));
				
				$PriceRule=new CPBSPriceRule();
				$PriceRule->setPostMetaDefault($data);
				
			break;
		
			case PLUGIN_CPBS_CONTEXT.'_location':
				
				self::unserialize($data,array('place_type_quantity','place_type_quantity_period','booking_period_date','business_hour','date_exclude','payment_id','payment_stripe_method'));
				
				$Location=new CPBSLocation();
				$Location->setPostMetaDefault($data);
   
				if(!is_array($data['payment_id'])) $data['payment_id']=array();
				
			break;
			
			case PLUGIN_CPBS_CONTEXT.'_place_type':
				
				$PlaceType=new CPBSPlaceType();
				$PlaceType->setPostMetaDefault($data);
				
			break;
			
			case PLUGIN_CPBS_CONTEXT.'_coupon':
				
				self::unserialize($data,array('discount_rental_day_count','user_group_id'));
				
				$Coupon=new CPBSCoupon();
				$Coupon->setPostMetaDefault($data);
				
			break;
		
			case PLUGIN_CPBS_CONTEXT.'_tax_rate':
				
				$TaxRate=new CPBSTaxRate();
				$TaxRate->setPostMetaDefault($data);
				
			break;
		
			case PLUGIN_CPBS_CONTEXT.'_email_account':
				
				$EmailAccount=new CPBSEmailAccount();
				$EmailAccount->setPostMetaDefault($data);
				
			break;
		}
		
		return($data);
	}
	
	/**************************************************************************/
	
	static function unserialize(&$data,$unserializeIndex)
	{
		foreach($unserializeIndex as $index)
		{
			if(isset($data[$index]))
				$data[$index]=maybe_unserialize($data[$index]);
		}
	}
	
	/**************************************************************************/
	
	static function updatePostMeta($post,$name,$value)
	{
		$name=PLUGIN_CPBS_CONTEXT.'_'.$name;
		$postId=(int)(is_object($post) ? $post->ID : $post);
		
		update_post_meta($postId,$name,$value);
	}
	
	/**************************************************************************/
	
	static function removePostMeta($post,$name)
	{
		$name=PLUGIN_CPBS_CONTEXT.'_'.$name;
		$postId=(int)(is_object($post) ? $post->ID : $post);
		
		delete_post_meta($postId,$name);
	}
		
	/**************************************************************************/
	
	static function createArray(&$array,$index)
	{
		$array=array($index=>array());
		return($array);
	}

	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/