<?php
		echo $this->data['nonce']; 

		$Date=new CPBSDate();
		$Validation=new CPBSValidation();

		if(($Validation->isEmpty($this->data['meta']['coordinate_latitude'])) || ($Validation->isEmpty($this->data['meta']['coordinate_longitude'])))
		{
?>	
			<div class="notice notice-error">
				<p>
					<?php esc_html_e('Please provide coordinates of location in "Address" tab. Otherwise location will not be available in booking form.','car-park-booking-system') ?>
				</p>
			</div>
<?php
		}
?>
		<div class="to">
			<div class="ui-tabs">
				<ul>
					<li><a href="#meta-box-location-1"><?php esc_html_e('General','car-park-booking-system'); ?></a></li>
					<li><a href="#meta-box-location-2"><?php esc_html_e('Park spaces','car-park-booking-system'); ?></a></li>
					<li><a href="#meta-box-location-3"><?php esc_html_e('Address','car-park-booking-system'); ?></a></li>
					<li><a href="#meta-box-location-4"><?php esc_html_e('Availability','car-park-booking-system'); ?></a></li>
					<li><a href="#meta-box-location-5"><?php esc_html_e('Payments','car-park-booking-system'); ?></a></li>
					<li><a href="#meta-box-location-6"><?php esc_html_e('Notifications','car-park-booking-system'); ?></a></li>
					<li><a href="#meta-box-location-7"><?php esc_html_e('Google Calendar','car-park-booking-system'); ?></a></li>
				</ul>
				<div id="meta-box-location-1">
					<ul class="to-form-field-list"> 
						<?php echo CPBSHelper::createPostIdField(__('Location ID','car-park-booking-system')); ?>
						<li>
							<h5><?php esc_html_e('Entry period','car-park-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('Set range (in days/hours/minutes) during which customer can book a space.','car-park-booking-system'); ?><br/>
								<?php esc_html_e('Eg. range 1-14 days means that customer can book a space from tomorrow during next two weeks.','car-park-booking-system'); ?><br/>
								<?php esc_html_e('Empty values means that entry period is not limited.','car-park-booking-system'); ?>
							</span>
							<div>
								<span class="to-legend-field"><?php esc_html_e('From (number of days/hours/minutes - counting from now - since when customer can book a space):','car-park-booking-system'); ?></span>
								<input type="text" maxlength="4" name="<?php CPBSHelper::getFormName('entry_period_from'); ?>" value="<?php echo esc_attr($this->data['meta']['entry_period_from']); ?>"/>
							</div>   
							<div>
								<span class="to-legend-field"><?php esc_html_e('To (number of days/hours/minutes - counting from now plus number of days/hours/minutes from previous field - until when customer can book a space):','car-park-booking-system'); ?></span>
								<input type="text" maxlength="4" name="<?php CPBSHelper::getFormName('entry_period_to'); ?>" value="<?php echo esc_attr($this->data['meta']['entry_period_to']); ?>"/>
							</div>  
							<div>
								<span class="to-legend-field"><?php esc_html_e('Time unit:','car-park-booking-system'); ?></span>
								<div class="to-radio-button">
									<input type="radio" value="1" id="<?php CPBSHelper::getFormName('entry_period_type_1'); ?>" name="<?php CPBSHelper::getFormName('entry_period_type'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['entry_period_type'],1); ?>/>
									<label for="<?php CPBSHelper::getFormName('entry_period_type_1'); ?>"><?php esc_html_e('Days','car-park-booking-system'); ?></label>
									<input type="radio" value="2" id="<?php CPBSHelper::getFormName('entry_period_type_2'); ?>" name="<?php CPBSHelper::getFormName('entry_period_type'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['entry_period_type'],2); ?>/>
									<label for="<?php CPBSHelper::getFormName('entry_period_type_2'); ?>"><?php esc_html_e('Hours','car-park-booking-system'); ?></label>
									<input type="radio" value="3" id="<?php CPBSHelper::getFormName('entry_period_type_3'); ?>" name="<?php CPBSHelper::getFormName('entry_period_type'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['entry_period_type'],3); ?>/>
									<label for="<?php CPBSHelper::getFormName('entry_period_type_3'); ?>"><?php esc_html_e('Minutes','car-park-booking-system'); ?></label>
								</div>  
							</div>
						</li> 
						<li>
							<h5><?php esc_html_e('Booking period','car-park-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('Maximum and minimum number of days/hours/minutes to rent a car park space.','car-park-booking-system'); ?><br/>
								<?php esc_html_e('Unit depends on selected billing type. Below values are treat as days for "Day" and "Day II" billing type, as hours for "Day + hour", "Day + hour II" and "Hour", as minutes for "Hour + minute" and "Minute".','car-park-booking-system'); ?><br/>
								<?php esc_html_e('Empty or zero values are ignored.','car-park-booking-system'); ?>
							</span>
							<div>
								<span class="to-legend-field"><?php esc_html_e('Minimum:','car-park-booking-system'); ?></span>
								<input type="text" maxlength="9" name="<?php CPBSHelper::getFormName('booking_period_from'); ?>" value="<?php echo esc_attr($this->data['meta']['booking_period_from']); ?>"/>
							</div>   
							<div>
								<span class="to-legend-field"><?php esc_html_e('Maximum:','car-park-booking-system'); ?></span>
								<input type="text" maxlength="9" name="<?php CPBSHelper::getFormName('booking_period_to'); ?>" value="<?php echo esc_attr($this->data['meta']['booking_period_to']); ?>"/>
							</div> 
						</li>
						<li>
							<h5><?php esc_html_e('Booking period depends on dates','car-park-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('Maximum and minimum number of days/hours/minutes to rent a car park space a for defined entry dates.','car-park-booking-system'); ?><br/>
								<?php esc_html_e('Unit depends on selected billing type. Below values are treat as days for "Day" and "Day II" billing type, as hours for "Day + hour", "Day + hour II" and "Hour", as minutes for "Hour + minute" and "Minute".','car-park-booking-system'); ?><br/>								
								<?php esc_html_e('Below options have higher priority than these defined in section "Booking period".','car-park-booking-system'); ?>
							</span> 
							<div class="to-clear-fix">
								<table class="to-table" id="to-table-booking-period-date">
									<tr>
										<th style="width:20%">
											<div>
												<?php esc_html_e('Start dare','car-park-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Start date.','car-park-booking-system'); ?>
												</span>
											</div>
										</th>
										<th style="width:20%">
											<div>
												<?php esc_html_e('End date','car-park-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('End date.','car-park-booking-system'); ?>
												</span>
											</div>
										</th>
										<th style="width:20%">
											<div>
												<?php esc_html_e('Minimum','car-park-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Minimum days/hours/minutes count of rental a car park space.','car-park-booking-system'); ?>
												</span>
											</div>
										</th>										
										<th style="width:20%">
											<div>
												<?php esc_html_e('Maximum','car-park-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Maximum days/hours/minutes count of rental a car park space.','car-park-booking-system'); ?>
												</span>
											</div>
										</th>	
										<th style="width:20%">
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
												<input type="text" class="to-datepicker-custom" name="<?php CPBSHelper::getFormName('booking_period_date[date_from][]'); ?>" title="<?php esc_attr_e('Enter start date.','car-park-booking-system'); ?>"/>
											</div>									
										</td>
										<td>
											<div>
												<input type="text" class="to-datepicker-custom" name="<?php CPBSHelper::getFormName('booking_period_date[date_to][]'); ?>" title="<?php esc_attr_e('Enter stop date.','car-park-booking-system'); ?>"/>
											</div>									
										</td>	
										<td>
											<div>
												<input type="text" maxlength="4" name="<?php CPBSHelper::getFormName('booking_period_date[unit_from][]'); ?>" title="<?php esc_attr_e('Enter minimum count of days/hours/minutes.','car-park-booking-system'); ?>"/>
											</div>									
										</td>
										<td>
											<div>
												<input type="text" maxlength="4" name="<?php CPBSHelper::getFormName('booking_period_date[unit_to][]'); ?>" title="<?php esc_attr_e('Enter minimum count of days/hours/minutes.','car-park-booking-system'); ?>"/>
											</div>									
										</td>	
										<td>
											<div>
												<a href="#" class="to-table-button-remove"><?php esc_html_e('Remove','car-park-booking-system'); ?></a>
											</div>
										</td>										
									</tr>	
									</tr>
<?php
		if(count($this->data['meta']['booking_period_date']))
		{
			foreach($this->data['meta']['booking_period_date'] as $index=>$value)
			{
?>
									<tr>
										<td>
											<div>
												<input type="text" class="to-datepicker-custom" value="<?php echo esc_attr($Date->formatDateToDisplay($value['date_from'])); ?>" name="<?php CPBSHelper::getFormName('booking_period_date[date_from][]'); ?>" title="<?php esc_attr_e('Enter start date.','car-park-booking-system'); ?>"/>
											</div>									
										</td>
										<td>
											<div>
												<input type="text" class="to-datepicker-custom" value="<?php echo esc_attr($Date->formatDateToDisplay($value['date_to'])); ?>" name="<?php CPBSHelper::getFormName('booking_period_date[date_to][]'); ?>" title="<?php esc_attr_e('Enter stop date.','car-park-booking-system'); ?>"/>
											</div>									
										</td>	
										<td>
											<div>
												<input type="text" maxlength="4" value="<?php echo esc_attr($value['unit_from']); ?>" name="<?php CPBSHelper::getFormName('booking_period_date[unit_from][]'); ?>" title="<?php esc_attr_e('Enter minimum count of days/hours/minutes.','car-park-booking-system'); ?>"/>
											</div>									
										</td>
										<td>
											<div>
												<input type="text" maxlength="4" value="<?php echo esc_attr($value['unit_to']); ?>" name="<?php CPBSHelper::getFormName('booking_period_date[unit_to][]'); ?>" title="<?php esc_attr_e('Enter maximum count of days/hours/minutes.','car-park-booking-system'); ?>"/>
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
?>
								</table>
								<div> 
									<a href="#" class="to-table-button-add"><?php esc_html_e('Add','car-park-booking-system'); ?></a>
								</div>
							</div>
						</li>						
					</ul>
				</div>
				<div id="meta-box-location-2">
					<ul class="to-form-field-list">
						<li>
							<h5><?php esc_html_e('Park spaces availability checking','car-park-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('Select in which way (if at all) plugin has to check if the space is free and available to book.','car-park-booking-system'); ?>
							</span>
							<div class="to-radio-button">
								<input type="radio" value="1" id="<?php CPBSHelper::getFormName('place_type_availability_check_enable_1'); ?>" name="<?php CPBSHelper::getFormName('place_type_availability_check_enable'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['place_type_availability_check_enable'],1); ?>/>
								<label for="<?php CPBSHelper::getFormName('place_type_availability_check_enable_1'); ?>"><?php esc_html_e('Enable','car-park-booking-system'); ?></label>
								<input type="radio" value="0" id="<?php CPBSHelper::getFormName('place_type_availability_check_enable_0'); ?>" name="<?php CPBSHelper::getFormName('place_type_availability_check_enable'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['place_type_availability_check_enable'],0); ?>/>
								<label for="<?php CPBSHelper::getFormName('place_type_availability_check_enable_0'); ?>"><?php esc_html_e('Disable','car-park-booking-system'); ?></label>
							</div>
						</li>  
						<li>
							<h5><?php esc_html_e('Park spaces quantity','car-park-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('Enter number of park space quantity for each type.','car-park-booking-system'); ?><br/>
								<?php esc_html_e('Allowed are integer numbers from range 0-9999.','car-park-booking-system'); ?><br/>
							</span>	
<?php
		if(count($this->data['dictionary']['place_type']))
		{
?>
								<div>
									<table class="to-table to-table-price">
										<tr>
											<th width="40%">
												<div>
													<?php esc_html_e('Name','car-park-booking-system'); ?>
													<span class="to-legend">
														<?php esc_html_e('Name.','car-park-booking-system'); ?>
													</span>
												</div>
											</th>
											<th width="20%">
												<div>
													<?php esc_html_e('Dimension','car-park-booking-system'); ?>
													<span class="to-legend">
														<?php esc_html_e('Dimension.','car-park-booking-system'); ?>
													</span>
												</div>
											</th>
											<th width="40%">
												<div>
													<?php esc_html_e('Quantity','car-park-booking-system'); ?>
													<span class="to-legend">
														<?php esc_html_e('Quantity.','car-park-booking-system'); ?>
													</span>
												</div>
											</th>	
										</tr>
<?php
			foreach($this->data['dictionary']['place_type'] as $index=>$value)
			{
?>
										<tr>
											<td>
												<div class="to-clear-fix">
													<?php echo esc_html($value['post']->post_title); ?>
												</div>
											</td>							
											<td>
												<div class="to-clear-fix">
													<?php echo sprintf(esc_html__('%sx%s m','car-park-booking-system'),$value['meta']['dimension_width'],$value['meta']['dimension_length']);; ?>
												</div>											
											</td>
											<td>
												<div class="to-clear-fix">
													<input type="text" maxlength="4" id="<?php CPBSHelper::getFormName('place_type_quantity_'.$index); ?>" name="<?php CPBSHelper::getFormName('place_type_quantity['.$index.']'); ?>" value="<?php echo esc_attr($this->data['meta']['place_type_quantity'][$index]); ?>"/>
												</div>
											</td>
										</tr>
<?php
			}
?>
									</table>
								</div>
<?php
		}
?>
						</li>
						<li>
							<h5><?php esc_html_e('Park spaces quantity in selected period','car-park-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('Enter number of park space of particular type in the selected period.','car-park-booking-system'); ?><br/>
								<?php esc_html_e('This setting has priority than these defined in the "Park spaces quantity" table.','car-park-booking-system'); ?>
							</span>	
<?php
		if(count($this->data['dictionary']['place_type']))
		{
?>
							<div>
								<table class="to-table" id="to-table-place-type-quantity-period">
									<tr>
										<th width="20%">
											<div>
												<?php esc_html_e('Name','car-park-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Name.','car-park-booking-system'); ?>
												</span>
											</div>
										</th>
										<th width="30%">
											<div>
												<?php esc_html_e('From','car-park-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Date and time of period start.','car-park-booking-system'); ?>
												</span>
											</div>
										</th>
										<th width="30%">
											<div>
												<?php esc_html_e('To','car-park-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Date and time of period end.','car-park-booking-system'); ?>
												</span>
											</div>
										</th>											
										<th width="10%">
											<div>
												<?php esc_html_e('Quantity','car-park-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Quantity.','car-park-booking-system'); ?>
												</span>
											</div>
										</th>	
										<th width="10%">
											<div>
												<?php esc_html_e('Remove','car-park-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Remove.','car-park-booking-system'); ?>
												</span>
											</div>
										</th>											
									</tr>
									<tr class="to-hidden">
										<td>
											<div class="to-clear-fix">
												<select name="<?php CPBSHelper::getFormName('place_type_quantity_period[place_type_id][]'); ?>" class="to-dropkick-disable">
<?php
			foreach($this->data['dictionary']['place_type'] as $index=>$value)
				echo '<option value="'.esc_attr($index).'">'.esc_html($value['post']->post_title).'</option>';
?>
												</select>
											</div>
										</td>							
										<td>
											<div class="to-clear-fix">
												<input type="text" class="to-datepicker-custom width-150" name="<?php CPBSHelper::getFormName('place_type_quantity_period[date_start][]'); ?>" title="<?php esc_attr_e('Enter date.','car-park-booking-system'); ?>"/>
												<input type="text" class="to-timepicker-custom width-150" name="<?php CPBSHelper::getFormName('place_type_quantity_period[time_start][]'); ?>" title="<?php esc_attr_e('Enter time.','car-park-booking-system'); ?>"/>													
											</div>											
										</td>
										<td>
											<div class="to-clear-fix">
												<input type="text" class="to-datepicker-custom width-150" name="<?php CPBSHelper::getFormName('place_type_quantity_period[date_stop][]'); ?>" title="<?php esc_attr_e('Enter date.','car-park-booking-system'); ?>"/>
												<input type="text" class="to-timepicker-custom width-150" name="<?php CPBSHelper::getFormName('place_type_quantity_period[time_stop][]'); ?>" title="<?php esc_attr_e('Enter time.','car-park-booking-system'); ?>"/>													
											</div>											
										</td>
										<td>
											<div class="to-clear-fix">
												<input type="text" maxlength="4" name="<?php CPBSHelper::getFormName('place_type_quantity_period[quantity][]'); ?>" title=""/>													
											</div>											
										</td>	
										<td>
											<div>
												<a href="#" class="to-table-button-remove"><?php esc_html_e('Remove','car-park-booking-system'); ?></a>
											</div>
										</td>
									</tr>
<?php
			if(is_array($this->data['meta']['place_type_quantity_period']))
			{
				foreach($this->data['meta']['place_type_quantity_period'] as $index=>$value)
				{
?>
									<tr>
										<td>
											<div class="to-clear-fix">
												<select name="<?php CPBSHelper::getFormName('place_type_quantity_period[place_type_id][]'); ?>">
<?php
					foreach($this->data['dictionary']['place_type'] as $placeTypeIndex=>$placeTypeValue)
						echo '<option value="'.esc_attr($placeTypeIndex).'" '.CPBSHelper::selectedIf($value['place_type_id'],$placeTypeIndex,false).'">'.esc_html($placeTypeValue['post']->post_title).'</option>';
?>
												</select>
											</div>
										</td>							
										<td>
											<div class="to-clear-fix">
												<input type="text" class="to-datepicker-custom" name="<?php CPBSHelper::getFormName('place_type_quantity_period[date_start][]'); ?>" value="<?php echo esc_attr($Date->formatDateToDisplay($value['date_start'])); ?>" title="<?php esc_attr_e('Enter date.','car-park-booking-system'); ?>"/>
												<input type="text" class="to-timepicker-custom" name="<?php CPBSHelper::getFormName('place_type_quantity_period[time_start][]'); ?>" value="<?php echo esc_attr($Date->formatTimeToDisplay($value['time_start'])); ?>"  title="<?php esc_attr_e('Enter time.','car-park-booking-system'); ?>"/>													
											</div>											
										</td>
										<td>
											<div class="to-clear-fix">
												<input type="text" class="to-datepicker-custom" name="<?php CPBSHelper::getFormName('place_type_quantity_period[date_stop][]'); ?>" value="<?php echo esc_attr($Date->formatDateToDisplay($value['date_stop'])); ?>"  title="<?php esc_attr_e('Enter date.','car-park-booking-system'); ?>"/>
												<input type="text" class="to-timepicker-custom" name="<?php CPBSHelper::getFormName('place_type_quantity_period[time_stop][]'); ?>" value="<?php echo esc_attr($Date->formatTimeToDisplay($value['time_stop'])); ?>" title="<?php esc_attr_e('Enter time.','car-park-booking-system'); ?>"/>													
											</div>											
										</td>
										<td>
											<div class="to-clear-fix">
												<input type="text" maxlength="4" name="<?php CPBSHelper::getFormName('place_type_quantity_period[quantity][]'); ?>" value="<?php echo esc_attr($value['quantity']); ?>" title=""/>													
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
?>
								</table>
								<div> 
									<a href="#" class="to-table-button-add"><?php esc_html_e('Add','car-park-booking-system'); ?></a>
								</div>
							</div>
<?php
		}
?>
						</li>
					</ul>
				</div>
				<div id="meta-box-location-3">
					<ul class="to-form-field-list">
						<li>
							<h5><?php esc_html_e('Location','car-park-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Start typing to find location.','car-park-booking-system'); ?></span>
							<div>
								<input type="text" name="<?php CPBSHelper::getFormName('location_search'); ?>" id="<?php CPBSHelper::getFormName('location_search'); ?>" value=""/>
							</div>
						</li>   						
						<li>
							<h5><?php esc_html_e('Address','car-park-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Specify address of the location.','car-park-booking-system'); ?></span>
							<div>
								<span class="to-legend-field"><?php esc_html_e('Street:','car-park-booking-system'); ?></span>
								<input type="text" name="<?php CPBSHelper::getFormName('address_street'); ?>" id="<?php CPBSHelper::getFormName('address_street'); ?>" value="<?php echo esc_attr($this->data['meta']['address_street']); ?>"/>
							</div>
							<div>
								<span class="to-legend-field"><?php esc_html_e('Street number:','car-park-booking-system'); ?></span>
								<input type="text" name="<?php CPBSHelper::getFormName('address_street_number'); ?>" id="<?php CPBSHelper::getFormName('address_street_number'); ?>" value="<?php echo esc_attr($this->data['meta']['address_street_number']); ?>"/>
							</div>
							<div>
								<span class="to-legend-field"><?php esc_html_e('Postcode:','car-park-booking-system'); ?></span>
								<input type="text" name="<?php CPBSHelper::getFormName('address_postcode'); ?>" id="<?php CPBSHelper::getFormName('address_postcode'); ?>" value="<?php echo esc_attr($this->data['meta']['address_postcode']); ?>"/>
							</div>
							<div>
								<span class="to-legend-field"><?php esc_html_e('City:','car-park-booking-system'); ?></span>
								<input type="text" name="<?php CPBSHelper::getFormName('address_city'); ?>" id="<?php CPBSHelper::getFormName('address_city'); ?>" value="<?php echo esc_attr($this->data['meta']['address_city']); ?>"/>
							</div>
							<div>
								<span class="to-legend-field"><?php esc_html_e('State:','car-park-booking-system'); ?></span>
								<input type="text" name="<?php CPBSHelper::getFormName('address_state'); ?>" id="<?php CPBSHelper::getFormName('address_state'); ?>" value="<?php echo esc_attr($this->data['meta']['address_state']); ?>"/>
							</div>
							<div>
								<span class="to-legend-field"><?php esc_html_e('Country:','car-park-booking-system'); ?></span>
								<select name="<?php CPBSHelper::getFormName('address_country'); ?>" id="<?php CPBSHelper::getFormName('address_country'); ?>">
<?php
		foreach($this->data['dictionary']['country'] as $index=>$value)
			echo '<option value="'.esc_attr($index).'" '.(CPBSHelper::selectedIf($this->data['meta']['address_country'],$index,false)).'>'.esc_html($value[0]).'</option>';
?>
								</select>
							</div>
						</li>
						<li>
							<h5><?php esc_html_e('Contact details','car-park-booking-system'); ?></h5> 
							<span class="to-legend"><?php esc_html_e('Specify contact details of the location.','car-park-booking-system'); ?></span>
							<div>
								<span class="to-legend-field"><?php esc_html_e('Phone number:','car-park-booking-system'); ?></span>
								<input type="text" name="<?php CPBSHelper::getFormName('contact_detail_phone_number'); ?>" id="<?php CPBSHelper::getFormName('contact_detail_phone_number'); ?>" value="<?php echo esc_attr($this->data['meta']['contact_detail_phone_number']); ?>"/>
							</div>
							<div>
								<span class="to-legend-field"><?php esc_html_e('Fax number:','car-park-booking-system'); ?></span>
								<input type="text" name="<?php CPBSHelper::getFormName('contact_detail_fax_number'); ?>" id="<?php CPBSHelper::getFormName('contact_detail_fax_number'); ?>" value="<?php echo esc_attr($this->data['meta']['contact_detail_fax_number']); ?>"/>
							</div>
							<div>
								<span class="to-legend-field"><?php esc_html_e('E-mail address:','car-park-booking-system'); ?></span>
								<input type="text" name="<?php CPBSHelper::getFormName('contact_detail_email_address'); ?>" id="<?php CPBSHelper::getFormName('contact_detail_email_address'); ?>" value="<?php echo esc_attr($this->data['meta']['contact_detail_email_address']); ?>"/>
							</div>
						</li>
						<li>
							<h5><?php esc_html_e('Coordinates','car-park-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Specify coordinates details (latitude, longitude) of the location.','car-park-booking-system'); ?></span>
							<div>
								<span class="to-legend-field"><?php esc_html_e('Latitude:','car-park-booking-system'); ?></span>
								<input type="text" name="<?php CPBSHelper::getFormName('coordinate_latitude'); ?>" id="<?php CPBSHelper::getFormName('coordinate_latitude'); ?>" value="<?php echo esc_attr($this->data['meta']['coordinate_latitude']); ?>"/>
							</div>
							<div>
								<span class="to-legend-field"><?php esc_html_e('Longitude:','car-park-booking-system'); ?></span>
								<input type="text" name="<?php CPBSHelper::getFormName('coordinate_longitude'); ?>" id="<?php CPBSHelper::getFormName('coordinate_longitude'); ?>" value="<?php echo esc_attr($this->data['meta']['coordinate_longitude']); ?>"/>
							</div>
						</li>						
					</ul>
				</div>
				<div id="meta-box-location-4">
					<ul class="to-form-field-list">
						<li>
							<h5><?php esc_html_e('Business hours','car-park-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('Specify working hours for a day of week or for specific date.','car-park-booking-system'); ?><br/>
								<?php esc_html_e('If your car park is open 24 hours, enter values 00:00 - 23:59 for a selected day of week/date.','car-park-booking-system'); ?><br/>
								<?php esc_html_e('You can set multiple hours for the same day of week/date.','car-park-booking-system'); ?>
							</span> 
							<div class="to-clear-fix">
								<table class="to-table" id="to-table-business-hour-date">
									<tr>
										<th width="25%">
											<div>
												<?php esc_html_e('Period type','car-park-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Type of period: day of week or specific date.','car-park-booking-system'); ?>
												</span>
											</div>
										</th>	
										<th width="25%">
											<div>
												<?php esc_html_e('Hours type','car-park-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Type of hours: for entry, exit or both.','car-park-booking-system'); ?>
												</span>
											</div>
										</th>											
										<th width="15%">
											<div>
												<?php esc_html_e('Date','car-park-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Date.','car-park-booking-system'); ?>
												</span>
											</div>
										</th>
										<th width="10%">
											<div>
												<?php esc_html_e('Start time','car-park-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Start time.','car-park-booking-system'); ?>
												</span>
											</div>
										</th>
										<th width="10%">
											<div>
												<?php esc_html_e('End time','car-park-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('End time.','car-park-booking-system'); ?>
												</span>
											</div>
										</th>
										<th width="15%">
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
											<div class="to-clear-fix">		
												<select name="<?php CPBSHelper::getFormName('business_hour[period_type][]'); ?>" class="to-dropkick-disable">
<?php
		for($i=1;$i<8;$i++) 
			echo '<option value="'.esc_attr($i).'">'.esc_html($Date->getDayName($i)).'</option>';
		echo '<option value="0">'.esc_html__('Specific date','car-park-booking-system').'</option>';
?>
												</select>												
											</div>
										</td>
										<td>
											<div class="to-clear-fix">		
												<select name="<?php CPBSHelper::getFormName('business_hour[hour_type][]'); ?>" class="to-dropkick-disable">
<?php
		foreach($this->data['dictionary']['business_hour_type'] as $index=>$value)
			echo '<option value="'.esc_attr($index).'">'.esc_html($value[0]).'</option>';
?>
												</select>												
											</div>
										</td>										
										<td>
											<div>
												<input type="text" class="to-datepicker-custom" name="<?php CPBSHelper::getFormName('business_hour[date][]'); ?>" title="<?php esc_attr_e('Enter date in format.','car-park-booking-system'); ?>"/>
											</div>									
										</td>
										<td>
											<div>
												<input type="text" class="to-timepicker-custom" name="<?php CPBSHelper::getFormName('business_hour[time_start][]'); ?>" title="<?php esc_attr_e('Enter start time.','car-park-booking-system'); ?>"/>
											</div>									
										</td>	
										<td>
											<div>
												<input type="text" class="to-timepicker-custom" name="<?php CPBSHelper::getFormName('business_hour[time_stop][]'); ?>" title="<?php esc_attr_e('Enter stop time.','car-park-booking-system'); ?>"/>
											</div>									
										</td>											
										<td>
											<div>
												<a href="#" class="to-table-button-remove"><?php esc_html_e('Remove','car-park-booking-system'); ?></a>
											</div>
										</td>
									</tr>
<?php
		if(count($this->data['meta']['business_hour']))
		{
			foreach($this->data['meta']['business_hour'] as $businessHourIndex=>$businessHourValue)
			{
				if((int)$businessHourValue['period_type']!==0)
				{
					$businessHourValue['date']='';
				}
?>
									<tr>
										<td>
											<div class="to-clear-fix">		
												<select name="<?php CPBSHelper::getFormName('business_hour[period_type][]'); ?>" id="<?php CPBSHelper::getFormName('business_hour_period_type_'.CPBSHelper::createId()); ?>">
<?php
				for($i=1;$i<8;$i++) 
					echo '<option value="'.esc_attr($i).'" '.($businessHourValue['period_type']===1 ? CPBSHelper::selectedIf($businessHourValue['day_number'],$i,false) : '').'>'.esc_html($Date->getDayName($i)).'</option>';
				echo '<option value="0"'.CPBSHelper::selectedIf($businessHourValue['period_type'],0,false).'>'.esc_html__('Specific date','car-park-booking-system').'</option>';
?>
												</select>												
											</div>
										</td>
										<td>
											<div class="to-clear-fix">		
												<select name="<?php CPBSHelper::getFormName('business_hour[hour_type][]'); ?>" id="<?php CPBSHelper::getFormName('business_hour_phour_type_'.CPBSHelper::createId()); ?>">
<?php
				foreach($this->data['dictionary']['business_hour_type'] as $index=>$value)
					echo '<option value="'.esc_attr($index).'"'.CPBSHelper::selectedIf($businessHourValue['hour_type'],$index,false).'>'.esc_html($value[0]).'</option>';
?>
												</select>												
											</div>
										</td>	
										
										<td>
											<div>
												<input type="text" class="to-datepicker-custom" value="<?php echo esc_attr($Date->formatDateToDisplay($businessHourValue['date'])); ?>" name="<?php CPBSHelper::getFormName('business_hour[date][]'); ?>" title="<?php esc_attr_e('Enter date.','car-park-booking-system'); ?>"/>
											</div>									
										</td>
										<td>
											<div>
												<input type="text" class="to-timepicker-custom" value="<?php echo esc_attr($Date->formatTimeToDisplay($businessHourValue['time_start'])); ?>" name="<?php CPBSHelper::getFormName('business_hour[time_start][]'); ?>" title="<?php esc_attr_e('Enter time.','car-park-booking-system'); ?>"/>
											</div>									
										</td>	
										<td>
											<div>
												<input type="text" class="to-timepicker-custom" value="<?php echo esc_attr($Date->formatTimeToDisplay($businessHourValue['time_stop'])); ?>" name="<?php CPBSHelper::getFormName('business_hour[time_stop][]'); ?>" title="<?php esc_attr_e('Enter time.','car-park-booking-system'); ?>"/>
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
?>									
								</table>
								<div> 
									<a href="#" class="to-table-button-add"><?php esc_html_e('Add','car-park-booking-system'); ?></a>
								</div>
							</div>
						</li>
						<li>
							<h5><?php esc_html_e('Exclude dates','car-park-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Specify dates not available for booking. Past (or invalid date ranges) will be removed during saving.','car-park-booking-system'); ?></span>
							<div>	
								<table class="to-table" id="to-table-exclude-date">
									<tr>
										<th width="40%">
											<div>
												<?php esc_html_e('Start date','car-park-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Start date.','car-park-booking-system'); ?>
												</span>
											</div>
										</th>
										<th width="40%">
											<div>
												<?php esc_html_e('End date','car-park-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('End date.','car-park-booking-system'); ?>
												</span>
											</div>
										</th>
										<th width="20%">
											<div>
												<?php esc_html_e('Remove','car-park-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Remove this entry','car-park-booking-system'); ?>
												</span>
											</div>
										</th>
									</tr>
									<tr class="to-hidden">
										<td>
											<div>
												<input type="text" class="to-datepicker-custom" name="<?php CPBSHelper::getFormName('date_exclude_start[]'); ?>" title="<?php esc_attr_e('Enter start date.','car-park-booking-system'); ?>"/>
											</div>									
										</td>
										<td>
											<div>
												<input type="text" class="to-datepicker-custom" name="<?php CPBSHelper::getFormName('date_exclude_stop[]'); ?>" title="<?php esc_attr_e('Enter start date.','car-park-booking-system'); ?>"/>
											</div>									
										</td>	
										<td>
											<div>
												<a href="#" class="to-table-button-remove"><?php esc_html_e('Remove','car-park-booking-system'); ?></a>
											</div>
										</td>
									</tr>
<?php
		if(count($this->data['meta']['date_exclude']))
		{
			foreach($this->data['meta']['date_exclude'] as $dateExcludeIndex=>$dateExcludeValue)
			{
?>
											<tr>
												<td>
													<div>
														<input type="text" class="to-datepicker-custom" value="<?php echo esc_attr($Date->formatDateToDisplay($dateExcludeValue['start'])); ?>" name="<?php CPBSHelper::getFormName('date_exclude_start[]'); ?>" title="<?php esc_attr_e('Enter start date.','car-park-booking-system'); ?>"/>
													</div>									
												</td>
												<td>
													<div>
														<input type="text" class="to-datepicker-custom" value="<?php echo esc_attr($Date->formatDateToDisplay($dateExcludeValue['stop'])); ?>" name="<?php CPBSHelper::getFormName('date_exclude_stop[]'); ?>" title="<?php esc_attr_e('Enter start date.','car-park-booking-system'); ?>"/>
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
?>
								</table>
								<div> 
									<a href="#" class="to-table-button-add"><?php esc_html_e('Add','car-park-booking-system'); ?></a>
								</div>
							</div>
						</li>
					</ul>
				</div>
				<div id="meta-box-location-5">
					<div class="ui-tabs">
						<ul>
							<li><a href="#meta-box-location-4-1"><?php esc_html_e('General','car-park-booking-system'); ?></a></li>
							<li><a href="#meta-box-location-4-2"><?php esc_html_e('Payments','car-park-booking-system'); ?></a></li>
						</ul>					
						<div id="meta-box-location-4-1">
							<ul class="to-form-field-list">
								<li>
									<h5><?php esc_html_e('Payment','car-park-booking-system'); ?></h5>
									<span class="to-legend">
										<?php esc_html_e('Select one or more payment methods available in this location.','car-park-booking-system'); ?><br/>
										<?php esc_html_e('For some of them you have to enter additional settings in tab named "Payments".','car-park-booking-system'); ?>
									</span>
									<div class="to-checkbox-button">
<?php
		foreach($this->data['dictionary']['payment'] as $index=>$value)
		{
?>
										<input type="checkbox" value="<?php echo esc_attr($index); ?>" id="<?php CPBSHelper::getFormName('payment_id_'.$index); ?>" name="<?php CPBSHelper::getFormName('payment_id[]'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['payment_id'],$index); ?>/>
										<label for="<?php CPBSHelper::getFormName('payment_id_'.$index); ?>"><?php echo esc_html($value[0]); ?></label>							
<?php		
		}
?>
									</div>	
								</li>
								<li>
									<h5><?php esc_html_e('Default payment','car-park-booking-system'); ?></h5>
									<span class="to-legend">
										<?php esc_html_e('Select default payment method.','car-park-booking-system'); ?>
									</span>
									<div class="to-radio-button">
										<input type="radio" value="-1" id="<?php CPBSHelper::getFormName('payment_default_id_0'); ?>" name="<?php CPBSHelper::getFormName('payment_default_id'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['payment_default_id'],$index); ?>/>
										<label for="<?php CPBSHelper::getFormName('payment_default_id_0'); ?>"><?php echo esc_html_e('- None - ','car-park-booking-system'); ?></label>	
<?php
		foreach($this->data['dictionary']['payment'] as $index=>$value)
		{
?>
										<input type="radio" value="<?php echo esc_attr($index); ?>" id="<?php CPBSHelper::getFormName('payment_default_id_'.$index); ?>" name="<?php CPBSHelper::getFormName('payment_default_id'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['payment_default_id'],$index); ?>/>
										<label for="<?php CPBSHelper::getFormName('payment_default_id_'.$index); ?>"><?php echo esc_html($value[0]); ?></label>							
<?php		
		}
?>
									</div>	
								</li>
								<li>
									<h5><?php esc_html_e('Payment selection','car-park-booking-system'); ?></h5>
									<span class="to-legend"><?php esc_html_e('Set payment method as mandatory to select by the customer.','car-park-booking-system'); ?></span>
									<div class="to-radio-button">
										<input type="radio" value="1" id="<?php CPBSHelper::getFormName('payment_mandatory_enable_1'); ?>" name="<?php CPBSHelper::getFormName('payment_mandatory_enable'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['payment_mandatory_enable'],1); ?>/>
										<label for="<?php CPBSHelper::getFormName('payment_mandatory_enable_1'); ?>"><?php esc_html_e('Enable','car-park-booking-system'); ?></label>
										<input type="radio" value="0" id="<?php CPBSHelper::getFormName('payment_mandatory_enable_0'); ?>" name="<?php CPBSHelper::getFormName('payment_mandatory_enable'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['payment_mandatory_enable'],0); ?>/>
										<label for="<?php CPBSHelper::getFormName('payment_mandatory_enable_0'); ?>"><?php esc_html_e('Disable','car-park-booking-system'); ?></label>
									</div>
								</li>
								<li>
									<h5><?php esc_html_e('Payment processing','car-park-booking-system'); ?></h5>
									<span class="to-legend">
										<?php esc_html_e('Enable or disable possibility of paying by booking form.','car-park-booking-system'); ?><br/>
										<?php esc_html_e('Disabling this option means that customer can choose payment method, but he won\'t be able to pay.','car-park-booking-system'); ?>
									</span>
									<div class="to-radio-button">
										<input type="radio" value="1" id="<?php CPBSHelper::getFormName('payment_processing_enable_1'); ?>" name="<?php CPBSHelper::getFormName('payment_processing_enable'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['payment_processing_enable'],1); ?>/>
										<label for="<?php CPBSHelper::getFormName('payment_processing_enable_1'); ?>"><?php esc_html_e('Enable','car-park-booking-system'); ?></label>
										<input type="radio" value="0" id="<?php CPBSHelper::getFormName('payment_processing_enable_0'); ?>" name="<?php CPBSHelper::getFormName('payment_processing_enable'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['payment_processing_enable'],0); ?>/>
										<label for="<?php CPBSHelper::getFormName('payment_processing_enable_0'); ?>"><?php esc_html_e('Disable','car-park-booking-system'); ?></label>
									</div>
								</li>   
								<li>
									<h5><?php esc_html_e('WooCommerce payments on step #3','car-park-booking-system'); ?></h5>
									<span class="to-legend">
										<?php esc_html_e('Enable or disable possibility to choose wooCommerce payment method in step #3.','car-park-booking-system'); ?><br/>
										<?php esc_html_e('This option is available if wooCommerce support is enabled.','car-park-booking-system'); ?>
									</span>
									<div class="to-radio-button">
										<input type="radio" value="1" id="<?php CPBSHelper::getFormName('payment_woocommerce_step_3_enable_1'); ?>" name="<?php CPBSHelper::getFormName('payment_woocommerce_step_3_enable'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['payment_woocommerce_step_3_enable'],1); ?>/>
										<label for="<?php CPBSHelper::getFormName('payment_woocommerce_step_3_enable_1'); ?>"><?php esc_html_e('Enable','car-park-booking-system'); ?></label>
										<input type="radio" value="0" id="<?php CPBSHelper::getFormName('payment_woocommerce_step_3_enable_0'); ?>" name="<?php CPBSHelper::getFormName('payment_woocommerce_step_3_enable'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['payment_woocommerce_step_3_enable'],0); ?>/>
										<label for="<?php CPBSHelper::getFormName('payment_woocommerce_step_3_enable_0'); ?>"><?php esc_html_e('Disable','car-park-booking-system'); ?></label>
									</div>
								</li>
							</ul>
						</div>
						<div id="meta-box-location-4-2">
							<div class="ui-tabs">
								<ul>
									<li><a href="#meta-box-location-4-2-1"><?php esc_html_e('Stripe','car-park-booking-system'); ?></a></li>
									<li><a href="#meta-box-location-4-2-2"><?php esc_html_e('PayPal','car-park-booking-system'); ?></a></li>
									<li><a href="#meta-box-location-4-2-3"><?php esc_html_e('Cash','car-park-booking-system'); ?></a></li>
									<li><a href="#meta-box-location-4-2-4"><?php esc_html_e('Wire transfer','car-park-booking-system'); ?></a></li>
								</ul>
								<div id="meta-box-location-4-2-1">
									<div class="to-notice-small to-notice-small-error">
										<?php echo sprintf(__('You can check possible errors related to processing payments via Stripe gateway in <a href="%s" target="_blank">"Plugin Options" in  "Log Manager / Stripe" tab</a>.','car-park-booking-system'),admin_url('options-general.php?page=cpbs')); ?>
									</div>
									<ul class="to-form-field-list">
										<li>
											<h5><?php esc_html_e('Secret API key','car-park-booking-system'); ?></h5>
											<span class="to-legend"><?php echo sprintf(__('You can find more info about keys <a href="%s" target="_blank">here</a>.','car-park-booking-system'),'https://stripe.com/docs/keys'); ?></span>
											<div class="to-clear-fix">
												<input type="text" name="<?php CPBSHelper::getFormName('payment_stripe_api_key_secret'); ?>" value="<?php echo esc_attr($this->data['meta']['payment_stripe_api_key_secret']); ?>"/>
											</div>											
										</li>
										<li>
											<h5><?php esc_html_e('Publishable API key','car-park-booking-system'); ?></h5>
											<span class="to-legend"><?php echo sprintf(__('You can find more info about keys <a href="%s" target="_blank">here</a>.','car-park-booking-system'),'https://stripe.com/docs/keys'); ?></span>									
											<div class="to-clear-fix">
												<input type="text" name="<?php CPBSHelper::getFormName('payment_stripe_api_key_publishable'); ?>" value="<?php echo esc_attr($this->data['meta']['payment_stripe_api_key_publishable']); ?>"/>
											</div>											
										</li>
										<li>
											<h5><?php esc_html_e('Payment methods','car-park-booking-system'); ?></h5>
											<span class="to-legend"><?php esc_html_e('You can set up each of them in your "Stripe" dashboard under "Settings / Payment methods".','car-park-booking-system'); ?></span>											
											<div class="to-clear-fix">
												<div class="to-checkbox-button">
<?php
		foreach($this->data['dictionary']['payment_stripe_method'] as $index=>$value)
		{
?>
													<input type="checkbox" value="<?php echo esc_attr($index); ?>" id="<?php CPBSHelper::getFormName('payment_stripe_method_'.$index); ?>" name="<?php CPBSHelper::getFormName('payment_stripe_method[]'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['payment_stripe_method'],$index); ?>/>
													<label for="<?php CPBSHelper::getFormName('payment_stripe_method_'.$index); ?>"><?php echo esc_html($value[0]); ?></label>							
<?php		
		}
?>
												</div>	
											</div>											
										</li>
										<li>
											<h5><?php esc_html_e('Product ID','car-park-booking-system'); ?></h5>
											<span class="to-legend">
												<?php esc_html_e('Product ID. ','car-park-booking-system'); ?><br/>
												<?php esc_html_e('Value of this field will be filled during payment processing. In almost all cases you should leave it blank.','car-park-booking-system'); ?>
											</span>											
											<div class="to-clear-fix">
												<input type="text" name="<?php CPBSHelper::getFormName('payment_stripe_product_id'); ?>" value="<?php echo esc_attr($this->data['meta']['payment_stripe_product_id']); ?>"/>
											</div>											
										</li>
										<li>
											<h5><?php esc_html_e('Redirection delay','car-park-booking-system'); ?></h5>
											<span class="to-legend"><?php esc_html_e('Duration of redirection delay (in seconds) to the Stripe gateway.','car-park-booking-system'); ?></span>											
											<div class="to-clear-fix">
												<input type="text" maxlength="2" name="<?php CPBSHelper::getFormName('payment_stripe_redirect_duration'); ?>" value="<?php echo esc_attr($this->data['meta']['payment_stripe_redirect_duration']); ?>"/>
											</div>												
										</li>
										<li>
											<h5><?php esc_html_e('"Success" URL address','car-park-booking-system'); ?></h5>
											<span class="to-legend"><?php esc_html_e('"Success" URL address.','car-park-booking-system'); ?></span>											
											<div class="to-clear-fix">
												<input type="text" name="<?php CPBSHelper::getFormName('payment_stripe_success_url_address'); ?>" value="<?php echo esc_attr($this->data['meta']['payment_stripe_success_url_address']); ?>"/>
											</div>											
										</li>									
										<li>
											<h5><?php esc_html_e('"Cancel" URL address','car-park-booking-system'); ?></h5>
											<span class="to-legend"><?php esc_html_e('"Cancel" URL address.','car-park-booking-system'); ?></span>											
											<div class="to-clear-fix">
												<input type="text" name="<?php CPBSHelper::getFormName('payment_stripe_cancel_url_address'); ?>" value="<?php echo esc_attr($this->data['meta']['payment_stripe_cancel_url_address']); ?>"/>
											</div>												
										</li>
										<li>
											<h5><?php esc_html_e('Booking summary page ID:','car-park-booking-system'); ?></h5>
											<span class="to-legend">
												<?php esc_html_e('Booking summary page is a special page which contains summary of the sent booking with a link to download a PDF document.','car-park-booking-system'); ?><br/>
												<?php esc_html_e('This page (displayed after successfully payment only) has to include \'[cpbs_booking_summary booking_form_id=""]\' shortcode".','car-park-booking-system'); ?><br/>
												<?php esc_html_e('In case if the below field includes valid page ID, URL address entered in the \' "Success" URL address \' field is ignored.','car-park-booking-system'); ?>
											</span>											
											<div class="to-clear-fix">
												<input type="text" maxlength="9" name="<?php CPBSHelper::getFormName('payment_stripe_booking_summary_page_id'); ?>" value="<?php echo esc_attr($this->data['meta']['payment_stripe_booking_summary_page_id']); ?>"/>
											</div>												
										</li>										
										<li>
											<h5><?php esc_html_e('Logo','car-park-booking-system'); ?></h5>
											<span class="to-legend"><?php esc_html_e('Logo:','car-park-booking-system'); ?></span>											
											<div class="to-clear-fix">
												<input type="text" name="<?php CPBSHelper::getFormName('payment_stripe_logo_src'); ?>" id="<?php CPBSHelper::getFormName('payment_stripe_logo_src'); ?>" class="to-float-left" value="<?php echo esc_attr($this->data['meta']['payment_stripe_logo_src']); ?>"/>
												<input type="button" name="<?php CPBSHelper::getFormName('payment_stripe_logo_src_browse'); ?>" id="<?php CPBSHelper::getFormName('payment_stripe_logo_src_browse'); ?>" class="to-button-browse to-button" value="<?php esc_attr_e('Browse','car-park-booking-system'); ?>"/>
											</div>											
										</li>
										<li>
											<h5><?php esc_html_e('Information for customer','car-park-booking-system'); ?></h5>
											<span class="to-legend"><?php esc_html_e('Additional information for the customer:','car-park-booking-system'); ?></span>											
											<div class="to-clear-fix">
												<textarea rows="1" cols="1" name="<?php CPBSHelper::getFormName('payment_stripe_info'); ?>"><?php echo esc_html($this->data['meta']['payment_stripe_info']); ?></textarea>
											</div>												
										</li>
									</ul>
								</div>
								<div id="meta-box-location-4-2-2">
									<div class="to-notice-small to-notice-small-error">
										<?php echo sprintf(__('You can check possible errors related to processing payments via PayPal gateway in <a href="%s" target="_blank">"Plugin Options" in  "Log Manager / PayPal" tab</a>.','car-park-booking-system'),admin_url('options-general.php?page=cpbs')); ?>
									</div>
									<ul class="to-form-field-list">
										<li>
											<h5><?php esc_html_e('E-mail address','car-park-booking-system'); ?></h5>
											<span class="to-legend"><?php esc_html_e('E-mail address.','car-park-booking-system'); ?></span>	
											<div class="to-clear-fix">
												<input type="text" name="<?php CPBSHelper::getFormName('payment_paypal_email_address'); ?>" value="<?php echo esc_attr($this->data['meta']['payment_paypal_email_address']); ?>"/>
											</div>											
										</li>									
										<li>
											<h5><?php esc_html_e('Sandbox mode','car-park-booking-system'); ?></h5>
											<span class="to-legend"><?php esc_html_e('Sandbox mode.','car-park-booking-system'); ?></span>	
											<div class="to-radio-button">
												<input type="radio" value="1" id="<?php CPBSHelper::getFormName('payment_paypal_sandbox_mode_enable_1'); ?>" name="<?php CPBSHelper::getFormName('payment_paypal_sandbox_mode_enable'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['payment_paypal_sandbox_mode_enable'],1); ?>/>
												<label for="<?php CPBSHelper::getFormName('payment_paypal_sandbox_mode_enable_1'); ?>"><?php esc_html_e('Enable','car-park-booking-system'); ?></label>
												<input type="radio" value="0" id="<?php CPBSHelper::getFormName('payment_paypal_sandbox_mode_enable_0'); ?>" name="<?php CPBSHelper::getFormName('payment_paypal_sandbox_mode_enable'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['payment_paypal_sandbox_mode_enable'],0); ?>/>
												<label for="<?php CPBSHelper::getFormName('payment_paypal_sandbox_mode_enable_0'); ?>"><?php esc_html_e('Disable','car-park-booking-system'); ?></label>
											</div>
										</li>	
										<li>
											<h5><?php esc_html_e('Redirection delay','car-park-booking-system'); ?></h5>
											<span class="to-legend"><?php esc_html_e('Duration of redirection delay (in seconds) to the PayPal gateway.','car-park-booking-system'); ?></span>												
											<div class="to-clear-fix">
												<input type="text" maxlength="2" name="<?php CPBSHelper::getFormName('payment_paypal_redirect_duration'); ?>" value="<?php echo esc_attr($this->data['meta']['payment_paypal_redirect_duration']); ?>"/>
											</div>				
										</li>	
										<li>
											<h5><?php esc_html_e('"Success" URL address','car-park-booking-system'); ?></h5>
											<span class="to-legend"><?php esc_html_e('"Success" URL address.','car-park-booking-system'); ?></span>												
											<div class="to-clear-fix">
												<input type="text" name="<?php CPBSHelper::getFormName('payment_paypal_success_url_address'); ?>" value="<?php echo esc_attr($this->data['meta']['payment_paypal_success_url_address']); ?>"/>
											</div>
										</li>									
										<li>
											<h5><?php esc_html_e('"Cancel" URL address','car-park-booking-system'); ?></h5>
											<span class="to-legend"><?php esc_html_e('"Cancel" URL address.','car-park-booking-system'); ?></span>												
											<div class="to-clear-fix">
												<input type="text" name="<?php CPBSHelper::getFormName('payment_paypal_cancel_url_address'); ?>" value="<?php echo esc_attr($this->data['meta']['payment_paypal_cancel_url_address']); ?>"/>
											</div>		
										</li>	
										<li>
											<h5><?php esc_html_e('Booking summary page ID:','car-park-booking-system'); ?></h5>
											<span class="to-legend">
												<?php esc_html_e('Booking summary page is a special page which contains summary of the sent booking with a link to download a PDF document.','car-park-booking-system'); ?><br/>
												<?php esc_html_e('This page (displayed after successfully payment only) has to include \'[cpbs_booking_summary booking_form_id=""]\' shortcode".','car-park-booking-system'); ?><br/>
												<?php esc_html_e('In case if the below field includes valid page ID, URL address entered in the \' "Success" URL address \' field is ignored.','car-park-booking-system'); ?>
											</span>											
											<div class="to-clear-fix">
												<input type="text" maxlength="9" name="<?php CPBSHelper::getFormName('payment_paypal_booking_summary_page_id'); ?>" value="<?php echo esc_attr($this->data['meta']['payment_paypal_booking_summary_page_id']); ?>"/>
											</div>												
										</li>	
										<li>
											<h5><?php esc_html_e('Logo','car-park-booking-system'); ?></h5>
											<span class="to-legend"><?php esc_html_e('Logo.','car-park-booking-system'); ?></span>												
											<div class="to-clear-fix">
												<input type="text" name="<?php CPBSHelper::getFormName('payment_paypal_logo_src'); ?>" id="<?php CPBSHelper::getFormName('payment_paypal_logo_src'); ?>" class="to-float-left" value="<?php echo esc_attr($this->data['meta']['payment_paypal_logo_src']); ?>"/>
												<input type="button" name="<?php CPBSHelper::getFormName('payment_paypal_logo_src_browse'); ?>" id="<?php CPBSHelper::getFormName('payment_paypal_logo_src_browse'); ?>" class="to-button-browse to-button" value="<?php esc_attr_e('Browse','car-park-booking-system'); ?>"/>
											</div>
										</li>	
										<li>
											<h5><?php esc_html_e('Information for customer','car-park-booking-system'); ?></h5>
											<span class="to-legend"><?php esc_html_e('Additional information for customer.','car-park-booking-system'); ?></span>												
											<div class="to-clear-fix">
												<textarea rows="1" cols="1" name="<?php CPBSHelper::getFormName('payment_paypal_info'); ?>"><?php echo esc_html($this->data['meta']['payment_paypal_info']); ?></textarea>
											</div>											
										</li>	
									</ul>
								</div>
								<div id="meta-box-location-4-2-3">
									<ul class="to-form-field-list">
										<li>
											<h5><?php esc_html_e('Logo','car-park-booking-system'); ?></h5>
											<span class="to-legend"><?php esc_html_e('Logo.','car-park-booking-system'); ?></span>
											<div class="to-clear-fix">
												<input type="text" name="<?php CPBSHelper::getFormName('payment_cash_logo_src'); ?>" id="<?php CPBSHelper::getFormName('payment_cash_logo_src'); ?>" class="to-float-left" value="<?php echo esc_attr($this->data['meta']['payment_cash_logo_src']); ?>"/>
												<input type="button" name="<?php CPBSHelper::getFormName('payment_cash_logo_src_browse'); ?>" id="<?php CPBSHelper::getFormName('payment_cash_logo_src_browse'); ?>" class="to-button-browse to-button" value="<?php esc_attr_e('Browse','car-park-booking-system'); ?>"/>
											</div>											
										</li>									
										<li>
											<h5><?php esc_html_e('Information for customer','car-park-booking-system'); ?></h5>
											<span class="to-legend"><?php esc_html_e('Additional information for customer.','car-park-booking-system'); ?></span>
											<div class="to-clear-fix">
												<textarea rows="1" cols="1" name="<?php CPBSHelper::getFormName('payment_cash_info'); ?>"><?php echo esc_html($this->data['meta']['payment_cash_info']); ?></textarea>
											</div>											
										</li>										
									</ul>
								</div>
								<div id="meta-box-location-4-2-4">
									<ul class="to-form-field-list">
										<li>
											<h5><?php esc_html_e('Logo','car-park-booking-system'); ?></h5>
											<span class="to-legend"><?php esc_html_e('Logo.','car-park-booking-system'); ?></span>
											<div class="to-clear-fix">
												<input type="text" name="<?php CPBSHelper::getFormName('payment_wire_transfer_logo_src'); ?>" id="<?php CPBSHelper::getFormName('payment_wire_transfer_logo_src'); ?>" class="to-float-left" value="<?php echo esc_attr($this->data['meta']['payment_wire_transfer_logo_src']); ?>"/>
												<input type="button" name="<?php CPBSHelper::getFormName('payment_wire_transfer_logo_src_browse'); ?>" id="<?php CPBSHelper::getFormName('payment_wire_transfer_logo_src_browse'); ?>" class="to-button-browse to-button" value="<?php esc_attr_e('Browse','car-park-booking-system'); ?>"/>
											</div>										
										</li>
										<li>
											<h5><?php esc_html_e('Information for customer','car-park-booking-system'); ?></h5>
											<span class="to-legend"><?php esc_html_e('Additional information for customer.','car-park-booking-system'); ?></span>
											<div class="to-clear-fix">
												<textarea rows="1" cols="1" name="<?php CPBSHelper::getFormName('payment_wire_transfer_info'); ?>"><?php echo esc_html($this->data['meta']['payment_wire_transfer_info']); ?></textarea>
											</div>											
										</li>
									</ul>
								</div>	
							</div>
						</div>
					</div>
				</div>
				<div id="meta-box-location-6">
					<div class="ui-tabs">
						<ul>
							<li><a href="#meta-box-location-6-1"><?php esc_html_e('E-mail','car-park-booking-system'); ?></a></li>
							<li><a href="#meta-box-location-6-2"><?php esc_html_e('Vonage SMS','car-park-booking-system'); ?></a></li>
							<li><a href="#meta-box-location-6-3"><?php esc_html_e('Twilio SMS','car-park-booking-system'); ?></a></li>
							<li><a href="#meta-box-location-6-4"><?php esc_html_e('Telegram','car-park-booking-system'); ?></a></li>
						</ul>
						<div id="meta-box-location-6-1">
							<ul class="to-form-field-list">
								<li>
									<h5><?php esc_html_e('Sender e-mail account','car-park-booking-system'); ?></h5>
									<span class="to-legend">
										<?php esc_html_e('Select sender e-mail account.','car-park-booking-system'); ?>
									</span>
									<div class="to-clear-fix">
										<select name="<?php CPBSHelper::getFormName('booking_new_sender_email_account_id'); ?>" id="<?php CPBSHelper::getFormName('booking_new_sender_email_account_id'); ?>">
<?php
		echo '<option value="-1" '.(CPBSHelper::selectedIf($this->data['meta']['booking_new_sender_email_account_id'],-1,false)).'>'.esc_html__(' - Not set -','car-park-booking-system').'</option>';
		foreach($this->data['dictionary']['email_account'] as $index=>$value)
			echo '<option value="'.esc_attr($index).'" '.(CPBSHelper::selectedIf($this->data['meta']['booking_new_sender_email_account_id'],$index,false)).'>'.esc_html($value['post']->post_title).'</option>';
?>
										</select>
									</div>									
								</li>
								<li>
									<h5><?php esc_html_e('Recipient e-mail addresses','car-park-booking-system'); ?></h5>
									<span class="to-legend"><?php esc_html_e('List of recipients e-mail addresses separated by semicolon.','car-park-booking-system'); ?></span>
									<div class="to-clear-fix">
										<input type="text" name="<?php CPBSHelper::getFormName('booking_new_recipient_email_address'); ?>" value="<?php echo esc_attr($this->data['meta']['booking_new_recipient_email_address']); ?>"/>
									</div>
								</li>
								<li>
									<h5><?php esc_html_e('New booking notifications sending to customers','car-park-booking-system'); ?></h5>
									<span class="to-legend"><?php esc_html_e('Sending an e-mail message about new booking to the customers.','car-park-booking-system'); ?></span>
									<div class="to-radio-button">
										<input type="radio" value="1" id="<?php CPBSHelper::getFormName('booking_new_customer_email_notification_1'); ?>" name="<?php CPBSHelper::getFormName('booking_new_customer_email_notification'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['booking_new_customer_email_notification'],1); ?>/>
										<label for="<?php CPBSHelper::getFormName('booking_new_customer_email_notification_1'); ?>"><?php esc_html_e('Enable','car-park-booking-system'); ?></label>
										<input type="radio" value="0" id="<?php CPBSHelper::getFormName('booking_new_customer_email_notification_0'); ?>" name="<?php CPBSHelper::getFormName('booking_new_customer_email_notification'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['booking_new_customer_email_notification'],0); ?>/>
										<label for="<?php CPBSHelper::getFormName('booking_new_customer_email_notification_0'); ?>"><?php esc_html_e('Disable','car-park-booking-system'); ?></label>
									</div>
								</li>
								<li>
									<h5><?php esc_html_e('New booking notifications sending to customers in case of successful payment only','car-park-booking-system'); ?></h5>
									<span class="to-legend">
										<?php esc_html_e('Sending an e-mail message about new booking to the customers only if the booking has been paid.','car-park-booking-system'); ?><br/>
										<?php esc_html_e('This option works only for a built-in online payment methods like Stripe and PayPal.','car-park-booking-system'); ?><br/>
										<?php esc_html_e('This option works only if the option "New booking notifications sending to customers" is enabled.','car-park-booking-system'); ?>
									</span>
									<div class="to-clear-fix">
										<div class="to-radio-button">
											<input type="radio" value="1" id="<?php CPBSHelper::getFormName('booking_new_customer_email_notification_payment_success_1'); ?>" name="<?php CPBSHelper::getFormName('booking_new_customer_email_notification_payment_success'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['booking_new_customer_email_notification_payment_success'],1); ?>/>
											<label for="<?php CPBSHelper::getFormName('booking_new_customer_email_notification_payment_success_1'); ?>"><?php esc_html_e('Enable','car-park-booking-system'); ?></label>
											<input type="radio" value="0" id="<?php CPBSHelper::getFormName('booking_new_customer_email_notification_payment_success_0'); ?>" name="<?php CPBSHelper::getFormName('booking_new_customer_email_notification_payment_success'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['booking_new_customer_email_notification_payment_success'],0); ?>/>
											<label for="<?php CPBSHelper::getFormName('booking_new_customer_email_notification_payment_success_0'); ?>"><?php esc_html_e('Disable','car-park-booking-system'); ?></label>
										</div>								
									</div>										
								</li>	
								<li>
									<h5><?php esc_html_e('New booking notifications sending to defined addresses','car-park-booking-system'); ?></h5>
									<span class="to-legend"><?php esc_html_e('Sending an e-mail message about new booking on the addresses defined on recipient list.','car-park-booking-system'); ?></span>
									<div class="to-clear-fix">
										<div class="to-radio-button">
											<input type="radio" value="1" id="<?php CPBSHelper::getFormName('booking_new_admin_email_notification_1'); ?>" name="<?php CPBSHelper::getFormName('booking_new_admin_email_notification'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['booking_new_admin_email_notification'],1); ?>/>
											<label for="<?php CPBSHelper::getFormName('booking_new_admin_email_notification_1'); ?>"><?php esc_html_e('Enable','car-park-booking-system'); ?></label>
											<input type="radio" value="0" id="<?php CPBSHelper::getFormName('booking_new_admin_email_notification_0'); ?>" name="<?php CPBSHelper::getFormName('booking_new_admin_email_notification'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['booking_new_admin_email_notification'],0); ?>/>
											<label for="<?php CPBSHelper::getFormName('booking_new_admin_email_notification_0'); ?>"><?php esc_html_e('Disable','car-park-booking-system'); ?></label>
										</div>								
									</div>										
								</li>	
								<li>
									<h5><?php esc_html_e('New booking notifications sending to defined addresses in case of successful payment only','car-park-booking-system'); ?></h5>
									<span class="to-legend">
										<?php esc_html_e('Sending an e-mail message about new booking on the addresses defined on recipient list only if the booking has been paid.','car-park-booking-system'); ?><br/>
										<?php esc_html_e('This option works only for a built-in online payment methods like Stripe and PayPal.','car-park-booking-system'); ?><br/>
										<?php esc_html_e('This option works only if the option "New booking notifications sending to defined addresses" is enabled.','car-park-booking-system'); ?>
									</span>
									<div class="to-clear-fix">
										<div class="to-radio-button">
											<input type="radio" value="1" id="<?php CPBSHelper::getFormName('booking_new_admin_email_notification_payment_success_1'); ?>" name="<?php CPBSHelper::getFormName('booking_new_admin_email_notification_payment_success'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['booking_new_admin_email_notification_payment_success'],1); ?>/>
											<label for="<?php CPBSHelper::getFormName('booking_new_admin_email_notification_payment_success_1'); ?>"><?php esc_html_e('Enable','car-park-booking-system'); ?></label>
											<input type="radio" value="0" id="<?php CPBSHelper::getFormName('booking_new_admin_email_notification_payment_success_0'); ?>" name="<?php CPBSHelper::getFormName('booking_new_admin_email_notification_payment_success'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['booking_new_admin_email_notification_payment_success'],0); ?>/>
											<label for="<?php CPBSHelper::getFormName('booking_new_admin_email_notification_payment_success_0'); ?>"><?php esc_html_e('Disable','car-park-booking-system'); ?></label>
										</div>								
									</div>										
								</li>	
								<li>
									<h5><?php esc_html_e('WooCommerce new booking notifications','car-park-booking-system'); ?></h5>
									<span class="to-legend"><?php esc_html_e('Enable/disable sending wooCommerce e-mail message with notification about new booking.','car-park-booking-system'); ?></span>
									<div class="to-radio-button">
										<input type="radio" value="1" id="<?php CPBSHelper::getFormName('booking_new_woocommerce_email_notification_1'); ?>" name="<?php CPBSHelper::getFormName('booking_new_woocommerce_email_notification'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['booking_new_woocommerce_email_notification'],1); ?>/>
										<label for="<?php CPBSHelper::getFormName('booking_new_woocommerce_email_notification_1'); ?>"><?php esc_html_e('Enable','car-park-booking-system'); ?></label>
										<input type="radio" value="0" id="<?php CPBSHelper::getFormName('booking_new_woocommerce_email_notification_0'); ?>" name="<?php CPBSHelper::getFormName('booking_new_woocommerce_email_notification'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['booking_new_woocommerce_email_notification'],0); ?>/>
										<label for="<?php CPBSHelper::getFormName('booking_new_woocommerce_email_notification_0'); ?>"><?php esc_html_e('Disable','car-park-booking-system'); ?></label>
									</div>
								</li>
								<li>
									<h5><?php echo esc_html__('Extra information','car-park-booking-system'); ?></h5>
									<span class="to-legend"><?php echo esc_html__('Extra information added to the message.','car-park-booking-system'); ?></span> 
									<div class="to-clear-fix">
										<textarea rows="1" cols="1" name="<?php CPBSHelper::getFormName('booking_email_notification_extra_information'); ?>" id="<?php CPBSHelper::getFormName('booking_email_notification_extra_information'); ?>"><?php echo ($this->data['meta']['booking_email_notification_extra_information']); ?></textarea>
									</div>						 
								</li>
							</ul>
						</div>
						<div id="meta-box-location-6-2">
							<div class="to-notice-small to-notice-small-error">
								<?php echo sprintf(__('You can find more information about Vonage <a href="%s" target="_blank">here</a>.','car-park-booking-system'),'https://www.vonage.com/'); ?>
							</div>
							<ul class="to-form-field-list">
								<li>
									<h5><?php esc_html_e('Status','car-park-booking-system'); ?></h5>
									<span class="to-legend"><?php esc_html_e('Status.','car-park-booking-system'); ?></span>
									<div class="to-clear-fix">
										<div class="to-radio-button">
											<input type="radio" value="1" id="<?php CPBSHelper::getFormName('nexmo_sms_enable_1'); ?>" name="<?php CPBSHelper::getFormName('nexmo_sms_enable'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['nexmo_sms_enable'],1); ?>/>
											<label for="<?php CPBSHelper::getFormName('nexmo_sms_enable_1'); ?>"><?php esc_html_e('Enable','car-park-booking-system'); ?></label>
											<input type="radio" value="0" id="<?php CPBSHelper::getFormName('nexmo_sms_enable_0'); ?>" name="<?php CPBSHelper::getFormName('nexmo_sms_enable'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['nexmo_sms_enable'],0); ?>/>
											<label for="<?php CPBSHelper::getFormName('nexmo_sms_enable_0'); ?>"><?php esc_html_e('Disable','car-park-booking-system'); ?></label>
										</div>								
									</div>								
								</li>
								<li>
									<h5><?php esc_html_e('API key','car-park-booking-system'); ?></h5>
									<span class="to-legend"><?php esc_html_e('API key.','car-park-booking-system'); ?></span>
									<div class="to-clear-fix">
										<input type="text" name="<?php CPBSHelper::getFormName('nexmo_sms_api_key'); ?>" value="<?php echo esc_attr($this->data['meta']['nexmo_sms_api_key']); ?>"/>
									</div>									
								</li>
								<li>
									<h5><?php esc_html_e('Secret API key','car-park-booking-system'); ?></h5>
									<span class="to-legend"><?php esc_html_e('Secret API key.','car-park-booking-system'); ?></span>
									<div class="to-clear-fix">
										<input type="text" name="<?php CPBSHelper::getFormName('nexmo_sms_api_key_secret'); ?>" value="<?php echo esc_attr($this->data['meta']['nexmo_sms_api_key_secret']); ?>"/>
									</div>									
								</li>
								<li>
									<h5><?php esc_html_e('Sender name','car-park-booking-system'); ?></h5>
									<span class="to-legend"><?php esc_html_e('Sender name.','car-park-booking-system'); ?></span>
									<div class="to-clear-fix">
										<input type="text" name="<?php CPBSHelper::getFormName('nexmo_sms_sender_name'); ?>" value="<?php echo esc_attr($this->data['meta']['nexmo_sms_sender_name']); ?>"/>
									</div>									
								</li>
								<li>
									<h5><?php esc_html_e('Recipient phone number','car-park-booking-system'); ?></h5>
									<span class="to-legend"><?php esc_html_e('Recipient phone number.','car-park-booking-system'); ?></span>
									<div class="to-clear-fix">
										<input type="text" name="<?php CPBSHelper::getFormName('nexmo_sms_recipient_phone_number'); ?>" value="<?php echo esc_attr($this->data['meta']['nexmo_sms_recipient_phone_number']); ?>"/>
									</div>									
								</li>
								<li>
									<h5><?php esc_html_e('Message','car-park-booking-system'); ?></h5>
									<span class="to-legend"><?php esc_html_e('Message.','car-park-booking-system'); ?></span>
									<div class="to-clear-fix">
										<input type="text" name="<?php CPBSHelper::getFormName('nexmo_sms_message'); ?>" value="<?php echo esc_attr($this->data['meta']['nexmo_sms_message']); ?>"/>
									</div>									
								</li>
							</ul>
						</div>
						<div id="meta-box-location-6-3">
							<div class="to-notice-small to-notice-small-error">
								<?php echo sprintf(__('You can find more information about Twilio <a href="%s" target="_blank">here</a>.','car-park-booking-system'),'https://www.twilio.com/'); ?>
							</div>
							<ul class="to-form-field-list">
								<li>
									<h5><?php esc_html_e('Status','car-park-booking-system'); ?></h5>
									<span class="to-legend"><?php esc_html_e('Status.','car-park-booking-system'); ?></span> 
									<div class="to-radio-button">
										<input type="radio" value="1" id="<?php CPBSHelper::getFormName('twilio_sms_enable_1'); ?>" name="<?php CPBSHelper::getFormName('twilio_sms_enable'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['twilio_sms_enable'],1); ?>/>
										<label for="<?php CPBSHelper::getFormName('twilio_sms_enable_1'); ?>"><?php esc_html_e('Enable','car-park-booking-system'); ?></label>
										<input type="radio" value="0" id="<?php CPBSHelper::getFormName('twilio_sms_enable_0'); ?>" name="<?php CPBSHelper::getFormName('twilio_sms_enable'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['twilio_sms_enable'],0); ?>/>
										<label for="<?php CPBSHelper::getFormName('twilio_sms_enable_0'); ?>"><?php esc_html_e('Disable','car-park-booking-system'); ?></label>
									</div>								
								</li>
								<li>
									<h5><?php esc_html_e('API SID','car-park-booking-system'); ?></h5>
									<span class="to-legend"><?php esc_html_e('API SID.','car-park-booking-system'); ?></span>
									<div class="to-clear-fix">
										<input type="text" name="<?php CPBSHelper::getFormName('twilio_sms_api_sid'); ?>" value="<?php echo esc_attr($this->data['meta']['twilio_sms_api_sid']); ?>"/>
									</div>
								</li>
								<li>
									<h5><?php esc_html_e('API token','car-park-booking-system'); ?></h5>
									<span class="to-legend"><?php esc_html_e('API token.','car-park-booking-system'); ?></span>
									<div class="to-clear-fix">
										<input type="text" name="<?php CPBSHelper::getFormName('twilio_sms_api_token'); ?>" value="<?php echo esc_attr($this->data['meta']['twilio_sms_api_token']); ?>"/>
									</div>
								</li>
								<li>
									<h5><?php esc_html_e('Sender phone number','car-park-booking-system'); ?></h5>
									<span class="to-legend"><?php esc_html_e('Sender phone number.','car-park-booking-system'); ?></span>
									<div class="to-clear-fix">
										<input type="text" name="<?php CPBSHelper::getFormName('twilio_sms_sender_phone_number'); ?>" value="<?php echo esc_attr($this->data['meta']['twilio_sms_sender_phone_number']); ?>"/>
									</div>
								</li>
								<li>
									<h5><?php esc_html_e('Recipient phone number','car-park-booking-system'); ?></h5>
									<span class="to-legend"><?php esc_html_e('Recipient phone number.','car-park-booking-system'); ?></span>
									<div class="to-clear-fix">
										<input type="text" name="<?php CPBSHelper::getFormName('twilio_sms_recipient_phone_number'); ?>" value="<?php echo esc_attr($this->data['meta']['twilio_sms_recipient_phone_number']); ?>"/>
									</div>
								</li>
								<li>
									<h5><?php esc_html_e('Message','car-park-booking-system'); ?></h5>
									<span class="to-legend"><?php esc_html_e('Message.','car-park-booking-system'); ?></span>
									<div class="to-clear-fix">
										<input type="text" name="<?php CPBSHelper::getFormName('twilio_sms_message'); ?>" value="<?php echo esc_attr($this->data['meta']['twilio_sms_message']); ?>"/>
									</div>
								</li>
							</ul>
						</div>
						<div id="meta-box-location-6-4">
							<div class="to-notice-small to-notice-small-error">
								<?php echo sprintf(__('You can find more information about Telegram configuration <a href="%s" target="_blank">here</a>.','car-park-booking-system'),'https://core.telegram.org/bots'); ?>
							</div>
							<ul class="to-form-field-list">
								<li>
									<h5><?php esc_html_e('Status','car-park-booking-system'); ?></h5>
									<span class="to-legend">
										<?php esc_html_e('Status.','car-park-booking-system'); ?>
									</span>
									<div class="to-radio-button">
										<input type="radio" value="1" id="<?php CPBSHelper::getFormName('telegram_enable_1'); ?>" name="<?php CPBSHelper::getFormName('telegram_enable'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['telegram_enable'],1); ?>/>
										<label for="<?php CPBSHelper::getFormName('telegram_enable_1'); ?>"><?php esc_html_e('Enable','car-park-booking-system'); ?></label>
										<input type="radio" value="0" id="<?php CPBSHelper::getFormName('telegram_enable_0'); ?>" name="<?php CPBSHelper::getFormName('telegram_enable'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['telegram_enable'],0); ?>/>
										<label for="<?php CPBSHelper::getFormName('telegram_enable_0'); ?>"><?php esc_html_e('Disable','car-park-booking-system'); ?></label>
									</div>								
								</li>
								<li>
									<h5><?php esc_html_e('Token','car-park-booking-system'); ?></h5>
									<span class="to-legend"><?php esc_html_e('Token.','car-park-booking-system'); ?></span>
									<div class="to-clear-fix">
										<input type="text" name="<?php CPBSHelper::getFormName('telegram_token'); ?>" value="<?php echo esc_attr($this->data['meta']['telegram_token']); ?>"/>
									</div>								
								</li>
								<li>
									<h5><?php esc_html_e('Group ID','car-park-booking-system'); ?></h5>
									<span class="to-legend"><?php esc_html_e('Group ID.','car-park-booking-system'); ?></span>
									<div class="to-clear-fix">
										<input type="text" name="<?php CPBSHelper::getFormName('telegram_group_id'); ?>" value="<?php echo esc_attr($this->data['meta']['telegram_group_id']); ?>"/>
									</div>								
								</li>
								<li>
									<h5><?php esc_html_e('Message','car-park-booking-system'); ?></h5>
									<span class="to-legend"><?php esc_html_e('Message.','car-park-booking-system'); ?></span>
									<div class="to-clear-fix">
										<input type="text" name="<?php CPBSHelper::getFormName('telegram_message'); ?>" value="<?php echo esc_attr($this->data['meta']['telegram_message']); ?>"/>
									</div>								
								</li>
							</ul>
						</div>
					</div>
				</div>	
				<div id="meta-box-location-7">
					<ul class="to-form-field-list">
					   <li>
							<h5><?php esc_html_e('Google Calendar','car-park-booking-system'); ?></h5>
							<span class="to-legend"><?php echo esc_html__('Enable or disable integration with Google Calendar.','car-park-booking-system'); ?></span> 
							<div class="to-radio-button">
								<input type="radio" value="1" id="<?php CPBSHelper::getFormName('google_calendar_enable_1'); ?>" name="<?php CPBSHelper::getFormName('google_calendar_enable'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['google_calendar_enable'],1); ?>/>
								<label for="<?php CPBSHelper::getFormName('google_calendar_enable_1'); ?>"><?php esc_html_e('Enable','car-park-booking-system'); ?></label>
								<input type="radio" value="0" id="<?php CPBSHelper::getFormName('google_calendar_enable_0'); ?>" name="<?php CPBSHelper::getFormName('google_calendar_enable'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['google_calendar_enable'],0); ?>/>
								<label for="<?php CPBSHelper::getFormName('google_calendar_enable_0'); ?>"><?php esc_html_e('Disable','car-park-booking-system'); ?></label>
							</div>							
						</li>	   
						<li>
							<h5><?php esc_html_e('ID','car-park-booking-system'); ?></h5>
							<span class="to-legend"><?php echo esc_html__('Google Calendar ID.','car-park-booking-system'); ?></span> 
							<div class="to-clear-fix">
								<input type="text" name="<?php CPBSHelper::getFormName('google_calendar_id'); ?>" value="<?php echo esc_attr($this->data['meta']['google_calendar_id']); ?>"/>								 
							</div>						 
						</li>
						<li>
							<h5><?php esc_html_e('Settings','car-park-booking-system'); ?></h5>
							<span class="to-legend"><?php echo esc_html__('Copy/paste the contents of downloaded *.json file.','car-park-booking-system'); ?></span> 
							<div class="to-clear-fix">
								<textarea rows="1" cols="1" name="<?php CPBSHelper::getFormName('google_calendar_settings'); ?>" id="<?php CPBSHelper::getFormName('google_calendar_settings'); ?>"><?php echo esc_html($this->data['meta']['google_calendar_settings']); ?></textarea>
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
				var helper=new CPBSHelper();
				helper.getMessageFromConsole();

				/***/

				var element=$(\'.to\').themeOptionElement({init:true});
				
				/***/
				
				var helper=new CPBSHelper();

				var timeFormat=\''.CPBSOption::getOption('time_format').'\';
				var dateFormat=\''.CPBSJQueryUIDatePicker::convertDateFormat(CPBSOption::getOption('date_format')).'\';

				helper.createCustomDateTimePicker(dateFormat,timeFormat);

				/***/
				
				$(\'#to-table-booking-period-date\').table();

				$(\'#to-table-business-hour-date\').table();
				$(\'#to-table-exclude-date\').table();
				
				$(\'#to-table-place-type-quantity-period\').table();
				
				/***/

				element.bindBrowseMedia(\'.to-button-browse\');

				/***/
				
				var helper=new CPBSHelper();
				helper.googleMapAutocompleteCreate($(\'#cpbs_location_search\'),function(place)
				{
					if(confirm(\''.esc_html__('Do you want to fill all address details based on this location?','car-park-booking-system').'\'))
					{
						var key=
						[
							[\'address_street\',\'route\'],
							[\'address_street_number\',\'street_number\'],
							[\'address_postcode\',\'postal_code\'],
							[\'address_city\',\'locality\'],
							[\'address_state\',\'administrative_area_level_1\'],
							[\'address_country\',\'country\']
						];

						for(var i in key)
						{
							for(var j in place.address_components)
							{
								var field=$(\'[name="cpbs_\'+key[i][0]+\'"]\');

								field.val(\'\');

								if(key[i][1].length)
								{
									if($.inArray(key[i][1],place.address_components[j].types)>-1)
									{
										if(key[i][1]==\'country\')
										{
											field.val(place.address_components[j].short_name);	
											field.dropkick(\'refresh\');
										}
										else field.val(place.address_components[j].long_name);	

										break;
									}
								}							
							}
						}

						$(\'[name="cpbs_coordinate_latitude"]\').val(place.geometry.location.lat);
						$(\'[name="cpbs_coordinate_longitude"]\').val(place.geometry.location.lng);
					}
				});
			});	
		');