<?php

/******************************************************************************/
/******************************************************************************/

class CPBSBookingHelper
{
	/**************************************************************************/
	   
	static function calculateBookingPeriod($entryDate,$entryTime,$exitDate,$exitTime,$bookingForm=null,$billingType=-1)
	{
		$period=array('day'=>0,'hour'=>0,'minute'=>0);
		
		if((int)$billingType===-1)
			$billingType=CPBSOption::getOption('billing_type');
		
		$time=strtotime($exitDate.' '.$exitTime)-strtotime($entryDate.' '.$entryTime);
		
		$hour=$time/60/60;
		$minute=$time/60;
		$day=$time/60/60/24;
		
		switch($billingType)
		{
			case 1:
				
				$period['minute']=ceil($minute);
				
			break;
			
			case 2:
				
				$period['hour']=ceil($hour);
				
			break;
		
			case 3:
				
				$period['day']=ceil($day);
				
			break;
		
			case 4:
				
				$period['hour']=floor($minute/60);
				$period['minute']=$minute-$period['hour']*60;				
				
			break;
		
			case 5:
				
				$period['day']=floor($hour/24);
				$period['hour']=ceil($hour-$period['day']*24);
		
			break;
		
			case 6:
				
				$date1=new DateTime($entryDate.' 00:00');
				$date2=new DateTime($exitDate.' 00:00');
				
				$difference=$date1->diff($date2);
	
				$period['day']=$difference->days+1;
		
			break;
		
			case 7:
				
				$period['day']=floor($hour/24);
				$period['hour']=ceil($hour-$period['day']*24);
				
				if(!is_null($bookingForm))
				{
					if($bookingForm['meta']['full_day_rounding_hour_number']<=$period['hour'])
					{
						$period['hour']-=$bookingForm['meta']['full_day_rounding_hour_number'];
						$period['day']++;
					}
				}
				
			break;
		}
		return($period);
	}
	
	/**************************************************************************/
	
	static function displayBookingPeriod($period,$billingType=-1)
	{
		$html=null;
		
		if((int)$billingType===-1)
			$billingType=CPBSOption::getOption('billing_type');

		switch($billingType)
		{
			case 1:
				
				$html=sprintf(esc_html__('%s minutes','car-park-booking-system'),$period['minute']);
				
			break;
			
			case 2:
				
				$html=sprintf(esc_html__('%s hours','car-park-booking-system'),$period['hour']);
				
			break;
		
			case 3:
				
				$html=sprintf(esc_html__('%s days','car-park-booking-system'),$period['day']);
				
			break;
		
			case 4:
						
				$html=sprintf(esc_html__('%s hours, %s minutes','car-park-booking-system'),$period['hour'],$period['minute']);
				
			break;
		
			case 5:
			case 7:
				
				$html=sprintf(esc_html__('%s days, %s hours','car-park-booking-system'),$period['day'],$period['hour']);
		
			break;
		
			case 6:
				
				$html=sprintf(esc_html__('%s days','car-park-booking-system'),$period['day']);
				
			break;
		}	
		
		return($html);
	}
	
	/**************************************************************************/
	
	static function getPaymentName($paymentId,$wooCommerceEnable=-1,$meta=array())
	{
		$Payment=new CPBSPayment();
		$WooCommerce=new CPBSWooCommerce();
		
		if($wooCommerceEnable===-1)
			$wooCommerceEnable=$WooCommerce->isEnable($meta);
		
		if($wooCommerceEnable)
		{
			$paymentName=$WooCommerce->getPaymentName($paymentId);
		}
		else
		{
			$paymentName=$Payment->getPaymentName($paymentId);
		}
		
		return($paymentName);
	}
	
	/**************************************************************************/
	
	static function isPayment(&$paymentId,$bookingFormMeta,$locationMeta)
	{
		$Payment=new CPBSPayment();
		$WooCommerce=new CPBSWooCommerce();
		
		if(($WooCommerce->isEnable($bookingFormMeta)) && ((int)$locationMeta['payment_woocommerce_step_3_enable']===0))
		{
			return(true);
		}
		
		if((int)$locationMeta['payment_mandatory_enable']===0)
		{
			if($WooCommerce->isEnable($bookingFormMeta))
			{
				if(empty($paymentId))
				{
					$paymentId=0;
					return(true);
				}
			}
			else
			{
				if($paymentId==0)
				{
					return(true);
				}
			}
		}
		
		if($WooCommerce->isEnable($bookingFormMeta))
		{
			return($WooCommerce->isPayment($paymentId));
		}
		else
		{
			if(!$Payment->isPayment($paymentId)) return(false);
		}
		
		return(true);
	}
	
	/**************************************************************************/
	
	static function formatDateTimeToStandard($data,$bookingForm=null)
	{
		$Date=new CPBSDate();
		
		CPBSHelper::removeUIndex($data,'entry_date','entry_time','exit_date','exit_time');
		
		$data['entry_date']=$Date->formatDateToStandard($data['entry_date']);
		$data['exit_date']=$Date->formatDateToStandard($data['exit_date']);

		$data['entry_time']=$Date->formatTimeToStandard($data['entry_time']);
		$data['exit_time']=$Date->formatTimeToStandard($data['exit_time']);
		
		if(is_array($bookingForm))
		{
			if((int)$bookingForm['meta']['time_field_enable']!==1)
			{
				$BookingForm=new CPBSBookingForm();
				
				$locationId=$BookingForm->getLocationId($data,$bookingForm);	
				
				if($locationId>0)
				{
					for($i=0;$i<2;$i++)
					{
						$businessHourIndex=null;
						$businessHour=$BookingForm->getBookingFormBusinessHour($bookingForm['dictionary']['location'][$locationId]['meta']['business_hour'],$i+2);	
						
						$date=$i===0 ? $data['entry_date'] : $data['exit_date'];
						$time=$i===0 ? $data['entry_time'] : $data['exit_time'];
						
						$number=$Date->getDayNumberOfWeek($date);

						if(isset($businessHour['available'][$date])) $businessHourIndex=$date;
						elseif(isset($businessHour['available'][$number])) $businessHourIndex=$number;

						if(!is_null($businessHourIndex))
						{
							if($i===0) $data['entry_time']=$businessHour['available'][$businessHourIndex][0]['start'];
							else $data['exit_time']=$businessHour['available'][$businessHourIndex][0]['stop'];
						}
					}
				}
			}			
		}	

		return($data);
	}

	/**************************************************************************/
	
	static function enableSelectLocation($bookingForm)
	{
		if((int)$bookingForm['meta']['location_single_display_enable']===1) return(true);
		
		if(count($bookingForm['dictionary']['location'])>1) return(true);
		
		return(false);
	}
	
	/**************************************************************************/
	
	static function enableTimeField($bookingForm)
	{
		if((int)$bookingForm['meta']['time_field_enable']===1) return(true);
		
		return(false);
	}
	
	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/