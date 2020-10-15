		<script>


	$(function() {
		$( "#datepicker" ).datepicker({
            dateFormat : 'mm/dd/yy',
            changeMonth : true,
            changeYear : true,
            yearRange: '-100y:c+nn'//,
           // maxDate: '-1d'
        });

        $( "input:submit, button", ".demo" ).button();
		$('.sidetip2').hide();
		$('.sidetip').hide();
		$('p span.sidetip').hide();
		$('td span.sidetip').hide();

	});
	</script>

		<style>
			x {
				color:red;
			}
		</style>



	<?if(empty($member_id)):?>
	<br><br><br><br>

			<div id="register">

					<?=form_open('account/forgot_password');?>

					<table>


						<tr><td class="Thead" colspan="3">RECOVER ACCOUNT</td></tr>

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
							<td style="color:#7d9a6b; font-size: 15px; font-weight: 650;">TELESCOOP Member ID :</td>
							<td>
								<input style="background-color:#f2d0aa; color:#5a5b5d; background-clip:border-box; padding:auto; height: 25px; width:180px" name="member_id" value="<?=set_value('member_id');?>" type="text" id="member_id" tabindex="1" size="25" autocomplete="off"/>
								<span class="sidetip" style="display: none;">Call up Telescoop Customer Service hotline at 890-0409 and know your “TELESCOOP MEMBER ID” (six digit number).</span>
							</td>

						</tr>



						<tr >


							<td colspan="2"><center><input id="loginhover" type="submit" class="demo" tabindex="8"  width="15" name="request" value="NEXT"/></center>

							</td>
						</tr>
					</table>



					<?form_close();?>


			</div>
				<!-- <br>
				<strong>Note:</strong> Registration will need approval by the administrator.

				<br> -->


	<?else:?>


		<?
			foreach($query->result() as $row)
			{
				$username = $row->username;
				$security = $row->question;
				$db_bday = $row->mem_bday;
				$db_email_add = $row->email_add;
				$db_answer = $row->answer;
				$ast_email = $row->ast_email;
			}

		?>
			<br><br><br><br>
			<div id="register">

					<?=form_open('account/forgot_password');?>

					<table>


						<tr><td class="Thead" colspan="3">RECOVER PASSWORD</td></tr>

						<tr>
							<td style="color:#7d9a6b; font-size: 14px; font-weight: 650;">Email Address:</td>
							<td>
								<span style="">NOTE: Please input your email address</span>
								<input style="background-color:#f2d0aa; color:#5a5b5d; background-clip:border-box; padding:auto; height: 25px; width:180px" name="email" type="text" value="<?=set_value('email');?>" placeholder="<?=$ast_email?>" tabindex="4" size="40" autocomplete="off"/>
								<span class="sidetip" style="display: none;">Please input your email address.</span>
							</td>
						</tr>

						<tr>
							<td style="color:#7d9a6b; font-size: 14px; font-weight: 650;">Member ID:</td>
							<td>
								<input style="background-color:#f2d0aa; color:#5a5b5d; background-clip:border-box; padding:auto; height: 25px; width:180px" name="member_id" value="<?=$member_id;?>" type="text"  tabindex="6" size="40" readonly autocomplete="off"/>
								<span class="sidetip" style="display: none;"></span>

							</td>
						</tr>
						<?$mem_question = $this->db->query("SELECT * FROM telescoop_web.member_questions WHERE member_id = $member_id")?>
						<?if($mem_question->num_rows() > 0):?>
						<tr>
							<td style="color:#7d9a6b; font-size: 14px; font-weight: 650;">Security Question:</td>
							<td>
								<!-- <input style="background-color:#f2d0aa; color:#5a5b5d; background-clip:border-box; padding:auto; height: 25px; width:180px" name="security" value="<?=$security;?>" type="text" tabindex="6" size="40" height="60"readonly autocomplete="off"/> -->
								<textarea style="background-color:#f2d0aa; color:#5a5b5d; background-clip:border-box; padding:auto; height: 80px; width:180px" readonly><?=$security?></textarea>
								<span class="sidetip" style="display: none;">Security Question you input after logging in to TELESCOOP.</span>

							</td>
						</tr>

						<tr>
							<td style="color:#7d9a6b; font-size: 14px; font-weight: 650;">Answer:</td>
							<td>
								<input style="background-color:#f2d0aa; color:#5a5b5d; background-clip:border-box; padding:auto; height: 25px; width:180px" name="answer" value="<?=set_value('answer');?>" type="password"  tabindex="6" size="40" autocomplete="off">
								<span class="sidetip" style="display: none;">Security Answer you input after logging in to TELESCOOP. THIS PART IS CASE SENSITIVE</span>

							</td>
						</tr>

						<input type="hidden" name="db_answer" value="<?=$db_answer?>" />

						<?else:?>
						<input type="hidden" name="db_answer" value="oks" />
						<input type="hidden" name="answer" value="oks" />

						<?endif;?>

							<input type="hidden" name="username" value="<?=$username?>" />
							<input type="hidden" name="db_bday" value="<?=$db_bday?>" />

							<input type="hidden" name="db_email_add" value="<?=$db_email_add?>" />

						<tr>


							<td colspan ='2'><center><input id="loginhover" type="submit" class="demo" tabindex="8"  width="15" name="request" value="Reset Password"/></center></td>

						</tr>
					</table>



					<?form_close();?>


			</div>
	<?endif;?>
