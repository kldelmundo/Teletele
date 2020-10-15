<!-- MADE TO COMPENSATE THE PROFILE FOR BLISS PROJECT -->
<body>

<div id="body">

	<div class="bodygradient">
		<div class="bodyminimum">
			<div style="height: 50px; position: relative; width: 100%; top:40px; font-family: Akrobat; font-size: 18px; color:white; text-align: center; padding: 5px;">
			<h1> MY TELESCOOP SAVINGS </h1>
			</div>
			<div id="savings" style="margin: 50px 250px; background-color: white; padding: 40px 50px; font-size: 18px; text-align: left;">

			<?if(isset($_POST['view_by_savings'])):?>

					<form action="<?=site_url($this->uri->uri_string())?>" method="POST">
						<p></p>
						<?
						$sql = "SELECT *
								FROM mem_savings_detail
								WHERE member_id = $member_id
								AND DATE_SUB(CURDATE(),INTERVAL {$_POST['view_by_savings']} MONTH) <= trans_date
								ORDER BY trans_date
								#LIMIT 0
								";

						$sql2 = "SELECT *
								 FROM mem_savings_detail
								 WHERE member_id = $member_id
								 AND DATE_SUB(CURDATE(),INTERVAL {$_POST['view_by_savings']} MONTH) <= trans_date
								 ORDER BY trans_date DESC LIMIT 1
								";
						$end_balance = $this->db->query($sql2);
						?>
						<? $query = $this->db->query($sql); ?>

						<? if($query->num_rows() > 0):?>

						<table>
							<tr>
								<td class="Thead" colspan=4>MY SAVINGS ACCOUNT  </td>
								<td class="Thead" colspan=2 align="right">
									View by: &nbsp;
									<select name="view_by_savings" onchange="submit()">
									<option value="3" <?if($_POST['view_by_savings'] == 3) echo 'selected';?>>Last three(3) months</option>
									<option value="6" <?if($_POST['view_by_savings'] == 6) echo 'selected';?>>Last six(6) months</option>
									<option value="12" <?if($_POST['view_by_savings'] == 12) echo 'selected';?>>Last one(1) year</option>
									</select>
								</td>
							</tr>

							<tr class="Thead">
								<td>#</td>
								<td>TRANS DATE</td>
								<td>REF NO#</td>
								<td>TRANS TYPE</td>
								<td align="right">TRANS AMOUNT</td>
								<td align="right">END BALANCE</td>
							</tr>
						<?endif;?>
						<?$ctr=1;
						foreach($query->result() as $row):?>

						<?
							if(trim($row->trans_type) == 'WDR'){
								$type = 'Withdrawal';
							}elseif(trim($row->trans_type) == 'CSD'){
								$type = 'Cash Salary Deduction';
							}elseif(trim($row->trans_type) == 'DM'){
								$type = 'Debit Memo';
							}elseif(trim($row->trans_type) == 'INT'){
								$type = 'Interest';
							}else{
								$type = '';
							}
						?>
								<tr>
									<td><?=$ctr++?></td>
									<td >&nbsp;<?=date('m/d/Y',strtotime($row->trans_date))?></td>
									<td><?=$row->ref_nbr?></td>
									<td align="center" title="<?=$type?>"><strong><?=$row->trans_type?></strong></td>
									<td align="right"><?=number_format($row->trans_amount,2)?></td>
									<td align="right"><?=number_format($row->end_balance,2)?></td>
								</tr>
						<?endforeach;?>
						<? if($query->num_rows() > 0):?>
								<tr>

									<td class="Thead" colspan=4><h3>TOTAL END BALANCE</h3></td>
									<td class="Thead" colspan=2 align="right"><h3><strong>PHP <?=number_format($end_balance->row('end_balance'),2)?></strong></h3></td>
								</tr>
						<?else:?>
								<br>
								<br>
								<br>
								<tr>
									<td colspan=4 align=center><center><strong>No Savings Found.</center></strong></td>
									<!--td colspan=4 align=center><center><strong>Savings is not yet available for viewing because it is currently under update. <br>Sorry for the inconvenience. Thank you.</center></strong></td-->
								</tr>
						<?endif;?>
						</table>

					</form>

			<?else:?>

				<form action="<?=site_url($this->uri->uri_string())?>" method="POST">
						<p></p>
						<?
						$sql = "SELECT *
								FROM mem_savings_detail
								WHERE member_id = $member_id
								AND DATE_SUB(CURDATE(),INTERVAL 3 MONTH) <= trans_date
								ORDER BY trans_date
								#LIMIT 0
								";

						$sql2 = "SELECT *
								 FROM mem_savings_detail
								 WHERE member_id = $member_id
								 AND DATE_SUB(CURDATE(),INTERVAL 3 MONTH) <= trans_date
								 ORDER BY trans_date DESC, id DESC LIMIT 1
								";
						$end_balance = $this->db->query($sql2);
						?>
						<? $query = $this->db->query($sql);?>

						<? if($query->num_rows() > 0):?>


						<table>
							<tr>
								<td class="Thead" colspan=4>  &nbsp; MY SAVINGS ACCOUNT  </td>
								<td class="Thead" colspan=2 align="right">
									View by: &nbsp;
									<select name="view_by_savings" onchange="submit()">
									<option value="3"> Last three(3) months</option>
									<option value="6"> Last six(6) months</option>
									<option value="12"> Last one(1) year</option>
									</select>
								</td>
							</tr>

							<tr class="Thead">
								<td>#</td>
								<td>TRANS DATE</td>
								<td>REF NO#</td>
								<td>TRANS TYPE</td>
								<td align="right">TRANS AMOUNT</td>
								<td align="right">END BALANCE</td>
							</tr>
						<?endif;?>
						<?$ctr=1;
						foreach($query->result() as $row):?>

						<?
							if(trim($row->trans_type) == 'WDR'){
								$type = 'Withdrawal';
							}elseif(trim($row->trans_type) == 'CSD'){
								$type = 'Cash Savings Deposit';
							}elseif(trim($row->trans_type) == 'DM'){
								$type = 'Debit Memo';
							}elseif(trim($row->trans_type) == 'INT'){
								$type = 'Interest';
							}elseif(trim($row->trans_type) == 'APP'){
								$type = 'Applied to Accounts';
							}else{
								$type = '';
							}
						?>
								<tr>
									<td><?=$ctr++?></td>
									<td >&nbsp;<?=date('m/d/Y',strtotime($row->trans_date))?></td>
									<td><?=$row->ref_nbr?></td>
									<td align="center" title="<?=$type?>"><strong><?=$row->trans_type?></strong></td>
									<td align="right"><?=number_format($row->trans_amount,2)?></td>
									<td align="right"><?=number_format($row->end_balance,2)?></td>
								</tr>
						<?endforeach;?>
						<? if($query->num_rows() > 0):?>
								<tr>

									<td class="Thead" colspan=4><h3>TOTAL END BALANCE</h3></td>
									<td class="Thead" colspan=2 align="right"><h3><strong>PHP <?=number_format($end_balance->row('end_balance'),2)?></strong></h3></td>
								</tr>
						<?else:?>
								<br>
								<br>
								<br>
								<tr>
									<td colspan=4 align=center><center><strong>No Savings Found.</center></strong></td>
									<!--td colspan=4 align=center><center><strong>Savings is not yet available for viewing because it is currently under update. <br>Sorry for the inconvenience. Thank you.</center></strong></td-->
								</tr>
						<?endif;?>
						</table>
						<br>
						<div style="margin: 10px">
							<small><strong>TELESCOOP Savings Deposit</strong> earns interests with the following bracket: (first 1M - 5%, 2nd 1M - 4% & balance - 3%)
							compounded monthly and payable every 1st day of the following month based on lowest balance
							of the previous month.
							 <a style="color:red" href="<?=FILES_PATH?>Interest rate.jpg" target="_blank">(click here for more info)</a>
							</small>
						</div>
				</form>
			<?endif;?>

		</div>
	</div>
</div>

</body>
</html>
