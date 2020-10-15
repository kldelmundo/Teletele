
	<script src="<?=JS_PATH?>sweetalert2/dist/sweetalert2.min.js"></script>
	<link rel="stylesheet" href="<?=JS_PATH?>sweetalert2/dist/sweetalert2.min.css">

	<style>
		.toggler { width: 500px; height: 200px; position: relative; }
		#button { padding: .5em 1em; text-decoration: none; }
		#effect { width: 240px; height: 135px; padding: 0.4em; position: relative; }
		#effect h3 { margin: 0; padding: 0.4em; text-align: center; }
		.ui-effects-transfer { border: 2px dotted gray; }

	#loader {
		  position: absolute;
		  left: 38%;
		  top: 70%;
		  z-index: 1;
		  width: 150px;
		  height: 150px;
		  margin: -75px 0 0 -75px;
		  border: 16px solid #f3f3f3;
		  border-radius: 50%;
		  border-top: 16px solid #3498db;
		  width: 120px;
		  height: 120px;
		  -webkit-animation: spin 2s linear infinite;
		  animation: spin 2s linear infinite;
		}

		@-webkit-keyframes spin {
		  0% { -webkit-transform: rotate(0deg); }
		  100% { -webkit-transform: rotate(360deg); }
		}

		@keyframes spin {
		  0% { transform: rotate(0deg); }
		  100% { transform: rotate(360deg); }
		}

	</style>

	<style>
		/* {box-sizing:border-box}*/

		.mySlides {display:none}

		/* Slideshow container */
		.slideshow-container {
		  max-width: 1000px;
		  position: relative;
		  margin: auto;
		}

		/* Caption text */
		.text {
		  color: #f2f2f2;
		  font-size: 15px;
		  padding: 8px 12px;
		  position: absolute;
		  bottom: 8px;
		  width: 100%;
		  text-align: center;
		}

		/* Number text (1/3 etc) */
		.numbertext {
		  color: #f2f2f2;
		  font-size: 12px;
		  padding: 8px 12px;
		  position: absolute;
		  top: 0;
		}

		/* The dots/bullets/indicators */
		.dot {
		  cursor:pointer;
		  height: 13px;
		  width: 13px;
		  margin: 0 2px;
		  background-color: #bbb;
		  border-radius: 50%;
		  display: inline-block;
		  transition: background-color 0.6s ease;
		}

		.prev, .next {
			z-index:0;
		  cursor: pointer;
		  position: absolute;
		  top: 50%;
		  width: auto;
		  margin-top: -22px;

		  padding: 16px;
		  color: white;
		  font-weight: bold;
		  font-size: 18px;
		  transition: 0.6s ease;
		  border-radius: 0 3px 3px 0;
		}

		.prev{
			 margin-left:-285px;
		}

		/* Position the "next button" to the right */
		.next {
			margin-right:10px;
		  right: 0;
		  border-radius: 3px 0 0 3px;
		}

		/* On hover, add a black background color with a little bit see-through */
		.prev:hover, .next:hover {
		  background-color: rgba(0,0,0,0.8);
		}

		.active {
		  background-color: #717171;
		}

		/* Fading animation */
		.fade {
		  -webkit-animation-name: fade;
		  -webkit-animation-duration: 1.5s;
		  animation-name: fade;
		  animation-duration: 1.5s;
		}

		@-webkit-keyframes fade {
		  from {opacity: .4}
		  to {opacity: 1}
		}

		@keyframes fade {
		  from {opacity: .4}
		  to {opacity: 1}
		}

		/* On smaller screens, decrease text size */
		@media only screen and (max-width: 300px) {
		  .text {font-size: 11px}
		}
	</style>

<?



	$name = ucwords(strtolower($row->mem_fname));

	#echo $row->lname;

	#print_r($row);

	if(!isset($_POST['answer1'])){
		$_POST['answer1'] = '';
	}
	if(!isset($_POST['conf_answer1'])){
		$_POST['conf_answer1'] = '';
	}

	if(!isset($_POST['answer2'])){
		$_POST['answer2'] = '';
	}
	if(!isset($_POST['conf_answer2'])){
		$_POST['conf_answer2'] = '';
	}
	if(!isset($_POST['answerx'])){
		$_POST['answerx'] = '';
	}

?>
<script type="text/JavaScript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script>


$(document).ready(function(){

	<?
		if(isset($_POST['item_model']) OR isset($_POST['credit_loanable'])) {
			echo "showContent('POL');";
		}
	?>

	    $('#thickbox').each(function(){
		    var url = $(this).attr('href') + '?TB_iframe=true&height=500&width=800';
		    $(this).attr('href', url);
	    });
});

function cancel_loan(online_id)
{
	swal({
		title: 'Are you sure you want to request cancellation for this Loan?',
		text: "",
		type: 'info',
		showCancelButton: true,
		cancelButtonColor: '#3085d6',
		confirmButtonColor: '#d33',
		confirmButtonText: 'Yes, Cancel it!',
		cancelButtonText: 'No, Process it'

	}).then((result) => {

		if(result.value)
		{
			showContent("loader");

			$.post("https://www.telescoop.com.ph/For_Evaluation/index.php/Welcome/test_send_cancel/",
			{online_id: online_id, ip_add:'<?=$_SERVER['REMOTE_ADDR']?>'},function(data){

				showContent("POL");

				swal(
				'Successfully cancelled!',
				'',
				'success'
				).then((result) => {

					var theForm = document.getElementById("POL_form");

					theForm.submit();
				});

			},'json');
		}

	});

}


</script>

<div id="body-left">

	<input type="hidden" id="teles_url" value="<?=site_url();?>"/>

	<div id="left-content">

		<span class="tag-title">Welcome <?=$name?>!</span>

			<div id="HoldingContainer" style="display:none;">

				<div id="home">
					<? if($is_questions_answered): ?>

						<? if($is_questions_answered2): ?>

							<center>
								<!--<img style="width:600px" src="<?=FILES_PATH?>cyberya2013.jpg" />
								<img style="width:600px" src="<?=FILES_PATH?>telescoop app.jpg" />-->

								<!--<img style="width:600px" src="<?=FILES_PATH?>rainy-final.jpg" />-->
								<!--<img style="width:600px" src="<?=FILES_PATH?>anniversarypromo.png" />-->
								<strong><font size="3.5"><a style="color:red" href="<?=FILES_PATH?>pricelist.pdf" target="_blank">(Latest Pricelist)</a></font></strong><br>
								<!--<strong><font size="3.5"><a style="color:red" href="https://docs.google.com/forms/d/e/1FAIpQLSdLZ5yksTRwAz2AOPwpF1yDtxn21J_NMmuXVqIlIHSUmD-awQ/viewform" target="_blank">(Click here to win Prizes)</a></font></strong>-->

								<!--<img style="width:600px" src="<?=FILES_PATH?>ANNOUNCMENT.jpg" />-->
							</center>
						<?else:?>
							<form action="<?=site_url($this->uri->uri_string())?>" method="POST">
							<table width="30%">


									<tr><td class="Thead" colspan="3">SECURITY QUESTION </td></tr>

									<?if(isset($msg)):?>

										<td colspan=2 align="center">
											<x style="color:red	"><?=$msg?></x>
										</td>

									<?endif;?>

									<tr>
										<td>Security Question :</td>
										<td>

											<?
											$queryq = $this->db->query("SELECT *
																       	FROM telescoop_web.member_questions
																		WHERE member_id = $member_id
																		ORDER BY RAND()
																		LIMIT 1");
											$rowq = $queryq->row('question');

											$rowq_id = $queryq->row('question_id');

											echo $rowq;

											?>
											<input type="hidden" name="question_idx" value="<?=$rowq_id;?>"/>
										</td>

									</tr>

									<tr>
										<td>Answer :</td>
										<td><input name="answerx" value="<?=$_POST['answerx'];?>" type="text" />


										</td>
									</tr>

									<tr>

										<td></td>
										<td><input type="submit" class="demo"   width="15" name="submit_answers2" value="Validate"/>

										</td>
									</tr>
							</table>
							</form>
						<?endif;?>

					<?else:?>
					<form action="<?=site_url($this->uri->uri_string())?>" method="POST">

						<table width="30%">


									<tr><td class="Thead" colspan="3">CHALLENGE QUESTIONS (Required)</td></tr>

									<?if(isset($msg)):?>

									<td colspan=2 align="center">
										<x style="color:red	"><?=$msg?></x>
									</td>

									<?endif;?>

									<style>
										x {
											color:red;
										}
									</style>

									<tr>
										<td>Challenge Question #1</td>
										<td>
											<select name="question1" onchange="submit()">
											<?
												$queryq = $this->db->get("telescoop_web.challenge_questions");
												echo '<option value="0">Choose One</option>';

												foreach($queryq->result() as $row)
												{
													if($_POST['question1'] == $row->question_id)
													{
														echo '<option value="'.$row->question_id.'" selected>'.$row->question.'</option>';
													}else{
														echo '<option value="'.$row->question_id.'">'.$row->question.'</option>';
													}

												}

											?>
											</select>
										</td>

									</tr>

									<tr>
										<td>Answer :</td>
										<td><input name="answer1" value="<?=$_POST['answer1']?>" type="password"  />

										</td>
									</tr>
									<tr>
										<td>Confirm Answer :</td>
									<td><input name="conf_answer1" value="<?=$_POST['conf_answer1']?>" type="password"  />
									<span class="sidetip" style="display: none;">Please confirm your answer.</span>

										</td>
									</tr>

									<tr>
										<td>Challenge Question #2</td>
										<td>

											<select name="question2" onchange="submit()">
											<?
											$queryq = $this->db->get("telescoop_web.challenge_questions");
											echo '<option value="0">Choose One</option>';
											foreach($queryq->result() as $row)
											{
												if($_POST['question2'] == $row->question_id)
												{
													echo '<option value="'.$row->question_id.'" selected>'.$row->question.'</option>';
												}else{
													echo '<option value="'.$row->question_id.'">'.$row->question.'</option>';
												}
											}
											?>
											</select>
										</td>

									</tr>

									<tr>
										<td>Answer :</td>
										<td><input name="answer2" value="<?=$_POST['answer2'];?>" type="password"  />

										</td>
									</tr>
									<tr>
										<td>Confirm Answer :</td>
									<td><input name="conf_answer2" value="<?=$_POST['conf_answer2'];?>" type="password" />
									<span class="sidetip" style="display: none;">Please confirm your answer.</span>

										</td>
									</tr>


									<tr>

										<td></td>
										<td><input type="submit" class="demo"  width="15" name="submit_answers" onclick="return confirm('Are you sure you want to continue?')" value="Submit"/>

										</td>
									</tr>
								</table>
					</form>
					<?endif;?>
				</div>


				<div id="notify">
					<center>
					<input type='hidden' name='redirect_page' value=''/>
					<?=form_open('account/notification');?>
						<? $row = $this->m_account->get_member_info(); ?>
					<table style="width:65%;margin:auto;font-size:11px;">
						<tr>
							<td class="Thead" colspan=2>Notification Settings</td>
						</tr>
							<tr>
								<td>Email Address:</td>
								<td><input style="width:200px" required type="text" name="email_add" value="<?=$row->email_add?>" /></td>

							</tr>
							<tr>
							<td>Mobile #:</td>

							<? if($row->is_notify_sms == 1)
							   {
							   		$checked = 'checked';
							   }else{
							   		$checked = '';
							   }
							?>
								<td> <strong style="font-size:13px">+639</strong> <input type="text" style="width:110px" required value="<?=substr($row->mobile_no,-9)?>" name="mobile_no">&nbsp;&nbsp;<input type="checkbox" name="is_notify_sms" <?=$checked?> title="Notify me via mobile" /> <x style="font-size:10px;" >notify me via mobile</x></td>
							</tr>
							<td>&nbsp;</td>
								<td align="right"><input type="submit" value="Update record"></td>
							</tr>

					</table>
					<?=form_close();?>
					</center>
				</div>


				<div id="new_loans">

					<table style="width:100%;margin:auto;font-size:10px;">
						<tr>
							<td class="Thead" colspan=8 align=center><strong>Newly Applied Loans</strong></td>
						</tr>
						<tr>
							<td class="Thead" width="2%" >#</td>
							<td class="Thead">DATE APPLIED</td>
							<td class="Thead">LOAN TYPE</td>
							<td class="Thead">DR NUMBER</td>

							<td class="Thead" align="right">GROSS AMT</td>
							<td class="Thead" align="right">NET AMT</td>
							<td class="Thead" align="center">STATUS</td>
							<!--td class="Thead" align="center">ACTION</td-->
						</tr>

						<?
						$ctr=1;
						foreach($row_new_loans->result() as $rowx):?>


							<tr>
							<td><?=$ctr++?></td>

							<td><?=$rowx->po_date?></td>
							<td><?=$rowx->prod_name?></td>
							<td><?=$rowx->dr_number?></td>

							<td align="right"><?=number_format($rowx->gross_amount,2)?></td>
							<td align="right"><?=number_format($rowx->net_proceeds,2)?></td>

						<?if($rowx->po_order_status == 'disapproved'):?>
							<td align="center">Disapproved</td>
						<?elseif($rowx->po_order_status == 'cancelled'):?>
							<td align="center">Cancelled</td>
						<?else:?>
							<?if($rowx->po_order_status != 'approved'):?>
								<td align="center">For Processing</td>
							<?elseif($rowx->po_order_status == 'approved'):?>
							<?#APPROVED NA. check if released in check,debit memo. then display as approved.?>
								<?echo '<td align="center">'.$rowx->release_status.'</td>';?>
							<?endif?>
						<?endif?>

							<!--td>
								<div  onmouseover="this.style.cursor='pointer';" onclick="alert('Under Construction!')" >
									<img src="<?=IMAGE_PATH?>printer.png" style="float:left; margin-top:-4px;width:20px"/> 	&nbsp;&nbsp; <strong>Print</strong>
								</div>
							</td-->

						</tr>
						<?endforeach;?>

					</table>
				</div>

				<div id="loader"></div>

				<div id="POL">
				<form id="POL_form" action="<?=site_url($this->uri->uri_string())?>" method="POST">
					<table>
						<tr>
							<td class="Thead" colspan=6>TELESCOOP ONLINE LOAN APPLICATION - NO COMAKER REQUIRED!!! </td>
							</tr>
							<tr>
								<td><strong>MEMBER NAME:</strong></td>
								<td colspan=3 style="font-size:13px"><?=strtoupper($row->mem_lname.', '.$row->mem_fname.' '.$row->mem_mname);?></td>

							</tr>
						<tr>

						<!--tr>
							<td><strong>BIRTH DATE:</strong></td>
							<td>	<?=date('F j, Y',strtotime($row->mem_bday));?></td>
							<td><strong>DATE HIRED:</strong></td>
							<td>	<?=date('F j, Y',strtotime($row->mem_hired_date));?></td>
						</tr>

						<tr>
							<td><strong>LOCATION:</strong></td>
							<td><?=$row->mem_location?></td>
							<td><strong>DEPARTMENT:</strong></td>
							<td><?=$row->department_name?></td>
						</tr-->

						<tr>
							<td><strong>CREDIT AVAILABLE:</strong></td>
							<? $loanable = $this->m_account->get_loanable_amount_online($row->member_id);?>
							<input type="hidden" type="text" value="<?=$loanable['loanable_amt']?>" name="credit_loanable"/>
							<td style="font-weight:bold; color:green; font-size:12px;">Php <?=number_format($loanable['loanable_amt'],2);?> <small style='color:black'>(<em><strong>As of: <?=date('F j, Y')?>) </strong></em> </small></td>

							<? if($loanable['loanable_amt'] > 0):?>
							<td colspan=2>
								<button style="cursor:pointer; background: none;color: inherit;border: none;padding: 0;font: inherit;outline: inherit;" onclick="javascript: window.open('<?=site_url('account/avail_now/')?>', 'avail_now', 'scrollbars=1,menubar=0, resizable=0, height=650, width=600'); return false; ">
								<img src="<?=IMAGE_PATH?>button_apply-financial-loan.png" />
								</button>
								<!--button> &nbsp;View Loans Availed&nbsp; </button-->
							</td>
							<?endif?>
						</tr>

					</table>

					<?
						$sql_ol = "SELECT *
								   FROM ar_loans_online_header
								   LEFT JOIN ar_loans_online_detail USING(online_id)
								   WHERE member_id = $row->member_id
								   AND po_order_status = 'pending'
								   #AND valid_until > NOW()";
						$query_ol = $this->etbms_db->query($sql_ol);
					?>

					<?if($query_ol->num_rows() > 0):?>

						<br>


						<span class="tag-title">Pending for confirmation:</span>
						<br>
						<table>
							<tr>
								<td class="Thead">#</td>
								<td class="Thead" align="center">Loan&nbsp;ID</td>
								<td class="Thead">Category</td>
								<td class="Thead">Amount</td>
								<td class="Thead">Valid Until</td>
								<td class="Thead">Email Verification Key</td>
							</tr>

							<?
							$ctr = 1;

							foreach($query_ol->result() as $row_ol):?>

							<script>
							// Set the date we're counting down to
							var countDownDate_<?=$ctr?> = new Date("<?=date('M j, Y H:i:s',strtotime($row_ol->valid_until))?>").getTime();

							//timeAfterMins_<?=$ctr?> = new Date(countDownDate_<?=$ctr?>.setMinutes(countDownDate_<?=$ctr?>.getMinutes() + 30));

							//alert(timeAfterMins_<?=$ctr?>);

							// Update the count down every 1 second
							var x_<?=$ctr?> = setInterval(function()
							{

								// Get todays date and time
								var now_<?=$ctr?> = new Date().getTime();

								// Find the distance between now an the count down date
								var distance_<?=$ctr?> = countDownDate_<?=$ctr?> - now_<?=$ctr?>;

								// Time calculations for days, hours, minutes and seconds
								var days_<?=$ctr?> = Math.floor(distance_<?=$ctr?> / (1000 * 60 * 60 * 24));
								var hours_<?=$ctr?> = Math.floor((distance_<?=$ctr?> % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
								var minutes_<?=$ctr?> = Math.floor((distance_<?=$ctr?> % (1000 * 60 * 60)) / (1000 * 60));
								var seconds_<?=$ctr?> = Math.floor((distance_<?=$ctr?> % (1000 * 60)) / 1000);

								// Display the result in the element with id="demo"  days_<?=$ctr?> + "d " + hours_<?=$ctr?> + "h "
								document.getElementById("demo_<?=$ctr?>").innerHTML = "<x style='color:green'>" + minutes_<?=$ctr?> + "m " + seconds_<?=$ctr?> + "s </x>";

								// If the count down is finished, write some text
								if (distance_<?=$ctr?> < 0)
								{
									clearInterval(x_<?=$ctr?>);
									document.getElementById("demo_<?=$ctr?>").innerHTML = "<x style='color:red'>EXPIRED<x>";
									$("#valid_key_<?=$ctr?>").attr("disabled", "disabled");
									$("#conf_btn_<?=$ctr?>").attr("disabled", "disabled");

									//auto cancelled via post

									var online_id = <?=$row_ol->online_id?>;

									$.post("<?=site_url('account/cancelled_expired')?>",
									{online_id: online_id},function(data){},'json');
								}


							}, 1000);
							</script>


							<tr>
								<td style="color:black; font-weight:bold"><?=$ctr?></td>
								<td style="color:black; font-weight:bold" align="center"><?=setLength($row_ol->online_id)?></td>
								<td style="color:blue; font-weight:bold"><?=$row_ol->prod_id=='O-FS01'?'FINANCIAL':'GADGET '?></td>
								<td style="font-weight:bold; color:black;">Php <?=number_format($row_ol->actual_amount,2)?></td>
								<td align="center" id="demo_<?=$ctr?>"></td>
								<td>
									<input id="valid_key_<?=$ctr?>" style='width:150px' type="text" placeholder=" --ENTER KEY HERE-- ">
									<button id="conf_btn_<?=$ctr?>" style="cursor:pointer" onclick="check_validation_key(<?=$ctr++?>); return false;"> &nbsp;Confirm&nbsp; </button>
									<?if($row_ol->prod_id=='O-FS01'):?>
									<button style="cursor:pointer" onclick="javascript: window.open('<?=site_url('account/view_fin_loan/'.$row_ol->online_id)?>', 'view_loan', 'scrollbars=1,menubar=0, resizable=0, height=650, width=500'); return false;" > &nbsp;View&nbsp; </button>
									<?else:?>
									<button style="cursor:pointer" onclick="javascript: window.open('<?=site_url('account/view_gadget_loan/'.$row_ol->item_detail_id)?>', 'view_loan', 'scrollbars=1,menubar=0, resizable=0, height=580, width=520'); return false;" > &nbsp;View&nbsp; </button>
									<?endif?>
								</td>
							</tr>
							<?endforeach?>
						</table>
						<br>

					<?endif?>

					<?
						$sql_ol = "SELECT *
								   FROM ar_loans_online_header
								   LEFT JOIN ar_loans_online_detail USING(online_id)
								   WHERE member_id = $row->member_id
								   AND po_order_status IN ('confirmed','processing')
								   ";
						$query_ol = $this->etbms_db->query($sql_ol);
					?>

					<?if($query_ol->num_rows() > 0):?>

						<br>


						<span class="tag-title">Active Loan for processing:</span>
						<br>
						<table>
							<tr>
								<td class="Thead">#</td>
								<td class="Thead" align="center">Loan&nbsp;ID</td>
								<td class="Thead" align="center">Datetime</td>
								<td class="Thead">Category</td>
								<td class="Thead">Amount</td>
								<td class="Thead" align="center">Time/Status</td>
								<td class="Thead" align="center">Action</td>
							</tr>

							<?
							$ctr = 1;

							foreach($query_ol->result() as $row_ol):?>

							<script>
							// Set the date we're counting down to
							var XcountDownDate_<?=$ctr?> = new Date("<?=date('M j, Y H:i:s',strtotime($row_ol->cancel_until))?>").getTime();

							//timeAfterMins_<?=$ctr?> = new Date(countDownDate_<?=$ctr?>.setMinutes(countDownDate_<?=$ctr?>.getMinutes() + 30));

							//alert(timeAfterMins_<?=$ctr?>);

							// Update the count down every 1 second
							var Xx_<?=$ctr?> = setInterval(function() {

							// Get todays date and time
							var Xnow_<?=$ctr?> = new Date().getTime();

							// Find the distance between now an the count down date
							var Xdistance_<?=$ctr?> = XcountDownDate_<?=$ctr?> - Xnow_<?=$ctr?>;

							// Time calculations for days, hours, minutes and seconds
							var Xdays_<?=$ctr?> = Math.floor(Xdistance_<?=$ctr?> / (1000 * 60 * 60 * 24));
							var Xhours_<?=$ctr?> = Math.floor((Xdistance_<?=$ctr?> % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
							var Xminutes_<?=$ctr?> = Math.floor((Xdistance_<?=$ctr?> % (1000 * 60 * 60)) / (1000 * 60));
							var Xseconds_<?=$ctr?> = Math.floor((Xdistance_<?=$ctr?> % (1000 * 60)) / 1000);

							// Display the result in the element with id="demo"  days_<?=$ctr?> + "d " + hours_<?=$ctr?> + "h "
							document.getElementById("Xdemo_<?=$ctr?>").innerHTML = "<x style='color:green'>" + Xminutes_<?=$ctr?> + "m " + Xseconds_<?=$ctr?> + "s </x>";

							// If the count down is finished, write some text
							if (Xdistance_<?=$ctr?> < 0) {
								clearInterval(Xx_<?=$ctr?>);
								document.getElementById("Xdemo_<?=$ctr?>").innerHTML = "<x style='color:green'>PROCESSING<x>";

							}
							}, 1000);
							</script>


							<tr>
								<td style="color:black; font-weight:bold"><?=$ctr?></td>
								<td style="color:black; font-weight:bold" align="center"><?=setLength($row_ol->online_id)?></td>
								<td style="color:black; font-weight:bold" align="center"><?=date('M j g:ia',strtotime($row_ol->created_date))?></td>
								<td style="color:blue; font-weight:bold"><?=$row_ol->prod_id=='O-FS01'?'FINANCIAL':'GADGET '?></td>
								<td style="font-weight:bold; color:black;">Php <?=number_format($row_ol->actual_amount,2)?></td>
								<td align="center" id="Xdemo_<?=$ctr++?>"></td>
								<td align="center">
									<?if($row_ol->po_order_status == 'processing'):?>

										<?if($row_ol->prod_id=='O-FS01'):?>
										<button style="cursor:pointer" onclick="javascript: window.open('<?=site_url('account/view_fin_loan/'.$row_ol->online_id)?>', 'view_loan', 'scrollbars=1,menubar=0, resizable=0, height=650, width=500'); return false;" > &nbsp;View&nbsp; </button>
										<?else:?>
										<button style="cursor:pointer" onclick="javascript: window.open('<?=site_url('account/view_gadget_loan/'.$row_ol->item_detail_id)?>', 'view_loan', 'scrollbars=1,menubar=0, resizable=0, height=580, width=520'); return false;" > &nbsp;View&nbsp; </button>
										<?endif?>

									<?else:?>
									<button style="cursor:pointer" onclick="cancel_loan(<?=$row_ol->online_id?>); return false;"> &nbsp;Request to cancel&nbsp; </button>

										<?if($row_ol->prod_id=='O-FS01'):?>
										<button style="cursor:pointer" onclick="javascript: window.open('<?=site_url('account/view_fin_loan/'.$row_ol->online_id)?>', 'view_loan', 'scrollbars=1,menubar=0, resizable=0, height=650, width=500'); return false;" > &nbsp;View&nbsp; </button>
										<?else:?>
										<button style="cursor:pointer" onclick="javascript: window.open('<?=site_url('account/view_gadget_loan/'.$row_ol->item_detail_id)?>', 'view_loan', 'scrollbars=1,menubar=0, resizable=0, height=580, width=520'); return false;" > &nbsp;View&nbsp; </button>
										<?endif?>

									<?endif?>
								</td>
							</tr>
							<?endforeach?>
						</table>
						<br>

					<?endif?>

					<? if($loanable['loanable_amt'] > 0):?>

						<!--span class="tag-title">Apply Financial Loan:</span>
						<br>
						<table>
							<tr>
								<td class="Thead">#</td>
								<td class="Thead">PO Name</td>
								<td class="Thead" align="center">Loanable Amount</td>
								<td class="Thead" align="center">Action</td>
							</tr>

							<tr>
								<td style="color:black; font-weight:bold">1</td>
								<td style="color:blue; font-weight:bold">ONLINE FINANCIAL LOAN</td>
								<td  style="font-weight:bold; color:black;" align="center">Up to <?=number_format($loanable['loanable_amt'],2)?></td>
								<td align="center">


								</td>
							</tr>
						</table-->

						<br>
							<?
							$sql_item_m = "SELECT *
										   FROM (
												SELECT item_detail_id,item_id, inv_po_header.date_received,inv_item_detail.item_flag,
												agent_name,item_short_desc,item_long_desc,inv_req_trans_no,inv_req_date
												,inv_req_exchange,serial_series,color,inv_item_detail.unit_cost as u_cost,
												inv_item_requisition_d.qty as qty_a,inv_item_detail.acq_cost,specs
												FROM inv_item_requisition_h
												LEFT JOIN inv_item_requisition_d USING(inv_req_trans_no)
												LEFT JOIN inv_item_detail USING(item_detail_id)
												LEFT JOIN inv_po_header USING (order_id)
												LEFT JOIN inv_prod_items USING(item_id)
												LEFT JOIN stg_sales_agent USING(agent_id)
												WHERE item_detail_id IS NOT NULL AND inv_item_detail.status LIKE '%assigned%'
												AND inv_item_requisition_d.return_number IS NULL
												AND inv_item_detail.item_flag != 'series'
												AND agent_id = 30


												UNION ALL

												SELECT item_detail_id,item_id,inv_po_header.date_received,inv_item_detail.item_flag,agent_name,item_short_desc,item_long_desc,inv_req_trans_no,inv_req_date,
												inv_req_exchange,serial_series,color,inv_item_detail.unit_cost as u_cost,
												inv_item_requisition_d.qty as qty_a,inv_item_detail.acq_cost,specs
												FROM inv_item_requisition_h
												LEFT JOIN inv_item_requisition_d USING(inv_req_trans_no)
												LEFT JOIN inv_item_detail USING(item_detail_id)
												LEFT JOIN inv_po_header USING (order_id)
												LEFT JOIN stg_sales_agent USING(agent_id)
												LEFT JOIN inv_prod_items USING(item_id)
												WHERE inv_item_detail.item_flag = 'series'
												AND inv_item_detail.status LIKE '%assigned%'
												AND inv_item_requisition_d.return_date IS NULL
												AND agent_id = 30
												GROUP BY item_short_desc
											) X
										WHERE X.u_cost <= {$loanable['loanable_amt']}
										AND X.item_detail_id NOT IN (
																	  SELECT item_detail_id
																	  FROM ar_loans_online_detail
																	  LEFT JOIN ar_loans_online_header USING(online_id)
																	  WHERE po_order_status IN ('confirmed','pending')
																	)
										#exclude pending GADGETS
										GROUP BY X.item_short_desc";
							#echo $sql_item_m;
							$query_model = $this->etbms_db->query($sql_item_m);

							?>
							<span class="tag-title">Gadget Loan: </span>
							<br>

							<table>

							<tr>
								<td style="width:10px" align="center" class="Thead">#</td>
								<td class="Thead" width="260px">

									ITEM MODEL

									<x style="float:right">
									<select name="item_model" onchange="submit()">
										<option value=''>ALL</option>
										<?foreach($query_model->result() as $row_model):?>
										<? if($_POST['item_model'] == $row_model->item_short_desc):?>
										<option selected value='<?=$row_model->item_short_desc?>'><?=$row_model->item_short_desc?></option>
										<? else:?>
										<option value='<?=$row_model->item_short_desc?>'><?=$row_model->item_short_desc?></option>
										<?endif?>
										<?endforeach?>
									</select>
									</x>
								</td>
								<td style="width:23px" class="Thead" align="center">SPECS</td>
								<td style="width:23px" class="Thead" align="center">UNIT COST</td>
								<td style="width:85px" class="Thead" align="center">ACTION</td>
							</tr>
						<?
						$where = '';
							if(isset($_POST['item_model']) AND !empty($_POST['item_model'])) {
								$where = " AND X.item_short_desc = '{$_POST['item_model']}' ";
							}
						$sql_item = "SELECT * FROM (
										SELECT item_detail_id,item_id, inv_po_header.date_received,inv_item_detail.item_flag,
										agent_name,item_short_desc,item_long_desc,inv_req_trans_no,inv_req_date
										,inv_req_exchange,serial_series,color,inv_item_detail.unit_cost as u_cost,
										inv_item_requisition_d.qty as qty_a,inv_item_detail.acq_cost,specs
										FROM inv_item_requisition_h
										LEFT JOIN inv_item_requisition_d USING(inv_req_trans_no)
										LEFT JOIN inv_item_detail USING(item_detail_id)
										LEFT JOIN inv_po_header USING (order_id)
										LEFT JOIN inv_prod_items USING(item_id)
										LEFT JOIN stg_sales_agent USING(agent_id)
										WHERE item_detail_id IS NOT NULL AND inv_item_detail.status LIKE '%assigned%'
										AND inv_item_requisition_d.return_number IS NULL
										AND inv_item_detail.item_flag != 'series'
										AND agent_id = 30


										UNION ALL

									  	SELECT item_detail_id,item_id,inv_po_header.date_received,inv_item_detail.item_flag,agent_name,item_short_desc,item_long_desc,inv_req_trans_no,inv_req_date,
									  	inv_req_exchange,serial_series,color,inv_item_detail.unit_cost as u_cost,
									  	inv_item_requisition_d.qty as qty_a,inv_item_detail.acq_cost,specs
									  	FROM inv_item_requisition_h
									  	LEFT JOIN inv_item_requisition_d USING(inv_req_trans_no)
								      	LEFT JOIN inv_item_detail USING(item_detail_id)
									  	LEFT JOIN inv_po_header USING (order_id)
								      	LEFT JOIN stg_sales_agent USING(agent_id)
								      	LEFT JOIN inv_prod_items USING(item_id)
									  	WHERE inv_item_detail.item_flag = 'series'
									  	AND inv_item_detail.status LIKE '%assigned%'
									  	AND inv_item_requisition_d.return_date IS NULL
									  	AND agent_id = 30

								  	GROUP BY inv_req_trans_no,item_id
								  	) X

								  	WHERE X.u_cost <= {$loanable['loanable_amt']}
								  	$where
									AND X.item_detail_id NOT IN (
																	SELECT item_detail_id
																	FROM ar_loans_online_detail
																	LEFT JOIN ar_loans_online_header USING(online_id)
																	WHERE po_order_status IN ('confirmed','pending')
																)
								  	#GROUP BY X.item_id
							 		ORDER BY X.u_cost,X.date_received";

							$query = $this->etbms_db->query($sql_item);
							$ctr = 1;
							foreach($query->result() as $row_item): ?>
								<tr>
									<td align="center" style="color:black; font-weight:bold"><?=$ctr++?></td>
									<td >
										<x style="font-weight:bold; color:blue"><?=strtoupper($row_item->item_short_desc.'-'.$row_item->item_long_desc)?>  </x>
										<br>
										<small><strong>S/N:</strong> <?=$row_item->serial_series?> <strong>COLOR:</strong> <?=strtoupper($row_item->color)?></small>

									</td>
									<td style="color:red" align="center">
										<? if(!empty($row_item->specs)): ?>
										<a onclick="javascript: window.open('<?=$row_item->specs?>', 'gsmarena', 'scrollbars=1,menubar=0, resizable=0, height=650, width=1080');" href="#">SEE&nbsp;SPECS</a>
										<? else:?>
										N/A
										<?endif?>
									</td>
									<td style="font-weight:bold; color:black" align="center">Php&nbsp;<?=number_format($row_item->u_cost,2)?></td>

									<td align="center">
										<button style="cursor:pointer; background: none;color: inherit;border: none;padding: 0;font: inherit;outline: inherit;" onclick="javascript: window.open('<?=site_url('account/avail_gadget_now/'.$row_item->item_detail_id)?>', 'avail_now_gadget', 'scrollbars=1,menubar=0, resizable=0, height=600, width=550'); return false; ">
										<img src="<?=IMAGE_PATH?>button_avail-now.png" />
										</button>

									</td>
								</tr>
								<!--tr>

									<td align="center">
										 <a onclick="javascript: window.open('https://www.google.com/search?tbm=isch&q=<?=str_replace(' ','+',$row_item->item_short_desc.'+'.$row_item->item_long_desc)?>', 'printable1', 'scrollbars=1,menubar=0, resizable=0, height=650, width=1005');" href="#">VIEW IMAGES</a> </td>
								</tr-->
							<?endforeach;?>

							<?if($query->num_rows() == 0):?>
								<tr>
									<td align="center" colspan=5>NO AVAILABLE ITEMS</td>
								</tr>
							<?endif?>

						</table>
						</form>
					<?endif?>
				</div>

				<div id="profile">

					<table>
						<tr>
							<td class="Thead" colspan=6>My Profile Information</td>
							</tr>
							<tr>
								<td><strong>NAME:</strong></td>
								<td colspan=2 style="font-size:13px"><?=strtoupper($row->mem_lname.', '.$row->mem_fname.' '.$row->mem_mname);?></td>
								<td>
									<strong>MEMBER ID: &nbsp;</strong> <?=setLength($row->member_id)?>
									<input type="hidden" id="member_id" value="<?=$row->member_id?>"/>
								</td>
							</tr>
						<tr>
						<?$id_no = $row->mem_emp_id;
							$level = $row->emp_level;
							?>
								<td><strong>COMPANY ID#:</strong></td>
								<td><?=$id_no;?></td>
								<td><strong>EMP LEVEL:</strong></td>
								<td><?=$level;?></td>
								<!--td><strong>POSITION:</strong></td>
								<td><?=$row->position?></td-->
							</tr>
							<!--tr>
								<td><strong>LOCATION:</strong></td>
								<td><?=$row->mem_location?></td>
								<td><strong>DEPARTMENT:</strong></td>
								<td><?=$row->department_name?></td>
							</tr-->
							<tr>
								<td><strong>DATE HIRED:</strong></td>
								<td><?=date('F j, Y',strtotime($row->mem_hired_date));?></td>
								<td><strong>TELEPHONE#:</strong></td>
								<td><?=$row->mem_telno?></td>
							</tr>

							<tr>
								<td><strong>BIRTH DATE:</strong></td>
								<td>	<?=date('F j, Y',strtotime($row->mem_bday));?></td>
								<td><strong>FIRST DEDUCTION:</strong></td>
								<td>	<?=date('F j, Y',strtotime($row->dedn_start_dt));?></td>
							</tr>

							<tr>
								<td><strong>ADDRESS:</strong></td>
								<td colspan=4><?=$row->mem_address;?></td>
							</tr>

					</table>

					<table>
						<tr>
							<td class="Thead" colspan=6>Beneficiaries</td>
							</tr>
							<tr>
								<td class="Thead" >#</td>
								<td class="Thead" >Name of Beneficiaries</td>
								<td class="Thead" >Relationship</td>
								<td class="Thead" >Date of Birth</td>
							</tr>

							<? $ctr=1; foreach($row_dep as $row2):?>
							<tr>
								<td><?=$ctr++?></td>
								<td><?=$row2->ben_lname?>, <?=$row2->ben_fname?></td>
								<td><?=$row2->rel_desc?></td>
								<td><?=date('F j, Y',strtotime($row2->beneficiary_bday));?></td>
							</tr>

							<?endforeach;?>
							<?if(count($row_dep) == 0):?>
							<tr>
								<td colspan=4 align=center><center>NO BENEFICIARY FOUND.</center></td>

							</tr>
							<?endif;?>

					</table>
				</div>

				<div id="savings">
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
						<small><strong>TELESCOOP Savings Deposit</strong> earns interests at an average
						of 5% per annum, with the following bracket: (first 1M - 5%; 2nd 1M - 4%; balance - 3%)
						compounded monthly and payable every 1st day of the following month based on lowest balance
						of the previous month.
						 <a style="color:red" href="<?=FILES_PATH?>Interest rate.jpg" target="_blank">(click here for more info)</a>
						</small>
					</div>

			</form>
				</div>


				<div id="x">
					<table style="width:70%;margin:auto;font-size:12px;">

						<?if(count($row_dividend)==0):?>
							<br>
							<br>
							<br>
							<tr>
								<td colspan=2 align=center><strong>NO DIVIDEND FOUND.</strong></td>
							</tr>
						<?else:?>

						<tr>
							<td class="Thead" colspan=2 align=center><strong>For the Dividend Year 2018</strong></td>
						</tr>
						<tr>
							<td>Interest on Share Capital:</td>
 							<td align="right"><?=number_format($row_dividend->int_capital,2)?></td>
						</tr>

						<tr>
							<td>Patronage Refund:</td>
							<td align="right"><?=number_format($row_dividend->Patronage,2)?></td>
						</tr>

						<tr>
							<td><strong>TOTAL:</strong></td>
							<td align="right"><?=number_format($row_dividend->Total,2)?></td>
						</tr>

						<tr>
							<td>LESS: Applied to Deferred Accounts:</td>

							<?if(empty($row_dividend->Deduct) OR $row_dividend->Deduct == ' ')
							  {
							  	 $deduct = 0;
							  }
							  else{
							  	$deduct = $row_dividend->Deduct;
							  }
							?>

							<td align="right"><?=number_format($deduct,2)?></td>
						</tr>

						<tr>
							<td><strong>NET AMOUNT:</strong></td>
							<td align="right"><strong>PHP <?=number_format($row_dividend->NET_Dividend,2)?></strong></td>
						</tr>
						<?endif;?>
					</table>
				</div>

				<div id="pwd">

					<p></p>
					<p>
						<?=form_open('account/change_password');?>
						<table>
							<tr>
								<td class="Thead" colspan=2>Change Password</td>
							</tr>
							<tr>
								<td>Username:</td>
								<td><input type="text" name="username" readonly value="<?=$this->session->userdata('username')?>"/></td>
							</tr>

							<tr>
								<td>Current Password:</td>
								<td><input type="password" id="old_pwd" name="old_pwd"/></td>
							</tr>

							<tr>
								<td>New Password:</td>
								<td><input type="password" id="new_pwd" name="new_pwd"/></td>
							</tr>

							<tr>
								<td>Confirm New Password:</td>
								<td><input type="password" id="conf_new_pwd" name="conf_new_pwd"/></td>
							</tr>

							<tr>
								<td>&nbsp;</td>
								<td><input type="submit" name="submit" value="Submit"/></td>
							</tr>
						</table>
						<?=form_close();?>
					</p>
				</div>

				<div id="inq">

					<p></p>
					<p>

						<script>
						function myFunction()
						{
						   ok = confirm("Press Ok to send your inquiry");
						   if(ok == false)
						   {
						   	return false;
						   }

						}
						</script>

						<?=form_open('account/submit_inquiry');?>
						<table>
							<tr>
								<font color= "red" ><h3>NOTE: Chat feature is best used using internet access outside of PLDT Intranet</h3><br></font>
								<td class="Thead" colspan=2>Inquiry Form</td>
							</tr>
							<tr>
								<td>Title:</td>
								<!--<td><input type="text" id="title" style="width:250px" value="" name="title"/></td>-->
								<td><select name="title" id="title">
										<option value="4">Application for New / Termination of Membership</option>
										<option value="3">Direct Selling Loans / Promo Loans / Pricelist</option>
										<option value="1">Loan Computation / Account Balance</option>
										<option value="2">Savings Deposit / Withdrawal / Balance</option>
										<option value="6">Comments & Suggestion</option>
										<option value="5">Others</option>

								</select></td>
							</tr>

							<tr>
								<td>Message:</td>
								<td><textarea name="msg" id="message" rows="6" cols="40"> </textarea></td>
							</tr>

							<tr>
								<td>&nbsp;</td>
								<td>

									<input type="submit" id="inq_send" name="inq_send" onclick="return myFunction()" value="Send"/>
									<input type="submit" id="cancel_send" name="cancel_send" value="Cancel"/>

								</td>
							</tr>

						</table>

						<!--<table>
							<tr>
								<td class="Thead"><h1><center>For Inquiry</center></h1></td>
							</tr>
							<tr>
								<td></td>
							</tr>
							<tr>
								<td><h2><center>Please use our Telescoop Live Chat!</center></h2></td>
							</tr>
							<tr>
								<td><h2><center>THANK YOU</center></h2></td>
							</tr>
						</table>-->

						<?=form_close();?>
					</p>

				</div>

		</div>

			<br>

		<div id="DisplayContainer">
			<div id="home">
				<center>
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

						<? if($is_questions_answered): ?>
							<? if($is_questions_answered2): ?>
								<?$path=$_SERVER["DOCUMENT_ROOT"];?>
								<center>
									<!--<img style="width:600px" src="<?=FILES_PATH?>cyberya2013.jpg" />
									<img style="width:600px" src="<?=FILES_PATH?>telescoop app.jpg" />-->

									<div class="slideshow-container" style="max-width:1000px;min-width:250px;position:relative;margin:auto;">
										
											    <!--<div class="numbertext">1 / 7</div>
												    <a href="http://www.telescoop.com.ph/assets/images/ads/YEM-cut.jpg" target="_blank"><img src="<?=IMAGE_PATH?>ads/YEM-cut.jpg" style="width:100%"></a>
												    <div class="text"></div>
											  	</div>-->

											<?$today = date("Y-m-d");?>
											<?$ded_line = "2020-01-10";?>
									  		<?if($today <= $ded_line):?>
											  	

											  <div class="mySlides fade">
												    <div class="numbertext"></div>
												    <a href="http://www.telescoop.com.ph/assets/images/ads/orig/1.jpg" target="_blank"><img src="<?=IMAGE_PATH?>ads/Scheduled/1.jpg" style="width:100%"></a>
												    <div class="text"></div>
												  </div>

									  			<div class="mySlides fade">
												    <div class="numbertext"></div>
												    <a href="http://www.telescoop.com.ph/assets/images/ads/1-20181012.jpg" target="_blank"><img src="<?=IMAGE_PATH?>ads/1-20181012.jpg" style="width:100%"></a>
												    <div class="text"></div>
												  </div>

												  <div class="mySlides fade">
												    <div class="numbertext"></div>
												    <a href="http://www.telescoop.com.ph/assets/images/ads/2-20181012.jpg" target="_blank"><img src="<?=IMAGE_PATH?>ads/2-20181012.jpg" style="width:100%"></a>
												    <div class="text"></div>
												  </div>

												  <div class="mySlides fade">
												     <div class="numbertext"></div>
												    <a href="http://www.telescoop.com.ph/assets/images/ads/Gridpoint.JPG" target="_blank"><img src="<?=IMAGE_PATH?>ads/Gridpoint.JPG" style="width:100%"></a>
												    <div class="text"></div>
												  </div>

												  <div class="mySlides fade">
												     <div class="numbertext"></div>
												    <a href="http://www.telescoop.com.ph/assets/images/ads/4-20181012.jpg" target="_blank"><img src="<?=IMAGE_PATH?>ads/4-20181012.jpg" style="width:100%"></a>
												    <div class="text"></div>
												  </div>


												  <div class="mySlides fade">
												    <div class="numbertext"></div>
												    <a href="http://www.telescoop.com.ph/assets/images/ads/Originals/3.jpg" target="_blank"><img src="<?=IMAGE_PATH?>ads/3.jpg" style="width:100%"></a>
												    <div class="text"></div>
												  </div>

												  <div class="mySlides fade">
												    <div class="numbertext"></div>
												    <a href="http://www.telescoop.com.ph/assets/images/ads/Originals/4.jpg" target="_blank"><img src="<?=IMAGE_PATH?>ads/4.jpg" style="width:100%"></a>
												    <div class="text"></div>
												  </div>

												  <div class="mySlides fade">
												     <div class="numbertext"></div>
												    <a href="http://www.telescoop.com.ph/assets/images/ads/All_Home.JPG" target="_blank"><img src="<?=IMAGE_PATH?>ads/All_Home.JPG" style="width:100%"></a>
												  <div class="text"></div>


											<?else:?>
											  	

											  	  <div class="mySlides fade">
												    <div class="numbertext"></div>
												    <a href="http://www.telescoop.com.ph/assets/images/ads/1-20181012.jpg" target="_blank"><img src="<?=IMAGE_PATH?>ads/1-20181012.jpg" style="width:100%"></a>
												    <div class="text"></div>
												  </div>

												  <div class="mySlides fade">
												    <div class="numbertext"></div>
												    <a href="http://www.telescoop.com.ph/assets/images/ads/2-20181012.jpg" target="_blank"><img src="<?=IMAGE_PATH?>ads/2-20181012.jpg" style="width:100%"></a>
												    <div class="text"></div>
												  </div>

												  <div class="mySlides fade">
												     <div class="numbertext"></div>
												    <a href="http://www.telescoop.com.ph/assets/images/ads/Gridpoint.JPG" target="_blank"><img src="<?=IMAGE_PATH?>ads/Gridpoint.JPG" style="width:100%"></a>
												    <div class="text"></div>
												  </div>

												  <div class="mySlides fade">
												     <div class="numbertext"></div>
												    <a href="http://www.telescoop.com.ph/assets/images/ads/4-20181012.jpg" target="_blank"><img src="<?=IMAGE_PATH?>ads/4-20181012.jpg" style="width:100%"></a>
												    <div class="text"></div>
												  </div>


												  <div class="mySlides fade">
												    <div class="numbertext"></div>
												    <a href="http://www.telescoop.com.ph/assets/images/ads/Originals/3.jpg" target="_blank"><img src="<?=IMAGE_PATH?>ads/3.jpg" style="width:100%"></a>
												    <div class="text"></div>
												  </div>

												  <div class="mySlides fade">
												    <div class="numbertext"></div>
												    <a href="http://www.telescoop.com.ph/assets/images/ads/Originals/4.jpg" target="_blank"><img src="<?=IMAGE_PATH?>ads/4.jpg" style="width:100%"></a>
												    <div class="text"></div>
												  </div>

												  <div class="mySlides fade">
												     <div class="numbertext"></div>
												    <a href="http://www.telescoop.com.ph/assets/images/ads/All_Home.JPG" target="_blank"><img src="<?=IMAGE_PATH?>ads/All_Home.JPG" style="width:100%"></a>
												    <div class="text"></div>
										    

										</div>

										<?endif;?>
										<a class="prev" onclick="plusSlides(-1)">&#10094;</a>
			  							<a class="next" onclick="plusSlides(1)">&#10095;</a>
									</div>
										<br>

										<div style="text-align:center">
										   
										    <?if($today != $ded_line):?>
												  	
												<span class="dot" onclick="currentSlide(1)"></span>
											    <span class="dot" onclick="currentSlide(2)"></span>
											    <span class="dot" onclick="currentSlide(3)"></span>
											    <span class="dot" onclick="currentSlide(4)"></span>
											    <span class="dot" onclick="currentSlide(5)"></span>
											    <span class="dot" onclick="currentSlide(6)"></span>
											    <span class="dot" onclick="currentSlide(7)"></span>
												<span class="dot" onclick="currentSlide(8)"></span>

											<?else:?>

												<span class="dot" onclick="currentSlide(1)"></span>
											    <span class="dot" onclick="currentSlide(2)"></span>
											    <span class="dot" onclick="currentSlide(3)"></span>
											    <span class="dot" onclick="currentSlide(4)"></span>
											    <span class="dot" onclick="currentSlide(5)"></span>
											    <span class="dot" onclick="currentSlide(6)"></span>
											    <span class="dot" onclick="currentSlide(7)"></span>

										  	<?endif;?>
										    <!--<span class="dot" onclick="currentSlide(7)"></span>-->

										    <!--<span class="dot" onclick="currentSlide(6)"></span>-->
										</div>

										<br>

									<!--<img style="width:600px" src="<?=FILES_PATH?>rainy-final.jpg" />-->
									<!--<img style="width:600px" src="<?=FILES_PATH?>anniversarypromo.png" />-->
									<strong><font size="3.5"><a style="color:red" href="<?=FILES_PATH?>pricelist.pdf" target="_blank">(Latest Pricelist)</a></font></strong><br>
									<!--<strong><font size="3.5"><a style="color:red" href="https://docs.google.com/forms/d/e/1FAIpQLSdLZ5yksTRwAz2AOPwpF1yDtxn21J_NMmuXVqIlIHSUmD-awQ/viewform" target="_blank">(Click here to win Prizes)</a></font></strong>-->
									<!--<img style="width:600px" src="<?=FILES_PATH?>ANNOUNCMENT.jpg" />-->
								</center>
							<?else:?>
								<form action="<?=site_url($this->uri->uri_string())?>" method="POST">
								<table width="30%">


										<tr><td class="Thead" colspan="3">SECURITY QUESTION </td></tr>

										<?if(isset($msg)):?>

										<td colspan=2 align="center">
											<x style="color:red	"><?=$msg?></x>
										</td>

										<?endif;?>



										<tr>
											<td>Security Question :</td>
											<td>

												<?
												$queryq = $this->db->query("SELECT *
														       	FROM telescoop_web.member_questions
																WHERE member_id = $member_id
																ORDER BY RAND()
																LIMIT 1");
												$rowq = $queryq->row('question');
												$rowq_id = $queryq->row('question_id');

												echo $rowq;

												?>
												<input type="hidden" name="question_idx" value="<?=$rowq_id;?>"/>
											</td>

										</tr>

										<tr>
											<td>Answer :</td>
											<td><input name="answerx" value="<?=$_POST['answerx'];?>" type="text"  />
											</td>
										</tr>

										<tr>

											<td></td>
											<td><input type="submit" class="demo" width="15" name="submit_answers2" value="Validate"/>

											</td>
										</tr>
								</table>
								</form>
							<?endif;?>
						<?else:?>
						<form action="<?=site_url($this->uri->uri_string())?>" method="POST">

						<table width="30%">


							<tr><td class="Thead" colspan="3">CHALLENGE QUESTIONS (Required)</td></tr>

							<?if(isset($msg)):?>

							<td colspan=2 align="center">
								<x style="color:red	"><?=$msg?></x>
							</td>

							<?endif;?>

							<style>
								x {
									color:red;
								}
							</style>

							<tr>
								<td>Challenge Question #1</td>
								<td>
									<select name="question1" onchange="submit()">
									<?
										$queryq = $this->db->get("telescoop_web.challenge_questions");
										echo '<option value="0">Choose One</option>';

										foreach($queryq->result() as $row)
										{
											if($_POST['question1'] == $row->question_id)
											{
												echo '<option value="'.$row->question_id.'" selected>'.$row->question.'</option>';
											}else{
												echo '<option value="'.$row->question_id.'">'.$row->question.'</option>';
											}

										}

									?>
									</select>
								</td>

							</tr>

							<tr>
								<td>Answer :</td>
								<td><input name="answer1" value="<?=$_POST['answer1']?>" type="password" />

								</td>
							</tr>
							<tr>
								<td>Confirm Answer :</td>
							<td><input name="conf_answer1" value="<?=$_POST['conf_answer1']?>" type="password"   />
							<span class="sidetip" style="display: none;">Please confirm your answer.</span>

								</td>
							</tr>

							<tr>
								<td>Challenge Question #2</td>
								<td>

									<select name="question2" onchange="submit()">
									<?
									$queryq = $this->db->get("telescoop_web.challenge_questions");
									echo '<option value="0">Choose One</option>';
									foreach($queryq->result() as $row)
									{
										if($_POST['question2'] == $row->question_id)
										{
											echo '<option value="'.$row->question_id.'" selected>'.$row->question.'</option>';
										}else{
											echo '<option value="'.$row->question_id.'">'.$row->question.'</option>';
										}
									}
									?>
									</select>
								</td>

							</tr>

							<tr>
								<td>Answer :</td>
								<td><input name="answer2" value="<?=$_POST['answer2'];?>" type="password" />

								</td>
							</tr>
							<tr>
								<td>Confirm Answer :</td>
							<td><input name="conf_answer2" value="<?=$_POST['conf_answer2'];?>" type="password" />
							<span class="sidetip" style="display: none;">Please confirm your answer.</span>

								</td>
							</tr>


							<tr>

								<td></td>
								<td><input type="submit" class="demo"   width="15" name="submit_answers" onclick="return confirm('Are you sure you want to continue?')" value="Submit"/>

								</td>
							</tr>
						</table>

						</form>
						<?endif;?>

					<!--img  src="<?=IMAGE_PATH?>welcome.png" />
					<img style="width:600px" src="<?=FILES_PATH?>Telescoop_Advisory.jpg" /-->


				<?endif;?>
				</center>
			</div>
		</div>



	</div>
</div>

	<script>

	var slideIndex = 1;
	showSlides(slideIndex);

	setInterval(function(){ autoSlides(); }, 5000);

	function autoSlides() {
	var slides = document.getElementsByClassName("mySlides");

	if (slideIndex > slides.length) {slideIndex = 1}
	else {slideIndex++ }
	showSlides(slideIndex);
	}

	function plusSlides(n) {
		showSlides(slideIndex += n);
	}

	function currentSlide(n) {
		showSlides(slideIndex = n);
	}

	function showSlides(n)
	{
		var i;
		var slides = document.getElementsByClassName("mySlides");
		var dots = document.getElementsByClassName("dot");
		//alert(n.' x '.slides.length)
		if (n > slides.length) {slideIndex = 1}
		if (n < 1) {slideIndex = slides.length}
		for (i = 0; i < slides.length; i++) {
			slides[i].style.display = "none";
		}
		for (i = 0; i < dots.length; i++) {
			dots[i].className = dots[i].className.replace(" active", "");
		}
		slides[slideIndex-1].style.display = "block";
		dots[slideIndex-1].className += " active";
	}

	function check_validation_key(ctr)
	{
		var valid_key = document.getElementById("valid_key_"+ctr).value;
		var member_id = document.getElementById("member_id").value;

		$.post( "<?=site_url('account/check_validation_key')?>", {valid_key:valid_key, member_id:member_id} ,function( data ) {
			if(data.ok == 0){
				Swal('Wrong verification key! ','Please try again!','error')
			}else{

				swal.showLoading();

				//sending email
				$.get( "https://www.telescoop.com.ph/For_Evaluation/index.php/Welcome/test_send_confirm/"+valid_key+"/<?=$_SERVER['REMOTE_ADDR']?>", function(data)
				{
					if(data.return_nya == 'success')
					{
						showContent("POL");

						swal(
							'Your loan has been confirmed.','Now ready for processing..','success'
						).then((result) => {

							var theForm = document.getElementById("POL_form");

							theForm.submit();
						});
					}
					else
					{
						swal(
						'Email Server Problem!',
						'Please try again.',
						'error'
						).then((result) => {
							close_window();
						});

					}


				},'json');
			}
		}, "json");

	}



	</script>



	<?$this->load->view($side_menu);?>
