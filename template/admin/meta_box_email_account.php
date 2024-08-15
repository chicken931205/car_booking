<?php 
		global $post;
		echo $this->data['nonce']; 
?>	
		<div class="to">
			<div class="ui-tabs">
				<ul>
					<li><a href="#meta-box-email-account-1"><?php esc_html_e('Sender','car-park-booking-system'); ?></a></li>
					<li><a href="#meta-box-email-account-2"><?php esc_html_e('SMTP Authentication','car-park-booking-system'); ?></a></li>
					<li><a href="#meta-box-email-account-3"><?php esc_html_e('E-mail Testing','car-park-booking-system'); ?></a></li>
				</ul>
				<div id="meta-box-email-account-1">
					<ul class="to-form-field-list">
						<?php echo CPBSHelper::createPostIdField(__('E-mail account ID','car-park-booking-system')); ?>
						<li>
							<h5><?php esc_html_e('Name','car-park-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Name.','car-park-booking-system'); ?></span>
							<div>
								<input type="text" name="<?php CPBSHelper::getFormName('sender_name'); ?>" id="<?php CPBSHelper::getFormName('sender_name'); ?>" value="<?php echo esc_attr($this->data['meta']['sender_name']); ?>"/>
							</div>
						</li>
						<li>
							<h5><?php esc_html_e('E-mail address','car-park-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('E-mail address.','car-park-booking-system'); ?></span>
							<div>
								<input type="text" name="<?php CPBSHelper::getFormName('sender_email_address'); ?>" id="<?php CPBSHelper::getFormName('sender_email_address'); ?>" value="<?php echo esc_attr($this->data['meta']['sender_email_address']); ?>"/>
							</div>
						</li>
					</ul>
				</div>
				<div id="meta-box-email-account-2">
					<ul class="to-form-field-list">
						<li>
							<h5><?php esc_html_e('Status','car-park-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Enable or disable SMTP Authentication.','car-park-booking-system'); ?></span>
							<div class="to-radio-button">
								<input type="radio" value="1" id="<?php CPBSHelper::getFormName('smtp_auth_enable_1'); ?>" name="<?php CPBSHelper::getFormName('smtp_auth_enable'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['smtp_auth_enable'],1); ?>/>
								<label for="<?php CPBSHelper::getFormName('smtp_auth_enable_1'); ?>"><?php esc_html_e('Enable','car-park-booking-system'); ?></label>
								<input type="radio" value="0" id="<?php CPBSHelper::getFormName('smtp_auth_enable_0'); ?>" name="<?php CPBSHelper::getFormName('smtp_auth_enable'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['smtp_auth_enable'],0); ?>/>
								<label for="<?php CPBSHelper::getFormName('smtp_auth_enable_0'); ?>"><?php esc_html_e('Disable','car-park-booking-system'); ?></label>							
							</div>
						</li>
						<li>
							<h5><?php esc_html_e('Username','car-park-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Username.','car-park-booking-system'); ?></span>
							<div>
								<input type="text" name="<?php CPBSHelper::getFormName('smtp_auth_username'); ?>" id="<?php CPBSHelper::getFormName('smtp_auth_username'); ?>" value="<?php echo esc_attr($this->data['meta']['smtp_auth_username']); ?>"/>
							</div>
						</li>
						<li>
							<h5><?php esc_html_e('Password','car-park-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Password.','car-park-booking-system'); ?></span>
							<div>
								<input type="password" name="<?php CPBSHelper::getFormName('smtp_auth_password'); ?>" id="<?php CPBSHelper::getFormName('smtp_auth_password'); ?>" value="<?php echo esc_attr($this->data['meta']['smtp_auth_password']); ?>"/>
							</div>
						</li>
						<li>
							<h5><?php esc_html_e('Host','car-park-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Host.','car-park-booking-system'); ?></span>
							<div>
								<input type="text" name="<?php CPBSHelper::getFormName('smtp_auth_host'); ?>" id="<?php CPBSHelper::getFormName('smtp_auth_host'); ?>" value="<?php echo esc_attr($this->data['meta']['smtp_auth_host']); ?>"/>
							</div>
						</li>
						<li>
							<h5><?php esc_html_e('Port','car-park-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Port.','car-park-booking-system'); ?></span>
							<div>
								<input type="text" name="<?php CPBSHelper::getFormName('smtp_auth_port'); ?>" id="<?php CPBSHelper::getFormName('smtp_auth_port'); ?>" value="<?php echo esc_attr($this->data['meta']['smtp_auth_port']); ?>"/>
							</div>
						</li>
						<li>
							<h5><?php esc_html_e('Secure connection type','car-park-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Secure connection type.','car-park-booking-system'); ?></span>
							<div class="to-radio-button">
<?php
		foreach($this->data['dictionary']['secure_connection_type'] as $secureConnectionTypeIndex=>$secureConnectionTypeData)
		{
?>
								<input type="radio" value="<?php echo esc_attr($secureConnectionTypeIndex); ?>" id="<?php CPBSHelper::getFormName('smtp_auth_secure_connection_type_'.$secureConnectionTypeIndex); ?>" name="<?php CPBSHelper::getFormName('smtp_auth_secure_connection_type'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['smtp_auth_secure_connection_type'],$secureConnectionTypeIndex); ?>/>
								<label for="<?php CPBSHelper::getFormName('smtp_auth_secure_connection_type_'.$secureConnectionTypeIndex); ?>"><?php echo esc_html($secureConnectionTypeData[0]); ?></label>							
<?php		
		}
?>
							</div>
						</li>
						<li>
							<h5><?php esc_html_e('Debug','car-park-booking-system'); ?></h5>
							<span class="to-legend">
								<?php esc_html_e('Enable or disable debugging.','car-park-booking-system'); ?><br/>
								<?php esc_html_e('You can check result of debugging in Chrome/Firebug console (after submit form).','car-park-booking-system'); ?><br/>
								<?php esc_html_e('Please note that this option should be used for debugging only. Once it is enabled, proper processing booking in last step could not be possible.','car-park-booking-system'); ?>
							</span>
							<div class="to-radio-button">
								<input type="radio" value="1" id="<?php CPBSHelper::getFormName('smtp_auth_debug_enable_1'); ?>" name="<?php CPBSHelper::getFormName('smtp_auth_debug_enable'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['smtp_auth_debug_enable'],1); ?>/>
								<label for="<?php CPBSHelper::getFormName('smtp_auth_debug_enable_1'); ?>"><?php esc_html_e('Enable','car-park-booking-system'); ?></label>							
								<input type="radio" value="0" id="<?php CPBSHelper::getFormName('smtp_auth_debug_enable_0'); ?>" name="<?php CPBSHelper::getFormName('smtp_auth_debug_enable'); ?>" <?php CPBSHelper::checkedIf($this->data['meta']['smtp_auth_debug_enable'],0); ?>/>
								<label for="<?php CPBSHelper::getFormName('smtp_auth_debug_enable_0'); ?>"><?php esc_html_e('Disable','car-park-booking-system'); ?></label>							
							</div>
						</li>
					</ul>
				</div>
				<div id="meta-box-email-account-3">
					<div class="to-notice-small to-notice-small-error">
						<?php esc_html_e('Enter receiver e-mail address and click on below button to send testing e-mail message using details of this account.','car-park-booking-system'); ?>
					</div>
					<ul class="to-form-field-list">
						<li>
							<h5><?php esc_html_e('Receiver e-mail address','car-park-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Receiver e-mail address.','car-park-booking-system'); ?></span>
							<div>
								<input type="text" name="<?php CPBSHelper::getFormName('test_email_receiver_email_address'); ?>" id="<?php CPBSHelper::getFormName('test_email_receiver_email_address'); ?>" value=""/>
							</div>
						</li>
						<li>
							<h5><?php esc_html_e('Response','car-park-booking-system'); ?></h5>
							<span class="to-legend"><?php esc_html_e('Response from the server.','car-park-booking-system'); ?></span>						
							<div class="to-clear-fix">
								<pre class="to-preformatted-text" id="to_email_response"><?php esc_html_e('No reply from the server.','car-park-booking-system'); ?></pre>
								<input type="submit" value="<?php esc_attr_e('Send a message','car-park-booking-system'); ?>" name="<?php CPBSHelper::getFormName('test_email_send'); ?>" class="to-button to-margin-right-0"/>
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

				$(\'input[name="'.CPBSHelper::getFormName('test_email_send',false).'"]\').on(\'click\',function(e)
				{
					e.preventDefault();

					var data={};

					var helper=new CPBSHelper();

					data.action=\''.PLUGIN_CPBS_CONTEXT.'_test_email_send\';
					data.email_account_id='.$post->ID.';
					data.receiver_email_address=$(\'input[name="'.CPBSHelper::getFormName('test_email_receiver_email_address',false).'"]\').val();

					if(helper.isEmpty(data.receiver_email_address))
					{
						alert(\''.esc_html__('Please enter receiver e-mail address.','car-park-booking-system').'\');
						$(\'input[name="'.CPBSHelper::getFormName('test_email_receiver_email_address',false).'"]\').focus();
					}
					else
					{
						$(\'.to\').block({message:false,overlayCSS:{opacity:\'0.3\'}});

						$(\'#to_email_response\').html(\''.esc_html__('No reply from the server.','car-park-booking-system').'\');

						$.post(ajaxurl,data,function(response) 
						{		
							$(\'.to\').unblock({onUnblock:function()
							{ 
								if(parseInt(response.error,10)===1)
								{
									alert(response.error_message);
								}
								else
								{
									if(new String(response.email_response)!==\'undefined\')
										$(\'#to_email_response\').html(response.email_response);
								}
							}});

						},\'json\');
					}
				});
			});			
		');