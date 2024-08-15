<?php
		$BookingFormElement=new CPBSBookingFormElement();
?>
		<div class="cpbs-layout-25x75 cpbs-clear-fix">
		<div class="cpbs-layout-column-left"></div>
		<div class="cpbs-layout-column-right">
			<div class="cpbs-notice cpbs-hidden"></div>
			<div class="cpbs-client-form"></div>
<?php
		if((int)$this->data['meta']['booking_extra_step_3_enable']===1)
		{
?>
				<div class="cpbs-booking-extra"></div>
<?php
		}
?>
			<div id="cpbs-payment"></div>
			<?php echo $BookingFormElement->createAgreement($this->data['meta']); ?>
			</div>   
		</div>
		<div class="cpbs-clear-fix cpbs-main-content-navigation-button">
			<a href="#" class="cpbs-button cpbs-button-style-2 cpbs-button-step-prev">
				<span class="cpbs-meta-icon-arrow-horizontal"></span>
				<?php echo esc_html($this->data['step']['dictionary'][3]['button']['prev']); ?>
			</a> 
			<a href="#" class="cpbs-button cpbs-button-style-1 cpbs-button-step-next">
				<?php echo esc_html($this->data['step']['dictionary'][3]['button']['next']); ?>
				<span class="cpbs-meta-icon-arrow-horizontal"></span>
			</a> 
		</div>