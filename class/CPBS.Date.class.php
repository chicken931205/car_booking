<?php

/******************************************************************************/
/******************************************************************************/

class CPBSDate
{
	/**************************************************************************/
	
	function __construct()
	{
		$this->day=array();
		
		for($i=1;$i<8;$i++)
		{
			$this->day[$i]=array(date_i18n('l',strtotime('0'.$i.'-04-2013')));
		}
	}
	
	/**************************************************************************/
	
	function isDay($day)
	{
		return(isset($this->day[$day]));
	}
	
	/**************************************************************************/
	
	function getDayName($number)
	{
		return($this->day[$number][0]);
	}
	
	/**************************************************************************/
	
	function compareTime($time1,$time2)
	{
		$time1=array_map('intval',preg_split('/:/',$time1));
		$time2=array_map('intval',preg_split('/:/',$time2));

		if($time1[0]>$time2[0]) return(1);

		if($time1[0]==$time2[0])
		{
			if($time1[1]>$time2[1]) return(1);
			if($time1[1]==$time2[1]) return(0);
		}
		
		return(2);
	}
	
	/**************************************************************************/
	
	function compareDate($date1,$date2)
	{
		$date1=strtotime($date1);
		$date2=strtotime($date2);
		
		if($date1-$date2==0) return(0);
		if($date1-$date2>0) return(1);
		if($date1-$date2<0) return(2);
	}
	
	/**************************************************************************/
	
	function reverseDate($date)
	{
		$Validation=new CPBSValidation();
		
		if($Validation->isEmpty($date)) return('');
		
		$date=preg_split('/-/',$date);
		return($date[2].'-'.$date[1].'-'.$date[0]);
	}
	
	/**************************************************************************/
	
	function dateInRange($date1,$date2,$date3)
	{
	   return((in_array($this->compareDate($date1,$date2),array(0,1))) && (in_array($this->compareDate($date1,$date3),array(0,2))));
	}
	
	/**************************************************************************/
	
	function timeInRange($time1,$time2,$time3)
	{
	   return((in_array($this->compareTime($time1,$time2),array(0,1))) && (in_array($this->compareTime($time1,$time3),array(0,2))));
	}
  
	/**************************************************************************/

	function getDayNumberOfWeek($date)
	{
		return(date_i18n('N',strtotime($date)));
	}
	
	/**************************************************************************/
	
	function formatTime($time)
	{
		return(number_format($time,2,':',''));
	}
	
	/**************************************************************************/
	
	function formatMinuteToTime($minute)
	{
		$hour=floor($minute/60);
		$minute=($minute%60);
		
		if(strlen($hour)==1) $hour='0'.$hour;
		if(strlen($minute)==1) $minute='0'.$minute;
		
		return($hour.':'.$minute);
	}
	
	/**************************************************************************/
	
	function formatDateToStandard($date)
	{
		$Validation=new CPBSValidation();
		if($Validation->isEmpty($date)) return('');
        
        $date=date_create_from_format(CPBSOption::getOption('date_format'),$date);
        if($date===false) return('');
		
		return(date_format($date,'d-m-Y'));
	}
	
	/**************************************************************************/
	
	function formatDateToDisplay($date,$sourceFormat='d-m-Y')
	{
		$Validation=new CPBSValidation();
		if($Validation->isEmpty($date)) return('');
		
        $date=date_create_from_format($sourceFormat,$date);
        if($date===false) return('');
        
		return(date_format($date,CPBSOption::getOption('date_format')));
	}
	
	/**************************************************************************/
	
	function formatTimeToStandard($time)
	{
		$Validation=new CPBSValidation();
		if($Validation->isEmpty($time)) return('');
		
		if(($index=strpos($time,' - '))!==false)
			$time=substr($time,0,$index);
		
		if($Validation->isTime($time)) return($time);
        
        $time=date_create_from_format(CPBSOption::getOption('time_format'),$time);
        if($time===false) return('');
        
		return(date_format($time,'H:i'));
	}
	
	/**************************************************************************/
	
	function formatTimeToDisplay($time,$sourceFormat='H:i')
	{
		$Validation=new CPBSValidation();
		if($Validation->isEmpty($time)) return('');
		
		$time=date_create_from_format($sourceFormat,$time);
		if($time===false) return('');
		
		return(date_format($time,CPBSOption::getOption('time_format')));
	}
	
    /**************************************************************************/
    
    static function getNow()
    {
        return(strtotime(date_i18n('d-m-Y H:i')));
    }
	
    /**************************************************************************/
    
    static function strtotime($time)
    {
        return(strtotime($time,self::getNow()));
    }
	
	/**************************************************************************/
	
	static function fillTime($time,$zeroCount=2)
	{
		$Validation=new CPBSValidation();
		
		if($Validation->isEmpty($time)) return;
		
		if(!preg_match('/\:/',$time)) $time.=':';
		
		$tTime=array_map('intval',preg_split('/:/',$time));
		
		$tTime[0]=str_pad($tTime[0],$zeroCount,'0',STR_PAD_LEFT); 
		$tTime[1]=str_pad($tTime[1],2,'0',STR_PAD_LEFT); 
		
		return($tTime[0].':'.$tTime[1]);
	}
	
	/**************************************************************************/
	
	static function convertTimeDurationToMinute($timeDuration)
	{
		$timeDuration=self::fillTime($timeDuration);
		
		$timeDuration=preg_split('/:/',$timeDuration);
		
		return(($timeDuration[0]*60)+$timeDuration[1]);
	}
	
	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/