<?php
		$Date=new CPBSDate();
		$Validation=new CPBSValidation();
		$BookingFormElement=new CPBSBookingFormElement();

		if((int)$this->data['document_header_exclude']!==1)
		{
?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">

		<head>
<?php
			if(is_rtl())
			{
?>
				<style>
					body
					{
						direction:rtl;
					}
				</style>
<?php		
			}
?>
		</head>

		<body>
<?php
		}
?>
			<table cellspacing="0" cellpadding="0" width="100%" border="0" <?php echo $this->data['style']['base']; ?>>
				<tr height="50px"><td></td></tr>
				<tr>
					<td>
						<table cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#FFFFFF" <?php echo $this->data['style']['table']; ?>>
<?php
		if((int)$this->data['document_header_exclude']!==1)
		{
			$logo=CPBSOption::getOption('logo');
			if($Validation->isNotEmpty($logo))
			{
?>
							<tr>
								<td>
									<img <?php echo $this->data['style']['image']; ?> src="<?php echo esc_attr($logo); ?>" alt=""/>
									<br/><br/>
								</td>
							</tr>						   
<?php
			}
		}
?>
							<tr>
								<td <?php echo $this->data['style']['header']; ?>><?php esc_html_e('General','car-park-booking-system'); ?></td>
							</tr>
							<tr><td <?php echo $this->data['style']['separator'][3]; ?>></td></tr>
							<tr>
								<td>
									<table cellspacing="0" cellpadding="0">
										<tr>
											<td <?php echo $this->data['style']['cell'][1]; ?>><?php esc_html_e('Title','car-park-booking-system'); ?></td>
											<td <?php echo $this->data['style']['cell'][2]; ?>><?php echo $this->data['booking']['booking_title']; ?></td>
										</tr>											
										<tr>
											<td <?php echo $this->data['style']['cell'][1]; ?>><?php esc_html_e('Status','car-park-booking-system'); ?></td>
											<td <?php echo $this->data['style']['cell'][2]; ?>><?php echo esc_html($this->data['booking']['booking_status_name']); ?></td>
										</tr>
<?php
		if(CPBSBookingHelper::enableTimeField($this->data['booking']))
		{
?>
									
										<tr>
											<td <?php echo $this->data['style']['cell'][1]; ?>><?php esc_html_e('Entry date and time','car-park-booking-system'); ?></td>
											<td <?php echo $this->data['style']['cell'][2]; ?>><?php echo esc_html($Date->formatDateToDisplay($this->data['booking']['meta']['entry_date']).' '.$Date->formatTimeToDisplay($this->data['booking']['meta']['entry_time'])); ?></td>
										</tr>	
										<tr>
											<td <?php echo $this->data['style']['cell'][1]; ?>><?php esc_html_e('Exit date and time','car-park-booking-system'); ?></td>
											<td <?php echo $this->data['style']['cell'][2]; ?>><?php echo esc_html($Date->formatDateToDisplay($this->data['booking']['meta']['exit_date']).' '.$Date->formatTimeToDisplay($this->data['booking']['meta']['exit_time'])); ?></td>
										</tr>		
<?php
		}
		else
		{
?>
										<tr>
											<td <?php echo $this->data['style']['cell'][1]; ?>><?php esc_html_e('Entry date','car-park-booking-system'); ?></td>
											<td <?php echo $this->data['style']['cell'][2]; ?>><?php echo esc_html($Date->formatDateToDisplay($this->data['booking']['meta']['entry_date'])); ?></td>
										</tr>	
										<tr>
											<td <?php echo $this->data['style']['cell'][1]; ?>><?php esc_html_e('Exit date','car-park-booking-system'); ?></td>
											<td <?php echo $this->data['style']['cell'][2]; ?>><?php echo esc_html($Date->formatDateToDisplay($this->data['booking']['meta']['exit_date'])); ?></td>
										</tr>										
<?php			
		}
?>
										<tr>
											<td <?php echo $this->data['style']['cell'][1]; ?>><?php esc_html_e('Rental period','car-park-booking-system'); ?></td>
											<td <?php echo $this->data['style']['cell'][2]; ?>><?php esc_html_e($this->data['booking']['rental_period']); ?></td>
										</tr>										
										<tr>
											<td <?php echo $this->data['style']['cell'][1]; ?>><?php esc_html_e('Order total amount','car-park-booking-system'); ?></td>
											<td <?php echo $this->data['style']['cell'][2]; ?>><?php echo esc_html(CPBSPrice::format($this->data['booking']['billing']['summary']['value_gross'],$this->data['booking']['meta']['currency_id'])); ?></td>
										</tr>	
<?php
		if($Validation->isNotEmpty($this->data['booking']['meta']['comment']))
		{
?>											
										<tr>
											<td <?php echo $this->data['style']['cell'][1]; ?>><?php esc_html_e('Comment','car-park-booking-system'); ?></td>
											<td <?php echo $this->data['style']['cell'][2]; ?>><?php echo esc_html($this->data['booking']['meta']['comment']); ?></td>
										</tr>   
<?php
		}
?>
									</table>
								</td>
							</tr>
									
							<tr><td <?php echo $this->data['style']['separator'][2]; ?>></td></tr>
							<tr>
								<td <?php echo $this->data['style']['header']; ?>><?php esc_html_e('Location','car-park-booking-system'); ?></td>
							</tr>
							<tr><td <?php echo $this->data['style']['separator'][3]; ?>></td></tr>
							<tr>
								<td>
									<table cellspacing="0" cellpadding="0">
										<tr>
											<td <?php echo $this->data['style']['cell'][1]; ?>><?php esc_html_e('Location','car-park-booking-system'); ?></td>
											<td <?php echo $this->data['style']['cell'][2]; ?>><?php echo esc_html($this->data['booking']['meta']['location_name']); ?></td>
										</tr>
<?php
		if($Validation->isNotEmpty($this->data['booking']['booking_email_notification_extra_information']))
		{
?>	
										<tr>
											<td <?php echo $this->data['style']['cell'][1]; ?>><?php esc_html_e('Extra information','car-park-booking-system'); ?></td>
											<td <?php echo $this->data['style']['cell'][2]; ?>><?php echo nl2br($this->data['booking']['booking_email_notification_extra_information']); ?></td>
										</tr>
<?php
		}
?>
									</table>
								</td>
							</tr>									

							<tr><td <?php echo $this->data['style']['separator'][2]; ?>></td></tr>
							<tr>
								<td <?php echo $this->data['style']['header']; ?>><?php esc_html_e('Space type','car-park-booking-system'); ?></td>
							</tr>
							<tr><td <?php echo $this->data['style']['separator'][3]; ?>></td></tr>
							<tr>
								<td>
									<table cellspacing="0" cellpadding="0">
										<tr>
											<td <?php echo $this->data['style']['cell'][1]; ?>><?php esc_html_e('Space type name','car-park-booking-system'); ?></td>
											<td <?php echo $this->data['style']['cell'][2]; ?>><?php echo esc_html($this->data['booking']['meta']['place_type_name']); ?></td>
										</tr>
									</table>
								</td>
							</tr>
<?php
		if(count($this->data['booking']['meta']['booking_extra']))
		{
?>											
							<tr><td <?php echo $this->data['style']['separator'][2]; ?>></td></tr>
							<tr>
								<td <?php echo $this->data['style']['header']; ?>><?php esc_html_e('Add-ons','car-park-booking-system'); ?></td>
							</tr>
							<tr><td <?php echo $this->data['style']['separator'][3]; ?>></td></tr>											
							<tr>
								<td>
									<table cellspacing="0" cellpadding="0">
										<tr>
											<td>
												<table cellspaccing="0" cellpadding="0">
<?php
			$i=0;
            foreach($this->data['booking']['billing']['detail'] as $index=>$value)
            {
				if($value['type']=='booking_extra')
				{
?>
													<tr>
														<td <?php echo $this->data['style']['cell'][3]; ?>>
															<?php echo (++$i).'.&nbsp;'; ?>
															<?php echo esc_html($value['quantity']); ?>
															<?php esc_html_e('x','car-park-booking-system'); ?>
															<?php echo esc_html($value['name']); ?> -
															<?php echo CPBSPrice::format($value['value_gross'],$this->data['booking']['meta']['currency_id']); ?>																
														</td>
													</tr>
									

<?php
				}
			}
?>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
<?php
		}
?>
							<tr><td <?php echo $this->data['style']['separator'][2]; ?>></td></tr>
							<tr>
								<td <?php echo $this->data['style']['header']; ?>><?php esc_html_e('Client details','car-park-booking-system'); ?></td>
							</tr>
							<tr><td <?php echo $this->data['style']['separator'][3]; ?>></td></tr>
							<tr>
								<td>
									<table cellspacing="0" cellpadding="0">
										<tr>
											<td <?php echo $this->data['style']['cell'][1]; ?>><?php esc_html_e('First name','car-park-booking-system'); ?></td>
											<td <?php echo $this->data['style']['cell'][2]; ?>><?php echo esc_html($this->data['booking']['meta']['client_contact_detail_first_name']); ?></td>
										</tr>
										<tr>
											<td <?php echo $this->data['style']['cell'][1]; ?>><?php esc_html_e('Last name','car-park-booking-system'); ?></td>
											<td <?php echo $this->data['style']['cell'][2]; ?>><?php echo esc_html($this->data['booking']['meta']['client_contact_detail_last_name']); ?></td>
										</tr>
										<tr>
											<td <?php echo $this->data['style']['cell'][1]; ?>><?php esc_html_e('E-mail address','car-park-booking-system'); ?></td>
											<td <?php echo $this->data['style']['cell'][2]; ?>><?php echo esc_html($this->data['booking']['meta']['client_contact_detail_email_address']); ?></td>
										</tr>
										<tr>
											<td <?php echo $this->data['style']['cell'][1]; ?>><?php esc_html_e('Phone number','car-park-booking-system'); ?></td>
											<td <?php echo $this->data['style']['cell'][2]; ?>><?php echo esc_html($this->data['booking']['meta']['client_contact_detail_phone_number']); ?></td>
										</tr>
										<?php echo $BookingFormElement->displayField(1,$this->data['booking']['meta'],2,array('style'=>$this->data['style'])); ?>
									</table>
								</td>
							</tr> 
<?php
		if((int)$this->data['booking']['meta']['client_billing_detail_enable']===1)
		{
?>											
							<tr><td <?php echo $this->data['style']['separator'][2]; ?>></td></tr>
							<tr>
								<td <?php echo $this->data['style']['header']; ?>><?php esc_html_e('Billing address','car-park-booking-system'); ?></td>
							</tr>
							<tr><td <?php echo $this->data['style']['separator'][3]; ?>></td></tr>
							<tr>
								<td>
									<table cellspacing="0" cellpadding="0">											
										<tr>
											<td <?php echo $this->data['style']['cell'][1]; ?>><?php esc_html_e('Company name','car-park-booking-system'); ?></td>
											<td <?php echo $this->data['style']['cell'][2]; ?>><?php echo esc_html($this->data['booking']['meta']['client_billing_detail_company_name']); ?></td>
										</tr>
										<tr>
											<td <?php echo $this->data['style']['cell'][1]; ?>><?php esc_html_e('Tax number','car-park-booking-system'); ?></td>
											<td <?php echo $this->data['style']['cell'][2]; ?>><?php echo esc_html($this->data['booking']['meta']['client_billing_detail_tax_number']); ?></td>
										</tr>
										<tr>
											<td <?php echo $this->data['style']['cell'][1]; ?>><?php esc_html_e('Street name','car-park-booking-system'); ?></td>
											<td <?php echo $this->data['style']['cell'][2]; ?>><?php echo esc_html($this->data['booking']['meta']['client_billing_detail_street_name']); ?></td>
										</tr>
										<tr>
											<td <?php echo $this->data['style']['cell'][1]; ?>><?php esc_html_e('Street number','car-park-booking-system'); ?></td>
											<td <?php echo $this->data['style']['cell'][2]; ?>><?php echo esc_html($this->data['booking']['meta']['client_billing_detail_street_number']); ?></td>
										</tr>
										<tr>
											<td <?php echo $this->data['style']['cell'][1]; ?>><?php esc_html_e('City','car-park-booking-system'); ?></td>
											<td <?php echo $this->data['style']['cell'][2]; ?>><?php echo esc_html($this->data['booking']['meta']['client_billing_detail_city']); ?></td>
										</tr>
										<tr>
											<td <?php echo $this->data['style']['cell'][1]; ?>><?php esc_html_e('State','car-park-booking-system'); ?></td>
											<td <?php echo $this->data['style']['cell'][2]; ?>><?php echo esc_html($this->data['booking']['meta']['client_billing_detail_state']); ?></td>
										</tr>
										<tr>
											<td <?php echo $this->data['style']['cell'][1]; ?>><?php esc_html_e('Postal code','car-park-booking-system'); ?></td>
											<td <?php echo $this->data['style']['cell'][2]; ?>><?php echo esc_html($this->data['booking']['meta']['client_billing_detail_postal_code']); ?></td>
										</tr>
										<tr>
											<td <?php echo $this->data['style']['cell'][1]; ?>><?php esc_html_e('Country','car-park-booking-system'); ?></td>
											<td <?php echo $this->data['style']['cell'][2]; ?>><?php echo esc_html($this->data['booking']['client_billing_detail_country_name']); ?></td>
										</tr>
										<?php echo $BookingFormElement->displayField(2,$this->data['booking']['meta'],2,array('style'=>$this->data['style'])); ?>
									</table>
								</td>
							</tr>  
<?php
		}
		
		$panel=$BookingFormElement->getPanel($this->data['booking']['meta']);
		foreach($panel as $panelIndex=>$panelValue)
		{
			if(in_array($panelValue['id'],array(1,2))) continue;
?>
							<tr><td <?php echo $this->data['style']['separator'][2]; ?>></td></tr>
							<tr>
								<td <?php echo $this->data['style']['header']; ?>><?php echo esc_html($panelValue['label']); ?></td>
							</tr>
							<tr><td <?php echo $this->data['style']['separator'][3]; ?>></td></tr>
							<tr>
								<td>
									<table cellspacing="0" cellpadding="0">   
									<?php echo $BookingFormElement->displayField($panelValue['id'],$this->data['booking']['meta'],2,array('style'=>$this->data['style'])); ?>											
									</table>
								</td>
							</tr>
<?php
		}
		
		if((array_key_exists('form_element_agreement',$this->data['booking']['meta'])) && (is_array($this->data['booking']['meta']['form_element_agreement'])) && (count($this->data['booking']['meta']['form_element_agreement'])))
		{
?>			
							<tr><td <?php echo $this->data['style']['separator'][2]; ?>></td></tr>
							<tr>
								<td <?php echo $this->data['style']['header']; ?>><?php esc_html_e('Agreements','car-park-booking-system'); ?></td>
							</tr>
							<tr><td <?php echo $this->data['style']['separator'][3]; ?>></td></tr>   
							<tr>
								<td <?php echo $this->data['style']['cell'][3]; ?>>
									<table cellspacing="0" cellpadding="0">
										<tr>
											<td <?php echo $this->data['style']['cell'][3]; ?>>
												<ol <?php echo $this->data['style']['list'][1]; ?>>
<?php
			foreach($this->data['booking']['meta']['form_element_agreement'] as $index=>$value)
			{
?>
													<li <?php echo $this->data['style']['list'][2]; ?>>
														<?php echo ((int)$value['value']===1 ? __('[YES]','car-park-booking-system') : __('[NO]','car-park-booking-system')).' '.$value['text']; ?>
													</li> 
<?php
			}
?>
												</ol>
											</td>
										</tr>
									</table>
								</td>
							</tr>
<?php		  
		}
?>
											
						<!-- -->
								
<?php
		if($Validation->isNotEmpty($this->data['booking']['meta']['payment_name']))
		{
?>
							<tr><td <?php echo $this->data['style']['separator'][2]; ?>></td></tr>
							<tr>
								<td <?php echo $this->data['style']['header']; ?>><?php esc_html_e('Payment','car-park-booking-system'); ?></td>
							</tr>
							<tr><td <?php echo $this->data['style']['separator'][3]; ?>></td></tr>
							<tr>
								<td>
									<table cellspacing="0" cellpadding="0">
										<tr>
											<td <?php echo $this->data['style']['cell'][1]; ?>><?php esc_html_e('Payment','car-park-booking-system'); ?></td>
											<td <?php echo $this->data['style']['cell'][2]; ?>><?php echo esc_html($this->data['booking']['meta']['payment_name']); ?></td>
										</tr>
									</table>
								</td>
							</tr>  
<?php	
		}
?>
					</table>
				</td>
			</tr>
			<tr height="50px"><td></td></tr>
		</table> 
<?php
		if((int)$this->data['document_header_exclude']!==1)
		{	
?>				
		</body>
	</html>
<?php
		}