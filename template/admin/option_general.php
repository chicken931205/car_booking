		<ul class="to-form-field-list">
			<li>
				<h5><?php esc_html_e('Billing type','car-park-booking-system'); ?></h5>
				<span class="to-legend"><?php esc_html_e('Select billing type.','car-park-booking-system'); ?></span>
				<div class="to-clear-fix">
					<select name="<?php CPBSHelper::getFormName('billing_type'); ?>" id="<?php CPBSHelper::getFormName('billing_type'); ?>">
<?php
		foreach($this->data['dictionary']['billing_type'] as $index=>$value)
			echo '<option value="'.esc_attr($index).'" '.(CPBSHelper::selectedIf($this->data['option']['billing_type'],$index,false)).'>'.esc_html($value[0]).'</option>';
?>
					</select>
				</div>
			</li>
			<li>
				<h5><?php esc_html_e('Logo','car-park-booking-system'); ?></h5>
				<span class="to-legend"><?php esc_html_e('Select company logo.','car-park-booking-system'); ?></span>
				<div class="to-clear-fix">
					<input type="text" name="<?php CPBSHelper::getFormName('logo'); ?>" id="<?php CPBSHelper::getFormName('logo'); ?>" class="to-float-left" value="<?php echo esc_attr($this->data['option']['logo']); ?>"/>
					<input type="button" name="<?php CPBSHelper::getFormName('logo_browse'); ?>" id="<?php CPBSHelper::getFormName('logo_browse'); ?>" class="to-button-browse to-button" value="<?php esc_attr_e('Browse','car-park-booking-system'); ?>"/>
				</div>
			</li> 
			<li>
				<h5><?php esc_html_e('Google Maps API key','car-park-booking-system'); ?></h5>
				<span class="to-legend">
					<?php echo sprintf(esc_html__('You can generate your own key %s.','car-park-booking-system'),'<a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank">'.esc_html__('here','car-park-booking-system').'</a>'); ?>
				</span>
				<div class="to-clear-fix">
					<input type="text" name="<?php CPBSHelper::getFormName('google_map_api_key'); ?>" id="<?php CPBSHelper::getFormName('google_map_api_key'); ?>" value="<?php echo esc_attr($this->data['option']['google_map_api_key']); ?>"/>
				</div>
			</li>  
			<li>
				<h5><?php esc_html_e('Remove duplicated Google Maps scripts','car-park-booking-system'); ?></h5>
				<span class="to-legend">
					<?php esc_html_e('Enable this option to remove Google Maps script from theme and other, included plugins.','car-park-booking-system'); ?><br/>
					<?php esc_html_e('This option allows to prevent errors related with including the same script more than once.','car-park-booking-system'); ?>
				</span>
				<div class="to-clear-fix">
					 <div class="to-radio-button">
						<input type="radio" value="1" id="<?php CPBSHelper::getFormName('google_map_duplicate_script_remove_1'); ?>" name="<?php CPBSHelper::getFormName('google_map_duplicate_script_remove'); ?>" <?php CPBSHelper::checkedIf($this->data['option']['google_map_duplicate_script_remove'],1); ?>/>
						<label for="<?php CPBSHelper::getFormName('google_map_duplicate_script_remove_1'); ?>"><?php esc_html_e('Enable (remove)','car-park-booking-system'); ?></label>
						<input type="radio" value="0" id="<?php CPBSHelper::getFormName('google_map_duplicate_script_remove_0'); ?>" name="<?php CPBSHelper::getFormName('google_map_duplicate_script_remove'); ?>" <?php CPBSHelper::checkedIf($this->data['option']['google_map_duplicate_script_remove'],0); ?>/>
						<label for="<?php CPBSHelper::getFormName('google_map_duplicate_script_remove_0'); ?>"><?php esc_html_e('Disable','car-park-booking-system'); ?></label>
					</div>
				</div>
			</li>	 
			<li>
				<h5><?php esc_html_e('Currency','car-park-booking-system'); ?></h5>
				<span class="to-legend"><?php esc_html_e('Currency.','car-park-booking-system'); ?></span>
				<div class="to-clear-fix">
					<select name="<?php CPBSHelper::getFormName('currency'); ?>" id="<?php CPBSHelper::getFormName('currency'); ?>">
<?php
		foreach($this->data['dictionary']['currency'] as $index=>$value)
			echo '<option value="'.esc_attr($index).'" '.(CPBSHelper::selectedIf($this->data['option']['currency'],$index,false)).'>'.esc_html($index.' ('.$value['name'].')').'</option>';
?>
					</select>
				</div>
			</li>
			<li>
				<h5><?php esc_html_e('Length unit','car-park-booking-system'); ?></h5>
				<span class="to-legend"><?php esc_html_e('Length unit.','car-park-booking-system'); ?></span>
				<div class="to-clear-fix">
					<select name="<?php CPBSHelper::getFormName('length_unit'); ?>" id="<?php CPBSHelper::getFormName('length_unit'); ?>">
<?php
						foreach($this->data['dictionary']['length_unit'] as $index=>$value)
							echo '<option value="'.esc_attr($index).'" '.(CPBSHelper::selectedIf($this->data['option']['length_unit'],$index,false)).'>'.esc_html($value[0].' ('.$value[1].')').'</option>';
?>
					</select>
				</div>
			</li>   
			<li>
				<h5><?php esc_html_e('Date format','car-park-booking-system'); ?></h5>
				<span class="to-legend"><?php echo sprintf(esc_html__('Select the date format to be displayed. More info you can find here %s.','car-park-booking-system'),'<a href="https://codex.wordpress.org/Formatting_Date_and_Time" target="_blank">'.esc_html__('Formatting Date and Time','car-park-booking-system').'</a>'); ?></span>
				<div class="to-clear-fix">
					<input type="text" name="<?php CPBSHelper::getFormName('date_format'); ?>" id="<?php CPBSHelper::getFormName('date_format'); ?>" value="<?php echo esc_attr($this->data['option']['date_format']); ?>"/>
				</div>
			</li>  
			<li>
				<h5><?php esc_html_e('Time format','car-park-booking-system'); ?></h5>
				<span class="to-legend"><?php echo sprintf(esc_html__('Select the time format to be displayed. More info you can find here %s.','car-park-booking-system'),'<a href="https://codex.wordpress.org/Formatting_Date_and_Time" target="_blank">'.esc_html__('Formatting Date and Time','car-park-booking-system').'</a>'); ?></span>
				<div class="to-clear-fix">
					<input type="text" name="<?php CPBSHelper::getFormName('time_format'); ?>" id="<?php CPBSHelper::getFormName('time_format'); ?>" value="<?php echo esc_attr($this->data['option']['time_format']); ?>"/>
				</div>
			</li>			   
			<li>
				<h5><?php esc_html_e('Default sender e-mail account','car-park-booking-system'); ?></h5>
				<span class="to-legend">
					<?php esc_html_e('Select default e-mail account.','car-park-booking-system'); ?><br/>
					<?php esc_html_e('It will be used to sending email messages to clients about changing of booking status.','car-park-booking-system'); ?>
				</span>
				<div class="to-clear-fix">
					<select name="<?php CPBSHelper::getFormName('sender_default_email_account_id'); ?>" id="<?php CPBSHelper::getFormName('sender_default_email_account_id'); ?>">
<?php
		echo '<option value="-1" '.(CPBSHelper::selectedIf($this->data['option']['sender_default_email_account_id'],-1,false)).'>'.esc_html__('- Not set -','car-park-booking-system').'</option>';
		foreach($this->data['dictionary']['email_account'] as $index=>$value)
			echo '<option value="'.esc_attr($index).'" '.(CPBSHelper::selectedIf($this->data['option']['sender_default_email_account_id'],$index,false)).'>'.esc_html($value['post']->post_title).'</option>';
?>
					</select>
				</div>
			</li>
			<li>
				<h5><?php esc_html_e('Geolocation server','car-park-booking-system'); ?></h5>
				<span class="to-legend">
					<?php esc_html_e('Select which servers has to handle geolocation requests.','car-park-booking-system'); ?><br/>
					<?php esc_html_e('For some of them, set up extra data could be needed.','car-park-booking-system'); ?><br/>
				</span>
				<div class="to-clear-fix">
					<span class="to-legend-field"><?php esc_html_e('Server:','car-park-booking-system'); ?></span>
					<div>
						<select name="<?php CPBSHelper::getFormName('geolocation_server_id'); ?>" id="<?php CPBSHelper::getFormName('geolocation_server_id'); ?>">
<?php
		echo '<option value="-1" '.(CPBSHelper::selectedIf($this->data['option']['geolocation_server_id'],-1,false)).'>'.esc_html__('- Not set -','car-park-booking-system').'</option>';
		foreach($this->data['dictionary']['geolocation_server'] as $index=>$value)
			echo '<option value="'.esc_attr($index).'" '.(CPBSHelper::selectedIf($this->data['option']['geolocation_server_id'],$index,false)).'>'.esc_html($value['name']).'</option>';
?>
						</select>
					</div>
				</div>
				<div class="to-clear-fix">
					<span class="to-legend-field"><?php esc_html_e('API key for ipstack server:','car-park-booking-system'); ?></span>
					<div>
						<input type="text" name="<?php CPBSHelper::getFormName('geolocation_server_id_3_api_key'); ?>" id="<?php CPBSHelper::getFormName('geolocation_server_id_3_api_key'); ?>" value="<?php echo esc_attr($this->data['option']['geolocation_server_id_3_api_key']); ?>"/>
					</div>
				</div>
			</li> 
			<li>
				<h5><?php esc_html_e('WooCommerce new order attachment','car-park-booking-system'); ?></h5>
				<span class="to-legend"><?php esc_html_e('Select file which will be added to the new order e-mail message sent by wooCommerce.','car-park-booking-system'); ?></span>
				<div class="to-clear-fix">
					<input type="hidden" name="<?php CPBSHelper::getFormName('attachment_woocommerce_email'); ?>" id="<?php CPBSHelper::getFormName('attachment_woocommerce_email'); ?>" value="<?php echo esc_attr($this->data['option']['attachment_woocommerce_email']); ?>"/>
					<input type="button" name="<?php CPBSHelper::getFormName('attachment_woocommerce_email_browse'); ?>" id="<?php CPBSHelper::getFormName('attachment_woocommerce_email_browse'); ?>" class="to-button-browse to-button" value="<?php esc_attr_e('Browse','car-park-booking-system'); ?>"/>
				</div>
			</li>  
			<li>
				<h5><?php esc_html_e('Booking report','car-park-booking-system'); ?></h5>
				<span class="to-legend">
					<?php esc_html_e('Enable or disable sending (via e-mail) message with complete list of customers which bookings starts/ends today.','car-park-booking-system'); ?><br/>
				</span>
				<div class="to-clear-fix">
					<span class="to-legend-field"><?php esc_html_e('Status:','car-park-booking-system'); ?></span>
					<div class="to-clear-fix">
						<div class="to-radio-button">
							<input type="radio" value="1" id="<?php CPBSHelper::getFormName('email_report_status_1'); ?>" name="<?php CPBSHelper::getFormName('email_report_status'); ?>" <?php CPBSHelper::checkedIf($this->data['option']['email_report_status'],1); ?>/>
							<label for="<?php CPBSHelper::getFormName('email_report_status_1'); ?>"><?php esc_html_e('Enable','car-park-booking-system'); ?></label>
							<input type="radio" value="0" id="<?php CPBSHelper::getFormName('email_report_status_0'); ?>" name="<?php CPBSHelper::getFormName('email_report_status'); ?>" <?php CPBSHelper::checkedIf($this->data['option']['email_report_status'],0); ?>/>
							<label for="<?php CPBSHelper::getFormName('email_report_status_0'); ?>"><?php esc_html_e('Disable','car-park-booking-system'); ?></label>
						</div>
					</div>
				</div>
				<div class="to-clear-fix">
					<span class="to-legend-field"><?php esc_html_e('Sender account:','car-park-booking-system'); ?></span>
					<div class="to-clear-fix">
						<select name="<?php CPBSHelper::getFormName('email_report_sender_email_account_id'); ?>" id="<?php CPBSHelper::getFormName('email_report_sender_email_account_id'); ?>">
<?php
		echo '<option value="-1" '.(CPBSHelper::selectedIf($this->data['option']['email_report_sender_email_account_id'],-1,false)).'>'.esc_html__('- Not set -','car-park-booking-system').'</option>';
		foreach($this->data['dictionary']['email_account'] as $index=>$value)
			echo '<option value="'.esc_attr($index).'" '.(CPBSHelper::selectedIf($this->data['option']['email_report_sender_email_account_id'],$index,false)).'>'.esc_html($value['post']->post_title).'</option>';
?>
						</select> 
					</div>
				</div>
				<div class="to-clear-fix">
					<span class="to-legend-field"><?php esc_html_e('List of recipients e-mail addresses separated by semicolon:','car-park-booking-system'); ?></span>
					<div class="to-clear-fix">
						<input type="text" name="<?php CPBSHelper::getFormName('email_report_recipient_email_address'); ?>" id="<?php CPBSHelper::getFormName('email_report_recipient_email_address'); ?>" value="<?php echo esc_attr($this->data['option']['email_report_recipient_email_address']); ?>"/>
					</div>						
				</div>
				<div class="to-clear-fix">
					<span class="to-legend-field"><?php esc_html_e('Date range','car-park-booking-system'); ?></span>
					<div class="to-clear-fix">				
						<select name="<?php CPBSHelper::getFormName('email_report_date_range'); ?>" id="<?php CPBSHelper::getFormName('email_report_date_range'); ?>">
							<option value="0" <?php CPBSHelper::selectedIf($this->data['option']['email_report_date_range'],0); ?>'><?php esc_html_e('Report includes a today\'s bookings','car-park-booking-system'); ?></option>
							<option value="1" <?php CPBSHelper::selectedIf($this->data['option']['email_report_date_range'],1); ?>'><?php esc_html_e('Report includes a tomorrow\'s bookings','car-park-booking-system'); ?></option>
						</select>	
					</div>
				</div>
				<div class="to-clear-fix">
					<span class="to-legend-field"><?php esc_html_e('Cron event:','car-park-booking-system'); ?></span>
					<div class="to-field-disabled to-width-100">
<?php
		$command='59 23 * * * wget '.get_site_url().'?cpbs_cron_event=1&cpbs_run_code='.CPBSOption::getOption('run_code');
		echo $command;
		echo '<a href="#" class="to-copy-to-clipboard to-float-right" data-clipboard-text="'.esc_attr($command).'" data-label-on-success="'.esc_attr__('Copied!','car-park-booking-system').'">'.esc_html__('Copy','car-park-booking-system').'</a>';
?>
					</div>						
				</div>	
				<div class="to-clear-fix">
					<span class="to-legend-field"><?php esc_html_e('Get booking report in CSV format:','car-park-booking-system'); ?></span>
					<div class="to-clear-fix">
						<input type="button" class="to-button to-button-booking-report-csv-get" name="<?php CPBSHelper::getFormName('booking_report_csv_get'); ?>" id="<?php CPBSHelper::getFormName('booking_report_csv_get'); ?>" value="<?php esc_attr_e('Get report','car-park-booking-system'); ?>"/>
					</div>
				</div>				
			</li>
			<li>
				<h5><?php esc_html_e('Fixer.io API key','car-park-booking-system'); ?></h5>
				<span class="to-legend">
					<?php echo sprintf(esc_html__('Enter API key generated by %s.','car-park-booking-system'),'<a href="https://fixer.io/" target="_blank">'.esc_html__('Fixer.io','car-park-booking-system').'</a>'); ?><br/>
				</span>
				<div class="to-clear-fix">
					<input type="text" name="<?php CPBSHelper::getFormName('fixer_io_api_key'); ?>" id="<?php CPBSHelper::getFormName('fixer_io_api_key'); ?>" value="<?php echo esc_attr($this->data['option']['fixer_io_api_key']); ?>"/>
				</div>
			</li>  
			<li>
				<h5><?php esc_html_e('Non-blocking booking statues','car-park-booking-system'); ?></h5>
				<span class="to-legend">
					<?php esc_html_e('Selected these statuses which don\'t block date/time during checking vehicle availability based on past bookings.','car-park-booking-system'); ?>
				</span>
				<div class="to-checkbox-button">
<?php
		foreach($this->data['dictionary']['booking_status'] as $index=>$value)
		{
?>
					<input type="checkbox" value="<?php echo esc_attr($index); ?>" id="<?php CPBSHelper::getFormName('booking_status_nonblocking_'.$index); ?>" name="<?php CPBSHelper::getFormName('booking_status_nonblocking[]'); ?>" <?php CPBSHelper::checkedIf($this->data['option']['booking_status_nonblocking'],$index); ?>/>
					<label for="<?php CPBSHelper::getFormName('booking_status_nonblocking_'.$index); ?>"><?php echo esc_html($value[0]); ?></label>
<?php		
		}
?>
				</div>
			</li>
		</ul>
<?php
		CPBSHelper::addInlineScript('cpbs-admin',
		'
			jQuery(document).ready(function($)
			{
				$(\'input[name="'.CPBSHelper::getFormName('booking_report_csv_get',false).'"]\').on(\'click\',function(e)
				{
					e.preventDefault();
					window.open("'.get_site_url().'?cpbs_cron_event=2&cpbs_run_code='.CPBSOption::getOption('run_code').'","_blank");
				});
			});
		');