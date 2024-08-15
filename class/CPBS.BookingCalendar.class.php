<?php

/******************************************************************************/
/******************************************************************************/

class CPBSBookingCalendar
{
	/**************************************************************************/
	   
	function __construct()
	{
		
	}
	
	/**************************************************************************/
	
	function createHeaderDate($year,$monthName)
	{
		$html=
		'
			<h1>'.esc_html($monthName.' '.$year).'</h1>
			<a href="#">&lt;</a>
			<a href="#">&gt;</a>
		';
		
		return($html);
	}
	
	/**************************************************************************/
	
	function createHeaderLocation()
	{
		$html=null;
		
		/***/
		
		$Location=new CPBSLocation();
		$dictionary=$Location->getDictionary();
		
		/***/
		
		if($dictionary!==false)
		{
			foreach($dictionary as $index=>$value)
				$html.='<option value="'.(int)$index.'">'.esc_html($value['post']->post_title).'</option>';
		}
		
		/***/
		
		$html=
		'
			<select id="'.CPBSHelper::getFormName('booking_calendar_location_id',false).'" name="'.CPBSHelper::getFormName('booking_calendar_location_id',false).'">
				<option value="-1">'.esc_html__('- All locations -','car-park-booking-system').'</option>
				'.$html.'
			</select>
		';
		
		/***/

		return($html);
	}
	
	/**************************************************************************/
	
	function getDate()
	{
		$DateTime=new DateTime();
		$Validation=new CPBSValidation();
		
		/***/
		
		$year=null;
		$month=null;
	
		/***/
		
		$data=CPBSHelper::getPostOption();
		
		if(array_key_exists('booking_calendar_year_number',$data))
			$year=$data['booking_calendar_year_number'];	
		if(array_key_exists('booking_calendar_month_number',$data))
			$month=$data['booking_calendar_month_number'];		
		
		/***/
		
		if(($Validation->isNotEmpty($year)) && ($Validation->isNotEmpty($month)))
			$DateTime->setDate($year,$month,1);
		
		/***/
		
		$response=array();
		
		$response['booking_calendar_year_number']=$DateTime->format('Y');
		$response['booking_calendar_month_number']=$DateTime->format('m');
		$response['booking_calendar_month_name']=$DateTime->format('F');
		
		return($response);
	}

	/**************************************************************************/
	
	function createBookingCalendar($year,$month,$locationId=-1)
	{
		$html=null;
		
		$Date=new CPBSDate();
		$DateTime=new DateTime();
		
		/***/
		
		$booking=$this->getBooking($year,$month,$locationId);
			
		/***/
		
		$tableHeadHtml=null;
		for($i=1;$i<=7;$i++)
			$tableHeadHtml.='<th><div>'.esc_html($Date->day[$i][0]).'</div></th>';
		
		/***/
		
		$cellCounter=0;
		
		$tableCellHtml=null;
		$tableBodyHtml=null;
		
		$DateTime=new DateTime('01-'.$month.'-'.$year);
		
		for($i=1;$i<=31;$i++)
		{
			$dayOfWeekNumber=$DateTime->format('N');
			
			if($i===1)
			{
				for($j=1;$j<$dayOfWeekNumber;$j++) $tableCellHtml.='<td><div></div></td>';
				$cellCounter+=$dayOfWeekNumber-1;
			}
			
			$value=array(0,0,0);
			
			if(isset($booking[(int)$DateTime->format('d')]['entry']['count']))
				$value[0]=(int)$booking[(int)$DateTime->format('d')]['entry']['count'];
			if(isset($booking[(int)$DateTime->format('d')]['exit']['count']))
				$value[1]=(int)$booking[(int)$DateTime->format('d')]['exit']['count'];
			if(isset($booking[(int)$DateTime->format('d')]['ongoing']['count']))
				$value[2]=(int)$booking[(int)$DateTime->format('d')]['ongoing']['count'];
			
			$class=array(null,null,null);
			
			if($value[0]===0) $class[0]=array('to-hidden');
			if($value[1]===0) $class[1]=array('to-hidden');

			if($value[0]!=0) $value[0]='+'.$value[0];
			if($value[1]!=0) $value[1]='-'.$value[1];

			$tableCellHtml.=
			'
				<td>
					<div>
						<div><span>'.$DateTime->format('d').'</span></div>
						<div>
							<div'.CPBSHelper::createCSSClassAttribute($class[0]).'><span>'.$value[0].'</span></div>
							<div'.CPBSHelper::createCSSClassAttribute($class[1]).'><span>'.$value[1].'</span></div>
							<div'.CPBSHelper::createCSSClassAttribute($class[2]).'><span>'.$value[2].'</span></div>
						</div>
					</div>
				</td>
			';
			
			$cellCounter++;
			
			$DateTime->modify('+1 day');
			
			$break=false;
			
			if((int)$DateTime->format('n')!==(int)$month)
			{
				$break=true;
				
				if($cellCounter%7!==0)
				{
					$maxCellCounter=(floor($cellCounter/7)+1)*7;
				
					for($j=$cellCounter;$j<$maxCellCounter;$j++) $tableCellHtml.='<td><div></div></td>';
				
					$cellCounter=$maxCellCounter;
				}
			}
			
			if($cellCounter%7===0)
			{
				$tableBodyHtml.='<tr>'.$tableCellHtml.'</tr>';
				$tableCellHtml=null;
			}
			
			if($break) break;
		}
		
		/***/
		
		$html.=
		'
			<table cellspacing="0px" cellpadding="0px">
				<thead>
					'.$tableHeadHtml.'
				</thead>
				<tbody>
					'.$tableBodyHtml.'
				</tbody>
			</table>
		';
			
		/***/
		
		return($html);
	}
	
	/**************************************************************************/
	
	function getBooking($year,$month,$locationId=-1)
	{
		global $post;
		
		$data=array();
		
		$DateTime=new DateTime('01-'.$month.'-'.$year);
		$DateTime->modify('+1 month');
		
		/***/
		
		$argument=array
		(
			'post_type'=>CPBSBooking::getCPTName(),
			'post_status'=>'publish',
			'posts_per_page'=>-1,
			'suppress_filters'=>true
		);
		
		$query=new WP_Query($argument);	
		if($query===false) return(false);
		
		while($query->have_posts())
		{
			$query->the_post();
			
			$meta=CPBSPostMeta::getPostMeta($post);
			
			$status=CPBSOption::getOption('booking_status_nonblocking');
			if(is_array($status))
			{
				if(in_array($meta['booking_status_id'],$status)) continue;
			}
			
			if($locationId!=-1)
			{
				if((int)$meta['location_id']!==(int)$locationId) continue;
			}
			
			$DateCurrent=new DateTime($meta['entry_date']);
			$DateExit=new DateTime($meta['exit_date']);
			
			$i=0;
			
			while(1)
			{
				$exit=false;
				
				$b=((int)$month===(int)$DateCurrent->format('n')) && ((int)$year===(int)$DateCurrent->format('Y'));
				
				if($i===0)
				{
					if($b)
					{
						$data[$DateCurrent->format('j')]['entry']['detail'][]=array($post->ID);
					}
				}

				if($DateCurrent->format('U')>=$DateExit->format('U'))
				{
					if($b)
					{
						$data[$DateCurrent->format('j')]['exit']['detail'][]=array($post->ID);
						$exit=true;
					}
					break;
				}
				
				if($b && !$exit)
				{
					$data[$DateCurrent->format('j')]['ongoing']['detail'][]=array($post->ID);
				}
			
				$DateCurrent->modify('+1 day');
				
				$i++;
			}
		}	
	
		for($i=1;$i<=31;$i++)
		{
			if(!isset($data[$i])) continue;
			
			if(isset($data[$i]['entry'])) 
				$data[$i]['entry']['count']=count($data[$i]['entry']['detail']);
			if(isset($data[$i]['ongoing'])) 
				$data[$i]['ongoing']['count']=count($data[$i]['ongoing']['detail']);
			if(isset($data[$i]['exit'])) 
				$data[$i]['exit']['count']=count($data[$i]['exit']['detail']);
		}

		return($data);
	}
	
	/**************************************************************************/
	
	function ajax()
	{
		$response=array();
	
		$data=CPBSHelper::getPostOption();
		
		$date=$this->getDate();
		
		$response['calendar']=$this->createBookingCalendar($date['booking_calendar_year_number'],$date['booking_calendar_month_number'],$data['booking_calendar_location_id']);
		
		$response['booking_calendar_header']=$date['booking_calendar_month_name'].' '.$date['booking_calendar_year_number'];
		
		CPBSHelper::createJSONResponse($response);
	}
	
	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/