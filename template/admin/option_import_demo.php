		<ul class="to-form-field-list">
			<li>
				<h5><?php esc_html_e('Import demo','car-park-booking-system'); ?></h5>
				<span class="to-legend">
					<?php esc_html_e('To import demo content, click on below button.','car-park-booking-system'); ?><br/>
					<?php esc_html_e('You should run this function only once (the same content will be created when you run it once again).','car-park-booking-system'); ?><br/>
					<?php esc_html_e('This operation takes a few minutes. This operation is not reversible.','car-park-booking-system'); ?><br/>
				</span>
				<input type="button" name="<?php CPBSHelper::getFormName('import_dummy_content'); ?>" id="<?php CPBSHelper::getFormName('import_dummy_content'); ?>" class="to-button to-margin-0" value="<?php esc_attr_e('Import','car-park-booking-system'); ?>"/>
			</li>
		</ul>
<?php
		CPBSHelper::addInlineScript('cpbs-admin',
		'
			jQuery(document).ready(function($)
			{
				$(\'#'.CPBSHelper::getFormName('import_dummy_content',false).'\').bind(\'click\',function(e) 
				{
					e.preventDefault();
					$(\'#action\').val(\''.PLUGIN_CPBS_CONTEXT.'_option_page_import_demo\');
					$(\'#to_form\').submit();
					$(\'#action\').val(\''.PLUGIN_CPBS_CONTEXT.'_option_page_save\');
				});
			});
		');