<?
		
	ob_start();
	session_start();
		
	error_reporting(E_ALL ^ E_NOTICE);
		
	$lastBilling = get_last_billing();
		
class Subs_member extends FPDF
{
	var $member_id;
	var $lastBilling;
	var $trans_date;
	var $username;
	
	function Member($member_id = 0,$lastBilling,$trans_date,$username)
	{
		$this->member_id = $member_id;
		$this->lastBilling = $lastBilling;
		$this->trans_date = $trans_date;
		$this->username = $username;
	}
	
	//Page header
	function Header()
	{
		global $lastBilling, $scs_divisor;
				
			$lastBilling = $this->lastBilling;
			$trans_date = $this->trans_date;
			
			$as_of = $lastBilling;
			if($trans_date != 0){
				$as_of = $trans_date;
			}
			$CI = & get_instance();
			
				
			$query = "  SELECT *,CONCAT(mem_lname,', ',mem_fname,' ',SUBSTR(mem_mname,1,1),'.') as name 
						FROM mem_members
						LEFT JOIN mem_emplevel USING(emp_level_id)
						LEFT JOIN mem_account USING(member_id)
						LEFT JOIN mem_temp_bank USING(bank_id)
						LEFT JOIN stg_company USING(company_id)
						WHERE member_id = $this->member_id";
						
			$result = mysql_query($query) or die (mysql_error().$query);
			$row = mysql_fetch_array($result, MYSQL_ASSOC);
				
			$stg = $CI->tbms_db->get('stg_general_settings')->row();
			
			$scs_divisor = $stg->scs_limit;
			
			$this->SetFont('Arial','B',9);
				
			$this->SetXY(5,05	);			
			$this->Cell(40,6,'Member\'s Account as of : '  ,0,0,'L');
			$this->Cell(81,6,date("M d, Y", strtotime($as_of)) ,0,0,'L');	
				
			#$this->Cell(18,4,'Remarks:' ,0,0,'L');
			#$this->SetFont('Arial','I',8);
			#$this->MultiCell(65,4,$row['acct_remarks'],0,'L');
				
			$this->SetXY(5,11);			
			$this->SetFont('Arial','B',9);
			$this->Cell(25,7,'Member Name:' ,0,0,'L');	
			$this->SetFont('Arial','B',12);
			$this->Cell(96,7,$row['name'] ,0,1,'L');	
			$this->SetFont('Arial','B',9);
				
			$this->SetXY(5,18);			
			$this->Cell(25,5,'Member ID:' ,0,0,'L');	
			$this->Cell(96,5,setLength($this->member_id),0,0,'L');
				
			$this->Cell(25,5,'Member Bank:' ,0,0,'L');
			$this->Cell(52,5,$row['bank_name']." - ". $row['account_no'],0,1,'L');
				
			$this->SetXY(5,23);			
				
			$this->Cell(25,5,'Company ID:' ,0,0,'L');
			$this->Cell(96,5,(!empty($row['mem_emp_id2'])?setLength($row['mem_emp_id']).' / '.setLength($row['mem_emp_id2']):setLength($row['mem_emp_id'])) ,0,0,'L');	
			$this->Cell(19,5,'Date Hired:' ,0,0,'L');
			$this->Cell(22,5,date("M d, Y", strtotime($row['mem_hired_date'])) ,10,0,'L');
				
			$los = dateDiff(date('Y-m-d'). '01:00:00', $row['mem_hired_date']. '01:00:00');
				
			$this->Cell(13,5,'LOS: '.$los ,0,0,'L');
				
			$this->SetXY(5,28);			
			
			$this->Cell(25,5,'Company:' ,0,0,'L');
			$this->Cell(96,5,$row['company_name'].' / '.$row['emp_level'],0,0,'L');
			$this->Cell(19,5,'First Dedn:' ,0,0,'L');
			$this->Cell(22,5,date("M d, Y", strtotime($row['dedn_start_dt'])) ,0,0,'L');
			
			$age = dateDiff(date('Y-m-d'). '01:00:00', $row['mem_bday']. '01:00:00');
			$this->Cell(28,5,'Age: '.$age ,0,1,'L');
			
			$this->SetFont('Arial','B',8);
			$this->SetXY(2,30);
			$this->Cell(9,15,'TYPE',0,0,'L');
			$this->Cell(28,15,'PO NUMBER',0,0,'C');
			$this->Cell(19,15,'PO DOC #',0,0,'L');
			$this->Cell(16,15,'END DATE',0,0,'L');
			$this->Cell(18,15,'SCHED DEDN',0,0,'L');
			$this->Cell(18,15,'PAYMENT',0,0,'R');
			$this->Cell(18,15,'DEFERRED',0,0,'R');
			$this->Cell(19,15,'SEMI AMORT',0,0,'R');
			$this->Cell(20,15,'BALANCE',0,0,'R');
			$this->Cell(25,15,'DESCRIPTION',0,1,'L');
			$this->SetXY(3,40);			
			$this->Cell(205,0,'',1,'R');
				
	}
	
	//Page footer
	function Footer()
	{
		global $lastBilling;
			
		$CI = & get_instance();
			
		$CI->load->model('m_members');
			
		$this->SetXY(3,-43);	
			$this->Cell(205,0,'',1,'R');
			$this->SetXY(3,-43);
			$this->SetFont('Arial','B',9);	
			$this->Cell(10,5,'(eTBMS)',0,0,'L');
			$this->Cell(196,5,'Historical Data of Payroll Deduction',0,0,'C');
				
			$query = "  SELECT *
						FROM (
						        SELECT payroll_date as pd,ar_collections_d.*
								FROM ar_collections_h
								LEFT JOIN ar_collections_d USING(collection_id)
								WHERE status = 'Posted'
								AND payment_type = 0
								GROUP BY pd
								ORDER BY payroll_date DESC
								LIMIT 8
						) A
						ORDER BY A.pd ASC";
			$resultx = mysql_query($query);
			
			$this->SetXY(2,-37);
			$this->SetFont('Arial','',8);
			$this->SetFillColor(200,200,200);
			$this->SetFont('Arial','B',9);
			$this->Cell(22,5,'DATE:',1,0,'L',1);
			
			while($rowx = mysql_fetch_array($resultx,MYSQL_ASSOC))
			{
				$date = date('m/d/Y',strtotime($rowx['pd']));
				$this->SetFillColor(200,200,200);
					
				$this->Cell(20,5,$date,1,0,'R',1);	
				
			}
			
			$this->Cell(28,5,'AVE. COLN',1,0,'C',1);
			
				
			
			
			$this->SetFont('Arial','B',9);
			
			$this->SetXY(2,-32);
			$this->Cell(22,5,'OB:',1,0,'L',1);
			
			$resulty = mysql_query($query);
				
			$t_amt = 0;
				
			while($row = mysql_fetch_array($resulty,MYSQL_ASSOC))
			{
				$pay_period = $row['pd'];
				$ob = $CI->m_members->get_account_ob($this->member_id, $pay_period, 1);
				
				$this->SetFont('Arial','',8);
				$this->Cell(20,5,number_format($ob,2),1,0,'R');
			}
				
			$this->SetFont('Arial','',9);
				
			$this->Ln(7);
			$this->SetX(2);
			$this->SetFont('Arial','B',09);
			$this->Cell(22,5,'SCHED:',1,0,'L',1);
				
			$resulty = mysql_query($query);
				
			$t_amt = 0;
				
			while($row = mysql_fetch_array($resulty,MYSQL_ASSOC))
			{
				$pay_period    = $row['pd'];
					
				$billing_info = $CI->m_members->get_billing_info($this->member_id,$pay_period,1);
					
				$this->SetFont('Arial','',8);
				$this->Cell(20,5,number_format($billing_info['billing'],2),1,0,'R');
			}
			
			#$this->SetXY(2,-27);
			$this->Ln(5);
			$this->SetX(2);
			$this->SetTextColor(0,0,0);	
			$this->SetFont('Arial','B',9);
			$this->Cell(22,5,'ACTUAL:',1,0,'L',1);
				
			$resulty = mysql_query($query);
			
			$t_amt = 0;
			
			while($row = mysql_fetch_array($resulty,MYSQL_ASSOC))
			{
				
				$amt_collected = 0;
				
				$pay_period = $row['pd'];
				$sqlx = "   SELECT payroll_date as pd,ar_collections_d.*
							FROM ar_collections_h
							LEFT JOIN ar_collections_d USING(collection_id)
							WHERE status = 'Posted'
							AND payment_type = 0
							AND member_id = '$this->member_id'
							AND payroll_date = '$pay_period'"; 
				$queryx = mysql_query($sqlx);
				if(mysql_num_rows($queryx) > 0)
				{
					$row_amt = mysql_fetch_array($queryx,MYSQL_ASSOC);
						
					$amt_collected = $row_amt['amount'];
				} 
					
				$this->SetFont('Arial','',8);
					
				$this->Cell(20,5,number_format($amt_collected,2),1,0,'R');
					
				$t_amt += $amt_collected;
			}
			
			$t_ave = 0;
			
			if(mysql_num_rows($resulty) > 0)
			{
				$t_ave = $t_amt / mysql_num_rows($resulty);
			}
			
			
			
			$this->SetFont('Arial','B',10);
			$this->Cell(28,5,number_format($t_ave,2),1,0,'C');
			
			$this->Ln(5);
			$this->SetX(2);
			$this->SetFont('Arial','B',09);
			$this->Cell(22,5,'DEFERRED:',1,0,'L',1);
				
			$resulty = mysql_query($query);
				
			$t_amt = 0;
				
			while($row = mysql_fetch_array($resulty,MYSQL_ASSOC))
			{
				$pay_period    = $row['pd'];
					
				$billing_info = $CI->m_members->get_billing_info($this->member_id,$pay_period,1);
					
				$this->SetFont('Arial','',8);
				$this->Cell(20,5,number_format($billing_info['deferred'],2),1,0,'R');
			}
			
			
			
			$this->SetFont('Arial','B',9);
			
			$this->Ln(5);
			$this->SetX(2);
			$this->Cell(22,5,'COLN %:',1,0,'L',1);
			
		
			$resulty = mysql_query($query);
			
			$t_amt = 0;
			$t_sched = 0;
			$t_percent = 0;
			while($row = mysql_fetch_array($resulty,MYSQL_ASSOC))
			{
				$pay_period = $row['pd'];
				$billing_info = $CI->m_members->get_billing_info($this->member_id, $pay_period, 1);
				$percent = 0;
				
				$amt_collected = 0;
				
				$sqlx = "   SELECT payroll_date as pd,ar_collections_d.*
							FROM ar_collections_h
							LEFT JOIN ar_collections_d USING(collection_id)
							WHERE status = 'Posted'
							AND payment_type = 0
							AND member_id = '$this->member_id'
							AND payroll_date = '$pay_period'"; 
				$queryx = mysql_query($sqlx);
				if(mysql_num_rows($queryx) > 0)
				{
					$row_amt = mysql_fetch_array($queryx,MYSQL_ASSOC);
						
					$amt_collected = $row_amt['amount'];
				} 
				
				if($amt_collected > 0 AND $billing_info['billing'] > 0):
					$percent = round(($amt_collected / $billing_info['billing']) * 100,0);
				endif;
					
				$t_percent += $percent;
				
				$this->SetFont('Arial','',8);
				$this->Cell(20,5,$percent.' %',1,0,'R');
				
				$t_amt += $billing_info['billing'] > 0 ? $amt_collected : 0;
				$t_sched += $billing_info['billing'];
			}
			
			if($t_amt == 0 AND $t_sched == 0){
				$t_percent =  0;
			}else{
				$t_percent =  $t_sched > 0 ? round(($t_amt / $t_sched) * 100,0) : 0;
			}
			
			#echo "$t_amt / $t_sched";
				
			$this->SetFont('Arial','B',10);
			$this->Cell(28,5,$t_percent.'%',1,1,'C');
			
			$this->SetFont('Arial','B',8);
			$this->Cell(0,15,'Page '.$this->PageNo().' of {nb}','T',0,'C');//''
			
			
			$this->SetFont('Arial','I',7);
			$this->setXY(1,-4);
			$this->Cell(32,4,'Printed By: '.$this->username,0,0,'L');
			$this->Cell(50,4,date("l, M j, Y"),0,0,'L');
			
		
	}
}



?>