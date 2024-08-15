<?php 
		echo $this->data['nonce']; 
?>	
		<div class="to">
			<div class="ui-tabs">
				<ul>
					<li><a href="#meta-box-tax-rate-1"><?php esc_html_e('General','car-park-booking-system'); ?></a></li>
				</ul>
				<div id="meta-box-tax-rate-1">
					<ul class="to-form-field-list">
						<?php echo CPBSHelper::createPostIdField(__('Tax rate ID','car-park-booking-system')); ?>
						<li>
							<h5><?php esc_html_e('Value','car-park-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Percentage value of tax rate. Floating point values are allowed, up to two decimal places in the range 0-100.','car-park-booking-system'); ?></span>
							<div>
								<input type="text" maxlength="5" name="<?php CPBSHelper::getFormName('tax_rate_value'); ?>" id="<?php CPBSHelper::getFormName('tax_rate_value'); ?>" value="<?php echo esc_attr($this->data['meta']['tax_rate_value']); ?>"/>
							</div>
						</li>  
						<li>
							<h5><?php esc_html_e('Default tax rate','car-park-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('Mark this tax rate as default.','car-park-booking-system'); ?><br/>
								<?php esc_html_e('Default value means, that this tax rate will be pre-selected during adding new items (e.g space types, pricing rules) in the dashboard.','car-park-booking-system'); ?><br/>
								<?php esc_html_e('You can have only one default tax rate in the same time. If the other rate is selected as default, its selection will be removed after saving.','car-park-booking-system'); ?>
							</span>
							<div class="to-radio-button">
								<input type="radio" value="1" id="<?php CPBSHelper::getFormName('tax_rate_default_1'); ?>" name="<?php CPBSHelper::getFormName('tax_rate_default'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['tax_rate_default'],1); ?>/>
								<label for="<?php CPBSHelper::getFormName('tax_rate_default_1'); ?>"><?php esc_html_e('Yes','car-park-booking-system'); ?></label>
								<input type="radio" value="0" id="<?php CPBSHelper::getFormName('tax_rate_default_0'); ?>" name="<?php CPBSHelper::getFormName('tax_rate_default'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['tax_rate_default'],0); ?>/>
								<label for="<?php CPBSHelper::getFormName('tax_rate_default_0'); ?>"><?php esc_html_e('No','car-park-booking-system'); ?></label>
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