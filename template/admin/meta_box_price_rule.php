<?php 
		echo $this->data['nonce'];
		$Date=new CPBSDate();
?>	
		<div class="to">
			<div class="ui-tabs">
				<ul>
					<li><a href="#meta-box-price-rule-1"><?php esc_html_e('General','car-park-booking-system'); ?></a></li>
					<li><a href="#meta-box-price-rule-2"><?php esc_html_e('Conditions','car-park-booking-system'); ?></a></li>
					<li><a href="#meta-box-price-rule-3"><?php esc_html_e('Prices','car-park-booking-system'); ?></a></li>
					<li><a href="#meta-box-price-rule-4"><?php esc_html_e('Options','car-park-booking-system'); ?></a></li>
				</ul>
				<div id="meta-box-price-rule-1">
					<ul class="to-form-field-list">
						<?php echo CPBSHelper::createPostIdField(__('Price rule ID','car-park-booking-system')); ?>
					</ul>
				</div>
				<div id="meta-box-price-rule-2">
					<div class="ui-tabs">
						<ul>
							<li><a href="#meta-box-price-rule-2-1"><?php esc_html_e('General','car-park-booking-system'); ?></a></li>
							<li><a href="#meta-box-price-rule-2-2"><?php esc_html_e('Locations','car-park-booking-system'); ?></a></li>
							<li><a href="#meta-box-price-rule-2-3"><?php esc_html_e('Park space types','car-park-booking-system'); ?></a></li>
							<li><a href="#meta-box-price-rule-2-4"><?php esc_html_e('Date','car-park-booking-system'); ?></a></li>
							<li><a href="#meta-box-price-rule-2-5"><?php esc_html_e('Rental duration','car-park-booking-system'); ?></a></li>
							<li><a href="#meta-box-price-rule-2-6"><?php esc_html_e('Users','car-park-booking-system'); ?></a></li>
						</ul>		
						<div id="meta-box-price-rule-2-1">
							<ul class="to-form-field-list">
								<li>
									<h5><?php esc_html_e('Booking forms','car-park-booking-system'); ?></h5>
									<span class="to-legend"><?php esc_html_e('Select booking form(s).','car-park-booking-system'); ?></span>
									<div class="to-clear-fix">
										<select multiple="multiple" class="to-dropkick-disable" name="<?php CPBSHelper::getFormName('booking_form_id[]'); ?>">
											<option value="-1" <?php CPBSHelper::selectedIf($this->data['meta']['booking_form_id'],-1); ?>><?php esc_html_e('- None -','car-park-booking-system'); ?></option>
<?php
		foreach($this->data['dictionary']['booking_form'] as $index=>$value)
			echo '<option value="'.esc_attr($index).'" '.(CPBSHelper::selectedIf($this->data['meta']['booking_form_id'],$index,false)).'>'.esc_html($value['post']->post_title).'</option>';
?>
										</select>  
									</div>									
								</li>							
							</ul>
						</div>
						<div id="meta-box-price-rule-2-2">
							<ul class="to-form-field-list">
								<li>
									<h5><?php esc_html_e('Locations','car-park-booking-system'); ?></h5>
									<span class="to-legend"><?php esc_html_e('Select location(s).','car-park-booking-system'); ?></span>
									<div class="to-clear-fix">
										<select multiple="multiple" class="to-dropkick-disable" name="<?php CPBSHelper::getFormName('location_id[]'); ?>">
											<option value="-1" <?php CPBSHelper::selectedIf($this->data['meta']['location_id'],-1); ?>><?php esc_html_e('- None -','car-park-booking-system'); ?></option>
<?php
		foreach($this->data['dictionary']['location'] as $index=>$value)
			echo '<option value="'.esc_attr($index).'" '.(CPBSHelper::selectedIf($this->data['meta']['location_id'],$index,false)).'>'.esc_html($value['post']->post_title).'</option>';
?>
										</select>  
									</div>	
								</li>  
							</ul>
						</div>
						<div id="meta-box-price-rule-2-3">
							<ul class="to-form-field-list">
								<li>
									<h5><?php esc_html_e('Park space types','car-park-booking-system'); ?></h5>
									<span class="to-legend"><?php esc_html_e('Select vehicle park space type(s).','car-park-booking-system'); ?></span>
									<div class="to-clear-fix">
										<select multiple="multiple" class="to-dropkick-disable" name="<?php CPBSHelper::getFormName('place_type_id[]'); ?>">
											<option value="-1" <?php CPBSHelper::selectedIf($this->data['meta']['place_type_id'],-1); ?>><?php esc_html_e('- None -','car-park-booking-system'); ?></option>
<?php
		foreach($this->data['dictionary']['place_type'] as $index=>$value)
			echo '<option value="'.esc_attr($index).'" '.(CPBSHelper::selectedIf($this->data['meta']['place_type_id'],$index,false)).'>'.esc_html($value['post']->post_title).'</option>';
?>
										</select>  
									</div>	
								</li>
							</ul>
						</div>
						<div id="meta-box-price-rule-2-4">
							<ul class="to-form-field-list">
								<li>
									<h5><?php esc_html_e('Week day number of first rental day','car-park-booking-system'); ?></h5>
									<span class="to-legend"><?php esc_html_e('Select the starting day of the rental week.','car-park-booking-system'); ?></span>
									<div class="to-checkbox-button">
										<input type="checkbox" value="-1" id="<?php CPBSHelper::getFormName('entry_day_number_0'); ?>" name="<?php CPBSHelper::getFormName('entry_day_number[]'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['entry_day_number'],-1); ?>/>
										<label for="<?php CPBSHelper::getFormName('entry_day_number_0'); ?>"><?php esc_html_e('- All days -','car-park-booking-system') ?></label>
<?php
		for($i=1;$i<=7;$i++)
		{
?>
										<input type="checkbox" value="<?php echo esc_attr($i); ?>" id="<?php CPBSHelper::getFormName('entry_day_number_'.$i); ?>" name="<?php CPBSHelper::getFormName('entry_day_number[]'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['entry_day_number'],$i); ?>/>
										<label for="<?php CPBSHelper::getFormName('entry_day_number_'.$i); ?>"><?php echo esc_html(date_i18n('l',strtotime('Sunday +'.$i.' days'))); ?></label>
<?php
		}
?>								
									</div>						
								</li>
								<li>
									<h5><?php esc_html_e('Dependency between dates','car-park-booking-system'); ?></h5>
									<span class="to-legend">
									<?php echo esc_html__('Dependency between entry and exit date.','car-park-booking-system'); ?>
									</span>			   
									<div>
										<div class="to-radio-button">
											<input type="radio" value="-1" id="<?php CPBSHelper::getFormName('date_entry_exit_dependency_0'); ?>" name="<?php CPBSHelper::getFormName('date_entry_exit_dependency'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['date_entry_exit_dependency'],-1); ?>/>
											<label for="<?php CPBSHelper::getFormName('date_entry_exit_dependency_0'); ?>"><?php esc_html_e('- None -','car-park-booking-system'); ?></label>
<?php
		foreach($this->data['dictionary']['date_dependency'] as $index=>$value)
		{
?>
											<input type="radio" value="<?php echo esc_attr($index); ?>" id="<?php CPBSHelper::getFormName('date_entry_exit_dependency_'.$index); ?>" name="<?php CPBSHelper::getFormName('date_entry_exit_dependency'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['date_entry_exit_dependency'],$index); ?>/>
											<label for="<?php CPBSHelper::getFormName('date_entry_exit_dependency_'.$index); ?>"><?php echo esc_html($value[0]); ?></label>
<?php			
		}
?>											
										</div>  
									</div>							  
								</li>   
								<li>
									<h5><?php esc_html_e('Rental dates','car-park-booking-system'); ?></h5>
									<span class="to-legend">
										<?php esc_html_e('Enter rental date(s).','car-park-booking-system'); ?><br/>
										<?php esc_html_e('To use prices defined in below table, you have to choose proper source type of price in tab named "Prices".','car-park-booking-system'); ?>
									</span>
									<div>
										<table class="to-table" id="to-table-rental-date">
											<tr>
												<th width="30%">
													<div>
														<?php esc_html_e('From','car-park-booking-system'); ?>
														<span class="to-legend">
															<?php esc_html_e('From.','car-park-booking-system'); ?>
														</span>
													</div>
												</th>
												<th width="30%">
													<div>
														<?php esc_html_e('To','car-park-booking-system'); ?>
														<span class="to-legend">
															<?php esc_html_e('To.','car-park-booking-system'); ?>
														</span>
													</div>
												</th>
												<th width="20%">
													<div>
														<?php esc_html_e('Price','car-park-booking-system'); ?>
														<span class="to-legend">
															<?php esc_html_e('Price.','car-park-booking-system'); ?>
														</span>
													</div>
												</th>
												<th width="20%">
													<div>
														<?php esc_html_e('Remove','car-park-booking-system'); ?>
														<span class="to-legend">
															<?php esc_html_e('Remove this entry.','car-park-booking-system'); ?>
														</span>
													</div>
												</th>											
											</tr>
											<tr class="to-hidden">
												<td>
													<div>
														<input type="text" class="to-datepicker-custom" name="<?php CPBSHelper::getFormName('rental_date[start][]'); ?>"/>
													</div>									
												</td>
												<td>
													<div>
														<input type="text" class="to-datepicker-custom" name="<?php CPBSHelper::getFormName('rental_date[stop][]'); ?>"/>
													</div>									
												</td>
												<td>
													<div>
														<input type="text" maxlength="12" name="<?php CPBSHelper::getFormName('rental_date[price][]'); ?>"/>
													</div>									
												</td>
												<td>
													<div>
														<a href="#" class="to-table-button-remove"><?php esc_html_e('Remove','car-park-booking-system'); ?></a>
													</div>
												</td>
											</tr>						 
<?php
		if(isset($this->data['meta']['rental_date']))
		{
			if(is_array($this->data['meta']['rental_date']))
			{
				foreach($this->data['meta']['rental_date'] as $index=>$value)
				{
?>
											<tr>
												<td>
													<div>
														<input type="text" class="to-datepicker-custom" name="<?php CPBSHelper::getFormName('rental_date[start][]'); ?>" value="<?php echo esc_attr($Date->formatDateToDisplay($value['start'])); ?>"/>
													</div>									
												</td>
												<td>
													<div>
														<input type="text" class="to-datepicker-custom" name="<?php CPBSHelper::getFormName('rental_date[stop][]'); ?>" value="<?php echo esc_attr($Date->formatDateToDisplay($value['stop'])); ?>"/>
													</div>									
												</td>
												<td>
													<div>
														<input type="text" mexlength="12" name="<?php CPBSHelper::getFormName('rental_date[price][]'); ?>" value="<?php echo esc_attr($value['price']); ?>"/>
													</div>									
												</td>
												<td>
													<div>
														<a href="#" class="to-table-button-remove"><?php esc_html_e('Remove','car-park-booking-system'); ?></a>
													</div>
												</td>
											</tr>	 
<?php				  
				}
			}
		}
?>
										</table>
										<div> 
											<a href="#" class="to-table-button-add"><?php esc_html_e('Add','car-park-booking-system'); ?></a>
										</div>
									</div>
								</li>											
							</ul>
						</div>
						<div id="meta-box-price-rule-2-5">
							<ul class="to-form-field-list">
								<li>
									<h5><?php esc_html_e('Rental days quantity','car-park-booking-system'); ?></h5>
									<span class="to-legend">
										<?php esc_html_e('Enter number of rental day(s) (works for "Day", "Day II", "Day + hour" and "Day + hour II" billing types only).','car-park-booking-system'); ?><br/>
										<?php esc_html_e('To use prices defined in below table, you have to choose proper source type of price in tab named "Prices".','car-park-booking-system'); ?>
									</span>
									<div>
										<table class="to-table" id="to-table-rental-day-quantity">
											<tr>
												<th width="30%">
													<div>
														<?php esc_html_e('From','car-park-booking-system'); ?>
														<span class="to-legend">
															<?php esc_html_e('From.','car-park-booking-system'); ?>
														</span>
													</div>
												</th>
												<th width="30%">
													<div>
														<?php esc_html_e('To','car-park-booking-system'); ?>
														<span class="to-legend">
															<?php esc_html_e('To.','car-park-booking-system'); ?>
														</span>
													</div>
												</th>
												<th width="20%">
													<div>
														<?php esc_html_e('Price','car-park-booking-system'); ?>
														<span class="to-legend">
															<?php esc_html_e('Price.','car-park-booking-system'); ?>
														</span>
													</div>
												</th>
												<th width="20%">
													<div>
														<?php esc_html_e('Remove','car-park-booking-system'); ?>
														<span class="to-legend">
															<?php esc_html_e('Remove this entry.','car-park-booking-system'); ?>
														</span>
													</div>
												</th>											
											</tr>
											<tr class="to-hidden">
												<td>
													<div>
														<input type="text" maxlength="5" name="<?php CPBSHelper::getFormName('rental_day_quantity[start][]'); ?>"/>
													</div>									
												</td>
												<td>
													<div>
														<input type="text" maxlength="5" name="<?php CPBSHelper::getFormName('rental_day_quantity[stop][]'); ?>"/>
													</div>									
												</td>
												<td>
													<div>
														<input type="text" maxlength="12" name="<?php CPBSHelper::getFormName('rental_day_quantity[price][]'); ?>"/>
													</div>									
												</td>
												<td>
													<div>
														<a href="#" class="to-table-button-remove"><?php esc_html_e('Remove','car-park-booking-system'); ?></a>
													</div>
												</td>
											</tr>   
<?php
		if(isset($this->data['meta']['rental_day_quantity']))
		{
			if(is_array($this->data['meta']['rental_day_quantity']))
			{
				foreach($this->data['meta']['rental_day_quantity'] as $index=>$value)
				{
?>
											<tr>
												<td>
													<div>
														<input type="text" maxlength="5" name="<?php CPBSHelper::getFormName('rental_day_quantity[start][]'); ?>" value="<?php echo esc_attr($value['start']); ?>"/>
													</div>									
												</td>
												<td>
													<div>
														<input type="text" maxlength="5" name="<?php CPBSHelper::getFormName('rental_day_quantity[stop][]'); ?>" value="<?php echo esc_attr($value['stop']); ?>"/>
													</div>									
												</td>
												<td>
													<div>
														<input type="text" maxlength="12" name="<?php CPBSHelper::getFormName('rental_day_quantity[price][]'); ?>" value="<?php echo esc_attr($value['price']); ?>"/>
													</div>									
												</td>
												<td>
													<div>
														<a href="#" class="to-table-button-remove"><?php esc_html_e('Remove','car-park-booking-system'); ?></a>
													</div>
												</td>										
											</tr>	 
<?php				  
				}
			}
		}
?>
										</table>
										<div> 
											<a href="#" class="to-table-button-add"><?php esc_html_e('Add','car-park-booking-system'); ?></a>
										</div>
									</div>
								</li>
								<li>
									<h5><?php esc_html_e('Rental hours quantity','car-park-booking-system'); ?></h5>
									<span class="to-legend">
										<?php esc_html_e('Enter number of rental hour(s) (works for "Hour", "Hour + minute", "Day + hour" and "Day + hour II" billing types only) in format HHHH:MM.','car-park-booking-system'); ?><br/>
										<?php esc_html_e('To use prices defined in below table, you have to choose proper source type of price in tab named "Prices".','car-park-booking-system'); ?>
									</span>
									<div>
										<table class="to-table" id="to-table-rental-hour-quantity">
											<tr>
												<th width="30%">
													<div>
														<?php esc_html_e('From','car-park-booking-system'); ?>
														<span class="to-legend">
															<?php esc_html_e('From.','car-park-booking-system'); ?>
														</span>
													</div>
												</th>
												<th width="30%">
													<div>
														<?php esc_html_e('To','car-park-booking-system'); ?>
														<span class="to-legend">
															<?php esc_html_e('To.','car-park-booking-system'); ?>
														</span>
													</div>
												</th>
												<th width="20%">
													<div>
														<?php esc_html_e('Price','car-park-booking-system'); ?>
														<span class="to-legend">
															<?php esc_html_e('Price.','car-park-booking-system'); ?>
														</span>
													</div>
												</th>
												<th width="20%">
													<div>
														<?php esc_html_e('Remove','car-park-booking-system'); ?>
														<span class="to-legend">
															<?php esc_html_e('Remove this entry.','car-park-booking-system'); ?>
														</span>
													</div>
												</th>											
											</tr>
											<tr class="to-hidden">
												<td>
													<div>
														<input type="text" maxlength="7" name="<?php CPBSHelper::getFormName('rental_hour_quantity[start][]'); ?>"/>
													</div>									
												</td>
												<td>
													<div>
														<input type="text" maxlength="7" name="<?php CPBSHelper::getFormName('rental_hour_quantity[stop][]'); ?>"/>
													</div>									
												</td>
												<td>
													<div>
														<input type="text" maxlength="12" name="<?php CPBSHelper::getFormName('rental_hour_quantity[price][]'); ?>"/>
													</div>									
												</td>
												<td>
													<div>
														<a href="#" class="to-table-button-remove"><?php esc_html_e('Remove','car-park-booking-system'); ?></a>
													</div>
												</td>
											</tr>   
<?php
		if(isset($this->data['meta']['rental_hour_quantity']))
		{
			if(is_array($this->data['meta']['rental_hour_quantity']))
			{
				foreach($this->data['meta']['rental_hour_quantity'] as $index=>$value)
				{
?>
											<tr>
												<td>
													<div>
														<input type="text" maxlength="7" name="<?php CPBSHelper::getFormName('rental_hour_quantity[start][]'); ?>" value="<?php echo esc_attr(CPBSDate::fillTime($value['start'],4)); ?>"/>
													</div>									
												</td>
												<td>
													<div>
														<input type="text" maxlength="7" name="<?php CPBSHelper::getFormName('rental_hour_quantity[stop][]'); ?>" value="<?php echo esc_attr(CPBSDate::fillTime($value['stop'],4)); ?>"/>
													</div>									
												</td>
												<td>
													<div>
														<input type="text" maxlength="12" name="<?php CPBSHelper::getFormName('rental_hour_quantity[price][]'); ?>" value="<?php echo esc_attr($value['price']); ?>"/>
													</div>									
												</td>
												<td>
													<div>
														<a href="#" class="to-table-button-remove"><?php esc_html_e('Remove','car-park-booking-system'); ?></a>
													</div>
												</td>										
											</tr>	 
<?php				  
				}
			}
		}
?>
										</table>
										<div> 
											<a href="#" class="to-table-button-add"><?php esc_html_e('Add','car-park-booking-system'); ?></a>
										</div>
									</div>
								</li>						
								<li>
									<h5><?php esc_html_e('Rental minutes quantity','car-park-booking-system'); ?></h5>
									<span class="to-legend">
										<?php esc_html_e('Enter number of rental minute(s) (works for "Minute" and "Hour + minute" billing type only).','car-park-booking-system'); ?><br/>
										<?php esc_html_e('To use prices defined in below table, you have to choose proper source type of price in tab named "Prices".','car-park-booking-system'); ?>
									</span>
									<div>
										<table class="to-table" id="to-table-rental-minute-quantity">
											<tr>
												<th width="30%">
													<div>
														<?php esc_html_e('From','car-park-booking-system'); ?>
														<span class="to-legend">
															<?php esc_html_e('From.','car-park-booking-system'); ?>
														</span>
													</div>
												</th>
												<th width="30%">
													<div>
														<?php esc_html_e('To','car-park-booking-system'); ?>
														<span class="to-legend">
															<?php esc_html_e('To.','car-park-booking-system'); ?>
														</span>
													</div>
												</th>
												<th width="20%">
													<div>
														<?php esc_html_e('Price','car-park-booking-system'); ?>
														<span class="to-legend">
															<?php esc_html_e('Price.','car-park-booking-system'); ?>
														</span>
													</div>
												</th>
												<th width="20%">
													<div>
														<?php esc_html_e('Remove','car-park-booking-system'); ?>
														<span class="to-legend">
															<?php esc_html_e('Remove this entry.','car-park-booking-system'); ?>
														</span>
													</div>
												</th>											
											</tr>
											<tr class="to-hidden">
												<td>
													<div>
														<input type="text" maxlength="5" name="<?php CPBSHelper::getFormName('rental_minute_quantity[start][]'); ?>"/>
													</div>									
												</td>
												<td>
													<div>
														<input type="text" maxlength="5" name="<?php CPBSHelper::getFormName('rental_minute_quantity[stop][]'); ?>"/>
													</div>									
												</td>
												<td>
													<div>
														<input type="text" maxlength="12" name="<?php CPBSHelper::getFormName('rental_minute_quantity[price][]'); ?>"/>
													</div>									
												</td>
												<td>
													<div>
														<a href="#" class="to-table-button-remove"><?php esc_html_e('Remove','car-park-booking-system'); ?></a>
													</div>
												</td>
											</tr>   
<?php
		if(isset($this->data['meta']['rental_minute_quantity']))
		{
			if(is_array($this->data['meta']['rental_minute_quantity']))
			{
				foreach($this->data['meta']['rental_minute_quantity'] as $index=>$value)
				{
?>
											<tr>
												<td>
													<div>
														<input type="text" maxlength="5" name="<?php CPBSHelper::getFormName('rental_minute_quantity[start][]'); ?>" value="<?php echo esc_attr($value['start']); ?>"/>
													</div>									
												</td>
												<td>
													<div>
														<input type="text" maxlength="5" name="<?php CPBSHelper::getFormName('rental_minute_quantity[stop][]'); ?>" value="<?php echo esc_attr($value['stop']); ?>"/>
													</div>									
												</td>
												<td>
													<div>
														<input type="text" maxlength="12" name="<?php CPBSHelper::getFormName('rental_minute_quantity[price][]'); ?>" value="<?php echo esc_attr($value['price']); ?>"/>
													</div>									
												</td>
												<td>
													<div>
														<a href="#" class="to-table-button-remove"><?php esc_html_e('Remove','car-park-booking-system'); ?></a>
													</div>
												</td>										
											</tr>	 
<?php				  
				}
			}
		}
?>
										</table>
										<div> 
											<a href="#" class="to-table-button-add"><?php esc_html_e('Add','car-park-booking-system'); ?></a>
										</div>
									</div>
								</li>														
							</ul>
						</div>
						<div id="meta-box-price-rule-2-6">
							<ul class="to-form-field-list">
								<li>
									<h5><?php esc_html_e('User login status','car-park-booking-system'); ?></h5>
									<span class="to-legend"><?php esc_html_e('Apply coupon to all, logged or non-logged in users.','car-park-booking-system'); ?></span>
									<div class="to-clear-fix">
										<select name="<?php CPBSHelper::getFormName('user_login_status'); ?>" id="<?php CPBSHelper::getFormName('user_login_status'); ?>">
											<option value="-1" <?php CPBSHelper::selectedIf($this->data['meta']['user_login_status'],-1); ?>><?php esc_html_e('- None -','car-park-booking-system'); ?></option>
<?php
		foreach($this->data['dictionary']['user_login_status'] as $index=>$value)
			echo '<option value="'.esc_attr($index).'" '.(CPBSHelper::selectedIf($this->data['meta']['user_login_status'],$index,false)).'>'.esc_html($value[0]).'</option>';
?>
										</select>
									</div>
								</li> 	
								<li>
									<h5><?php esc_html_e('User groups','car-park-booking-system'); ?></h5>
									<span class="to-legend"><?php esc_html_e('Apply coupon only to users from selected group(s).','car-park-booking-system'); ?></span>
									<div class="to-clear-fix">
										<select multiple="multiple" class="to-dropkick-disable"  name="<?php CPBSHelper::getFormName('user_group_id[]'); ?>">
											<option value="-1" <?php CPBSHelper::selectedIf($this->data['meta']['user_group_id'],-1); ?>><?php esc_html_e('- None -','car-park-booking-system'); ?></option>
<?php
		foreach($this->data['dictionary']['user_group'] as $index=>$value)
			echo '<option value="'.esc_attr($index).'" '.(CPBSHelper::selectedIf($this->data['meta']['user_group_id'],$index,false)).'>'.esc_html($value['name']).'</option>';
?>
										</select>
									</div>
								</li> 	
							</ul>
						</div>
					</div>
				</div>
				<div id="meta-box-price-rule-3">
					<ul class="to-form-field-list">
						<li>
							<h5><?php esc_html_e('Price source','car-park-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('Select price source.','car-park-booking-system'); ?>
							</span>
							<div class="to-clear-fix">
								<select name="<?php CPBSHelper::getFormName('price_source_type'); ?>">
<?php
		foreach($this->data['dictionary']['price_source_type'] as $index=>$value)
			echo '<option value="'.esc_attr($index).'" '.(CPBSHelper::selectedIf($this->data['meta']['price_source_type'],$index,false)).'>'.esc_html($value[0]).'</option>';
?>
								</select>
							</div>
						</li>
						<li>
							<h5><?php esc_html_e('Prices','car-park-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Net prices.','car-park-booking-system'); ?></span>
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
										<th width="35%">
											<div>
												<?php esc_html_e('Description','car-park-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Description.','car-park-booking-system'); ?>
												</span>
											</div>
										</th>
										<th width="20%">
											<div>
												<?php esc_html_e('Price alter','car-park-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Price alter type.','car-park-booking-system'); ?>
												</span>
											</div>
										</th>	
										<th width="15%">
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
												<select name="<?php CPBSHelper::getFormName('price_initial_alter_type_id'); ?>">
<?php
		foreach($this->data['dictionary']['price_alter_type'] as $index=>$value)
		{
			echo '<option value="'.esc_attr($index).'" '.(CPBSHelper::selectedIf($this->data['meta']['price_initial_alter_type_id'],$index,false)).'>'.esc_html($value[0]).'</option>';
		}
?>
												</select>												  
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
												<select name="<?php CPBSHelper::getFormName('price_rental_day_alter_type_id'); ?>">
<?php
		foreach($this->data['dictionary']['price_alter_type'] as $index=>$value)
		{
			echo '<option value="'.esc_attr($index).'" '.(CPBSHelper::selectedIf($this->data['meta']['price_rental_day_alter_type_id'],$index,false)).'>'.esc_html($value[0]).'</option>';
		}
?>
												</select>												  
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
												<select name="<?php CPBSHelper::getFormName('price_rental_hour_alter_type_id'); ?>">
<?php
		foreach($this->data['dictionary']['price_alter_type'] as $index=>$value)
		{
			echo '<option value="'.esc_attr($index).'" '.(CPBSHelper::selectedIf($this->data['meta']['price_rental_hour_alter_type_id'],$index,false)).'>'.esc_html($value[0]).'</option>';
		}
?>
												</select>												  
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
												<select name="<?php CPBSHelper::getFormName('price_rental_minute_alter_type_id'); ?>">
<?php
		foreach($this->data['dictionary']['price_alter_type'] as $index=>$value)
		{
			echo '<option value="'.esc_attr($index).'" '.(CPBSHelper::selectedIf($this->data['meta']['price_rental_minute_alter_type_id'],$index,false)).'>'.esc_html($value[0]).'</option>';
		}
?>
												</select>												  
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
				<div id="meta-box-price-rule-4">
					<ul class="to-form-field-list">
						<li>
							<h5><?php esc_html_e('Next rule processing','car-park-booking-system'); ?></h5>
							<span class="to-legend">
							<?php echo esc_html__('This option determine, whether prices will be set up based on this rule only or plugin has to processing next rule based on priority (order).','car-park-booking-system'); ?>
							</span>			   
							<div>
								<div class="to-radio-button">
									<input type="radio" value="1" id="<?php CPBSHelper::getFormName('process_next_rule_enable_1'); ?>" name="<?php CPBSHelper::getFormName('process_next_rule_enable'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['process_next_rule_enable'],1); ?>/>
									<label for="<?php CPBSHelper::getFormName('process_next_rule_enable_1'); ?>"><?php esc_html_e('Enable','car-park-booking-system'); ?></label>
									<input type="radio" value="0" id="<?php CPBSHelper::getFormName('process_next_rule_enable_0'); ?>" name="<?php CPBSHelper::getFormName('process_next_rule_enable'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['process_next_rule_enable'],0); ?>/>
									<label for="<?php CPBSHelper::getFormName('process_next_rule_enable_0'); ?>"><?php esc_html_e('Disable','car-park-booking-system'); ?></label>
								</div>  
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

				/***/

				$(\'input[name="'.CPBSHelper::getFormName('booking_form_id',false).'[]"],input[name="'.CPBSHelper::getFormName('location_id',false).'[]"],input[name="'.CPBSHelper::getFormName('place_type_id',false).'[]"],input[name="'.CPBSHelper::getFormName('entry_day_number',false).'[]"]\').on(\'change\',function()
				{
					var checkbox=$(this).parents(\'li:first\').find(\'input\');

					var value=parseInt($(this).val());
					if(value===-1)
					{
						checkbox.prop(\'checked\',false);
						checkbox.first().prop(\'checked\',true);
					}
					else checkbox.first().prop(\'checked\',false);

					var checked=[];
					checkbox.each(function()
					{
						if($(this).is(\':checked\'))
							checked.push(parseInt($(this).val(),10));
					});

					if(checked.length===0)
					{
						checkbox.prop(\'checked\',false);
						checkbox.first().prop(\'checked\',true);
					}

					checkbox.button(\'refresh\');
				});

				/***/

				$(\'#to-table-rental-date\').table();
				$(\'#to-table-rental-day-quantity\').table();
				$(\'#to-table-rental-hour-quantity\').table();
				$(\'#to-table-rental-minute-quantity\').table();

				/***/

				var helper=new CPBSHelper();

				var timeFormat=\''.CPBSOption::getOption('time_format').'\';
				var dateFormat=\''.CPBSJQueryUIDatePicker::convertDateFormat(CPBSOption::getOption('date_format')).'\';

				helper.createCustomDateTimePicker(dateFormat,timeFormat);
			});			
		');