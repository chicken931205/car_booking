
/******************************************************************************/
/******************************************************************************/

function CPBSBookingCalendar()
{
	/**************************************************************************/

	this.sendRequest=function()
	{
		var data={};

		data.action='cpbs_booking_calendar_ajax';
					
		data.cpbs_booking_calendar_year_number=jQuery('input[name="cpbs_booking_calendar_year_number"]').val();
		data.cpbs_booking_calendar_month_number=jQuery('input[name="cpbs_booking_calendar_month_number"]').val();
		
		data.cpbs_booking_calendar_location_id=jQuery('select[name="cpbs_booking_calendar_location_id"]').val();
		
		jQuery('.to').block({message:false,overlayCSS:{opacity:'0.3'}});

		jQuery.post(ajaxurl,data,function(response) 
		{		
			jQuery('.to').unblock({onUnblock:function()
			{ 
				jQuery('.to-booking-calendar-table').html(response.calendar);
				jQuery('.to-booking-calendar-header>div>h1').html(response.booking_calendar_header);
			}});

		},'json');
	};
	
	/**************************************************************************/
	
	this.increaseMonthNumber=function(step)
	{
		var month=parseInt(jQuery('input[name="cpbs_booking_calendar_month_number"]').val(),10);
		
		month+=step;
		
		jQuery('input[name="cpbs_booking_calendar_month_number"]').val(month);
	};

    /**************************************************************************/
};

/******************************************************************************/
/******************************************************************************/