<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Website For Evaluation Approver</title>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script src="//code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
	<link rel="stylesheet" href="/resources/demos/style.css">
	<link rel='stylesheet' href='<?=CSS_PATH?>bootstrap.min.css' type='text/css' charset='utf-8' />
	<link rel='stylesheet' href='<?=CSS_PATH?>ace.min.css' type='text/css' charset='utf-8' />

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
	<h1>Website For Evaluation</h1>

	<div id="body">
		
		<code>Will send only to valid email address below <br>if a problem occured, kindly <u><?=mailto('guinmar.liamzon@telescoop.com.ph','Click here to mail me');?></u></code>
		<!--<h4 align="center"><?=anchor('welcome/Prints', 'Print',array('target' => '_blank'));?></h4>-->
		
		
		

		
		

		<?echo '<script>
				function reload()
				{
					window.location = "'.site_url("welcome/index").'"
				}
				</script>
				';?>

		<!-- <script>
			$(function() {
			$( "#datepicker" ).datepicker({
			dateFormat: 'yy-mm-dd',
			changeMonth: true,	
			changeYear: true
			});
			});
		</script>-->
		
			<?=form_open('welcome/index');?> 
				<!--<code ><p align="center">Date: <input type="text" id="datepicker" name="datepicker" readonly><input type="submit" name="date" value="Go"/></p></code>-->
			<?=form_close();?>

         <?=form_open('welcome/Send');?>   
		<table cellspacing="10" id="table_ledger" border=1 style="margin-left:5px;width:100%;background:white;margin-top:-10px;font-size:11px; font-family:tahoma; border-collapse:collapse " class="table table-bordered table-condensed table-hover no-footer">

			
			
			<thead style="font-size:11px">
				<tr style="font-weight:bold;">
					<td align=center><input type = "checkbox" name="email[]" value="" checked="checked" onclick="reload()"/></td>
					<!--<td><input type = "checkbox" onchange="checkAll()" name="email[]" value="" /></td>-->
					<td style="width:80px" align=center>Member ID</td>
					<td style="width:200px" align=center class="orange">Name</td>
					<td align=center class="blue">Company</td>
					<td style="width:200px" align=center class="danger red">Email</td>
					<td style="width:200px" align=center class="gray">MIS Remarks</td>
					<td align=center class="success green">Date Registered</td>
				</tr>
			</thead>

			<?$ctr=1?>
			<?$ipaddress = $_SERVER['REMOTE_ADDR']?>
			<?foreach($query->result() as $row):?>
				<tr style="font-weight:bold">
					<?$email = $row->email_add?>
						<?if(!empty($email))
						{
							echo "<td align=center><input type = 'checkbox' name='email[]' value='$ctr' checked='checked' /></td>";
						}
						else
						{
							echo "<td align=center><input type = 'checkbox' name='email[]' value='$ctr' /></td>";
						}
						?>

						<input type="hidden" name="email_<?=$ctr?>" value="<?=$row->email_add?>" />
						<input type="hidden" name="member_<?=$ctr?>" value="<?=$row->member_id?>" />
						<input type="hidden" name="ip_<?=$ctr?>" value="<?=$ipaddress;?>" />

					<?$name2 = strtoupper($row->mem_lname.', '.$row->mem_fname);?>
						
					<td align=center><?=$row->member_id;?></td>
					<td align=center><?=$name2?></td>
					<td align=center><?=$row->company_name?></td>
					<td align=center><?=$row->email_add?></td>
					<td align=center><strong><?=$row->acct_remarks?></strong></td>
					<td align=center><?=$row->date_register?></td>



				</tr>
			<?$ctr++;?>

			<?endforeach;?>
					<td align="Center" colspan="10"><input class="btn btn-xs btn-purple" type="submit" name="submit" value="submit"/></td>
					

		</table>



		<?=form_close();?>
		
		<!--p>The page you are looking at is being generated dynamically by CodeIgniter.</p>

		<p>If you would like to edit this page you'll find it located at:</p>
		

		<p>The corresponding controller for this page is found at:</p>
		<code>application/controllers/welcome.php</code>

		<p>If you are exploring CodeIgniter for the very first time, you should start by reading the <a href="user_guide/">User Guide</a>.</p-->
	</div>

	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
</div>

</body>
</html>