<?php

/******************************************************************************/
/******************************************************************************/

$Currency=new CPBSCurrency();
$BookingForm=new CPBSBookingForm();
$VisualComposer=new CPBSVisualComposer();

vc_map
( 
    array
    (
        'base'=>CPBSBookingForm::getShortcodeName(),
        'name'=>esc_html__('Car Park Booking Form','car-park-booking-system'),
        'description'=>esc_html__('Displays booking from.','car-park-booking-system'), 
        'category'=>esc_html__('Content','car-park-booking-system'),  
        'params'=>array
        (   
            array
            (
                'type'=>'dropdown',
                'param_name'=>'booking_form_id',
                'heading'=>esc_html__('Booking form','car-park-booking-system'),
                'description'=>esc_html__('Select booking form which has to be displayed.','car-park-booking-system'),
                'value'=>$VisualComposer->createParamDictionary($BookingForm->getDictionary()),
                'admin_label'=>true
            ),
            array
            (
                'type'=>'dropdown',
                'param_name'=>'currency',
                'heading'=>esc_html__('Currency','car-park-booking-system'),
                'description'=>esc_html__('Select currency of booking form.','car-park-booking-system'),
                'value'=>$VisualComposer->createParamDictionary($Currency->getCurrency()),
                'admin_label'=>true
            )  
        )
    )
);  