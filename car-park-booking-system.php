<?php
/* 
Plugin Name: Car Park Booking System for WordPress
Plugin URI: https://1.envato.market/car-park-booking-system-for--wordpress
Description: Car Park Booking System is a powerful online reservation WordPress plugin which provides all the tools and features needed to run your parking lot business. It provides a simple, step-by-step booking process with online payments, e-mail and sms notifications, WooCommerce and Google Calendar integration and an intuitive backend administration. 
Author: QuanticaLabs
Version: 2.7
Author URI: https://1.envato.market/car-park-booking-system-for-wordpress
*/

load_plugin_textdomain('car-park-booking-system',false,dirname(plugin_basename(__FILE__)).'/languages/');

require_once('include.php');

$Plugin=new CPBSPlugin();
$WooCommerce=new CPBSWooCommerce();

register_activation_hook(__FILE__,array($Plugin,'pluginActivation'));

add_action('init',array($Plugin,'init'));
add_action('after_setup_theme',array($Plugin,'afterSetupTheme'));
add_filter('woocommerce_locate_template',array($WooCommerce,'locateTemplate'),1,3);

$WidgetBookingForm=new CPBSWidgetBookingForm();
$WidgetBookingForm->register();