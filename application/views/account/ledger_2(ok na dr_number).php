



<?

	$sqlsdf = "SELECT DISTINCT(pay_period)
						   FROM ar_member_subs where member_id = '$member_id'
						   && pay_period < NOW()
						   AND post_by IS NOT NULL
						   ORDER BY `ar_member_subs`.`pay_period`  DESC LIMIT 1";
						   
	$resultadf= mysql_query($sqlsdf) or die (mysql_error().$sqlsdf);
	$rowadf = mysql_fetch_array($resultadf, MYSQL_ASSOC);					   

?>





<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<link rel='stylesheet' href='<?=CSS_PATH?>thickbox.css' type='text/css' charset='utf-8' />
<link rel='stylesheet' href='<?=CSS_PATH?>ledger.css' type='text/css' charset='utf-8' />

<script type="text/JavaScript" src="<?=JS_PATH?>jquery.js"></script>
<script type="text/JavaScript" src="<?=JS_PATH?>thickbox.js"></script>



</script>



	<style>
	
	</style>
	<form action="<?=site_url($this->uri->uri_string())?>" method="POST">
	
	<?php
		
		$lastdate = getLastBilling();
		
		if(!empty($member_id)) {
		$query = "SELECT
	             A.member_id, 
	             CONCAT(member_lname, ', ', member_fname, ' ', LEFT(member_mname, 1), '.') AS name,
             member_emp_id, member_emp_id2, company_name, member_lname, company_name, max(pay_period) as period, scs_divisor,member_category, B.company_id
	             FROM members A 							
				 LEFT JOIN companies B ON A.company_id = B.company_id
				 LEFT JOIN ar_member_subs C on A.member_id = C.member_id
				 WHERE A.member_id ={$member_id}
				 GROUP BY A.member_id, name, member_emp_id, member_emp_id2, company_name, member_lname, company_name";
		$result = mysql_query($query) or die (mysql_error().$query);
		$row = mysql_fetch_array($result, MYSQL_ASSOC);
		$scs_divisor = $row['scs_divisor'];
		if($this->input->post('sel_date'))
			$lastBilling = $this->input->post('sel_date');
		else
			$lastBilling = $rowadf['pay_period'];#2012-07-15';#getLastBilling();
		$today2 = date("Y-m-d");
		
	?>
	
	
		<table  border="0" width="60%" align="left">
		<tr>
			<td>Member's Account as of : <?=$this->input->post('sel_date')?date("M. d, Y",strtotime($this->input->post('sel_date'))):date("M. d, Y")?></td>
			<td>History: <select name="sel_date" id="sel_date" onchange="submit();">
				<option value="0">Current Date</option>
				<?
				$queryA = "SELECT DISTINCT(pay_period) 
						   FROM ar_member_subs where member_id = '{$row['member_id']}' 
						   && pay_period < NOW()  
						   AND post_by IS NOT NULL
						   ORDER BY `ar_member_subs`.`pay_period`  DESC LIMIT 3";
				$resultA = mysql_query($queryA);
				
				while($rowA = mysql_fetch_array($resultA))
				{
					
					if($this->input->post('sel_date') == $rowA['pay_period'])
						echo '<option value="'.$rowA['pay_period'].'" selected="selected">'.date("M. d, Y",strtotime($rowA['pay_period'])).'</option>';	
						#echo '<option value="'.$next_x.'" >'.date("M. d, Y",strtotime($next_x)).'</option>';	
					#elseif($this->input->post('sel_date') == $next_x)	
				#	{
					#	echo '<option value="'.$next_x.'" selected="selected" >'.date("M. d, Y",strtotime($next_x)).'</option>';	
				#		echo '<option value="'.$rowA['pay_period'].'">'.date("M. d, Y",strtotime($rowA['pay_period'])).'</option>';	
				#	}
					else
						echo '<option value="'.$rowA['pay_period'].'">'.date("M. d, Y",strtotime($rowA['pay_period'])).'</option>';	
				}
				?>
			</select></td>
		</tr>
		<tr>
			 <title>
	
	<?=$row['name']?>
	
</title>
			<td width="350">Member Name :&nbsp; <strong style="font-size:16px;"><?=$row['name']?></strong></td>
			<td width="250">Company : <?=$row['company_name']?></td>
		</tr>
		<tr>
			
			<td>Company Id : <?=$row['member_emp_id'] .' / '. $row['member_emp_id2']?></td>
			<td>Member Status : 
			<? if( ($row['member_category'] == 2 AND $row['membership_status'] == 3) OR $row['company_id'] == 10 ) :?>	
				Resigned from coop
			<?else:?>	
				Active
			<?endif;?>
		</td>
		</tr>
		<tr>
			<td>Member Id : <?=setLength($row['member_id'])?></td>
				<?
				if($this->input->post('sel_date')==0)
				{
					$is_current = 1;
				}else
				{
					$is_current = 0;
				}	
				?>
			<td> 
				<div style="width:160px;" onmouseover="this.style.cursor='pointer';" onclick="javascript: window.open('<?=site_url("account/fpdf/$lastBilling/$is_current")?>', '_blank','printable', 'menubar=0, resizable=0, height=600, width=800');">
				 <img src="<?=IMAGE_PATH?>printer.png" style="float:left; margin-top:-4px;width:20px"/> 	&nbsp;&nbsp; <strong>Print Credit Standing</strong>
				</div>
			
			</td>
		</tr>
	</table>
		<br>	
		<br>
		<br>	
		<br><br>	
		<br><br>	
		<br>
		<br>
		<table width="100%" style="margin-right:10px" class="center" border="1" style="border-collapse: collapse; border: 1px #000 solid;">
			<tr class="Thead">
				<td>TYPE #</td>
				<td>PO NUMBER</td>
				<td>PO DOC #</td>
				<td>END DATE</td>
				<td>SCHED DEDN</td>
				<td>PAYMENT</td>
				<td>DEFFERED</td>
				<td>SEMI AMOR</td>
				<td>BALANCE</td>
				<td>DESCRIPTION</td>
			</tr>
			<?php
				
				$nxtBilling = get_next_billing($lastBilling);
				
				
				$query = "SELECT subs_id, member_id, A.trans_id, pay_period, ROUND(beg_balance,6) as beg_balance, semi_mon_ammort, scheduled_dedn_amt, actual_payment, deferred_amount, ROUND(end_balance,6) as end_balance, post_by, post_date, B.trans_id, accnt_code, trans_type_sdesc, trans_type_ldesc, priority, semi_monthly_contrib, created_by, date_created, updated_by, date_updated
								FROM ar_member_subs A
								LEFT JOIN m_transaction_types B on A.trans_id = B.trans_id
								WHERE member_id = {$member_id} AND A.trans_id  in (3)
								AND A.pay_period = '$lastBilling'
							UNION ALL
								SELECT subs_id, member_id, A.trans_id, pay_period, ROUND(beg_balance,6) as beg_balance, semi_mon_ammort, scheduled_dedn_amt, actual_payment, deferred_amount, ROUND(end_balance,6)  as end_balance, post_by, post_date, B.trans_id, accnt_code, trans_type_sdesc, trans_type_ldesc, priority, semi_monthly_contrib, created_by, date_created, updated_by, date_updated 
								FROM ar_member_subs A
								LEFT JOIN m_transaction_types B on A.trans_id = B.trans_id
								WHERE member_id = {$member_id} AND A.trans_id not in (0,1,2,3,4,5,7,10)
								AND A.pay_period = '$lastBilling'
							UNION ALL
								SELECT subs_id, member_id, A.trans_id, pay_period, ROUND(beg_balance,6) as beg_balance, semi_mon_ammort, scheduled_dedn_amt, actual_payment, deferred_amount, ROUND(end_balance,6) as end_balance, post_by, post_date, B.trans_id, accnt_code, trans_type_sdesc, trans_type_ldesc, priority, semi_monthly_contrib, created_by, date_created, updated_by, date_updated 
								FROM ar_member_subs A
								LEFT JOIN m_transaction_types B on A.trans_id = B.trans_id
								WHERE member_id = {$member_id} AND A.trans_id in (10)
								AND A.pay_period = '$lastBilling'";
				
				/*$query = "SELECT * 
							FROM ar_member_subs A 
							LEFT JOIN m_transaction_types B on A.trans_id = B.trans_id						
							WHERE member_id = {$member_id} AND A.trans_id not in (0,1,2,4,5,7)
							AND A.pay_period = '$lastBilling'
							ORDER BY B.trans_id";
				*/
				# Modified by Majo : 2009-03-05 : to include advance payments on end balances
					
				
				$sub_total = 0;	
				$scs1_exist = 0;
				$scs_exist = 0;
				$result = mysql_query($query) or die (mysql_error().$query);
				$t_dedn_amt = 0;
				$t_actual_pay = 0;
				$t_deferr = 0;
				$t_semi = 0;
				$t_end_bal = 0;
				$t_scs = 0;
				$t_end_bal2x = 0;
					
				while($row = mysql_fetch_array($result, MYSQL_ASSOC))
				{
					$chkOR_contrib = "SELECT sum(amt) as or_amount, pay_period1, pay_period2
									  FROM or_header A 
									  INNER JOIN or_details B on A.or_id = B.or_id
								      WHERE po_num = '{$row['accnt_code']}'
									  AND or_date >= '$lastBilling'
									  AND or_date <= '$nxtBilling'
									  AND member_id = $member_id								  
									  AND A.posted_status = 1
								      GROUP BY po_num";
					
					$resultOR_contrib = mysql_query($chkOR_contrib) or die (mysql_error() . "Error in Query : ". $chkOR_contrib);
					$rowOR = mysql_fetch_array($resultOR_contrib, MYSQL_ASSOC);
					
					$or_contrib = is_null($rowOR['or_amount']) ? 0 : $rowOR['or_amount'];
					
					$qAdvance = "SELECT sum(actual_payment) as adv_payments
								 FROM ar_member_subs
								 WHERE trans_id = '{$row['trans_id']}'
								 AND pay_period > '{$lastBilling}'
								 AND member_id = '$member_id'";
					$rAdvance = mysql_query($qAdvance) or die (mysql_error() . "Error in Query : ".$qAdvance);
					$rwAdvance = mysql_fetch_array($rAdvance, MYSQL_ASSOC);
					
					if ($this->input->post('sel_date') == 0)
					{
						
						if($row['trans_id'] == 9)
						{
							
							$qAdvance2 = "SELECT sum(actual_payment) as adv_payments
								 FROM ar_member_subs
								 WHERE trans_id = 10
								 AND pay_period > '{$lastBilling}'
								 AND member_id = '{$member_id}'";
							$rAdvance2 = mysql_query($qAdvance2) or die (mysql_error() . "Error in Query : ".$qAdvance2);
							$rwAdvance2 = mysql_fetch_array($rAdvance2, MYSQL_ASSOC);
							
							$rwAdvance['adv_payments'] += $rwAdvance2['adv_payments'];
						}
						
						#advance payments						
						#JETH $row['end_balance'] + $rwAdvance['adv_payments'] to $row['end_balance'] - $rwAdvance['adv_payments'];
						$balance_contrib = $row['end_balance'] + $rwAdvance['adv_payments'];
						$payments_contrib = $or_contrib;
						$deferred = number_format($row['deferred_amount'],2,".",",");
						$t_deferr += $row['deferred_amount'];
					}
					else
					{ 
						
						$balance_contrib = $row['end_balance'];
						$payments_contrib = $row['actual_payment'];
						$deferred = number_format($row['deferred_amount'],2,".",",");
						$t_deferr += $row['deferred_amount'];
						
					}
					
					$sched_dedn_amt = number_format($row['scheduled_dedn_amt'],2,".",",");
					$actual_pay = number_format($payments_contrib,2,".",",");
					
					$semi = number_format($row['semi_mon_ammort'],2,".",",");
					$end_bal = number_format($balance_contrib,2,".",",");
					
					$t_dedn_amt += $row['scheduled_dedn_amt'];
					$t_actual_pay += $payments_contrib;
					
					$t_semi += $row['semi_mon_ammort'];
					$t_end_bal += $balance_contrib;
					echo "
						<tr>
							<td>{$row['trans_type_sdesc']}</td>
							<td></td>
							<td></td>
							<td></td>
							<td class = 'td' align=\"right\">$sched_dedn_amt</td>
							<td class = 'td' align=\"right\">$actual_pay</td>
							<td class = 'td' align=\"right\">$deferred</td>
							<td class = 'td' align=\"right\">$semi</td>
							<td class = 'td' align=\"right\">$end_bal</td>
							<td>{$row['trans_type_ldesc']}</td>
						</tr>
					";
					
					
					if($row['trans_id'] == 3)
					{
						$t_end_bal2x += $row['end_balance'];
					}
					
					if($row['trans_id'] == 8 || $row['trans_id'] == 11)
					{
						$t_end_bal2x += $row['deferred_amount'];
					}
					
					if($row['trans_id'] == 9 OR $row['trans_id'] == 10) {
						$t_scs += $row['end_balance'];
					}
					
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
					
					echo "
						<tr>
							<td>SCS</td>
							<td></td>
							<td></td>
							<td></td>
							<td class = 'td' align=\"right\">0.00</td>
							<td class = 'td' align=\"right\">0.00</td>
							<td class = 'td' align=\"right\">0.00</td>
							<td class = 'td' align=\"right\">0.00</td>
							<td class = 'td' align=\"right\">14,000.00</td>
							<td class = 'td' align=\"left\">Subscription Fee</td>
						</tr>
					";
					
				}
				//===============================================================//
				
				
				//echo $t_dedn_amt;
				echo "
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td class = 'totals' align=\"right\">".number_format($t_dedn_amt,2,".",",")."</td>
							<td class = 'totals' align=\"right\">".number_format($t_actual_pay,2,".",",")."</td>
							<td class = 'totals' align=\"right\">".number_format($t_deferr,2,".",",")."</td>
							<td class = 'totals' align=\"right\">".number_format($t_semi,2,".",",")."</td>
							<td class = 'totals' align=\"right\">".number_format($t_end_bal,2,".",",")."</td>
							<td></td>
						</tr>
					";
				
				$query2 = "SELECT *, C.interest as intrst,
									 A.po_number as this_po_number ,
									 po_start_date,
									 pay_period,
									 beginning_bal, 
									 C.commission,
									 C.prod_id as prod,
									 post_ar_by,
									 trans_type_sdesc,
									 trans_type_ldesc,
									 sales_id
							FROM ar_member_subs_detail A 
								LEFT JOIN p_sales_header C on A.po_number = C.po_number
								LEFT JOIN m_loan_products D on C.prod_id = D.prod_id
								LEFT JOIN m_transaction_types E on A.trans_type = E.trans_id
							WHERE A.member_id = $member_id
							AND A.pay_period = '$lastBilling'
							AND C.prod_id != 'L-FS09'
							AND po_status != 5
							AND C.Prod_Id NOT IN ('L-FS04')";
					
				//$query2 .= " AND A.trans_type in (select distinct(trans_id) from ar_member_subs where member_id = $member_id)AND A.pay_period = (SELECT MAX(pay_period) FROM ar_member_subs_detail WHERE member_id = $member_id AND pay_period <= '$today2' GROUP BY member_id LIMIT 1)";
				//$query2 .=" ORDER BY A.trans_type";
				$result2 = mysql_query($query2) or die (mysql_error().$query2);
				$t_dedn_amt2 = 0;
				$t_actual_pay2 = 0;
				$t_deferr2 = 0;
				$t_semi2 = 0;
				$t_end_bal2 = 0;
				
				$t_principal = 0;
				$x = 0;
				$advance = 0;
				while($row2 = mysql_fetch_array($result2, MYSQL_ASSOC))
				{	
					$chkOR_contrib = "SELECT sum(amt) as or_amount, pay_period1, pay_period2
									  FROM or_header A 
									  INNER JOIN or_details B on A.or_id = B.or_id
								      WHERE po_num = '{$row2['this_po_number']}'
									  AND or_date >= '$lastBilling'
									  AND or_date <= '$nxtBilling'
									  AND member_id = $member_id
									  AND A.posted_status = 1
									  GROUP BY po_num";
					$resultOR_contrib = mysql_query($chkOR_contrib) or die (mysql_error() . "Error in Query : ". $chkOR_contrib);
					$rowOR = mysql_fetch_array($resultOR_contrib, MYSQL_ASSOC);
					
					#=====================================================================#
					$or_contrib = is_null($rowOR['or_amount']) ? 0 : $rowOR['or_amount'];
					#=====================================================================#
					
					
					$queryZ = "SELECT SUM(actual_payment) AS t_ap
							   FROM ar_member_subs_detail 
							   WHERE po_number = '{$row2['this_po_number']}'
							   AND pay_period > '$lastBilling'";
					$resultZ = mysql_query($queryZ);
					$rowZ = mysql_fetch_array($resultZ);
					
					if ($this->input->post('sel_date') == 0)
					{
						#advance payments						
						$end_bal2 = $row2['end_bal'] - $rowZ['t_ap'];
						$a_p = $or_contrib;
						$deferred2 = number_format($row2['deferred_amount'],2,".",",");
						$t_deferr2 += $row2['deferred_amount'];
					}
					else
					{
						if (!is_null($rowOR['or_amount']))
						{						
							$a_p = $row2['actual_payment'];# - ($or_contrib - $rowZ['t_ap']);										
							$deferred2 = ($row2['sched_dedn_amount'] - $a_p);
							
							if($deferred2 < 0)
							{
								$deferred2 = 0;
							}
							
										
							$end_bal2 = ($row2['beginning_bal'] - $a_p);
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
					
					if ($row2['prod'] != 'Ins' && $row2['prod'] != 'INS' && $row2['prod'] != 'L-FS04'){
						$t_end_bal2 += $end_bal2;
					}else{
						
						if($row2['prod'] == 'INS' OR $row2['prod'] == 'Ins'){
							$t_end_bal2x += $row2['deferred_amount'];
						}
						else{
							$t_end_bal2x += $end_bal2;
						}
					}
						
					#$principal = get_principal($row2['prod'],$end_bal2);	
					#$sub_total += $principal;
						
					if ($row2['prod'] == 'L-FS04')	
					{	
						$semi2 = number_format($row2['semi_monthly_amort'],2,".",",");	
						$t_semi2 -= $row2['semi_monthly_amort'];
					}
					#$t_principal += $principal;	
					
					if ($row2['prod'] == 'L-DS01' || $row2['prod'] == 'L-DS02' || $row2['prod'] == 'L-QTN')
					{
						$q1 = "SELECT item_short_desc, B.item_code 
								FROM p_items A
								INNER JOIN (SELECT item_code FROM p_sales_details WHERE sales_id = {$row2['sales_id']}) B on A.item_code = B.item_code
								WHERE A.item_code = B.item_code";
						$r1 = mysql_query($q1) or die (mysql_error() . "Error in Query : ".$q1);
						$rw1 = mysql_fetch_array($r1, MYSQL_ASSOC);
						
						$prod_desc = $rw1['item_short_desc'];
						
						
						if(empty($prod_desc)){
							$q2 = "SELECT *
								FROM p_sales_details
								WHERE sales_id = {$row2['sales_id']}";
							$r2 = mysql_query($q2) or die (mysql_error() . "Error in Query : ".$q2);
							$rw2 = mysql_fetch_array($r2, MYSQL_ASSOC);
							$prod_desc = $rw2['i_desc'];
						}
						
						if ($prod_desc == ''){
							$prod_desc = $row2['Prod_Name'];
						}
					}
					else $prod_desc = $row2['Prod_Name'];
					
					if ($row2['prod'] == 'L-FS04' )
					{
						echo "
							<tr class=\"normal\">
								<td title='{$row2['trans_type_ldesc']}' class = 'td'>{$row2['trans_type_sdesc']}</td>
									<td class = 'td'>{$row2['this_po_number']}</td>";?>
									
								<td class = 'td'><a title="View loan details" href="<?=site_url("account/view_header/{$row2['dr_number']}")?>?TB_iframe=true&height=300&width=400" class="thickbox"><?=$row2['dr_number']?></a><?#=$row2['dr_number']?>
								
								
					<?	echo "			<td class = 'td'>".date("m/d/Y",strtotime($row2['end_dt']))."</td>
								<td class = 'td' align=\"right\"><span style=\"color: red; font-size: 10px; font-weight: 700;\">$sched_dedn_amt2</span></td>
								<td class = 'td' align=\"right\"><span style=\"color: red; font-size: 10px; font-weight: 700;\">".number_format($a_p,2,".",",")."</span></td>
								<td class = 'td' align=\"right\"><span style=\"color: red; font-size: 10px; font-weight: 700;\">$deferred2</span></td>
								<td class = 'td' align=\"right\"><span style=\"color: red; font-size: 10px; font-weight: 700;\">$semi2</span></td>
								<td class = 'td' align=\"right\"><span style=\"color: red; font-size: 10px; font-weight: 700;\">".number_format($end_bal2,2,".",",")."</span></td>
								<td class = 'td'>{$prod_desc}</td>
							</tr>
						";
					}
					elseif($row2['prod'] == 'L-FS03')
					{
						echo "
							<tr class=\"normal\">
								<td title='{$row2['trans_type_ldesc']}' class = 'td'>{$row2['trans_type_sdesc']}</td>
									<td class = 'td'>{$row2['this_po_number']}</td>";?>
								
								
								<td class = 'td'><a title="View loan details" href="<?=site_url("account/view_header/{$row2['dr_number']}")?>?TB_iframe=true&height=300&width=400" class="thickbox"><?=$row2['dr_number']?></a><?#=$row2['dr_number']?>
								
								
					<?	echo "			<td class = 'td'>".date("m/d/Y",strtotime($row2['end_dt']))."</td>
							    <td class = 'td' align=\"right\"><span style=\"color: red; font-size: 10px; font-weight: 700;\">$sched_dedn_amt2</span></td>
								<td class = 'td' align=\"right\">".number_format($a_p,2,".",",")."</td>
								<td class = 'td' align=\"right\">$deferred2</td>
								<td class = 'td' align=\"right\">$semi2</td>
								<td class = 'td' align=\"right\">".number_format($end_bal2,2,".",",")."</td>
								<td class = 'td'>{$prod_desc}</td>
							</tr>
						";
					}
					elseif($row2['prod'] == 'INS' || $row2['prod'] == 'Ins')
					{
						echo "
							<tr class=\"normal\">
								<td title='{$row2['trans_type_ldesc']}' class = 'td'>{$row2['trans_type_sdesc']}</td>
									<td class = 'td'>{$row2['this_po_number']}</td>";?>
								
								
								<td class = 'td'><a title="View loan details" href="<?=site_url("account/view_header/{$row2['dr_number']}")?>?TB_iframe=true&height=300&width=400" class="thickbox"><?=$row2['dr_number']?></a><?=$row2['dr_number']?>
								
					<?	echo "		
								<td class = 'td'>".date("m/d/Y",strtotime($row2['end_dt']))."</td>
								<td class = 'td' align=\"right\">$sched_dedn_amt2</td>
								<td class = 'td' align=\"right\">".number_format($a_p,2,".",",")."</td>
								<td class = 'td' align=\"right\">$deferred2</td>
								<td class = 'td' align=\"right\">$semi2</td>
								<td class = 'td' align=\"right\"><span style=\"color: red; font-size: 10px; font-weight: 700;\">".number_format(0,2,".",",")."</span></td>
								<td class = 'td'>{$prod_desc}</td>
							</tr>
						";
					}
					else
					{
						echo "
							<tr class=\"normal\">
								<td title='{$row2['trans_type_ldesc']}' class = 'td'>{$row2['trans_type_sdesc']}</td>
								<td class = 'td'>{$row2['this_po_number']}</td>";?>
								
								
								<td class = 'td'><a title="View loan details" href="<?=site_url("account/view_header/{$row2['dr_number']}")?>?TB_iframe=true&height=300&width=400" class="thickbox"><?=$row2['dr_number']?></a><?#=$row2['dr_number']?>


				
					<?	echo "
								<td class = 'td'>".date("m/d/Y",strtotime($row2['end_dt']))."</td>
								<td class = 'td' align=\"right\">$sched_dedn_amt2</td>
								<td class = 'td' align=\"right\">".number_format($a_p,2,".",",")."</td>
								<td class = 'td' align=\"right\">$deferred2</td>
								<td class = 'td' align=\"right\">$semi2</td>
								<td class = 'td' align=\"right\">".number_format($end_bal2,2,".",",")."</td>
								<td class = 'td'>{$prod_desc}</td>
							</tr>
						";
					}
					$x++;
				}
					
				
				# Added By Majo : 2009-03-06 : Conso Loans
				$query4 = "SELECT *, C.interest as intrst, A.po_number as this_po_number , po_start_date, pay_period, beginning_bal, C.commission, dr_number,trans_type_sdesc,trans_type_ldesc
							FROM ar_member_subs_detail A 
								LEFT JOIN p_sales_details E on A.po_number = E.item_code
								LEFT JOIN p_sales_header C on E.sales_id = C.sales_id
								LEFT JOIN m_loan_products D on C.prod_id = D.prod_id
								LEFT JOIN m_transaction_types F on A.trans_type = F.trans_id
							WHERE A.member_id = $member_id AND A.pay_period = '$lastBilling' AND C.prod_id = 'L-FS09' 
								AND ((A.po_number LIKE '%-T' OR A.po_number LIKE '%-P' OR A.po_number LIKE '%-T2') OR dr_number LIKE 'CLF_%' AND dr_number NOT LIKE 'CLF-2%')   AND po_status != 5";
					
				//$query2 .= " AND A.trans_type in (select distinct(trans_id) from ar_member_subs where member_id = $member_id)AND A.pay_period = (SELECT MAX(pay_period) FROM ar_member_subs_detail WHERE member_id = $member_id AND pay_period <= '$today2' GROUP BY member_id LIMIT 1)";
				//$query2 .=" ORDER BY 	A.trans_type";
				$result4 = mysql_query($query4) or die (mysql_error().$query4);
				
				$x = 0;
				$advance = 0;
				while($row4 = mysql_fetch_array($result4, MYSQL_ASSOC))
				{
					$chkOR_contrib = "SELECT sum(amt) as or_amount, pay_period1, pay_period2 FROM or_header A 
									INNER JOIN or_details B on A.or_id = B.or_id
								WHERE po_num = '{$row4['this_po_number']}' AND or_date > '$lastBilling' AND or_date <= '$nxtBilling'
									AND member_id = $member_id
									AND A.posted_status = 1
								GROUP BY po_num";
					$resultOR_contrib = mysql_query($chkOR_contrib) or die (mysql_error() . "Error in Query : ". $chkOR_contrib);
					$rowOR = mysql_fetch_array($resultOR_contrib, MYSQL_ASSOC);
					$or_contrib = is_null($rowOR['or_amount']) ? 0 : $rowOR['or_amount'];
					
					$queryZ = "SELECT SUM(actual_payment) AS t_ap FROM ar_member_subs_detail 
								WHERE po_number = '{$row4['this_po_number']}' && pay_period > '$lastBilling'";
					$resultZ = mysql_query($queryZ);
					$rowZ = mysql_fetch_array($resultZ);
					
					if ($this->input->post('sel_date') == 0)
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
						{
							$a_p = $row4['actual_payment'];# - ($or_contrib - $rowZ['t_ap']);	
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
					
					if(substr($row4['this_po_number'],-1) != 'P' )
					{
						$t_end_bal2 += $end_bal4;
					}
					
					$t_dedn_amt2 += $row4['sched_dedn_amount'];
					
					$t_actual_pay2 += $a_p;
					
					$t_semi2 += $row4['semi_monthly_amort'];
						
					#$principal4 = get_principal('L-FS09',$end_bal4);
					#$sub_total += $principal4;
					
				#	$t_principal += $principal4;
					
					if(substr($row4['this_po_number'],-1) != 'P' )
					{
						echo "
						<tr class=\"normal\">
							<td title='{$row4['trans_type_ldesc']}' class = 'td'>{$row4['trans_type_sdesc']}</td>
							<td class = 'td'>{$row4['this_po_number']}</td>
							<td class = 'td' style=\"cursor:pointer\" onclick=\"view_header('{$row4['dr_number']}')\">{$row4['dr_number']}</td>
							<td class = 'td'>".date("m/d/Y",strtotime($row4['end_dt']))."</td>
							<td class = 'td' align=\"right\">$sched_dedn_amt4</td>
							<td class = 'td' align=\"right\">$actual_pay4</td>
							<td class = 'td' align=\"right\">$deferred4</td>
							<td class = 'td' align=\"right\">$semi4</td>
							<td class = 'td' align=\"right\">".number_format($end_bal4,2,".",",")."</td>
								<td class = 'td'>{$row4['Prod_Name']}</td>
						</tr>
						";
					}
					else
					{
						echo "
						<tr class=\"normal\">
							<td title='{$row4['trans_type_ldesc']}' class = 'td'>{$row4['trans_type_sdesc']}</td>
							<td class = 'td'>{$row4['this_po_number']}</td>
							<td class = 'td' style=\"cursor:pointer\" onclick=\"view_header('{$row4['dr_number']}')\">{$row4['dr_number']}</td>
							<td class = 'td'>".date("m/d/Y",strtotime($row4['end_dt']))."</td>
							<td class = 'td' align=\"right\">$sched_dedn_amt4</td>
							<td class = 'td' align=\"right\">$actual_pay4</td>
							<td class = 'td' align=\"right\">$deferred4</td>
							<td class = 'td' align=\"right\">$semi4</td>
							<td class = 'td' align=\"right\"><span style=\"color: red; font-size: 10px; font-weight: 700;\">".number_format($end_bal4,2,".",",")."</span></td>
							<td class = 'td'>{$row4['Prod_Name']}</td>
						</tr>
						";
					}
					
					$x++;
				}
				
				
				# Added by Majo : include new loans			
				$lastBilling2 = switch_date($lastBilling);
				$end_dt = $this->input->post('sel_date')?$this->input->post('sel_date'):date("Y-m-d");
					
				$query3 = "SELECT *, B.interest as intrst,
									 A.po_number as this_po_number, po_start_date, pay_period, beginning_bal, B.prod_id as prod,trans_type_sdesc,trans_type_ldesc,
									 B.commission as commission, net_proceeds, sales_id
							FROM ar_member_subs_detail A
								LEFT JOIN p_sales_header B ON A.po_number = B.po_number
									AND A.member_id = B.member_id
								LEFT JOIN m_loan_products C ON B.prod_id = C.prod_id	
								LEFT JOIN m_transaction_types D on A.trans_type = D.trans_id						
							WHERE  po_start_date > '$lastBilling' 
							AND C.prod_id != 'L-FS04'
							AND A.member_id = $member_id AND po_status != 5
							GROUP BY A.po_number
							
							UNION ALL
								
							SELECT A.*,C.*,D.*,F.*,C.interest as intrst,
									 A.po_number as this_po_number, po_start_date, pay_period, beginning_bal, C.prod_id as prod,trans_type_sdesc,trans_type_ldesc,
									 C.commission as commission, net_proceeds, C.sales_id
							FROM ar_member_subs_detail A
								LEFT JOIN p_sales_details E on A.po_number = E.item_code
								LEFT JOIN p_sales_header C on E.sales_id = C.sales_id
								LEFT JOIN m_loan_products D on C.prod_id = D.prod_id
								LEFT JOIN m_transaction_types F on A.trans_type = F.trans_id
							WHERE A.member_id = $member_id AND A.start_dt > '$lastBilling' 
							AND C.prod_id = 'L-FS09'
							AND ((A.po_number LIKE '%-T' OR A.po_number LIKE '%-P' OR A.po_number LIKE '%-T2') OR dr_number LIKE 'CLF_%'
							AND dr_number NOT LIKE 'CLF-2%')
							AND po_status != 5
							GROUP BY A.po_number";
									
				$result3 = mysql_query($query3) or die (mysql_error().$query3);	
				
				$printed = true;
				
				
				while($row3 = mysql_fetch_array($result3, MYSQL_ASSOC))
				{
					
					if ($row3['po_date'] <= $lastBilling OR $this->input->post('sel_date') == 0)
					{
						
						if($printed){
							echo "
								<tr>
									<td colspan=\"11\" align=\"left\" ><span style=\" font-weight: 700;\">NEWLY APPLIED LOANS </span></td>
								</tr>
							";	
							$printed = false;
						}
						
						$a_p = 0;
						if ($this->input->post('sel_date') == 0)
						{
							#-------------------------------------------------------------------------------------------------
							$queryZ = "SELECT SUM(actual_payment) AS t_ap FROM ar_member_subs_detail 
										WHERE po_number = '{$row3['this_po_number']}'";
							$resultZ = mysql_query($queryZ);
							$rowZ = mysql_fetch_array($resultZ);
							$advance = $rowZ['t_ap'];
							if($row3['prod'] != 'L-FS04'){
								$a_p = $advance;
							}else{
								$a_p = 0;
							}
							
							#-------------------------------------------------------------------------------------------------
						}
						$sched_dedn_amt3 = number_format(0,2,".",",");
						$actual_pay3 = number_format($a_p,2,".",",");
						$deferred3 = number_format(0,2,".",",");
						$semi3 = number_format($row3['semi_monthly_amort'],2,".",",");				
									
						
						#$t_dedn_amt2 += $row3[''];
						$t_actual_pay2 += $a_p;
						#$t_deferr2 += $row3[''];
						$t_semi2 += $row3['semi_monthly_amort'];
						$end_bal3 = number_format($row3['beginning_bal'] - $a_p,2,".",",");		
						if ($row3['prod'] != 'Ins' && $row3['prod'] != 'INS' && $row3['prod'] != 'L-FS04')	
							$t_end_bal2 += $row3['beginning_bal'] - $a_p;
							
					
						if ($row3['prod'] == 'L-FS04')	
						{	
							$semi3 = number_format($row3[''],2,".",",");	
							$t_semi2 -= $row3['semi_monthly_amort'];
						}	
						
						if ($row3['prod'] == 'L-DS01' || $row3['prod'] == 'S-DS01' || $row3['prod'] == 'S-DS02' || $row3['prod'] == 'L-DS02' || $row3['prod'] == 'L-QTN')
						{
							$q1 = "SELECT item_short_desc, B.item_code 
									FROM p_items A
									INNER JOIN (SELECT item_code FROM p_sales_details WHERE sales_id = {$row3['sales_id']}) B on A.item_code = B.item_code
									WHERE A.item_code = B.item_code";
							$r1 = mysql_query($q1) or die (mysql_error() . "Error in Query : ".$q1);
							$rw1 = mysql_fetch_array($r1, MYSQL_ASSOC);
							
							$prod_desc = $rw1['item_short_desc'];
							
							
							if(empty($prod_desc)){
								$q2 = "SELECT *
									FROM p_sales_details
									WHERE sales_id = {$row3['sales_id']}";
								$r2 = mysql_query($q2) or die (mysql_error() . "Error in Query : ".$q2);
								$rw2 = mysql_fetch_array($r2, MYSQL_ASSOC);
								$prod_desc = $rw2['i_desc'];
							}
							
							if ($prod_desc == ''){
								$prod_desc = $row2['Prod_Name'];
							}
						}
						else $prod_desc = $row3['Prod_Name'];
						
						if ($row3['prod'] != 'Ins' && $row3['prod'] != 'INS' && $row3['prod'] != 'L-FS04' && $row3['prod'] != 'L-FSG')
						{
							echo "
							<tr class=\"normal\">
								<td title='{$row3['trans_type_ldesc']}' class = 'td'>{$row3['trans_type_sdesc']}</td>
									<td class = 'td'>{$row3['this_po_number']}</td>";?>
								
								<td class = 'td'><a title="View loan details" href="<?=site_url("account/view_header/{$row3['dr_number']}")?>?TB_iframe=true&height=300&width=400" class="thickbox"><?=$row3['dr_number']?></a>
								
						<?	echo "
								<td class = 'td'>".date("m/d/Y",strtotime($row3['end_dt']))."</td>
								<td class = 'td' align=\"right\">$sched_dedn_amt3</td>
								<td class = 'td' align=\"right\">$actual_pay3</td>
								<td class = 'td' align=\"right\">$deferred3</td>
								<td class = 'td' align=\"right\">$semi3</td>
								<td class = 'td' align=\"right\">$end_bal3</td>
								<td class = 'td'>{$prod_desc}</td>
							</tr>
							";
						}
						elseif($row3['prod'] == 'L-FSG')
						{
							echo "
							<tr class=\"normal\">
								<td title='{$row3['trans_type_ldesc']}' class = 'td'>{$row3['trans_type_sdesc']}</td>
									<td class = 'td'>{$row3['this_po_number']}</td>";?>
								
								
								<td class = 'td'><a title="View loan details" href="<?=site_url("account/view_header/{$row3['dr_number']}")?>?TB_iframe=true&height=300&width=400" class="thickbox"><?=$row3['dr_number']?></a>
								
								
						<?	echo "
								<td class = 'td'>".date("m/d/Y",strtotime($row3['end_dt']))."</td>
								<td class = 'td' align=\"right\">$sched_dedn_amt3</td>
								<td class = 'td' align=\"right\">$actual_pay3</td>
								<td class = 'td' align=\"right\">$deferred3</td>
								<td class = 'td' align=\"right\">$semi3</td>
								<td class = 'td' align=\"right\">$end_bal3</td>
								<td class = 'td'>{$prod_desc}</td>
							</tr>
							";
						}
						else
						{
							echo "
							<tr class=\"normal\">
								<td title='{$row3['trans_type_ldesc']}' class = 'td'>{$row3['trans_type_sdesc']}</td>
									<td class = 'td'>{$row3['this_po_number']}</td>";?>
								
								<td class = 'td'><a title="View loan details" href="<?=site_url("account/view_header/{$row3['dr_number']}")?>?TB_iframe=true&height=300&width=400" class="thickbox"><?=$row3['dr_number']?></a>
								
						<?	echo "
								<td class = 'td'>".date("m/d/Y",strtotime($row3['end_dt']))."</td>
								<td class = 'td' align=\"right\"><span style=\"color: red; font-size: 10px; font-weight: 700;\">$sched_dedn_amt3</span></td>
								<td class = 'td' align=\"right\">$actual_pay3</td>
								<td class = 'td' align=\"right\">$deferred3</td>
								<td class = 'td' align=\"right\">$semi3</td>
								<td class = 'td' align=\"right\"><span style=\"color: red; font-size: 10px; font-weight: 700;\">$end_bal3</span></td>
								<td class = 'td'>{$prod_desc}</td>
							</tr>
							";	
						}
						
						$x++;
					}
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
								AND po_status != 5
								AND B.Prod_Id NOT IN ('L-FS04')";
								#AND A.post_ar_date IS NOT NULL";
							
					$result3 = mysql_query($query3) or die (mysql_error().$query3);	
					while($row5 = mysql_fetch_array($result3, MYSQL_ASSOC))
					{
						$queryZ = "SELECT amt as t_ap FROM m_fully_paid_deduction
									   WHERE po_number = '{$row5['this_po_number']}'
									   AND pay_period = '$lastBilling'";	
									   			   
						$resultZ = mysql_query($queryZ);
						$rowZ = mysql_fetch_array($resultZ);
					
						$last_cutoff = getLastBilling();
						if ($this->input->post('sel_date') == 0)
						{
							$qr = "SELECT *
									   FROM p_sales_rebate
									   WHERE po_number = '{$row5['this_po_number']}'";
							$rr = mysql_query($qr);
							$rwr = mysql_fetch_array($rr, MYSQL_ASSOC);
							$rbt = is_null($rwr['rebate_40']) ? 0 : $rwr['rebate_40'];
							
							$a_p = 0;
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
							$a_p = 0;
							
							if ($this->input->post('sel_date') == $last_cutoff)
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
									$a_p 	 = $rw['actual_payment'];# + $rowZ['t_ap'];
									$endbal3 = $rw['end_bal'];
									$deff3   = $rw['deferred_amount'];
									$sched3  = $rw['sched_dedn_amount'];
									$t_end_bal2 += $endbal3;
								}
								else
								{
									$endbal3 = $row5['end_bal'];
									$a_p 	 = $row5['actual_payment'];
									$deff3 = $row5['deferred_amount'];
									$sched3 = $row5['sched_dedn_amount'];	
								}
							}
							else 
							{
								$endbal3 = $row5['end_bal'];
								$a_p 	 = $row5['actual_payment'];
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
							
							
						$t_semi2 += $row5['semi_monthly_amort'];
							
							
						# not including INS and MPL in total end balance
						#=================================================================================#
						if ($row5['prod'] != 'Ins' && $row5['prod'] != 'INS' && $row5['prod'] != 'L-FS04')
						{
							$t_end_bal2 += $row5['end_bal'];#($row5['beginning_bal'] - $a_p );
							$t_dedn_amt2 += $sched3;
							$t_deferr2 += $deff3;
							$t_actual_pay2 += $a_p;
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
						
						$sql = "SELECT rebate_40 as rbt
								FROM p_sales_rebate
								WHERE po_number = '{$row5['this_po_number']}'";
								
						$row_sql = mysql_query($sql) or die (mysql_error() . "Error in Query : ". $sql);
						$rbtrow = mysql_fetch_array($row_sql);
						$actual_pay3 = $actual_pay3 <=0 ? number_format(0,2,".",",") : $actual_pay3;
						
						
						if(mysql_num_rows($row_sql) > 0)
						{
							
							echo "
								<tr class=\"normal\">
									<td class = 'td'>{$row5['trans_type_sdesc']}</td>
										<td class = 'td'>{$row5['this_po_number']}</td> ";?>
									
									<td class = 'td'><a title="View loan details" href="<?=site_url("account/view_header/{$row5['dr_number']}")?>?TB_iframe=true&height=300&width=400" class="thickbox"><?=$row5['dr_number']?></a><?#=$row2['dr_number']?>
									
						<?	echo "
									<td class = 'td'>".date("m/d/Y",strtotime($row5['end_dt']))."</td>
									<td class = 'td' align=\"right\">$sched_dedn_amt3</td>
									<td class = 'td' align=\"right\">$actual_pay3</td>
									<td class = 'td' align=\"right\">$deferred3</td>
									<td class = 'td' align=\"right\">$semi3</td>
									<td class = 'td' align=\"right\"><span style=\"color: red; font-size: 10px; font-weight: 700;\">**</span>".number_format($endbal3,2,".",",")."</td>
									<td class = 'td'>{$row5['Prod_Name']}</td>
								</tr>
								";
						}
						else
						{
							echo "
								<tr class=\"normal\">
									<td class = 'td'>{$row5['trans_type_sdesc']}</td>
										<td class = 'td'>{$row5['this_po_number']}</td>";?>
										
									<td class = 'td'><a title="View loan details" href="<?=site_url("account/view_header/{$row5['dr_number']}")?>?TB_iframe=true&height=300&width=400" class="thickbox"><?=$row5['dr_number']?></a><?#=$row2['dr_number']?>
									
						<? 	echo "			<td class = 'td'>".date("m/d/Y",strtotime($row5['end_dt']))."</td>
									<td class = 'td' align=\"right\">$sched_dedn_amt3</td>
									<td class = 'td' align=\"right\">$actual_pay3</td>
									<td class = 'td' align=\"right\">$deferred3</td>
									<td class = 'td' align=\"right\">$semi3</td>
									<td class = 'td' align=\"right\">".number_format($endbal3,2,".",",")."</td>
									<td class = 'td'>{$row5['Prod_Name']}</td>
								</tr>
							";
						}
						
						$x++;
					}	
				}
				
				
				#change jeth jan16, 2012
				$m = date('m',strtotime($lastBilling));
				$y = date('Y',strtotime($lastBilling));
				//-----------------------------------------------------------------------------------------------------------------------------------------------
				$chkOR_full = "SELECT *
							   FROM or_header A
							   LEFT JOIN or_details B ON A.or_id = B.or_id
							   #LEFT JOIN p_sales_header C ON B.po_num = C.po_number
							   WHERE A.member_id = $member_id
							   AND is_fully_paid = 1
							   #AND or_date >= '$lastBilling'
							   AND MONTH(or_date) >= $m
 							   AND YEAR(or_date) = $y
 							   	AND A.posted_status = 1";
							   
				$resultOR_full = mysql_query($chkOR_full) or die (mysql_error() . "Error in Query : ". $chkOR_full);
				
				if(mysql_num_rows($resultOR_full) > 0){
					echo "
						<tr>
							<td colspan=\"11\" align=\"left\" ><span style=\" font-weight: 700;\">FULLY PAID ACCOUNTS VIA OFFICIAL RECEIPTS </span></td>
						</tr>
					";	
				}
						
				while ($row_full = mysql_fetch_array($resultOR_full, MYSQL_ASSOC))
				{
					$header_p = "SELECT * FROM p_sales_header WHERE po_number = '{$row_full['po_num']}'";
					$query_p = mysql_query($header_p);
					$row_p = mysql_fetch_array($query_p);
					
					
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
					
					
					$sr_mora = 0;
					
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
							AND A.pay_period >= '$lastBilling'
							AND po_status != 5
							LIMIT 1";
					}
					
							
					$result3 = mysql_query($query3) or die (mysql_error().$query3);	
					while($row3 = mysql_fetch_array($result3, MYSQL_ASSOC))
					{
						$last_cutoff = getLastBilling();
						
						$qr = "SELECT *
									   FROM p_sales_rebate
									   WHERE po_number = '{$row3['this_po_number']}'";
						$rr = mysql_query($qr);
						$rwr = mysql_fetch_array($rr, MYSQL_ASSOC);
						$rbt = is_null($rwr['rebate_40']) ? 0 : $rwr['rebate_40'];
						
						if ($this->input->post('sel_date') == 0)
						{
							
							$queryY = "SELECT SUM(actual_payment) AS t_ap
								   FROM ar_member_subs_detail_history 
								   WHERE po_number = '{$row3['this_po_number']}'
								   AND pay_period >= '$lastBilling'";
								$resultY = mysql_query($queryY);
								$rowY = mysql_fetch_array($resultY);
								
								$a_py = $rowY['t_ap'];	
									
							
							$a_p = 0;	
							
							#include other payments within pay period to total
							$queryZ = "SELECT SUM(amt) as t_ap FROM or_details
									   LEFT JOIN or_header USING(or_id)
									   WHERE po_num = '{$row3['this_po_number']}'
									   AND pay_period = '$lastBilling'
									   AND posted_status = 1";	
									   			   
							$resultZ = mysql_query($queryZ);
							$rowZ = mysql_fetch_array($resultZ);
							$advance = $rowZ['t_ap'];
							$a_p = $advance;
							$endbal3 = 0;
							$deff3 = 0;
							$sched3 = 0;
							$principal2 = 0;
							
							#$t_end_bal2 -= $rbt;
							
							#$t_end_bal2 -= $row3['actual_payment'];
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
												  AND member_id = $member_id
												  AND A.posted_status = 1
												  GROUP BY po_num";
												  
								$resultOR_contrib = mysql_query($chkOR_contrib) or die (mysql_error() . "Error in Query : ". $chkOR_contrib);
								$rowOR = mysql_fetch_array($resultOR_contrib, MYSQL_ASSOC);
								
								#=====================================================================#
								 $or_contrib = is_null($rowOR['or_amount']) ? 0 : $rowOR['or_amount'];
								#=====================================================================#
								
								#if($row3['prod'] == 'L-FS04'){
									#$or_contrib = 0;
								#}
								
								if ($this->input->post('sel_date') == $last_cutoff)
								{
									$qr = "SELECT *
										   FROM p_sales_rebate
										   WHERE po_number = '{$row3['this_po_number']}'";
									$rr = mysql_query($qr);
									$rwr = mysql_fetch_array($rr, MYSQL_ASSOC);
									
									$queryZ = "SELECT SUM(actual_payment) AS t_ap
											   FROM ar_member_subs_detail_history 
											   WHERE po_number = '{$row3['this_po_number']}'
											   AND pay_period > '$lastBilling'";
											   
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
											#21500.00 - (3113.00 - 21500.00) #0.00 - (3113.00  - 21500.00) 
											
											$a_p 	 = $row3['actual_payment'] - (($or_contrib - $rbt) - ($rowZ['t_ap'] + $rbt));
											
											if($row3['prod'] == 'L-FS04')
											{
												$a_p 	 = $row3['actual_payment']; #- (($or_contrib - $rbt) - ($rowZ['t_ap'] + $rbt));
												
												$deff3   = $row3['deferred_amount'];
											}
											else{
												if($row3['sched_dedn_amount'] < $a_p){
													$deff3   = 0;#$row3['sched_dedn_amount'] - $a_p;
												}else{
													$deff3   = $row3['sched_dedn_amount'] - $a_p;
												}
												
											}
											
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
								/*
								if ($row3['prod'] != 'L-FS03' && $row3['prod'] != 'L-FSVC' && $row3['prod'] != 'Ins' && $row3['prod'] != 'INS' && $row3['prod'] != 'L-FS04')
								{
									$principal2 = $row3['beginning_bal'] - $a_p;
									$sub_total += $principal2;
								}
								else
								{
									$principal2 = 0;
								}	
								
								*/
							
							}
							
							$principal2 = 0;
						}
						
						
						if($sr_mora == 1 AND $this->input->post('sel_date') != 0)
						{
							$a_p = 0;
							$endbal3 = $row3['beginning_bal'];
							$sched_dedn_amt3 = 0;#number_format($sched3,2,".",",");
							$actual_pay3 = 0;#number_format($a_p,2,".",",");
							$deferred3 = 0;#number_format($deff3,2,".",",");
							$semi3 = number_format($row3['semi_monthly_amort'],2,".",",");	
						}
						else
						{
							if($this->input->post('sel_date') == 0)
							{
								$endbal3 = $row3['beginning_bal'] - $a_py;
								
								if($row3['end_bal'] == 0)
								{
									$endbal3 = 0;	
								}
								
								$sched_dedn_amt3 = number_format($sched3,2,".",",");
								$actual_pay3 = number_format($a_p,2,".",",");
								$deferred3 = number_format($deff3,2,".",",");
								$semi3 = number_format($row3['semi_monthly_amort'],2,".",",");		
							}
							else
							{
								$endbal3 = $row3['beginning_bal'] - $a_p;
								$sched_dedn_amt3 = number_format($sched3,2,".",",");
								$actual_pay3 = number_format($a_p,2,".",",");
								$deferred3 = number_format($deff3,2,".",",");
								$semi3 = number_format($row3['semi_monthly_amort'],2,".",",");		
							}
						}
						
								
			
						
						$t_semi2 += $row3['semi_monthly_amort'];
						
						
						/* not including INS and MPL in total end balance*/
						#=================================================================================#
						if ($row3['prod'] != 'Ins' && $row3['prod'] != 'INS' && $row3['prod'] != 'L-FS04')
						{
							$t_actual_pay2 += $a_p;
							$t_end_bal2 += $endbal3;#($row3['beginning_bal'] - $a_p ); 
							$t_dedn_amt2 += $sched3;
							$t_deferr2 += $deff3;
							
						}	
						#==================================================================================#
						#===============================================#
						if ($row3['prod'] == 'L-FS04')	
						{	
							$semi3 = number_format(0,2,".",",");	
							$t_semi2 -= $row3['semi_monthly_amort'];
						}
						#===============================================#
						$t_principal += $principal2;
						
						$sql = "SELECT rebate_40 as rbt
								FROM p_sales_rebate
								WHERE po_number = '{$row3['this_po_number']}'";
								
						$row_sql = mysql_query($sql) or die (mysql_error() . "Error in Query : ". $sql);
						$rbtrow = mysql_fetch_array($row_sql);
						$actual_pay3 = $actual_pay3 <=0 ? number_format(0,2,".",",") : $actual_pay3;
						
						if($endbal3 > 0){
							$endbal3 -= $rbtrow['rbt'];
							$t_end_bal2 -= $rbtrow['rbt'];
						}
						
						if(mysql_num_rows($row_sql) > 0)
						{
							
							echo "
								<tr class=\"normal\">
									<td class = 'td'>{$row3['trans_type_sdesc']}</td>
										<td class = 'td'>{$row3['this_po_number']}</td>";?>
									
									
									<td class = 'td'><a title="View loan details" href="<?=site_url("account/view_header/{$row3['dr_number']}")?>?TB_iframe=true&height=300&width=400" class="thickbox"><?=$row3['dr_number']?></a><?#=$row2['dr_number']?>
									
						<?	echo "		
									<td class = 'td'>".date("m/d/Y",strtotime($row3['end_dt']))."</td>
									<td class = 'td' align=\"right\">$sched_dedn_amt3</td>
									<td class = 'td' align=\"right\">$actual_pay3</td>
									<td class = 'td' align=\"right\">$deferred3</td>
									<td class = 'td' align=\"right\">$semi3</td>
									<td class = 'td' align=\"right\"><span style=\"color: red; font-size: 10px; font-weight: 700;\">**</span>".number_format($endbal3,2,".",",")."</td>
									<td class = 'td'>{$row3['Prod_Name']}</td>
								</tr>
								";
						}
						else
						{
							echo "
								<tr class=\"normal\">
									<td class = 'td'>{$row3['trans_type_sdesc']}</td>
										<td class = 'td'>{$row3['this_po_number']}</td>";?>
									
									
									<td class = 'td'><a title="View loan details" href="<?=site_url("account/view_header/{$row3['dr_number']}")?>?TB_iframe=true&height=300&width=400" class="thickbox"><?=$row3['dr_number']?></a></td>
									
									
						<?	echo "	<td class = 'td'>".date("m/d/Y",strtotime($row3['end_dt']))."</td>
									<td class = 'td' align=\"right\">$sched_dedn_amt3</td>
									<td class = 'td' align=\"right\">$actual_pay3</td>
									<td class = 'td' align=\"right\">$deferred3</td>
									<td class = 'td' align=\"right\">$semi3</td>
									<td class = 'td' align=\"right\">".number_format($endbal3,2,".",",")."</td>
									<td class = 'td'>{$row3['Prod_Name']}</td>
								</tr>
							";
						}
						
						$x++;
					}	
				}
				//-----------------------------------------------------------------------------------------------------------------------------------------------	
				
				
				
				//-----------------------------------------------------------------------------------------------------------------------------------------------
				$chkfull = "SELECT *
							FROM m_fully_paid
							LEFT JOIN p_sales_header USING(po_number)
							WHERE is_fully_paid = 1
							AND Prod_Id NOT IN('L-FS04')
							AND pay_period >= '$lastBilling'
							#AND pay_period <= '$nxtBilling'
							AND  m_fully_paid.member_id = $member_id";
				$chkfull_res = mysql_query($chkfull) or die (mysql_error().$chkfull);
				
				if(mysql_num_rows($chkfull_res) > 0){
					echo "
						<tr>
							<td colspan=\"11\" align=\"left\" ><span style=\" font-weight: 700;\">FULLY PAID ACCOUNTS VIA PAYROLL COLLECTION </span></td>
						</tr>
					";	
				}
				
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
						if ($this->input->post('sel_date') == 0)
						{
							$a_p = 0;
							$endbal3 = 0;
							$deff3 = 0;
							$sched3 = 0;
							$principal2 = 0;
							$semi4 = 0;
							
							if( $row4['prod'] != 'L-FS04')
							$t_end_bal2 -= $row4['actual_payment'];
							
						}
						else
						{
							$endbal3 = $row4['end_bal'];
							$a_p = $row4['actual_payment'];
							$deff3 = $row4['deferred_amount'];
							$sched3 = $row4['sched_dedn_amount'];	
							$semi4 = 0;#$row4['semi'];
							$principal2 = 0;
						}
						
						$end_bal3 = ($row4['beginning_bal'] - $a_p);
						$sched_dedn_amt3 = $sched3;#number_format($sched3,2,".",",");
						$actual_pay3 = $a_p;#number_format($a_p,2,".",",");
						$deferred3 = number_format($deff3,2,".",",");
						$semi3 = number_format($semi4,2,".",",");		
								
						$actual_pay3 = $actual_pay3 <=0 ? number_format(0,2,".",",") : $actual_pay3;
						
						$sched_dedn_amt3 = $sched_dedn_amt3 <=0 ? number_format(0,2,".",",") : $sched_dedn_amt3;
					#jeth 2011-22-06	
					#	$t_semi2 += $row4['semi'];
						
						
						/* not including INS and MPL in total end balance*/
						#=================================================================================#
						if ($row4['prod'] != 'Ins' && $row4['prod'] != 'INS' && $row4['prod'] != 'L-FS04')
						{
							$t_end_bal2 += ($row4['beginning_bal'] - $a_p );
							$t_dedn_amt2 += $sched_dedn_amt3;
							$t_actual_pay2 += $actual_pay3;
							$t_deferr2 += $deff3;
						}	
						#==================================================================================#
						#===============================================#
						if ($row4['prod'] == 'L-FS04')	
						{	
							$semi3 = number_format($row4[''],2,".",",");	
					#jeth 2011-22-06		
					#		$t_semi2 -= $row4['semi'];
						}
						#===============================================#
						$t_principal += $principal2;
						
						if ($row4['prod'] == 'L-FS04'){
							echo "
							<tr class=\"normal\">
								<td class = 'td'>{$row4['trans_type_sdesc']}</td>
									<td class = 'td'>{$row4['this_po_number']}</td>";?>
								
								<td class = 'td'><a title="View loan details" href="<?=site_url("account/view_header/{$row4['dr_number']}")?>?TB_iframe=true&height=300&width=400" class="thickbox"><?#=$row4['dr_number']?></a></td>
								
						<?	echo "
								<td class = 'td'>".date("m/d/Y",strtotime($row4['end_dt']))."</td>
								<td class = 'td' align=\"right\"><span style=\"color: red; font-size: 10px; font-weight: 700;\">$sched_dedn_amt3</span></td>
								<td class = 'td' align=\"right\"><span style=\"color: red; font-size: 10px; font-weight: 700;\">$actual_pay3</span></td>
								<td class = 'td' align=\"right\"><span style=\"color: red; font-size: 10px; font-weight: 700;\">$deferred3</span></td>
								<td class = 'td' align=\"right\"><span style=\"color: red; font-size: 10px; font-weight: 700;\">$semi3</span></td>
								<td class = 'td' align=\"right\"><span style=\"color: red; font-size: 10px; font-weight: 700;\">".number_format($endbal3,2,".",",")."</span></td>
								<td class = 'td'>{$row4['Prod_Name']}</td>
							</tr>";
						}
						else{
							echo "
							<tr class=\"normal\">
								<td class = 'td'>{$row4['trans_type_sdesc']}</td>
									<td class = 'td'>{$row4['this_po_number']}</td>";?>
								
								<td class = 'td'><a title="View loan details" href="<?=site_url("account/view_header/{$row4['dr_number']}")?>?TB_iframe=true&height=300&width=400" class="thickbox"><?=$row4['dr_number']?></a></td>
								
						<?	echo "
								<td class = 'td'>".date("m/d/Y",strtotime($row4['end_dt']))."</td>
								<td class = 'td' align=\"right\">".number_format($sched_dedn_amt3,2)."</td>
								<td class = 'td' align=\"right\">".number_format($actual_pay3,2)."</td>
								<td class = 'td' align=\"right\">$deferred3</td>
								<td class = 'td' align=\"right\">$semi3</td>
								<td class = 'td' align=\"right\">".number_format($endbal3,2,".",",")."</td>
								<td class = 'td'>{$row4['Prod_Name']}</td>
							</tr>
						";
						}
						
						
						$x++;
					}
				}
				//-----------------------------------------------------------------------------------------------------------------------------------------------
				$t_end_bal2x += $t_end_bal2;
				
				
				echo "
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td class = 'totals' align=\"right\">".number_format($t_dedn_amt2,2,".",",")."</td>
							<td class = 'totals' align=\"right\">".number_format($t_actual_pay2,2,".",",")."</td>
							<td class = 'totals' align=\"right\">".number_format($t_deferr2,2,".",",")."</td>
							<td class = 'totals' align=\"right\">".number_format($t_semi2,2,".",",")."</td>
							<td class = 'totals' align=\"right\">".number_format($t_end_bal2,2,".",",")."</td>
							
							<td></td>
						</tr>
					";
				$g_dedn_amt = $t_dedn_amt2 + $t_dedn_amt;
				$g_actual_pay = $t_actual_pay2 + $t_actual_pay;
				$g_deferr = $t_deferr2 + $t_deferr;
				$g_semi = $t_semi2 + $t_semi;
				$g_end_bal = $t_end_bal2 + $t_end_bal;
				echo "
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td class = 'totals' align=\"right\">".number_format($g_dedn_amt,2,".",",")."</td>
							<td class = 'totals' align=\"right\">".number_format($g_actual_pay,2,".",",")."</td>
							<td class = 'totals' align=\"right\">".number_format($g_deferr,2,".",",")."</td>
							<td class = 'totals' align=\"right\">".number_format($g_semi,2,".",",")."</td>
							<td class = 'totals' align=\"right\"></td>
							<td></td>
						</tr>
					";		
			
				
				
			$mpl_last_billing = mpl_last_billing();
			$mpl_last_billing_nxt = get_next_ben_month($mpl_last_billing);
				
			
				
			$t_dedn_amt_mpl=0;
			$t_actual_pay_mpl=0;
			$t_deferr_mpl=0;
			$t_semi_mpl=0;
			$t_end_bal_mpl=0;
				
			#FORWARDING MPL BALANCES  #jeth added: 2011-06-22		
			#--------------------------------------------------#	
			$query_mpl = "SELECT *, C.interest as intrst,
								 A.po_number as this_po_number ,
								 po_start_date,
								 pay_period,
									 beginning_bal, 
								 C.commission,
								 C.prod_id as prod,
								 post_ar_by,
								 trans_type_sdesc,
								 sales_id
						FROM ar_member_subs_detail A 
							LEFT JOIN p_sales_header C on A.po_number = C.po_number
							LEFT JOIN m_loan_products D on C.prod_id = D.prod_id
							LEFT JOIN m_transaction_types E on A.trans_type = E.trans_id
						WHERE A.member_id = {$member_id}
						AND A.pay_period = '$mpl_last_billing'  
						AND C.prod_id = 'L-FS04'
						AND po_status != 5";
		$result_mpl = mysql_query($query_mpl) or die (mysql_error().$query_mpl);				
		
			$chkfull = "SELECT *
						FROM m_fully_paid
						LEFT JOIN p_sales_header USING(po_number)
						WHERE is_fully_paid = 1
						AND pay_period >= '$mpl_last_billing'
						AND m_fully_paid.member_id = {$member_id}
						AND Prod_Id = 'L-FS04'";
		$chkfull_res = mysql_query($chkfull) or die (mysql_error().$chkfull);			
				
		if(mysql_num_rows($result_mpl) > 0 OR mysql_num_rows($chkfull_res) > 0)
		{
			
			
			$x_mpl = 0;
			$advance_mpl = 0;
			while($row_mpl = mysql_fetch_array($result_mpl, MYSQL_ASSOC))
			{	
				#START OF CHECKING
				#$mpl_date = "$year-$prev_month-15"; 
				$sql_mpl2 = "SELECT *
							 FROM ar_member_subs_detail
							 WHERE po_number = '{$row_mpl['this_po_number']}'
							 AND pay_period = '$mpl_last_billing'";
				$result = mysql_query($sql_mpl2) or die(mysql_error().$sql_mpl2);		
					
				if(mysql_num_rows($result) > 0)
				{
					$mpl_name = get_mpl_name($mpl_last_billing);
						
					$chkOR_contrib_mpl = "SELECT sum(amt) as or_amount, pay_period1, pay_period2
										  FROM or_header A 
										  INNER JOIN or_details B on A.or_id = B.or_id
									      WHERE po_num = '{$row_mpl['this_po_number']}'
										  AND or_date > '$mpl_last_billing' 
							    		  AND or_date <= '$mpl_last_billing_nxt'
										  AND member_id = {$member_id}
										  GROUP BY po_num";
					$resultOR_contrib_mpl = mysql_query($chkOR_contrib_mpl) or die (mysql_error() . "Error in Query : ". $chkOR_contrib_mpl);
					$rowOR_mpl = mysql_fetch_array($resultOR_contrib_mpl, MYSQL_ASSOC);
					
					#=====================================================================#
					$or_contrib_mpl = is_null($rowOR_mpl['or_amount']) ? 0 : $rowOR_mpl['or_amount'];
					#=====================================================================#
					
					
					$queryZ_mpl = "SELECT SUM(actual_payment) AS t_ap
							   FROM ar_member_subs_detail 
							   WHERE po_number = '{$row_mpl['this_po_number']}'
							   AND pay_period > '$mpl_last_billing'";
					$resultZ_mpl = mysql_query($queryZ_mpl);
					$rowZ_mpl = mysql_fetch_array($resultZ_mpl);
					
						
						#if (!is_null($rowOR_mpl['or_amount']))
						#{	
							/*					
							$a_p_mpl = $row_mpl['actual_payment'] - ($or_contrib_mpl - $rowZ_mpl['t_ap']);										
							$deferred_mpl = ($row2['sched_dedn_amount'] - $a_p);			
							#$end_bal2 = $row2['Prod_Id'] == 'L-FS03' ? $row2['end_bal'] : ($row2['beginning_bal'] - $a_p);		
							$end_bal_mpl = ($row2['beginning_bal'] - $a_p);
							if ( $row_mpl['prod'] != 'L-FS04'){
								$t_deferr2 += $deferred_mpl;
							}
							
							$deferred_mpl = number_format($deferred_mpl,2,".",",");
							*/
						#}
						#else 
						##{
							$end_bal_mpl  = $row_mpl['end_bal'];
							$a_p_mpl	   = $row_mpl['actual_payment'];
							$deferred_mpl = number_format($row_mpl['deferred_amount'],2,".",",");
							if ( $row_mpl['prod'] != 'L-FS04'){
								$t_deferr2 += $row_mpl['deferred_amount'];
							}
							
						#}				
					
					$sched_dedn_amt_mpl = number_format($row_mpl['sched_dedn_amount'],2,".",",");				
					$semi_mpl = number_format($row_mpl['semi_monthly_amort'],2,".",",");
					
					
					
					
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
					
					
					$semi2 = number_format($row2['semi_monthly_amort'],2,".",",");	
					$t_semi2 -= $row2['semi_monthly_amort'];
					
					$t_principal += $principal;	
					
					$prod_desc = $row_mpl['Prod_Name'];
					
					if ($row_mpl['prod'] == 'L-FS04' )
					{
						echo "
							<tr class=\"normal\">
								<td class = 'td'>{$row_mpl['trans_type_sdesc']}</td>
									<td class = 'td'>{$row_mpl['this_po_number']}</td>";?>
								
								<td class = 'td'><a title="View loan details" href="<?=site_url("account/view_header/{$row_mpl['dr_number']}")?>?TB_iframe=true&height=300&width=400" class="thickbox"><?=$row_mpl['dr_number']?></a></td>
								
					<?	echo "		<td class = 'td'>".date("m/d/Y",strtotime($row_mpl['end_dt']))."</td>
								<td class = 'td' align=\"right\">$sched_dedn_amt_mpl</td>
								<td class = 'td' align=\"right\">".number_format($a_p_mpl,2,".",",")."</td>
								<td class = 'td' align=\"right\">$deferred_mpl</span></td>
								<td class = 'td' align=\"right\">$semi_mpl</span></td>
								<td class = 'td' align=\"right\">".number_format($end_bal_mpl,2,".",",")."</td>
									<td class = 'td'>{$prod_desc}$mpl_name</td>
							</tr>
						";
					}
					
					$t_dedn_amt_mpl+=$row_mpl['sched_dedn_amount'];
					$t_actual_pay_mpl+=$row_mpl['actual_payment'];
					$t_deferr_mpl+=$row_mpl['deferred_amount'];
					$t_semi_mpl+= $row_mpl['semi_monthly_amort'];
					$t_end_bal_mpl+=$row_mpl['end_bal'];
					
					$x_mpl++;
					
					$x++;
				}	
			}
			#--------------------------------------------------#	
			
			//-----------------------------------------------------------------------------------------------------------------------------------------------
			
			
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
						AND A.pay_period = '{$row_fulls['pay_period']}'
						AND B.Prod_Id IN ('L-FS04')
						AND po_status != 5
						";
						
				$result4 = mysql_query($query4) or die (mysql_error().$query3);	
				while($row4 = mysql_fetch_array($result4, MYSQL_ASSOC))
				{
					$mpl_name = get_mpl_name($row4['pay_period']);
					
						$endbal3 = $row4['end_bal'];
						$a_p = $row4['actual_payment'];
						$deff3 = $row4['deferred_amount'];
						$sched3 = $row4['sched_dedn_amount'];	
						$principal2 = 0;
						$semi4 = 0;#$row4['semi'];
					
					$end_bal3 = ($row4['beginning_bal'] - $a_p);
					$sched_dedn_amt3 = $sched3;#number_format($sched3,2,".",",");
					$actual_pay3 = $a_p;#number_format($a_p,2,".",",");
					$deferred3 = $deff3;#number_format($deff3,2,".",",");
					$semi3 = $semi4;#number_format($semi4,2,".",",");		
							
					$actual_pay3 = $actual_pay3 <=0 ? number_format(0,2,".",",") : $actual_pay3;
					
					$sched_dedn_amt3 = $sched_dedn_amt3 <=0 ? number_format(0,2,".",",") : $sched_dedn_amt3;
				#jeth 2011-22-06	
				#	$t_semi2 += $row4['semi'];
					
					
					/* not including INS and MPL in total end balance*/
					#=================================================================================#
					if ($row4['prod'] != 'Ins' && $row4['prod'] != 'INS' && $row4['prod'] != 'L-FS04')
					{
						$t_end_bal2 += ($row4['beginning_bal'] - $a_p );
						$t_dedn_amt2 += $sched_dedn_amt3;
						$t_actual_pay2 += $actual_pay3;
						$t_deferr2 += $deff3;
					}	
					#==================================================================================#
					#===============================================#
					
					#===============================================#
					#$t_principal += $principal2;
					
					if ($row4['prod'] == 'L-FS04'){
						echo "
						<tr class=\"normal\">
							<td class = 'td'>{$row4['trans_type_sdesc']}</td>
								<td class = 'td'>{$row4['this_po_number']}</td>";?>
							
							<td class = 'td'><a title="View loan details" href="<?=site_url("account/view_header/{$row4['dr_number']}")?>?TB_iframe=true&height=300&width=400" class="thickbox"><?=$row4['dr_number']?></a></td>
							
					<?	echo "
							<td class = 'td'>".date("m/d/Y",strtotime($row4['end_dt']))."</td>
							<td class = 'td' align=\"right\">".number_format($sched_dedn_amt3,2)."</td>
							<td class = 'td' align=\"right\">".number_format($actual_pay3,2)."</td>
							<td class = 'td' align=\"right\">".number_format($deferred3,2)."</td>
							<td class = 'td' align=\"right\">".number_format($semi3,2)."</td>
							<td class = 'td' align=\"right\">".number_format($endbal3,2,".",",")."</td>
							<td class = 'td'>{$row4['Prod_Name']}$mpl_name</td>
						</tr>";
					}
					
					$t_dedn_amt_mpl+=$row4['sched_dedn_amount'];
					$t_actual_pay_mpl+=$row4['actual_payment'];
					$t_deferr_mpl+=$row4['deferred_amount'];
					#$t_semi_mpl+= $row4['semi_monthly_amort'];
					$t_end_bal_mpl+=$row4['end_bal'];
					
					$x++;
				}
			}
				
			echo "
					<tr>
						<td colspan=4><span style=\" font-weight: 700;\"><strong>MPL Accounts (Last Collection)</strong></span></td>
						<td class = 'totals' align=\"right\">".number_format($t_dedn_amt_mpl,2,".",",")."</td>
						<td class = 'totals' align=\"right\">".number_format($t_actual_pay_mpl,2,".",",")."</td>
						<td class = 'totals' align=\"right\">".number_format($t_deferr_mpl,2,".",",")."</td>
						<td class = 'totals' align=\"right\">".number_format($t_semi_mpl,2,".",",")."</td>
						<td class = 'totals' align=\"right\">".number_format($t_end_bal_mpl,2,".",",")."</td>
						<td></td>
					</tr>
				";
				
		}	
				
			$t_dedn_amt_mpl2=0;
			$t_actual_pay_mpl2=0;
			$t_deferr_mpl2=0;
			$t_semi_mpl2= 0;
			$t_end_bal_mpl2=0;
				
			#FORWARDING MPL BALANCES  #jeth added: 2011-06-22		
			#--------------------------------------------------#	
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
				  #jethro oct 29 2013
				  GROUP BY A.po_number
				  #ORDER BY pay_period DESC,po_start_date DESC";		
				  
			$result_mpl = mysql_query($query_mpl) or die (mysql_error().$query_mpl);
			
			$x_mpl = 0;
			$advance_mpl = 0;
			
		if(mysql_num_rows($result_mpl) > 0)	
		{
			
			
			
			while($row_mpl = mysql_fetch_array($result_mpl, MYSQL_ASSOC))
			{	
				#START OF CHECKING
				#$mpl_date = "$year-$prev_month-15"; 
				
				$mpl_name = get_mpl_name($row_mpl['pay_period']);
				
				$sql_mpl2 = "SELECT *
							 FROM ar_member_subs_detail
							 WHERE po_number = '{$row_mpl['this_po_number']}'
							  AND pay_period = '{$row_mpl['pay_period']}'";
				$result = mysql_query($sql_mpl2) or die(mysql_error().$sql_mpl2);		
					
				if(mysql_num_rows($result) > 0)
				{
					$chkOR_contrib_mpl = "SELECT sum(amt) as or_amount, pay_period1, pay_period2
									  FROM or_header A 
									  INNER JOIN or_details B on A.or_id = B.or_id
								      WHERE po_num = '{$row_mpl['this_po_number']}'
									   AND or_date > '$mpl_last_billing' 
						      			AND or_date <= '$mpl_last_billing_nxt'
									  AND member_id = {$member_id}
									  GROUP BY po_num";
					$resultOR_contrib_mpl = mysql_query($chkOR_contrib_mpl) or die (mysql_error() . "Error in Query : ". $chkOR_contrib_mpl);
					$rowOR_mpl = mysql_fetch_array($resultOR_contrib_mpl, MYSQL_ASSOC);
					
					#=====================================================================#
					$or_contrib_mpl = is_null($rowOR_mpl['or_amount']) ? 0 : $rowOR_mpl['or_amount'];
					#=====================================================================#
					
					
					$queryZ_mpl = "SELECT SUM(actual_payment) AS t_ap
							   FROM ar_member_subs_detail 
							   WHERE po_number = '{$row_mpl['this_po_number']}'
							   AND pay_period > '$mpl_last_billing'";
					$resultZ_mpl = mysql_query($queryZ_mpl);
					$rowZ_mpl = mysql_fetch_array($resultZ_mpl);
					/*
					if ($this->input->post('sel_date') == 0)
					{
						#advance payments						
						$end_bal_mpl = $row_mpl['end_bal'] - $rowZ_mpl['t_ap'];
						$a_p_mpl = $or_contrib_mpl;
						$deferred_mpl = number_format($row_mpl['deferred_amount'],2,".",",");
						$t_deferr2 += $row_mpl['deferred_amount'];
					}
					else
					{
						
						
						if (!is_null($rowOR_mpl['or_amount']))
						{						
							$a_p_mpl = $row_mpl['actual_payment'] - ($or_contrib_mpl - $rowZ_mpl['t_ap']);										
							$deferred_mpl = ($row2['sched_dedn_amount'] - $a_p);			
							#$end_bal2 = $row2['Prod_Id'] == 'L-FS03' ? $row2['end_bal'] : ($row2['beginning_bal'] - $a_p);		
							$end_bal_mpl = ($row2['beginning_bal'] - $a_p);
							if ( $row_mpl['prod'] != 'L-FS04'){
								$t_deferr2 += $deferred_mpl;
							}
							
							$deferred_mpl = number_format($deferred_mpl,2,".",",");
						}
						else 
						{
							*/
							$end_bal_mpl  = $row_mpl['end_bal'];
							$a_p_mpl	   = $row_mpl['actual_payment'];
							$deferred_mpl = number_format($row_mpl['deferred_amount'],2,".",",");
							if ( $row_mpl['prod'] != 'L-FS04'){
								$t_deferr2 += $row_mpl['deferred_amount'];
							}
							
						#}				
				#	}
					
					$sched_dedn_amt_mpl = number_format($row_mpl['sched_dedn_amount'],2,".",",");				
					$semi_mpl = number_format($row_mpl['semi_monthly_amort'],2,".",",");
					
					if ( $row_mpl['prod'] != 'L-FS04' && $row_mpl['prod'] != 'L-FS03')
					{
						$t_semi2 += $row_mpl['semi_monthly_amort'];
						$t_dedn_amt2 += $row_mpl['sched_dedn_amount'];
					}
					
					$t_actual_pay2 += $a_p_mpl;
								
					
					
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
					
					if ($row2['prod'] == 'L-FS04')	
					{	
						$semi2 = number_format($row2['semi_monthly_amort'],2,".",",");	
						$t_semi2 -= $row2['semi_monthly_amort'];
					}
					$t_principal += $principal;	
					
					$prod_desc = $row_mpl['Prod_Name'];
					
					if ($row_mpl['prod'] == 'L-FS04' )
					{
						echo "
							<tr class=\"normal\">
								<td class = 'td'>{$row_mpl['trans_type_sdesc']}</td>
								<td class = 'td'>{$row_mpl['this_po_number']}</td>";?>
								
								<td class = 'td'><a title="View loan details" href="<?=site_url("account/view_header/{$row_mpl['dr_number']}")?>?TB_iframe=true&height=300&width=400" class="thickbox"><?=$row_mpl['dr_number']?></a></td>
								
					<?	echo "
								<td class = 'td'>".date("m/d/Y",strtotime($row_mpl['end_dt']))."</td>
								<td class = 'td' align=\"right\">$sched_dedn_amt_mpl</td>
								<td class = 'td' align=\"right\">".number_format($a_p_mpl,2,".",",")."</td>
								<td class = 'td' align=\"right\">$deferred_mpl</span></td>
								<td class = 'td' align=\"right\">$semi_mpl</span></td>
								<td class = 'td' align=\"right\">".number_format($end_bal_mpl,2,".",",")."</td>
								<td class = 'td'>{$prod_desc}$mpl_name</td>
							</tr>
						";
					}
					
					$t_dedn_amt_mpl2+=$row_mpl['sched_dedn_amount'];
					$t_actual_pay_mpl2+=$row_mpl['actual_payment'];
					$t_deferr_mpl2+=$row_mpl['deferred_amount'];
					$t_semi_mpl2+= $row_mpl['semi_monthly_amort'];
					$t_end_bal_mpl2+=$row_mpl['end_bal'];
					
					$x_mpl++;
					
					$x++;
				}	
			}
			#--------------------------------------------------#	
			
			
			$t_end_bal2x += $t_end_bal_mpl2;
			
			echo "
					<tr>
						
						<td colspan=4><span style=\" font-weight: 700;\"><strong>MPL Accounts (Total Availment)</strong></span></td>
						<td class = 'totals' align=\"right\">".number_format($t_dedn_amt_mpl2,2,".",",")."</td>
						<td class = 'totals' align=\"right\">".number_format($t_actual_pay_mpl2,2,".",",")."</td>
						<td class = 'totals' align=\"right\">".number_format($t_deferr_mpl2,2,".",",")."</td>
						<td class = 'totals' align=\"right\">".number_format($t_semi_mpl2,2,".",",")."</td>
						<td class = 'totals' align=\"right\">".number_format($t_end_bal_mpl2,2,".",",")."</td>
						<td></td>
					</tr>
				";	
				
				
		}	
		
		
		?>
		</table>
	    
		</form>
		
			
		<br>
	
		
		<?php
		}
		?>
	