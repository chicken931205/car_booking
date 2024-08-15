<?php	
		global $post;

		$Validation=new CPBSValidation();

		$class=array('cpbs-main','cpbs-booking-form-id-'.$this->data['booking_form_id'],'cpbs-booking-summary-page','cpbs-clear-fix');
?>
		<div<?php echo CPBSHelper::createCSSClassAttribute($class); ?>>
			
			<form name="cpbs-form" enctype="multipart/form-data" method="POST">
				
				<div>
					<input type="submit" value="<?php esc_attr_e('Download PDF','car-park-booking-system'); ?>" class="cpbs-button cpbs-button-style-1"/>
				</div>
				
				<br/><br/>
				
				<?php echo $this->data['email_body']; ?>
				
				<input type="hidden" name="<?php CPBSHelper::getFormName('access_token'); ?>" value="<?php echo esc_attr($this->data['access_token']); ?>"/>
				
				<input type="hidden" name="<?php CPBSHelper::getFormName('booking_id'); ?>" value="<?php echo esc_attr($this->data['booking_id']); ?>"/>
				<input type="hidden" name="<?php CPBSHelper::getFormName('booking_form_id'); ?>" value="<?php echo esc_attr($this->data['booking_form_id']); ?>"/>
				
			</form>
			
		</div>
<?php
		CPBSHelper::addInlineScript('cpbs-booking-form',
		'
			jQuery(document).ready(function($)
			{
				var Helper=new CPBSHelper();
				Helper.setWidthClass($(".cpbs-booking-summary-page"),true);
			});
		');
