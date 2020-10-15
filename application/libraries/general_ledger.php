<?php
defined("BMS_VALID") or die("Direct Access to this location is not allowed.");
?>

<?
$validate = new validation;
$alert = new alert;

if(isset($_POST['save']))
	{	
	for($x=1;$x<=10;$x++)
		{
		if($_POST['remarks_'.$x] != "")
			{
			$query = "UPDATE t_accounts SET remarks = '{$_POST['remarks_'.$x]}' WHERE id = '{$_POST['id_'.$x]}'";
			$result = mysql_query($query) or die(mysql_error() . $query);
				
			if($result)
				{
				$alert->success = 1;
				$alert->sMsg = "Entry has been edited.";
				$alert->showAlert($e . ' ' . $validate->e);	
				}
			else 
				{
				$alert->success = 0;
				$alert->sMsg = "Entry has not been edited.";
				$alert->showAlert($e . ' ' . $validate->e);	
				}
			}
		}
	}
?>


<form action="<?=$_SERVER['PHP_SELF']?>?path=<?=$_GET['path']?>" method="POST">
<br>
<table class="right" width="100%">
	<tr>
		<td align="right">
			<input type="submit" name="save" id="save" value="Save" style="width: 60px;">
			<input type="submit" name="cancel" id="cancel" value="Cancel" style="width: 60px;">
		</td>
	</tr>
</table>

<fieldset class="center" style="width: 98%;">
	<table class="center" width="100%" border="1" style="border-collapse:collapse;">
		<tr class="theader">
			<td colspan="12" align="left" style="padding-left:2px">GENERAL LEDGER</td>
		</tr>
		<tr style="background: #D7D399">
			<td colspan="12" align="left" style="padding-left:10px">PROCESSING YEAR: <?=date("Y")?></td>
		</tr>
		<?
		//$nav = new navigation;
		
		$query = "SELECT id, journal_id, line_num, ref_no, accnt_code, balance, txn_id, remarks, chart_of_accounts.description AS desc1, account_entry_header.description AS desc2, dr, cr, amount, posted_date, Emp_Name, dr_number
					FROM chart_of_accounts 
					LEFT JOIN t_accounts ON chart_of_accounts.accnt_code = t_accounts.account
					LEFT JOIN m_employees ON m_employees.Emp_No = t_accounts.posted_by 
					LEFT JOIN account_entry_header USING (txn_id)
				  WHERE accnt_code IS NOT NULL && (status IS NULL || status = 3) ORDER BY `chart_of_accounts`.`accnt_code`, `txn_id`, `journal_id` ASC";
		$result = mysql_query($query);
		
		$record_count = mysql_num_rows($result);
		/*						
		$nav->page = intval($_GET["page"]);
		if(!$nav->page) 
			$nav->page = 1;
						
		$limit = 10;
		$start = $limit * ($nav->page - 1);
		$nav->total_pages = ceil($record_count / $limit);
				
		$query .= " LIMIT $start, $limit";*/
		$result = mysql_query($query);
		
		$num_rows = mysql_num_rows($result);
		$ctr = 0;
		while($row = mysql_fetch_array($result))
			{
			$ctr++;
			$color = ($color == '#FFFFFF')?'#F3F3F3':'#FFFFFF';
			if($old_value != $row['accnt_code'])
				{
				?>
				<tr style="background: #CCDDFF">
					<td colspan="13">&nbsp;</td>
				</tr>
				<tr style="background: #F3F399">
					<td colspan="13" align="left"><?=$row['accnt_code']?> : <?=$row['desc1']?></td>
				</tr>
				
				<tr style="background: #F3F3F3; text-align:center;">
					
					<td><small>POST DATE</small></td>
					<td><small>TRANSACTION CODE</small></td>
					<td><small>TRANSACTION TITLE</small></td>
					<td width="10px"><small>JOURNAL ID</small></td>
					<td width="10px"><small>LINE NUMBER</small></td>
					<td width="10px"><small>DR NUMBER</small></td>
					<td><small>DEBIT</small></td>
					<td><small>CREDIT</small></td>
					<td><small>BALANCE</small></td>
					<td><small>Remarks</small></td>
					<td><small>POSTED BY</small></td>
					<td><small>DATE POSTED</small></td>
				</tr>
				<tr>
					<td align="center"></td>
					<td></td>
					<td></td>
					<td width="10px"><small>Balance</small></td>
					<td width="10px"></td>
					<td width="10px"></td>
					<td></td>
					<td></td>
					<td align="center"><small><?=number_format($row['balance'], 2, '.', ',')?></small></td>
					<td></td>
					<td></td>
				</tr>
				<?
				$balance = $row['balance'];
				}
			if(is_null($row['id']))
				$disabled = "disabled";
			else 
				$disabled = "";
			echo '<tr style="background:'.$color.'">';
				//echo '<td><input type="checkbox" name="check_'.$ctr.' id="check_'.$ctr.'" value="'.$row['id'].'" '.$disabled.'></td>';
			if($row['posted_date'])
				echo '<td align="center"><small>'.date("n/d/Y",strtotime($row['posted_date'])).'</small></td>';
			else 
				echo '<td align="center"><small>--- --- ---</small></td>';
			if($row['txn_id'])
				echo '<td align="center"><small>'.$row['txn_id'].'</small></td>';
			else 
				echo '<td align="center"><small>--- --- ---</small></td>';	
			if($row['desc2'])
				echo '<td><small>'.$row['desc2'].'</small></td>';
			else 
				echo '<td align="center"><small>--- --- ---</small></td>';	
			if($row['journal_id'])
				{
				if($row['ref_no'] == 'ME')
					echo '<td width="10px" align="center"><small>JV-'.$row['journal_id'].'</small></td>';
				else 
					echo '<td width="10px" align="center"><small>'.$row['journal_id'].'</small></td>';
				}
			else 
				echo '<td width="10px" align="center"><small>--- --- ---</small></td>';
			if($row['line_num'])	
				echo '<td width="10px" align="center"><small>'.$row['line_num'].'</small></td>';
			else 
				echo '<td width="10px" align="center"><small>--- --- ---</small></td>';
			if($row['dr_number'])	
				echo '<td width="10px" align="center"><small>'.$row['dr_number'].'</small></td>';
			else 
				echo '<td width="10px" align="center"><small>--- --- ---</small></td>';	
			if($row['dr'] == 1)
				{
				$dr = number_format($row['amount'], 2, '.', ',');
				if(($row['accnt_code'] >= 10000 && $row['accnt_code'] <= 19999) || ($row['accnt_code'] >= 60000 && $row['accnt_code'] <= 69999) || $row['accnt_code'] == 30001)
					$balance += $row['amount'];
					
				if(($row['accnt_code'] >= 20000 && $row['accnt_code'] <= 29999) || ($row['accnt_code'] == 30000 || $row['accnt_code'] >= 30002 && $row['accnt_code'] <= 39999) || ($row['accnt_code'] >= 50000 && $row['accnt_code'] <= 59999))
					$balance -= $row['amount'];
				}
			else 
				$dr = "0.00";
				
			echo '<td align="right"><small>'.$dr.'</small></td>';
			
			
			if($row['cr'] == 1)
				{
				$cr = number_format($row['amount'], 2, '.', ',');
				if(($row['accnt_code'] >= 10000 && $row['accnt_code'] <= 19999) || ($row['accnt_code'] >= 60000 && $row['accnt_code'] <= 69999) || $row['accnt_code'] == 30001)
					$balance -= $row['amount'];	
					
				if(($row['accnt_code'] >= 20000 && $row['accnt_code'] <= 29999) || ($row['accnt_code'] == 30000 || $row['accnt_code'] >= 30002 && $row['accnt_code'] <= 39999) || ($row['accnt_code'] >= 50000 && $row['accnt_code'] <= 59999))
					$balance += $row['amount'];
			
				}
			else 
				$cr = "0.00";
			echo '<td align="right"><small>'.$cr.'</small></td>';
			echo '<td align="center"><small>'.number_format($balance, 2, '.', ',').'</small></td>';//balance
			
			echo '<td align="center"><small><textarea name="remarks_'.$ctr.'" id="remarks_'.$ctr.'" rows="1" '.$disabled.'>'.$row['remarks'].'</textarea></small></td>';//remarks
				echo '<input type="hidden" name="id_'.$ctr.'" id="id_'.$ctr.'" value="'.$row['id'].'">';
			if($row['Emp_Name'])
				echo '<td align="center"><small>'.$row['Emp_Name'].'</small></td>';
			else 
				echo '<td align="center"><small>--- --- ---</small></td>';
			if($row['posted_date'])
				echo '<td align="center"><small>'.date("n/d/Y",strtotime($row['posted_date'])).'</small></td>';
			else 
				echo '<td align="center"><small>--- --- ---</small></td>';
			echo '</tr>';
			?>

		  <?
			$old_value = $row['accnt_code'];
			}
		if ($num_rows == 0) 
			{?>
			<tr style="background: #F3F399">
				<td colspan="10" align="center">No Existing Data.</td>
			</tr>
		  <?}
		?>
	</table>
</fieldset>

	<div style="text-align:center">
		<?php //$nav->pagination($_SERVER['PHP_SELF'] . '?path=' . $_GET['path']); ?>
	</div>
</form>
<div style="float:center; width:180px;" class="center" onmouseover="this.style.cursor='pointer';" 
	onclick="window.open('accounting/reports/general_ledger_excel.php', 
	'printable', 'menubar=0, resizable=0, height=0, width=0');">
	<img src="images/csv.png" alt="print" /> Download XLS File
</div>