<?php 
		echo $this->data['nonce']; 
		global $post;
?>	
		<div class="to">
			<div class="ui-tabs">
				<ul>
					<li><a href="#meta-box-booking-form-1"><?php esc_html_e('General','car-park-booking-system'); ?></a></li>
					<li><a href="#meta-box-booking-form-2"><?php esc_html_e('Form elements','car-park-booking-system'); ?></a></li>
					<li><a href="#meta-box-booking-form-3"><?php esc_html_e('Styles','car-park-booking-system'); ?></a></li>
					<li><a href="#meta-box-booking-form-4"><?php esc_html_e('Google Maps','car-park-booking-system'); ?></a></li>
				</ul>
				<div id="meta-box-booking-form-1">
					<div class="ui-tabs">
						<ul>
							<li><a href="#meta-box-booking-form-1-1"><?php esc_html_e('Main','car-park-booking-system'); ?></a></li>
							<li><a href="#meta-box-booking-form-1-2"><?php esc_html_e('Prices','car-park-booking-system'); ?></a></li>
							<li><a href="#meta-box-booking-form-1-3"><?php esc_html_e('Look & feel','car-park-booking-system'); ?></a></li>
						</ul>
						<div id="meta-box-booking-form-1-1">
							<ul class="to-form-field-list">
								<?php echo CPBSHelper::createPostIdField(__('Booking form ID','car-park-booking-system')); ?>
								<li>
									<h5><?php esc_html_e('Shortcode','car-park-booking-system'); ?></h5>
									<span class="to-legend"><?php esc_html_e('Copy and paste the shortcode on a page.','car-park-booking-system'); ?></span>
									<div class="to-field-disabled">
<?php
										$shortcode='['.PLUGIN_CPBS_CONTEXT.'_booking_form booking_form_id="'.$post->ID.'"]';
										echo esc_html($shortcode);
?>
										<a href="#" class="to-copy-to-clipboard to-float-right" data-clipboard-text="<?php echo esc_attr($shortcode); ?>" data-label-on-success="<?php esc_attr_e('Copied!','car-park-booking-system') ?>"><?php esc_html_e('Copy','car-park-booking-system'); ?></a>
									</div>
								</li>  
								<li>
									<h5><?php esc_html_e('Locations','car-park-booking-system'); ?></h5>
									<span class="to-legend">
										<?php esc_html_e('Select at least one location.','car-park-booking-system'); ?>
									</span>
									<div class="to-checkbox-button">
<?php
		foreach($this->data['dictionary']['location'] as $index=>$value)
		{
?>
											<input type="checkbox" value="<?php echo esc_attr($index); ?>" id="<?php CPBSHelper::getFormName('location_id_'.$index); ?>" name="<?php CPBSHelper::getFormName('location_id[]'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['location_id'],$index); ?>/>
											<label for="<?php CPBSHelper::getFormName('location_id_'.$index); ?>"><?php echo esc_html(get_the_title($index)); ?></label>
<?php		
		}
?>								
									</div>
								</li>  
								<li>
									<h5><?php esc_html_e('Default booking status','car-park-booking-system'); ?></h5>
									<span class="to-legend"><?php esc_html_e('Default booking status of new order.','car-park-booking-system'); ?></span>
									<div class="to-radio-button">
<?php
		foreach($this->data['dictionary']['booking_status'] as $index=>$value)
		{
?>
											<input type="radio" value="<?php echo esc_attr($index); ?>" id="<?php CPBSHelper::getFormName('booking_status_id_default_'.$index); ?>" name="<?php CPBSHelper::getFormName('booking_status_id_default'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['booking_status_id_default'],$index); ?>/>
											<label for="<?php CPBSHelper::getFormName('booking_status_id_default_'.$index); ?>"><?php echo esc_html($value[0]); ?></label>
<?php		
		}
?>								
									</div>
								</li>	
								<li>
									<h5><?php esc_html_e('Geolocation','car-park-booking-system'); ?></h5>
									<span class="to-legend"><?php esc_html_e('Enable or disable geolocation.','car-park-booking-system'); ?></span>
									<div class="to-checkbox-button">
										<input type="checkbox" value="1" id="<?php CPBSHelper::getFormName('geolocation_enable_1'); ?>" name="<?php CPBSHelper::getFormName('geolocation_enable[]'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['geolocation_enable'],1); ?>/>
										<label for="<?php CPBSHelper::getFormName('geolocation_enable_1'); ?>"><?php esc_html_e('Client side','car-park-booking-system'); ?></label>
										<input type="checkbox" value="2" id="<?php CPBSHelper::getFormName('geolocation_enable_2'); ?>" name="<?php CPBSHelper::getFormName('geolocation_enable[]'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['geolocation_enable'],2); ?>/>
										<label for="<?php CPBSHelper::getFormName('geolocation_enable_2'); ?>"><?php esc_html_e('Server side','car-park-booking-system'); ?></label>
									</div>
								</li>						   
								<li>
									<h5><?php esc_html_e('WooCommerce','car-park-booking-system'); ?></h5>
									<span class="to-legend"><?php esc_html_e('Enable or disable WooCommerce support for this booking form.','car-park-booking-system'); ?></span>
									<div class="to-radio-button">
										<input type="radio" value="1" id="<?php CPBSHelper::getFormName('woocommerce_enable_1'); ?>" name="<?php CPBSHelper::getFormName('woocommerce_enable'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['woocommerce_enable'],1); ?>/>
										<label for="<?php CPBSHelper::getFormName('woocommerce_enable_1'); ?>"><?php esc_html_e('Enable','car-park-booking-system'); ?></label>
										<input type="radio" value="0" id="<?php CPBSHelper::getFormName('woocommerce_enable_0'); ?>" name="<?php CPBSHelper::getFormName('woocommerce_enable'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['woocommerce_enable'],0); ?>/>
										<label for="<?php CPBSHelper::getFormName('woocommerce_enable_0'); ?>"><?php esc_html_e('Disable','car-park-booking-system'); ?></label>
									</div>
								</li> 
								<li>
									<h5><?php esc_html_e('WooCommerce account','car-park-booking-system'); ?></h5>
									<span class="to-legend">
										<?php esc_html_e('Enable or disable possibility to create and login via wooCommerce account.','car-park-booking-system'); ?><br/>
										<?php esc_html_e('"Disable" means that login and register form will not be displayed.','car-park-booking-system'); ?><br/>
										<?php esc_html_e('"Enable as option" means that both forms will be available, but logging and/or creating an account depends on user preferences.','car-park-booking-system'); ?><br/>
										<?php esc_html_e('"Enable as mandatory" means that user have to be registered and logged before he sends a booking.','car-park-booking-system'); ?>
									</span>
									<div class="to-radio-button">
										<input type="radio" value="1" id="<?php CPBSHelper::getFormName('woocommerce_account_enable_type_1'); ?>" name="<?php CPBSHelper::getFormName('woocommerce_account_enable_type'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['woocommerce_account_enable_type'],1); ?>/>
										<label for="<?php CPBSHelper::getFormName('woocommerce_account_enable_type_1'); ?>"><?php esc_html_e('Enable as option','car-park-booking-system'); ?></label>
										<input type="radio" value="2" id="<?php CPBSHelper::getFormName('woocommerce_account_enable_type_2'); ?>" name="<?php CPBSHelper::getFormName('woocommerce_account_enable_type'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['woocommerce_account_enable_type'],2); ?>/>
										<label for="<?php CPBSHelper::getFormName('woocommerce_account_enable_type_2'); ?>"><?php esc_html_e('Enable as mandatory','car-park-booking-system'); ?></label>
										<input type="radio" value="0" id="<?php CPBSHelper::getFormName('woocommerce_account_enable_type_0'); ?>" name="<?php CPBSHelper::getFormName('woocommerce_account_enable_type'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['woocommerce_account_enable_type'],0); ?>/>
										<label for="<?php CPBSHelper::getFormName('woocommerce_account_enable_type_0'); ?>"><?php esc_html_e('Disable','car-park-booking-system'); ?></label>
									</div>
								</li>
								<li>
									<h5><?php esc_html_e('Coupons','car-park-booking-system'); ?></h5>
									<span class="to-legend"><?php esc_html_e('Enable or disable coupons for this booking form.','car-park-booking-system'); ?></span>
									<div class="to-radio-button">
										<input type="radio" value="1" id="<?php CPBSHelper::getFormName('coupon_enable_1'); ?>" name="<?php CPBSHelper::getFormName('coupon_enable'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['coupon_enable'],1); ?>/>
										<label for="<?php CPBSHelper::getFormName('coupon_enable_1'); ?>"><?php esc_html_e('Enable','car-park-booking-system'); ?></label>
										<input type="radio" value="0" id="<?php CPBSHelper::getFormName('coupon_enable_0'); ?>" name="<?php CPBSHelper::getFormName('coupon_enable'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['coupon_enable'],0); ?>/>
										<label for="<?php CPBSHelper::getFormName('coupon_enable_0'); ?>"><?php esc_html_e('Disable','car-park-booking-system'); ?></label>
									</div>
								</li>
								<li>
									<h5><?php esc_html_e('Spaces sorting','car-park-booking-system'); ?></h5>
									<span class="to-legend"><?php esc_html_e('Select sorting options of spaces in booking form.','car-park-booking-system'); ?></span>
									<div class="to-clear-fix">
										<select name="<?php CPBSHelper::getFormName('place_sorting_type'); ?>">
<?php
		foreach($this->data['dictionary']['place_sorting_type'] as $index=>$value)
			echo '<option value="'.esc_attr($index).'" '.(CPBSHelper::selectedIf($this->data['meta']['place_sorting_type'],$index,false)).'>'.esc_html($value[0]).'</option>';
?>
										</select>
									</div>
								</li>  	
								<li>
									<h5><?php esc_html_e('Maximum number of dates','car-park-booking-system'); ?></h5>
									<span class="to-legend">
										<?php esc_html_e('Maximum number of the same entry/exit dates modified by the given interval.','car-park-booking-system'); ?>
									</span>
									<div>
										<span class="to-legend-field"><?php esc_html_e('Number of dates (leave empty in case of unlimited):','car-park-booking-system'); ?></span>
										<input type="text" maxlength="2" name="<?php CPBSHelper::getFormName('date_number_value'); ?>" value="<?php echo esc_attr($this->data['meta']['date_number_value']); ?>"/>
									</div>	
									<div>
										<span class="to-legend-field"><?php esc_html_e('Interval (in minutes):','car-park-booking-system'); ?></span>
										<input type="text" maxlength="4" name="<?php CPBSHelper::getFormName('date_number_interval'); ?>" value="<?php echo esc_attr($this->data['meta']['date_number_interval']); ?>"/>
									</div>										
								</li>	
								<li>
									<h5><?php esc_html_e('Rounding to the full day','car-park-booking-system'); ?></h5>
									<span class="to-legend">
										<?php esc_html_e('Define number of hours, equal or greater these from the booking, for which the rental period should be rounded to the full day.','car-park-booking-system'); ?><br/>
										<?php esc_html_e('This option works only for a "Day + hour II" billing type. Allowed are integer values from 0 to 23.','car-park-booking-system'); ?>
									</span>
									<div>
										<input type="text" maxlength="2" name="<?php CPBSHelper::getFormName('full_day_rounding_hour_number'); ?>" value="<?php echo esc_attr($this->data['meta']['full_day_rounding_hour_number']); ?>"/>
									</div>	
								</li>									
							</ul>
						</div>
						<div id="meta-box-booking-form-1-2">
							<ul class="to-form-field-list">
								<li>
									<h5><?php esc_html_e('Currencies','car-park-booking-system'); ?></h5>
									<span class="to-legend">
										<?php esc_html_e('Select available currencies.','car-park-booking-system'); ?><br/>
										<?php esc_html_e('You can set exchange rates for each selected currency in plugin options.','car-park-booking-system'); ?><br/>
										<?php esc_html_e('You can run booking form with particular currency by adding parameter "currency=CODE" to the query string of page on which booking form is located.','car-park-booking-system'); ?>
									</span>						
									<div class="to-clear-fix">
										<select multiple="multiple" class="to-dropkick-disable" name="<?php CPBSHelper::getFormName('currency[]'); ?>">
											<option value="-1" <?php CPBSHelper::selectedIf($this->data['meta']['currency'],-1); ?>><?php esc_html_e('- None -','car-park-booking-system'); ?></option>
<?php
		foreach($this->data['dictionary']['currency'] as $index=>$value)
			echo '<option value="'.esc_attr($index).'" '.(CPBSHelper::selectedIf($this->data['meta']['currency'],$index,false)).'>'.esc_html($value['name'].' ('.$index.')').'</option>';
?>
										</select>												
									</div>
								</li>
								<li>
									<h5><?php esc_html_e('Minimum order value','car-park-booking-system'); ?></h5>
									<span class="to-legend">
										<?php esc_html_e('Specify minimum gross value of the order.','car-park-booking-system'); ?>
									</span>
									<div><input type="text" maxlength="12" name="<?php CPBSHelper::getFormName('order_value_minimum'); ?>" value="<?php echo esc_attr($this->data['meta']['order_value_minimum']); ?>"/></div>								  
								</li>
								<li>
									<h5><?php esc_html_e('Hide fees','car-park-booking-system'); ?></h5>
									<span class="to-legend"><?php esc_html_e('Hide all additional fees in booking summary and include them to the price of selected space.','car-park-booking-system'); ?>
									</span>
									<div class="to-radio-button">
										<input type="radio" value="1" id="<?php CPBSHelper::getFormName('booking_summary_hide_fee_1'); ?>" name="<?php CPBSHelper::getFormName('booking_summary_hide_fee'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['booking_summary_hide_fee'],1); ?>/>
										<label for="<?php CPBSHelper::getFormName('booking_summary_hide_fee_1'); ?>"><?php esc_html_e('Enable','car-park-booking-system'); ?></label>
										<input type="radio" value="0" id="<?php CPBSHelper::getFormName('booking_summary_hide_fee_0'); ?>" name="<?php CPBSHelper::getFormName('booking_summary_hide_fee'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['booking_summary_hide_fee'],0); ?>/>
										<label for="<?php CPBSHelper::getFormName('booking_summary_hide_fee_0'); ?>"><?php esc_html_e('Disable','car-park-booking-system'); ?></label>
									</div>
								</li>  
								<li>
									<h5><?php esc_html_e('Display net prices','car-park-booking-system'); ?></h5>
									<span class="to-legend"><?php esc_html_e('Display net prices and tax separately in booking summary.','car-park-booking-system'); ?>
									</span>
									<div class="to-radio-button">
										<input type="radio" value="1" id="<?php CPBSHelper::getFormName('booking_summary_display_net_price_1'); ?>" name="<?php CPBSHelper::getFormName('booking_summary_display_net_price'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['booking_summary_display_net_price'],1); ?>/>
										<label for="<?php CPBSHelper::getFormName('booking_summary_display_net_price_1'); ?>"><?php esc_html_e('Enable','car-park-booking-system'); ?></label>
										<input type="radio" value="0" id="<?php CPBSHelper::getFormName('booking_summary_display_net_price_0'); ?>" name="<?php CPBSHelper::getFormName('booking_summary_display_net_price'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['booking_summary_display_net_price'],0); ?>/>
										<label for="<?php CPBSHelper::getFormName('booking_summary_display_net_price_0'); ?>"><?php esc_html_e('Disable','car-park-booking-system'); ?></label>
									</div>
								</li>  
							</ul>
						</div>
						<div id="meta-box-booking-form-1-3">
							<div class="ui-tabs">
								<ul>
									<li><a href="#meta-box-booking-form-1-3-1"><?php esc_html_e('Main','car-park-booking-system'); ?></a></li>
									<li><a href="#meta-box-booking-form-1-3-2"><?php esc_html_e('Step #1','car-park-booking-system'); ?></a></li>
									<li><a href="#meta-box-booking-form-1-3-3"><?php esc_html_e('Step #2','car-park-booking-system'); ?></a></li>
									<li><a href="#meta-box-booking-form-1-3-4"><?php esc_html_e('Step #3','car-park-booking-system'); ?></a></li>
									<li><a href="#meta-box-booking-form-1-3-5"><?php esc_html_e('Step #4','car-park-booking-system'); ?></a></li>
									<li><a href="#meta-box-booking-form-1-3-6"><?php esc_html_e('Step #5','car-park-booking-system'); ?></a></li>
								</ul>
								<div id="meta-box-booking-form-1-3-1">
									<ul class="to-form-field-list">	
										<li>
											<h5><?php esc_html_e('Form preloader','car-park-booking-system'); ?></h5>
											<span class="to-legend"><?php esc_html_e('Enable or disable form preloader.','car-park-booking-system'); ?></span>
											<div class="to-radio-button">
												<input type="radio" value="1" id="<?php CPBSHelper::getFormName('form_preloader_enable_1'); ?>" name="<?php CPBSHelper::getFormName('form_preloader_enable'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['form_preloader_enable'],1); ?>/>
												<label for="<?php CPBSHelper::getFormName('form_preloader_enable_1'); ?>"><?php esc_html_e('Enable','car-park-booking-system'); ?></label>
												<input type="radio" value="0" id="<?php CPBSHelper::getFormName('form_preloader_enable_0'); ?>" name="<?php CPBSHelper::getFormName('form_preloader_enable'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['form_preloader_enable'],0); ?>/>
												<label for="<?php CPBSHelper::getFormName('form_preloader_enable_0'); ?>"><?php esc_html_e('Disable','car-park-booking-system'); ?></label>
											</div>
										</li>
										<li>
											<h5><?php esc_html_e('Top navigation','car-park-booking-system'); ?></h5>
											<span class="to-legend">
												<?php echo esc_html__('Enable or disable top navigation.','car-park-booking-system'); ?>
											</span>
											<div class="to-clear-fix">
												<div class="to-radio-button">
													<input type="radio" value="1" id="<?php CPBSHelper::getFormName('navigation_top_enable_1'); ?>" name="<?php CPBSHelper::getFormName('navigation_top_enable'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['navigation_top_enable'],1); ?>/>
													<label for="<?php CPBSHelper::getFormName('navigation_top_enable_1'); ?>"><?php esc_html_e('Enable','car-park-booking-system'); ?></label>
													<input type="radio" value="0" id="<?php CPBSHelper::getFormName('navigation_top_enable_0'); ?>" name="<?php CPBSHelper::getFormName('navigation_top_enable'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['navigation_top_enable'],0); ?>/>
													<label for="<?php CPBSHelper::getFormName('navigation_top_enable_0'); ?>"><?php esc_html_e('Disable','car-park-booking-system'); ?></label>
												</div>								
											</div>
										</li>	
										<li>
											<h5><?php esc_html_e('Location details window opening','car-park-booking-system'); ?></h5>
											<span class="to-legend"><?php esc_html_e('Define after which action, the window with location details should be opened.','car-park-booking-system'); ?></span>
											<div class="to-checkbox-button">
												<input type="checkbox" value="1" id="<?php CPBSHelper::getFormName('location_detail_window_open_action_1'); ?>" name="<?php CPBSHelper::getFormName('location_detail_window_open_action[]'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['location_detail_window_open_action'],1); ?>/>
												<label for="<?php CPBSHelper::getFormName('location_detail_window_open_action_1'); ?>"><?php esc_html_e('After clicking on the map marker','car-park-booking-system'); ?></label>
												<input type="checkbox" value="2" id="<?php CPBSHelper::getFormName('location_detail_window_open_action_2'); ?>" name="<?php CPBSHelper::getFormName('location_detail_window_open_action[]'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['location_detail_window_open_action'],2); ?>/>
												<label for="<?php CPBSHelper::getFormName('location_detail_window_open_action_2'); ?>"><?php esc_html_e('After selecting from the location list','car-park-booking-system'); ?></label>												
												<input type="checkbox" value="3" id="<?php CPBSHelper::getFormName('location_detail_window_open_action_3'); ?>" name="<?php CPBSHelper::getFormName('location_detail_window_open_action[]'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['location_detail_window_open_action'],3); ?>/>
												<label for="<?php CPBSHelper::getFormName('location_detail_window_open_action_3'); ?>"><?php esc_html_e('After clicking on the "More details" link','car-park-booking-system'); ?></label>																
											</div>
										</li> 	
									</ul>
								</div>
								<div id="meta-box-booking-form-1-3-2">
									<ul class="to-form-field-list">	
										<li>
											<h5><?php esc_html_e('Timepicker','car-park-booking-system'); ?></h5>
											<span class="to-legend">
												<?php esc_html_e('Timepicker settings.','car-park-booking-system'); ?><br/>
											</span>
											<div>
												<span class="to-legend-field">
													<?php esc_html_e('Interval - the amount of time, in minutes, between each item in the dropdown.','car-park-booking-system'); ?>
													<?php esc_html_e('Allowed are integer values from 1 to 9999.','car-park-booking-system'); ?>
												</span>
												<div>
													<input type="text" maxlength="4" name="<?php CPBSHelper::getFormName('timepicker_step'); ?>" value="<?php echo esc_attr($this->data['meta']['timepicker_step']); ?>"/>
												</div>
											</div>								  
											<div>
												<span class="to-legend-field">
													<?php esc_html_e('Start time for a current date:','car-park-booking-system'); ?>
												</span>		
												<div class="to-radio-button">
													<input type="radio" value="1" id="<?php CPBSHelper::getFormName('timepicker_today_start_time_type_1'); ?>" name="<?php CPBSHelper::getFormName('timepicker_today_start_time_type'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['timepicker_today_start_time_type'],1); ?>/>
													<label for="<?php CPBSHelper::getFormName('timepicker_today_start_time_type_1'); ?>"><?php esc_html_e('Timepicker starts based on current time','car-park-booking-system'); ?></label>
													<input type="radio" value="2" id="<?php CPBSHelper::getFormName('timepicker_today_start_time_type_2'); ?>" name="<?php CPBSHelper::getFormName('timepicker_today_start_time_type'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['timepicker_today_start_time_type'],2); ?>/>
													<label for="<?php CPBSHelper::getFormName('timepicker_today_start_time_type_2'); ?>"><?php esc_html_e('Timepicker starts based on interval','car-park-booking-system'); ?></label>
												</div>		
											</div>
										</li>
										<li>
											<h5><?php esc_html_e('Entry/exit time field','car-park-booking-system'); ?></h5>
											<span class="to-legend">
												<?php esc_html_e('Enable or disable entry/exit time field in the booking form.','car-park-booking-system'); ?>
											</span>
											<div class="to-radio-button">
												<input type="radio" value="1" id="<?php CPBSHelper::getFormName('time_field_enable_1'); ?>" name="<?php CPBSHelper::getFormName('time_field_enable'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['time_field_enable'],1); ?>/>
												<label for="<?php CPBSHelper::getFormName('time_field_enable_1'); ?>"><?php esc_html_e('Enable','car-park-booking-system'); ?></label>
												<input type="radio" value="0" id="<?php CPBSHelper::getFormName('time_field_enable_0'); ?>" name="<?php CPBSHelper::getFormName('time_field_enable'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['time_field_enable'],0); ?>/>
												<label for="<?php CPBSHelper::getFormName('time_field_enable_0'); ?>"><?php esc_html_e('Disable','car-park-booking-system'); ?></label>
											</div>
										</li> 
										<li>
											<h5><?php esc_html_e('Show location drop down list','car-park-booking-system'); ?></h5>
											<span class="to-legend"><?php esc_html_e('Show or hide pickup and return location drop down list if only one is available.','car-park-booking-system'); ?></span>
											<div class="to-radio-button">
												<input type="radio" value="1" id="<?php CPBSHelper::getFormName('location_single_display_enable_1'); ?>" name="<?php CPBSHelper::getFormName('location_single_display_enable'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['location_single_display_enable'],1); ?>/>
												<label for="<?php CPBSHelper::getFormName('location_single_display_enable_1'); ?>"><?php esc_html_e('Enable','car-park-booking-system'); ?></label>
												<input type="radio" value="0" id="<?php CPBSHelper::getFormName('location_single_display_enable_0'); ?>" name="<?php CPBSHelper::getFormName('location_single_display_enable'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['location_single_display_enable'],0); ?>/>
												<label for="<?php CPBSHelper::getFormName('location_single_display_enable_0'); ?>"><?php esc_html_e('Disable','car-park-booking-system'); ?></label>
											</div>
										</li> 	
									</ul>
								</div>
								<div id="meta-box-booking-form-1-3-3">
									<ul class="to-form-field-list">	
										<li>
											<h5><?php esc_html_e('Scroll after selecting a space','car-park-booking-system'); ?></h5>
											<span class="to-legend"><?php esc_html_e('Scroll user to booking add-ons section after selecting a space.','car-park-booking-system'); ?></span>
											<div class="to-radio-button">
												<input type="radio" value="1" id="<?php CPBSHelper::getFormName('scroll_to_booking_extra_after_select_place_enable_1'); ?>" name="<?php CPBSHelper::getFormName('scroll_to_booking_extra_after_select_place_enable'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['scroll_to_booking_extra_after_select_place_enable'],1); ?>/>
												<label for="<?php CPBSHelper::getFormName('scroll_to_booking_extra_after_select_place_enable_1'); ?>"><?php esc_html_e('Enable','car-park-booking-system'); ?></label>
												<input type="radio" value="0" id="<?php CPBSHelper::getFormName('scroll_to_booking_extra_after_select_place_enable_0'); ?>" name="<?php CPBSHelper::getFormName('scroll_to_booking_extra_after_select_place_enable'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['scroll_to_booking_extra_after_select_place_enable'],0); ?>/>
												<label for="<?php CPBSHelper::getFormName('scroll_to_booking_extra_after_select_place_enable_0'); ?>"><?php esc_html_e('Disable','car-park-booking-system'); ?></label>
											</div>
										</li> 		
										<li>
											<h5><?php esc_html_e('Redirect after selecting a space','car-park-booking-system'); ?></h5>
											<span class="to-legend"><?php esc_html_e('Redirect user to the next step after selecting a space.','car-park-booking-system'); ?></span>
											<div class="to-radio-button">
												<input type="radio" value="1" id="<?php CPBSHelper::getFormName('redirect_to_next_step_after_select_place_enable_1'); ?>" name="<?php CPBSHelper::getFormName('redirect_to_next_step_after_select_place_enable'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['redirect_to_next_step_after_select_place_enable'],1); ?>/>
												<label for="<?php CPBSHelper::getFormName('redirect_to_next_step_after_select_place_enable_1'); ?>"><?php esc_html_e('Enable','car-park-booking-system'); ?></label>
												<input type="radio" value="0" id="<?php CPBSHelper::getFormName('redirect_to_next_step_after_select_place_enable_0'); ?>" name="<?php CPBSHelper::getFormName('redirect_to_next_step_after_select_place_enable'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['redirect_to_next_step_after_select_place_enable'],0); ?>/>
												<label for="<?php CPBSHelper::getFormName('redirect_to_next_step_after_select_place_enable_0'); ?>"><?php esc_html_e('Disable','car-park-booking-system'); ?></label>
											</div>
										</li> 
										<li>
											<h5><?php esc_html_e('Show "Customer details" button','car-park-booking-system'); ?></h5>
											<span class="to-legend"><?php esc_html_e('Show "Customer details" button only if the car park space is selected.','car-park-booking-system'); ?></span>
											<div class="to-radio-button">
												<input type="radio" value="1" id="<?php CPBSHelper::getFormName('second_step_next_button_enable_1'); ?>" name="<?php CPBSHelper::getFormName('second_step_next_button_enable'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['second_step_next_button_enable'],1); ?>/>
												<label for="<?php CPBSHelper::getFormName('second_step_next_button_enable_1'); ?>"><?php esc_html_e('Enable','car-park-booking-system'); ?></label>
												<input type="radio" value="0" id="<?php CPBSHelper::getFormName('second_step_next_button_enable_0'); ?>" name="<?php CPBSHelper::getFormName('second_step_next_button_enable'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['second_step_next_button_enable'],0); ?>/>
												<label for="<?php CPBSHelper::getFormName('second_step_next_button_enable_0'); ?>"><?php esc_html_e('Disable','car-park-booking-system'); ?></label>
											</div>
										</li> 	
										<li>
											<h5><?php esc_html_e('Show parking space type dimension','car-park-booking-system'); ?></h5>
											<span class="to-legend"><?php esc_html_e('Show parking space dimension on the car park space types list.','car-park-booking-system'); ?></span>
											<div class="to-radio-button">
												<input type="radio" value="1" id="<?php CPBSHelper::getFormName('car_park_space_type_list_space_dimension_enable_1'); ?>" name="<?php CPBSHelper::getFormName('car_park_space_type_list_space_dimension_enable'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['car_park_space_type_list_space_dimension_enable'],1); ?>/>
												<label for="<?php CPBSHelper::getFormName('car_park_space_type_list_space_dimension_enable_1'); ?>"><?php esc_html_e('Enable','car-park-booking-system'); ?></label>
												<input type="radio" value="0" id="<?php CPBSHelper::getFormName('car_park_space_type_list_space_dimension_enable_0'); ?>" name="<?php CPBSHelper::getFormName('car_park_space_type_list_space_dimension_enable'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['car_park_space_type_list_space_dimension_enable'],0); ?>/>
												<label for="<?php CPBSHelper::getFormName('car_park_space_type_list_space_dimension_enable_0'); ?>"><?php esc_html_e('Disable','car-park-booking-system'); ?></label>
											</div>
										</li> 											
										<li>
											<h5><?php esc_html_e('Show parking spaces number available','car-park-booking-system'); ?></h5>
											<span class="to-legend"><?php esc_html_e('Show parking spaces number available on the car park space types list.','car-park-booking-system'); ?></span>
											<div class="to-radio-button">
												<input type="radio" value="1" id="<?php CPBSHelper::getFormName('car_park_space_type_list_space_number_available_enable_1'); ?>" name="<?php CPBSHelper::getFormName('car_park_space_type_list_space_number_available_enable'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['car_park_space_type_list_space_number_available_enable'],1); ?>/>
												<label for="<?php CPBSHelper::getFormName('car_park_space_type_list_space_number_available_enable_1'); ?>"><?php esc_html_e('Enable','car-park-booking-system'); ?></label>
												<input type="radio" value="0" id="<?php CPBSHelper::getFormName('car_park_space_type_list_space_number_available_enable_0'); ?>" name="<?php CPBSHelper::getFormName('car_park_space_type_list_space_number_available_enable'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['car_park_space_type_list_space_number_available_enable'],0); ?>/>
												<label for="<?php CPBSHelper::getFormName('car_park_space_type_list_space_number_available_enable_0'); ?>"><?php esc_html_e('Disable','car-park-booking-system'); ?></label>
											</div>
										</li> 										
									</ul>
								</div>								
								<div id="meta-box-booking-form-1-3-4">
									<ul class="to-form-field-list">	
										<li>
											<h5><?php esc_html_e('Sticky summary sidebar','car-park-booking-system'); ?></h5>
											<span class="to-legend"><?php esc_html_e('Enable or disable sticky option for summary sidebar.','car-park-booking-system'); ?></span>
											<div class="to-radio-button">
												<input type="radio" value="1" id="<?php CPBSHelper::getFormName('summary_sidebar_sticky_enable_1'); ?>" name="<?php CPBSHelper::getFormName('summary_sidebar_sticky_enable'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['summary_sidebar_sticky_enable'],1); ?>/>
												<label for="<?php CPBSHelper::getFormName('summary_sidebar_sticky_enable_1'); ?>"><?php esc_html_e('Enable','car-park-booking-system'); ?></label>
												<input type="radio" value="0" id="<?php CPBSHelper::getFormName('summary_sidebar_sticky_enable_0'); ?>" name="<?php CPBSHelper::getFormName('summary_sidebar_sticky_enable'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['summary_sidebar_sticky_enable'],0); ?>/>
												<label for="<?php CPBSHelper::getFormName('summary_sidebar_sticky_enable_0'); ?>"><?php esc_html_e('Disable','car-park-booking-system'); ?></label>
											</div>
										</li> 
										<li>
											<h5><?php esc_html_e('Billing details','car-park-booking-system'); ?></h5>
											<span class="to-legend"><?php esc_html_e('Select default state of billing details section.','car-park-booking-system'); ?></span>
											<div class="to-radio-button">
												<input type="radio" value="1" id="<?php CPBSHelper::getFormName('billing_detail_state_1'); ?>" name="<?php CPBSHelper::getFormName('billing_detail_state'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['billing_detail_state'],1); ?>/>
												<label for="<?php CPBSHelper::getFormName('billing_detail_state_1'); ?>"><?php esc_html_e('Unchecked','car-park-booking-system'); ?></label>
												<input type="radio" value="2" id="<?php CPBSHelper::getFormName('billing_detail_state_2'); ?>" name="<?php CPBSHelper::getFormName('billing_detail_state'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['billing_detail_state'],2); ?>/>
												<label for="<?php CPBSHelper::getFormName('billing_detail_state_2'); ?>"><?php esc_html_e('Checked','car-park-booking-system'); ?></label>
												<input type="radio" value="3" id="<?php CPBSHelper::getFormName('billing_detail_state_3'); ?>" name="<?php CPBSHelper::getFormName('billing_detail_state'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['billing_detail_state'],3); ?>/>
												<label for="<?php CPBSHelper::getFormName('billing_detail_state_3'); ?>"><?php esc_html_e('Mandatory','car-park-booking-system'); ?></label>
												<input type="radio" value="4" id="<?php CPBSHelper::getFormName('billing_detail_state_4'); ?>" name="<?php CPBSHelper::getFormName('billing_detail_state'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['billing_detail_state'],4); ?>/>
												<label for="<?php CPBSHelper::getFormName('billing_detail_state_4'); ?>"><?php esc_html_e('Hidden','car-park-booking-system'); ?></label>
											</div>
										</li>
										<li>
											<h5><?php esc_html_e('Fields mandatory','car-park-booking-system'); ?></h5>
											<span class="to-legend"><?php esc_html_e('Select which fields should be marked as mandatory.','car-park-booking-system'); ?></span>
											<div class="to-checkbox-button">
<?php
		foreach($this->data['dictionary']['field_mandatory'] as $index=>$value)
		{
?>
												<input type="checkbox" value="<?php echo esc_attr($index); ?>" id="<?php CPBSHelper::getFormName('field_mandatory_'.$index); ?>" name="<?php CPBSHelper::getFormName('field_mandatory['.$index.']'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['field_mandatory'],$index); ?>/>
												<label for="<?php CPBSHelper::getFormName('field_mandatory_'.$index); ?>"><?php echo esc_html($value['label']); ?></label>
<?php		
		}
?>								
											</div>
										</li> 
										<li>
											<h5><?php esc_html_e('Show "Booking extras" section in step #3','car-park-booking-system'); ?></h5>
											<span class="to-legend"><?php esc_html_e('Show "Booking extras" section in step #3 (and hide it in step #2).','car-park-booking-system'); ?></span>
											<div class="to-radio-button">
												<input type="radio" value="1" id="<?php CPBSHelper::getFormName('booking_extra_step_3_enable_1'); ?>" name="<?php CPBSHelper::getFormName('booking_extra_step_3_enable'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['booking_extra_step_3_enable'],1); ?>/>
												<label for="<?php CPBSHelper::getFormName('booking_extra_step_3_enable_1'); ?>"><?php esc_html_e('Enable','car-park-booking-system'); ?></label>
												<input type="radio" value="0" id="<?php CPBSHelper::getFormName('booking_extra_step_3_enable_0'); ?>" name="<?php CPBSHelper::getFormName('booking_extra_step_3_enable'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['booking_extra_step_3_enable'],0); ?>/>
												<label for="<?php CPBSHelper::getFormName('booking_extra_step_3_enable_0'); ?>"><?php esc_html_e('Disable','car-park-booking-system'); ?></label>
											</div>
										</li> 											
									</ul>
								</div>
								<div id="meta-box-booking-form-1-3-5">
									<div class="to-notice-small to-notice-small-error">
										<?php esc_html_e('There are no settings for this step.','car-park-booking-system'); ?>
									</div>									
								</div>								
								<div id="meta-box-booking-form-1-3-6">
									<ul class="to-form-field-list">	
										<li>
											<h5><?php esc_html_e('"Thank You" page','car-park-booking-system'); ?></h5>
											<span class="to-legend">
												<?php esc_html_e('Enable or disable "Thank You" page in booking form.','car-park-booking-system'); ?><br/>
												<?php esc_html_e('Please note, that disabling this page is available only if wooCommerce support is enabled.','car-park-booking-system'); ?><br/>
												<?php esc_html_e('Then, customer is redirected to checkout page without information, that order has been sent.','car-park-booking-system'); ?>
											</span>
											<div class="to-radio-button">
												<input type="radio" value="1" id="<?php CPBSHelper::getFormName('thank_you_page_enable_1'); ?>" name="<?php CPBSHelper::getFormName('thank_you_page_enable'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['thank_you_page_enable'],1); ?>/>
												<label for="<?php CPBSHelper::getFormName('thank_you_page_enable_1'); ?>"><?php esc_html_e('Enable','car-park-booking-system'); ?></label>
												<input type="radio" value="0" id="<?php CPBSHelper::getFormName('thank_you_page_enable_0'); ?>" name="<?php CPBSHelper::getFormName('thank_you_page_enable'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['thank_you_page_enable'],0); ?>/>
												<label for="<?php CPBSHelper::getFormName('thank_you_page_enable_0'); ?>"><?php esc_html_e('Disable','car-park-booking-system'); ?></label>
											</div>
										</li> 
										<li>
											<h5><?php esc_html_e('"Back to home" button on "Thank you" page','car-park-booking-system'); ?></h5>
											<span class="to-legend">
												<?php esc_html_e('Enter URL address and label for this button.','car-park-booking-system'); ?><br/>
												<?php esc_html_e('This button is displayed if payment processing is disabled or customer selects wire transfer or cash payment.','car-park-booking-system'); ?>
											</span>
											<div>
												<span class="to-legend-field"><?php esc_html_e('Label:','car-park-booking-system'); ?></span>
												<div>
													<input type="text" name="<?php CPBSHelper::getFormName('thank_you_page_button_back_to_home_label'); ?>" value="<?php echo esc_attr($this->data['meta']['thank_you_page_button_back_to_home_label']); ?>"/>
												</div>					 
											</div>
											<div>
												<span class="to-legend-field"><?php esc_html_e('URL address:','car-park-booking-system'); ?></span>
												<div>
													<input type="text" name="<?php CPBSHelper::getFormName('thank_you_page_button_back_to_home_url_address'); ?>" value="<?php echo esc_attr($this->data['meta']['thank_you_page_button_back_to_home_url_address']); ?>"/>
												</div>					 
											</div>
										</li> 
									</ul>
								</div>
							</div>	
						</div>
					</div>
				</div>
				<div id="meta-box-booking-form-2">
					<ul class="to-form-field-list">
						<li>
							<h5><?php esc_html_e('Panels','car-park-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('Table includes list of user defined panels (group of fields) used in client form.','car-park-booking-system'); ?><br/>
								<?php esc_html_e('Default tabs "Contact details" and "Billing address" cannot be modified.','car-park-booking-system'); ?>
							</span>
							<div class="to-clear-fix">
								<table class="to-table" id="to-table-form-element-panel">
									<tr>
										<th width="85%">
											<div>
												<?php esc_html_e('Label','car-park-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Label of the panel.','car-park-booking-system'); ?>
												</span>
											</div>
										</th>
										<th width="18%">
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
												<input type="hidden" name="<?php CPBSHelper::getFormName('form_element_panel[id][]'); ?>"/>
												<input type="text" name="<?php CPBSHelper::getFormName('form_element_panel[label][]'); ?>" title="<?php esc_attr_e('Enter label.','car-park-booking-system'); ?>"/>
											</div>									
										</td>
										<td>
											<div>
												<a href="#" class="to-table-button-remove"><?php esc_html_e('Remove','car-park-booking-system'); ?></a>
											</div>
										</td>										
									</tr>
<?php
		if(isset($this->data['meta']['form_element_panel']))
		{
			foreach($this->data['meta']['form_element_panel'] as $panelValue)
			{
?>
											<tr>
												<td>
													<div>
														<input type="hidden" value="<?php echo esc_attr($panelValue['id']); ?>" name="<?php CPBSHelper::getFormName('form_element_panel[id][]'); ?>"/>
														<input type="text" value="<?php echo esc_attr($panelValue['label']); ?>" name="<?php CPBSHelper::getFormName('form_element_panel[label][]'); ?>" title="<?php esc_attr_e('Enter label.','car-park-booking-system'); ?>"/>
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
							<h5><?php esc_html_e('Fields','car-park-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('Table includes list of user defined fields used in client form.','car-park-booking-system'); ?><br/>
								<?php esc_html_e('Default fields located in tabs "Contact details" and "Billing address" cannot be modified.','car-park-booking-system'); ?><br/>
								<?php esc_html_e('If the new field is marked as "Mandatory", "Error message" field in the table cannot be empty.','car-park-booking-system'); ?><br/>
							</span>
							<div class="to-clear-fix to-table-form-element-field">
								<table class="to-table" id="to-table-form-element-field">
									<tr>
										<th width="15%">
											<div>
												<?php esc_html_e('Label','car-park-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Label of the field.','car-park-booking-system'); ?>
												</span>
											</div>
										</th>
										<th width="15%">
											<div>
												<?php esc_html_e('Type','car-park-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Field type.','car-park-booking-system'); ?>
												</span>
											</div>
										</th>
										<th width="7.5%">
											<div>
												<?php esc_html_e('Mandatory','car-park-booking-system'); ?>
												<span class="to-legend">
												<?php esc_html_e('Mandatory.','car-park-booking-system'); ?>
												</span>
											</div>
										</th>		
										<th width="20%">
											<div>
												<?php esc_html_e('Values','car-park-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('List of possible values to choose separated by semicolon.','car-park-booking-system'); ?>
												</span>
											</div>
										</th>   
										<th width="20%">
											<div>
												<?php esc_html_e('Error message','car-park-booking-system'); ?>	
												<span class="to-legend">
													<?php esc_html_e('Error message displayed in tooltip when field is empty.','car-park-booking-system'); ?>
												</span>
											</div>
										</th>											  
										<th width="15%">
											<div>
												<?php esc_html_e('Panel','car-park-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Panel in which field has to be located.','car-park-booking-system'); ?>
												</span>
											</div>
										</th>											 
										<th width="7.5%">
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
												<input type="hidden" name="<?php CPBSHelper::getFormName('form_element_field[id][]'); ?>"/>
												<input type="text" name="<?php CPBSHelper::getFormName('form_element_field[label][]'); ?>" title="<?php esc_attr_e('Enter label.','car-park-booking-system'); ?>"/>
											</div>									
										</td>
										<td>
											<div class="to-clear-fix">
												<select name="<?php CPBSHelper::getFormName('form_element_field[type][]'); ?>" class="to-dropkick-disable" id="form_element_field_type">
<?php
		foreach($this->data['dictionary']['field_type'] as $index=>$value)
			echo '<option value="'.esc_attr($index).'">'.esc_html($value[0]).'</option>';
?>
												</select>
											</div>									
										</td>	
										<td>
											<div class="to-clear-fix">
												<select name="<?php CPBSHelper::getFormName('form_element_field[mandatory][]'); ?>" class="to-dropkick-disable" id="form_element_field_mandatory">
													<option value="1"><?php esc_html_e('Yes','car-park-booking-system'); ?></option>
													<option value="0" selected="selected"><?php esc_html_e('No','car-park-booking-system'); ?></option>
												</select>
											</div>
										</td>
										<td>
											<div class="to-clear-fix">												
												<input type="text" name="<?php CPBSHelper::getFormName('form_element_field[dictionary][]'); ?>" title="<?php esc_attr_e('Enter values of list separated by semicolon.','car-park-booking-system'); ?>"/>
											</div>									
										</td>  
										<td>
											<div class="to-clear-fix">												
												<input type="text" name="<?php CPBSHelper::getFormName('form_element_field[message_error][]'); ?>" title="<?php esc_attr_e('Enter error message.','car-park-booking-system'); ?>"/>
											</div>									
										</td>										
										<td>
											<div class="to-clear-fix">
												<select name="<?php CPBSHelper::getFormName('form_element_field[panel_id][]'); ?>" class="to-dropkick-disable" id="form_element_field_panel_id">
<?php
		foreach($this->data['dictionary']['form_element_panel'] as $index=>$value)
			echo '<option value="'.esc_attr($value['id']).'">'.esc_html($value['label']).'</option>';
?>
												</select>
											</div>									
										</td>
										<td>
											<div>
												<a href="#" class="to-table-button-remove"><?php esc_html_e('Remove','car-park-booking-system'); ?></a>
											</div>
										</td>										
									</tr>
<?php
		if(isset($this->data['meta']['form_element_field']))
		{
			foreach($this->data['meta']['form_element_field'] as $fieldValue)
			{
?>			   
									<tr>
										<td>
											<div class="to-clear-fix">
												<input type="hidden" value="<?php echo esc_attr($fieldValue['id']); ?>" name="<?php CPBSHelper::getFormName('form_element_field[id][]'); ?>"/>
												<input type="text" value="<?php echo esc_attr($fieldValue['label']); ?>" name="<?php CPBSHelper::getFormName('form_element_field[label][]'); ?>" title="<?php esc_attr_e('Enter label.','car-park-booking-system'); ?>"/>
											</div>									
										</td>
										<td>
											<div class="to-clear-fix">
												<select  id="<?php CPBSHelper::getFormName('form_element_field_type_'.$fieldValue['id']); ?>" name="<?php CPBSHelper::getFormName('form_element_field[type][]'); ?>">
<?php
		foreach($this->data['dictionary']['field_type'] as $index=>$value)
			echo '<option value="'.esc_attr($index).'" '.(CPBSHelper::selectedIf($fieldValue['type'],$index,false)).'>'.esc_html($value[0]).'</option>';
?>
												</select>
											</div>									
										</td>
										<td>
											<div class="to-clear-fix">
												<select id="<?php CPBSHelper::getFormName('form_element_field_mandatory_'.$fieldValue['id']); ?>" name="<?php CPBSHelper::getFormName('form_element_field[mandatory][]'); ?>">
													<option value="1" <?php CPBSHelper::selectedIf($fieldValue['mandatory'],1); ?>><?php esc_html_e('Yes','car-park-booking-system'); ?></option>
													<option value="0" <?php CPBSHelper::selectedIf($fieldValue['mandatory'],0); ?>><?php esc_html_e('No','car-park-booking-system'); ?></option>
												</select>
											</div>
										</td>
										<td>
											<div class="to-clear-fix">												
												<input type="text" value="<?php echo esc_attr($fieldValue['dictionary']); ?>" name="<?php CPBSHelper::getFormName('form_element_field[dictionary][]'); ?>" title="<?php esc_attr_e('Enter values of list separated by semicolon.','car-park-booking-system'); ?>"/>
											</div>									
										</td> 
										<td>
											<div class="to-clear-fix">												
												<input type="text" value="<?php echo esc_attr($fieldValue['message_error']); ?>" name="<?php CPBSHelper::getFormName('form_element_field[message_error][]'); ?>" title="<?php esc_attr_e('Enter error message.','car-park-booking-system'); ?>"/>
											</div>									
										</td>										
										<td>
											<div class="to-clear-fix">
												<select id="<?php CPBSHelper::getFormName('form_element_field_panel_id_'.$fieldValue['id']); ?>" name="<?php CPBSHelper::getFormName('form_element_field[panel_id][]'); ?>">
<?php
														foreach($this->data['dictionary']['form_element_panel'] as $index=>$value)
															echo '<option value="'.esc_attr($value['id']).'" '.(CPBSHelper::selectedIf($fieldValue['panel_id'],$value['id'],false)).'>'.esc_html($value['label']).'</option>';
?>
												</select>
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
							<h5><?php esc_html_e('Agreements','car-park-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('Table includes list of agreements needed to accept by customer before sending the booking.','car-park-booking-system'); ?><br/>
								<?php esc_html_e('Each agreement consists of approval field (checkbox) and text of agreement.','car-park-booking-system'); ?>
							</span>
							<div class="to-clear-fix">
								<table class="to-table" id="to-table-form-element-agreement">
									<tr>
										<th width="85%">
											<div>
												<?php esc_html_e('Text','car-park-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Text of the agreement.','car-park-booking-system'); ?>
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
											<div>
												<input type="hidden" name="<?php CPBSHelper::getFormName('form_element_agreement[id][]'); ?>"/>
												<input type="text" name="<?php CPBSHelper::getFormName('form_element_agreement[text][]'); ?>" title="<?php esc_attr_e('Enter text.','car-park-booking-system'); ?>"/>
											</div>									
										</td>
										<td>
											<div>
												<a href="#" class="to-table-button-remove"><?php esc_html_e('Remove','car-park-booking-system'); ?></a>
											</div>
										</td>										
									</tr>
<?php
		if(isset($this->data['meta']['form_element_agreement']))
		{
			foreach($this->data['meta']['form_element_agreement'] as $agreementValue)
			{
?>
											<tr>
												<td>
													<div>
														<input type="hidden" value="<?php echo esc_attr($agreementValue['id']); ?>" name="<?php CPBSHelper::getFormName('form_element_agreement[id][]'); ?>"/>
														<input type="text" value="<?php echo esc_attr($agreementValue['text']); ?>" name="<?php CPBSHelper::getFormName('form_element_agreement[text][]'); ?>" title="<?php esc_attr_e('Enter text.','car-park-booking-system'); ?>"/>
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
				<div id="meta-box-booking-form-3">
					<ul class="to-form-field-list">
						<li>
							<h5><?php esc_html_e('Colors','car-park-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('Specify color for each group of elements.','car-park-booking-system'); ?>
							</span> 
							<div class="to-clear-fix">
								<table class="to-table">
									<tr>
										<th width="20%">
											<div>
												<?php esc_html_e('Group number','car-park-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Group number.','car-park-booking-system'); ?>
												</span>
											</div>
										</th>
										<th width="30%">
											<div>
												<?php esc_html_e('Default color','car-park-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Default value of the color.','car-park-booking-system'); ?>
												</span>
											</div>
										</th>
										<th width="50%">
											<div>
												<?php esc_html_e('Color','car-park-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('New value (in HEX) of the color.','car-park-booking-system'); ?>
												</span>
											</div>
										</th>
									</tr>
<?php
		foreach($this->data['dictionary']['color'] as $index=>$value)
		{
?>
										<tr>
											<td>
												<div><?php echo esc_html($index); ?>.</div>
											</td>
											<td>
												<div class="to-clear-fix">
													<span class="to-color-picker-sample to-color-picker-sample-style-1" <?php echo CPBSHelper::createStyleAttribute(array('background-color'=>'#'.$value['color'])); ?>></span>
													<span><?php echo '#'.esc_html($value['color']); ?></span>
												</div>
											</td>
											<td>
												<div class="to-clear-fix">	
													 <input type="text" class="to-color-picker" id="<?php CPBSHelper::getFormName('style_color_'.$index); ?>" name="<?php CPBSHelper::getFormName('style_color['.$index.']'); ?>" value="<?php echo esc_attr($this->data['meta']['style_color'][$index]); ?>"/>
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
				<div id="meta-box-booking-form-4">
					<ul class="to-form-field-list">				
						<li>
							<h5><?php esc_html_e('Google Maps enable','car-park-booking-system'); ?></h5>
							<span class="to-legend"><?php echo esc_html__('Enable or disable Google Maps.','car-park-booking-system'); ?></span> 
							<div class="to-radio-button">
								<input type="radio" value="1" id="<?php CPBSHelper::getFormName('google_map_enable_1'); ?>" name="<?php CPBSHelper::getFormName('google_map_enable'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['google_map_enable'],1); ?>/>
								<label for="<?php CPBSHelper::getFormName('google_map_enable_1'); ?>"><?php esc_html_e('Enable','car-park-booking-system'); ?></label>
								<input type="radio" value="0" id="<?php CPBSHelper::getFormName('google_map_enable_0'); ?>" name="<?php CPBSHelper::getFormName('google_map_enable'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['google_map_enable'],0); ?>/>
								<label for="<?php CPBSHelper::getFormName('google_map_enable_0'); ?>"><?php esc_html_e('Disable','car-park-booking-system'); ?></label>
							</div>							
						</li>
					   <li>
							<h5><?php esc_html_e('Scrollwheel','car-park-booking-system'); ?></h5>
							<span class="to-legend"><?php echo esc_html__('Enable or disable wheel scrolling on the map.','car-park-booking-system'); ?></span> 
							<div class="to-radio-button">
								<input type="radio" value="1" id="<?php CPBSHelper::getFormName('google_map_scrollwheel_enable_1'); ?>" name="<?php CPBSHelper::getFormName('google_map_scrollwheel_enable'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['google_map_scrollwheel_enable'],1); ?>/>
								<label for="<?php CPBSHelper::getFormName('google_map_scrollwheel_enable_1'); ?>"><?php esc_html_e('Enable','car-park-booking-system'); ?></label>
								<input type="radio" value="0" id="<?php CPBSHelper::getFormName('google_map_scrollwheel_enable_0'); ?>" name="<?php CPBSHelper::getFormName('google_map_scrollwheel_enable'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['google_map_scrollwheel_enable'],0); ?>/>
								<label for="<?php CPBSHelper::getFormName('google_map_scrollwheel_enable_0'); ?>"><?php esc_html_e('Disable','car-park-booking-system'); ?></label>
							</div>							
						</li>
						<li>
							<h5><?php esc_html_e('Map type control','car-park-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('Enter settings for a map type.','car-park-booking-system'); ?>
							</span> 
							<div class="to-clear-fix">
								<span class="to-legend-field"><?php esc_html_e('Type:','car-park-booking-system'); ?></span>
								<select name="<?php CPBSHelper::getFormName('google_map_map_type_control_id'); ?>" id="<?php CPBSHelper::getFormName('google_map_map_type_control_id'); ?>">
<?php
		foreach($this->data['dictionary']['google_map']['map_type_control_id'] as $index=>$value)
			echo '<option value="'.esc_attr($index).'" '.(CPBSHelper::selectedIf($this->data['meta']['google_map_map_type_control_id'],$index,false)).'>'.esc_html($value).'</option>';
?>
								</select>								
							</div>  
						</li>
						<li>
							<h5><?php esc_html_e('Zoom','car-park-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('Enter settings for a zoom.','car-park-booking-system'); ?>
							</span> 
							<div class="to-clear-fix">
								<span class="to-legend-field"><?php esc_html_e('Level:','car-park-booking-system'); ?></span>
								<div class="to-clear-fix">
									<div id="<?php CPBSHelper::getFormName('google_map_zoom_control_level'); ?>"></div>
									<input type="text" name="<?php CPBSHelper::getFormName('google_map_zoom_control_level'); ?>" id="<?php CPBSHelper::getFormName('google_map_zoom_control_level'); ?>" class="to-slider-range" readonly/>
								</div>								 
							</div>   
						</li>
						<li>
							<h5><?php esc_html_e('Style','car-park-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('Enter (in JSON format) styles for map.','car-park-booking-system'); ?><br/>
								<?php echo sprintf(esc_html__('You can create your own styles using %s.','car-park-booking-system'),'<a href="https://mapstyle.withgoogle.com/" target="_blank">'.esc_html__('Styling Wizard','car-park-booking-system').'</a>'); ?><br/>
							</span> 
							<div class="to-clear-fix">
								<textarea rows="1" cols="1" name="<?php CPBSHelper::getFormName('google_map_style'); ?>"><?php echo esc_html($this->data['meta']['google_map_style']); ?></textarea>
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
				element.createSlider(\'#'.CPBSHelper::getFormName('google_map_zoom_control_level',false).'\',1,21,'.(int)$this->data['meta']['google_map_zoom_control_level'].');

				/***/

				var timeFormat=\''.CPBSOption::getOption('time_format').'\';
				var dateFormat=\''.CPBSJQueryUIDatePicker::convertDateFormat(CPBSOption::getOption('date_format')).'\';

				helper.createCustomDateTimePicker(dateFormat,timeFormat);

				/***/

				$(\'#to-table-form-element-panel\').table();
				$(\'#to-table-form-element-field\').table();
				$(\'#to-table-form-element-agreement\').table();
			});			
		');