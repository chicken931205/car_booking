<?php 
		echo $this->data['nonce']; 

		$Date=new CPBSDate();
		$PriceRule=new CPBSPriceRule();
		$Validation=new CPBSValidation();
		$BookingFormElement=new CPBSBookingFormElement();	
?>	
		<div class="to">
			<div class="ui-tabs">
				<ul>
					<li><a href="#meta-box-booking-1"><?php esc_html_e('General','car-park-booking-system'); ?></a></li>
					<li><a href="#meta-box-booking-2"><?php esc_html_e('Billing','car-park-booking-system'); ?></a></li>
					<li><a href="#meta-box-booking-3"><?php esc_html_e('Space','car-park-booking-system'); ?></a></li>
					<li><a href="#meta-box-booking-4"><?php esc_html_e('Extras','car-park-booking-system'); ?></a></li>
					<li><a href="#meta-box-booking-5"><?php esc_html_e('Client','car-park-booking-system'); ?></a></li>
					<li><a href="#meta-box-booking-6"><?php esc_html_e('Payment','car-park-booking-system'); ?></a></li>
				</ul>
				<div id="meta-box-booking-1">
					<ul class="to-form-field-list">
						<?php echo CPBSHelper::createPostIdField(__('Booking ID','car-park-booking-system')); ?>
						<li>
							<h5><?php esc_html_e('Status','car-park-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Booking status.','car-park-booking-system'); ?></span>
							<div class="to-radio-button">
<?php
		foreach($this->data['dictionary']['booking_status'] as $index=>$value)
		{
?>
									<input type="radio" value="<?php echo esc_attr($index); ?>" id="<?php CPBSHelper::getFormName('booking_status_id_'.$index); ?>" name="<?php CPBSHelper::getFormName('booking_status_id'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['booking_status_id'],$index); ?>/>
									<label for="<?php CPBSHelper::getFormName('booking_status_id_'.$index); ?>"><?php echo esc_html($value[0]); ?></label>
<?php		
		}
?>
							</div>
						</li>	   
						<li>
							<h5><?php esc_html_e('Entry date and time','car-park-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Entry date and time.','car-park-booking-system'); ?></span>
							<div class="to-field-disabled">
								<?php echo esc_html($Date->formatDateToDisplay($this->data['meta']['entry_date']).' '.$Date->formatTimeToDisplay($this->data['meta']['entry_time']));  ?>
							</div>
						</li> 
						<li>
							<h5><?php esc_html_e('Exit date and time','car-park-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Exit date and time.','car-park-booking-system'); ?></span>
							<div class="to-field-disabled">
								<?php echo esc_html($Date->formatDateToDisplay($this->data['meta']['exit_date']).' '.$Date->formatTimeToDisplay($this->data['meta']['exit_time']));  ?>
							</div>
						</li> 
						<li>
							<h5><?php esc_html_e('Location','car-park-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Location.','car-park-booking-system'); ?></span>
							<div class="to-field-disabled">
								<?php echo esc_html($this->data['meta']['location_name']);  ?>
								<div class="to-float-right"><?php edit_post_link(esc_html__('Edit','car-park-booking-system'),null,null,$this->data['meta']['location_id']); ?></div>
							</div>
						</li>
						<li>
							<h5><?php esc_html_e('Space type','car-park-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Space type.','car-park-booking-system'); ?></span>
							<div class="to-field-disabled">
								<?php echo esc_html($this->data['meta']['place_type_name']);  ?>
								<div class="to-float-right"><?php edit_post_link(esc_html__('Edit','car-park-booking-system'),null,null,$this->data['meta']['place_type_id']); ?></div>
							</div>
						</li>						
						<li>
							<h5><?php esc_html_e('Order total amount','car-park-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Order total amount.','car-park-booking-system'); ?></span>
							<div class="to-field-disabled">
								<?php echo esc_html(CPBSPrice::format($this->data['billing']['summary']['value_gross'],$this->data['meta']['currency_id']));  ?>
							</div>
						</li>  
<?php
		if($Validation->isNotEmpty($this->data['meta']['comment']))
		{
?>
							<li>
								<h5><?php esc_html_e('Comments to order','car-park-booking-system'); ?></h5>
								<span class="to-legend"><?php esc_html_e('Client comments.','car-park-booking-system'); ?></span>
								<div class="to-field-disabled">
								<?php echo esc_html($this->data['meta']['comment']);  ?>
								</div>
							</li>						 
<?php
		}
		if($Validation->isNotEmpty($this->data['meta']['coupon_code']))
		{
?>
							<li>
								<h5><?php esc_html_e('Coupon code','car-park-booking-system'); ?></h5>
								<span class="to-legend"><?php esc_html_e('Coupon code.','car-park-booking-system'); ?></span>
								<div class="to-field-disabled">
									<?php echo esc_html($this->data['meta']['coupon_code']);  ?>
								</div>
							</li>  
							<li>
								<h5><?php esc_html_e('Percentage discount','car-park-booking-system'); ?></h5>
								<span class="to-legend"><?php esc_html_e('Percentage discount.','car-park-booking-system'); ?></span>
								<div class="to-field-disabled">
									<?php echo esc_html($this->data['meta']['coupon_discount_percentage']);  ?>%
								</div>
							</li>  
<?php
		}
?>
					</ul>
				</div>
				<div id="meta-box-booking-2">
					<ul class="to-form-field-list">
						<li>
							<h5><?php esc_html_e('Billing','car-park-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Billing.','car-park-booking-system'); ?></span>
							<div>	
								<table class="to-table">
									<tr>
										<th width="5%">
											<div>
												<?php esc_html_e('ID','car-park-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('ID.','car-park-booking-system'); ?>
												</span>
											</div>
										</th>
										<th width="25%">
											<div>
												<?php esc_html_e('Item','car-park-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Name of the item.','car-park-booking-system'); ?>
												</span>
											</div>
										</th>										
										<th width="10%">
											<div>
												<?php esc_html_e('Unit','car-park-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Name of the unit.','car-park-booking-system'); ?>
												</span>
											</div>
										</th>
										<th width="10%" class="to-align-right">
											<div>
												<?php esc_html_e('Quantity','car-park-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Quantity.','car-park-booking-system'); ?>
												</span>
											</div>
										</th> 
										<th width="10%" class="to-align-right">
											<div>
												<?php esc_html_e('Price','car-park-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Net unit price.','car-park-booking-system'); ?>
												</span>
											</div>
										</th>	 
										<th width="10%" class="to-align-right">
											<div>
												<?php esc_html_e('Value','car-park-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Net value.','car-park-booking-system'); ?>
												</span>
											</div>
										</th>  
										<th width="15%" class="to-align-right">
											<div>
												<?php esc_html_e('Tax','car-park-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Tax rate in percentage.','car-park-booking-system'); ?>
												</span>
											</div>
										</th>	  
										<th width="15%" class="to-align-right">
											<div>
												<?php esc_html_e('Total amount','car-park-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Total gross amount.','car-park-booking-system'); ?>
												</span>
											</div>
										</th>											 
									</tr>
<?php
		$i=0;
		foreach($this->data['billing']['detail'] as $index=>$value)
		{
?>		   
										<tr>
											<td>
												<div>
													<?php echo esc_html(++$i); ?>
												</div>
											</td>
											<td>
												<div>
													<?php echo esc_html($value['name']); ?>
												</div>
											</td>										
											<td>
												<div>
													<?php echo esc_html($value['unit']); ?>
												</div>
											</td>												
											<td class="to-align-right">
												<div>
													<?php echo esc_html($value['quantity']); ?>
												</div>
											</td>	 
											<td class="to-align-right">
												<div>
													<?php echo esc_html($value['price_net']); ?>
												</div>
											</td>											 
											<td class="to-align-right">
												<div>
													<?php echo esc_html($value['value_net']); ?>
												</div>
											</td>  
											<td class="to-align-right">
												<div>
													<?php echo esc_html($value['tax_value']); ?>
												</div>
											</td>  
											<td class="to-align-right">
												<div>
													<?php echo esc_html($value['value_gross']); ?>
												</div>
											</td>	  
										</tr>			
<?php
		}
?>
									<tr>
										<td><div>-</div></td>
										<td><div>-</div></td>
										<td><div>-</div></td>
										<td class="to-align-right"><div>-</div></td>
										<td class="to-align-right"><div>-</div></td>
										<td class="to-align-right">
											<div>
												<?php echo esc_html($this->data['billing']['summary']['value_net']); ?>
											</div>
										</td>  
										<td class="to-align-right"><div>-</div></td>
										<td class="to-align-right">
											<div>
												<?php echo esc_html($this->data['billing']['summary']['value_gross']); ?>
											</div>
										</td>	  
									</tr> 
								</table>
							</div>
						</li>	  
					</ul>
				</div>
				<div id="meta-box-booking-3">
					<ul class="to-form-field-list">
						<li>
							<h5><?php esc_html_e('Space type','car-park-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Space type.','car-park-booking-system'); ?></span>
							<div class="to-field-disabled">
								<?php echo esc_html($this->data['meta']['place_type_name']);  ?>
								<div class="to-float-right"><?php edit_post_link(esc_html__('Edit','car-park-booking-system'),null,null,$this->data['meta']['place_type_id']); ?></div>
							</div>
						</li>
						<li>
							<h5><?php esc_html_e('Space prices','car-park-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Base prices of the space.','car-park-booking-system'); ?></span>
							<div>	
								<table class="to-table">
									<tr>
										<th width="30%">
											<div>
												<?php esc_html_e('Price name','car-park-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Price name.','car-park-booking-system'); ?>
												</span>
											</div>
										</th>
										<th width="40%">
											<div>
												<?php esc_html_e('Value','car-park-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Value.','car-park-booking-system'); ?>
												</span>
											</div>
										</th>
										<th width="40%">
											<div>
												<?php esc_html_e('Tax rate','car-park-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Tax rate.','car-park-booking-system'); ?>
												</span>
											</div>
										</th>
									</tr>
<?php
		foreach($PriceRule->getPriceUseType() as $index=>$value)
		{
?>
										<tr>
											<td>
												<div><?php echo esc_html($value[0]) ?></div>
											</td>
											<td>
												<div class="to-clear-fix">
													<div class="to-field-disabled">
														<?php echo CPBSPrice::format($this->data['meta']['price_'.$index.'_value'],$this->data['meta']['currency_id']); ?>
													</div>
												</div>
											</td>
											<td>
												<div class="to-clear-fix">
													<div class="to-field-disabled">
														<?php echo esc_html($this->data['meta']['price_'.$index.'_tax_rate_value'].'%'); ?>
													</div>
												</div>
											</td>										
										</tr>
<?php		  
		}
?>
								</table>
							</div>
						</li>						 
					</ul>					
				</div>
				<div id="meta-box-booking-4">
<?php
		if(count($this->data['meta']['booking_extra']))
		{
?>
						<ul class="to-form-field-list">
							<li>
								<h5><?php esc_html_e('Booking extras','car-park-booking-system'); ?></h5>
								<span class="to-legend"><?php esc_html_e('List of addons ordered.','car-park-booking-system'); ?></span>
								<div>	
									<table class="to-table" id="to-table-vehicle-attribute">
										<tr>
											<th width="40%">
												<div>
													<?php esc_html_e('Name','car-park-booking-system'); ?>
													<span class="to-legend">
														<?php esc_html_e('Name.','car-park-booking-system'); ?>
													</span>
												</div>
											</th>
											<th class="to-align-right" width="10%">
												<div>
													<?php esc_html_e('Quantity','car-park-booking-system'); ?>
													<span class="to-legend">
														<?php esc_html_e('Quantity.','car-park-booking-system'); ?>
													</span>
												</div>
											</th>
											<th class="to-align-right" width="10%">
												<div>
													<?php esc_html_e('Price','car-park-booking-system'); ?>
													<span class="to-legend">
														<?php esc_html_e('Net unit price.','car-park-booking-system'); ?>
													</span>
												</div>
											</th>
											<th class="to-align-right" width="10%">
												<div>
													<?php esc_html_e('Value','car-park-booking-system'); ?>
													<span class="to-legend">
														<?php esc_html_e('Net value.','car-park-booking-system'); ?>
													</span>
												</div>
											</th>
											<th class="to-align-right" width="10%">
												<div>
													<?php esc_html_e('Tax','car-park-booking-system'); ?>
													<span class="to-legend">
														<?php esc_html_e('Tax rate in percentage.','car-park-booking-system'); ?>
													</span>
												</div>
											</th>
											<th class="to-align-right" width="10%">
												<div>
													<?php esc_html_e('Total amount','car-park-booking-system'); ?>
													<span class="to-legend">
														<?php esc_html_e('Total gross amount.','car-park-booking-system'); ?>
													</span>
												</div>
											</th>										
										</tr> 
<?php
            foreach($this->data['billing']['detail'] as $index=>$value)
            {
				if($value['type']=='booking_extra')
				{
?>
										<tr>
											<td style="width:40%">
												<div>
													<?php echo esc_html($value['name']); ?>
													<div class="to-float-right"><?php edit_post_link(esc_html__('Edit','car-park-booking-system'),null,null,$value['id'],'to-link-target-blank'); ?></div>
												</div>
											</td>
											<td class="to-align-right" style="width:10%">
												<div>
													<?php echo esc_html($value['quantity']); ?>
												</div>
											</td>
											<td class="to-align-right" style="width:10%">
												<div>
													<?php echo number_format($value['price_net'],2,'.',''); ?>
												</div>
											</td>                                        
											<td class="to-align-right" style="width:10%">
												<div>
													<?php echo number_format($value['value_net'],2,'.',''); ?>
												</div>
											</td>                                            
											<td class="to-align-right" style="width:15%">
												<div>
													<?php echo number_format($value['tax_value'],2,'.',''); ?>
												</div>
											</td>                                            
											<td class="to-align-right" style="width:15%">
												<div>
													<?php echo number_format($value['value_gross'],2,'.',''); ?>
												</div>
											</td>                                              
										</tr>      
<?php              
				}
			}
?>
									</table>
								</div>
							</li>
						</ul>
<?php
		}
?>
				</div>
				<div id="meta-box-booking-5">
				   <ul class="to-form-field-list">
						<li>
							<h5><?php esc_html_e('Client details','car-park-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('Client contact details.','car-park-booking-system'); ?><br/>
							</span>
							<div>
								<span class="to-legend-field"><?php esc_html_e('First name:','car-park-booking-system'); ?></span>
								<div class="to-field-disabled"><?php echo esc_html($this->data['meta']['client_contact_detail_first_name']) ?></div>								
							</div>
							<div>
								<span class="to-legend-field"><?php esc_html_e('Last name:','car-park-booking-system'); ?></span>
								<div class="to-field-disabled"><?php echo esc_html($this->data['meta']['client_contact_detail_last_name']) ?></div>								
							</div>								
							<div>
								<span class="to-legend-field"><?php esc_html_e('E-mail address:','car-park-booking-system'); ?></span>
								<div class="to-field-disabled"><?php echo esc_html($this->data['meta']['client_contact_detail_email_address']) ?></div>								
							</div>									
							<div>
								<span class="to-legend-field"><?php esc_html_e('Phone number:','car-park-booking-system'); ?></span>
								<div class="to-field-disabled"><?php echo esc_html($this->data['meta']['client_contact_detail_phone_number']) ?></div>								
							</div> 
<?php
		echo $BookingFormElement->displayField(1,$this->data['meta']);
?>
						</li>
<?php
		if((int)$this->data['meta']['client_billing_detail_enable']===1)
		{
?>
						<li>
							<h5><?php esc_html_e('Billing address','car-park-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('Billing address details.','car-park-booking-system'); ?><br/>
							</span>
							<div>
								<span class="to-legend-field"><?php esc_html_e('Company name:','car-park-booking-system'); ?></span>
								<div class="to-field-disabled"><?php echo esc_html($this->data['meta']['client_billing_detail_company_name']) ?></div>								
							</div>
							<div>
								<span class="to-legend-field"><?php esc_html_e('Tax number:','car-park-booking-system'); ?></span>
								<div class="to-field-disabled"><?php echo esc_html($this->data['meta']['client_billing_detail_tax_number']) ?></div>								
							</div>
							<div>
								<span class="to-legend-field"><?php esc_html_e('Street name:','car-park-booking-system'); ?></span>
								<div class="to-field-disabled"><?php echo esc_html($this->data['meta']['client_billing_detail_street_name']) ?></div>								
							</div>						   
							<div>
								<span class="to-legend-field"><?php esc_html_e('Street number:','car-park-booking-system'); ?></span>
								<div class="to-field-disabled"><?php echo esc_html($this->data['meta']['client_billing_detail_street_number']) ?></div>								
							</div>		  
							<div>
								<span class="to-legend-field"><?php esc_html_e('City:','car-park-booking-system'); ?></span>
								<div class="to-field-disabled"><?php echo esc_html($this->data['meta']['client_billing_detail_city']) ?></div>								
							</div>		  
							<div>
								<span class="to-legend-field"><?php esc_html_e('State:','car-park-booking-system'); ?></span>
								<div class="to-field-disabled"><?php echo esc_html($this->data['meta']['client_billing_detail_state']) ?></div>								
							</div>	
							<div>
								<span class="to-legend-field"><?php esc_html_e('Postal code:','car-park-booking-system'); ?></span>
								<div class="to-field-disabled"><?php echo esc_html($this->data['meta']['client_billing_detail_postal_code']) ?></div>								
							</div>	
							<div>
								<span class="to-legend-field"><?php esc_html_e('Country:','car-park-booking-system'); ?></span>
								<div class="to-field-disabled"><?php echo esc_html($this->data['client_billing_detail_country_name']) ?></div>								
							</div>	  
<?php
			echo $BookingFormElement->displayField(2,$this->data['meta']);
?>
						</li>
<?php		  
		}
		
		$panel=$BookingFormElement->getPanel($this->data['meta']);
		foreach($panel as $panelIndex=>$panelValue)
		{
			if(in_array($panelValue['id'],array(1,2))) continue;
?>
						<li>
							<h5><?php echo esc_html($panelValue['label']); ?></h5>
							<span class="to-legend">
								<?php echo esc_html($panelValue['label']); ?>
							</span>							
							<?php echo $BookingFormElement->displayField($panelValue['id'],$this->data['meta']); ?>
						</li>	
<?php
		}
		
		if((array_key_exists('form_element_agreement',$this->data['meta'])) && (is_array($this->data['meta']['form_element_agreement'])) && (count($this->data['meta']['form_element_agreement'])))
		{
?>
						<li>
							<h5><?php esc_html_e('Agreements','car-park-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('Agreements.','car-park-booking-system'); ?><br/>
							</span>
							<div>
								<table class="to-table" id="to-table-vehicle-attribute">
									<tr>
										<th style="width:80%">
											<div>
												<?php esc_html_e('Agreement','car-park-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Text of the agreement.','car-park-booking-system'); ?>
												</span>
											</div>
										</th>
										<th style="width:20%">
											<div>
												<?php esc_html_e('Customer reply','car-park-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Customer reply.','car-park-booking-system'); ?>
												</span>
											</div>
										</th>									   
									</tr>
<?php
			foreach($this->data['meta']['form_element_agreement'] as $index=>$value)
			{
?>
									<tr>
										<td>
											<div>
												<?php echo $value['text']; ?>
											</div>
										</td>
										<td>
											<div>
												<?php echo ((int)$value['value']===1 ? esc_html__('Yes','car-park-booking-system') : esc_html__('No','car-park-booking-system')); ?>
											</div>
										</td>
									</tr>
<?php
			}
?>
								</table>
							</div>
						</li>						
<?php
		}
?>		
					</ul>
				</div>
				<div id="meta-box-booking-6">
<?php
        if($Validation->isNotEmpty($this->data['meta']['payment_name']))
        {
?>
                    <ul class="to-form-field-list">
                        <li>
                            <h5><?php esc_html_e('Payment details','car-park-booking-system'); ?></h5>
                            <span class="to-legend">
                                <?php esc_html_e('Payment details.','car-park-booking-system'); ?><br/>
                            </span>
                            <div>
                                <span class="to-legend-field"><?php esc_html_e('Payment method:','car-park-booking-system'); ?></span>
                                <div class="to-field-disabled"><?php echo esc_html($this->data['meta']['payment_name']) ?></div>                                
                            </div>
                        </li>
<?php
            if(in_array($this->data['meta']['payment_id'],array(2,3)))
            {
?>
                        <li>
                            <h5><?php esc_html_e('Transactions','car-park-booking-system'); ?></h5>
                            <span class="to-legend">
                                <?php esc_html_e('List of registered transactions for this payment.','car-park-booking-system'); ?><br/>
                            </span>
<?php
				if(array_key_exists('payment_stripe_data',$this->data['meta']))
				{
					if((is_array($this->data['meta']['payment_stripe_data'])) && (count($this->data['meta']['payment_stripe_data'])))
					{
?>						
                            <div>	
                                <table class="to-table to-table-fixed-layout">
                                     <thead>
                                        <tr>
                                            <th style="width:15%">
                                                <div>
                                                    <?php esc_html_e('Transaction ID','car-park-booking-system'); ?>
                                                    <span class="to-legend"><?php esc_html_e('Transaction ID.','car-park-booking-system'); ?></span>
                                                </div>
                                            </th>
                                            <th style="width:15%">
                                                <div>
                                                    <?php esc_html_e('Type','car-park-booking-system'); ?>
                                                    <span class="to-legend"><?php esc_html_e('Type.','car-park-booking-system'); ?></span>
                                                </div>
                                            </th>
                                            <th style="width:15%">
                                                <div>
                                                    <?php esc_html_e('Date','car-park-booking-system'); ?>
                                                    <span class="to-legend"><?php esc_html_e('Date.','car-park-booking-system'); ?></span>
                                                </div>
                                            </th>	
                                            <th style="width:55%">
                                                <div>
                                                    <?php esc_html_e('Details','car-park-booking-system'); ?>
                                                    <span class="to-legend"><?php esc_html_e('Status.','car-park-booking-system'); ?></span>
                                                </div>
                                            </th>
                                        </tr>
                                    </thead>	
                                    <tbody>
<?php
						foreach($this->data['meta']['payment_stripe_data'] as $index=>$value)
						{
?>
                                        <tr>
                                            <td><div><?php echo esc_html($value->id); ?></div></td>
                                            <td><div><?php echo esc_html($value->type); ?></div></td>
                                            <td><div><?php echo esc_html(date_i18n(CPBSOption::getOption('date_format').' '.CPBSOption::getOption('time_format'),$value->created)); ?></div></td>
                                            <td>
												<div class="to-toggle-details">
													<a href="#"><?php esc_html_e('Toggle details','car-park-booking-system'); ?></a>
													<div class="to-hidden">
														<pre>
															<?php var_dump($value); ?>
														</pre>
													</div>
												</div>
											</td>
                                        </tr>
<?php
						}
?>
                                    </tbody>
								</table>
							</div>
<?php						
					}
				}
				else if(array_key_exists('payment_paypal_data',$this->data['meta']))
				{
					if((is_array($this->data['meta']['payment_paypal_data'])) && (count($this->data['meta']['payment_paypal_data'])))
					{
?>

                            <div>	
                                <table class="to-table">
                                    <thead>
                                        <tr>
                                            <th style="width:15%">
                                                <div>
                                                    <?php esc_html_e('Transaction ID','car-park-booking-system'); ?>
                                                    <span class="to-legend"><?php esc_html_e('Transaction ID.','car-park-booking-system'); ?></span>
                                                </div>
                                            </th>
                                            <th style="width:15%">
                                                <div>
                                                    <?php esc_html_e('Status','car-park-booking-system'); ?>
                                                    <span class="to-legend"><?php esc_html_e('Type.','car-park-booking-system'); ?></span>
                                                </div>
                                            </th>
                                            <th style="width:15%">
                                                <div>
                                                    <?php esc_html_e('Date','car-park-booking-system'); ?>
                                                    <span class="to-legend"><?php esc_html_e('Date.','car-park-booking-system'); ?></span>
                                                </div>
                                            </th>	
                                            <th style="width:55%">
                                                <div>
                                                    <?php esc_html_e('Details','car-park-booking-system'); ?>
                                                    <span class="to-legend"><?php esc_html_e('Details.','car-park-booking-system'); ?></span>
                                                </div>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php
						foreach($this->data['meta']['payment_paypal_data'] as $index=>$value)
						{
?>
                                        <tr>
                                            <td><div><?php echo esc_html($value['txn_id']); ?></div></td>
                                            <td><div><?php echo esc_html($value['payment_status']); ?></div></td>
                                            <td><div><?php echo esc_html($value['payment_date']); ?></div></td>
											<td>
												<div class="to-toggle-details">
													<a href="#"><?php esc_html_e('Toggle details','car-park-booking-system'); ?></a>
													<div class="to-hidden">
														<pre>
															<?php var_dump($value); ?>
														</pre>
													</div>
												</div>
											</td>
                                        </tr>
<?php
						}
?>
                                    </tbody>
                                </table>
                            </div>
<?php				
					}
				}
?>
						</li>
<?php
            }
?>
                    </ul>
<?php
        }
?>
				</div>
			</div>
		</div>
<?php
		CPBSHelper::addInlineScript('cpbs-admin',
		'
			jQuery(document).ready(function($)
			{
				$(\'.to\').themeOptionElement({init:true});
				
				$(\'.to-toggle-details>a\').on(\'click\',function(e)
				{
					e.preventDefault();
					$(this).parents(\'td:first\').css(\'max-width\',\'0px\');
					$(this).next(\'div\').toggleClass(\'to-hidden\');
				});
			});			
		');