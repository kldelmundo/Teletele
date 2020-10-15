<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Cat2 Online Loan Generator</title>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script src="//code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
	<link rel="stylesheet" href="/resources/demos/style.css">

	<style type="text/css">

	::selection{ background-color: #E13300; color: white; }
	::moz-selection{ background-color: #E13300; color: white; }
	::webkit-selection{ background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body{
		margin: 0 15px 0 15px;
	}

	p.footer{
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}

	#container{
		margin: 10px;
		border: 1px solid #D0D0D0;
		-webkit-box-shadow: 0 0 8px #D0D0D0;
	}
	</style>
</head>


<body>

<div id="container">
	<h1>Category 2 Online Loan Generator</h1>

	<div id="body">

		<code>Will send only to valid email address below <br>if a problem occured, kindly <?=mailto('guinmar.liamzon@telescoop.com.ph','Click here to mail me');?></code>
		<!--<h4 align="center"><?=anchor('welcome/Prints', 'Print',array('target' => '_blank'));?></h4>-->
		
		<?$this->etbms_db = $this->load->database('etbms_db', TRUE);
		  $this->tbms_db = $this->load->database('tbms_db', TRUE);?>
		<?$sqly = "   SELECT
						member_id,
						CONCAT( mem_lname, ', ', mem_fname, ' ', LEFT ( mem_mname, 1 ), '.' ) AS NAME,
						mem_hired_date,
						dedn_start_dt,
						emp_level_id,
						company_id,
						TIMESTAMPDIFF( YEAR, mem_hired_date, CURDATE( ) ) AS LOS,
						TIMESTAMPDIFF( YEAR, dedn_start_dt, CURDATE( ) ) AS LOM,
						( SELECT beg_bal FROM ar_loans_subs_detail WHERE pay_period = '$lastbilling_next' AND trans_id = 9 AND member_id = A.member_id ) AS SCS,
						( SELECT zero ( SUM( rbp ) ) FROM stg_retirement_schedule WHERE TIMESTAMPDIFF( YEAR, dedn_start_dt, '$lastbilling_next' ) = yrs ) AS RBP,
						( SELECT zero ( SUM( beg_bal ) ) FROM ar_loans_subs_detail WHERE pay_period = '$lastbilling_next' AND trans_id IN ( 1, 2, 4, 13 ) AND member_id = A.member_id ) OB,

					( SELECT beg_bal FROM ar_loans_subs_detail WHERE pay_period = '$lastbilling_next' AND trans_id = 9 AND member_id = A.member_id ) + 
						( SELECT zero ( SUM( rbp ) ) FROM stg_retirement_schedule WHERE TIMESTAMPDIFF( YEAR, dedn_start_dt, '$lastbilling_next' ) = yrs ) -
						( SELECT zero ( SUM( beg_bal ) ) FROM ar_loans_subs_detail WHERE pay_period = '$lastbilling_next' AND trans_id IN ( 1, 2, 4, 13 ) AND member_id = A.member_id ) as net_stake 
					FROM
						mem_members A 
					WHERE
						company_id = '1' 
						AND member_category = '1'
						AND mem_status_id = '2'
						AND TIMESTAMPDIFF( YEAR, mem_hired_date, CURDATE( ) ) > 0
						AND TIMESTAMPDIFF( YEAR, dedn_start_dt, CURDATE( ) ) > 0
						AND ( SELECT beg_bal FROM ar_loans_subs_detail WHERE pay_period = '$lastbilling_next' AND trans_id = 9 AND member_id = A.member_id ) + 
						( SELECT zero ( SUM( rbp ) ) FROM stg_retirement_schedule WHERE TIMESTAMPDIFF( YEAR, dedn_start_dt, '$lastbilling_next' ) = yrs ) -
						( SELECT zero ( SUM( beg_bal ) ) FROM ar_loans_subs_detail WHERE pay_period = '$lastbilling_next' AND trans_id IN ( 1, 2, 4, 13 ) AND member_id = A.member_id ) <= 0";

		$queryy = $this->etbms_db->query($sqly);?>



		
		<table cellpadding="10" border="1" style="border-collapse:collapse; font-size:14px; font-family: arial narrow;">

			<tr>
				<!--<td><input type = "checkbox" onchange="checkAll()" name="email[]" value="" /></td>-->
				<td>#</td>
				<td>Company</td>
				<td>Member ID</td>
				<td>Member Name</td>
				<td>LOS</td>
				<td>SCS</td>
				<td>RBP</td>
				<td>OB</td>
				<td>Netstake</td>
				<td>Loanable Amount</td>
				<td>OL Loan Count</td>
                <td>Username</td>
				<td>Password</td>
			</tr>


		<?$ctr=1?>
		<?foreach($queryy->result() as $row):?>
			<?if($row->company_id = 1):?>
				<?if($row->LOM > 0):?>
					<?if($row->LOS > 0):?>
						<?if($row->net_stake <= 0):?>
							
							<?$query_pay_days = $this->tbms_db->query("SELECT pay_period FROM ar_loans_subs_detail
																		WHERE pay_period <= '$lastbilling'
																		AND trans_date IS NULL
																		GROUP BY pay_period
																		ORDER BY pay_period DESC
																		LIMIT 24
																		");

							$def_count = 0;

							foreach($query_pay_days->result() as $report)
							{
								$sql_check_def = $this->etbms_db->query("SELECT SUM(deferred_amount) as def
																	FROM ar_loans_subs_detail
																	WHERE pay_period = '$report->pay_period'
																	AND trans_id IN (1,2,4)
																	AND trans_type = 'PAYROLL'
																	AND member_id = $row->member_id")->row('def');

								if($sql_check_def > 0)
								{
									$def_count++;
								}

								$sql_check_def_no_trans_type = "SELECT SUM(deferred_amount) as def
																	FROM ar_loans_subs_detail A
																	LEFT JOIN ar_loans_header USING (sales_id)
																	WHERE pay_period = '$report->pay_period'
																	AND trans_id NOT IN (7,12,13)
																	AND prod_id NOT IN ('L-FS04')
																	AND collection_type = '1'
																	AND A.member_id = $row->member_id";
								$if_def_no_trans_type = $this->etbms_db->query($sql_check_def_no_trans_type)->row('def');

								if($if_def_no_trans_type > 0)	
								{
									$def_count++;
								}

							}?>
							
								<?if($def_count <= 0):?>
									<?
										$ol_loan_counter = 0;
										$sql_ol_app_count = $this->etbms_db->query("SELECT *
																				FROM ar_loans_header
																				WHERE member_id = $row->member_id
																				AND prod_id = 'O-FS01'");
										foreach($sql_ol_app_count->result() as $loan_check)
										{
											$sql_ol_loan_count = $this->etbms_db->query("SELECT * 
																						FROM ar_loans_subs_detail
																						WHERE member_id = $row->member_id
																						AND sales_id = $loan_check->sales_id
																						AND pay_period = '$lastbilling_next'");
											foreach($sql_ol_loan_count->result() as $loan_count)
											{
												if($loan_count->beg_bal > 0)
												{
													$ol_loan_counter++;
												}
											}
										}
										#echo $ol_loan_counter;
									?>
										<?if($ol_loan_counter <= 2):?>
											<?$sql_d = "SELECT * 
												FROM  stg_loanable_online 
												WHERE member_type = 3
												AND emp_levels LIKE '%$row->emp_level_id%'
												AND '$row->LOS' BETWEEN LOS_from AND LOS_to
												AND cat_id >= '7'";

											$standard_loan = $this->etbms_db->query($sql_d)->row('standard_loan');?>
											<?$sys_query = $this->db->query("SELECT * FROM telescoop_web.member_sys_access WHERE member_id = '$row->member_id'");

									        $username = '';
									        $password = '';
									        if($sys_query->num_rows() > 0){
									            $web_info = $sys_query->row();
									            $username = $web_info->username;
									            $password = $web_info->password;
									        }?>

									        
												

											<tr>

												<td><?=$ctr?></td>
												<td><?=$row->company_id?></td>
												<td><?=$row->member_id?></td>

												<td><?=$row->NAME?></td>
												<td><?=$row->LOS?></td>
												<td><?=$row->SCS?></td>
												<td><?=$row->RBP?></td>
												<td><?=$row->OB?></td>
												<td><?=$row->net_stake?></td>
												<td><?=$standard_loan?></td>
												<td><?=$ol_loan_counter?></td>
												<td><?=$username?></td>
												<td><?=$password?></td>
												<?$ctr++;?>

											</tr>
										<?endif?>
								<?endif?>
						<?endif?>
					<?endif?>
				<?endif?>
			<?endif?>		

							

		<?endforeach;?>



			<!-- <tr>
				<td align="Center" colspan="13"><a href='<?=site_url("welcome/print_xls/")?>'>
				<input type="button" name="XLS" value="Print XLS">	</a>
				</td>
			</tr> -->
		</table>




		<!--p>The page you are looking at is being generated dynamically by CodeIgniter.</p>             <input type="submit" name="submit" value="submit"/>

		<p>If you would like to edit this page you'll find it located at:</p>


		<p>The corresponding controller for this page is found at:</p>
		<code>application/controllers/welcome.php</code>

		<p>If you are exploring CodeIgniter for the very first time, you should start by reading the <a href="user_guide/">User Guide</a>.</p-->
	</div>

	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
</div>

</body>
</html>

