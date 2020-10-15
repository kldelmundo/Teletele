<?
	ob_start();
	session_start();
			
	error_reporting(E_ALL ^ E_NOTICE);
	
	$lastBilling = getLastBilling();
		
class Subs_member extends FPDF
{
	var $member_id;
	var $lastBilling;
	var $is_current;
	var $username;
	
	function Member($member_id = 0,$lastBilling,$is_current,$username)
	{
		$this->member_id = $member_id;
		$this->lastBilling = $lastBilling;
		$this->is_current = $is_current;
		$this->username = $username;
	}
	
	//Page header
	function Header()
	{
		global $lastBilling, $scs_divisor;
			
			if($this->is_current == 1){
				$lastBilling = date("M d, Y");
			}
			else
			{
				$lastBilling = $this->lastBilling;
			}
			
			$query = "SELECT
                            A.member_id, 
                            CONCAT(member_lname, ', ', member_fname, ' ', LEFT(member_mname, 1), '.') AS name,
                            member_emp_id, member_emp_id2, company_name, member_lname, company_name, max(pay_period) as period, scs_divisor, 
                            bank_acct,account_no,member_hired_date,dedn_start_dt,E.bank_name,acct_remarks
                            FROM members A 							
								LEFT JOIN companies B ON A.company_id = B.company_id
								LEFT JOIN ar_member_subs C on A.member_id = C.member_id
								LEFT JOIN member_account D on A.member_id = D.member_id
								LEFT JOIN member_temp_bank E on D.bank_id = E.bank_id
							WHERE A.member_id = {$this->member_id}
							GROUP BY A.member_id, name,
								member_emp_id, member_emp_id2, company_name, member_lname, company_name";
			$result = mysql_query($query) or die (mysql_error().$query);
			$row = mysql_fetch_array($result, MYSQL_ASSOC);
			$scs_divisor = $row['scs_divisor'];
			$this->SetFont('Arial','B',9);
			
			$this->SetXY(5,05	);			
			$this->Cell(40,6,'Member\'s Account as of : '  ,0,0,'L');
			$this->Cell(81,6,date("M d, Y", strtotime($lastBilling)) ,0,0,'L');	
			
			$this->Cell(18,4,'Remarks:' ,0,0,'L');
			$this->SetFont('Arial','I',9);
			$this->MultiCell(61,4,$row['acct_remarks'],0,'L');
			
			
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
			$this->Cell(96,5,(!empty($row['member_emp_id'])?setLength($row['member_emp_id']):setLength($row['member_emp_id2'])) ,0,0,'L');	
			$this->Cell(19,5,'Date Hired:' ,0,0,'L');
			$this->Cell(22,5,date("M d, Y", strtotime($row['member_hired_date'])) ,10,0,'L');
			
			
			$los = dateDiff(date('Y-m-d'), $row['member_hired_date']. '01:00:00');
			
			$this->Cell(13,5,'LOS: '.$los ,0,0,'L');

			
			$this->SetXY(5,28);			
			
			$this->Cell(25,5,'Company:' ,0,0,'L');
			$this->Cell(96,5,$row['company_name'] ,0,0,'L');
			$this->Cell(35,5,'First Deduction Date:' ,0,0,'L');
			$this->Cell(44,5,date("M d, Y", strtotime($row['dedn_start_dt'])) ,0,1,'L');
			
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
			#$this->Cell(20,15,'COST',0,0,'C');
			#$this->Cell(12,15,'STATUS',0,0,'C');
			$this->Cell(25,15,'DESCRIPTION',0,1,'L');
			$this->SetXY(3,40);			
			$this->Cell(205,0,'',1,'R');
	
		
	
	}
	
	//Page footer
	function Footer()
	{
		$lastBilling = getLastBilling();
		
		$this->SetXY(3,-38);	
			$this->Cell(205,0,'',1,'R');
			$this->SetXY(3,-38);
			$this->SetFont('Arial','B',9);	
			$this->Cell(206,5,'Historical Data of Payroll Deduction',0,0,'C');
			/*
			#$ctr = 1;
			for($ctr = 1; $ctr <= 8; $ctr++)
			{
				$date = sw
				
				$pdf->Cell(10,5,$date,0,0,'C');	
				
				
			}
			*/
			$queryx = "SELECT * FROM (
						   SELECT distinct pay_period as pd 
						   FROM ar_member_subs_detail 
						   WHERE pay_period <= '$lastBilling' 
						   AND member_id = {$this->member_id} 
						   ORDER BY pay_period DESC LIMIT 8) A
					   ORDER BY A.pd ASC";
			$resultx = mysql_query($queryx);
			
			$this->SetXY(2,-32);
			$this->SetFont('Arial','',8);
			$this->SetFillColor(200,200,200);
			$this->SetFont('Arial','B',9);
			$this->Cell(20,5,'DATE:',1,0,'L',1);
			
			while($rowx = mysql_fetch_array($resultx,MYSQL_ASSOC))
			{
				$date = date('m/d/Y',strtotime($rowx['pd']));
				$this->SetFillColor(200,200,200);
				#$this->SetTextColor(0,0,0);	
				#$this->SetTextColor(255,255,255);
				#$this->SetDrawColor(200,200,200);
				$this->Cell(20,5,$date,1,0,'R',1);	
				
				
				
			}
			
			$this->Cell(30,5,'AVE. COLN',1,0,'C',1);
			
				
			
			
			$this->SetFont('Arial','B',9);
			$query = "SELECT * FROM (
					  SELECT distinct pay_period as pd 
					  FROM ar_member_subs_detail 
					  WHERE pay_period <= '$lastBilling' 
					  AND member_id = {$this->member_id} 
					  ORDER BY pay_period DESC LIMIT 3) A
				      ORDER BY A.pd ASC";
			$result = mysql_query($query);
			$aPd = array();
			
			
			$this->SetXY(2,-27);
			$this->Cell(20,5,'OB:',1,0,'L',1);
			
			$queryy = "SELECT * FROM (
						   SELECT distinct pay_period as pd 
						   FROM ar_member_subs_detail 
						   WHERE pay_period <= '$lastBilling' 
						   AND member_id = {$this->member_id} 
						   ORDER BY pay_period DESC LIMIT 8) A
					   ORDER BY A.pd ASC";
			$resulty = mysql_query($queryy);
			
			$t_amt = 0;
			
			while($row = mysql_fetch_array($resulty,MYSQL_ASSOC))
			{
				$query2 = "SELECT sched_dedn_amount, actual_payment, deferred_amount, end_bal, C.prod_id as prod, pay_period
						FROM ar_member_subs_detail A
							LEFT JOIN p_sales_header C ON A.po_number = C.po_number
							LEFT JOIN m_loan_products D ON C.prod_id = D.prod_id
						WHERE A.member_id = {$this->member_id}
							AND A.pay_period = '{$row['pd']}'
						AND C.prod_id NOT IN ( 'L-FS09','L-FS04')
							AND po_status !=5";
				$result2 = mysql_query($query2) or die (mysql_error() . $query2);
				$sumOB1 = 0; $sumSched1 = 0; $sumActual1 = 0; $sumDef1 = 0;
				while ($row2 = mysql_fetch_array($result2, MYSQL_ASSOC))
				{		
					$pd = $row2['pay_period'];
					if ($row2['prod'] != 'L-FS04' && $row2['prod'] != 'Ins' && $row2['prod'] != 'INS')
						$sumOB1 += $row2['end_bal'];
					if ($row2['prod'] != 'L-FS03' && $row2['prod'] != 'L-FSVC' && $row2['prod'] != 'L-FS04')
						$sumSched1 += $row2['sched_dedn_amount'];
						
					$sumActual1 += $row2['actual_payment'];
					$sumDef1 += $row2['deferred_amount'];
				}
				$query3 = "SELECT sched_dedn_amount, actual_payment, deferred_amount, end_bal, C.prod_id as prod
							FROM ar_member_subs_detail A 
								LEFT JOIN p_sales_details F on A.po_number = F.item_code
								LEFT JOIN p_sales_header C on F.sales_id = C.sales_id
								LEFT JOIN m_loan_products D on C.prod_id = D.prod_id					
							WHERE A.member_id = {$this->member_id} AND A.pay_period = '{$row['pd']}' AND C.prod_id = 'L-FS09' 
								AND ((A.po_number LIKE '%-T') OR dr_number LIKE 'CLF_%' AND dr_number NOT LIKE 'CLF-2%')  AND po_status != 5";
				$result3 = mysql_query($query3);
				$row3 =  mysql_fetch_array($result3, MYSQL_ASSOC);
				$sumOB1 += $row3['end_bal'];
				$sumSched1 += $row3['sched_dedn_amount'];
				$sumActual1 += $row3['actual_payment'];
				$sumDef1 += $row3['deferred_amount'];
				
				$query4 = "SELECT actual_payment FROM actual_payment WHERE member_id = '{$this->member_id}' && pay_period = '{$row['pd']}'";
				$result4 = mysql_query($query4);
				$row4 = mysql_fetch_array($result4);
				
				$query5 = "SELECT SUM(scheduled_dedn_amt) AS scheduled_dedn_amt FROM ar_member_subs WHERE member_id = '{$this->member_id}' && pay_period = '{$row['pd']}' && trans_id IN (3,8,9,10,11)";
				$result5 = mysql_query($query5);
				$row5 = mysql_fetch_array($result5);
				
				$sumSched1 += $row5['scheduled_dedn_amt'];
				
				$suma = $sumSched1 - $row4['actual_payment'];
				
				
				$this->SetFont('Arial','',8);
				$this->Cell(20,5,number_format($sumOB1,2),1,0,'R');
			}
			
			
			
			$this->SetFont('Arial','',9);
			
			$this->Ln(7);
			$this->SetX(2);
			$this->SetFont('Arial','B',09);
			$this->Cell(20,5,'SCHED:',1,0,'L',1);
			$queryy = "SELECT * FROM (
						   SELECT distinct pay_period as pd 
						   FROM ar_member_subs_detail 
						   WHERE pay_period <= '$lastBilling' 
						   AND member_id = {$this->member_id} 
						   ORDER BY pay_period DESC LIMIT 8) A
					   ORDER BY A.pd ASC";
			$resulty = mysql_query($queryy);
			
			$t_amt = 0;
			
			while($row = mysql_fetch_array($resulty,MYSQL_ASSOC))
			{
				$query2 = "SELECT SUM(sched_dedn) as billing
				 FROM ar_member_billing
				 WHERE pay_period = '{$row['pd']}'
				 AND (member_id = {$this->member_id} OR deduct_from = {$this->member_id})
				 AND Prod_Id <> 'L-FS04'";
				$result2 = mysql_query($query2) or die (mysql_error() . $query2);
				
				$row2 = mysql_fetch_array($result2, MYSQL_ASSOC);
					
				$sumSched1 = $row2['billing'];
					
				$this->SetFont('Arial','',8);
				$this->Cell(20,5,number_format($sumSched1,2),1,0,'R');
			}
			
			#$this->SetXY(2,-27);
			$this->Ln(5);
			$this->SetX(2);
			$this->SetTextColor(0,0,0);	
			$this->SetFont('Arial','B',9);
			$this->Cell(20,5,'ACTUAL:',1,0,'L',1);
			
			$queryy = "SELECT * FROM (
						   SELECT distinct pay_period as pd 
						   FROM ar_member_subs_detail 
						   WHERE pay_period <= '$lastBilling' 
						   AND member_id = {$this->member_id} 
						   ORDER BY pay_period DESC LIMIT 8) A
					   ORDER BY A.pd ASC";
			$resulty = mysql_query($queryy);
			
			$t_amt = 0;
			
			while($rowy = mysql_fetch_array($resulty,MYSQL_ASSOC))
			{
				$sql_ap = "SELECT * FROM actual_payment WHERE member_id = {$this->member_id} AND pay_period = '{$rowy['pd']}'";
				$query_ap = mysql_query($sql_ap) or die(mysql_error().$sql_ap);
				$row_ap = mysql_fetch_array($query_ap,MYSQL_ASSOC);
				$amt = $row_ap['actual_payment'];
				$this->SetFont('Arial','',8);

				$this->Cell(20,5,number_format($amt,2),1,0,'R');
				#$this->Ln(5);	
				#$this->Cell(20,5,number_format($amt,2),1,0,'R');	
				$t_amt += $amt;
				
				
				#$this->Cell(22,5,'asd',1,0,'C',1);	

			}
			
			$t_ave = $t_amt / 8;
			
			
			$this->SetFont('Arial','B',10);
			$this->Cell(30,5,number_format($t_ave,2),1,0,'C');
			
			
			
			$this->SetFont('Arial','B',9);
			
			$this->Ln(5);
			$this->SetX(2);
			$this->Cell(20,5,'DEFERRED:',1,0,'L',1);
			
			 $queryy = "SELECT * FROM (
						   SELECT distinct pay_period as pd 
						   FROM ar_member_subs
						   WHERE pay_period <= '$lastBilling' 
						   AND member_id = {$this->member_id} 
						   ORDER BY pay_period DESC LIMIT 8) A
					   ORDER BY A.pd ASC";
			$resulty = mysql_query($queryy);
			
			$t_amt = 0;
			
			while($row = mysql_fetch_array($resulty,MYSQL_ASSOC))
			{
				$sql = "SELECT *
						FROM ar_posting_detail
						WHERE member_id = {$this->member_id}
						AND pay_period = '{$row['pd']}'";
				$query_sql = mysql_query($sql) or die(mysql_error().$sql);
				
				$row_sql = mysql_fetch_array($query_sql,MYSQL_ASSOC);
				
				$sumDef1 =	$row_sql['deferred'];
				if($row_sql['overpayment'] > 0){
					$sumDef1 =	$row_sql['deferred2'];
				}
				$this->SetFont('Arial','',8);
				$this->Cell(20,5,number_format($sumDef1,2),1,0,'R');
			}
			
			$this->SetFont('Arial','B',8);
			$this->Cell(0,15,'Page '.$this->PageNo().' of {nb}','T',0,'C');//''
			$this->SetFont('Arial','I',7);
			$this->setXY(1,-4);
			$this->Cell(32,4,'Printed By: '.$this->username,0,0,'L');
			$this->Cell(50,4,date("l, M j, Y"),0,0,'L');
	}
}



?>