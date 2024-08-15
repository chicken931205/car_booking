<?php 
		echo $this->data['nonce']; 
		
		$LengthUnit=new CPBSLengthUnit();
?>	
		<div class="to">
			<div class="ui-tabs">
				<ul>
					<li><a href="#meta-box-place_type-1"><?php esc_html_e('General','car-park-booking-system'); ?></a></li>
					<li><a href="#meta-box-place_type-2"><?php esc_html_e('Prices','car-park-booking-system'); ?></a></li>
				</ul>
				<div id="meta-box-place_type-1">
					<ul class="to-form-field-list">
						<?php echo CPBSHelper::createPostIdField(__('Space type ID','car-park-booking-system')); ?>
						<li>
							<h5><?php esc_html_e('Dimension','car-park-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('Enter length and width of space in selected length unit. Available are values from 0.00 to 9999.99.','car-park-booking-system'); ?><br/>
							</span>
							<div>
								<span class="to-legend-field"><?php esc_html_e('Width:','car-park-booking-system'); ?></span>
								<div>
									<input type="text" maxlength="12" name="<?php CPBSHelper::getFormName('dimension_width'); ?>" value="<?php echo esc_attr($LengthUnit->convertLengthUnit($this->data['meta']['dimension_width'],1,CPBSOption::getOption('length_unit'))); ?>"/>
								</div>					 
							</div>
							<div>
								<span class="to-legend-field"><?php esc_html_e('Length:','car-park-booking-system'); ?></span>
								<div>
									<input type="text" maxlength="12" name="<?php CPBSHelper::getFormName('dimension_length'); ?>" value="<?php echo esc_attr($LengthUnit->convertLengthUnit($this->data['meta']['dimension_length'],1,CPBSOption::getOption('length_unit'))); ?>"/>
								</div>					 
							</div>
						</li>  
						<li>
							<h5><?php esc_html_e('Icon','car-park-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Select icon.','car-park-booking-system'); ?><br/></span>
							<div class="to-clear-fix">
								<select name="<?php CPBSHelper::getFormName('icon'); ?>">
<?php
		foreach($this->data['dictionary']['icon_feature'] as $index=>$value)
			echo '<option value="'.esc_attr($index).'" '.(CPBSHelper::selectedIf($this->data['meta']['icon'],$index,false)).'>'.esc_html($value[0]).'</option>';
?>
								</select>
							</div>
						</li> 
						<li>
							<h5><?php esc_html_e('Main color','car-park-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Select a color which identify this space type.','car-park-booking-system'); ?><br/></span>
							<div class="to-clear-fix">	
								 <input type="text" class="to-color-picker" id="<?php CPBSHelper::getFormName('color'); ?>" name="<?php CPBSHelper::getFormName('color'); ?>" value="<?php echo esc_attr($this->data['meta']['color']); ?>"/>
							</div>
						</li>
					</ul>
				</div>
				<div id="meta-box-place_type-2">
					<ul class="to-form-field-list">
						<li>
							<h5><?php esc_html_e('Prices','car-park-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Prices.','car-park-booking-system'); ?></span>
							<div>
								<table class="to-table to-table-price">
									<tr>
										<th width="20%">
											<div>
												<?php esc_html_e('Name','car-park-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Name.','car-park-booking-system'); ?>
												</span>
											</div>
										</th>
										<th width="40%">
											<div>
												<?php esc_html_e('Description','car-park-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Description.','car-park-booking-system'); ?>
												</span>
											</div>
										</th>
										<th width="30%">
											<div>
												<?php esc_html_e('Value','car-park-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Value.','car-park-booking-system'); ?>
												</span>
											</div>
										</th>										
										<th width="10%">
											<div>
												<?php esc_html_e('Tax','car-park-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Tax.','car-park-booking-system'); ?>
												</span>
											</div>
										</th>										  
									</tr>
									<tr>
										<td>
											<div class="to-clear-fix">
												<?php esc_html_e('Initial','car-park-booking-system'); ?>
											</div>
										</td>							
										<td>
											<div class="to-clear-fix">
												<?php esc_html_e('Initial, fixed fee added to the booking.','car-park-booking-system'); ?>
											</div>
										</td>	
										<td>
											<div class="to-clear-fix">
												<input type="text" maxlength="12" id="<?php CPBSHelper::getFormName('price_initial_value'); ?>" name="<?php CPBSHelper::getFormName('price_initial_value'); ?>" value="<?php echo esc_attr($this->data['meta']['price_initial_value']); ?>"/>
											</div>
										</td>	
										<td>
											<div class="to-clear-fix">
												<select name="<?php CPBSHelper::getFormName('price_initial_tax_rate_id'); ?>">
<?php
		echo '<option value="0" '.(CPBSHelper::selectedIf($this->data['meta']['price_initial_tax_rate_id'],0,false)).'>'.esc_html__('- Not set -','car-park-booking-system').'</option>';
		foreach($this->data['dictionary']['tax_rate'] as $index=>$value)
		{
			echo '<option value="'.esc_attr($index).'" '.(CPBSHelper::selectedIf($this->data['meta']['price_initial_tax_rate_id'],$index,false)).'>'.esc_html($value['post']->post_title).'</option>';
		}
?>	   
												</select>
											</div>
										</td>	
									</tr>
									<tr>
										<td>
											<div class="to-clear-fix">
												<?php esc_html_e('Rental per day','car-park-booking-system'); ?>
											</div>
										</td>							
										<td>
											<div class="to-clear-fix">
												<?php esc_html_e('Price for rent a space per day.','car-park-booking-system'); ?><br/>
												<?php esc_html_e('This price applies for "Day", "Day II", "Day + hour" and "Day + hour II" billing type only.','car-park-booking-system'); ?>
											</div>
										</td>
										<td>
											<div class="to-clear-fix">
												<input type="text" maxlength="12" id="<?php CPBSHelper::getFormName('price_rental_day_value'); ?>" name="<?php CPBSHelper::getFormName('price_rental_day_value'); ?>" value="<?php echo esc_attr($this->data['meta']['price_rental_day_value']); ?>"/>
											</div>											
										</td>
										<td>
											<div class="to-clear-fix">
												<select name="<?php CPBSHelper::getFormName('price_rental_day_tax_rate_id'); ?>">
<?php
		echo '<option value="0" '.(CPBSHelper::selectedIf($this->data['meta']['price_rental_day_tax_rate_id'],0,false)).'>'.esc_html__('- Not set -','car-park-booking-system').'</option>';
		foreach($this->data['dictionary']['tax_rate'] as $index=>$value)
		{
			echo '<option value="'.esc_attr($index).'" '.(CPBSHelper::selectedIf($this->data['meta']['price_rental_day_tax_rate_id'],$index,false)).'>'.esc_html($value['post']->post_title).'</option>';
		}
?>
												</select>												
											</div>
										</td>	
									</tr>									
									<tr>
										<td>
											<div class="to-clear-fix">
												<?php esc_html_e('Rental per hour','car-park-booking-system'); ?>
											</div>
										</td>							
										<td>
											<div class="to-clear-fix">
												<?php esc_html_e('Price for rent a space per hour.','car-park-booking-system'); ?><br/>
												<?php esc_html_e('This price applies for "Hour" and "Hour + minute" billing type only.','car-park-booking-system'); ?>
											 </div>
										</td>
										<td>
											<div class="to-clear-fix">
												<input type="text" maxlength="12" id="<?php CPBSHelper::getFormName('price_rental_hour_value'); ?>" name="<?php CPBSHelper::getFormName('price_rental_hour_value'); ?>" value="<?php echo esc_attr($this->data['meta']['price_rental_hour_value']); ?>"/>
											</div>
										</td>	
										<td>
											<div class="to-clear-fix">
												<select name="<?php CPBSHelper::getFormName('price_rental_hour_tax_rate_id'); ?>">
<?php
		echo '<option value="0" '.(CPBSHelper::selectedIf($this->data['meta']['price_rental_hour_tax_rate_id'],0,false)).'>'.esc_html__('- Not set -','car-park-booking-system').'</option>';
		foreach($this->data['dictionary']['tax_rate'] as $index=>$value)
		{
			echo '<option value="'.esc_attr($index).'" '.(CPBSHelper::selectedIf($this->data['meta']['price_rental_hour_tax_rate_id'],$index,false)).'>'.esc_html($value['post']->post_title).'</option>';
		}
?>
												</select>												
											</div>
										</td>
									</tr>
									<tr>
										<td>
											<div class="to-clear-fix">
												<?php esc_html_e('Rental per minute','car-park-booking-system'); ?>
											</div>
										</td>							
										<td>
											<div class="to-clear-fix">
												<?php esc_html_e('Price for rent a space per minute.','car-park-booking-system'); ?><br/>
												<?php esc_html_e('This price applies for "Minute" billing type only.','car-park-booking-system'); ?>
											 </div>
										</td>
										<td>
											<div class="to-clear-fix">
												<input type="text" maxlength="12" id="<?php CPBSHelper::getFormName('price_rental_minute_value'); ?>" name="<?php CPBSHelper::getFormName('price_rental_minute_value'); ?>" value="<?php echo esc_attr($this->data['meta']['price_rental_minute_value']); ?>"/>
											</div>
										</td>	
										<td>
											<div class="to-clear-fix">
												<select name="<?php CPBSHelper::getFormName('price_rental_minute_tax_rate_id'); ?>">
<?php
		echo '<option value="0" '.(CPBSHelper::selectedIf($this->data['meta']['price_rental_minute_tax_rate_id'],0,false)).'>'.esc_html__('- Not set -','car-park-booking-system').'</option>';
		foreach($this->data['dictionary']['tax_rate'] as $index=>$value)
		{
			echo '<option value="'.esc_attr($index).'" '.(CPBSHelper::selectedIf($this->data['meta']['price_rental_minute_tax_rate_id'],$index,false)).'>'.esc_html($value['post']->post_title).'</option>';
		}
?>
												</select>												
											</div>
										</td>
									</tr>
								</table>
							</div>
						</li>
					</ul>
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