<?php
		$Date=new CPBSDate();
		$Validation=new CPBSValidation();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
<?php
		if(is_rtl())
		{
?>
			<style>
				body
				{
					direction:rtl;
				}
			</style>
<?php		
		}
?>
	</head>
	
	<body>
		<table cellspacing="0" cellpadding="0" width="100%" bgcolor="#EEEEEE" <?php echo $this->data['style']['base']; ?>>
			<tr height="50px"><td></td></tr>
			<tr>
				<td>
					<table cellspacing="0" cellpadding="0" width="600px" border="0" align="center" bgcolor="#FFFFFF" <?php echo $this->data['style']['table']; ?>>
<?php
		$logo=CPBSOption::getOption('logo');
		if($Validation->isNotEmpty($logo))
		{
?>
							<tr>
								<td>
									<img <?php echo $this->data['style']['image']; ?> src="<?php echo esc_attr($logo); ?>" alt=""/>
									<br/><br/>
								</td>
							</tr>						   
<?php
		}
		
		$i=0;
		foreach($this->data['booking'] as $index=>$value)
		{
?>
							<tr>
								<td <?php echo $this->data['style']['header']; ?>><?php echo esc_html($value['post']->post_title); ?></td>
							</tr>
							<tr><td <?php echo $this->data['style']['separator'][3]; ?>><td></tr>
							<tr>
								<td>
									<table cellspacing="0" cellpadding="0">
										<tr>
											<td <?php echo $this->data['style']['cell'][1]; ?>><?php esc_html_e('Location','car-park-booking-system'); ?></td>
											<td <?php echo $this->data['style']['cell'][2]; ?>><?php echo esc_html($value['meta']['location_name']); ?></td>
										</tr>	
										<tr>
											<td <?php echo $this->data['style']['cell'][1]; ?>><?php esc_html_e('Space type','car-park-booking-system'); ?></td>
											<td <?php echo $this->data['style']['cell'][2]; ?>><?php echo esc_html($value['meta']['place_type_name']); ?></td>
										</tr>	
										<tr>
											<td <?php echo $this->data['style']['cell'][1]; ?>><?php esc_html_e('Entry date and time','car-park-booking-system'); ?></td>
											<td <?php echo $this->data['style']['cell'][2]; ?>><?php echo esc_html($Date->formatDateToDisplay($value['meta']['entry_date']).' '.$Date->formatTimeToDisplay($value['meta']['entry_time'])); ?></td>
										</tr>	
										<tr>
											<td <?php echo $this->data['style']['cell'][1]; ?>><?php esc_html_e('Exit date and time','car-park-booking-system'); ?></td>
											<td <?php echo $this->data['style']['cell'][2]; ?>><?php echo esc_html($Date->formatDateToDisplay($value['meta']['exit_date']).' '.$Date->formatTimeToDisplay($value['meta']['exit_time'])); ?></td>
										</tr>
										<tr>
											<td <?php echo $this->data['style']['cell'][1]; ?>><?php esc_html_e('First name','car-park-booking-system'); ?></td>
											<td <?php echo $this->data['style']['cell'][2]; ?>><?php echo esc_html($value['meta']['client_contact_detail_first_name']); ?></td>
										</tr>
										<tr>
											<td <?php echo $this->data['style']['cell'][1]; ?>><?php esc_html_e('Last name','car-park-booking-system'); ?></td>
											<td <?php echo $this->data['style']['cell'][2]; ?>><?php echo esc_html($value['meta']['client_contact_detail_last_name']); ?></td>
										</tr>
										<tr>
											<td <?php echo $this->data['style']['cell'][1]; ?>><?php esc_html_e('E-mail address','car-park-booking-system'); ?></td>
											<td <?php echo $this->data['style']['cell'][2]; ?>><?php echo esc_html($value['meta']['client_contact_detail_email_address']); ?></td>
										</tr>
										<tr>
											<td <?php echo $this->data['style']['cell'][1]; ?>><?php esc_html_e('Phone number','car-park-booking-system'); ?></td>
											<td <?php echo $this->data['style']['cell'][2]; ?>><?php echo esc_html($value['meta']['client_contact_detail_phone_number']); ?></td>
										</tr>
									</table>
								</td>
							</tr>
<?php
			if((++$i)!==count($this->data['booking']))
			{
?>
							<tr><td <?php echo $this->data['style']['separator'][2]; ?>><td></tr>
<?php
			}
		}
?>
					</table>
				</td>
			</tr>
			<tr height="50px"><td></td></tr>
		</table> 
	</body>
</html>