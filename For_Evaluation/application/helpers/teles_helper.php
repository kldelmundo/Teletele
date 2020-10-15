<?


#---------------------------------------------------#
# OUTSIDE FUNCTIONS
#---------------------------------------------------#
function str_limiter($str,$max)
{
	if (strlen($str) > $max)
	   $str = trim(substr($str, 0, ($max - 3) )) . '...';
	
	return $str;
}


function users_date_format($str){
	
	if(!empty($str)){
			$str = explode('-',$str);
			
			$year      = $str[0];
			$old_month = $str[1];
			$day       = $str[2];
			$new_date  = '';
			
			if(strlen($day) < 2)
			{
				$day = '0'.$day;
			}

			$new_date = $old_month.'/'.$day.'/'.$year;
			
			return $new_date;
	}else{
			return $str;
	}
}

function mysql_date_format($str){

	if(!empty($str)){

			$str = explode('/',$str);
			
			$old_month = $str[0];
			$day 	   = $str[1];
			$year 	   = $str[2];
			
			$new_date = '';
			
			if(strlen($day) < 2)
			{
				$day = '0'.$day;
			}
			
			$new_date = $year.'-'.$old_month.'-'.$day;
			
			return $new_date;
	 }else{
			return $str;	 
	}
}


function green_integer($var)
	{
		if($var > 0 || $var < 0){
			return "<strong>".number_format($var,2)."</strong>";
		}else{
			return number_format($var,2);
		}
	}

function get_last_billing()
{
	$mo = date('m');
	$year = date('Y');
	$day = date('d');
	$lastDayOfMonth = cal_days_in_month(CAL_GREGORIAN,$mo,date('y'));
	if (strtotime(date('Y-m-d')) == strtotime(date('Y-m-d', mktime(0,0,0,$mo,15,$year))))
	{
		return $period = date('Y-m-d', mktime(0,0,0,$mo,15,$year));
	}
	elseif (strtotime(date('Y-m-d')) == strtotime(date('Y-m-d', mktime(0,0,0,$mo,$lastDayOfMonth,$year))))
	{
		return date('Y-m-d', mktime(0,0,0,$mo,$lastDayOfMonth,$year));
	}
	elseif (strtotime(date('Y-m-d')) < strtotime(date('Y-m-d', mktime(0,0,0,$mo,15,$year))))
	{
		$less_mo = strtotime("-1 month", mktime(0,0,0,$mo,$day,$year));
		$last_mo = date('m',$less_mo);
		$yr = date('Y',$less_mo);
		$lastDayOfMonthLastMonth = cal_days_in_month(CAL_GREGORIAN,$last_mo,date('y'));			
		return $period = date('Y-m-d', mktime(0,0,0,$last_mo,$lastDayOfMonthLastMonth,$yr));
	}
	elseif (strtotime(date('Y-m-d')) < strtotime(date('Y-m-d', mktime(0,0,0,$mo,$lastDayOfMonth,$year))))
	{
		return $period = date('Y-m-d', mktime(0,0,0,$mo,15,$year));
	}
}

function get_last_billing_per_date($date)
{
	$mo = date('m',strtotime($date));
	$year = date('Y',strtotime($date));
	$day = date('d',strtotime($date));
	$lastDayOfMonth = cal_days_in_month(CAL_GREGORIAN,$mo,date('y'));
	
	if (strtotime(date('Y-m-d')) == strtotime(date('Y-m-d', mktime(0,0,0,$mo,15,$year))))
	{
		return $period = date('Y-m-d', mktime(0,0,0,$mo,15,$year));
	}
	elseif (strtotime(date('Y-m-d')) == strtotime(date('Y-m-d', mktime(0,0,0,$mo,$lastDayOfMonth,$year))))
	{
		return date('Y-m-d', mktime(0,0,0,$mo,$lastDayOfMonth,$year));
	}
	elseif (strtotime(date('Y-m-d')) < strtotime(date('Y-m-d', mktime(0,0,0,$mo,15,$year))))
	{
		$less_mo = strtotime("-1 month", mktime(0,0,0,$mo,$day,$year));
		$last_mo = date('m',$less_mo);
		$yr = date('Y',$less_mo);
		$lastDayOfMonthLastMonth = cal_days_in_month(CAL_GREGORIAN,$last_mo,date('y'));			
		return $period = date('Y-m-d', mktime(0,0,0,$last_mo,$lastDayOfMonthLastMonth,$yr));
	}
	elseif (strtotime(date('Y-m-d')) < strtotime(date('Y-m-d', mktime(0,0,0,$mo,$lastDayOfMonth,$year))))
	{
		
		return $period = date('Y-m-d', mktime(0,0,0,$mo,15,$year));
	}
	
}

	function last_date($pay_period)
	{
		$date = explode("-",$pay_period);	
						
		$year = $date[0];
		$month = $date[1];
		$day = $date[2];
			
			
		if($day <= 15)
		{
			if($month == 1)
			{
				$month = 13;
				$year--;
			}
			
			$mktime = mktime(0, 0, 0, $month-1, 0, $year);
				
			$lastday = cal_days_in_month(CAL_GREGORIAN,$month-1,$year);
				
			$pay_period = date("Y-m-d", mktime(0, 0, 0, $month-1, $lastday, $year));
		}
		else 
		{
			$pay_period = date("Y-m-d", mktime(0, 0, 0, $month, 15, $year));	
		}
			
		return $pay_period;
	}



function setLength($id)
{			
	if (strlen($id) == 1)
		return "00000".$id;
	elseif (strlen($id) == 2)
		return "0000".$id;
	elseif (strlen($id) == 3)
		return "000".$id;
	elseif (strlen($id) == 4)
		return "00".$id;
	elseif (strlen($id) == 5)
		return "0".$id;
	else
		return $id;
		
}

function nf($var)
{
	return number_format($var,2);
}


function get_next_billing($pay_period)
{
	
	$date = explode("-",$pay_period);	
				
	$year = $date[0];
	$month = $date[1];
	$day = $date[2];
	
	if($day == 15)
		{
		$mktime = mktime(0, 0, 0, $month+1, 0, $year);
		$lastday = strftime("%d",$mktime);
		$pay_period = date("Y-m-d", mktime(0, 0, 0, $month, $lastday, $year));
		}
	else 
		{
		$pay_period = date("Y-m-d", mktime(0, 0, 0, $month+1, 15, $year));	
		}
		
	return $pay_period;
}	

function switch_next_date($pay_period)
	{
	$date = explode("-",$pay_period);	
					
	$year = $date[0];
	$month = $date[1];
	$day = $date[2];
	
	#echo $month;
	
	#echo $year;# = $date[0];
	
	$lastday = cal_days_in_month(CAL_GREGORIAN,$month,$year);	
	if($day == $lastday)
		{
		if ((int)$month == 1)
			{ $year += 1; $month = 12;}
		else
			$month += 1;
		$mktime = mktime(0, 0, 0, $month, 0, $year);
		//$lastday = strftime("%d",$mktime);
		
		if($month == 13)
		{
			$month = 1;
			$year += 1;
		}
		
		$lastday = cal_days_in_month(CAL_GREGORIAN,$month,$year);	
		
		
		$pay_period = date("Y-m-d", mktime(0, 0, 0, $month, 15, $year));
		}
	else 
		{
		$pay_period = date("Y-m-d", mktime(0, 0, 0, $month, $lastday, $year));	
		}
		
	return $pay_period;
	}		
function switch_date($pay_period)
	{
	$date = explode("-",$pay_period);	
					
	$year = $date[0];
	$month = $date[1];
	$day = $date[2];
	
	if($day == 15)
		{
		if ((int)$month == 1)
			{ $year -= 1; $month = 12;}
		else
			$month -= 1;

		$mktime = mktime(0, 0, 0, $month, 0, $year);
		//$lastday = strftime("%d",$mktime);
		$lastday = cal_days_in_month(CAL_GREGORIAN,$month,$year);	
		$pay_period = date("Y-m-d", mktime(0, 0, 0, $month, $lastday, $year));
		}
	else 
		{
		$pay_period = date("Y-m-d", mktime(0, 0, 0, $month, 15, $year));	
		}
		
	return $pay_period;
	}
function chkBilling($curr_date)
	{			
		$mo = date('m', strtotime($curr_date));
		$year = date('Y', strtotime($curr_date));
		$day = date('d', strtotime($curr_date));
		$lastDayOfMonth = cal_days_in_month(CAL_GREGORIAN,$mo,date('y'));	
		
		if (strtotime($curr_date) == strtotime(date('Y-m-d', mktime(0,0,0,$mo,15,$year))))
		{
			$period = date('Y-m-d', mktime(0,0,0,$mo,$lastDayOfMonth,$year));
		}
		elseif (strtotime($curr_date) == strtotime(date('Y-m-d', mktime(0,0,0,$mo,$lastDayOfMonth,$year))))
		{
			 $period = date('Y-m-d', mktime(0,0,0,$mo+1,15,$year));
		}
		elseif (strtotime($curr_date) < strtotime(date('Y-m-d', mktime(0,0,0,$mo,15,$year))))
		{
			$daysDiff = dateDiff(date('Y-m-d', mktime(0,0,0,$mo,15,$year)), date('Y-m-d'));
			$period = date('Y-m-d', mktime(0,0,0,$mo,15,$year));
		}
		elseif (strtotime($curr_date) < strtotime(date('Y-m-d', mktime(0,0,0,$mo,$lastDayOfMonth,$year))))
		{
			$daysDiff = dateDiff(date('Y-m-d', mktime(0,0,0,$mo,$lastDayOfMonth,$year)), date('Y-m-d'));
			$period = date('Y-m-d', mktime(0,0,0,$mo,$lastDayOfMonth,$year));
		}		
		return $period;
	}	
#==============================================================================================================================================
	function getLastBilling()
	{
		$mo = date('m');
		$year = date('Y');
		$day = date('d');
		$lastDayOfMonth = cal_days_in_month(CAL_GREGORIAN,$mo,date('y'));
		if (strtotime(date('Y-m-d')) == strtotime(date('Y-m-d', mktime(0,0,0,$mo,15,$year))))
		{
			return $period = date('Y-m-d', mktime(0,0,0,$mo,15,$year));
		}
		elseif (strtotime(date('Y-m-d')) == strtotime(date('Y-m-d', mktime(0,0,0,$mo,$lastDayOfMonth,$year))))
		{
			return date('Y-m-d', mktime(0,0,0,$mo,$lastDayOfMonth,$year));
		}
		elseif (strtotime(date('Y-m-d')) < strtotime(date('Y-m-d', mktime(0,0,0,$mo,15,$year))))
		{
			$less_mo = strtotime("-1 month", mktime(0,0,0,$mo,$day,$year));
			$last_mo = date('m',$less_mo);
			$yr = date('Y',$less_mo);
			$lastDayOfMonthLastMonth = cal_days_in_month(CAL_GREGORIAN,$last_mo,date('y'));			
			return $period = date('Y-m-d', mktime(0,0,0,$last_mo,$lastDayOfMonthLastMonth,$yr));
		}
		elseif (strtotime(date('Y-m-d')) < strtotime(date('Y-m-d', mktime(0,0,0,$mo,$lastDayOfMonth,$year))))
		{
			
			return $period = date('Y-m-d', mktime(0,0,0,$mo,15,$year));
		}
	}
	
	
function dateDiff($time1, $time2, $precision = 6) {
    // If not numeric then convert texts to unix timestamps
    if (!is_int($time1)) {
      $time1 = strtotime($time1);
    }
    if (!is_int($time2)) {
      $time2 = strtotime($time2);
    }
 	
    $negative = 1;
    
    // If time1 is bigger than time2
    // Then swap time1 and time2
    if ($time1 > $time2) {
      $negative = 0;
      $ttime = $time1;
      $time1 = $time2;
      $time2 = $ttime;
    }
 
    // Set up intervals and diffs arrays
    $intervals = array('year','month');
    $diffs = array();
 
    // Loop thru all intervals
    foreach ($intervals as $interval) {
      // Set default diff to 0
      $diffs[$interval] = 0;
      // Create temp time from time1 and interval
      $ttime = strtotime("+1 " . $interval, $time1);
      // Loop until temp time is smaller than time2
      while ($time2 >= $ttime) {
	$time1 = $ttime;
	$diffs[$interval]++;
	// Create new temp time from time1 and interval
	$ttime = strtotime("+1 " . $interval, $time1);
      }
    }
 
    $count = 0;
    $times = array();
    // Loop thru all diffs
    foreach ($diffs as $interval => $value) {
      // Break if we have needed precission
      if ($count >= $precision) {
	break;
      }
      // Add value and interval 
      // if value is bigger than 0
      if ($value > 0) {
	// Add s if value is not 1
	if ($value != 1) {
	  $interval .= "s";
	}
	// Add value and interval to times array
	$times[] = $value . " " . $interval;
	$count++;
      }
    }
 
    // Return string with times
    $return = implode(", ", $times);
    
    if($negative == 1){
    	return "-$return";
    }else{
    	return $return;
    }
  }
	  
	function getLOS_by_po($start_dt,$po_date)
	{
		list($year,$month,$day) = explode("-",$start_dt);
		
		list($year2,$month2,$day2) = explode("-",$po_date);
		
		$year_diff = $year2 - $year;
		$month_diff = $month2 - $month;
		$day_diff = $day2 - $day;
		
		if($day<=31){
			if ($month_diff < 0) $year_diff--;
			elseif (($month_diff==0) && ($day_diff < 0)) $year_diff--;
		}else{
			$year_diff = 0;
		}
			
		return $year_diff;
	}
	
	
	function mpl_last_billing()
	{
		$sql = <<<SQL
		SELECT DATE(MAX(post_start)) as mpl_date,YEAR(MAX(post_start)) as year1,YEAR(CURDATE()) as year2
		FROM ar_collection_posting_mpl
		WHERE status = 1;	
SQL;
		$query = mysql_query($sql) or die(mysql_error().$sql);
		$row = mysql_fetch_array($query,MYSQL_ASSOC);
		
		if($row['year2'] > $row['year1'] )
		{
			$year = $row['year1'];
		}else{
			$year = 'YEAR(CURDATE()) ';
		}
		
		$sql2 ="SELECT *,CONCAT($year,'-',Benefit_month,'-',15) as mpl_date
				FROM m_employee_benefits
				WHERE Benefit_month >= MONTH('{$row['mpl_date']}')
				ORDER BY Benefit_month
				LIMIT 1";
		$query2 = mysql_query($sql2) or die(mysql_error().$sql2);
		$row2 = mysql_fetch_array($query2,MYSQL_ASSOC);
		
		return $row2['mpl_date'];
	}
	
	function get_mpl_name($date)
	{
		$sql2 ="SELECT *,CONCAT(YEAR(CURDATE()),'-',Benefit_month,'-',15) as mpl_date
				FROM m_employee_benefits
				WHERE Benefit_month = MONTH('$date')
				ORDER BY Benefit_month";
		$query2 = mysql_query($sql2);
		$row2 = mysql_fetch_array($query2,MYSQL_ASSOC);
		
		if($row2['Benefit_month'] == 11){
			return '-13TH Nov';
		}elseif($row2['Benefit_month'] == 12){
			return '-14TH Dec';
		}elseif($row2['Benefit_month'] == 3){
			return '-USL';
		}elseif($row2['Benefit_month'] == 6){
			return '-LGY';
		}elseif($row2['Benefit_month'] == 5){
			return '-MIDYR';
		}elseif($row2['Benefit_month'] == 8){
			return '-MRP';
		}
	}
	
	function get_next_ben_month($date)
	{
		
		if(date('m',strtotime($date)) == 12)
		{
			$year = date('m',strtotime($date))  + 1; 
			return "$year-03-15";
		}
		else
		{
			$sql2 ="SELECT *,CONCAT(YEAR(CURDATE()),'-',Benefit_month,'-',15) as mpl_date
				FROM m_employee_benefits
				WHERE Benefit_month > MONTH('{$date}')
				ORDER BY Benefit_month
				LIMIT 1";
			$query2 = mysql_query($sql2) or die(mysql_error().$sql2);
			$row2 = mysql_fetch_array($query2,MYSQL_ASSOC);
			
			return $row2['mpl_date'];
		}
		
	}
	
	
	function get_posting_detail($pay_period,$member_id)
	{
		$sql = <<<SQL
		SELECT *
		FROM ar_posting_detail
		WHERE member_id = $member_id
		AND pay_period = '$pay_period'	
SQL;
		$query = mysql_query($sql) or die(mysql_error().$sql);
		
		$row = mysql_fetch_array($query,MYSQL_ASSOC);
		
		return $row;
	}
	
	function get_principal($prod_id,$end_bal)
	{
		if ($prod_id != 'L-FS03' AND 
					$prod_id != 'L-FS04' AND
					$prod_id != 'INS' AND
					$prod_id != 'S-DS01' AND
					$prod_id!= 'S-DS02' AND
					$prod_id != 'S-GC01' AND
					$prod_id != 'S-GC02'
					)
		{ 
			$principal = $end_bal;
		}
		else
			$principal = 0;
			
		return $principal;
	}
	
	function transform_date($date)
	{
		$a = explode('-',$date);
		
		$year = $a[0];
		$mo = $a[1];
		$day= $a[2];
		
		return "$mo/$day/$year";
		
		
	}
	
	function add_savings($member_id,$pay_period)
	{
		$query3 = "SELECT savings_amt as total 
				   FROM m_savings 
				   WHERE pay_period = '$pay_period' 
				   AND member_id = '$member_id' ";
		$result3 = mysql_query($query3) or die(mysql_error().$query3.'======12');
		$row3 = mysql_fetch_array($result3);
		$savings = is_null($row3['total'])?0.00:$row3['total'];
				   
		
		return $savings;
	}
	
	
  
  #==============================================================================================================================================


?>