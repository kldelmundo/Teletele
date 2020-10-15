<html>
<body>

<form action="<?=site_url($this->uri->uri_string())?>" method="POST">
	


<link rel='stylesheet' href='<?=CSS_PATH?>thickbox.css' type='text/css' charset='utf-8' />

<script type="text/JavaScript" src="<?=JS_PATH?>jquery.js"></script>
<script type="text/JavaScript" src="<?=JS_PATH?>thickbox.js"></script>
	
	
	<link rel='stylesheet' href='<?=CSS_PATH?>bootstrap.min.css' type='text/css' charset='utf-8' />
	<link rel='stylesheet' href='<?=CSS_PATH?>ace.min.css' type='text/css' charset='utf-8' />
	
	
	<? $user_level = 0;	?>
	
	<div id="view_loan_details" class="hide fade in">
	</div> 
	
	<div id="view_contrib_details" class="hide">
	</div> 
	<? $_POST['member_id'] = $member_id; ?>
	
	<? if(isset($_POST['member_id'])): ?>
	
	<? $mem_info = $this->m_members->get_members_info($_POST['member_id'])?>
	
	
	<?endif?>
	
	
	<div style="margin-top:10px;font-family:tahoma">
	
	<?
	if(!isset($_POST['pay_period']))
	{
		$_POST['pay_period'] = get_last_billing();
	} 
	
	
	#get_next_billing($_POST['pay_period']);
	?>
		
		&nbsp;&nbsp;&nbsp;
		<strong class="green">Select Pay Period:</strong> <select name="pay_period" id="pay_period" onchange="$('#trans_date').val(0); submit();">
				<?
				
				$queryA = " SELECT distinct(pay_period)
							FROM ar_loans_subs_detail
							WHERE member_id = '{$_POST['member_id']}' 
							AND pay_period < NOW()
							ORDER BY `pay_period`  DESC
							LIMIT 8";
				$resultA = mysql_query($queryA);
				
				while($rowA = mysql_fetch_array($resultA))
				{
					if(!isset($_POST['pay_period']))
					{
						$_POST['pay_period'] = $rowA['pay_period']; 
					} 
					
					if($_POST['pay_period'] == $rowA['pay_period'])
						echo '2<option value="'.$rowA['pay_period'].'" selected="selected">'.date("M. d, Y",strtotime($rowA['pay_period'])).'</option>';	
					else
						echo '1<option value="'.$rowA['pay_period'].'">'.date("M. d, Y",strtotime($rowA['pay_period'])).'</option>';	
				}
				?>
			</select>
		
		&nbsp;&nbsp;&nbsp;
		
		<?
		
			$queryA = " SELECT distinct(DATE(trans_date)) as trans_date
						FROM ar_loans_subs_detail
						WHERE member_id = '{$_POST['member_id']}'
						AND pay_period = '{$_POST['pay_period']}'
						AND trans_date IS NOT NULL
						ORDER BY `trans_date`  DESC
						LIMIT 48";
						#echo $queryA;
			$resultA = $this->tbms_db->query($queryA);
		
			if(!isset($_POST['trans_date']) OR $resultA->num_rows() == 0)
			{
				$_POST['trans_date'] = 0; 
			} 
		?>
		
		<?if($resultA->num_rows() > 0):?>
				
		<strong class="blue">Transaction (As of):</strong>
		<select name="trans_date" id="trans_date" onchange="submit();">
		<option value="0">Select Date</option>
			
		
			<?
			foreach($resultA->result_array() as $rowA)
			{
				
				
				if($_POST['trans_date'] == $rowA['trans_date'])
					echo '<option value="'.$rowA['trans_date'].'" selected="selected">'.date("M. d, Y",strtotime($rowA['trans_date'])).'</option>';	
				else
					echo '<option value="'.$rowA['trans_date'].'">'.date("M. d, Y",strtotime($rowA['trans_date'])).'</option>';	
			}
			?>
		</select>	
		
		<?endif;?>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a target="_blank" href='<?=site_url("account/print_pdf/$member_id/{$_POST['pay_period']}/{$_POST['trans_date']}")?>' class="btn btn-xs btn-purple">
		Print PDF
	</a>
	
	<!--a href='<?=site_url("TBMS/Members/Subsidiary_Ledger/download_xls_sl/$member_id/{$_POST['pay_period']}/{$_POST['trans_date']}")?>' class="btn btn-xs btn-success">
		<i class="icon-save align-bottom bigger-125"></i>
		Print XLS
	</a>
	
	<a href='<?=site_url("TBMS/Members/Subsidiary_Ledger/download_checklist_xls_sl/{$_POST['pay_period']}/{$_POST['trans_date']}/$member_id")?>' class="btn btn-xs btn-info">
		<i class="icon-save align-bottom bigger-125"></i>
		Checklist XLS
	</a-->
	
	
</div>

<?$stg = $this->tbms_db->get('stg_general_settings')->row();?>

<br>
<table cellspacing="10" id="table_ledger" border=1 style="margin-left:5px;width:70%;background:white;margin-top:-10px;font-size:11px; font-family:tahoma; " class="table table-bordered table-condensed table-hover no-footer">
	<thead style="font-size:11px">
		<tr style="font-weight:bold;">
			<td align=center>TYPE</td>
			<td style="width:200px" align=center>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PO&nbsp;NUMBER&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
			<td align=center>PO&nbsp;DOC&nbsp;#</td>
			<td align=center>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;START&nbsp;/&nbsp;END&nbsp;DATE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
			<!--td align=center class="pink">BILLING</td-->
			<td align=center class="orange">SCHED&nbsp;DEDN</td>
			<td align=center class="blue">PAYMENT</td>
			<td align=center class="danger red">DEFERRED</td>
			<td align=center class="gray" >SEMI AMOR</td>
			<td align=center class="success green">BALANCE</td>
			<td style="width:300px">DESCRIPTION</td>
		</tr>
	</thead>
	<tbody>
		
		<? #CONTRIBUTIONS ACCOUNTS: LEDGER ?>
		<?
		$scs_limit = $stg->scs_limit;	
		$t_billing = 0;
		$t_sched = 0;
		$t_payment = 0;
		$t_deferred = 0;
		$t_semi = 0;
		$t_end_bal = 0;
		$curr_bal = 0;	
		
		$fp_bal = 0;
		$rbp_def = 0;
		$tbp_def = 0;
		
		?>
		
		<?$contrib = $this->m_members->get_contrib_sl( $member_id, $_POST['pay_period'], $_POST['trans_date']);?>
		
		<?foreach($contrib as $row):?>
			
			<tr style="font-weight:bold">
				<td align=center><strong><?=$row['type']?></strong></td>
				<td colspan=3 align=right><em><?=$row['desc']?></em><? if($row['trans_type'] == 'NEW'): ?><small><span class="badge badge-sm badge-success badge-left">New</span></small> <?endif?>  </td>
				<!--td align="right"><?=number_format($row['billing'],2)?></td-->
				<td align="right"><?=number_format($row['sched'],2)?></td>
				<td align="right"><?=green_integer($row['actual'])?></td>
				<td align="right"><?=number_format($row['deferred'],2)?></td>
				<td align="right"><?=number_format($row['semi'],2)?></td>
				<td align="right"><?=number_format($row['end_bal'],2)?></td>
				<td><em><?=$row['type']?></em></td>
			</tr>
		<?
		$t_billing  += $row['billing'];		
		$t_sched    += $row['sched'];
		$t_payment  += $row['actual'];
		$t_deferred += $row['deferred'];
		$t_semi 	+= $row['semi'];
		$t_end_bal  += $row['end_bal'];
			
		if($row['type'] == 'FP'){
			$fp_bal  += $row['end_bal'];
		}
			
		if($row['type'] == 'TBP'){
			$tbp_def  += $row['deferred'];
		}
			
		if($row['type'] == 'RBP'){
			$rbp_def  += $row['deferred'];
		}
				
		?>	
		
		
		<?endforeach?>
		
		<?$contrib_scs = $this->m_members->get_contrib_scs_sl( $member_id, $_POST['pay_period'], $_POST['trans_date']);?>
		
		<?foreach($contrib_scs as $row):?>
			
				<tr style="font-weight:bold">
					<td align=center><strong><?=$row['type']?></strong> </td>
					<td colspan=3 align=right><em><?=$row['desc']?></em> <? if($row['trans_type'] == 'NEW'): ?> <small> <span class="badge badge-sm badge-success badge-left">New</span></small> <?endif?></td>	
					<!--td align="right"><?=number_format($row['billing'],2)?></td-->
					<td align="right"><?=number_format($row['sched'],2)?></td>
					<td align="right"><?=green_integer($row['actual'])?></td>
					<td align="right"><?=number_format($row['deferred'],2)?></td>
					<td align="right"><?=number_format($row['semi'],2)?></td>
					<td align="right"><?=number_format($row['end_bal'],2)?></td>
					<td><em><?=$row['type']?></em></td>
				</tr>
		<?
		$t_billing  += $row['billing'];			
		$t_sched    += $row['sched'];
		$t_payment  += $row['actual'];
		$t_deferred += $row['deferred'];
		$t_semi 	+= $row['semi'];
		$t_end_bal  += $row['end_bal'];
				
		?>	
		
		
		<?endforeach?>

			
		<tr class="">
			<td colspan=4 align="right"></td>
			<!--td align="center" style="padding: 2px 0px 0px 0px; "><input type="text" class="input-sm input-small pink " value="<?=number_format($t_billing,2)?>" style="font-weight:bold;width:90px;text-align:right;" readonly></td-->
			<td align="center" style="padding: 2px 0px 0px 0px; "><input type="text" class="input-sm input-small orange " value="<?=number_format($t_sched,2)?>" style="font-weight:bold;width:90px;text-align:right;" readonly></td>
			<td align="center" style="padding: 2px 0px 0px 0px; "><input type="text" class="input-sm input-small blue" value="<?=number_format($t_payment,2)?>" style="font-weight:bold;width:90px;text-align:right;" readonly></td>
			<td align="center" style="padding: 2px 0px 0px 0px; "><input type="text" class="input-sm input-small red" value="<?=number_format($t_deferred,2)?>" style="font-weight:bold;width:90px;text-align:right;" readonly></td>
			<td align="center" style="padding: 2px 0px 0px 0px; " ><input type="text" class="input-sm input-small" value="<?=number_format($t_semi,2)?>" style="font-weight:bold;width:90px;text-align:right;" readonly></td>
			<td align="center" style="padding: 2px 0px 0px 0px; "><input type="text" class="input-sm input-small green" value="<?=number_format($t_end_bal,2)?>" style="font-weight:bold;width:90px;text-align:right;" readonly></td>
			<td colspan=2>
			</td>
		</tr>
		
		<? #LOAN ACCOUNTS: LEDGER ?>
		<?$accounts = $this->m_members->get_accounts_sl( $member_id, $_POST['pay_period'], $_POST['trans_date']);?>
		<?
		$t_billing_a = 0;	
		$t_sched_a = 0;
		$t_payment_a = 0;
		$t_deferred_a = 0;
		$t_semi_a = 0;
		$t_end_bal_a = 0;
		
		$ins_def = 0;
			
		?>
		<?foreach($accounts as $row):?>
			
			<tr>
				<td style="font-weight:bold" align=center><strong><?=$row['type']?></strong></td>
				<td style="font-weight:bold" align=center><?=$row['po_number']?></td>
				<td style="font-weight:bold" align=center>
					<a title="View loan details" href="<?=site_url("account/view_header/{$row['dr_number']}")?>?TB_iframe=true&height=400&width=400" class="thickbox"><u><?=$row['dr_number']?></u></a>
					 <? if($row['trans_type'] == 'NEW'): ?><?endif?> </td>
				<td align=center><?=users_date_format($row['start_dt'])?>&nbsp;-&nbsp;<?=users_date_format($row['end_dt'])?></td>
				<!--td style="font-weight:bold" align="right"><?=number_format($row['billing'],2)?></td-->
				<td style="font-weight:bold" align="right"><?=number_format($row['sched'],2)?></td>
				<td style="font-weight:bold" align="right"><?=green_integer($row['actual'])?></td>
				<td style="font-weight:bold" align="right"><?=number_format($row['deferred'],2)?></td>
				<td style="font-weight:bold" align="right"><?=number_format($row['semi'],2)?></td>
				<td style="font-weight:bold" align="right"><?=number_format($row['end_bal'],2)?></td>
				<td style="font-weight:bold" ><em><?=str_replace(" ",'&nbsp;',str_limiter($row['desc'],25))?></em></td>
			
			</tr>
			<?
			$t_billing_a  += $row['billing'];		
			$t_sched_a    += $row['sched'];
			$t_payment_a  += $row['actual'];
			$t_deferred_a += $row['deferred'];
			$t_semi_a 	  += $row['semi'];
				
			if($row['type'] != 'INS')
			{
				$t_end_bal_a  += $row['end_bal'];
			}
			
			if($row['type'] == 'INS'){
				$ins_def  += $row['deferred'];
			}
			?>	
		
		
		<?endforeach;?>
		
		<?#FOR OVERPAYMENT?>
		<?$accounts_ovr = $this->m_members->get_accounts_over( $member_id, $_POST['pay_period'], $_POST['trans_date']);?>
			
		<?foreach($accounts_ovr as $row):?>
			
		<?if($row['trans_type'] != 'NEW' OR $row['end_bal'] != 0):?>
			<tr style="font-weight:bold">
				<td align=center><strong><?=$row['type']?></strong></td>
				<td align=center><?=$row['po_number']?></td>
				<td align=center><?=$row['dr_number']?></td>
				<td align=center><?=users_date_format($row['start_dt'])?> - <?=users_date_format($row['end_dt'])?></td>
				<!--td align="right"><?=number_format($row['billing'],2)?></td-->
				<td align="right"><?=number_format($row['sched'],2)?></td>
				<td align="right"><?=green_integer($row['actual'])?></td>
				<td align="right"><?=green_integer($row['deferred'])?></td>
				<td align="right"><?=number_format($row['semi'],2)?></td>
				<td align="right" class="red"><strong><?=number_format($row['end_bal'],2)?></strong></td>
				<td><em><?=str_replace(" ",'&nbsp;',str_limiter($row['desc'],25))?></em></td>
				
			</tr>
				
			<?
				
			$t_payment_a  += $row['actual'];
			$t_end_bal_a  += $row['end_bal'];
			?>	
				
		<?endif?>
		<?endforeach;?>
		
		<?
			$tp_billing 	= $t_billing + $t_billing_a;	
			$tp_sched 		= $t_sched + $t_sched_a;
			$tp_payment		= $t_payment + $t_payment_a;
			$tp_deferred  	= $t_deferred + $t_deferred_a;
			$tp_semi 		= $t_semi + $t_semi_a;
			$tp_end_bal 	= $t_end_bal_a + $fp_bal + $rbp_def + $tbp_def + $ins_def;
				
		?>
		
		<? if(count($accounts) > 0): ?>
		
		<tr >
			<td align=right colspan="4"></td>
			<!--td align="center" style="padding: 2px 0px 0px 0px; "><input type="text" class="input-sm input-small pink" value="<?=number_format($t_billing_a,2)?>" style="font-weight:bold;width:90px;text-align:right;" readonly=""></td-->
			<td align="center" style="padding: 2px 0px 0px 0px; "><input type="text" class="input-sm input-small orange" value="<?=number_format($t_sched_a,2)?>" style="font-weight:bold;width:90px;text-align:right;" readonly=""></td>
			<td align="center" style="padding: 2px 0px 0px 0px; "><input type="text" class="input-sm input-small blue" value="<?=number_format($t_payment_a,2)?>" style="font-weight:bold;width:90px;text-align:right;" readonly=""></td>
			<td align="center" style="padding: 2px 0px 0px 0px; "><input type="text" class="input-sm input-small red" value="<?=number_format($t_deferred_a,2)?>" style="font-weight:bold;width:90px;text-align:right;" readonly=""></td>
			<td align="center" style="padding: 2px 0px 0px 0px; " ><input type="text" class="input-sm input-small" value="<?=number_format($t_semi_a,2)?>" style="font-weight:bold;width:90px;text-align:right;" readonly=""></td>
			<td align="center" style="padding: 2px 0px 0px 0px; "><input type="text" class="input-sm input-small green" value="<?=number_format($t_end_bal_a,2)?>" style="font-weight:bold;width:90px;text-align:right;" readonly=""></td>
			<td colspan=2>
			</td>
		</tr>
		
		<tr class="">
			<td align=right colspan="4"></td>
			<!--td align="center" style="padding: 2px 0px 0px 0px; "><input type="text" class="input-sm input-small pink" value="<?=number_format($tp_billing,2)?>" style="width:90px;text-align:right;font-weight:bold"   readonly=""></td-->
			<td align="center" style="padding: 2px 0px 0px 0px; "><input type="text" class="input-sm input-small orange" value="<?=number_format($tp_sched,2)?>" style="width:90px;text-align:right;font-weight:bold"   readonly=""></td>
			<td align="center" style="padding: 2px 0px 0px 0px; "><input type="text" class="input-sm input-small blue" value="<?=number_format($tp_payment,2)?>" style="width:90px;text-align:right;font-weight:bold"   readonly=""></td>
			<td align="center" style="padding: 2px 0px 0px 0px; "><input type="text" class="input-sm input-small red" value="<?=number_format($tp_deferred,2)?>" style="width:90px;text-align:right;font-weight:bold"   readonly=""></td>
			<td align="center" style="padding: 2px 0px 0px 0px; " ><input type="text" class="input-sm input-small" value="<?=number_format($tp_semi,2)?>" style="width:90px;text-align:right;font-weight:bold" 		    readonly=""></td>
			<td align="center" style="padding: 2px 0px 0px 0px; "><input type="text" class="input-sm input-small green" value="<?=number_format($tp_end_bal,2)?>" style="width:90px;text-align:right;font-weight:bold"  readonly=""></td>
			<td colspan=2>
			</td>
		</tr>
		
		<? endif; ?>
		
		<? #LOAN NON-PAYROLL ACCOUNTS: LEDGER ?>
		<?$accounts_np = $this->m_members->get_accounts_sl( $member_id, $_POST['pay_period'], $_POST['trans_date'], 2);?>
		

		<?
		$t_billing_np = 0;	
		$t_sched_np = 0;
		$t_payment_np = 0;
		$t_deferred_np = 0;
		$t_semi_np = 0;
		$t_end_bal_np = 0;
			
		?>
		<?foreach($accounts_np as $row):?>
				
			<tr >
				<td style="font-weight:bold" align=center><strong><?=$row['type']?></strong></td>
				<td style="font-weight:bold" align=center><?=$row['po_number']?></td>
				<td style="font-weight:bold" align=center>
					<a title="View loan details" href="<?=site_url("account/view_header/{$row['dr_number']}")?>?TB_iframe=true&height=400&width=400" class="thickbox"><u><?=$row['dr_number']?></u></a>
					<? if($row['trans_type'] == 'NEW'): ?><?endif?></td>
				<td align=center><?=users_date_format($row['start_dt'])?> - <?=users_date_format($row['end_dt'])?></td>
				<!--td style="font-weight:bold" align="right"><?=number_format($row['billing'],2)?></td-->
				<td style="font-weight:bold" align="right"><?=number_format($row['sched'],2)?></td>
				<td style="font-weight:bold" align="right"><?=green_integer($row['actual'])?></td>
				<td style="font-weight:bold"  align="right"><?=number_format($row['deferred'],2)?></td>
				<td style="font-weight:bold" align="right"><?=number_format($row['semi'],2)?></td>
				<td style="font-weight:bold" align="right"><?=number_format($row['end_bal'],2)?></td>
				<td style="font-weight:bold" ><em><?=str_limiter($row['desc'],23)?></em></td>
				
			</tr>
			
			<?
			$t_billing_np  += $row['billing'];		
			$t_sched_np    += $row['sched'];
			$t_payment_np  += $row['actual'];
			$t_deferred_np += $row['deferred'];
			$t_semi_np 	   += $row['semi'];
			$t_end_bal_np  += $row['end_bal'];
					
			?>	
		
		
		<?endforeach;?>
		
		<?if(count($accounts_np) > 0):?>
		
		<tr class="">
			<td align=right colspan="4"> <strong>Non Payroll Accounts</strong> </td>
			<!--td align="center" style="padding: 2px 0px 0px 0px; "><input type="text" class="input-sm input-small pink" value="<?=number_format($t_billing_np,2)?>" style="font-weight:bold;width:90px;text-align:right;" readonly></td-->
			<td align="center" style="padding: 2px 0px 0px 0px; "><input type="text" class="input-sm input-small orange" value="<?=number_format($t_sched_np,2)?>" style="font-weight:bold;width:90px;text-align:right;" readonly></td>
			<td align="center" style="padding: 2px 0px 0px 0px; "><input type="text" class="input-sm input-small blue" value="<?=number_format($t_payment_np,2)?>" style="font-weight:bold;width:90px;text-align:right;" readonly></td>
			<td align="center" style="padding: 2px 0px 0px 0px; "><input type="text" class="input-sm input-small red" value="<?=number_format($t_deferred_np,2)?>" style="font-weight:bold;width:90px;text-align:right;" readonly></td>
			<td align="center" style="padding: 2px 0px 0px 0px; " ><input type="text" class="input-sm input-small" value="<?=number_format($t_semi_np,2)?>" style="font-weight:bold;width:90px;text-align:right;" readonly></td>
			<td align="center" style="padding: 2px 0px 0px 0px; "><input type="text" class="input-sm input-small green" value="<?=number_format($t_end_bal_np,2)?>" style="font-weight:bold;width:90px;text-align:right;" readonly></td>
			<td>
			</td>
		</tr>
		
		<?endif;?>
		
		<?$accounts_mpl = $this->m_members->get_accounts_sl( $member_id, $_POST['pay_period'], $_POST['trans_date'], 3);?>
		
		<?
		$t_billing_mpl = 0;	
		$t_sched_mpl = 0;
		$t_payment_mpl = 0;
		$t_deferred_mpl = 0;
		$t_semi_mpl = 0;
		$t_end_bal_mpl = 0;
			
		?>
		
		<?foreach($accounts_mpl as $row):?>
		
			
			<tr >
				<td style="font-weight:bold" align=center><strong><?=$row['type']?></strong></td>
				<td style="font-weight:bold" align=center><?=$row['po_number']?></td>
				<td style="font-weight:bold" align=center>
					<a title="View loan details" href="<?=site_url("account/view_header/{$row['dr_number']}")?>?TB_iframe=true&height=400&width=400" class="thickbox"><u><?=$row['dr_number']?></u></a>
				</td>
				<td align=center><?=users_date_format($row['start_dt'])?> - <?=users_date_format($row['end_dt'])?></td>
				<!--td style="font-weight:bold" align="right"><?=number_format($row['billing'],2)?></td-->
				<td style="font-weight:bold" align="right"><?=number_format($row['sched'],2)?></td>
				<td align="right"><?=green_integer($row['actual'])?></td>
				<td style="font-weight:bold" align="right"><?=number_format($row['deferred'],2)?></td>
				<td style="font-weight:bold" align="right"><?=number_format($row['semi'],2)?></td>
				<td style="font-weight:bold" align="right"><?=number_format($row['end_bal'],2)?></td>
				<td style="font-weight:bold"><em><?=$row['desc']?></em></td>
				
			</tr>
			
			<?
			$t_billing_mpl  += $row['billing'];		
			$t_sched_mpl    += $row['sched'];
			$t_payment_mpl  += $row['actual'];
			$t_deferred_mpl += $row['deferred'];
			$t_semi_mpl 	   += $row['semi'];
			$t_end_bal_mpl  += $row['end_bal'];
					
			?>	
		
		
		<?endforeach;?>
		
		
		
		<?if(count($accounts_mpl) > 0):?>
		
		<tr style="font-weight:bold">
			<td align=right colspan="4"> <strong>MPL Accounts</strong> </td>
			<!--td align="center" style="padding: 2px 0px 0px 0px; "><input type="text" class="input-sm input-small pink" value="<?=number_format($t_billing_mpl,2)?>" style="font-weight:bold;width:90px;text-align:right;" readonly></td-->
			<td align="center" style="padding: 2px 0px 0px 0px; "><input type="text" class="input-sm input-small orange" value="<?=number_format($t_sched_mpl,2)?>" style="font-weight:bold;width:90px;text-align:right;" readonly></td>
			<td align="center" style="padding: 2px 0px 0px 0px; "><input type="text" class="input-sm input-small blue" value="<?=number_format($t_payment_mpl,2)?>" style="font-weight:bold;width:90px;text-align:right;" readonly></td>
			<td align="center" style="padding: 2px 0px 0px 0px; "><input type="text" class="input-sm input-small red" value="<?=number_format($t_deferred_mpl,2)?>" style="font-weight:bold;width:90px;text-align:right;" readonly></td>
			<td align="center" style="padding: 2px 0px 0px 0px; " ><input type="text" class="input-sm input-small" value="<?=number_format($t_semi_mpl,2)?>" style="font-weight:bold;width:90px;text-align:right;" readonly></td>
			<td align="center" style="padding: 2px 0px 0px 0px; "><input type="text" class="input-sm input-small green" value="<?=number_format($t_end_bal_mpl,2)?>" style="font-weight:bold;width:90px;text-align:right;" readonly></td>
			<td>
			</td>
		</tr>
		
		<?endif;?>
		
		<?
		$t_billing_d = 0;		
		$t_sched_d = 0;
		$t_payment_d = 0;
		$t_deferred_d = 0;
		$t_semi_d = 0;
		$t_end_bal_d = 0;
			
		?>
		
		<? $dep = $this->m_members->get_member_dependents($member_id); ?>
			
		<?foreach($dep->result() as $dep_row):?>
		
			<?
			$t_billing_d2 = 0;	
			$t_sched_d2 = 0;
			$t_payment_d2 = 0;
			$t_deferred_d2 = 0;
			$t_semi_d2 = 0;
			$t_end_bal_d2 = 0;
				
			?>
				
			<? #DEPENDENT TBP RBP CONTRIB ACCOUNTS: LEDGER ?>
			<?$accounts = $this->m_members->get_contrib_sl( $dep_row->member_id, $_POST['pay_period'], $_POST['trans_date']);?>
				
			<?
			foreach($accounts as $row):
				$t_billing_d  += $row['billing'];	
				$t_sched_d    += $row['sched'];
				$t_payment_d  += $row['actual'];
				$t_deferred_d += $row['deferred'];
				$t_semi_d 	  += $row['semi'];
				#IF FINES & PENALTIES ADD TO END BALANCE	
				if($row['type'] == 'FP')
				{
					$t_end_bal_d  += $row['end_bal'];
				}
				
				if($row['type'] == 'RBP')
				{
					$t_end_bal_d  += $row['deferred'];
				}
				
				if($row['type'] == 'TBP')
				{
					$t_end_bal_d  += $row['deferred'];
				}
				
				$t_billing_d2    += $row['billing'];
				$t_sched_d2    += $row['sched'];
				$t_payment_d2  += $row['actual'];
				$t_deferred_d2 += $row['deferred'];
				$t_semi_d2 	  += $row['semi'];
				#IF FINES & PENALTIES ADD TO END BALANCE	
				if($row['type'] == 'FP')
				{
					$t_end_bal_d2 += $row['end_bal'];
				}
				
				if($row['type'] == 'RBP')
				{
					$t_end_bal_d2 += $row['deferred'];
				}
				
				if($row['type'] == 'RBP')
				{
					$t_end_bal_d2 += $row['deferred'];
				}
				
				
			endforeach;
			?>
			
			<? #DEPENDENT SCS CONTRIB ACCOUNTS: LEDGER ?>
			<?$accounts = $this->m_members->get_contrib_scs_sl( $dep_row->member_id, $_POST['pay_period'], $_POST['trans_date']);?>
				
			<?
			foreach($accounts as $row):
				$t_billing_d  += $row['billing'];	
				$t_sched_d    += $row['sched'];
				$t_payment_d  += $row['actual'];
				$t_deferred_d += $row['deferred'];
				$t_semi_d 	  += $row['semi'];
				
				$t_billing_d2  += $row['billing'];		
				$t_sched_d2    += $row['sched'];
				$t_payment_d2  += $row['actual'];
				$t_deferred_d2 += $row['deferred'];
				$t_semi_d2	  += $row['semi'];
					
			endforeach;
			?>
			
			<? #DEPENDENT LOANS ACCOUNTS: LEDGER ?>
			<?$accounts = $this->m_members->get_accounts_sl( $dep_row->member_id, $_POST['pay_period'], $_POST['trans_date']);?>
				
			<?
			foreach($accounts as $row):
				$t_billing_d  += $row['billing'];		
				$t_sched_d    += $row['sched'];
				$t_payment_d  += $row['actual'];
				$t_deferred_d += $row['deferred'];
				$t_semi_d 	  += $row['semi'];
				$t_end_bal_d  += $row['end_bal'];
				
				$t_billing_d2  += $row['billing'];
				$t_sched_d2    += $row['sched'];
				$t_payment_d2  += $row['actual'];
				$t_deferred_d2 += $row['deferred'];
				$t_semi_d2 	   += $row['semi'];
				$t_end_bal_d2  += $row['end_bal'];
					
			endforeach;
			?>
			
			<? if($t_semi_d2 > 0):?>
			
				<tr style="font-weight:bold">
					<td align=right colspan="4"> <strong class="pink"><em>DEPENDENT: </strong> <strong><?=$dep_row->name?></strong></em> </td>
					<!--td align="right"><?=number_format($t_billing_d2,2)?></td-->
					<td align="right"><?=number_format($t_sched_d2,2)?></td>
					
					<td align="right"><?=green_integer($t_payment_d2)?></td>
					<td align="right" class="red"><?=number_format($t_deferred_d2,2)?></td>
					<td align="right"><?=number_format($t_semi_d2,2)?></td>
					<td align="right"><?=number_format($t_end_bal_d2,2)?></td>
					<td>
					</td>
				</tr>
			<?else:
				$t_billing_d  -= $t_billing_d2;
				$t_sched_d    -= $t_sched_d2;
				$t_payment_d  -= $t_payment_d2;
				$t_deferred_d -= $t_deferred_d2;
				$t_semi_d 	  -= $t_semi_d2;
				$t_end_bal_d  -= $t_end_bal_d2;?>
			<?endif?>	
			
		<?endforeach;?>
		
		<? $savings_sched = $this->m_members->get_savings_sched_all($_POST['member_id'],$_POST['pay_period']);?>
		
		<? $comaker_share = 0; ?>
		
		
		
		<?
			$g_billing 		= $t_billing   + $t_billing_a  + $t_billing_d   + $savings_sched;
			$g_sched 		= $t_sched     + $t_sched_a    + $t_sched_d     + $t_sched_np;
			$g_payment		= $t_payment   + $t_payment_a  + $t_payment_d   + $t_payment_np + $t_payment_mpl;
			$g_deferred  	= $t_deferred  + $t_deferred_a + $t_deferred_np + $t_deferred_d;
			$g_semi 		= $t_semi      + $t_semi_a 	   + $t_semi_np 	+ $t_semi_d;
			$g_end_bal 		= $t_end_bal_a + $t_end_bal_np + $t_end_bal_d 	+ $fp_bal + $tbp_def + $rbp_def + $ins_def + $t_end_bal_mpl;
		?>
		
		<? if($comaker_share > 0 AND $mem_info->cm == 1): ?>
		<tr>
			<td align=right colspan="4"> <strong class="purple"><em>CO-MAKER EXPOSURE</em></strong> </td>
			<!--td align="right">0.00</td-->
			<td align="right">0.00</td>
			
			<td align="right">0.00</td>
			<td align="right">0.00</td>
			<td align="right">0.00</td>
			<td align="right"><?=number_format($comaker_share,2)?></td>
			<td >
				&nbsp;
			</td>
		</tr>
		<? $g_end_bal += $comaker_share; ?>
		<?endif?>
			
		<tr class="success">
			<td align=right colspan="4"> <strong>GRAND TOTAL </strong> </td>
			<!--td align="center" style="padding: 2px 0px 0px 0px; "><input type="text" class="input-sm input-small pink" value="<?=number_format($g_billing,2)?>" style="width:90px;text-align:right;font-weight:bold"  readonly=""></td-->
			<td align="center" style="padding: 2px 0px 0px 0px; "><input type="text" class="input-sm input-small orange" value="<?=number_format($g_sched,2)?>" style="width:90px;text-align:right;font-weight:bold"  readonly=""></td>
			<td align="center" style="padding: 2px 0px 0px 0px; "><input type="text" class="input-sm input-small blue" value="<?=number_format($g_payment,2)?>" style="width:90px;text-align:right;font-weight:bold"  readonly=""></td>
			<td align="center" style="padding: 2px 0px 0px 0px; " ><input type="text" class="input-sm input-small red" value="<?=number_format($g_deferred,2)?>" style="width:90px;text-align:right;font-weight:bold"  readonly=""></td>
			<td align="center" style="padding: 2px 0px 0px 0px; "><input type="text" class="input-sm input-small" value="<?=number_format($g_semi,2)?>" style="width:90px;text-align:right;font-weight:bold"  readonly=""></td>
			<td align="center" style="padding: 2px 0px 0px 0px; "><input type="text" class="input-sm input-small green" value="<?=number_format($g_end_bal,2)?>" style="width:90px;text-align:right;font-weight:bold"  readonly=""></td>
			<td align=left></td>
		</tr>
		
		<input type="hidden" id="grand_total" value="<?=$g_end_bal-$comaker_share?>" />
	</tbody>
</table>

<?
	$sql = "    SELECT *
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
	$query = $this->tbms_db->query($sql);

	
?>

<?if($query->num_rows() > 0):?>
<hr>

<h3 style="margin-left:10px;" class="header smaller lighter green">
	<i class="icon-file-text-alt"></i>																
	Historical Data of Payroll Deduction
	<small> >> Last four months of collection</small>
</h3>



<table cellspacing="10" border=1 style="margin-left:10px;width:900px;background:white; margin-top:-10px; font-size:11px; font-family:tahoma;" class="table table-striped table-condensed table-bordered">
	
	<thead class="thin-border-bottom">
	<tr style="font-weight:bold; font-size:11px;">
		<th>PAYROLL DATE: </th>
		
		<?foreach($query->result() as $row):?>
		<td align="right"><?=users_date_format($row->pd)?></td> 
		<?endforeach;?>
		
		<td align="center">AVE. COLN / %</td>
	</tr>
	</thead>
	
	
	<tr style="font-weight:bold">
		<th class=" green">END BALANCE: </th>
		
		<?foreach($query->result() as $row):?>
		
		<? $ob = $this->m_members->get_account_ob($_POST['member_id'], $row->pd, 1); ?>
		
		<td align="right"><?=number_format($ob,2)?></td> 
		<?endforeach;?>
	</tr>
	
	<tr style="font-weight:bold">
		<th class=" orange">SCHED DEDUCTION:</th>
		<?foreach($query->result() as $row):?>
		
		<?$billing_info = $this->m_members->get_billing_info($_POST['member_id'], $row->pd, 1);?>
		
		<td align="right"><?=number_format($billing_info['billing'],2)?></td> 
		<?endforeach;?>
	</tr>
	
	<tr style="font-weight:bold">
		<th class="blue">ACTUAL PAYMENT: </th>
		
		<?
		$t_amt = 0;
		foreach($query->result() as $row):?>
		<?
		$actual = 0;
		$sqlx = "    SELECT payroll_date as pd,ar_collections_d.*
					FROM ar_collections_h
					LEFT JOIN ar_collections_d USING(collection_id)
					WHERE status = 'Posted'
					AND payment_type = 0
					AND member_id = '{$_POST['member_id']}'
					AND payroll_date = '$row->pd'"; 
		#echo $sqlx;
		$queryx = $this->tbms_db->query($sqlx);
		if($queryx->num_rows() > 0) $actual = $queryx->row('amount');
		?>
		
		<td align="right"><?=number_format($actual,2)?></td> 
		
		<?
		
		$t_amt += $actual;
		endforeach;
		
		$t_ave = $t_amt / $query->num_rows();
		?>
		
		<td align="center">Php <?=number_format($t_ave,2)?></td> 
		
	</tr>
	
	<tr style="font-weight:bold">
		<th class="red">DEFERRED AMOUNT: </th>
		<?foreach($query->result() as $row):?>
		
		<?$billing_info = $this->m_members->get_billing_info($_POST['member_id'], $row->pd, 1);?>
		
		<td align="right"><?=number_format($billing_info['deferred'],2)?></td> 
		<?endforeach;?>
	</tr>
	
	<tr>
		<th>COLLECTION %: </th>
			
		<?
		$t_amt = 0;
		$t_sched = 0;
		$t_percent = 0;
		foreach($query->result() as $row):?>
		<?
		$billing_info = $this->m_members->get_billing_info($_POST['member_id'], $row->pd, 1);
		$percent = 0;
		
		$actual = 0;
		$sqlx = "    SELECT payroll_date as pd,ar_collections_d.*
					FROM ar_collections_h
					LEFT JOIN ar_collections_d USING(collection_id)
					WHERE status = 'Posted'
					AND payment_type = 0
					AND member_id = '{$_POST['member_id']}'
					AND payroll_date = '$row->pd'"; 
		#echo $sqlx;
		$queryx = $this->tbms_db->query($sqlx);
		if($queryx->num_rows() > 0) $actual = $queryx->row('amount');
		
		
		if($actual > 0 AND $billing_info['billing'] > 0):
			$percent = round(($actual / $billing_info['billing']) * 100,0); 
		endif;
		
		$t_percent += $percent;
		
		$t_amt += $billing_info['billing'] > 0 ? $actual : 0;
		$t_sched += $billing_info['billing'];
		?>
			
		<td align="right"><strong><?=$percent?> %</strong></td> 
			
		<?endforeach;?>
			
		<?$t_percent =  $t_sched > 0 ? round(($t_amt / $t_sched) * 100,0) : 0; ?>
			
		<td align="center"><strong><?=$t_percent?> %</strong></td> 
			
	</tr>
	
</table>
<?endif?>

</form>

</body>
</html>

