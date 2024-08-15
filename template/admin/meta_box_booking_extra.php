<?php 
		echo $this->data['nonce']; 
?>	
		<div class="to">
			<div class="ui-tabs">
				<ul>
					<li><a href="#meta-box-booking-extra-1"><?php esc_html_e('General','car-park-booking-system'); ?></a></li>
					<li><a href="#meta-box-booking-extra-2"><?php esc_html_e('Locations','car-park-booking-system'); ?></a></li>
				</ul>
				<div id="meta-box-booking-extra-1">
					<ul class="to-form-field-list">
						<?php echo CPBSHelper::createPostIdField(__('Booking extra ID','car-park-booking-system')); ?>
						<li>
							<h5><?php esc_html_e('Description','car-park-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Description of the additive.','car-park-booking-system'); ?></span>
							<div>
								<textarea rows="1" cols="1" name="<?php CPBSHelper::getFormName('description'); ?>" id="<?php CPBSHelper::getFormName('description'); ?>"><?php echo esc_html($this->data['meta']['description']); ?></textarea>
							</div>
						</li>
						<li>
							<h5><?php esc_html_e('Quantity','car-park-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Define quantity.','car-park-booking-system'); ?></span>
							<div>
								<span class="to-legend-field"><?php esc_html_e('Default:','car-park-booking-system'); ?></span>
								<input type="text" name="<?php CPBSHelper::getFormName('quantity_default'); ?>" id="<?php CPBSHelper::getFormName('quantity_default'); ?>" value="<?php echo esc_attr($this->data['meta']['quantity_default']); ?>"/>
							</div>
							<div>
								<span class="to-legend-field"><?php esc_html_e('Minimum:','car-park-booking-system'); ?></span>
								<input type="text" name="<?php CPBSHelper::getFormName('quantity_minimum'); ?>" id="<?php CPBSHelper::getFormName('quantity_minimum'); ?>" value="<?php echo esc_attr($this->data['meta']['quantity_minimum']); ?>"/>
							</div>
							<div>
								<span class="to-legend-field"><?php esc_html_e('Maximum:','car-park-booking-system'); ?></span>
								<input type="text" name="<?php CPBSHelper::getFormName('quantity_maximum'); ?>" id="<?php CPBSHelper::getFormName('quantity_maximum'); ?>" value="<?php echo esc_attr($this->data['meta']['quantity_maximum']); ?>"/>
							</div>	
							<div>
								<span class="to-legend-field"><?php esc_html_e('Readonly (customer is not able to change quantity):','car-park-booking-system'); ?></span>							
								<div class="to-radio-button">
									<input type="radio" value="1" id="<?php CPBSHelper::getFormName('quantity_readonly_enable_1'); ?>" name="<?php CPBSHelper::getFormName('quantity_readonly_enable'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['quantity_readonly_enable'],1); ?>/>
									<label for="<?php CPBSHelper::getFormName('quantity_readonly_enable_1'); ?>"><?php esc_html_e('Enable','car-park-booking-system'); ?></label>
									<input type="radio" value="0" id="<?php CPBSHelper::getFormName('quantity_readonly_enable_0'); ?>" name="<?php CPBSHelper::getFormName('quantity_readonly_enable'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['quantity_readonly_enable'],0); ?>/>
									<label for="<?php CPBSHelper::getFormName('quantity_readonly_enable_0'); ?>"><?php esc_html_e('Disable','car-park-booking-system'); ?></label>
								</div>
							</div>	
							<div>
								<span class="to-legend-field"><?php esc_html_e('Equal to number of rental days (works for "Day" billing type only):','car-park-booking-system'); ?></span>							
								<div class="to-radio-button">
									<input type="radio" value="1" id="<?php CPBSHelper::getFormName('quantity_equal_rental_day_number_1'); ?>" name="<?php CPBSHelper::getFormName('quantity_equal_rental_day_number'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['quantity_equal_rental_day_number'],1); ?>/>
									<label for="<?php CPBSHelper::getFormName('quantity_equal_rental_day_number_1'); ?>"><?php esc_html_e('Enable','car-park-booking-system'); ?></label>
									<input type="radio" value="0" id="<?php CPBSHelper::getFormName('quantity_equal_rental_day_number_0'); ?>" name="<?php CPBSHelper::getFormName('quantity_equal_rental_day_number'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['quantity_equal_rental_day_number'],0); ?>/>
									<label for="<?php CPBSHelper::getFormName('quantity_equal_rental_day_number_0'); ?>"><?php esc_html_e('Disable','car-park-booking-system'); ?></label>
								</div>
							</div>
						</li>
						<li>
							<h5><?php esc_html_e('State of "Select" button','car-park-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('State of the "Select" booking add-ons button.','car-park-booking-system'); ?><br/>
								<?php esc_html_e('"Not selected" means, that button will not be checked by default.','car-park-booking-system'); ?><br/>
								<?php esc_html_e('"Selected" means, that button will be checked by default, but customer is able to uncheck it.','car-park-booking-system'); ?><br/>
								<?php esc_html_e('"Mandatory" means, that button will be checked by default and customer is not able to uncheck it.','car-park-booking-system'); ?>
							</span>						
							<div class="to-radio-button">
								<input type="radio" value="0" id="<?php CPBSHelper::getFormName('button_select_default_state_0'); ?>" name="<?php CPBSHelper::getFormName('button_select_default_state'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['button_select_default_state'],0); ?>/>
								<label for="<?php CPBSHelper::getFormName('button_select_default_state_0'); ?>"><?php esc_html_e('Not selected','car-park-booking-system'); ?></label>
								<input type="radio" value="1" id="<?php CPBSHelper::getFormName('button_select_default_state_1'); ?>" name="<?php CPBSHelper::getFormName('button_select_default_state'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['button_select_default_state'],1); ?>/>
								<label for="<?php CPBSHelper::getFormName('button_select_default_state_1'); ?>"><?php esc_html_e('Selected','car-park-booking-system'); ?></label>
								<input type="radio" value="2" id="<?php CPBSHelper::getFormName('button_select_default_state_2'); ?>" name="<?php CPBSHelper::getFormName('button_select_default_state'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['button_select_default_state'],2); ?>/>
								<label for="<?php CPBSHelper::getFormName('button_select_default_state_2'); ?>"><?php esc_html_e('Mandatory','car-park-booking-system'); ?></label>
							</div>
						</li>
						<li>
							<h5><?php esc_html_e('Price','car-park-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('Price settings. You can also set prices and tax rates for each location separately in tab named "Locations".','car-park-booking-system'); ?>
							</span>
							<div>
								<span class="to-legend-field"><?php esc_html_e('Net price:','car-park-booking-system'); ?></span>
								<input maxlength="12" type="text" name="<?php CPBSHelper::getFormName('price'); ?>" id="<?php CPBSHelper::getFormName('price'); ?>" value="<?php echo esc_attr($this->data['meta']['price']); ?>"/>
							</div>
							<div>
								<span class="to-legend-field"><?php esc_html_e('Tax rate:','car-park-booking-system'); ?></span>		
								<div>
									<select name="<?php CPBSHelper::getFormName('tax_rate_id'); ?>">
<?php
		echo '<option value="0" '.(CPBSHelper::selectedIf($this->data['meta']['tax_rate_id'],0,false)).'>'.esc_html__('- Not set -','car-park-booking-system').'</option>';
		foreach($this->data['dictionary']['tax_rate'] as $index=>$value)
		{
			echo '<option value="'.esc_attr($index).'" '.(CPBSHelper::selectedIf($this->data['meta']['tax_rate_id'],$index,false)).'>'.esc_html($value['post']->post_title).'</option>';
		}
?>	   
									</select>
								</div>
							</div>
							<div>
								<span class="to-legend-field"><?php esc_html_e('Price type:','car-park-booking-system'); ?></span>
								<div class="to-radio-button">
<?php
		foreach($this->data['dictionary']['price_type'] as $index=>$value)
		{
?>
										<input type="radio" value="<?php echo esc_attr($index); ?>" id="<?php CPBSHelper::getFormName('price_type_'.$index); ?>" name="<?php CPBSHelper::getFormName('price_type'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['price_type'],$index); ?>/>
										<label for="<?php CPBSHelper::getFormName('price_type_'.$index); ?>"><?php echo esc_html($value[0]); ?></label>
<?php		
		}
?>								
								</div>
							</div>
						</li> 
					</ul>
				</div>
				<div id="meta-box-booking-extra-2">
<?php
		if((is_array($this->data['dictionary']['location'])) && (count($this->data['dictionary']['location'])))
		{
?>
						<ul class="to-form-field-list">
							<li>
								<h5><?php esc_html_e('Locations','car-park-booking-system'); ?></h5>
								<span class="to-legend">
									<?php esc_html_e('Set booking add-ons availability for locations and (if its is needed) price with tax.','car-park-booking-system'); ?>
								</span>
								<div class="to-clear-fix">
									<table class="to-table">
										<tr>
											<th width="25%">
												<div>
													<?php esc_html_e('Location','car-park-booking-system'); ?>
													<span class="to-legend">
														<?php esc_html_e('Location.','car-park-booking-system'); ?>
													</span>
												</div>
											</th>
											<th width="25%">
												<div>
													<?php esc_html_e('Availability','car-park-booking-system'); ?>
													<span class="to-legend">
														<?php esc_html_e('Set availability in location.','car-park-booking-system'); ?>
													</span>
												</div>
											</th> 
											<th width="25%">
												<div>
													<?php esc_html_e('Price','car-park-booking-system'); ?>
													<span class="to-legend">
														<?php esc_html_e('Net price.','car-park-booking-system'); ?>
													</span>
												</div>
											</th>   
											<th width="25%">
												<div>
													<?php esc_html_e('Tax rate','car-park-booking-system'); ?>
													<span class="to-legend">
														<?php esc_html_e('Tax rate.','car-park-booking-system'); ?>
													</span>
												</div>
											</th>	
										</tr>
<?php
		foreach($this->data['dictionary']['location'] as $index=>$value)
		{
?>			   
										<tbody id="to-location-<?php echo esc_attr($index); ?>">
											<tr>
												<td>
													<div class="to-clear-fix">
														<div class="to-field-disabled">
															<?php echo esc_html($value['post']->post_title); ?>
														</div>
													</div>
												</td> 
												<td>
													<div class="to-clear-fix">
														<div class="to-radio-button">
															<input type="radio" value="1" id="<?php CPBSHelper::getFormName('location_enable_'.$index.'_1'); ?>" name="<?php CPBSHelper::getFormName('location['.$index.'][enable]'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['location'][$index]['enable'],1); ?>/>
															<label for="<?php CPBSHelper::getFormName('location_enable_'.$index.'_1'); ?>"><?php esc_html_e('Available','car-park-booking-system'); ?></label>
															<input type="radio" value="0" id="<?php CPBSHelper::getFormName('location_enable_'.$index.'_0'); ?>" name="<?php CPBSHelper::getFormName('location['.$index.'][enable]'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['location'][$index]['enable'],0); ?>/>
															<label for="<?php CPBSHelper::getFormName('location_enable_'.$index.'_0'); ?>"><?php esc_html_e('Not available','car-park-booking-system'); ?></label>
														</div>
													</div>
												</td> 
												<td>
													<div class="to-clear-fix">
														<input type="text" name="<?php CPBSHelper::getFormName('location['.$index.'][price]'); ?>" value="<?php echo esc_attr($this->data['meta']['location'][$index]['price']); ?>" title="<?php esc_attr_e('Enter price.','car-park-booking-system'); ?>"/>
													</div>
												</td> 
												<td>
													<div class="to-clear-fix">
														<select name="<?php CPBSHelper::getFormName('location['.$index.'][tax_rate_id]'); ?>">
<?php
			echo '<option value="0" '.(CPBSHelper::selectedIf($this->data['meta']['location'][$index]['tax_rate_id'],0,false)).'>'.esc_html__('- Not set -','car-park-booking-system').'</option>';
			foreach($this->data['dictionary']['tax_rate'] as $taxRateId=>$taxRateValue)
			{
				echo '<option value="'.esc_attr($taxRateId).'" '.(CPBSHelper::selectedIf($this->data['meta']['location'][$index]['tax_rate_id'],$taxRateId,false)).'>'.esc_html($taxRateValue['post']->post_title).'</option>';
			}
?>
														</select>														
													</div>										
												</td>
											</tr>
										</tbody>
<?php
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
			</div>
		</div>
<?php
		CPBSHelper::addInlineScript('cpbs-admin',
		'
			jQuery(document).ready(function($)
			{
				$(\'.to\').themeOptionElement({init:true});
			});			
		');