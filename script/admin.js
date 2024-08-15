/******************************************************************************/
/******************************************************************************/

;(function($,doc,win) 
{
	"use strict";
    
    /**************************************************************************/
    
    if(parseInt(cpbsData.jqueryui_buttonset_enable,10)!==1)
    {
        $('.to .to-radio-button,.to .to-checkbox-button').addClass('to-jqueryui-buttonset-disable');
    }
    
    /**************************************************************************/
    
    var $GET=[];
    
    document.location.search.replace(/\??(?:([^=]+)=([^&]*)&?)/g,function() 
    {
        function decode(s) 
        {
            return(decodeURIComponent(s.split('+').join(' ')));
        }
        $GET[decode(arguments[1])]=decode(arguments[2]);
    });
        
    /**************************************************************************/
    
    var menu=$('#menu-posts-cpbs_booking .wp-menu-name');
    if(menu.text()==='Car Park Booking System')
        menu.html('Car Park<br/>Booking System');
	
    $('.wp-submenu a').each(function() 
	{
		if($(this).text()==='Car Park Booking System')
			$(this).html('Car Park<br/>Booking System');	
	});
	
    /**************************************************************************/
    
})(jQuery,document,window);

/******************************************************************************/