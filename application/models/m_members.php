<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class m_members extends CI_Model
{
	
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->tbms_db = $this->load->database('tbms_db', TRUE);

        
    }
    
   
   
    function get_emp_idno($member_id)
    {
    	$sql = "SELECT *
    			FROM mem_members
    			WHERE member_id = $member_id";
    			
    	$query = $this->tbms_db->query($sql);
    	
    	if($query->num_rows() > 0){
    		$id2 = $query->row('mem_emp_id2');
    		$id = $query->row('mem_emp_id');
    		
    		return !empty($id2) ? $id2 : $id;
    		
    	}else{
    		return '';
    	}
    	
    	
	}
	
	function get_checklist_payroll($member_id,$pay_period,$trans_id='',$sales_id='')
	{
		$sql = " SELECT zero(SUM(actual_payment)) as t_payment
			     FROM ar_loans_subs_detail
			     WHERE pay_period = '$pay_period'
	    	 	 AND (trans_type = 'PAYROLL' OR trans_type IS NULL)
			     AND member_id = $member_id
			     AND ((sales_id = '$sales_id') OR (trans_id = '$trans_id' AND sales_id IS NULL))
				 GROUP BY member_id";
						
		$query = $this->tbms_db->query($sql);
			
		if($query->num_rows() > 0)
		{
    		return $query->row('t_payment');
    	}
    	else
    	{
    		return 0;
    	}
				
	}
	
	function get_checklist_trans($member_id,$pay_period,$trans_id='',$sales_id='',$trans_date)
	{
		$array = array(
			'OR'=>0,
			'AR'=>0,
			'MPL'=>0,
			'FP'=>0,
			'RBT'=>0,
			'ADJ'=>0
			);
			
		$sql = " SELECT trans_type,zero(SUM(actual_payment)) as t_payment
			     FROM ar_loans_subs_detail
			     WHERE pay_period = '$pay_period'
		    	 AND trans_type IN ('OR','AR','FP','RBT','ADJ','MPL')
			     AND member_id = $member_id
			     AND ((sales_id = '$sales_id') OR (trans_id = '$trans_id' AND sales_id IS NULL))
				 AND DATE(trans_date) <= '$trans_date'
				 GROUP BY trans_type";
						
		$query = $this->tbms_db->query($sql);
			
		foreach($query->result() as $row)
		{
			$array[$row->trans_type] = $row->t_payment; 
		}
		
		return $array;
				
	}
    	
    function get_savings_balance($member_id)
    {
    	$sql = "SELECT *
				 FROM mem_savings_detail
				 WHERE member_id = $member_id
				 ORDER BY trans_date DESC, id DESC LIMIT 1";
		$query = $this->tbms_db->query($sql);
			
		$row = $query->row();
		
		if($query->num_rows() > 0){
			return $row->end_balance;
		}else{
			return 0;
		}
			
		
    }
    	
    function get_overpayment_bal($member_id,$trans_date)
    {
    	$pay_period = get_last_billing();	
    	
    	
    	$sql = "SELECT *
    		    FROM (
			    	
    			SELECT *,DATE(trans_date) as trans_dt
				FROM ar_loans_subs_detail
				LEFT JOIN stg_transaction_types USING(trans_id)
				WHERE member_id = $member_id
				AND DATE(pay_period) = '$pay_period'
				AND trans_date IS NULL
				AND trans_id IN (13)
					
				UNION ALL
					
				SELECT *,DATE(trans_date) as trans_dt
				FROM ar_loans_subs_detail
				LEFT JOIN stg_transaction_types USING(trans_id)
				WHERE member_id = $member_id
				AND DATE(pay_period) = '$pay_period'
				AND DATE(trans_date) = '$trans_date'
				AND trans_id IN (13)
				AND trans_type = 'NEW'
				
				) A
				ORDER BY A.trans_id
					
				";
		#echo $sql;		
		$query = $this->tbms_db->query($sql);
		
		$return_arr = array();
			
		foreach($query->result() as $row)
		{
			#------------------------------------#
			$trans_id = $row->trans_id;
			$type     = $row->trans_type_sdesc;
			$trans_type     = $row->trans_type;
			$desc	  = $row->trans_type_ldesc;
			$billing  = is_null($row->billing_dedn) ? 0 : $row->billing_dedn;
			$sched    = $row->sched_dedn;
			$semi_mo  = $row->semi_mo;
			$actual   = $row->actual_payment;
			$deferred = $row->deferred_amount;	
			$end_bal  = $row->end_bal;
			#------------------------------------#
			
			if(!empty($trans_date) AND $trans_date != 0)
			{
				$sql2 = "SELECT SUM(actual_payment) as t_payment, MAX(end_bal) as curr_bal
						 FROM ar_loans_subs_detail
						 WHERE member_id = $member_id
						 AND DATE(trans_date) BETWEEN '$pay_period' AND '$trans_date'
						 AND trans_id = $trans_id";
							
				$query2 = $this->tbms_db->query($sql2);
				
				$trans_record = $query2->row();
				
				$t_payment = $trans_record->t_payment;
				$curr_bal  = $trans_record->curr_bal;
					
				if(is_null($t_payment) AND is_null($curr_bal))
				{
					$actual     = 0;
				}	
				else
				{
					$actual  = $t_payment;
					$end_bal = $curr_bal;	
					$deferred = max($row->deferred_amount - $t_payment,0);
				}
				
				
			}
			
			#---------------------------------------------------------#
			$return_arr[]=  array(  'trans_id' => $trans_id,
									'type'     => $type,
									'trans_type' => $trans_type,
									'desc'	   => $desc,
									'billing'  => $billing,
									'sched'    => $sched,
									'semi'     => $semi_mo,
									'actual'   => $actual,
									'deferred' => $deferred,	
									'end_bal'  => $end_bal);
			#---------------------------------------------------------#	
			
		}
		
		
		

		return $return_arr;
    }
    
    function get_overpayment_bal2($member_id,$pay_period,$trans_date)
    {
    	if(empty($pay_period))
    	{
    		$pay_period = get_last_billing();
    	}
    	
    	$sql = "SELECT *
    		    FROM (
			    	
    			SELECT *,DATE(trans_date) as trans_dt
				FROM ar_loans_subs_detail
				LEFT JOIN stg_transaction_types USING(trans_id)
				WHERE member_id = $member_id
				AND DATE(pay_period) = '$pay_period'
				AND trans_date IS NULL
				AND trans_id IN (13)
					
				UNION ALL
					
				SELECT *,DATE(trans_date) as trans_dt
				FROM ar_loans_subs_detail
				LEFT JOIN stg_transaction_types USING(trans_id)
				WHERE member_id = $member_id
				AND DATE(pay_period) = '$pay_period'
				AND DATE(trans_date) = '$trans_date'
				AND trans_id IN (13)
				AND trans_type = 'NEW'
				
				) A
				ORDER BY A.trans_id
					
				";
		#echo $sql;		
		$query = $this->tbms_db->query($sql);
		
		$return_arr = array();
			
		foreach($query->result() as $row)
		{
			#------------------------------------#
			$trans_id = $row->trans_id;
			$type     = $row->trans_type_sdesc;
			$trans_type     = $row->trans_type;
			$desc	  = $row->trans_type_ldesc;
			$billing  = is_null($row->billing_dedn) ? 0 : $row->billing_dedn;
			$sched    = $row->sched_dedn;
			$semi_mo  = $row->semi_mo;
			$actual   = $row->actual_payment;
			$deferred = $row->deferred_amount;	
			$end_bal  = $row->end_bal;
			#------------------------------------#
			
			if(!empty($trans_date) AND $trans_date != 0)
			{
				$sql2 = "SELECT SUM(actual_payment) as t_payment, MAX(end_bal) as curr_bal
						 FROM ar_loans_subs_detail
						 WHERE member_id = $member_id
						 AND DATE(trans_date) BETWEEN '$pay_period' AND '$trans_date'
						 AND trans_id = $trans_id";
							
				$query2 = $this->tbms_db->query($sql2);
				
				$trans_record = $query2->row();
				
				$t_payment = $trans_record->t_payment;
				$curr_bal  = $trans_record->curr_bal;
					
				if(is_null($t_payment) AND is_null($curr_bal))
				{
					$actual     = 0;
				}	
				else
				{
					$actual  = $t_payment;
					$end_bal = $curr_bal;	
					$deferred = max($row->deferred_amount - $t_payment,0);
				}
				
				
			}
			
			#---------------------------------------------------------#
			$return_arr[]=  array(  'trans_id' => $trans_id,
									'type'     => $type,
									'trans_type' => $trans_type,
									'desc'	   => $desc,
									'billing'  => $billing,
									'sched'    => $sched,
									'semi'     => $semi_mo,
									'actual'   => $actual,
									'deferred' => $deferred,	
									'end_bal'  => $end_bal);
			#---------------------------------------------------------#	
			
		}
		
		
		

		return $return_arr;
    }
    
    function get_savings_sched($member_id,$pay_period)
    {
		$sql2 = "  SELECT savings_amt as total,CONCAT(mem_lname,', ',mem_fname) as name,company_name 
				   FROM `mem_savings_sched` 
				   LEFT JOIN mem_members USING(member_id)
				   LEFT JOIN stg_company USING(company_id)
				   WHERE '$pay_period' BETWEEN effective_from AND effective_to
				   AND member_id = '$member_id'
				   ORDER BY id DESC
				   LIMIT 1 ";
		$query2 = $this->tbms_db->query($sql2);
		
		if($query2->num_rows() > 0)
		{
			$row2 = $query2->row();
				
			$savings = is_null($row2->total) ? 0.00 : $row2->total;
			
			return $savings;
		}
		else
		{
			return 0;
		}
		
		
    }
    
     function get_savings_sched_all($member_id,$pay_period)
    {
		$sql2 = "  SELECT savings_amt as total,CONCAT(mem_lname,', ',mem_fname) as name,company_name 
				   FROM `mem_savings_sched` 
				   LEFT JOIN mem_members USING(member_id)
				   LEFT JOIN stg_company USING(company_id)
				   WHERE '$pay_period' BETWEEN effective_from AND effective_to
				   AND member_id = '$member_id'
				   ORDER BY id DESC
				   LIMIT 1 ";
		$query2 = $this->tbms_db->query($sql2);
		
		if($query2->num_rows() > 0)
		{
			$row2 = $query2->row();
				
			$savings = is_null($row2->total) ? 0.00 : $row2->total;
			
			return $savings;
		}
		else
		{
			return 0;
		}
		
		
    }
    
    function get_members_info($member_id)
    {
    	$sql = "SELECT *,CONCAT(mem_lname,', ',mem_fname,' ',mem_mname) as name 
				FROM mem_members
				LEFT JOIN mem_emplevel USING(emp_level_id)
				LEFT JOIN mem_account USING(member_id)
				LEFT JOIN mem_temp_bank USING(bank_id)
				LEFT JOIN stg_company USING(company_id)
				WHERE member_id = $member_id";
					
		$query = $this->tbms_db->query($sql);
			
		return $query->row();
    }
    
    function get_member_los($member_id, $as_of = '')
    {
    	if(empty($as_of))
    	{
    		$as_of = date('Y-m-d');
    	}
    		
    	$mem_row = $this->tbms_db->get_where('mem_members',array('member_id'=>$member_id))->row();
    		
    	$los = dateDiff($as_of, $mem_row->mem_hired_date. '01:00:00');
    	
    	return $los;
    }
    
    function get_member_lom($member_id, $as_of = '')
    {
    	if(empty($as_of))
    	{
    		$as_of = date('Y-m-d');
    	}
    	
    	$mem_row = $this->tbms_db->get_where('mem_members',array('member_id'=>$member_id))->row();
    		
    	$los = dateDiff($as_of, $mem_row->dedn_start_dt. '01:00:00');
    	//echo $mem_row->dedn_start_dt;
    	return $los;
    }
    
    function get_billing_info($member_id,$pay_period,$account_type)
	{
		$sql = "SELECT  SUM(billing_dedn) as t_billing,
						SUM(actual_payment) as t_payment, 
						SUM(deferred_amount) as t_deferred,
						SUM(end_bal) as ob, C.member_id
				FROM ar_loans_billing A
				LEFT JOIN ar_loans_subs_detail B USING(billing_id)
				LEFT JOIN mem_members C ON B.member_id = C.member_id
				WHERE A.pay_period = '$pay_period'
				#AND B.trans_date IS NULL
				AND account_type = $account_type
				AND (C.member_id = $member_id OR C.deduct_from = $member_id)
				GROUP BY C.member_id";
					
		$query = $this->tbms_db->query($sql);
			
		$sched = 0;
		$actual = 0;
		$deferred = 0;
		$ob = 0;
		$savings_sched = 0;
			
		if($query->num_rows() > 0)
		{
			foreach($query->result() as $row)
			{
				$sched    += $row->t_billing;
				$actual   += $row->t_payment;
				$deferred += $row->t_deferred;
				$ob       += $row->ob;
				
				$savings_sched += $this->m_members->get_savings_sched_all($row->member_id,$pay_period);	
				#echo $savings_sched;
			}
		}	
			#echo $sched;
		return array( 'billing'  => $sched + $savings_sched,
             		  'actual'   => $actual,
             		  'deferred' => $deferred,
             		  'ob'       => $ob );
	}
	
	function get_payroll_info($member_id, $pay_period)
	{
		$sql = "SELECT
				 zero(SUM(semi)) as semi,
				 zero(SUM(sched)) as sched,
				 zero(SUM(billing)) as billing,
			 	 zero(SUM(deferred)) as deferred,
		 	 	 zero(SUM(actual)) as actual
				FROM (
						
					SELECT
	 				 zero(SUM(semi_mo)) as semi,
					 zero(SUM(sched_dedn)) as sched,
					 zero(SUM(billing_dedn)) as billing,
				 	 zero(SUM(deferred_amount)) as deferred,
			 	 	 zero(SUM(actual_payment)) as actual
					FROM ar_loans_subs_detail
					LEFT JOIN ar_loans_header USING(sales_id)
					WHERE ar_loans_subs_detail.member_id = $member_id
					AND (collection_type = 1 OR collection_type IS NULL)
					AND pay_period = '$pay_period'
					AND (ar_loans_subs_detail.pay_period >= ar_loans_header.po_start_date OR ar_loans_header.sales_id IS NULL)
					AND trans_date IS NULL
					#AND collection_id IS NOT NULL
						
					UNION ALL
						
					SELECT
	 				zero(SUM(semi_mo)) as semi,
					 zero(SUM(sched_dedn)) as sched,
					 zero(SUM(billing_dedn)) as billing,
				 	 zero(SUM(deferred_amount)) as deferred,
			 	 	 zero(SUM(actual_payment)) as actual
					FROM ar_loans_subs_detail
					LEFT JOIN ar_loans_header USING(sales_id)
					WHERE ar_loans_subs_detail.member_id = $member_id
					AND (collection_type = 1 OR collection_type IS NULL)
					AND pay_period = '$pay_period'
					AND (ar_loans_subs_detail.pay_period >= ar_loans_header.po_start_date OR ar_loans_header.sales_id IS NULL)
					AND trans_date IS NOT NULL
	        		AND DATE(trans_date) = '$pay_period'
	        		#AND collection_id IS NOT NULL
				) A";
		#			
		$semi = 0;
		$sched = 0;
		$deferred = 0;
		$billing = 0;
		$actual = 0;
			
		$query = $this->tbms_db->query($sql);
			
		if($query->num_rows() > 0)
		{
			$semi = $query->row('semi');
			$sched = $query->row('sched');
			$deferred = $query->row('deferred');
			$billing = $query->row('billing');
			$actual = $query->row('actual');
		}
			
		return array('semi' => $semi,
					 'sched' => $sched,
					 'deferred' => $deferred,
					 'billing' => $billing,
					 'actual' => $actual );
    }
    
	function get_member_billing($member_id,$pay_period,$account_type,$billing_id=0)
	{
		$billing_detail = array();
		$billing_dedn = 0;
		$t_savings = 0;	
			$dep_query = $this->m_members->get_member_dependents_prin($member_id);
			$orig_pay_period = $pay_period;
			foreach($dep_query->result() as $row)
			{
				$member_id = $row->member_id;
				$pay_period = $orig_pay_period;
					
				#-------------------------------------------------------------------------------#
				#1. SUM_CONTRIBUTIONS
				#-------------------------------------------------------------------------------#
				if($account_type == 1):
					
					$sqlc = "SELECT *,CONCAT(mem_lname,', ',mem_fname) as name
							FROM ar_loans_subs_detail
							LEFT JOIN stg_transaction_types	USING(trans_id)
							LEFT JOIN mem_members USING(member_id)
							LEFT JOIN stg_company USING(company_id)
							WHERE ar_loans_subs_detail.member_id = $member_id
							AND ar_loans_subs_detail.trans_date IS NULL
							AND pay_period = '$pay_period'
							AND ar_loans_subs_detail.trans_id IN (3,6,8,9,11)
							AND sched_dedn > 0";
					#echo $sqlc;			
					$queryc = $this->tbms_db->query($sqlc);
					
					foreach($queryc->result() as $row)
					{
						if($row->sched_dedn > 0):
		
						$data_upd = array(
						               'billing_dedn' => $row->sched_dedn,
						               'billing_id'   => $billing_id,
					            	);
										
						$this->tbms_db->where('subs_id', $row->subs_id);
						$this->tbms_db->update("ar_loans_subs_detail",$data_upd);	
						
						
						$billing_detail[] = array(
							'SubsID'       => $row->subs_id,
							'Pay Period'   => $pay_period,
							'Company Name' => $row->company_name,
							'Member ID'	   => $row->member_id,
							'Member Name'  => $row->name,
							'Trans Type'   => $row->trans_type_sdesc,
							'Loan Name'    => '',
							'Prod Id'      => '',
							'PO Number'    => '',
							'DR Number'    => '',
							'Semi Monthly' => $row->semi_mo,
							'Interest'     => '0.00',
							'Amount Billed'=> $row->sched_dedn
							);
							
						$billing_dedn += $row->sched_dedn;
						
						
						
						endif;
					}
				endif;
					
				#-------------------------------------------------------------------------------#
				#2. SUM_LOANS (BASED ON COLLECTION TYPE)
				#-------------------------------------------------------------------------------#
				$query_where = '';
				$sched_dedn = 'AND sched_dedn > 0';
				if($account_type == 3)
				{
					$query_where = "AND po_start_date <= '$pay_period'";
						
					$mpl_d = "SELECT mpl_id,billing_dedn,CONCAT(mem_lname,', ',mem_fname) as name,
									 sales_id,company_name,trans_type_sdesc,prod_name,prod_id,
									 po_number,dr_number, semi_monthly_amor AS semi_mo
							  FROM ar_mpl_deductions
							  LEFT JOIN stg_transaction_types	USING(trans_id)
							  LEFT JOIN mem_members USING(member_id)
						  	  LEFT JOIN ar_loans_header USING(sales_id)
							  LEFT JOIN stg_company USING(company_id)
							  LEFT JOIN stg_loan_products USING(prod_id)
							  WHERE ar_mpl_deductions.member_id = $member_id
							  AND mpl_date = '$pay_period'";
									
					$pay_period = switch_date(get_last_billing());
					
					$sched_dedn = '';
				}
				
				
				
				#-------------------------------------------------------------------------------#
				#2. SUM_LOANS (BASED ON COLLECTION TYPE)
				#-------------------------------------------------------------------------------#
				$sql = "SELECT *,CONCAT(mem_lname,', ',mem_fname) as name
						FROM ar_loans_subs_detail
						LEFT JOIN mem_members USING(member_id)
						LEFT JOIN stg_company USING(company_id)
						LEFT JOIN ar_loans_header USING(sales_id)
						LEFT JOIN stg_transaction_types	USING(trans_id)	
						LEFT JOIN stg_loan_products USING(prod_id)
						WHERE ar_loans_subs_detail.member_id = $member_id
						AND pay_period = '$pay_period'
						AND ar_loans_subs_detail.trans_date IS NULL
						$query_where
						AND ar_loans_header.collection_type = $account_type
						AND ar_loans_header.po_order_status = 'approved'
						$sched_dedn";
						
				$query = $this->tbms_db->query($sql);
				
				$name = '';
				$company_name = '';
				foreach($query->result() as $row)
				{
					$amt_billed = $row->sched_dedn; 
					#IF ACCOUNT TYPE MPL, GET BEGINNING BALANCE.
					if($account_type == 3)
					{
						$amt_billed = $row->beg_bal;
					}
						
					if($amt_billed > 0):
						
						$data_upd = array(
						               'billing_dedn' => $amt_billed,
						               'billing_id'   => $billing_id,
					            	);
										
						$this->tbms_db->where('subs_id', $row->subs_id);
						$this->tbms_db->update("ar_loans_subs_detail",$data_upd);	
						
					$billing_detail[] = array(
						'SubsID'       => $row->subs_id,
						'Pay Period'   => $pay_period,
						'Company Name' => $row->company_name,
						'Member ID'	   => $row->member_id,
						'Member Name'  => $row->name,
						'Trans Type'   => $row->trans_type_sdesc,
						'Loan Name'    => $row->prod_name,
						'Prod Id'      => $row->prod_id,
						'PO Number'    => $row->po_number,
						'DR Number'    => $row->dr_number,
						'Semi Monthly' => $row->semi_mo,
						'Amount Billed'=> $amt_billed
					);
					
					$billing_dedn += $amt_billed;
					$name = $row->name;
					$company_name = $row->company_name;
					endif;
				}
				
				#IF BONUSES MPL (Include AR-MPL-DEDUCTIONS)
				if($account_type == 3)
				{
					$query_mpl_d = $this->tbms_db->query($mpl_d);
					if($query_mpl_d->num_rows() > 0)
					{
						foreach($query_mpl_d->result() as $row_mpl_d)
						{
							$amt_billed = $row_mpl_d->billing_dedn;
								
							if($amt_billed > 0):
							
								$data_upd = array(
								               'billing_id'   => $billing_id
							            	);
												
								$this->tbms_db->where('mpl_id', $row_mpl_d->mpl_id);
								$this->tbms_db->update("ar_mpl_deductions",$data_upd);	
								
								$billing_detail[] = array(
									'SubsID'       => $row_mpl_d->sales_id,
									'Pay Period'   => $pay_period,
									'Company Name' => $row_mpl_d->company_name,
									'Member ID'	   => $member_id,
									'Member Name'  => $row_mpl_d->name,
									'Trans Type'   => $row_mpl_d->trans_type_sdesc,
									'Loan Name'    => $row_mpl_d->prod_name,
									'Prod Id'      => $row_mpl_d->prod_id,
									'PO Number'    => $row_mpl_d->po_number,
									'DR Number'    => $row_mpl_d->dr_number,
									'Semi Monthly' => $row_mpl_d->semi_mo,
									'Amount Billed'=> $row_mpl_d->billing_dedn
								);
								
								$billing_dedn += $amt_billed;
									
							endif;
						}
						
					}
				}
				
					
				$savings = 0;
				$savings_dep = 0;
				#----------------------------------------------------------------------#
				# ADD SAVINGS SCHEDULED DEDUCTION
				#----------------------------------------------------------------------#
				if($account_type == 1):
						
					$savings = $this->m_members->get_savings_sched($member_id,$pay_period);
						
					if($savings > 0)
					{
						
						$billing_detail[] = array(
							'SubsID'       => 0,
							'Pay Period'   => $pay_period,
							'Company Name' => $company_name,
							'Member ID'	   => $member_id,
							'Member Name'  => $name,
							'Trans Type'   => 'Savings',
							'Loan Name'    => '',
							'Prod Id'      => '',
							'PO Number'    => '',
							'DR Number'    => '',
							'Semi Monthly' => $savings,
							'Amount Billed'=> $savings
						);
						
						$t_savings += $savings;
						
					}
					
						
				endif;
				#----------------------------------------------------------------------#
				
			}	
				
			if($dep_query->num_rows() > 0)
			{
				$billing_info = array( 'billing_dedn'   => $billing_dedn + $t_savings,# + $savings_dep, 
							  	   'billing_detail' => $billing_detail);
				return $billing_info;
			}
			else
			{
				return array( 'billing_detail' => $billing_detail, 'billing_dedn' => 0);
			}	
			
		
		
	}
	
	function get_total_posting_pay_period($member_id,$pay_period,$sales_id=0,$trans_id=0)
	{
		if($sales_id != 0)
		{
			if($trans_id == 5)
			{
				$endbal = "beg_bal+SUM(actual_payment)";
			}
			else
			{
				$endbal = "beg_bal-SUM(actual_payment)";
			}
				
			$last = $this->tbms_db->query("SELECT po_number,
												  ($endbal) as end_bal ,
												  SUM(actual_payment) as t_payment,
												  SUM(deferred_amount) as deferred_amount,
												  beg_bal,semi_mo
									   		FROM ar_loans_subs_detail 
										   WHERE sales_id = $sales_id
										   AND pay_period = '$pay_period' 
										   AND member_id = '$member_id'
										   ")->row();
		}
		else
		{
			if($trans_id == 3)
			{
				$endbal = "beg_bal-SUM(actual_payment)";
			}
			else
			{
				$endbal = "beg_bal+SUM(actual_payment)";
			}
				
			#LAST RECORD (even with trans_date kuha)
			$last = $this->tbms_db->query("SELECT po_number,
												  ($endbal) as end_bal,
												  SUM(actual_payment) as t_payment,
												  SUM(deferred_amount) as deferred_amount,
												  beg_bal,semi_mo
											FROM ar_loans_subs_detail 
											WHERE trans_id = '$trans_id' 
											AND pay_period = '$pay_period'
											AND member_id = '$member_id'
											ORDER BY subs_id DESC 
											LIMIT 1")->row();
		}
			
		return $last;
	}
	
	function get_tbp($member_id, $pay_period)
	{
		$sql = "SELECT *
				FROM ar_loans_subs_detail
				WHERE member_id = $member_id
				AND pay_period = '$pay_period'
				AND trans_id = 11
				ORDER BY subs_id DESC LIMIT 1";
					
		$query = $this->tbms_db->query($sql);
		
		$puc = 0;
		
		if($query->num_rows() > 0)
		{
			$puc = $query->row('end_bal');
				
			#LESS MIGRATED ADVANCE PAYMENT
			$sql_adv = "SELECT SUM(actual_payment) as adv
						FROM ar_loans_subs_detail
						WHERE member_id = $member_id
						AND pay_period > '$pay_period'
						AND trans_id = 11
						";
						
			$query_adv = $this->tbms_db->query($sql_adv);
			
			if($query_adv->num_rows() > 0)
			{
				$puc += $query_adv->row('adv');
			}
			
		}
		
		return $puc;
	}
	
	function get_rbp($member_id, $pay_period)
	{
		$sql = "SELECT *
				FROM ar_loans_subs_detail
				WHERE member_id = $member_id
				AND pay_period = '$pay_period'
				AND trans_id = 8
				ORDER BY subs_id DESC LIMIT 1";
					
		$query = $this->tbms_db->query($sql);
		
		$puc = 0;
		
		if($query->num_rows() > 0)
		{
			$puc = $query->row('end_bal');
				
			#LESS MIGRATED ADVANCE PAYMENT
			$sql_adv = "SELECT SUM(actual_payment) as adv
						FROM ar_loans_subs_detail
						WHERE member_id = $member_id
						AND pay_period > '$pay_period'
						AND trans_id = 8
						";
						
			$query_adv = $this->tbms_db->query($sql_adv);
			
			if($query_adv->num_rows() > 0)
			{
				$puc += $query_adv->row('adv');
			}
			
		}
		
		return $puc;
	}
	
	function get_puc($member_id, $pay_period)
	{
		$sql = "SELECT *
				FROM ar_loans_subs_detail
				WHERE member_id = $member_id
				AND pay_period = '$pay_period'
				AND trans_id = 9
				ORDER BY subs_id DESC LIMIT 1";
					
		$query = $this->tbms_db->query($sql);
		
		$puc = 0;
		
		if($query->num_rows() > 0)
		{
			$puc = $query->row('end_bal');
				
			#LESS MIGRATED ADVANCE PAYMENT
			$sql_adv = "SELECT SUM(actual_payment) as adv
						FROM ar_loans_subs_detail
						WHERE member_id = $member_id
						AND pay_period > '$pay_period'
						AND trans_id = 9
						";
						
			$query_adv = $this->tbms_db->query($sql_adv);
			
			if($query_adv->num_rows() > 0)
			{
				$puc += $query_adv->row('adv');
			}
			
		}
		
		return $puc;
	}
	
	function get_advance_payment($member_id,$pay_period,$trans_id,$sales_id=0)
	{
		$sales_where = '';
		
		if($sales_id > 1)
		{
			$sales_where = " AND sales_id = $sales_id";
		}
		
		$sql = "SELECT SUM(actual_payment) as adv
				FROM ar_loans_subs_detail
				WHERE member_id = $member_id
				AND pay_period > '$pay_period'
				AND trans_id = $trans_id
				$sales_where
				";
					
		$query = $this->tbms_db->query($sql);
		
		$adv = 0;
		
		if($query->num_rows() > 0)
		{
			$adv = $query->row('adv');
		}
		
		return $adv;
	}
	
	
	 
    function get_contrib_sl($member_id, $pay_period, $trans_date = '')
    {
    	$sql = "SELECT *
    		    FROM (
			    	
    			SELECT *,DATE(trans_date) as trans_dt
				FROM ar_loans_subs_detail
				LEFT JOIN stg_transaction_types USING(trans_id)
				WHERE member_id = $member_id
				AND DATE(pay_period) = '$pay_period'
				AND trans_date IS NULL
				AND trans_id IN (3,6,8,11)
					
				UNION ALL
					
				SELECT *,DATE(trans_date) as trans_dt
				FROM ar_loans_subs_detail
				LEFT JOIN stg_transaction_types USING(trans_id)
				WHERE member_id = $member_id
				AND DATE(pay_period) = '$pay_period'
				AND DATE(trans_date) = '$trans_date'
				AND trans_id IN (3,6,8,11)
				AND trans_type = 'NEW'
				
				) A
				ORDER BY A.trans_id
					
				";
		#echo $sql;		
		$query = $this->tbms_db->query($sql);
		
		$return_arr = array();
			
		foreach($query->result() as $row)
		{
			#------------------------------------#
			$trans_id = $row->trans_id;
			$type     = $row->trans_type_sdesc;
			$trans_type     = $row->trans_type;
			$desc	  = $row->trans_type_ldesc;
			$billing  = is_null($row->billing_dedn) ? 0 : $row->billing_dedn;
			$sched    = $row->sched_dedn;
			$semi_mo  = $row->semi_mo;
			$actual   = $row->actual_payment;
			$deferred = $row->deferred_amount;	
			$end_bal  = $row->end_bal;
			$beg_bal  = $row->beg_bal;
			#------------------------------------#
			
			if(!empty($trans_date) AND $trans_date != 0)
			{
				#RECLASS ACCOUNT FOR PAYROLL COLLECTION
				$re_class = 0;
				
				if($trans_date == $pay_period)
				{
					$sql2 = "SELECT SUM(actual_payment) as t_payment, MIN(end_bal) as curr_bal
							 FROM ar_loans_subs_detail
							 WHERE member_id = $member_id
						 	 AND ( (DATE(trans_date) BETWEEN '$pay_period' AND '$trans_date') OR (pay_period = '$pay_period' AND trans_date IS NULL) )
							 AND trans_id = $row->trans_id";
				}
				else
				{
					$sql2A = "SELECT SUM(actual_payment) as t_payment, MIN(end_bal) as curr_bal
							 FROM ar_loans_subs_detail
							 WHERE member_id = $member_id
						 	 AND DATE(trans_date) = '$pay_period'
							 AND trans_id = $row->trans_id";
							 
					$query2B = $this->tbms_db->query($sql2A);
					
					if($query2B->num_rows() > 0)		 
					{
						$re_class = $query2B->row('t_payment');
					}
					
					$sql2 = "SELECT SUM(actual_payment) as t_payment, MIN(end_bal) as curr_bal
						 	 FROM ar_loans_subs_detail
						 	 WHERE member_id = $member_id
						 	 AND DATE(trans_date) BETWEEN '$pay_period' AND '$trans_date'
							 AND DATE(trans_date) > '$pay_period'
						 	 AND trans_id = $row->trans_id";
				}
					
				
				$query2 = $this->tbms_db->query($sql2);
				
				$trans_record = $query2->row();
				
				$t_payment = $trans_record->t_payment;
				
				if(is_null($t_payment) AND $re_class == 0)
				{
					$actual     = 0;
				}	
				else
				{
					if(is_null($t_payment)){
						$t_payment = 0;
					}
					
					if($trans_date == $pay_period)
					{	
						$curr_bal  = ($trans_id==3) ? ($beg_bal - $t_payment) : ($beg_bal + $t_payment);
						$deferred  = max($sched - $t_payment,0);
					}
					else
					{
						$curr_bal  = ($trans_id==3) ? ($beg_bal - ($t_payment + $actual + $re_class)) : ($beg_bal + ($t_payment + $actual +  $re_class));
						$deferred  =  max($sched - ($t_payment + $actual + $re_class),0);
					}
						
					$actual  = $t_payment;
					$end_bal = $curr_bal;	
				}
				
				
			}
				
			#---------------------------------------------------------#
			$return_arr[]=  array(  'trans_id' => $trans_id,
									'type'     => $type,
									'trans_type' => $trans_type,
									'desc'	   => $desc,
									'billing'  => $billing,
									'sched'    => $sched,
									'semi'     => $semi_mo,
									'actual'   => $actual,
									'deferred' => $deferred,	
									'end_bal'  => $end_bal);
			#---------------------------------------------------------#	
			
		}
			
		return $return_arr;
		
    }
    
    function get_accounts_over($member_id, $pay_period, $trans_date = '')
    {
    	$sql = "SELECT *
    		    FROM (
			    	
    			SELECT *,DATE(trans_date) as trans_dt
				FROM ar_loans_subs_detail
				LEFT JOIN stg_transaction_types USING(trans_id)
				WHERE member_id = $member_id
				AND DATE(pay_period) = '$pay_period'
				AND trans_date IS NULL
				AND trans_id IN (13)
					
				UNION ALL
					
				SELECT *,DATE(trans_date) as trans_dt
				FROM ar_loans_subs_detail
				LEFT JOIN stg_transaction_types USING(trans_id)
				WHERE member_id = $member_id
				AND DATE(pay_period) = '$pay_period'
				AND DATE(trans_date) = '$trans_date'
				AND trans_id IN (13)
				AND trans_type = 'NEW'
				
				) A
				ORDER BY A.trans_id
					
				";
		#echo $sql;		
		$query = $this->tbms_db->query($sql);
		
		$return_arr = array();
			
		foreach($query->result() as $row)
		{
			#------------------------------------#
			$trans_id = $row->trans_id;
			$type     = $row->trans_type_sdesc;
			$trans_type     = $row->trans_type;
			$desc	  = $row->trans_type_ldesc;
			$billing  = is_null($row->billing_dedn) ? 0 : $row->billing_dedn;
			$sched    = $row->sched_dedn;
			$semi_mo  = $row->semi_mo;
			$actual   = $row->actual_payment;
			$deferred = $row->deferred_amount;	
			$end_bal  = $row->end_bal;
			#------------------------------------#
			
			if(!empty($trans_date) AND $trans_date != 0)
			{
				$sql2 = "SELECT SUM(actual_payment) as t_payment, MAX(end_bal) as curr_bal
						 FROM ar_loans_subs_detail
						 WHERE member_id = $member_id
						 AND DATE(trans_date) BETWEEN '$pay_period' AND '$trans_date'
						 AND trans_id = $trans_id";
							
				$query2 = $this->tbms_db->query($sql2);
				
				$trans_record = $query2->row();
				
				$t_payment = $trans_record->t_payment;
				$curr_bal  = $trans_record->curr_bal;
			
				if(is_null($t_payment) AND is_null($curr_bal))
				{
					$actual     = 0;
				}	
				else
				{
					$actual  = $t_payment;
					$end_bal = $curr_bal;	
					$deferred = 0;#max($row->deferred_amount - $t_payment,0);
				}
				
				
			}
			
			#---------------------------------------------------------#
			$return_arr[]=  array(  'trans_id' => $trans_id,
									'type'     => $type,
									'trans_type' => $trans_type,
									'po_number' => '',
									'dr_number' => '',
									'start_dt' => '',
									'end_dt' => '',
									'sales_id' => '',
									'desc'	   => $desc,
									'billing'  => $billing,
									'sched'    => $sched,
									'semi'     => $semi_mo,
									'actual'   => $actual,
									'deferred' => $deferred,	
									'end_bal'  => $end_bal);
			#---------------------------------------------------------#	
			
		}
		
		
		

		return $return_arr;
		
    }
    
    function get_contrib_scs_sl($member_id, $pay_period, $trans_date = '')
    {
    	
    	$scs_limit = $this->tbms_db->get('stg_general_settings')->row('scs_limit');
    		
    	$return_arr = array();
    		
    	#-------------------------------------------------------------#	
		# SCS CONTRIBUTIONS SET LIMIT IF REACH 20K
		#-------------------------------------------------------------#	
		
		$sql = "SELECT *,DATE(trans_date) as trans_dt
				FROM ar_loans_subs_detail
				LEFT JOIN stg_transaction_types USING(trans_id)
				WHERE member_id = $member_id
				AND DATE(pay_period) = '$pay_period'
				AND trans_date IS NULL
				AND trans_id IN (9)		
					
				UNION ALL
				
				SELECT *,DATE(trans_date) as trans_dt
				FROM ar_loans_subs_detail
				LEFT JOIN stg_transaction_types USING(trans_id)
				WHERE member_id = $member_id
				AND DATE(pay_period) = '$pay_period'
				AND DATE(trans_date) = '$trans_date'
				AND trans_type = 'NEW'
				AND trans_id IN (9)			
				";
				
		$query = $this->tbms_db->query($sql);
		
		foreach($query->result() as $row)
		{
			#------------------------------------#
			$trans_id = $row->trans_id;
			$type     = $row->trans_type_sdesc;
			$trans_type = $row->trans_type;
			$desc	  = $row->trans_type_ldesc;
			$sched    = $row->sched_dedn;
			$billing  = is_null($row->billing_dedn) ? 0 : $row->billing_dedn;
			$semi_mo  = $row->semi_mo;
			$actual   = $row->actual_payment;
			$deferred = $row->deferred_amount;	
			$end_bal  = $row->end_bal;
			$beg_bal  = $row->beg_bal;
			$scs_payment = $row->actual_payment;
			$scs1_payment = $row->actual_payment;
			#------------------------------------#
			
			if(!empty($trans_date) AND $trans_date != 0)
			{
				
				#RECLASS ACCOUNT FOR PAYROLL COLLECTION
				$re_class = 0;
				
				if($trans_date == $pay_period)
				{
					$sql2 = "SELECT SUM(actual_payment) as t_payment, MIN(end_bal) as curr_bal
							 FROM ar_loans_subs_detail
							 WHERE member_id = $member_id
						 	 AND ( (DATE(trans_date) BETWEEN '$pay_period' AND '$trans_date') OR (pay_period = '$pay_period' AND trans_date IS NULL) )
							 AND trans_id = $row->trans_id";
				}
				else
				{
					$sql2A = "SELECT SUM(actual_payment) as t_payment, MIN(end_bal) as curr_bal
							 FROM ar_loans_subs_detail
							 WHERE member_id = $member_id
						 	 AND DATE(trans_date) = '$pay_period'
							 AND trans_id = $row->trans_id";
							 
					$query2B = $this->tbms_db->query($sql2A);
					
					if($query2B->num_rows() > 0)		 
					{
						$re_class = $query2B->row('t_payment');
					}
					
					$sql2 = "SELECT SUM(actual_payment) as t_payment, MIN(end_bal) as curr_bal
						 	 FROM ar_loans_subs_detail
						 	 WHERE member_id = $member_id
						 	 AND DATE(trans_date) BETWEEN '$pay_period' AND '$trans_date'
							 AND DATE(trans_date) > '$pay_period'
						 	 AND trans_id = $row->trans_id";
				}
					
				
				$query2 = $this->tbms_db->query($sql2);
				
				$trans_record = $query2->row();
				
				$t_payment = $trans_record->t_payment;
					
				$curr_bal = 0;
					
				if(is_null($t_payment) AND $re_class == 0)
				{
					$actual     = 0;
				}	
				else
				{
					
					if(is_null($t_payment)){
						$t_payment = 0;
					}
					
					if($trans_date == $pay_period)
					{	
						$curr_bal  = ($beg_bal + $t_payment);
						$deferred  = max($sched - $t_payment,0);
					}
					else
					{
						$curr_bal  = ($beg_bal + ($t_payment + $actual +  $re_class));
						$deferred  = max($sched - ($t_payment + $actual +  $re_class),0);
					}
					
					$actual  = $t_payment;
					$end_bal = $curr_bal;	
					#$deferred = max($row->deferred_amount - $t_payment,0);
				}
					
				if($curr_bal > $scs_limit AND $row->end_bal < $scs_limit )
				{
					$scs1_payment  = $curr_bal - $scs_limit;
					$scs_payment = $actual- $scs1_payment;
					
					#SCS
					#---------------------------------------------------------#
					$return_arr[]=  array(  'trans_id' => $trans_id,
											'type'     => $type,
											'trans_type' => $trans_type,
											'desc'	   => $desc,
											'sched'    => $sched,
											'billing'  => $billing,
											'semi'     => $semi_mo,
											'actual'   => $scs_payment,
											'deferred' => $deferred,	
											'end_bal'  => $scs_limit);
					#---------------------------------------------------------#	
					#SCS1
					#---------------------------------------------------------#
					$return_arr[]=  array(  'trans_id' => 10,
											'type'     => 'SCS1',
											'trans_type' => '',
											'desc'	   => 'Share Capital Subscription',
											'billing'  => 0,
											'sched'    => 0,
											'semi'     => 0,
											'actual'   => $scs1_payment,
											'deferred' => 0,	
											'end_bal'  => $end_bal - $scs_limit);
					#---------------------------------------------------------#	
				}
				else
				{
					if($end_bal > $scs_limit)
					{
						
						#SCS1
						#---------------------------------------------------------#
						$return_arr[]=  array(  'trans_id' => 10,
												'type'     => 'SCS1',
												'trans_type' => '',
												'desc'	   => 'Share Capital Subscription',
												'sched'    => $sched,
												'billing'  => $billing,
												'semi'     => $semi_mo,
												'actual'   => $actual,
												'deferred' => $deferred,	
												'end_bal'  => $end_bal - $scs_limit);
						#---------------------------------------------------------#	
						
						#SCS
						#---------------------------------------------------------#
						$return_arr[]=  array(  'trans_id' => $trans_id,
												'type'     => $type,
												'trans_type' => $trans_type,
												'desc'	   => $desc,
												'sched'    => 0,
												'billing'  => 0,
												'semi'     => 0,
												'actual'   => 0,
												'deferred' => 0,	
												'end_bal'  => $scs_limit);
						#---------------------------------------------------------#	
					}
					else
					{
						#---------------------------------------------------------#
						$return_arr[]=  array(  'trans_id' => $trans_id,
												'type'     => $type,
												'trans_type' => $trans_type,
												'desc'	   => $desc,
												'sched'    => $sched,
												'billing'  => $billing,
												'semi'     => $semi_mo,
												'actual'   => $actual,
												'deferred' => $deferred,	
												'end_bal'  => $end_bal);
						#---------------------------------------------------------#	
					}
				}
				
			}
			else
			{
				#echo 1234;
				if($end_bal > $scs_limit)
				{
					
					#SCS1
					#---------------------------------------------------------#
					$return_arr[]=  array(  'trans_id' => 10,
											'type'     => 'SCS1',
											'trans_type' => '',
											'desc'	   => 'Share Capital Subscription',
											'sched'    => $sched,
											'semi'     => $semi_mo,
											'billing'  => $billing,
											'actual'   => $actual,
											'deferred' => $deferred,	
											'end_bal'  => $end_bal - $scs_limit);
					#---------------------------------------------------------#	
					
					#SCS
					#---------------------------------------------------------#
					$return_arr[]=  array(  'trans_id' => $trans_id,
											'type'     => $type,
											'trans_type' => $trans_type,
											'desc'	   => $desc,
											'sched'    => 0,
											'billing'  => 0,
											'semi'     => 0,
											'actual'   => 0,
											'deferred' => 0,	
											'end_bal'  => $scs_limit);
					#---------------------------------------------------------#	
				}
				else
				{
					#---------------------------------------------------------#
					$return_arr[]=  array(  'trans_id' => $trans_id,
											'type'     => $type,
											'trans_type' => $trans_type,
											'desc'	   => $desc,
											'sched'    => $sched,
											'billing'  => $billing,
											'semi'     => $semi_mo,
											'actual'   => $actual,
											'deferred' => $deferred,	
											'end_bal'  => $end_bal);
					#---------------------------------------------------------#	
				}
				
			}
			
		}

		return $return_arr;
    }
    
    function get_contrib_all($member_id, $pay_period, $trans_date = '')
    {
    	$sql = "SELECT *
    		    FROM (
			    	
    			SELECT *,DATE(trans_date) as trans_dt
				FROM ar_loans_subs_detail
				LEFT JOIN stg_transaction_types USING(trans_id)
				WHERE member_id = $member_id
				AND DATE(pay_period) = '$pay_period'
				AND trans_date IS NULL
				AND trans_id IN (3,6,8,9,11)
					
				UNION ALL
					
				SELECT *,DATE(trans_date) as trans_dt
				FROM ar_loans_subs_detail
				LEFT JOIN stg_transaction_types USING(trans_id)
				WHERE member_id = $member_id
				AND DATE(pay_period) = '$pay_period'
				AND DATE(trans_date) = '$trans_date'
				AND trans_id IN (3,6,8,9,11)
				AND trans_type = 'NEW'
				
				) A
				ORDER BY A.trans_id
					
				";
				
		$query = $this->tbms_db->query($sql);
		
		$return_arr = array();
			
		foreach($query->result() as $row)
		{
			#------------------------------------#
			$trans_id = $row->trans_id;
			$type     = $row->trans_type_sdesc;
			$desc	  = $row->trans_type_ldesc;
			$sched    = $row->sched_dedn;
			$billing  = is_null($row->billing_dedn) ? 0 : $row->billing_dedn;
			$semi_mo  = $row->semi_mo;
			$actual   = $row->actual_payment;
			$deferred = $row->deferred_amount;	
			$end_bal  = $row->end_bal;
			$beg_bal  = $row->beg_bal;
			#------------------------------------#
			
			if(!empty($trans_date) AND $trans_date != 0)
			{
				#RECLASS ACCOUNT FOR PAYROLL COLLECTION
				$re_class = 0;
				
				if($trans_date == $pay_period)
				{
					$sql2 = "SELECT SUM(actual_payment) as t_payment, MIN(end_bal) as curr_bal
							 FROM ar_loans_subs_detail
							 WHERE member_id = $member_id
						 	 AND ( (DATE(trans_date) BETWEEN '$pay_period' AND '$trans_date') OR (pay_period = '$pay_period' AND trans_date IS NULL) )
							 AND trans_id = $row->trans_id";
				}
				else
				{
					$sql2A = "SELECT SUM(actual_payment) as t_payment, MIN(end_bal) as curr_bal
							 FROM ar_loans_subs_detail
							 WHERE member_id = $member_id
						 	 AND DATE(trans_date) = '$pay_period'
							 AND trans_id = $row->trans_id";
							 
					$query2B = $this->tbms_db->query($sql2A);
					
					if($query2B->num_rows() > 0)		 
					{
						$re_class = $query2B->row('t_payment');
					}
					
					$sql2 = "SELECT SUM(actual_payment) as t_payment, MIN(end_bal) as curr_bal
						 	 FROM ar_loans_subs_detail
						 	 WHERE member_id = $member_id
						 	 AND DATE(trans_date) BETWEEN '$pay_period' AND '$trans_date'
							 AND DATE(trans_date) > '$pay_period'
						 	 AND trans_id = $row->trans_id";
				}
					
				
				$query2 = $this->tbms_db->query($sql2);
				
				$trans_record = $query2->row();
				
				$t_payment = $trans_record->t_payment;
				
				if(is_null($t_payment) AND $re_class == 0)
				{
					$actual     = 0;
				}	
				else
				{
					if(is_null($t_payment)){
						$t_payment = 0;
					}
						
					if($trans_date == $pay_period)
					{	
						$curr_bal  = ($trans_id==3) ? ($beg_bal - $t_payment) : ($beg_bal + $t_payment);
						$deferred  = max($sched - $t_payment,0);
					}
					else
					{
						$curr_bal  = ($trans_id==3) ? ($beg_bal - ($t_payment + $actual + $re_class)) : ($beg_bal + ($t_payment + $actual +  $re_class));
						$deferred  =  max($sched - ($t_payment + $actual + $re_class),0);
					}
						
					$actual  = $t_payment;
					$end_bal = $curr_bal;	
					
				}
				
				
			}
			
			#---------------------------------------------------------#
			$return_arr[]=  array(  'member_id' => $member_id,
									'trans_id' => $trans_id,
									'type'     => $type,
									'desc'	   => $desc,
									'sched'    => $sched,
									'billing'  => $billing,
									'semi'     => $semi_mo,
									'actual'   => $actual,
									'deferred' => $deferred,	
									'end_bal'  => $end_bal);
			#---------------------------------------------------------#	
			
		}
		return $return_arr;
		
    }

    function get_accounts_sl($member_id, $pay_period, $trans_date = '', $coln_type = 1, $sales_id = '')
    {
    	#$coln_type = ($coln_type == 1) ? $coln_type = '= 1' : $coln_type = ' IN (2,3)';
    	$trans_dt = '';
    	if(empty($trans_date) AND $trans_date == 0){
    		$trans_dt = 'AND trans_date IS NULL';
    	}
    	
    	$sales_id_where = '';
    	if(!empty($sales_id)){
    		$sales_id_where = "AND A.sales_id = $sales_id";
    	}
    	
    	#INCLUDE THRU SAVINGS
    	if($coln_type == 2)
    	{
    		$coln_type = "2,4";
    	}
    		
    	$sql = "SELECT B.*,
    				   prod_name,
    				   trans_type_sdesc,
    				   A.dr_number,
    				   A.po_start_date,
    				   A.po_end_date,
    				   A.gross_amount,
    				   A.prod_id,
    				   loan_cat_id
				FROM ar_loans_header A
				LEFT JOIN ar_loans_subs_detail B USING(sales_id)
				LEFT JOIN stg_transaction_types USING(trans_id)
				LEFT JOIN stg_loan_products USING(prod_id)
				WHERE pay_period = '$pay_period'
				AND A.member_id = '$member_id'
				AND A.collection_type IN ($coln_type)
				AND A.po_order_status = 'approved'
				$trans_dt
				$sales_id_where
				GROUP BY sales_id
				ORDER BY A.po_date,A.sales_id";
		$query = $this->tbms_db->query($sql);
		
		//echo $sql;	
		#if($sales_id == 697571){
		#	echo $sql;	
		#}
    	
		
		$return_arr = array();
			
		foreach($query->result() as $row)
		{
			
			
			#------------------------------------#
			$subs_id  = $row->subs_id;
			$sales_id = $row->sales_id;
			$trans_id = $row->trans_id;
			$prod_id  = $row->prod_id;
			$type     = $row->trans_type_sdesc;
			$trans_type = $row->trans_type;
			$desc	  = $row->prod_name;
			$po_number= $row->po_number;
			$dr_number= $row->dr_number;
			$start_dt = $row->po_start_date;
			$end_dt   = $row->po_end_date;
			$billing  = is_null($row->billing_dedn) ? 0 : $row->billing_dedn;
			$sched    = $row->sched_dedn;
			$semi_mo  = $row->semi_mo;
			$actual   = $row->actual_payment;
			$deferred = $row->deferred_amount;	
			$beg_bal  = $row->beg_bal;
			$end_bal  = $row->end_bal;
			$gross    = $row->gross_amount;
			#------------------------------------#
			
			if($row->loan_cat_id == 1 OR $row->loan_cat_id == 13)
			{
				$item = $this->tbms_db->get_where('ar_loans_detail',array('sales_id'=>$row->sales_id));
				
				if($item->num_rows() > 0 AND !empty($item->row('i_desc')))
				{
					$desc = $item->row('i_desc');	
				}
			}
			#echo $beg_bal.'<br>';
			if(!empty($trans_date) AND $trans_date != 0)
			{
				#RECLASS ACCOUNT FOR PAYROLL COLLECTION
				$re_class = 0;
				
				if($trans_date == $pay_period)
				{
					$sql2 = "SELECT SUM(actual_payment) as t_payment, MIN(end_bal) as curr_bal
							 FROM ar_loans_subs_detail
							 WHERE member_id = $member_id
						 	 AND ( 
						 	 	
						 	 (DATE(trans_date) BETWEEN '$pay_period' AND '$trans_date') 
						 	 	
						 	 OR (pay_period = '$pay_period' AND trans_date IS NULL) 
						 	 	
						 	 )
							 AND sales_id = $row->sales_id";
				}
				else
				{
					$sql2A = "SELECT SUM(actual_payment) as t_payment, MIN(end_bal) as curr_bal
							 FROM ar_loans_subs_detail
							 WHERE member_id = $member_id
						 	 AND DATE(trans_date) = '$pay_period'
							 AND sales_id = $row->sales_id";
							 
					$query2B = $this->tbms_db->query($sql2A);
					
					if($query2B->num_rows() > 0)		 
					{
						$re_class = $query2B->row('t_payment');
					}
					
					$sql2 = "SELECT SUM(actual_payment) as t_payment, MIN(end_bal) as curr_bal
						 	 FROM ar_loans_subs_detail
						 	 WHERE member_id = $member_id
						 	 AND DATE(trans_date) BETWEEN '$pay_period' AND '$trans_date'
							 AND DATE(trans_date) > '$pay_period'
						 	 AND sales_id = $row->sales_id";
				}
					
				
				$query2 = $this->tbms_db->query($sql2);
				
				$trans_record = $query2->row();
				
				$t_payment = $trans_record->t_payment;
				
				
				
				if(is_null($t_payment) AND $re_class == 0)
				{
					
					$actual     = 0;
				}	
				else
				{
					#echo $re_class;
					if(is_null($t_payment)){
						$t_payment = 0;
					}
						
					if($trans_date == $pay_period)
					{	
						
						$curr_bal  = ($trans_id==5) ? ($beg_bal + $t_payment) : ($beg_bal - $t_payment);
						$deferred = max($sched - $t_payment,0);
					}
					else
					{
						$curr_bal  = ($trans_id==5) ? ($beg_bal + ($t_payment + $actual + $re_class)) : ($beg_bal - ($t_payment + $actual +  $re_class));
						$deferred  = max($sched - ($t_payment + $actual +  $re_class),0);
					}
						
					$actual  = $t_payment;
					$end_bal = $curr_bal;	
					
				}
				
			}
			
			$need_to_return = TRUE;	
			if($beg_bal == 0 AND $actual == 0 AND $end_bal == 0){
				$need_to_return = FALSE;	
			}
			
			if($need_to_return):
			#---------------------------------------------------------#
			$return_arr[] = array(  'member_id'  => $member_id,
									'subs_id'  => $subs_id,
									'sales_id' => $sales_id,
									'prod_id'  => $prod_id,
									'trans_id' => $trans_id,
									'type'     => $type,
									'trans_type' => $trans_type,
									'desc'	   => $desc,
									'po_number'=> $po_number,
									'dr_number'=> $dr_number,
									'start_dt' => $start_dt,
									'end_dt'   => $end_dt,
									'billing'  => $billing,
									'sched'    => $sched,
									'semi'     => $semi_mo,
									'actual'   => $actual,
									'deferred' => $deferred,	
									'end_bal'  => $end_bal,
									'gross'    => $gross);
			#---------------------------------------------------------#	
			endif;
				
			
		}
		
		return $return_arr;
		
	}
	
	 function get_accounts_sl_all($member_id, $pay_period, $trans_date = '')
    {
    	#$coln_type = ($coln_type == 1) ? $coln_type = '= 1' : $coln_type = ' IN (2,3)';
    	$trans_dt = '';
    	if(empty($trans_date) AND $trans_date == 0){
    		$trans_dt = 'AND trans_date IS NULL';
    	}
    		
    	$sql = "SELECT B.*,
    				   prod_name,
    				   trans_type_sdesc,
    				   A.dr_number,
    				   A.po_start_date,
    				   A.po_end_date,
    				   A.gross_amount,
    				   A.prod_id
				FROM ar_loans_header A
				LEFT JOIN ar_loans_subs_detail B USING(sales_id)
				LEFT JOIN stg_transaction_types USING(trans_id)
				LEFT JOIN stg_loan_products USING(prod_id)
				WHERE pay_period = '$pay_period'
				AND A.member_id = '$member_id'
				AND A.po_order_status = 'approved'
				$trans_dt
				GROUP BY sales_id
				ORDER BY A.collection_type,A.po_date,A.sales_id";
		$query = $this->tbms_db->query($sql);
    	#echo $sql;	
		$return_arr = array();
			
		foreach($query->result() as $row)
		{
			#------------------------------------#
			$subs_id  = $row->subs_id;
			$sales_id = $row->sales_id;
			$trans_id = $row->trans_id;
			$prod_id  = $row->prod_id;
			$type     = $row->trans_type_sdesc;
			$desc	  = $row->prod_name;
			$po_number= $row->po_number;
			$dr_number= $row->dr_number;
			$start_dt = $row->po_start_date;
			$end_dt   = $row->po_end_date;
			$billing  = is_null($row->billing_dedn) ? 0 : $row->billing_dedn;
			$sched    = $row->sched_dedn;
			$semi_mo  = $row->semi_mo;
			$actual   = $row->actual_payment;
			$deferred = $row->deferred_amount;	
			$end_bal  = $row->end_bal;
			$beg_bal  = $row->beg_bal;
			$gross    = $row->gross_amount;
			#------------------------------------#
			
			if(!empty($trans_date) AND $trans_date != 0)
			{
				#RECLASS ACCOUNT FOR PAYROLL COLLECTION
				$re_class = 0;
				
				if($trans_date == $pay_period)
				{
					$sql2 = "SELECT SUM(actual_payment) as t_payment, MIN(end_bal) as curr_bal
							 FROM ar_loans_subs_detail
							 WHERE member_id = $member_id
						 	 AND ( (DATE(trans_date) BETWEEN '$pay_period' AND '$trans_date') OR (pay_period = '$pay_period' AND trans_date IS NULL) )
							 AND sales_id = $row->sales_id";
				}
				else
				{
					$sql2A = "SELECT SUM(actual_payment) as t_payment, MIN(end_bal) as curr_bal
							 FROM ar_loans_subs_detail
							 WHERE member_id = $member_id
						 	 AND DATE(trans_date) = '$pay_period'
							 AND sales_id = $row->sales_id";
							 
					$query2B = $this->tbms_db->query($sql2A);
					
					if($query2B->num_rows() > 0)		 
					{
						$re_class = $query2B->row('t_payment');
					}
					
					$sql2 = "SELECT SUM(actual_payment) as t_payment, MIN(end_bal) as curr_bal
						 	 FROM ar_loans_subs_detail
						 	 WHERE member_id = $member_id
						 	 AND DATE(trans_date) BETWEEN '$pay_period' AND '$trans_date'
							 AND DATE(trans_date) > '$pay_period'
						 	 AND sales_id = $row->sales_id";
				}
					
				
				$query2 = $this->tbms_db->query($sql2);
				
				$trans_record = $query2->row();
				
				$t_payment = $trans_record->t_payment;
				
				
				
				if(is_null($t_payment) AND $re_class == 0)
				{
					
					$actual     = 0;
				}	
				else
				{
					if(is_null($t_payment)){
						$t_payment = 0;
					}
						
					if($trans_date == $pay_period)
					{	
						$curr_bal  = ($trans_id==5) ? ($beg_bal + $t_payment) : ($beg_bal - $t_payment);
						$deferred = max($sched - $t_payment,0);
							
					}
					else
					{
						$curr_bal  = ($trans_id==5) ? ($beg_bal + ($t_payment + $actual + $re_class)) : ($beg_bal - ($t_payment + $actual +  $re_class));
						$deferred  = max($sched - ($t_payment + $actual +  $re_class),0);
					}
					
						
					$actual  = $t_payment;
					$end_bal = $curr_bal;	
					
					
					
				}
				
				
			}
			
			$need_to_return = TRUE;	
			if($beg_bal == 0 AND $actual == 0 AND $end_bal == 0){
				$need_to_return = FALSE;	
			}
			
			if($need_to_return):
			#---------------------------------------------------------#
			$return_arr[] = array(  'subs_id'  => $subs_id,
									'sales_id' => $sales_id,
									'prod_id'  => $prod_id,
									'trans_id' => $trans_id,
									'type'     => $type,
									'desc'	   => $desc,
									'po_number'=> $po_number,
									'dr_number'=> $dr_number,
									'start_dt' => $start_dt,
									'end_dt'   => $end_dt,
									'billing'  => $billing,
									'sched'    => $sched,
									'semi'     => $semi_mo,
									'actual'   => $actual,
									'deferred' => $deferred,	
									'end_bal'  => $end_bal,
									'gross'    => $gross);
			#---------------------------------------------------------#	
			endif;
		}
		
		return $return_arr;
		
	}
	
	
	function get_account_ob($member_id, $pay_period, $coln_type)
	{
		$fp = ', 3';
		
		$sql = "SELECT SUM(end_bal) as ob
				FROM ar_loans_subs_detail A
				LEFT JOIN ar_loans_header B ON (A.sales_id = B.sales_id)
				WHERE pay_period = '$pay_period'
				AND A.member_id = $member_id
				AND (A.trans_date IS NULL OR (DATE(A.trans_date) = '$pay_period' AND A.trans_type = 'NEW'))
				AND ( (collection_type = $coln_type AND B.po_order_status = 'approved') OR A.sales_id IS NULL)
				AND A.trans_id NOT IN (6,5,9,8,11,13,3)
				";
				//INS, SCS, TBP, RBP, FP	
		$query = $this->tbms_db->query($sql);
			
		$ob = 0;
			
		if($query->num_rows() > 0 AND !is_null($query->row('ob')) )
		{
			#INCLUDE OVERPAYMENT RECLASSIFICATION OF ACCOUNTS (same pay_period date)
			$offset_sql = " SELECT SUM(actual_payment) as t_payment
							FROM ar_loans_subs_detail A
							LEFT JOIN ar_loans_header B ON (A.sales_id = B.sales_id)
							WHERE pay_period = '$pay_period'
							AND A.member_id = $member_id
							AND DATE(A.trans_date) = '$pay_period'
							AND ( (collection_type = $coln_type AND B.po_order_status = 'approved') OR A.sales_id IS NULL)
							AND A.trans_id NOT IN (6,5,9,8,11,13,3)";
			$query_offset = $this->tbms_db->query($offset_sql);
				
			$ob_nya =  $query->row('ob');
			$offset = 0;
				
			if($query_offset->num_rows() > 0)
			{
				$offset = $query_offset->row('t_payment');
			}
				
			$ob += $ob_nya - $offset;
			
			#LESS MIGRATED ADVANCE PAYMENT	
			$sql_adv = "SELECT SUM(actual_payment) as adv
						FROM ar_loans_subs_detail A
						LEFT JOIN ar_loans_header B ON (A.sales_id = B.sales_id)
						WHERE pay_period > '$pay_period'
						AND A.member_id = $member_id
						AND A.trans_date IS NULL
						AND ( (collection_type = $coln_type AND B.po_order_status = 'approved') OR A.sales_id IS NULL)
						AND A.trans_id NOT IN (6,5,9,8,11,13,3)
						AND trans_type IS NULL";
					
			$query_adv = $this->tbms_db->query($sql_adv);				
			
			if($query_adv->num_rows() > 0)
			{
				$ob -= $query_adv->row('adv');
			}
		}	
			
		return $ob;
	}	
	
	function get_comaker_loans($member_id,$pay_period)
	{
		$sql = "SELECT
				CONCAT(mem_lname, ', ', mem_fname, ' ', LEFT(mem_mname, 1), '.') as maker_name,
				D.dr_number as dr_number,
				C.po_number as po_number,
				pay_period,
				beg_bal,
				po_date,
				A1.maker_id as member_id,
				A1.sales_id as sales_id
				FROM ar_loans_comakers A1
				LEFT JOIN mem_members B1 on A1.maker_id = B1.member_id
				LEFT JOIN ar_loans_subs_detail C on A1.sales_id = C.sales_id
				LEFT JOIN ar_loans_header D on A1.sales_id = D.sales_id
				WHERE C.pay_period = '$pay_period'
				AND trans_date IS NULL
				AND A1.member_id = $member_id
				GROUP BY A1.sales_id
				ORDER BY CONCAT(mem_lname, ', ', mem_fname, ' ', LEFT(mem_mname, 1), '.'), po_date, C.po_number";
			
						
		$query = $this->tbms_db->query($sql);
				
		return $query;
	}
	
	function get_comaker_loans_share($member_id,$pay_period)
	{
		$sql = "SELECT
				CONCAT(mem_lname, ', ', mem_fname, ' ', LEFT(mem_mname, 1), '.') as maker_name,
				D.dr_number as dr_number,
				C.po_number as po_number,
				pay_period,
				beg_bal,
				po_date,
				A1.maker_id as member_id,
				A1.sales_id as sales_id
				FROM ar_loans_comakers A1
				LEFT JOIN mem_members B1 on A1.maker_id = B1.member_id
				LEFT JOIN ar_loans_subs_detail C on A1.sales_id = C.sales_id
				LEFT JOIN ar_loans_header D on A1.sales_id = D.sales_id
				WHERE C.pay_period = '$pay_period'
				AND trans_date IS NULL
				AND A1.member_id = $member_id
				GROUP BY A1.sales_id
				ORDER BY CONCAT(mem_lname, ', ', mem_fname, ' ', LEFT(mem_mname, 1), '.'), po_date, C.po_number";
					
		$comaker = $this->tbms_db->query($sql);
		
		$t_bal = 0;
	    $t_share = 0;
				
		foreach($comaker->result() as $row): 	
			
			$sql = "SELECT SUM(actual_payment) as ap FROM ar_loans_subs_detail WHERE sales_id = $row->sales_id AND pay_period = '$pay_period'"; 
		  	$ap = $this->tbms_db->query($sql)->row('ap');
			  		
			if(is_null($ap) or empty($ap)){
				$ap = 0;
			}
			   		
		  	$active_cm = $this->m_members->get_active_comaker_per_loan($row->sales_id);
			
			if(is_null($active_cm) or empty($active_cm)){
			   	$active_cm = 0;
		    }
		    
		    if($active_cm > 0){
		    	$share = ($row->beg_bal-$ap) / $active_cm;
		    }else{
		    	$share = ($row->beg_bal-$ap);
		    }
		    
		    $t_bal += $row->beg_bal-$ap;
		    $t_share += $share;
		    	
		endforeach;
		   		
		return $t_share;
	}
	
	function get_active_comaker_per_loan($sales_id)
	{
		$q = "  SELECT COUNT(sales_id) as a
				FROM ar_loans_comakers
				LEFT JOIN mem_members USING (member_id)
				WHERE sales_id = $sales_id
				AND (company_id !=10 AND company_id !=25) 
				AND member_category IN (1,2,6)
				GROUP BY sales_id";
					
		$query = $this->tbms_db->query($q);
		
		if($query->num_rows() > 0)
		{
			return $query->row('a');
		}
		else
		{
			return 0;
		}
		
	}
	
	function get_active_comaker_per_loan_detail($sales_id)
	{
		$q = "  SELECT *,ar_loans_comakers.member_id as cm_id,CONCAT(mem_lname,', ',mem_fname,' ',SUBSTR(mem_mname,1,1),'.') as name 
				FROM ar_loans_comakers
				LEFT JOIN mem_members USING (member_id)
				LEFT JOIN ar_loans_header USING(sales_id)
				WHERE sales_id = $sales_id
				AND (company_id !=10 AND company_id !=25) 
				AND member_category IN (1,2,6)";
					
		$query = $this->tbms_db->query($q);
		
		return $query;
		
	}
		
   
    function get_contrib_amort_table($member_id,$trans_id)
    {
    	$sql = "SELECT *
    			FROM ar_loans_subs_detail
    			WHERE trans_id = $trans_id
    			AND member_id = $member_id
    			ORDER BY pay_period,trans_date";
    	#echo $sql;			
    	$query = $this->tbms_db->query($sql);
    	
    	return $query;
    }
    
    function get_account_amort_table($sales_id)
    {
    	$sql = "SELECT *
    			FROM ar_loans_subs_detail
    			WHERE sales_id = $sales_id
    			ORDER BY pay_period,trans_date";
    				
    	$query = $this->tbms_db->query($sql);
    	
    	return $query;
    }
    
    function get_member_id()
    {
    	$row = $this->tbms_db->query('SELECT max(member_id) + 1 as member_id FROM mem_members WHERE member_id != 999999');
		if($row->num_rows() == 0)
		{
			$member_id = '000001';
		}
		else
		{
			$member_id = str_pad($row->row('member_id'), 6, '0', STR_PAD_LEFT);
		}
		return $member_id;
    }
    
    function get_member_dependents($member_id)
    {
    	$sql = "SELECT *,CONCAT(mem_lname,', ',mem_fname) as name 
    			FROM mem_members
    			WHERE deduct_from = $member_id";
    			
    	$query = $this->tbms_db->query($sql);
    	
    	return $query;
    }
    
    function get_member_dependents_prin($member_id)
    {
    	$sql = "SELECT *,CONCAT(mem_lname,', ',mem_fname) as name 
    			FROM mem_members
    			WHERE (deduct_from = '$member_id' OR member_id = '$member_id')";
    			
    	$query = $this->tbms_db->query($sql);
    	
    	return $query;
    }
    
   
    function get_or_adv_per_date($sales_id = 0, $member_id, $trans_id, $pay_period)
    {
    	if($sales_id == ''){
    		$sales_id = 0;
    	}
    	
    	$sql = "SELECT SUM(or_details.amount) as t_amount
    			FROM or_header
    			LEFT JOIN or_details USING(or_id)
    			WHERE sales_id = $sales_id
    			AND trans_id = $trans_id
				AND member_id = $member_id
    			AND or_details.pay_period = '$pay_period'
    			AND is_advance = 1
    			AND posted_status = 1";
    	#echo $sql;		
    	$query = $this->tbms_db->query($sql);
    	
    	if($query->num_rows() > 0)
    	{
    		$t_amount = $query->row('t_amount');
    		
    		return is_null($t_amount) ? 0 : $t_amount;
    	}
    	else
    	{
    		return 0;
    	}
    }
    
    function get_mig_or_adv_per_date($sales_id = 0, $member_id, $trans_id, $pay_period)
    {
    	$sales = '';
    	
    	if(!empty($sales_id))
    	{
    		$sales = " AND sales_id = $sales_id";
    	}
    	
    	$sql = "SELECT *
    	      	FROM ar_loans_subs_detail
    			WHERE trans_id = $trans_id
    			$sales
				AND member_id = $member_id
    			AND pay_period = '$pay_period'
    			";
    				
    	$query = $this->tbms_db->query($sql);
    	
    	if($query->num_rows() > 0)
    	{
    		$t_amount = $query->row('actual_payment');
    		
    		return is_null($t_amount) ? 0 : $t_amount;
    	}
    	else
    	{
    		return 0;
    	}
    }
    
    function get_semi_adv_payments_per_po($sales_id='', $member_id , $trans_id, $semi_contrib = 0)
    {
    	$semi_arr = array();
    		
    	$next_pay_period = switch_date(get_last_billing());
    		
    	#CONTRIB
    	if( (empty($sales_id) OR is_null($sales_id) OR $sales_id == 0 OR $trans_id == 5))
    	{
    		$ctr = 1;
    		$ctr2 = 1;
    		while($ctr <= 36)
    		{
    			$semi = $semi_contrib;
    				
    			#CHECK DATE IF HAS ALREADY ADVANCE PAYMENT
				$adv_payment = $this->m_members->get_or_adv_per_date(NULL, $member_id,  $trans_id, $next_pay_period);
    			#echo 123;
				#CHECK MIGRATED RECORDS ADVANCE PAYMENT
				$adv_payment_m = $this->m_members->get_mig_or_adv_per_date(NULL, $member_id,  $trans_id, $next_pay_period);
					
				#$semi = $this->get_semi_sl(0, $member_id , $trans_id, $pay_period, $semi_contrib);
				#echo $adv_payment_m + $adv_payment;
				//LESS ADVANCE PAYMENT TO SEMI-AMORT
				if($adv_payment_m + $adv_payment > 0)
				{
					$semi -= ($adv_payment + $adv_payment_m);
				}
					
				if($semi > 0)
				{
					$semi_arr[] = array( 'ctr' => $ctr,
										 'pay_period' => $next_pay_period,
										 'semi' => $semi	 
										);
					$ctr++;		
				}	
					
				$next_pay_period = switch_date($next_pay_period);	
					
    		}
    		
    		
		}
		else
		{
			
			
			$sql = "SELECT *
    				FROM ar_loans_header
    				WHERE sales_id = $sales_id
    				";
    		$loan_info = $this->tbms_db->query($sql)->row();	
    			
    		$start = $loan_info->po_start_date;
    			
    		if($next_pay_period >= $loan_info->po_start_date){
    			$start = $next_pay_period;
    		}
			
			$arr = get_date_arr( $start, $loan_info->po_end_date);
			$ctr_semi = 1;
			foreach($arr as $pay_period => $ctr)
			{
				#CHECK DATE IF HAS ALREADY ADVANCE PAYMENT
				$adv_payment = $this->m_members->get_or_adv_per_date($sales_id, $member_id,  $trans_id, $pay_period);
					
				#CHECK MIGRATED RECORDS ADVANCE PAYMENT
				$adv_payment_m = $this->m_members->get_mig_or_adv_per_date($sales_id, $member_id,  $trans_id, $pay_period);
				
				$semi = $this->get_semi_sl($sales_id, $member_id , $trans_id, $pay_period, $semi_contrib);
				
				//LESS ADVANCE PAYMENT TO SEMI-AMORT
				if($adv_payment_m + $adv_payment > 0)
				{
					$semi -= $adv_payment + $adv_payment_m;
				}
					
				if($semi > 0)
				{
					$semi_arr[] = array( 'ctr' => $ctr_semi++,
										 'pay_period' => $pay_period,
								 		 'semi' => $semi); 
				}
			}
		}
		
		return $semi_arr;
    }
    
    function get_semi_sl($sales_id='', $member_id , $trans_id, $pay_period, $semi_contrib = 0)
    {
    	$contrib_arr = array( 11 => 'tbp_contrib',
					    	  8  => 'rbp_contrib',
					    	  9  => 'scs_contrib',
					    	  6  => 'membership_fee'
					    	  );
    		
    	#CONTRIB
    	if(empty($sales_id) OR is_null($sales_id))
    	{
    		$sql = "SELECT *
    				FROM mem_members
    				WHERE '$pay_period' >= dedn_start_dt
    				AND member_id = $member_id
    				";
    		$contrib = $this->tbms_db->query($sql);	
    		//NOT FP, OVERPAYMENT
    		if($contrib->num_rows() > 0 AND $trans_id != 3 AND $trans_id != 13)
    		{
    			$contrib_row = $contrib->row_array();
    				
    			return $contrib_row[$contrib_arr[$trans_id]];
    		}
    		else
    		{
    			return 0;
    		}
    	}
    	else
    	{
    		$sql = "SELECT *
    				FROM ar_loans_header
    				WHERE sales_id = $sales_id
    				AND '$pay_period' BETWEEN po_start_date AND po_end_date";
    		$accts = $this->tbms_db->query($sql);		
    		
    		if($accts->num_rows() > 0)
    		{
    			$loan_h = $accts->row();
    			#SR, TEAM, at kaya niya.
    			if($loan_h->sc_amort_months > 0 AND $loan_h->semi_amort_w_sc > 0)
    			{
    				$pay_terms     = $loan_h->pay_terms;
	    			$po_start_date = $loan_h->po_start_date;
	    			$po_end_date   = $loan_h->po_end_date;
	    				
	    			$date_arr = get_date_arr($po_start_date, $po_end_date);
	    				
	    			$curr_pd = $date_arr[$pay_period] / 2;
		    			
	    			if($curr_pd <= $loan_h->sc_amort_months)
	    			{
	    				return $loan_h->semi_amort_w_sc;
	    			}
	    			else
	    			{
	    				return $loan_h->semi_amort_wo_sc;
	    			}
		    			
    			}
    			else
    			{
    				#echo "$loan_h->semi_monthly_amor > $semi_contrib";
    					
    				if($semi_contrib > 0)
    				{
    					if($loan_h->semi_monthly_amor != $semi_contrib)
    					{
    						return $semi_contrib;
    					}
    					else
    					{
    						return $loan_h->semi_monthly_amor;
    					}
    				}
    				else
    				{
    					return $loan_h->semi_monthly_amor;
    				}
    			}
    		}
    		else
    		{
    			return 0;
    		}
    	}
    }
	    
	function get_for_approval_by_company($company_id,$mem_status_id = '',$status = '')
	{
		$and = '';
		if($status != '' && $status != 'all')
		{
			$and = "AND member_id IN(
										SELECT member_id FROM mem_members_temp
										WHERE status = $status
									)";
		}
		
		if($status == 'all_res'){
			
			$and = "AND member_id IN(
										SELECT member_id FROM mem_members_temp
										WHERE status IN (3,4,5)
									)";
			
		}
		
		$and1 = '';
		if($mem_status_id)
		{
			$and1 = "AND mem_status_id = $mem_status_id";
		}
		
		$or = '';
		if($mem_status_id && $status)
		{
			$and1 = '';
			$and = '';
			$or = "AND (
							mem_status_id = 1
							OR 
							member_id IN(
											SELECT member_id FROM mem_members_temp
										)
						 )";
		}
		
		$male = $this->tbms_db->query("SELECT * FROM mem_members 
												 WHERE company_id = $company_id
												 $or 
												 $and1
												 AND mem_gender = 'M'
												 $and")->num_rows();
												 	
		$female = $this->tbms_db->query("SELECT * FROM mem_members 
												  WHERE company_id = $company_id
												  $or
												  $and1
												  AND mem_gender = 'F'
												  $and")->num_rows();
		$total = $female + $male;
		
		return array(
			'male'=>$male,
			'female'=>$female,
			'total'=>$total,
		);
	}
	
	function get_emp_by_empid($emp_id,$company_id)
	{
		$row = $this->tbms_db->query("  SELECT *  FROM mem_members
										#WHERE member_id NOT IN	(
										#							SELECT member_id FROM mem_members_temp
										#						)
										WHERE mem_status_id = 2
										AND member_category NOT IN(4,5)
										AND (mem_emp_id = '$emp_id' OR mem_emp_id2 = '$emp_id')
										AND company_id = $company_id
									")->row();
		return $row;
		
	}
	
	function get_emp_by_empid_for_all($emp_id,$company_id)
	{
		$row = $this->tbms_db->query("SELECT *  FROM mem_members
												#WHERE member_id NOT IN	(
												#							SELECT member_id FROM mem_members_temp
												#						)
												WHERE mem_status_id = 2
												AND (mem_emp_id = '$emp_id' OR mem_emp_id2 = '$emp_id')
												AND company_id = $company_id
									")->row();
		return $row;
		
	}
	
	function saved_or_payment($sales_id = '', $trans_id, $member_id)
	{
		#FOR BALANCE
		#GET THE LAST ENTRY FOR LAST PAY PERIOD
		
		$last_pay_period = get_last_billing();
		
		$last = $this->tbms_db->query("SELECT * FROM ar_loans_subs_detail 
												WHERE sales_id = '$sales_id' 
												AND pay_period = '$last_pay_period' 
												ORDER BY subs_id DESC 
												LIMIT 1")->row();
		#CREATE NEW ENTRY WITH DATE TODAY AS TRANSACTION DATE
		$end_bal = $last->end_bal - $row->deduction_amt;
		$data = array(
			'sales_id'=>$row->sales_id,
			'member_id' =>$member_id,
			'trans_id' =>$row->trans_id,
			'po_number' =>$row->po_number,
			'trans_date'=>date('Y-m-d H:i:s'),
			'beg_bal' => $last->end_bal,
			'sched_dedn' => 0,
			'pay_period' => $row->pay_period,
			'semi_mo' => 0,
			'actual_payment' => $row->deduction_amt,
			'deferred_amount' => 0,
			'end_bal' => $end_bal,
			'trans_type' => 'OR',
		);
		
		$this->tbms_db->insert('ar_loans_subs_detail',$data);
		
		#CHECK FOR REBATE
		if($row->rebate > 0)
		{
			#BEG BAL WILL BE END BAL OR (last->end_bal - row->deduction_amt)
			$data = array(
				'sales_id'=>$row->sales_id,
				'member_id' =>$member_id,
				'trans_id' =>$row->trans_id,
				'po_number' =>$row->po_number,
				'trans_date'=>date('Y-m-d H:i:s'),
				'beg_bal' => $end_bal,
				'sched_dedn' => 0,
				'pay_period' => $row->pay_period,
				'semi_mo' => 0,
				'actual_payment' => $row->rebate,
				'deferred_amount' => 0,
				'end_bal' => 0,
				'trans_type' => 'ADJ',
				'remarks' => 'Rebate'
			);
			
			$this->tbms_db->insert('ar_loans_subs_detail',$data);
		}
		
		#UPDATE NEXT ENTRY WITH NEXT BILLING(update certain things to zero)
		$next_period = switch_date($row->pay_period);
		$next = $this->tbms_db->query("SELECT * FROM ar_loans_subs_detail 
												WHERE po_number = '$row->po_number' 
												AND pay_period = '$next_period' 
												ORDER BY subs_id DESC 
												LIMIT 1")->row();
			
		$data2 = array(
			'beg_bal' => 0,
			'sched_dedn' => 0,
			'end_bal' => 0,
		);
		
		$this->tbms_db->where('subs_id', $next->subs_id);
		$this->tbms_db->update('ar_loans_subs_detail', $data2);
	}
		
	function get_final_pay_billing($member_id, $pay_period, $trans_date)
	{
		#TOTAL VARIABLES 	
		$contrib_sched = 0;
		$t_payroll = 0;
		$t_or_pdc = 0;
		$t_bonuses = 0;
		
		$data_array = array();
			
		#-----------------------------------------------------#
		# BILLING INFORMATION FOR FINAL MRP COLLECTION
		#-----------------------------------------------------#
		# 1. INCLUDE CONTRIB DEF (TBP, RBP) FP BALANCE
		#-----------------------------------------------------#
		# 2. LOANS BALANCE (REGULAR PAYROLL) INS DEFERRED ONLY
		#-----------------------------------------------------#
		# 3. LOANS BALANCE (OR/PDC)
		#-----------------------------------------------------#
		# 4. LOANS BALANCE (BONUSES)
		#-----------------------------------------------------#
		# 5. DEPENDENT ACCOUNTS (SAME AS 1-4)
		#-----------------------------------------------------#
			
		# 1. INCLUDE CONTRIB DEF (TBP, RBP) FP BALANCE	
		$contrib = $this->m_members->get_contrib_all($member_id, $pay_period, $trans_date);
		foreach($contrib as $row)
		{
			$amt_billed = 0;
			
			if($row['trans_id'] == 8 OR $row['trans_id'] == 11)
			{
				$contrib_sched += $row['deferred'];
				$amt_billed = $row['deferred'];
			}
			elseif($row['trans_id'] == 3)
			{
				$contrib_sched += $row['end_bal'];
				$amt_billed = $row['end_bal'];
			}
				
			$data_array[] = array(  'member_id' => $member_id,
									'sales_id' => NULL,
									'trans_id' => $row['trans_id'],
									'amount_billed' => $amt_billed);
		}

		# 2. LOANS BALANCE (REGULAR PAYROLL) INS DEFERRED ONLY	
		$payroll = $this->m_members->get_accounts_sl($member_id, $pay_period, $trans_date,  1);
		foreach($payroll as $row)
		{
			$amt_billed = 0;
			
			if($row['trans_id'] == 5){
				$t_payroll += $row['deferred'];
				$amt_billed = $row['deferred'];
			}else{
				$t_payroll += $row['end_bal'];
				$amt_billed = $row['end_bal'];
			}
				
			$data_array[] = array(  'member_id' => $row['member_id'],
									'sales_id' => $row['sales_id'],
									'trans_id' => $row['trans_id'],
									'amount_billed' => $amt_billed);
			
		}
		
		# 3. LOANS BALANCE (OR/PDC)	
		$or_pdc = $this->m_members->get_accounts_sl($member_id, $pay_period, $trans_date,  2);
		foreach($or_pdc as $row)
		{
			$amt_billed = 0;
			
			if($row['trans_id'] == 5){
				$t_or_pdc += $row['deferred'];
				$amt_billed = $row['deferred'];
			}else{
				$t_payroll += $row['end_bal'];
				$amt_billed = $row['end_bal'];
			}
				
			$data_array[] = array(  'member_id' => $row['member_id'],
									'sales_id' => $row['sales_id'],
									'trans_id' => $row['trans_id'],
									'amount_billed' => $amt_billed);
									
		}
		
		# 4. LOANS BALANCE (BONUSES)		
		$bonuses = $this->m_members->get_accounts_sl($member_id, $pay_period, $trans_date,  3);
		foreach($bonuses as $row)
		{
			$amt_billed = 0;
				
			$t_bonuses += $row['end_bal'];
			$amt_billed = $row['end_bal'];
				
			$data_array[] = array(  'member_id' => $row['member_id'],
									'sales_id' => $row['sales_id'],
									'trans_id' => $row['trans_id'],
									'amount_billed' => $amt_billed);
									
		}
		
		# 5. DEPENDENT ACCOUNTS (SAME AS 1-4)	
		$dep = $this->m_members->get_member_dependents($member_id);
		foreach($dep->result() as $dep_row)
		{
			$contrib = $this->m_members->get_contrib_all($dep_row->member_id, $pay_period, $trans_date);
			
			foreach($contrib as $row)
			{
				$amt_billed = 0;
				
				if($row['trans_id'] == 8 OR $row['trans_id'] == 11)
				{
					$contrib_sched += $row['deferred'];
					$amt_billed = $row['deferred'];
				}
				elseif($row['trans_id'] == 3)
				{
					$contrib_sched += $row['end_bal'];
					$amt_billed = $row['end_bal'];
				}
					
				$data_array[] = array(  'member_id' => $row['member_id'],
										'sales_id' => NULL,
										'trans_id' => $row['trans_id'],
										'amount_billed' => $amt_billed);
			}
			
			$payroll = $this->m_members->get_accounts_sl($dep_row->member_id, $pay_period, $trans_date,  1);
				
			foreach($payroll as $row)
			{
				$amt_billed = 0;
				
				if($row['trans_id'] == 5){
					$t_payroll += $row['deferred'];
					$amt_billed = $row['deferred'];
				}else{
					$t_payroll += $row['end_bal'];
					$amt_billed = $row['end_bal'];
				}
					
				$data_array[] = array(  'member_id' => $row['member_id'],
										'sales_id' => $row['sales_id'],
										'trans_id' => $row['trans_id'],
										'amount_billed' => $amt_billed);
				
			}
				
			$or_pdc = $this->m_members->get_accounts_sl($dep_row->member_id, $pay_period, $trans_date,  2);
				
			foreach($or_pdc as $row)
			{
				$amt_billed = 0;
				
				if($row['trans_id'] == 5){
					$t_or_pdc += $row['deferred'];
					$amt_billed = $row['deferred'];
				}else{
					$t_payroll += $row['end_bal'];
					$amt_billed = $row['end_bal'];
				}
					
				$data_array[] = array(  'member_id' => $row['member_id'],
										'sales_id' => $row['sales_id'],
										'trans_id' => $row['trans_id'],
										'amount_billed' => $amt_billed);
										
			}
				
			$bonuses = $this->m_members->get_accounts_sl($dep_row->member_id, $pay_period, $trans_date,  3);
				
			foreach($bonuses as $row)
			{
				$amt_billed = 0;
						
				$t_bonuses += $row['end_bal'];
				$amt_billed = $row['end_bal'];
					
				$data_array[] = array(  'member_id' => $row['member_id'],
										'sales_id' => $row['sales_id'],
										'trans_id' => $row['trans_id'],
										'amount_billed' => $amt_billed);
											
			}
			
		}
		
		$total_billing = $contrib_sched + $t_payroll + $t_or_pdc + $t_bonuses;
		
		return array('total_billing' => $total_billing, 'billing_details'=>$data_array);
		
	}
    
	
	
}