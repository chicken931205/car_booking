<?php	
		global $post;

		$Validation=new CPBSValidation();

		$class=array('cpbs-main','cpbs-booking-form-id-'.$this->data['booking_form_post_id'],'cpbs-google-map-enable-'.(int)$this->data['google_map_enable'],'cpbs-location-field-enable-'.(int)$this->data['location_field_enable'],'cpbs-clear-fix','cpbs-hidden');

		if($this->data['widget_mode']==1)
			array_push($class,'cpbs-booking-form-widget-mode','cpbs-booking-form-widget-mode-style-'.$this->data['widget_booking_form_style_id']);
?>
		<div<?php echo CPBSHelper::createCSSClassAttribute($class); ?> id="<?php echo esc_attr($this->data['booking_form_html_id']); ?>">
			<form name="cpbs-form" enctype="multipart/form-data">
<?php
		if(($this->data['widget_mode']!=1) && ((int)$this->data['meta']['navigation_top_enable']===1))
		{
?>
					<div class="cpbs-main-navigation-default cpbs-clear-fix" data-step-count="<?php echo esc_attr(count($this->data['step']['dictionary'])); ?>">
						<ul class="cpbs-list-reset">
<?php
			foreach($this->data['step']['dictionary'] as $index=>$value)
			{
				$class=array();
				if($index==1) array_push($class,'cpbs-state-selected');
?>		   
								<li data-step="<?php echo esc_attr($index); ?>"<?php echo CPBSHelper::createCSSClassAttribute($class); ?> >
									<div></div>
									<a href="#">
										<span>
											<span><?php echo esc_html($value['navigation']['number']); ?></span>
											<span class="cpbs-meta-icon-tick"></span>
										</span>
										<span><?php echo esc_html($value['navigation']['label']); ?></span>
									</a>
								</li>	   
<?php		  
			}
?>
						</ul>
					</div>
					<div class="cpbs-main-navigation-responsive cpbs-clear-fix">
						<div class="cpbs-form-field">
							<select name="<?php CPBSHelper::getFormName('navigation_responsive'); ?>" data-value="1">
<?php
			foreach($this->data['step']['dictionary'] as $index=>$value)
			{
?>			
									<option value="<?php echo esc_attr($index); ?>">
										<?php echo esc_html($value['navigation']['number'].'. '.$value['navigation']['label']); ?>
									</option>	   
<?php		  
			}		  
?>				
							</select>
						</div>
					</div>
<?php
		}
?>
				<div class="cpbs-main-content cpbs-clear-fix">
<?php
		for($i=1;$i<=($this->data['widget_mode']===1 ? 1 : 5);$i++)
		{
?> 
						<div class="cpbs-main-content-step-<?php echo esc_attr($i); ?>">
<?php
			$Template=new CPBSTemplate($this->data,PLUGIN_CPBS_TEMPLATE_PATH.'public/public-step-'.$i.'.php');
			echo $Template->output();
?>
						</div>
<?php
		}
?>
				</div>

				<input type="hidden" name="action" data-value=""/>

				<input type="hidden" name="<?php CPBSHelper::getFormName('step'); ?>" data-value="1"/>
				<input type="hidden" name="<?php CPBSHelper::getFormName('step_request'); ?>" data-value="1"/>

				<input type="hidden" name="<?php CPBSHelper::getFormName('place_type_id'); ?>" data-value="0"/>
				<input type="hidden" name="<?php CPBSHelper::getFormName('payment_id'); ?>" data-value=""/>
				<input type="hidden" name="<?php CPBSHelper::getFormName('booking_extra_id'); ?>" data-value="0"/>

				<input type="hidden" name="<?php CPBSHelper::getFormName('booking_form_id'); ?>" data-value="<?php echo esc_attr($this->data['booking_form_post_id']); ?>"/>

				<input type="hidden" name="<?php CPBSHelper::getFormName('post_id'); ?>" data-value="<?php echo esc_attr($post->ID); ?>"/>

				<input type="hidden" name="<?php CPBSHelper::getFormName('currency'); ?>" data-value="<?php echo esc_attr($this->data['currency']); ?>"/>

			</form>

			<div id="cpbs-payment-form">
<?php
		foreach($this->data['dictionary']['location'] as $index=>$value)
		{
			if(in_array(3,$value['meta']['payment_id']))
			{
				$PaymentPaypal=new CPBSPaymentPaypal();
				echo $PaymentPaypal->createPaymentForm($post->ID,$index,$value);
			}
		}
?>  
			</div>

<?php
		if((int)$this->data['meta']['form_preloader_enable']===1)
		{
?>
				<div id="cpbs-preloader"></div>
<?php
		}
?>

			<div id="cpbs-preloader-start"></div>
<?php
		foreach($this->data['dictionary']['location'] as $index=>$value)
		{
?>
				<div class="cpbs-location-info-frame" data-location_id="<?php echo esc_attr($index); ?>"> 

					<div>

						<div class="cpbs-layout-50x50 cpbs-clear-fix">

							<div class="cpbs-layout-column-left cpbs-location-info-frame-name">

								<div class="cpbs-header cpbs-header-style-2"><?php echo esc_html($value['post']->post_title); ?></div>
								<div>
<?php 
			$address=array();

			$address['street']=$value['meta']['address_street'];
			$address['street_number']=$value['meta']['address_street_number'];
			$address['postcode']=$value['meta']['address_postcode'];
			$address['city']=$value['meta']['address_city'];
			$address['state']=null;
			$address['country']=null;

			echo CPBSHelper::displayAddress($address); 
?>
								</div>

							</div>

							<div class="cpbs-layout-column-right cpbs-location-info-frame-place-type">
								<div class="cpbs-list">
<?php
			$placeType=$this->data['dictionary']['location_place'][$index];

			foreach($placeType as $placeTypeIndex=>$placeTypeValue)
			{
				$placeTypeDictionary=$this->data['dictionary']['place_type'][$placeTypeIndex];

				if(is_array($placeTypeDictionary))
				{
					echo 
					'
						<div class="cpbs-list-item">
							<div'.CPBSHelper::createStyleAttribute(array('background-color'=>'#'.$placeTypeDictionary['meta']['color'])).'>
								<span class="cpbs-feature-icon-'.$placeTypeDictionary['meta']['icon'].'"></span>
								<div>
									<span>'.esc_html($placeTypeDictionary['post']->post_title).'</span>
									<span>'.sprintf(esc_html__('%s spaces','car-park-booking-system'),$placeType[$placeTypeIndex]['place_all']).'</span>
								</div>
							</div>
						</div>
					';
				}
			}
?>		
								</div>
							</div>	
						</div>
<?php
			$thumbnail=get_the_post_thumbnail($value['post'],'full');
			if($Validation->isNotEmpty($thumbnail))
			{
?>
							<div class="cpbs-location-info-frame-image">
								<?php echo $thumbnail; ?>
							</div>
<?php
			}
?>

						<div class="cpbs-layout-50x25x25">

							<div class="cpbs-layout-column-left cpbs-location-info-frame-description">
								<?php echo $value['post']->post_content; ?>
							</div>

							<div class="cpbs-layout-column-center cpbs-location-info-frame-contact-detail">
								<label><?php esc_html_e('Contact','car-park-booking-system'); ?></label>
<?php
			if($Validation->isNotEmpty($value['meta']['contact_detail_phone_number']))
				echo '<div>'.sprintf(esc_html__('Phone: %s','car-park-booking-system'),$value['meta']['contact_detail_phone_number']).'</div>';
			if($Validation->isNotEmpty($value['meta']['contact_detail_fax_number']))
				echo '<div>'.sprintf(esc_html__('Fax: %s','car-park-booking-system'),$value['meta']['contact_detail_fax_number']).'</div>';
			if($Validation->isNotEmpty($value['meta']['contact_detail_email_address']))
				echo '<div><a href="'.esc_attr($value['meta']['contact_detail_email_address']).'">'.esc_html($value['meta']['contact_detail_email_address']).'</a></div>';
?>
							</div>	

							<div class="cpbs-layout-column-right cpbs-location-info-frame-business-hour">
								<label><?php esc_html_e('Business hours','car-park-booking-system'); ?></label>
								<?php echo CPBSHelper::displayBusinessHour($value['meta']['business_hour']);  ?>
							</div>	

						</div>

					</div>

				</div>
<?php
		}
?>
		</div>
<?php
		CPBSHelper::addInlineScript('cpbs-booking-form',
		'
			jQuery(document).ready(function($)
			{			
				$(\'#'.esc_attr($this->data['booking_form_html_id']).'\').CPBSBookingForm(
				{
					booking_form_id: \''.$this->data['booking_form_post_id'].'\',
					plugin_version: \''.PLUGIN_CPBS_VERSION.'\',
					widget:
					{
						mode: '.(int)$this->data['widget_mode'].',
						booking_form_url: \''.$this->data['widget_booking_form_url'].'\'
					},
					ajax_url: \''.$this->data['ajax_url'].'\',
					plugin_url: \''.PLUGIN_CPBS_URL.'\',
					time_format: \''.CPBSOption::getOption('time_format').'\',
					date_format: \''.CPBSOption::getOption('date_format').'\',
					date_format_js: \''.CPBSJQueryUIDatePicker::convertDateFormat(CPBSOption::getOption('date_format')).'\',
					timepicker_step: \''.$this->data['meta']['timepicker_step'].'\',
					summary_sidebar_sticky_enable: '.$this->data['meta']['summary_sidebar_sticky_enable'].',
					location_id: '.(int)$this->data['location_id'].',
					location_date_exclude:	'.json_encode($this->data['location_date_exclude']).',
					location_business_hour: 
					{
						entry:'.json_encode($this->data['location_business_hour']['entry']).',
						exit:'.json_encode($this->data['location_business_hour']['exit']).'
					},
					location_entry_period: '.json_encode($this->data['location_entry_period'],JSON_UNESCAPED_SLASHES).',
					location_entry_period_format: '.json_encode($this->data['location_entry_period_format'],JSON_UNESCAPED_SLASHES).',
					location_coordinate: '.json_encode($this->data['location_coordinate']).',
					location_payment_paypal_redirect_duration: '.json_encode($this->data['location_payment_paypal_redirect_duration']).',
					location_detail_window_open_action: '.json_encode($this->data['meta']['location_detail_window_open_action']).',
					client_coordinate: '.json_encode($this->data['client_coordinate']).',   
					geolocation_enable: '.json_encode($this->data['meta']['geolocation_enable']).',
					gooogleMapOption:
					{	
						scrollwheel:
						{
							enable: '.(int)$this->data['meta']['google_map_scrollwheel_enable'].'
						},
						draggable:
						{
							enable:false
						},
						mapControl:
						{
							enable: false,
							id: \''.$this->data['meta']['google_map_map_type_control_id'].'\'
						},
						zoomControl:
						{
							enable: false,
							level: '.(int)$this->data['meta']['google_map_zoom_control_level'].'							
						},
						style: '.($Validation->isEmpty($this->data['meta']['google_map_style']) ? '\'[]\'': $this->data['meta']['google_map_style']).'
					},
					booking_form_color: '.json_encode($this->data['booking_form_color']).',
					is_rtl: '.(int)is_rtl().',
					scroll_to_booking_extra_after_select_place_enable: '.(int)$this->data['meta']['scroll_to_booking_extra_after_select_place_enable'].',
					redirect_to_next_step_after_select_place_enable: '.(int)$this->data['meta']['redirect_to_next_step_after_select_place_enable'].',
					second_step_next_button_enable: '.(int)$this->data['meta']['second_step_next_button_enable'].',
					current_date: \''.date_i18n('d-m-Y').'\',
					current_time: \''.date_i18n('H:i').'\'
				}).setup();
			});	
		',2);