<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()
	{
		if($this->session->userdata('is_login')){
			$data['row'] = $this->m_account->get_member_info();
		}
		
		##$data['has_side_menu'] = TRUE;
		$data['body'] = 'home';
		
		$this->load->view('index',$data);
		
		
		#$this->m_account->send_bday();
		
		
	}

	public function membership()
	{
		if($this->session->userdata('is_login')){
			$data['row'] = $this->m_account->get_member_info();
		}
		
		##$data['has_side_menu'] = TRUE;
		$data['body'] = 'membership';
		
		$this->load->view('index',$data);
	}

	public function services()
	{
		if($this->session->userdata('is_login')){
			$data['row'] = $this->m_account->get_member_info();
		}
		
		##$data['has_side_menu'] = TRUE;
		$data['body'] = 'services';
		
		$this->load->view('index',$data);
	}
	
	public function loan_calculator()
	{
		if($this->session->userdata('is_login')){
			$data['row'] = $this->m_account->get_member_info();
		}
			
		##$data['has_side_menu'] = TRUE;
		$data['body'] = 'loan_calculator';
			
		$this->load->view('index',$data);
		//$this->m_account->send_bday();
		
	}
		
	function member_req()
	{
		if($this->session->userdata('is_login')){
			$data['row'] = $this->m_account->get_member_info();
		}
		##$data['has_side_menu'] = TRUE;
		$data['body'] = 'member/requirements';
		
		$this->load->view('index',$data);
	}

	function mem_resignation()
	{
		if($this->session->userdata('is_login')){
			$data['row'] = $this->m_account->get_member_info();
		}
		#$data['has_side_menu'] = TRUE;
		$data['body'] = 'member/mem_resignation';
		
		$this->load->view('index',$data);
	}
	
	function duties()
	{
		if($this->session->userdata('is_login')){
			$data['row'] = $this->m_account->get_member_info();
		}
		#$data['has_side_menu'] = TRUE;
		$data['body'] = 'member/duties';
		
		$this->load->view('index',$data);
	}
	
	function sched_dedn()
	{
		if($this->session->userdata('is_login')){
			$data['row'] = $this->m_account->get_member_info();
		}
		#$data['has_side_menu'] = TRUE;
		$data['body'] = 'member/sched_dedn';
		
		$this->load->view('index',$data);
	}
	
	public function events()
	{
		
		$data['body'] = 'events';
		
		$this->load->view('index.php', $data);
		#$this->load->view('event.html');
	}
	
	public function contact_us()
	{
		if($this->session->userdata('is_login')){
			$data['row'] = $this->m_account->get_member_info();
		}
		##$data['has_side_menu'] = TRUE;
		$data['body'] = 'contact_us';
		
		$this->load->view('index',$data);
	}
	
	public function financial()
	{
		$data['body'] = 'financial';
			
		$this->load->view('index',$data);
	}
	public function mpl()
	{
		$data['body'] = 'multi-purpose';
			
		$this->load->view('index',$data);
	}
	public function fsdl_sr()
	{
		$data['body'] = 'fsdl_sr';
			
		$this->load->view('index',$data);
	}
	public function gift_checks()
	{
		$data['body'] = 'gift_checks';
			
		$this->load->view('index',$data);
	}
	
	public function appliance($offset = 0, $key = '')
	{
		$keyword = $this->input->post("search");

		if($key != '')
		{
			$keyword = $key;	
		}

		$data['keyword'] = $keyword;

		$where = '';

		if(!empty($keyword))
		{
			$where = "
					AND ps_name LIKE '%$keyword%'
					OR ps_title LIKE '%$keyword%'
					OR ps_description LIKE '%$keyword%'
					 ";
		}

		$sql = "SELECT *
				FROM telescoop_web.products_services
				WHERE  ps_status = 1
				AND ps_type = 2
				$where
				ORDER BY is_new DESC
				";

		
		$total_rows = $this->db->query($sql)->num_rows();
		$sql .=	"LIMIT $offset, 3";
		$query = $this->db->query($sql);

		$data['query'] = $query;

		if($keyword != '')
		{
			$data['prefix'] = "/".$data['keyword'].'/';
			$data['base_url'] = base_url().'/home/appliance_search';

		}
		else
		{
			$data['base_url'] = base_url().'home/appliance';
		}


		$data['uri_segment'] = 3;
		$data['total_rows'] = $total_rows;
		$data['per_page'] = 5;

		$this->pagination->initialize($data);

		
		$data['body'] = 'appliance';
		
		$this->load->view('index',$data);
	}

	public function appliance_search($key = '',$offset = 0)
	{
		$keyword = str_replace('%20', ' ', $key);
		$data['keyword'] = $keyword;
		$where = '';
		if(!empty($keyword))
		{
			$where = "
					AND ps_name LIKE '%$keyword%'
					OR ps_title LIKE '%$keyword%'
					OR ps_description LIKE '%$keyword%'
					 ";
		}

		$sql = "SELECT *
				FROM telescoop_web.products_services
				WHERE  ps_status = 1
				AND ps_type = 2
				$where
				ORDER BY is_new DESC
				";

		$total_rows = $this->db->query($sql)->num_rows();
		$sql .=	"LIMIT $offset, 3";
		$query = $this->db->query($sql);

		$num_rows = $this->db->query($sql);

		$data['query'] = $query;

		$data['uri_segment'] = 3;
		$data['base_url'] = base_url().'/home/appliance_search/'.$key;
		$data['total_rows'] = $total_rows;
		$data['per_page'] = 5;

		$this->pagination->initialize($data);

		
		$data['body'] = 'appliance';
		
		$this->load->view('index',$data);

	}
	public function fsdl_subs()
	{
		$data['body'] = 'fsdl_subs';
			
		$this->load->view('index',$data);
	}
	
	public function others()
	{
		$data['body'] = 'others';
		
		$this->load->view('index',$data);
	}
	
	function benefits()
	{
		##$data['has_side_menu'] = TRUE;
 
		$data['body'] = 'benefits/benefits';
			
		$this->load->view('index',$data);
	}
	
	function cart()
	{
		##$data['has_side_menu'] = TRUE;
		#$data['body'] = 'contact_us';
		
		#$this->load->view('index',$data);
		echo "<br><br><br><br><br><br><center><code>Sorry for inconvenience,<br>we are working on it.</code></center>";
	}
	
	function fpdf($member_id='')
	{
		if(empty($member_id)){
			$member_id = $this->input->post('member_id');
		}
		
		$this->load->library('subs_member');
		
		$pdf= new Subs_member('P','mm','Letter');
		$pdf->Member($member_id);
			
		$query = "  SELECT
	                A.member_id, 
	                CONCAT(mem_lname, ', ', mem_fname, ' ', LEFT(mem_mname, 1), '.') AS name,
	                mem_emp_id, mem_emp_id2, company_name, mem_lname, company_name, max(pay_period) as period, scs_divisor, 
	                bank_acct,account_no,member_hired_date,dedn_start_dt,E.bank_name,acct_remarks
	                FROM members A 							
						LEFT JOIN companies B ON A.company_id = B.company_id
						LEFT JOIN ar_member_subs C on A.member_id = C.member_id
						LEFT JOIN member_account D on A.member_id = D.member_id
						LEFT JOIN member_temp_bank E on D.bank_id = E.bank_id
					WHERE A.member_id = {$member_id}
					GROUP BY A.member_id, name,
					member_emp_id, member_emp_id2, company_name, mem_lname, company_name";
		$result = mysql_query($query) or die (mysql_error().$query);
		$row = mysql_fetch_array($result, MYSQL_ASSOC);
		$scs_divisor = $row['scs_divisor'];
			
		$pdf->SetMargins(10,5,10);
		$pdf->SetAutoPageBreak(true , 40);
		$pdf->AliasNbPages();
		$pdf->AddPage();
		
		$lastBilling = getLastBilling();
		
		$_GET['date'] = $lastBilling;
		
		$nxtBilling = switch_next_date($lastBilling);
		$query = "SELECT * FROM ar_member_subs A 
							LEFT JOIN m_transaction_types B on A.trans_id = B.trans_id
							WHERE member_id = {$member_id} AND A.trans_id not in (0,1,2,4,5,7)
							AND A.pay_period = '$lastBilling'
							ORDER BY B.trans_id";
		$result = mysql_query($query) or die (mysql_error().$query);
	
		$y = 40;
		$t_dedn_amt = 0;
		$t_actual_pay = 0;
		$t_deferr = 0;
		$t_semi = 0;
		$t_end_bal = 0;
		$t_scs = 0;
		$pdf->SetFont('Arial','',8);
		while($row = mysql_fetch_array($result, MYSQL_ASSOC))
		{
			
			$chkOR_contrib = "SELECT sum(amt) as or_amount, pay_period1, pay_period2 FROM or_header A 
							INNER JOIN or_details B on A.or_id = B.or_id
						WHERE po_num = '{$row['accnt_code']}' AND or_date > '$lastBilling' AND or_date <= '$nxtBilling'
							AND member_id = {$member_id}
						GROUP BY po_num";
			$resultOR_contrib = mysql_query($chkOR_contrib) or die (mysql_error() . "Error in Query : ". $chkOR_contrib);
			$rowOR = mysql_fetch_array($resultOR_contrib, MYSQL_ASSOC);
			$or_contrib = is_null($rowOR['or_amount']) ? 0 : $rowOR['or_amount'];
			
			$qAdvance = "SELECT sum(actual_payment) as adv_payments FROM ar_member_subs
				WHERE trans_id = '{$row['trans_id']}' AND pay_period > '{$lastBilling}'  AND member_id = '{$member_id}'";
			$rAdvance = mysql_query($qAdvance) or die (mysql_error() . "Error in Query : ".$qAdvance);
			$rwAdvance = mysql_fetch_array($rAdvance, MYSQL_ASSOC);
			
			if ($_GET['date'] == 0)
			{
				#advance payments						
				$balance_contrib = $row['end_balance'] - $rwAdvance['adv_payments'];
				$payments_contrib = $or_contrib;
				$deferred = number_format($row['deferred_amount'],2,".",",");
				$t_deferr += $row['deferred_amount'];
			}
			else
			{
				if (!is_null($rowOR['or_amount']))
				{		/*				
					$pd1 = explode("-", $rowOR['pay_period1']);
					$pd2 = explode("-", $rowOR['pay_period2']);
					if (mktime(0,0,0,$pd1[1],$pd1[2], $pd1[0]) == mktime(0,0,0,$pd2[1],$pd2[2], $pd2[0]))
					{
						if ($or_contrib < $row['scheduled_dedn_amt'])
							$payments_contrib = 0;
						else 
						$payments_contrib = $row['scheduled_dedn_amt'] - $or_contrib;
					}
					else */
					$payments_contrib = $row['actual_payment'] - ($or_contrib - $rwAdvance['adv_payments']);	
					if ($or_contrib < $row['scheduled_dedn_amt'])
						$diff = $row['scheduled_dedn_amt']	- $or_contrib;	
					$deferred = ($or_contrib - $rwAdvance['adv_payments']) + $diff ;
					//$balance_contrib = ($or_contrib - $rwAdvance['adv_payments']) + $diff;
					$balance_contrib = $row['beg_balance'] - $payments_contrib;
					$t_deferr += $deferred;
					$deferred = number_format($deferred,2,".",",");
				}
				else 
				{
					$balance_contrib = $row['end_balance'];
					$payments_contrib = $row['actual_payment'];
					$deferred = number_format($row['deferred_amount'],2,".",",");
					$t_deferr += $row['deferred_amount'];
				}				
				
			}
			$sched_dedn_amt = number_format($row['scheduled_dedn_amt'],2,".",",");
			$actual_pay = number_format($payments_contrib,2,".",",");
			
			$semi = number_format($row['semi_mon_ammort'],2,".",",");
			$end_bal = number_format($balance_contrib,2,".",",");
			
			$t_dedn_amt += $row['scheduled_dedn_amt'];
			$t_actual_pay += $payments_contrib;		
			$t_semi += $row['semi_mon_ammort'];
			$t_end_bal += $balance_contrib;
			
			if($row['trans_id'] == 9 OR $row['trans_id'] == 10) {
				$t_scs += $row['end_balance'];
			}
	
			$pdf->SetXY(3,$y);
			$pdf->Cell(9,5,$row['trans_type_sdesc'],0,0,'L');
			$pdf->Cell(63,5,'',0,0,'C');
			$pdf->Cell(18,5,$sched_dedn_amt,0,0,'R');
			$pdf->Cell(18,5,$actual_pay,0,0,'R');
			$pdf->Cell(18,5,$deferred,0,0,'R');
			$pdf->Cell(19,5,$semi,0,0,'R');
			$pdf->Cell(20,5,$end_bal,0,0,'R');
			$pdf->Cell(20,5,'',0,0,'R');	
			#$pdf->Cell(10,5,'A',0,0,'C');	
			$pdf->Cell(25,5,$srow['Prod_Name'],0,1,'L');	
			$y+=5;
			
			
			
			if($row['trans_id'] == 10){
				$scs1_exist = 1;
			}
			
			if($row['trans_id'] == 9){
				$scs_exist = 1;
			}
			
			
		}
		
		//===============================================================//
		//added by carl 
		//temporary sol'n to show scs (Hardcode)
		if($scs1_exist == 1 && $scs_exist != 1){
			
			$t_scs += 14000;
			$t_end_bal+= 14000;
			$pdf->SetXY(3,$y);
			$pdf->Cell(9,5,"SCS",0,0,'L');
			$pdf->Cell(63,5,'',0,0,'C');
			$pdf->Cell(18,5,"0.00",0,0,'R');
			$pdf->Cell(18,5,"0.00",0,0,'R');
			$pdf->Cell(18,5,"0.00",0,0,'R');
			$pdf->Cell(19,5,"0.00",0,0,'R');
			$pdf->Cell(20,5,"14,000.00",0,0,'R');
			$pdf->Cell(20,5,'',0,0,'R');	
			#$pdf->Cell(10,5,'A',0,0,'C');	
			$y+=5;
			
	
		}
		
		
		
		if(mysql_num_rows($result) > 0) {
			$pdf->SetXY(3,$y);
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(72,5,'',0,0,'C');
			$pdf->Cell(18,5,number_format($t_dedn_amt,2,".",","),1,0,'R');
			$pdf->Cell(18,5,number_format($t_actual_pay,2,".",","),1,0,'R');
			$pdf->Cell(18,5,number_format($t_deferr,2,".",","),1,0,'R');
			$pdf->Cell(19,5,number_format($t_semi,2,".",","),1,0,'R');
			$pdf->Cell(20,5,number_format($t_end_bal,2,".",","),1,1,'R');
		}	
		
			
		$today2 = date("Y-m-d");
		$query2 = "SELECT *, C.interest as intrst, A.po_number as this_po_number , po_start_date, pay_period, beginning_bal, C.commission, C.prod_id as prod, trans_type_sdesc
							FROM ar_member_subs_detail A 
								LEFT JOIN m_transaction_types B on A.trans_type = B.trans_id
								LEFT JOIN p_sales_header C on A.po_number = C.po_number
								LEFT JOIN m_loan_products D on C.prod_id = D.prod_id
							WHERE A.member_id = {$member_id} 
							AND A.pay_period = '$lastBilling'  
							AND C.prod_id NOT IN ( 'L-FS09'  ,'L-FS04')
							AND po_status != 5";
				
		//(SELECT MAX(pay_period) FROM ar_member_subs WHERE member_id = $member_id GROUP BY member_id LIMIT 1)
		$result2 = mysql_query($query2) or die (mysql_error().$query2);
		$ys = $y+10;
		$t_dedn_amt2 = 0;
		$t_actual_pay2 = 0;
		$t_deferr2 = 0;
		$t_semi2 = 0;
		$t_end_bal2 = 0;
		$t_principal = 0;
		$pdf->SetFont('Arial','',8);
		while($row2 = mysql_fetch_array($result2, MYSQL_ASSOC))
		{
			$chkOR_contrib = "SELECT sum(amt) as or_amount, pay_period1, pay_period2 FROM or_header A 
							INNER JOIN or_details B on A.or_id = B.or_id
						WHERE po_num = '{$row2['this_po_number']}' AND or_date > '$lastBilling' AND or_date <= '$nxtBilling'
							AND member_id = {$member_id}
						GROUP BY po_num";
			$resultOR_contrib = mysql_query($chkOR_contrib) or die (mysql_error() . "Error in Query : ". $chkOR_contrib);
			$rowOR = mysql_fetch_array($resultOR_contrib, MYSQL_ASSOC);
			$or_contrib = is_null($rowOR['or_amount']) ? 0 : $rowOR['or_amount'];
			
			$queryZ = "SELECT SUM(actual_payment) AS t_ap FROM ar_member_subs_detail 
						WHERE po_number = '{$row2['this_po_number']}' && pay_period > '$lastBilling'";
			$resultZ = mysql_query($queryZ);
			$rowZ = mysql_fetch_array($resultZ);
			
			if ($_GET['date'] == 0)
			{
				#advance payments						
				$end_bal2 = $row2['end_bal'] - $rowZ['t_ap'];
				$a_p = $or_contrib;
				$deferred2 = number_format($row2['deferred_amount'],2,".",",");
				$t_deferr2 += $row2['deferred_amount'];
			}
			else
			{/*	
				if (!is_null($rowOR['or_amount']))
				{					
					$pd1 = explode("-", $rowOR['pay_period1']);
					$pd2 = explode("-", $rowOR['pay_period2']);
					if (mktime(0,0,0,$pd1[1],$pd1[2], $pd1[0]) == mktime(0,0,0,$pd2[1],$pd2[2], $pd2[0]))
					{
						
						if ($or_contrib < $row2['sched_dedn_amount'])
							$a_p = 0;
						else 
							$a_p = $row2['sched_dedn_amount'] - $or_contrib;
						//$a_p = $row2['sched_dedn_amount'] - $or_contrib;
					}
					else
						$a_p = $row2['sched_dedn_amount'] - ($or_contrib - $rowZ['t_ap']);										
					if ($or_contrib < $row2['sched_dedn_amount'])
						$diff = $row2['sched_dedn_amount']	- $or_contrib;		
					$deferred2 = $row2['sched_dedn_amount'] - $a_p;											
					//$deferred2 = ($or_contrib - $rowZ['t_ap']) + $diff;
					
					$end_bal2 = ($row2['beginning_bal'] - $a_p) ;		
					$t_deferr2 += $deferred2;
					$deferred2 = number_format($deferred2,2,".",",");
				
				}
				else 
				{
					$end_bal2 = $row2['end_bal'];
					$a_p = $row2['actual_payment'];
					$deferred2 = number_format($row2['deferred_amount'],2,".",",");
					$t_deferr2 += $row2['deferred_amount'];
				}*/
				
					if (!is_null($rowOR['or_amount']))
					{						
						$a_p = $row2['actual_payment'] - ($or_contrib - $rowZ['t_ap']);										
						$deferred2 = ($row2['sched_dedn_amount'] - $a_p);			
						$end_bal2 = ($row2['beginning_bal'] - $a_p);
						#$end_bal2 = $row2['Prod_Id'] == 'L-FS03' ? $row2['end_bal'] : ($row2['beginning_bal'] - $a_p);		
						if ( $row2['prod'] != 'L-FS04'){
							$t_deferr2 += $deferred2;
						}
						
						$deferred2 = number_format($deferred2,2,".",",");
					}
					else 
					{
						$end_bal2  = $row2['end_bal'];
						$a_p	   = $row2['actual_payment'];
						$deferred2 = number_format($row2['deferred_amount'],2,".",",");
						
						if ( $row2['prod'] != 'L-FS04'){
								$t_deferr2 += $row2['deferred_amount'];
						}
						
						
					}				
				
			}
			
			$sched_dedn_amt2 = number_format($row2['sched_dedn_amount'],2,".",",");
			$actual_pay2 = number_format($a_p,2,".",",");		
			$semi2 = number_format($row2['semi_monthly_amort'],2,".",",");
			
			if ( $row2['prod'] != 'L-FS04' && $row2['prod'] != 'L-FS03')
			{
				$t_dedn_amt2 += $row2['sched_dedn_amount'];
			}
			$t_actual_pay2 += $a_p;		
			$t_semi2 += $row2['semi_monthly_amort'];
			
			if (is_null($row['post_ar_by']) && date("Y-m-d") == $lastBilling )
			{			
				$ending = $row2['beginning_bal'];
				$pd_left = (int)$row2['paydays_left'] - 1;
			}
			else 
			{			
				$ending = $row2['end_bal'];
				$pd_left = (int)$row2['paydays_left'];
			}
			if ($row2['prod'] != 'Ins' && $row2['prod'] != 'INS' && $row2['prod'] != 'L-FS04')
				$t_end_bal2 += $end_bal2;
			
				
			if ($row2['prod'] == 'L-FS01' || $row2['prod'] == 'L-FS02' || $row2['prod'] == 'L-FS07' || $row2['prod'] == 'L-FS08' || $row2['prod'] == 'L-FS09' || $row2['prod'] == 'L-FS11')
			{
				
				#TEAM LOAN SCS REQUIREMENT
				if($row2['prod'] == 'L-FS11')
				{
					$sql_tm = mysql_query("SELECT member_hired_date 
										   FROM members 
										   WHERE member_id = {$_POST['member_id']}");
					$row_tm = mysql_fetch_row($sql_tm);
							
					$member_hired_dt = $row_tm[0];
						
					$los = getLOS_by_po($member_hired_dt,$row2['po_date']);
					
					if($los < 5)
					{
						$principal = $end_bal2;
						$sub_total += $principal;
					}
					else
					{
						$principal = 0;
					}	
				}
				else
				{	
					if ($row2['prod'] == 'L-FS01' || $row2['prod'] == 'L-FS02' || $row2['prod'] == 'L-FS07' || $row2['prod'] == 'L-FS08' || $row2['prod'] == 'L-FS11')
						$principal = $end_bal2;
					else
					{
						if ($row2['paydays_left'] > 0 && $row2['end_bal'] > 0)
							$principal = (float) $end_bal2 - (((float) $row2['intrst'] / ((int) $row2['pay_terms'] * 2)) * (int) $pd_left-1);				
						else 
							$principal = $end_bal2;
					}
					$sub_total += $principal;
				}
			}
			else
				$principal = 0;
			
			if ($row2['prod'] == 'L-FS04')	
			{	
				$semi2 = number_format($row2['semi_monthly_amort'],2,".",",");	
				$t_semi2 -= $row2['semi_monthly_amort'];
			}	
				
			$t_principal += $principal;	
			//$pdf->SetXY(3,$ys);
			$pdf->SetX(3);
			
			$pdf->Cell(9,5,$row2['trans_type_sdesc'],0,0,'L');
			$pdf->Cell(25,5,$row2['this_po_number'],0,0,'L');
			$pdf->Cell(22,5,$row2['dr_number'],0,0,'L');
			$pdf->Cell(16,5,date("m/d/Y",strtotime($row2['end_dt'])),0,0,'R');
			$pdf->Cell(18,5,$sched_dedn_amt2,0,0,'R');
			$pdf->Cell(18,5,$actual_pay2,0,0,'R');
			$pdf->Cell(18,5,$deferred2,0,0,'R');
			$pdf->Cell(19,5,$semi2,0,0,'R');
			$pdf->Cell(20,5,number_format($end_bal2,2,".",","),0,0,'R');
			$pdf->Cell(20,5,number_format($principal,2,".",","),0,0,'R');	
			#$pdf->Cell(10,5,'A',0,0,'C');	
			$pdf->Cell(25,5,substr($row2['Prod_Name'],0,15),0,1,'L');
			$ys+=5;
		}
	
		
		# Added By Majo : 2009-03-06 : Conso Loans
		$query4 = "SELECT *, C.interest as intrst, A.po_number as this_po_number , po_start_date, pay_period, beginning_bal, C.commission, dr_number
							FROM ar_member_subs_detail A 
								LEFT JOIN p_sales_details F on A.po_number = F.item_code
								LEFT JOIN p_sales_header C on F.sales_id = C.sales_id
								LEFT JOIN m_loan_products D on C.prod_id = D.prod_id
								LEFT JOIN m_transaction_types E on A.trans_type = E.trans_id
							WHERE A.member_id = {$member_id} AND A.pay_period = '$lastBilling' AND C.prod_id = 'L-FS09' 
								AND ((A.po_number LIKE '%-T' OR A.po_number LIKE '%-P' OR A.po_number LIKE '%-T2') OR (dr_number LIKE 'CLF_%' AND dr_number NOT LIKE 'CLF-2%')) AND po_status != 5";
		
		$result4 = mysql_query($query4) or die (mysql_error().$query4);
		
		$x = 0;
		while($row4 = mysql_fetch_array($result4, MYSQL_ASSOC))
		{
			$chkOR_contrib = "SELECT sum(amt) as or_amount, pay_period1, pay_period2 FROM or_header A 
							INNER JOIN or_details B on A.or_id = B.or_id
						WHERE po_num = '{$row4['this_po_number']}' AND or_date > '$lastBilling' AND or_date <= '$nxtBilling'
							AND member_id = {$member_id}
						GROUP BY po_num";
			$resultOR_contrib = mysql_query($chkOR_contrib) or die (mysql_error() . "Error in Query : ". $chkOR_contrib);
			$rowOR = mysql_fetch_array($resultOR_contrib, MYSQL_ASSOC);
			$or_contrib = is_null($rowOR['or_amount']) ? 0 : $rowOR['or_amount'];
			
			$queryZ = "SELECT SUM(actual_payment) AS t_ap FROM ar_member_subs_detail 
						WHERE po_number = '{$row4['this_po_number']}' && pay_period > '$lastBilling'";
			$resultZ = mysql_query($queryZ);
			$rowZ = mysql_fetch_array($resultZ);
			
			if ($_GET['date'] == 0)
			{
				#advance payments						
				$end_bal4 = $row4['end_bal'] - $rowZ['t_ap'];
				$a_p = $or_contrib;
				$deferred4 = number_format($row4['deferred_amount'],2,".",",");
				$t_deferr2 += $row4['deferred_amount'];
			}
			else
			{
				if (!is_null($rowOR['or_amount']))
				{			/*			
					$pd1 = explode("-", $rowOR['pay_period1']);
					$pd2 = explode("-", $rowOR['pay_period2']);
					if (mktime(0,0,0,$pd1[1],$pd1[2], $pd1[0]) == mktime(0,0,0,$pd2[1],$pd2[2], $pd2[0]))
						$a_p = $row4['sched_dedn_amount'] - $or_contrib;
					else
						$a_p = $row4['sched_dedn_amount'] - ($or_contrib - $rowZ['t_ap']);										
					$deferred4 = $or_contrib - $rowZ['t_ap'];
					$end_bal4 = $row4['beginning_bal'] - $a_p;		
					$t_deferr2 += $deferred4;
					$deferred4 = number_format($deferred4,2,".",",");
					*/
					$a_p = $row4['actual_payment'] - ($or_contrib - $rowZ['t_ap']);	
					$deferred4 = ($row4['sched_dedn_amount'] - $a_p);
					$end_bal4 = $row4['beginning_bal'] - $a_p;		
					$t_deferr2 += $deferred4;
					$deferred4 = number_format($deferred4,2,".",",");
				}
				else 
				{
					$end_bal4 = $row4['end_bal'];
					$a_p = $row4['actual_payment'];
					$deferred4 = number_format($row4['deferred_amount'],2,".",",");
					$t_deferr2 += $row4['deferred_amount'];
				}				
				
			}
			
			$sched_dedn_amt4 = number_format($row4['sched_dedn_amount'],2,".",",");
			$actual_pay4 = number_format($a_p,2,".",",");		
			$semi4 = number_format($row4['semi_monthly_amort'],2,".",",");
			
			
			$t_dedn_amt2 += $row4['sched_dedn_amount'];
			$t_actual_pay2 += $a_p;		
			$t_semi2 += $row4['semi_monthly_amort'];
			
			if(substr($row4['this_po_number'],-1) != 'P' ) 
						$t_end_bal2 += $end_bal4;
	
			if(substr($row4['this_po_number'],-1) == 'T'  || substr($row4['this_po_number'],-2) == 'T2') 
				{
					$payd_left = $row4['paydays_left']-1;
					if ($row4['paydays_left'] > 0 && $row4['end_bal'] > 0)
					{
						$principal4 = (float) $end_bal4 - (((float) $row4['intrst'] / ((int) $row4['pay_terms'] * 2)) * (int)$payd_left);				
					}
					else
						$principal4 = $row4['end_bal'];				
						$sub_total += $principal4;
				}
			elseif (substr($row4['this_po_number'],-1) == 'P')
				{
					
					$principal4 = 0;					
					$sub_total += 0;			
					
				}
					
			$t_principal += $principal4;	
			//$pdf->SetXY(3,$ys);
			$pdf->SetX(3);
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(9,5,$row4['trans_type_sdesc'],0,0,'L');
			$pdf->Cell(25,5,$row4['this_po_number'],0,0,'L');
			$pdf->Cell(22,5,$row4['dr_number'],0,0,'L');
			$pdf->Cell(16,5,date("m/d/Y",strtotime($row4['end_dt'])),0,0,'C');
			$pdf->Cell(18,5,$sched_dedn_amt4,0,0,'R');
			$pdf->Cell(18,5,$actual_pay4,0,0,'R');
			$pdf->Cell(18,5,$deferred4,0,0,'R');
			$pdf->Cell(19,5,$semi4,0,0,'R');
			$pdf->Cell(20,5,number_format($end_bal4,2,".",","),0,0,'R');
			$pdf->Cell(20,5,number_format($principal4,2,".",","),0,0,'R');	
			#$pdf->Cell(10,5,'A',0,0,'C');	
			$pdf->Cell(25,5,substr($row4['Prod_Name'],0,15),0,1,'L');
			$ys+=5;
			
			
		
		}
		
		//$nextBilling = chkBilling($lastBilling);
		$lastBilling2 = switch_date($lastBilling);
		$end_dt = date("Y-m-d");//$_GET['billing_date']?$_GET['billing_date']:
		$query3 = "SELECT *, B.interest as intrst, A.po_number as this_po_number, po_start_date, pay_period, beginning_bal, B.prod_id as prod,trans_type_sdesc,
										B.commission as commission, net_proceeds, sales_id
									FROM ar_member_subs_detail A
										LEFT JOIN p_sales_header B ON A.po_number = B.po_number
											AND A.member_id = B.member_id
										LEFT JOIN m_loan_products C ON B.prod_id = C.prod_id	
										LEFT JOIN m_transaction_types D on A.trans_type = D.trans_id						
									WHERE  po_start_date > '$lastBilling' 
									AND C.prod_id != 'L-FS04'
									AND A.member_id = {$member_id} AND po_status != 5
									GROUP BY A.po_number
					UNION ALL
								
					SELECT A.*,C.*,D.*,F.*,C.interest as intrst,
							 A.po_number as this_po_number, po_start_date, pay_period, beginning_bal, C.prod_id as prod,trans_type_sdesc,
							 C.commission as commission, net_proceeds, C.sales_id
					FROM ar_member_subs_detail A
						LEFT JOIN p_sales_details E on A.po_number = E.item_code
						LEFT JOIN p_sales_header C on E.sales_id = C.sales_id
						LEFT JOIN m_loan_products D on C.prod_id = D.prod_id
						LEFT JOIN m_transaction_types F on A.trans_type = F.trans_id
					WHERE A.member_id = {$member_id} AND A.start_dt > '$lastBilling' 
					AND C.prod_id = 'L-FS09'
					AND ((A.po_number LIKE '%-T' OR A.po_number LIKE '%-P' OR A.po_number LIKE '%-T2') OR dr_number LIKE 'CLF_%'
					AND dr_number NOT LIKE 'CLF-2%')
					AND po_status != 5
					GROUP BY A.po_number";	
									
		#and approved_date <= '$today2'
		$result3 = mysql_query($query3) or die (mysql_error().$query3);	
		while($row3 = mysql_fetch_array($result3, MYSQL_ASSOC))
		{
			$a_p = 0;
			if ($_GET['date'] == 0)
			{
				#-------------------------------------------------------------------------------------------------
				$queryZ = "SELECT SUM(actual_payment) AS t_ap FROM ar_member_subs_detail 
							WHERE po_number = '{$row3['this_po_number']}'";
				$resultZ = mysql_query($queryZ);
				$rowZ = mysql_fetch_array($resultZ);
				$advance = $rowZ['t_ap'];
				
				$a_p = $advance;
				#-------------------------------------------------------------------------------------------------
			}
			$sched_dedn_amt3 = number_format($row3[''],2,".",",");
			$actual_pay3 = number_format($a_p,2,".",",");
			$deferred3 = number_format($row3[''],2,".",",");
			$semi3 = number_format($row3['semi_monthly_amort'],2,".",",");
			
			
			$t_dedn_amt2 += $row3[''];
			$t_actual_pay2 += $a_p;
			$t_deferr2 += $row3[''];
			$t_semi2 += $row3['semi_monthly_amort'];
			$end_bal3 = number_format($row3['beginning_bal'] - $a_p,2,".",",");	
			if ($row3['prod'] != 'Ins' && $row3['prod'] != 'INS' && $row3['prod'] != 'L-FS04')	
						$t_end_bal2 += $row3['beginning_bal'];
			
			if ($row3['prod'] != 'L-FS03' && $row3['prod'] != 'L-FSVC' && $row3['prod'] != 'Ins' && $row3['prod'] != 'INS' && $row3['prod'] != 'L-FS04' && $row3['prod'] != 'L-FS06' && $row3['prod'] != 'L-DS01')
			{
				$principal2 = $row3['beginning_bal'];
				$sub_total += $principal2;
			}
			elseif ($row3['prod'] == 'L-FS06')
			{
				$principal2 = $row3['net_proceeds'] + $row3['commission'];					
				$sub_total += $principal2;
			}
			elseif ($row3['prod'] == 'L-DS01')
			{
				$principal2 = $row3['net_proceeds'];					
				$sub_total += $principal2;
			}
			else
			{
				//$end_bal3 =  number_format($row2[''],2,".",",");
				$principal2 = 0;
			}
			if ($row3['prod'] == 'L-FS04')	
			{	
				$semi3 = number_format($row3[''],2,".",",");	
				$t_semi2 -= $row3['semi_monthly_amort'];
			}	
			$t_principal += $principal2;	
			//$pdf->SetXY(3,$ys);
			$pdf->SetX(3);
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(9,5,$row3['trans_type_sdesc'],0,0,'L');
			$pdf->Cell(25,5,$row3['this_po_number'],0,0,'L');
			$pdf->Cell(22,5,$row3['dr_number'],0,0,'L');
			$pdf->Cell(16,5,date("m/d/Y",strtotime($row3['end_dt'])),0,0,'C');
			$pdf->Cell(18,5,$sched_dedn_amt3,0,0,'R');
			$pdf->Cell(18,5,$actual_pay3,0,0,'R');
			$pdf->Cell(18,5,$deferred3,0,0,'R');
			$pdf->Cell(19,5,$semi3,0,0,'R');
			$pdf->Cell(20,5,$end_bal3,0,0,'R');
			$pdf->Cell(20,5,number_format($principal2,2,".",","),0,0,'R');	
			#$pdf->Cell(10,5,'A',0,0,'C');	
			$pdf->Cell(25,5,substr($row3['Prod_Name'],0,15),0,1,'L');
			$ys+=5;
			
			
		}
		
			$chk_fullDed = "SELECT *
					    FROM m_fully_paid_deduction
					    WHERE member_id = {$member_id}
					    AND is_fully_paid = 1
					    AND pay_period >= '$lastBilling'";
							   
				$result_fullDed = mysql_query($chk_fullDed) or die (mysql_error() . "Error in Query : ". $chk_fullDed);
						
				while ($row_fullDed = mysql_fetch_array($result_fullDed, MYSQL_ASSOC))
				{
					$po = substr($row_fullDed['po_number'],-1);
					if($po == 'T')
						$po_n = "CONCAT(B.po_number,'-T')";
					elseif($po == 'P')
						$po_n = "CONCAT(B.po_number,'-P')";
					elseif($po == '2')
						{
						if((substr($row_fullDed['po_number'],-2)) == 'T2')
							{
							$po_n = "CONCAT(B.po_number,'-T2')";
							}
						else 
							$po_n = "B.po_number";
						}
					else 
						$po_n = "B.po_number";
					
						$query3 = "SELECT *,
									    B.interest as intrst,
										A.po_number as this_po_number,
										po_start_date,
										pay_period, 
										beginning_bal,
										B.prod_id as prod,
										trans_type_sdesc
								FROM ar_member_subs_detail_history A
								   LEFT JOIN p_sales_header B ON A.po_number = $po_n
								   AND A.member_id = B.member_id
								   LEFT JOIN m_loan_products C ON B.prod_id = C.prod_id		
								   LEFT JOIN m_transaction_types D ON A.trans_type= D.trans_id
								WHERE A.po_number = '{$row_fullDed['po_number']}'
								AND A.pay_period = '$lastBilling'
								AND po_status != 5";
								#AND A.post_ar_date IS NOT NULL";
							
					$result3 = mysql_query($query3) or die (mysql_error().$query3);	
					while($row5 = mysql_fetch_array($result3, MYSQL_ASSOC))
					{
						$last_cutoff = getLastBilling();
						if ($_GET['date'] == 0)
						{
							$qr = "SELECT *
									   FROM p_sales_rebate
									   WHERE po_number = '{$row5['this_po_number']}'";
							$rr = mysql_query($qr);
							$rwr = mysql_fetch_array($rr, MYSQL_ASSOC);
							$rbt = is_null($rwr['rebate_40']) ? 0 : $rwr['rebate_40'];
							
							$a_p = 0;
							
							$queryZ = "SELECT amt as t_ap FROM m_fully_paid_deduction
									   WHERE po_number = '{$row5['this_po_number']}'
									   AND pay_period = '$lastBilling'";	
									   			   
							$resultZ = mysql_query($queryZ);
							$rowZ = mysql_fetch_array($resultZ);
							$advance = $rowZ['t_ap'] - $rbt;
							$a_p = $advance;
							$endbal3 = 0;
							$deff3 = 0;
							$sched3 = 0;
							$principal2 = 0;
							
							#$t_end_bal2 -= $row3['actual_payment'];
							
						}
						else
						{
							if ($_GET['date'] == $last_cutoff)
							{
								$qr = "SELECT *
									   FROM p_sales_rebate
									   WHERE po_number = '{$row3['this_po_number']}'";
								$rr = mysql_query($qr);
								$rwr = mysql_fetch_array($rr, MYSQL_ASSOC);
								
								$rbt = is_null($rwr['rebate_40']) ? 0 : $rwr['rebate_40'];
								
								$sql3 = "SELECT *
										FROM ar_member_subs_detail_temp
										WHERE po_number = '{$row5['this_po_number']}'
										AND pay_period = '$lastBilling'";
										
								$row_sql3 = mysql_query($sql3) or die (mysql_error() . "Error in Query : ". $sql3);
								$rw = mysql_fetch_array($row_sql3);
								if(mysql_num_rows($row_sql3) > 0)
								{
									$a_p 	 = $rw['actual_payment'];
									$endbal3 = $rw['end_bal'];
									$deff3   = $rw['deferred_amount'];
									$sched3  = $rw['sched_dedn_amount'];
									$t_end_bal2 += $endbal3;
								}
							}
							else 
							{
								$endbal3 = $row5['end_bal'];
								$a_p = $row5['actual_payment'];
								$deff3 = $row5['deferred_amount'];
								$sched3 = $row5['sched_dedn_amount'];	
								
							}
							
							if ($row5['prod'] != 'L-FS03' && $row5['prod'] != 'L-FSVC' && $row5['prod'] != 'Ins' && $row5['prod'] != 'INS' && $row5['prod'] != 'L-FS04')
							{
								$principal2 = $row5['beginning_bal'] - $a_p;
								$sub_total += $principal2;
							}
							else
							{
								$principal2 = 0;
							}
							$principal2 = 0;
						}
						
						$end_bal3 = number_format($row5['beginning_bal'] - $a_p,2,".",",");
						$sched_dedn_amt3 = number_format($sched3,2,".",",");
						$actual_pay3 = number_format($a_p,2,".",",");
						$deferred3 = number_format($deff3,2,".",",");
						$semi3 = number_format($row5['semi_monthly_amort'],2,".",",");				
						
						$t_actual_pay2 += $a_p;
						$t_semi2 += $row5['semi_monthly_amort'];
						
						
						# not including INS and MPL in total end balance
						#=================================================================================#
						if ($row5['prod'] != 'Ins' && $row5['prod'] != 'INS' && $row5['prod'] != 'L-FS04')
						{
							$t_end_bal2 += $row5['end_bal'];#($row5['beginning_bal'] - $a_p );
							$t_dedn_amt2 += $sched3;
							$t_deferr2 += $deff3;
						}	
						#==================================================================================#
						#===============================================#
						if ($row3['prod'] == 'L-FS04')	
						{	
							$semi3 = number_format($row5[''],2,".",",");	
							$t_semi2 -= $row5['semi_monthly_amort'];
						}
						#===============================================#
						$t_principal += $principal2;
						
						$pdf->SetX(3);
						$pdf->SetFont('Arial','',8);
						$pdf->Cell(9,5,$row5['trans_type_sdesc'],0,0,'L');
						$pdf->Cell(25,5,$row5['this_po_number'],0,0,'L');
						$pdf->Cell(22,5,$row5['dr_number'],0,0,'L');
						$pdf->Cell(16,5,date("m/d/Y",strtotime($row5['end_dt'])),0,0,'C');
						$pdf->Cell(18,5,$sched_dedn_amt3,0,0,'R');
						$pdf->Cell(18,5,$actual_pay3,0,0,'R');
						$pdf->Cell(18,5,$deferred3,0,0,'R');
						$pdf->Cell(19,5,$semi3,0,0,'R');
						$pdf->Cell(20,5,$endbal3,0,0,'R');
						$pdf->Cell(20,5,number_format($principal2,2,".",","),0,0,'R');	
						#$pdf->Cell(10,5,'A',0,0,'C');	
						$pdf->Cell(25,5,substr($row5['Prod_Name'],0,15),0,1,'L');
					}	
				}
		
		
		
		//-----------------------------------------------------------------------------------------------------------------------------------------------
							   
				$chkOR_full = "SELECT *
							   FROM or_header A
							   LEFT JOIN or_details B ON A.or_id = B.or_id
							   #LEFT JOIN p_sales_header C ON B.po_num = C.po_number
							   WHERE A.member_id = {$member_id}
							   AND is_fully_paid = 1
							   AND or_date >= '$lastBilling'";
							   
				$resultOR_full = mysql_query($chkOR_full) or die (mysql_error() . "Error in Query : ". $chkOR_full);
				
				while ($row_full = mysql_fetch_array($resultOR_full, MYSQL_ASSOC))
				{	
					$header_p = "SELECT * FROM p_sales_header WHERE po_number = '{$row_full['po_num']}'";
					$query_p = mysql_query($header_p);
					$row_p = mysql_fetch_array($query_p);
					
					$sr_mora = 0;
					
					$po = substr($row_full['po_num'],-1);
					if($po == 'T')
						$po_n = "CONCAT(B.po_number,'-T')";
					elseif($po == 'P')
						$po_n = "CONCAT(B.po_number,'-P')";
					elseif($po == '2')
						{
						if((substr($row_full['po_num'],-2)) == 'T2')
							{
							$po_n = "CONCAT(B.po_number,'-T2')";
							}
						else 
							$po_n = "B.po_number";
						}
					else 
						$po_n = "B.po_number";
					
					
					if($row_p['moratorium'] == 1)
					{
						if( strtotime($row_p['po_start_date']) > strtotime($lastBilling) )
						{
							$query3 = "SELECT *,
								    B.interest as intrst,
									A.po_number as this_po_number,
									po_start_date,
									pay_period, 
									beginning_bal,
									B.prod_id as prod,
									trans_type_sdesc
							FROM ar_member_subs_detail_history A
							   LEFT JOIN p_sales_header B ON A.po_number = $po_n
							   AND A.member_id = B.member_id
							   LEFT JOIN m_loan_products C ON B.prod_id = C.prod_id		
							   LEFT JOIN m_transaction_types D ON A.trans_type= D.trans_id
							WHERE A.po_number = '{$row_full['po_num']}'
							AND B.po_start_date > '$lastBilling'
							AND po_status != 5
							GROUP BY A.po_number";
							
							$sr_mora = 1;
						}
						
					}
					elseif($row_p['Prod_Id'] == 'L-FS04') #MPL
					{
						$query3 = "SELECT *,
								    B.interest as intrst,
									A.po_number as this_po_number,
									po_start_date,
									pay_period, 
									beginning_bal,
									B.prod_id as prod,
									trans_type_sdesc
							FROM ar_member_subs_detail_history A
							   LEFT JOIN p_sales_header B ON A.po_number = $po_n
							   AND A.member_id = B.member_id
							   LEFT JOIN m_loan_products C ON B.prod_id = C.prod_id		
							   LEFT JOIN m_transaction_types D ON A.trans_type= D.trans_id
							WHERE A.po_number = '{$row_full['po_num']}'
							AND A.pay_period >= '$lastBilling'
							AND po_status != 5";
					}
					else
					{
						$query3 = "SELECT *,
								    B.interest as intrst,
									A.po_number as this_po_number,
									po_start_date,
									pay_period, 
									beginning_bal,
									B.prod_id as prod,
									trans_type_sdesc
							FROM ar_member_subs_detail_history A
							   LEFT JOIN p_sales_header B ON A.po_number = $po_n
							   AND A.member_id = B.member_id
							   LEFT JOIN m_loan_products C ON B.prod_id = C.prod_id		
							   LEFT JOIN m_transaction_types D ON A.trans_type= D.trans_id
							WHERE A.po_number = '{$row_full['po_num']}'
							AND A.pay_period = '$lastBilling'
							AND po_status != 5";
					}
					
					
					$result3 = mysql_query($query3) or die (mysql_error().$query3);	
					while($row3 = mysql_fetch_array($result3, MYSQL_ASSOC))
					{
						$last_cutoff = getLastBilling();
						
						$qr = "SELECT * FROM p_sales_rebate WHERE po_number = '{$row3['this_po_number']}'";
								$rr = mysql_query($qr);
								$rwr = mysql_fetch_array($rr, MYSQL_ASSOC);
						$rbt = is_null($rwr['rebate_40']) ? 0 : $rwr['rebate_40'];
						
						if ($_GET['date'] == 0)
						{/*
							$sqlJ = "SELECT *
									 FROM ar_member_subs_detail_temp
									 WHERE po_number = '{$row3['this_po_number']}'
									 AND pay_period = '$lastBilling'";
							$res_SqlJ = mysql_query($sqlJ) or die (mysql_error().$sqlJ);
							$rowJ = mysql_fetch_array($res_SqlJ, MYSQL_ASSOC);
							if(mysql_num_rows($res_SqlJ) > 0)
							{
								$rbt += $rowJ['actual_payment'];
							}
							elseif(mysql_num_rows($res_SqlJ) == 0 && $row3['actual_payment'] > 0 && $row3['deferred_amount'] == 0 && $row3['prod'] == 'L-FS05')
							{
								$rbt -= $row3['actual_payment'];
							}
							
							$rbt += $row3['actual_payment'];
							$a_p = 0;*/
							#-------------------------------------------------------------------------------------------------
							/*$queryZ = "SELECT amt as t_ap FROM or_details
									   WHERE po_num = '{$row3['this_po_number']}'
										   ORDER BY or_id DESC";*/
							$queryZ = "SELECT SUM(amt) as t_ap FROM or_details
									   LEFT JOIN or_header USING(or_id)
									   WHERE po_num = '{$row3['this_po_number']}'
									   AND pay_period = '$lastBilling'";	
									   
							$resultZ = mysql_query($queryZ);
							$rowZ = mysql_fetch_array($resultZ);
							$advance = $rowZ['t_ap'];
							$a_p = $advance;
							$endbal3 = 0;
							$deff3 = 0;
							$sched3 = 0;
							$principal2 = 0;
							
							#$t_end_bal2 -= $rbt;
							#-------------------------------------------------------------------------------------------------
						}
						else
						{	
							
							if($sr_mora == 0)
							{			      
								$chkOR_contrib = "SELECT sum(amt) as or_amount, pay_period1, pay_period2
												  FROM or_header A 
												  INNER JOIN or_details B on A.or_id = B.or_id
											      WHERE po_num = '{$row3['this_po_number']}'
												  AND or_date >= '$lastBilling'
												  AND or_date <= '$nxtBilling'
												  AND member_id = {$member_id}
												  GROUP BY po_num";
												  
								$resultOR_contrib = mysql_query($chkOR_contrib) or die (mysql_error() . "Error in Query : ". $chkOR_contrib);
								$rowOR = mysql_fetch_array($resultOR_contrib, MYSQL_ASSOC);
								
								#=====================================================================#
								$or_contrib = is_null($rowOR['or_amount']) ? 0 : $rowOR['or_amount'];
								#=====================================================================#
								
								if ($_GET['date'] == $last_cutoff)
								{
									
										
									$queryZ = "SELECT SUM(actual_payment) AS t_ap FROM ar_member_subs_detail_history 
												WHERE po_number = '{$row3['this_po_number']}' AND pay_period > '$lastBilling'";
									$resultZ = mysql_query($queryZ);
									$rowZ = mysql_fetch_array($resultZ);
									
								    if (!is_null($rowOR['or_amount']))
								    {														
										$sql3 = "SELECT *
												FROM ar_member_subs_detail_temp
												WHERE po_number = '{$row3['this_po_number']}'
												AND pay_period = '$lastBilling'";
												
										$row_sql3 = mysql_query($sql3) or die (mysql_error() . "Error in Query : ". $sql3);
										$rw = mysql_fetch_array($row_sql3);
										if(mysql_num_rows($row_sql3) > 0)
										{
											$a_p 	 = $rw['actual_payment'];
											$endbal3 = $rw['end_bal'];
											$deff3   = $rw['deferred_amount'];
											$sched3  = $rw['sched_dedn_amount'];
										}
										else
										{
											$a_p 	 = $row3['actual_payment'] - (($or_contrib - $rbt) - ($rowZ['t_ap']) + $rbt);
											$deff3   = $row3['sched_dedn_amount'] - $a_p;
											$endbal3 = $row3['Prod_Id'] == 'L-FS03' ? $row3['end_bal'] : ($row3['beginning_bal'] - $a_p);
											$sched3  = $row3['sched_dedn_amount'];
										}
									}
									else
									{
										$a_p 	 = $row3['actual_payment'];
										$endbal3 = $row3['end_bal'];
										$deff3   = $row3['deferred_amount'];
										$sched3  = $row3['sched_dedn_amount'];	
									}
								}
								else 
								{
									$endbal3 = $row3['end_bal'];
									$a_p = $row3['actual_payment'];
									$deff3 = $row3['deferred_amount'];
									$sched3 = $row3['sched_dedn_amount'];	
								}
								
								if ($row3['prod'] != 'L-FS03' && $row3['prod'] != 'L-FSVC' && $row3['prod'] != 'Ins' && $row3['prod'] != 'INS' && $row3['prod'] != 'L-FS04')
								{
								$principal2 = 0;#$row3['beginning_bal'] - $a_p;
								$sub_total += 0;#$principal2;
								}
								else
								$principal2 = 0;
							}
						}
						
						if($sr_mora == 1 AND $_GET['date'] != 0)
						{
							$a_p = 0;
							$endbal3 = number_format($row3['beginning_bal'],2,".",",");	
							$sched_dedn_amt3 = number_format(0,2,".",",");
							$actual_pay3 = number_format(0,2,".",",");
							$deferred3 = number_format(0,2,".",",");
							$semi3 = number_format($row3['semi_monthly_amort'],2,".",",");	
						}
						else
						{
							$end_bal3 = number_format($row3['beginning_bal'] - $a_p,2,".",",");
							$sched_dedn_amt3 = number_format($sched3,2,".",",");
							$actual_pay3 = number_format($a_p,2,".",",");
							$deferred3 = number_format($deff3,2,".",",");
							$semi3 = number_format($row3['semi_monthly_amort'],2,".",",");
						}	
			
						$t_actual_pay2 += $a_p;
						$t_semi2 += $row3['semi_monthly_amort'];
						
						if ($row3['prod'] != 'Ins' && $row3['prod'] != 'INS' && $row3['prod'] != 'L-FS04')	
							$t_end_bal2 += $endbal3;#($row3['beginning_bal'] - $a_p );
							$t_dedn_amt2 += $sched3;
							$t_deferr2 += $deff3;
						
						
						if ($row3['prod'] == 'L-FS04')	
							{	
							$semi3 = number_format($row3[''],2,".",",");	
							$t_semi2 -= $row3['semi_monthly_amort'];
							}
						$t_principal += $principal2;	
						$pdf->SetX(3);
						$pdf->SetFont('Arial','',8);
						$pdf->Cell(9,5,$row3['trans_type_sdesc'],0,0,'L');
						$pdf->Cell(25,5,$row3['this_po_number'],0,0,'L');
						$pdf->Cell(22,5,$row3['dr_number'],0,0,'L');
						$pdf->Cell(16,5,date("m/d/Y",strtotime($row3['end_dt'])),0,0,'C');
						$pdf->Cell(18,5,$sched_dedn_amt3,0,0,'R');
						$pdf->Cell(18,5,$actual_pay3,0,0,'R');
						$pdf->Cell(18,5,$deferred3,0,0,'R');
						$pdf->Cell(19,5,$semi3,0,0,'R');
						$pdf->Cell(20,5,$endbal3,0,0,'R');
						$pdf->Cell(20,5,number_format($principal2,2,".",","),0,0,'R');	
						#$pdf->Cell(10,5,'A',0,0,'C');	
						$pdf->Cell(25,5,substr($row3['Prod_Name'],0,15),0,1,'L');
						/*echo "
								<tr><td colspan=\"11\"></td></tr>
								<tr class=\"normal\">
									<td class = 'td'>{$row3['trans_type_sdesc']}</td>
									<td class = 'td'>{$row3['this_po_number']}</td>
									<td class = 'td'>{$row3['dr_number']}</td>
									<td class = 'td'>".date("m/d/Y",strtotime($row3['end_dt']))."</td>
									<td class = 'td' align=\"right\">$sched_dedn_amt3</td>
									<td class = 'td' align=\"right\">$actual_pay3</td>
									<td class = 'td' align=\"right\">$deferred3</td>
									<td class = 'td' align=\"right\">$semi3</td>
									<td class = 'td' align=\"right\"><span style=\"color: red; font-size: 10px; font-weight: 700;\">**</span>".number_format($endbal3,2,".",",")."</td>
									<td class = 'td' align=\"right\">".number_format($principal2,2,".",",")."</td>
									<td class = 'td'>{$row3['Prod_Name']}</td>
								</tr>
								";*/
						$x++;
						}	
				}
				//-----------------------------------------------------------------------------------------------------------------------------------------------	
				$chkfull = "SELECT *
							FROM m_fully_paid
							WHERE is_fully_paid = 1
							AND pay_period >= '$lastBilling'
							AND member_id = {$member_id}";
				$chkfull_res = mysql_query($chkfull) or die (mysql_error().$chkfull);
				
				while ($row_fulls = mysql_fetch_array($chkfull_res, MYSQL_ASSOC))
				{
					
					$po = substr($row_fulls['po_number'],-1);
					if($po == 'T')
						$po_n = "CONCAT(B.po_number,'-T')";
					elseif($po == 'P')
						$po_n = "CONCAT(B.po_number,'-P')";
					elseif($po == '2')
						{
						if((substr($row_fulls['po_number'],-2)) == 'T2')
							{
							$po_n = "CONCAT(B.po_number,'-T2')";
							}
						else 
							$po_n = "B.po_number";
						}
					else 
						$po_n = "B.po_number";
					
					$query4 = "SELECT *,
								    B.interest as intrst,
									A.po_number as this_po_number,
									po_start_date,
									pay_period, 
									beginning_bal,
									B.prod_id as prod,
									trans_type_sdesc,
									B.semi_mo_amor as semi
							FROM ar_member_subs_detail_history A
							   LEFT JOIN p_sales_header B ON A.po_number = $po_n
							   AND A.member_id = B.member_id
							   LEFT JOIN m_loan_products C ON B.prod_id = C.prod_id		
							   LEFT JOIN m_transaction_types D ON A.trans_type= D.trans_id
							WHERE A.po_number = '{$row_fulls['po_number']}'
							AND A.pay_period = '$lastBilling'
							AND B.Prod_Id NOT IN ('L-FS04')
							AND po_status != 5
							AND A.post_ar_date IS NOT NULL";
							
					$result4 = mysql_query($query4) or die (mysql_error().$query3);	
					while($row4 = mysql_fetch_array($result4, MYSQL_ASSOC))
					{
						$mpl_name = get_mpl_name($row4['pay_period']);
						
						if ($_GET['date'] == 0)
						{
							$a_p = 0;
							$endbal3 = 0;
							$deff3 = 0;
							$sched3 = 0;
							$principal2 = 0;
							$semi4 = 0;
							
							if($row4['prod'] != 'L-FS04')
								$t_end_bal2 -= $row4['actual_payment'];
							
						}
						else
						{
							$principal2 = 0;
							$endbal3 = $row4['end_bal'];
							$a_p = $row4['actual_payment'];
							$deff3 = $row4['deferred_amount'];
							$sched3 = $row4['sched_dedn_amount'];	
							$semi4 = 0;#$row4['semi'];
						}
						
						$end_bal3 = ($row4['beginning_bal'] - $a_p);
						$sched_dedn_amt3 = $sched3;#number_format($sched3,2,".",",");
						$actual_pay3 = $a_p;#number_format($a_p,2,".",",");
						$deferred3 = $deff3;#number_format($deff3,2,".",",");
						$semi3 = $semi4;#number_format($semi4,2,".",",");		
								
						$actual_pay3 = $actual_pay3 <=0 ? number_format(0,2,".",",") : $actual_pay3;
						
						$sched_dedn_amt3 = $sched_dedn_amt3 <=0 ? number_format(0,2,".",",") : $sched_dedn_amt3;
						
						$t_actual_pay2 += $actual_pay3;
						
						$t_semi2 += $row4['semi'];
						
						
						/* not including INS and MPL in total end balance*/
						#=================================================================================#
						if ($row4['prod'] != 'Ins' && $row4['prod'] != 'INS' && $row4['prod'] != 'L-FS04')
						{
							$t_end_bal2 += ($row4['beginning_bal'] - $a_p );
							$t_dedn_amt2 += $sched3;
							$t_deferr2 += $deff3;
						}	
						#==================================================================================#
						#===============================================#
						if ($row4['prod'] == 'L-FS04')	
						{	
							$semi3 = number_format($row4[''],2,".",",");	
							$t_semi2 -= $row4['semi'];
						}
						#===============================================#
						#$t_principal += $principal2;
						
						$pdf->SetX(3);
						$pdf->SetFont('Arial','',8);
						$pdf->Cell(9,5,'a'.$row4['trans_type_sdesc'],0,0,'L');
						$pdf->Cell(25,5,$row4['this_po_number'],0,0,'L');
						$pdf->Cell(22,5,$row4['dr_number'],0,0,'L');
						$pdf->Cell(16,5,date("m/d/Y",strtotime($row4['end_dt'])),0,0,'C');
						$pdf->Cell(18,5,$sched_dedn_amt3,0,0,'R');
						$pdf->Cell(18,5,$actual_pay3,0,0,'R');
						$pdf->Cell(18,5,$deferred3,0,0,'R');
						$pdf->Cell(19,5,$semi3,0,0,'R');
						$pdf->Cell(20,5,$endbal3,0,0,'R');
						$pdf->Cell(20,5,number_format($principal2,2,".",","),0,0,'R');	
						#$pdf->Cell(10,5,'A',0,0,'C');	
						$pdf->Cell(25,5,substr($row4['Prod_Name'],0,15),0,1,'L');
						
						$x++;
					}
				}
				
				
				//-----------------------------------------------------------------------------------------------------------------------------------------------	
	
		
		#$pdf->SetX(1);#,$ys);
		$pdf->Ln(1);
		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(65,5,'Total Payroll Accounts',T,0,'R');
		$pdf->Cell(18,5,number_format($t_dedn_amt2,2,".",","),1,0,'R');
		$pdf->Cell(18,5,number_format($t_actual_pay2,2,".",","),1,0,'R');
		$pdf->Cell(18,5,number_format($t_deferr2,2,".",","),1,0,'R');
		$pdf->Cell(19,5,number_format($t_semi2,2,".",","),1,0,'R');
		$pdf->Cell(20,5,number_format($t_end_bal2,2,".",","),1,0,'R');
		$pdf->Cell(20,5,number_format($sub_total,2,".",","),1,1,'R');
			
		$g_dedn_amt = $t_dedn_amt2 + $t_dedn_amt;
		$g_actual_pay = $t_actual_pay2 + $t_actual_pay;
		$g_deferr = $t_deferr2 + $t_deferr;
		$g_semi = $t_semi2 + $t_semi;
		$g_end_bal = $t_end_bal2; #+ $t_end_bal;
		
		$pdf->Ln(1);
		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(65,5,'',0,0,'R');
		$pdf->Cell(18,5,number_format($g_dedn_amt,2,".",","),1,0,'R');
		$pdf->Cell(18,5,number_format($g_actual_pay,2,".",","),1,0,'R');
		$pdf->Cell(18,5,number_format($g_deferr,2,".",","),1,0,'R');
		$pdf->Cell(19,5,number_format($g_semi,2,".",","),1,1,'R');
		
		#$pdf->Ln(2);
		
		#MPL POSTING LAST BILLING
	#--------------------------------------------------#	
		$mpl_last_billing = mpl_last_billing();
		$mpl_last_billing_nxt = get_next_ben_month($mpl_last_billing);
		
		$today_mpl = date("Y-m-d");
		
		$query_mpl = "SELECT *, C.interest as intrst, A.po_number as this_po_number , po_start_date, pay_period, beginning_bal, 
								C.commission, C.prod_id as prod, trans_type_sdesc
					  FROM ar_member_subs_detail A 
							LEFT JOIN m_transaction_types B on A.trans_type = B.trans_id
							LEFT JOIN p_sales_header C on A.po_number = C.po_number
							LEFT JOIN m_loan_products D on C.prod_id = D.prod_id
					  WHERE A.member_id = {$member_id} 
					  AND A.pay_period = '$mpl_last_billing'  
					  AND C.prod_id = 'L-FS04'  
					  AND po_status != 5
					  ORDER BY A.po_number";	
					  
		#echo $query_mpl;			  			
				
		//(SELECT MAX(pay_period) FROM ar_member_subs WHERE member_id = $member_id GROUP BY member_id LIMIT 1)
		$result_mpl = mysql_query($query_mpl) or die (mysql_error().$query_mpl);
		
		$one_mpl = mysql_num_rows($result_mpl);
		
		$pdf->SetFont('Arial','',8);
		$t_dedn_amt_mpl =0;
		$t_actual_pay_mpl =0;
		$t_deferr_mpl =0;
		$t_semi_mpl =0;
		$t_end_bal_mpl =0;
		while($row_mpl = mysql_fetch_array($result_mpl, MYSQL_ASSOC))
		{
			
			
			$mpl_name = get_mpl_name($row_mpl['pay_period']);
			
			#START OF CHECKING
			$mpl_date = "$year-$prev_month-15"; 
			
			$sql_mpl2 = "SELECT *
						 FROM ar_member_subs_detail
						 WHERE po_number = '{$row_mpl['this_po_number']}'
						 AND pay_period = '$mpl_last_billing'";
						 
			$result = mysql_query($sql_mpl2) or die(mysql_error().$sql_mpl2);	
			
			if(mysql_num_rows($result) > 0)
			{
				
				#FOR UPDATE
				$chkOR_contrib_mpl = "SELECT sum(amt) as or_amount, pay_period1, pay_period2 FROM or_header A 
								  INNER JOIN or_details B on A.or_id = B.or_id
							      WHERE po_num = '{$row_mpl['this_po_number']}' 
							      AND or_date > '$mpl_last_billing' 
							      AND or_date <= '$mpl_last_billing_nxt'
								  AND member_id = {$member_id}
							      GROUP BY po_num";
				$resultOR_contrib_mpl = mysql_query($chkOR_contrib_mpl) or die (mysql_error() . "Error in Query : ". $chkOR_contrib_mpl);
				$rowOR_mpl = mysql_fetch_array($resultOR_contrib_mpl, MYSQL_ASSOC);
				$or_contrib_mpl = is_null($rowOR_mpl['or_amount']) ? 0 : $rowOR_mpl['or_amount'];
				
				$queryZ_mpl = "SELECT SUM(actual_payment) AS t_ap 
							   FROM ar_member_subs_detail 
							   WHERE po_number = '{$row_mpl['this_po_number']}' 
							   AND pay_period > '$mpl_last_billing'";
				$resultZ_mpl = mysql_query($queryZ_mpl);
				$rowZ_mpl = mysql_fetch_array($resultZ_mpl);
				/*
				if ($_GET['date'] == 0)
				{
					#advance payments						
					$end_bal_mpl = $row_mpl['end_bal'] - $rowZ_mpl['t_ap'];
					$a_p_mpl = $or_contrib_mpl;
					$deferred_mpl = number_format($row_mpl['deferred_amount'],2,".",",");
					$t_deferr2 += $row_mpl['deferred_amount'];
					$t_end_bal_mpl += $row_mpl['end_bal'] - $rowZ_mpl['t_ap'];
					$t_deferr_mpl += $row_mpl['deferred_amount'];
				}
				else
				{
				*/		
					if (!is_null($rowOR_mpl['or_amount']))
					{						
						$a_p_mpl = $row_mpl['actual_payment'] - ($or_contrib_mpl - $rowZ_mpl['t_ap']);										
						$deferred_mpl = ($row_mpl['sched_dedn_amount'] - $a_p_mpl);			
						$end_bal_mpl = ($row_mpl['beginning_bal'] - $a_p_mpl);
						#$end_bal2 = $row2['Prod_Id'] == 'L-FS03' ? $row2['end_bal'] : ($row2['beginning_bal'] - $a_p);		
						if ( $row_mpl['prod'] != 'L-FS04'){
							$t_deferr2 += $deferred_mpl;
						}
						
						$t_deferr_mpl += $deferred_mpl;
						$deferred_mpl = number_format($deferred_mpl,2,".",",");
						$t_end_bal_mpl += ($row_mpl['beginning_bal'] - $a_p_mpl);
						
					}
					else 
					{
						$end_bal_mpl  = $row_mpl['end_bal'];
						$a_p_mpl	   = $row_mpl['actual_payment'];
						$deferred_mpl = number_format($row_mpl['deferred_amount'],2,".",",");
						
						$t_deferr_mpl += $row_mpl['deferred_amount'];
						
						$t_end_bal_mpl += $row_mpl['end_bal'];
					}				
					
				#}
				
				$sched_dedn_amt_mpl = number_format($row_mpl['sched_dedn_amount'],2,".",",");
				$actual_pay_mpl = number_format($a_p_mpl,2,".",",");		
				$semi_mpl = number_format($row_mpl['semi_monthly_amort'],2,".",",");
				
				
				$t_actual_pay2 += $a_p_mpl;		
				$t_semi2 += $row_mpl['semi_monthly_amort'];
				
				if (is_null($row_mpl['post_ar_by']) && date("Y-m-d") == $lastBilling )
				{			
					$ending = $row_mpl['beginning_bal'];
					$pd_left = (int)$row_mpl['paydays_left'] - 1;
				}
				else 
				{			
					$ending = $row_mpl['end_bal'];
					$pd_left = (int)$row_mpl['paydays_left'];
				}
				
				$principal = 0;
				
				if ($row_mpl['prod'] == 'L-FS04')	
				{	
					$semi_mpl = number_format($row_mpl['semi_monthly_amort'],2,".",",");	
					$t_semi2 -= $row_mpl['semi_monthly_amort'];
				}	
					
				$t_principal += $principal;	
				//$pdf->SetXY(3,$ys);
				$pdf->SetX(3);
				
				$pdf->Cell(9,5,$row_mpl['trans_type_sdesc'],0,0,'L');
				$pdf->Cell(25,5,$row_mpl['this_po_number'],0,0,'L');
				$pdf->Cell(22,5,$row_mpl['dr_number'],0,0,'L');
				$pdf->Cell(16,5,date("m/d/Y",strtotime($row_mpl['end_dt'])),0,0,'C');
				$pdf->Cell(18,5,$sched_dedn_amt_mpl,0,0,'R');
				$pdf->Cell(18,5,$actual_pay_mpl,0,0,'R');
				$pdf->Cell(18,5,$deferred_mpl,0,0,'R');
				$pdf->Cell(19,5,$semi_mpl,0,0,'R');
				$pdf->Cell(20,5,number_format($end_bal_mpl,2,".",","),0,0,'R');
				$pdf->Cell(20,5,number_format($principal,2,".",","),0,0,'R');	
				#$pdf->Cell(10,5,'A',0,0,'C');	
				$pdf->Cell(25,5,substr($row_mpl['Prod_Name'],0,15).$mpl_name,0,1,'L');
				$ys+=5;
				
				$t_dedn_amt_mpl += $row_mpl['sched_dedn_amount'];
				$t_actual_pay_mpl += $a_p_mpl;
				
				$t_semi_mpl +=$row_mpl['semi_monthly_amort'];
				
			}
		}
			
				
		$chkfull = "SELECT *
					FROM m_fully_paid
					WHERE is_fully_paid = 1
					AND pay_period >= '$mpl_last_billing'
					AND member_id = {$member_id}";
		$chkfull_res = mysql_query($chkfull) or die (mysql_error().$chkfull);
		
		$two_mpl = mysql_num_rows($chkfull_res);
		
		if($one_mpl > 0 OR $two_mpl > 0)
		{
		
		while ($row_fulls = mysql_fetch_array($chkfull_res, MYSQL_ASSOC))
		{
			
			$po = substr($row_fulls['po_number'],-1);
			if($po == 'T')
				$po_n = "CONCAT(B.po_number,'-T')";
			elseif($po == 'P')
				$po_n = "CONCAT(B.po_number,'-P')";
			elseif($po == '2')
				{
				if((substr($row_fulls['po_number'],-2)) == 'T2')
					{
					$po_n = "CONCAT(B.po_number,'-T2')";
					}
				else 
					$po_n = "B.po_number";
				}
			else 
				$po_n = "B.po_number";
			
			$query4 = "SELECT *,
						    B.interest as intrst,
							A.po_number as this_po_number,
							po_start_date,
							pay_period, 
							beginning_bal,
							B.prod_id as prod,
							trans_type_sdesc,
							B.semi_mo_amor as semi
					FROM ar_member_subs_detail_history A
					   LEFT JOIN p_sales_header B ON A.po_number = $po_n
					   AND A.member_id = B.member_id
					   LEFT JOIN m_loan_products C ON B.prod_id = C.prod_id		
					   LEFT JOIN m_transaction_types D ON A.trans_type= D.trans_id
					WHERE A.po_number = '{$row_fulls['po_number']}'
					AND A.pay_period >= '$mpl_last_billing'
					AND B.Prod_Id IN ('L-FS04')
					AND po_status != 5
					AND A.post_ar_date IS NOT NULL";
					
			$result4 = mysql_query($query4) or die (mysql_error().$query3);	
			while($row4 = mysql_fetch_array($result4, MYSQL_ASSOC))
			{
				$mpl_name = get_mpl_name($row4['pay_period']);
				
				/*if ($_GET['date'] == 0)
				{
					$a_p = 0;
					$endbal3 = 0;
					$deff3 = 0;
					$sched3 = 0;
					$principal2 = 0;
					$semi4 = 0;
					
					if($row4['prod'] != 'L-FS04')
						$t_end_bal2 -= $row4['actual_payment'];
					
				}
				else
				{*/
					$principal2 = 0;
					$endbal3 = $row4['end_bal'];
					$a_p = $row4['actual_payment'];
					$deff3 = $row4['deferred_amount'];
					$sched3 = $row4['sched_dedn_amount'];	
					$semi4 = 0;#$row4['semi'];
				#}
				
				$end_bal3 = ($row4['beginning_bal'] - $a_p);
				$sched_dedn_amt3 = $sched3;#number_format($sched3,2,".",",");
				$actual_pay3 = $a_p;#number_format($a_p,2,".",",");
				$deferred3 = $deff3;#number_format($deff3,2,".",",");
				$semi3 = $semi4;#number_format($semi4,2,".",",");		
						
				$actual_pay3 = $actual_pay3 <=0 ? number_format(0,2,".",",") : $actual_pay3;
				
				$sched_dedn_amt3 = $sched_dedn_amt3 <=0 ? number_format(0,2,".",",") : $sched_dedn_amt3;
				
				$t_actual_pay2 += $actual_pay3;
				
				$t_semi2 += $row4['semi'];
				
				
				#===============================================#
				if ($row4['prod'] == 'L-FS04')	
				{	
					$semi3 = number_format($row4[''],2,".",",");	
					$t_semi2 -= $row4['semi'];
				}
				#===============================================#
				#$t_principal += $principal2;
				
				$pdf->SetX(3);
				$pdf->SetFont('Arial','',8);
				$pdf->Cell(9,5,$row4['trans_type_sdesc'],0,0,'L');
				$pdf->Cell(25,5,$row4['this_po_number'],0,0,'L');
				$pdf->Cell(22,5,$row4['dr_number'],0,0,'L');
				$pdf->Cell(16,5,date("m/d/Y",strtotime($row4['end_dt'])),0,0,'C');
				$pdf->Cell(18,5,number_format($sched_dedn_amt3,2,".",","),0,0,'R');
				$pdf->Cell(18,5,number_format($actual_pay3,2,".",","),0,0,'R');
				$pdf->Cell(18,5,$deferred3,0,0,'R');
				$pdf->Cell(19,5,$semi3,0,0,'R');
				$pdf->Cell(20,5,$endbal3,0,0,'R');
				$pdf->Cell(20,5,number_format($principal2,2,".",","),0,0,'R');	
				#$pdf->Cell(10,5,'A',0,0,'C');	
				$pdf->Cell(25,5,substr($row4['Prod_Name'],0,15).$mpl_name,0,1,'L');
				
				$t_dedn_amt_mpl += $row4['sched_dedn_amount'];
				$t_actual_pay_mpl += $a_p;
				
				$t_semi_mpl +=$row4['semi'];
				
				
				$ys+=5;
			}
		}
		
		
	
		
		
		
		$pdf->Ln(1);
		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(65,5,'Total MPL Accounts',T,0,'R');
		$pdf->Cell(18,5,number_format($t_dedn_amt_mpl,2,".",","),1,0,'R');
		$pdf->Cell(18,5,number_format($t_actual_pay_mpl,2,".",","),1,0,'R');
		$pdf->Cell(18,5,number_format($t_deferr_mpl,2,".",","),1,0,'R');
		$pdf->Cell(19,5,number_format($t_semi_mpl,2,".",","),1,0,'R');
		$pdf->Cell(20,5,number_format($t_end_bal_mpl,2,".",","),1,0,'R');
		$pdf->Cell(20,5,number_format($sub_total_mpl,2,".",","),1,1,'R');
		
		$g_end_bal += $t_end_bal_mpl;
		
		}
		
		$query_mpl = "SELECT *, C.interest as intrst, A.po_number as this_po_number , po_start_date, pay_period, beginning_bal, 
								C.commission, C.prod_id as prod, trans_type_sdesc
					  FROM ar_member_subs_detail A 
							LEFT JOIN m_transaction_types B on A.trans_type = B.trans_id
							LEFT JOIN p_sales_header C on A.po_number = C.po_number
							LEFT JOIN m_loan_products D on C.prod_id = D.prod_id
					  WHERE A.member_id = {$member_id} 
					  AND A.pay_period > '$mpl_last_billing'  
					  AND C.prod_id = 'L-FS04'  
					  AND po_status != 5
					  #ORDER BY pay_period DESC,po_start_date DESC";				
				
		//(SELECT MAX(pay_period) FROM ar_member_subs WHERE member_id = $member_id GROUP BY member_id LIMIT 1)
		$result_mpl = mysql_query($query_mpl) or die (mysql_error().$query_mpl);
		
		$three_mpl = mysql_num_rows($result_mpl);
		
		if($three_mpl > 0)
		{
		
		$pdf->SetFont('Arial','',8);
		$t_dedn_amt_mpl =0;
		$t_actual_pay_mpl =0;
		$t_deferr_mpl =0;
		$t_semi_mpl =0;
		$t_end_bal_mpl =0;
		while($row_mpl = mysql_fetch_array($result_mpl, MYSQL_ASSOC))
		{
			$mpl_name = get_mpl_name($row_mpl['pay_period']);
			
			#START OF CHECKING
			$mpl_date = "$year-$prev_month-15"; 
			
			$sql_mpl2 = "SELECT *
						 FROM ar_member_subs_detail
						 WHERE po_number = '{$row_mpl['this_po_number']}'
						 AND pay_period = '{$row_mpl['pay_period']}'";
						 
			$result = mysql_query($sql_mpl2) or die(mysql_error().$sql_mpl2);	
			
			if(mysql_num_rows($result) > 0)
			{
			
				$chkOR_contrib_mpl = "SELECT sum(amt) as or_amount, pay_period1, pay_period2 FROM or_header A 
								  INNER JOIN or_details B on A.or_id = B.or_id
							      WHERE po_num = '{$row_mpl['this_po_number']}' 
							      AND or_date > '$mpl_last_billing' 
							      AND or_date <= '$mpl_last_billing_nxt'
								  AND member_id = {$member_id}
							      GROUP BY po_num";
				$resultOR_contrib_mpl = mysql_query($chkOR_contrib_mpl) or die (mysql_error() . "Error in Query : ". $chkOR_contrib_mpl);
				$rowOR_mpl = mysql_fetch_array($resultOR_contrib_mpl, MYSQL_ASSOC);
				$or_contrib_mpl = is_null($rowOR_mpl['or_amount']) ? 0 : $rowOR_mpl['or_amount'];
				
				$queryZ_mpl = "SELECT SUM(actual_payment) AS t_ap 
							   FROM ar_member_subs_detail 
							   WHERE po_number = '{$row_mpl['this_po_number']}' 
							   AND pay_period > '$mpl_last_billing'";
				$resultZ_mpl = mysql_query($queryZ_mpl);
				$rowZ_mpl = mysql_fetch_array($resultZ_mpl);
				
				if ($_GET['date'] == 0)
				{
					#advance payments						
					$end_bal_mpl = $row_mpl['end_bal'] - $rowZ_mpl['t_ap'];
					$a_p_mpl = $or_contrib_mpl;
					$deferred_mpl = number_format($row_mpl['deferred_amount'],2,".",",");
					$t_deferr2 += $row_mpl['deferred_amount'];
					$t_end_bal_mpl += $row_mpl['end_bal'] - $rowZ_mpl['t_ap'];
					$t_deferr_mpl += $row_mpl['deferred_amount'];
				}
				else
				{
						
					if (!is_null($rowOR_mpl['or_amount']))
					{						
						$a_p_mpl = $row_mpl['actual_payment'] - ($or_contrib_mpl - $rowZ_mpl['t_ap']);										
						$deferred_mpl = ($row_mpl['sched_dedn_amount'] - $a_p_mpl);			
						$end_bal_mpl = ($row_mpl['beginning_bal'] - $a_p_mpl);
						#$end_bal2 = $row2['Prod_Id'] == 'L-FS03' ? $row2['end_bal'] : ($row2['beginning_bal'] - $a_p);		
						if ( $row_mpl['prod'] != 'L-FS04'){
						#	$t_deferr2 += $deferred_mpl;
						}
						
						#$t_deferr_mpl += $deferred_mpl;
						$deferred_mpl = number_format($deferred_mpl,2,".",",");
						#$t_end_bal_mpl += ($row_mpl['beginning_bal'] - $a_p_mpl);
						
					}
					else 
					{
						$end_bal_mpl  = $row_mpl['end_bal'];
						$a_p_mpl	   = $row_mpl['actual_payment'];
						$deferred_mpl = number_format($row_mpl['deferred_amount'],2,".",",");
						
						$t_deferr_mpl += $row_mpl['deferred_amount'];
						
						$t_end_bal_mpl += $row_mpl['end_bal'];
					}				
					
				}
				
				$sched_dedn_amt_mpl = number_format($row_mpl['sched_dedn_amount'],2,".",",");
				$actual_pay_mpl = number_format($a_p_mpl,2,".",",");		
				$semi_mpl = number_format($row_mpl['semi_monthly_amort'],2,".",",");
				
				
				$t_actual_pay2 += $a_p_mpl;		
				$t_semi2 += $row_mpl['semi_monthly_amort'];
				
				if (is_null($row_mpl['post_ar_by']) && date("Y-m-d") == $lastBilling )
				{			
					$ending = $row_mpl['beginning_bal'];
					$pd_left = (int)$row_mpl['paydays_left'] - 1;
				}
				else 
				{			
					$ending = $row_mpl['end_bal'];
					$pd_left = (int)$row_mpl['paydays_left'];
				}
				
				$principal = 0;
				
				if ($row_mpl['prod'] == 'L-FS04')	
				{	
					$semi_mpl = number_format($row_mpl['semi_monthly_amort'],2,".",",");	
					$t_semi2 -= $row_mpl['semi_monthly_amort'];
				}	
					
				$t_principal += $principal;	
				//$pdf->SetXY(3,$ys);
				$pdf->SetX(3);
				
				$pdf->Cell(9,5,$row_mpl['trans_type_sdesc'],0,0,'L');
				$pdf->Cell(25,5,$row_mpl['this_po_number'],0,0,'L');
				$pdf->Cell(22,5,$row_mpl['dr_number'],0,0,'L');
				$pdf->Cell(16,5,date("m/d/Y",strtotime($row_mpl['end_dt'])),0,0,'C');
				$pdf->Cell(18,5,$sched_dedn_amt_mpl,0,0,'R');
				$pdf->Cell(18,5,$actual_pay_mpl,0,0,'R');
				$pdf->Cell(18,5,$deferred_mpl,0,0,'R');
				$pdf->Cell(19,5,$semi_mpl,0,0,'R');
				$pdf->Cell(20,5,number_format($end_bal_mpl,2,".",","),0,0,'R');
				$pdf->Cell(20,5,number_format($principal,2,".",","),0,0,'R');	
				#$pdf->Cell(10,5,'A',0,0,'C');	
				$pdf->Cell(25,5,substr($row_mpl['Prod_Name'],0,15).$mpl_name	,0,1,'L');
				$ys+=5;
				
				$t_dedn_amt_mpl += $row_mpl['sched_dedn_amount'];
				$t_actual_pay_mpl += $a_p_mpl;
				
				$t_semi_mpl +=$row_mpl['semi_monthly_amort'];
				
			}
		}
		
		$pdf->Ln(1);
		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(65,5,'Total MPL Accounts',T,0,'R');
		$pdf->Cell(18,5,number_format($t_dedn_amt_mpl,2,".",","),1,0,'R');
		$pdf->Cell(18,5,number_format($t_actual_pay_mpl,2,".",","),1,0,'R');
		$pdf->Cell(18,5,number_format($t_deferr_mpl,2,".",","),1,0,'R');
		$pdf->Cell(19,5,number_format($t_semi_mpl,2,".",","),1,0,'R');
		$pdf->Cell(20,5,number_format($t_end_bal_mpl,2,".",","),1,0,'R');
		$pdf->Cell(20,5,number_format($sub_total_mpl,2,".",","),1,1,'R');
		
		}
		
		
		$pdf->Ln(2);
		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(65,5,'Grand Total:',0,0,'R');
		$pdf->Cell(18,5,number_format($g_dedn_amt,2,".",","),B,0,'R');
		$pdf->Cell(18,5,number_format($g_actual_pay,2,".",","),B,0,'R');
		$pdf->Cell(18,5,number_format($g_deferr,2,".",","),B,0,'R');
		$pdf->Cell(19,5,number_format($g_semi,2,".",","),B,0,'R');
		$pdf->Cell(20,5,number_format($g_end_bal,2,".",","),B,1,'R');
		$pdf->Ln(1);
		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(65,5,'',0,0,'R');
		$pdf->Cell(18,5,'',T,0,'R');
		$pdf->Cell(18,5,'',T,0,'R');
		$pdf->Cell(18,5,'',T,0,'R');
		$pdf->Cell(19,5,'',T,0,'R');
		$pdf->Cell(20,5,'',T,1,'R');
		
		
		#END
			
		$pdf->SetX(4);	
		$pdf->SetFont('Arial','B',8);
		$pdf->Cell(8,5,'Note:',0,0,'L');	
		$pdf->SetFont('Arial','I',8);
		$pdf->Cell(140,5,'* Insurance not included in total balance.',0,1,'L');
	
		
		$pdf->SetFont('Arial','B',9);
		
		if(isset($_GET['nloan'])){
			$new_loan_dagdag = $_GET['nloan'];
			
			if($new_loan_dagdag > 0){
				$sub_total += $new_loan_dagdag;
				
				$pdf->Cell(172,5,'New Loan 	: ',0,0,'R');
				$pdf->Cell(20,5,number_format($new_loan_dagdag,2,".",","),1,0,'R');
				$pdf->Ln(5);
			}
		}
		
		
		$reqd_SCS = $t_scs - ($sub_total / $scs_divisor);
		$reqd_SCS = round($reqd_SCS);
		
		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(160,5,'Required SCS: ',0,0,'R');
		$pdf->Cell(20,5,number_format($reqd_SCS,2,".",","),1,0,'C');
		$pdf->Ln(5);
		
		
		$pdf->SetX(4);
		
		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(198,5,'Newly Applied Loan',B,0,'C');
		
		$pdf->Ln(5);
		$pdf->SetFont('Arial','B',9);
		$pdf->SetX(4);
		$pdf->Cell(30,5,'PO Number',0,0,'L');
		$pdf->Cell(25,5,'PO Date',0,0,'C');
		$pdf->Cell(40,5,'Net Proceeds',0,0,'R');
		$pdf->Cell(40,5,'Gross Amount',0,0,'R');
		$pdf->Cell(40,5,'Total Cost',0,0,'R');
		$pdf->Cell(25,5,'Status',0,0,'C');
		$pdf->Ln(5);
		$pdf->SetX(4);
		$pdf->Cell(198,0,'',1,'R');	
		$pdf->Ln(2);
		$query = "SELECT po_number, po_date, gross_amount, net_proceeds, title, po_status
						FROM p_sales_header
						LEFT JOIN module_approvals ON module_approvals.order =p_sales_header.po_order_status
						LEFT JOIN m_txn_approval_bodies USING (App_Id)
						WHERE member_id = {$member_id} AND (po_status !=1 AND released_by IS NULL) AND menu_item_id = 217
						AND YEAR(po_date) > '2010'
						ORDER BY po_number";
			$result = mysql_query($query);
		if(mysql_error() OR mysql_num_rows($result) < 1) {
			$pdf->SetX(4);
			$pdf->Cell(198,5,'- no result to display -',0,0,'C');
		} else {
			while($row = mysql_fetch_array($result)) {
				if ($row['po_status'] == 2) $stats = 'Disapproved';
				elseif ($row['po_status'] == 5) $stats = 'Cancelled';
				else $stats = $row['title'];
				$pdf->SetFont('Arial','',8);
				$pdf->SetX(4);
				$pdf->Cell(30,4,'  '.$row['po_number'],0,0,'L');
				$pdf->Cell(25,4,'  '.date('m/d/Y',strtotime($row['po_date'])),0,0,'C');
				$pdf->Cell(40,4,'PhP '.$row['net_proceeds'].'  ',0,0,'R');
				$pdf->Cell(40,4,'PhP '.$row['gross_amount'].'  ',0,0,'R');
				$pdf->Cell(40,4,'PhP '.$row['gross_amount'].'  ',0,0,'R');
				$pdf->Cell(25,4,$stats,0,0,'C');
				$pdf->Ln(4);
			}
		}
		
		$pdf->Output();
		
	}

	function apc()
	{
		if($this->session->userdata('is_login')){
			$data['row'] = $this->m_account->get_member_info();
		}
		echo $this->session->userdata('name').'<br>';
		echo $this->session->userdata('email').'<br>';
		echo $this->session->userdata('member_id').'<br>';
	}
}
