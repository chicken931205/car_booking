<?php 
		echo $this->data['nonce']; 
		$Date=new CPBSDate();
?>	
		<div class="to">
			<div class="ui-tabs">
				<ul>
					<li><a href="#meta-box-coupon-1"><?php esc_html_e('General','car-park-booking-system'); ?></a></li>
					<li><a href="#meta-box-coupon-2"><?php esc_html_e('Users','car-park-booking-system'); ?></a></li>
				</ul>
				<div id="meta-box-coupon-1">
					<ul class="to-form-field-list">
						<?php echo CPBSHelper::createPostIdField(__('Coupon ID','car-park-booking-system')); ?>
						<li>
							<h5><?php esc_html_e('Coupon code','car-park-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Unique code of the coupon.','car-park-booking-system'); ?></span>
							<div>
								<input type="text" maxlength="32" name="<?php CPBSHelper::getFormName('code'); ?>" id="<?php CPBSHelper::getFormName('code'); ?>" value="<?php echo esc_attr($this->data['meta']['code']); ?>"/>
							</div>
						</li> 
						<li>
							<h5><?php esc_html_e('Usage count','car-park-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Current usage count of the code.','car-park-booking-system'); ?></span>
							<div class="to-field-disabled">
								<?php echo esc_html($this->data['meta']['usage_count']); ?>
							</div>
						</li>  
						<li>
							<h5><?php esc_html_e('Usage limit','car-park-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Usage limit of the code. Allowed are integer values from range 1-9999. Leave blank for unlimited.','car-park-booking-system'); ?></span>
							<div>
								<input type="text" maxlength="4" name="<?php CPBSHelper::getFormName('usage_limit'); ?>" id="<?php CPBSHelper::getFormName('usage_limit'); ?>" value="<?php echo esc_attr($this->data['meta']['usage_limit']); ?>"/>
							</div>
						</li>  
						<li>
							<h5><?php esc_html_e('Active from','car-park-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Start date. Leave blank for no start date.','car-park-booking-system'); ?></span>
							<div>
								<input type="text" class="to-datepicker-custom" name="<?php CPBSHelper::getFormName('active_date_start'); ?>" id="<?php CPBSHelper::getFormName('active_date_start'); ?>" value="<?php echo esc_attr($Date->formatDateToDisplay($this->data['meta']['active_date_start'])); ?>"/>
							</div>
						</li>  
						<li>
							<h5><?php esc_html_e('Active to','car-park-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Stop date. Leave blank for no stop  date.','car-park-booking-system'); ?></span>
							<div>
								<input type="text" class="to-datepicker-custom" name="<?php CPBSHelper::getFormName('active_date_stop'); ?>" id="<?php CPBSHelper::getFormName('active_date_stop'); ?>" value="<?php echo esc_attr($Date->formatDateToDisplay($this->data['meta']['active_date_stop'])); ?>"/>
							</div>
						</li>  						
						<li>
							<h5><?php esc_html_e('Percentage discount','car-park-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Percentage discount. Allowed are integer numbers from 0-100.','car-park-booking-system'); ?></span>
							<div>
								<input type="text" maxlength="3" name="<?php CPBSHelper::getFormName('discount_percentage'); ?>" id="<?php CPBSHelper::getFormName('discount_percentage'); ?>" value="<?php echo esc_attr($this->data['meta']['discount_percentage']); ?>"/>
							</div>
						</li>	 
						<li>
							<h5><?php esc_html_e('Fixed discount','car-park-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Fixed discount. This discount is used only if percentage discount is set to 0.','car-park-booking-system'); ?></span>
							<div>
								<input type="text" maxlength="12" name="<?php CPBSHelper::getFormName('discount_fixed'); ?>" id="<?php CPBSHelper::getFormName('discount_fixed'); ?>" value="<?php echo esc_attr($this->data['meta']['discount_fixed']); ?>"/>
							</div>
						</li>  
					   <li>
							<h5><?php esc_html_e('Discount based on rental days number','car-park-booking-system'); ?></h5>
							<span class="to-legend">
								<?php echo esc_html__('Enter discount (percentage or fixed) for selected range of rental days. This option works for "Day" and "Day II" billing types only.','car-park-booking-system'); ?><br/>
								<?php echo esc_html__('Fixed discount is used only if percentage discount is set to 0. If days ranges will not be found, default discount from coupon will be applied.','car-park-booking-system'); ?><br/>
							</span>
							<div>
								<table class="to-table" id="to-table-discount-rental-day-count">
									<tr>
										<th width="20%">
											<div>
												<?php esc_html_e('From','car-park-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('From.','car-park-booking-system'); ?>
												</span>
											</div>
										</th>
										<th width="20%">
											<div>
												<?php esc_html_e('To','car-park-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('To.','car-park-booking-system'); ?>
												</span>
											</div>
										</th>
										<th width="20%">
											<div>
												<?php esc_html_e('Percentage discount','car-park-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Percentage discount.','car-park-booking-system'); ?>
												</span>
											</div>
										</th>
										<th width="20%">
											<div>
												<?php esc_html_e('Fixed discount','car-park-booking-system'); ?>
												<span class="to-legend">
													<?php esc_html_e('Fixed discount.','car-park-booking-system'); ?>
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
												<input type="text" maxlength="5" name="<?php CPBSHelper::getFormName('discount_rental_day_count[start][]'); ?>"/>
											</div>									
										</td>
										<td>
											<div>
												<input type="text" maxlength="5" name="<?php CPBSHelper::getFormName('discount_rental_day_count[stop][]'); ?>"/>
											</div>									
										</td>
										<td>
											<div>
												<input type="text" maxlength="3" name="<?php CPBSHelper::getFormName('discount_rental_day_count[discount_percentage][]'); ?>"/>
											</div>									
										</td>
										<td>
											<div>
												<input type="text" maxlength="12" name="<?php CPBSHelper::getFormName('discount_rental_day_count[discount_fixed][]'); ?>"/>
											</div>									
										</td>
										<td>
											<div>
												<a href="#" class="to-table-button-remove"><?php esc_html_e('Remove','car-park-booking-system'); ?></a>
											</div>
										</td>
									</tr>   
<?php
		if(isset($this->data['meta']['discount_rental_day_count']))
		{
			if(is_array($this->data['meta']['discount_rental_day_count']))
			{
				foreach($this->data['meta']['discount_rental_day_count'] as $index=>$value)
				{
?>
											<tr>
												<td>
													<div>
														<input type="text" maxlength="5" name="<?php CPBSHelper::getFormName('discount_rental_day_count[start][]'); ?>" value="<?php echo esc_attr($value['start']); ?>"/>
													</div>									
												</td>
												<td>
													<div>
														<input type="text" maxlength="5" name="<?php CPBSHelper::getFormName('discount_rental_day_count[stop][]'); ?>" value="<?php echo esc_attr($value['stop']); ?>"/>
													</div>									
												</td>
												<td>
													<div>
														<input type="text" maxlength="3" name="<?php CPBSHelper::getFormName('discount_rental_day_count[discount_percentage][]'); ?>" value="<?php echo esc_attr($value['discount_percentage']); ?>"/>
													</div>									
												</td>
												<td>
													<div>
														<input type="text" maxlength="12" name="<?php CPBSHelper::getFormName('discount_rental_day_count[discount_fixed][]'); ?>" value="<?php echo esc_attr($value['discount_fixed']); ?>"/>
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
				<div id="meta-box-coupon-2">
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
<?php
		CPBSHelper::addInlineScript('cpbs-admin',
		'
			jQuery(document).ready(function($)
			{
				$(\'.to\').themeOptionElement({init:true});

				var helper=new CPBSHelper();

				var timeFormat=\''.CPBSOption::getOption('time_format').'\';
				var dateFormat=\''.CPBSJQueryUIDatePicker::convertDateFormat(CPBSOption::getOption('date_format')).'\';

				helper.createCustomDateTimePicker(dateFormat,timeFormat);

				$(\'#to-table-discount-rental-day-count\').table();
			});
		');