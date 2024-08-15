<?php
		$Validation=new CPBSValidation();
		$Location=new CPBSLocation();
?>
		<div class="cpbs-notice cpbs-hidden"></div>
		<div class="cpbs-clear-fix cpbs-form-panel">
			<div>
				<div>
					<div>
						<div>
							<div class="cpbs-header cpbs-header-style-4">
<?php 
		if(CPBSBookingHelper::enableTimeField($this->data))
			esc_html_e('Entry Date and Time','car-park-booking-system'); 
		else esc_html_e('Entry Date','car-park-booking-system'); 
?>
							</div>
							<div>
								<div class="cpbs-form-field">
									<label class="cpbs-form-field-label"><?php esc_html_e('Entry date','car-park-booking-system'); ?></label>
									<input type="text" name="<?php CPBSHelper::getFormName('entry_date'); ?>" class="cpbs-datepicker" value="<?php echo CPBSRequest::get('entry_date'); ?>" autocomplete="off"/>
								</div>
<?php
		if(CPBSBookingHelper::enableTimeField($this->data))
		{
?>
						
								<div class="cpbs-form-field">
									<label class="cpbs-form-field-label"><?php esc_html_e('Entry time','car-park-booking-system'); ?></label>
									<input type="text" name="<?php CPBSHelper::getFormName('entry_time'); ?>" class="cpbs-timepicker" value="<?php echo CPBSRequest::get('entry_time'); ?>" autocomplete="off"/>
								</div>	
<?php
		}
?>
							</div>
						</div>
						<div>
							<div class="cpbs-header cpbs-header-style-4">
<?php 
		if(CPBSBookingHelper::enableTimeField($this->data))
			esc_html_e('Exit Date and Time','car-park-booking-system'); 
		else esc_html_e('Exit Date','car-park-booking-system'); 
?>
							</div>
							<div>
								<div class="cpbs-form-field">
									<label class="cpbs-form-field-label"><?php esc_html_e('Exit date','car-park-booking-system'); ?></label>
									<input type="text" name="<?php CPBSHelper::getFormName('exit_date'); ?>" class="cpbs-datepicker" value="<?php echo CPBSRequest::get('exit_date'); ?>" autocomplete="off"/>
								</div>
<?php
		if(CPBSBookingHelper::enableTimeField($this->data))
		{
?>
								<div class="cpbs-form-field">
									<label class="cpbs-form-field-label"><?php esc_html_e('Exit time','car-park-booking-system'); ?></label>
									<input type="text" name="<?php CPBSHelper::getFormName('exit_time'); ?>" class="cpbs-timepicker" value="<?php echo CPBSRequest::get('exit_time'); ?>" autocomplete="off"/>
								</div>	
<?php
		}
?>
							</div>
						</div>
<?php
		if((int)$this->data['location_field_enable']===1)
		{
?>
						<div>
							<div class="cpbs-header cpbs-header-style-4"><?php esc_html_e('Select Car Park','car-park-booking-system'); ?></div>
							<div>
								<div class="cpbs-form-field">
									<label><?php esc_html_e('Car park','car-park-booking-system'); ?></label>
									<select name="<?php CPBSHelper::getFormName('location_id'); ?>">
<?php
			foreach($this->data['dictionary']['location'] as $index=>$value)
			{
?>
										<option value="<?php echo esc_attr($index); ?>" <?php CPBSHelper::selectedIf($index,CPBSRequest::get('location_id')); ?>><?php echo esc_html($value['post']->post_title); ?></option>
<?php              
			}
?>
									</select>
								</div>
							</div>
						</div>
<?php
		}
?>
					</div>
					<div>
						<input type="submit" value="<?php esc_attr_e('Get My Quote','car-park-booking-system'); ?>" class="cpbs-button cpbs-button-style-1"/>
					</div>
				</div>
			</div>
<?php
		if(((int)$this->data['google_map_enable']===1) && ($this->data['widget_mode']!=1))
		{
?>
			<div>
				<div class="cpbs-google-map">
					<div id="cpbs_google_map"></div>
				</div>	
			</div>
<?php
		}
?>
		</div>	