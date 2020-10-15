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


<br><br><br><br>
			<div id="register">

					<form name="form1" method="post" action="<?=site_url('account/request')?>">

					<table>


						<tr><td class="Thead" colspan="3">REGISTER USER ACCOUNT</td></tr>

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
							<td style="color:#7d9a6b; font-size: 13px; font-weight: 650;">TELESCOOP Member ID :</td>
							<td> <z style="color:red"><?php echo form_error('member_id'); ?></z>
								<input style="background-color:#f2d0aa; color:#5a5b5d; background-clip:border-box; padding:auto; height: 25px; width:200px" name="member_id" value="<?=set_value('member_id');?>" type="text" id="member_id" tabindex="1"/>
								<span class="sidetip" style="display: none;">Call up Telescoop Customer Service hotline at 890-0409 and know your “TELESCOOP MEMBER ID” (six digit number).</span>
							<x>*</x>
							</td>

						</tr>
						<tr>
							<td style="color:#7d9a6b; font-size: 13px; font-weight: 650;">Employee No :</td>
							<td><z style="color:red"><?php echo form_error('emp_no'); ?></z>
								<input style="background-color:#f2d0aa; color:#5a5b5d; background-clip:border-box; padding:auto; height: 25px; width:200px" name="emp_no" value="<?=set_value('emp_no');?>" type="text" tabindex="2" />
								<span class="sidetip" style="display: none;">Please Enter Either your Old ID / SAP ID.</span>
								<x>*</x>
							</td>
						</tr>
						<tr>
							<td style="color:#7d9a6b; font-size: 13px; font-weight: 650;">Birth Date :</td>
							<td><z style="color:red"><?php echo form_error('bday'); ?></z>
								<input style="background-color:#f2d0aa; color:#5a5b5d; background-clip:border-box; padding:auto; height: 25px; width:200px" name="bday" title="Please select by (MONTH, YEAR, DATE)" id="datepicker" value="<?=set_value('bday');?>" readonly type="text"  tabindex="3"/>
							<!--span class="sidetip" style="display: none;">Please select by (MONTH, YEAR, DATE)</span-->
								<x>*</x>
							</td>
						</tr>
						<tr>
							<td style="color:#7d9a6b; font-size: 13px; font-weight: 650;">Email Address :</td>
							<td><z style="color:red"><?php echo form_error('email'); ?></z>
								<input style="background-color:#f2d0aa; color:#5a5b5d; background-clip:border-box; padding:auto; height: 25px; width:200px" name="email" type="text" value="<?=set_value('email');?>" tabindex="4"/>
							<span class="sidetip" style="display: none;">Maximum of 50 alphanumeric characters.</span>
							<x>*</x>
							</td>
						</tr>

						<tr>
							<td style="color:#7d9a6b; font-size: 13px; font-weight: 650;">Mobile number # :</td>
							<td><z style="color:red"><?php echo form_error('mobile'); ?></z>
								 <strong style="font-size:13px">+639</strong> <input style="background-color:#f2d0aa; color:#5a5b5d; background-clip:border-box; padding:auto; height: 25px; width:150px" name="mobile" type="text" style="width:110px" value="<?=set_value('mobile');?>" tabindex="5"/>
							<span class="sidetip" style="display: none;">Please Input Valid Mobile Numbers. Last 9 digits or If CP# is not available, key in 9 zeros.</span>
							<x>*</x>
							</td>
						</tr>

						<tr>
							<td style="color:#7d9a6b; font-size: 13px; font-weight: 650;">Username :</td>
							<td><z style="color:red"><?php echo form_error('username'); ?></z>
								<input style="background-color:#f2d0aa; color:#5a5b5d; background-clip:border-box; padding:auto; height: 25px; width:200px" name="username" value="<?=set_value('username');?>" type="text"  tabindex="6"/>
							<span class="sidetip" style="display: none;">Enter Your Desired Username. Minimum of six(6) alphanumeric characters.</span>

								<x>*</x>
							</td>
						</tr>
						<!--tr>
							<td>Password :</td>
							<td><z style="color:red"><?php echo form_error('password'); ?></z>
								<input name="password" value="<?=set_value('password');?>" type="password" tabindex="7" />
							<span class="sidetip" style="display: none;">Enter Your Desired Password. Minimum of six(6) characters.</span>

								<x>*</x>
							</td>
						</tr>
						<tr>
							<td>Confirm Password :</td>
						<td><z style="color:red"><?php echo form_error('conf_password'); ?></z>
							<input name="conf_password" value="<?=set_value('conf_password');?>" type="password"  tabindex="8" />
						<span class="sidetip" style="display: none;">Please Confirm Your Password.</span>

								<x>*</x>
							</td>
						</tr-->
						<tr>

							<td></td>
							<td><input id="loginhover" type="submit" class="demo" tabindex="8"  width="15" name="request" value="Create Account"/>

							</td>
						</tr>
					</table>



					</form>


			</div>
				<br>
				<strong>Note:</strong> Registration will need approval by the administrator.

				<br>
