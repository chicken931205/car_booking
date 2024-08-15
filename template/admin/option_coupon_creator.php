<?php
				$Date=new CPBSDate();
?>
				<ul class="to-form-field-list">
					<li>
						<h5><?php esc_html_e('Count','car-park-booking-system'); ?></h5>
						<span class="to-legend">
							<?php esc_html_e('Number of coupons which should be generated.','car-park-booking-system'); ?><br/>
							<?php esc_html_e('Allowed are integer numbers from range 1-999.','car-park-booking-system'); ?>
						</span>
						<div>
							<input type="text" maxlength="3" name="<?php CPBSHelper::getFormName('coupon_generate_count'); ?>" id="<?php CPBSHelper::getFormName('coupon_generate_count'); ?>" value="<?php echo esc_attr($this->data['option']['coupon_generate_count']); ?>"/>
						</div>
					</li> 
					<li>
						<h5><?php esc_html_e('Usage limit','car-park-booking-system'); ?></h5>
						<span class="to-legend"><?php esc_html_e('Current usage count of the code. Allowed are integer values from range 1-9999. Leave blank for unlimited.','car-park-booking-system'); ?></span>
						<div>
							<input type="text" maxlength="4" name="<?php CPBSHelper::getFormName('coupon_generate_usage_limit'); ?>" id="<?php CPBSHelper::getFormName('coupon_generate_usage_limit'); ?>" value="<?php echo esc_attr($this->data['option']['coupon_generate_usage_limit']); ?>"/>
						</div>
					</li>
					<li>
						<h5><?php esc_html_e('Active from','car-park-booking-system'); ?></h5>
						<span class="to-legend"><?php esc_html_e('Start date. Leave blank for no start date.','car-park-booking-system'); ?></span>
						<div>
							<input type="text" class="to-datepicker-custom" name="<?php CPBSHelper::getFormName('coupon_generate_active_date_start'); ?>" id="<?php CPBSHelper::getFormName('coupon_generate_active_date_start'); ?>" value="<?php echo esc_attr($this->data['option']['coupon_generate_active_date_start']); ?>"/>
						</div>
					</li>  
					<li>
						<h5><?php esc_html_e('Active to','car-park-booking-system'); ?></h5>
						<span class="to-legend"><?php esc_html_e('Stop date. Leave blank for no start date.','car-park-booking-system'); ?></span>
						<div>
							<input type="text" class="to-datepicker-custom" name="<?php CPBSHelper::getFormName('coupon_generate_active_date_stop'); ?>" id="<?php CPBSHelper::getFormName('coupon_generate_active_date_stop'); ?>" value="<?php echo esc_attr($this->data['option']['coupon_generate_active_date_stop']); ?>"/>
						</div>
					</li>
					<li>
						<h5><?php esc_html_e('Percentage discount','car-park-booking-system'); ?></h5>
						<span class="to-legend">
						<?php esc_html_e('Percentage discount. Allowed are integer numbers from 1-99.','car-park-booking-system'); ?></span>
						<div>
							<input type="text" maxlength="3" name="<?php CPBSHelper::getFormName('coupon_generate_discount_percentage'); ?>" id="<?php CPBSHelper::getFormName('coupon_generate_discount_percentage'); ?>" value="<?php echo esc_attr($this->data['option']['coupon_generate_discount_percentage']); ?>"/>
						</div>
					</li>   
					<li>
						<h5><?php esc_html_e('Fixed discount','car-park-booking-system'); ?></h5>
						<span class="to-legend"><?php esc_html_e('Fixed discount.','car-park-booking-system'); ?></span>
						<div>
							<input type="text" maxlength="12" name="<?php CPBSHelper::getFormName('coupon_generate_discount_fixed'); ?>" id="<?php CPBSHelper::getFormName('coupon_generate_discount_fixed'); ?>" value="<?php echo esc_attr($this->data['option']['coupon_generate_discount_fixed']); ?>"/>
						</div>
					</li>	 
					<li>
						<input type="button" name="<?php CPBSHelper::getFormName('create_coupon_code'); ?>" id="<?php CPBSHelper::getFormName('create_coupon_code'); ?>" class="to-button to-margin-0" value="<?php esc_attr_e('Create coupons','car-park-booking-system'); ?>"/>
					</li>
				</ul>
<?php
		CPBSHelper::addInlineScript('cpbs-admin',
		'
			jQuery(document).ready(function($)
			{
				var helper=new CPBSHelper();

				var timeFormat=\''.CPBSOption::getOption('time_format').'\';
				var dateFormat=\''.CPBSJQueryUIDatePicker::convertDateFormat(CPBSOption::getOption('date_format')).'\';

				helper.createCustomDateTimePicker(dateFormat,timeFormat);

				$(\''.CPBSHelper::getFormName('create_coupon_code',false).'\').bind(\'click\',function(e) 
				{
					e.preventDefault();
					$(\'#action\').val(\''.PLUGIN_CPBS_CONTEXT.'_option_page_create_coupon_code\');
					$(\'#to_form\').submit();
					$(\'#action\').val(\''.PLUGIN_CPBS_CONTEXT.'_option_page_save\');
				});
			});
		');