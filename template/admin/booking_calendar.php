
		<div class="to">
			
			<div class="to-booking-calendar">
				
				<div class="to-booking-calendar-header">
					<div><?php echo $this->data['header_date']; ?> </div>
					<div><?php echo $this->data['header_location']; ?> </div>
				</div>
				
				<div class="to-booking-calendar-table">
					<?php echo $this->data['calendar']; ?>
				</div>
				
				<input type="hidden" name="<?php CPBSHelper::getFormName('booking_calendar_year_number'); ?>" value="<?php echo (int)$this->data['booking_calendar_year_number']; ?>"/>
				<input type="hidden" name="<?php CPBSHelper::getFormName('booking_calendar_month_number'); ?>" value="<?php echo (int)$this->data['booking_calendar_month_number']; ?>"/>

			</div>

		</div>
<?php
		CPBSHelper::addInlineScript('cpbs-admin',
		'
			jQuery(document).ready(function($)
			{
				$(\'.to\').themeOptionElement({init:true});
				
				$(\'#'.CPBSHelper::getFormName('booking_calendar_location_id',false).'\').on(\'change\',function(e)
				{
					e.preventDefault();

					var BookingCalendar=new CPBSBookingCalendar();
					BookingCalendar.sendRequest();
				});		
				
				$(\'.to-booking-calendar-header>div:first>a:first\').on(\'click\',function(e)
				{
					var BookingCalendar=new CPBSBookingCalendar();
					
					BookingCalendar.increaseMonthNumber(-1);
					BookingCalendar.sendRequest();
				});
				
				$(\'.to-booking-calendar-header>div:first>a:first+a\').on(\'click\',function(e)
				{
					var BookingCalendar=new CPBSBookingCalendar();
					
					BookingCalendar.increaseMonthNumber(1);
					BookingCalendar.sendRequest();
				});
			});	
		');