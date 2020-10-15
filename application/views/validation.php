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
	<div style="height: 50px; position: relative; width: 100%; top:40px; font-family: Akrobat; font-size: 18px; color:white; text-align: center; padding: 5px;">
			<h1></h1>
			</div>

			<div id="register">

					<?=form_open('account/validation_bmp');?>

					<table>


						<tr><td class="Thead" colspan="3"><center>VALIDATION</center></td></tr>


						<input type="hidden" name="member_id" value="<?=$member_id;?>">

						<tr>
							<td style="color:#7d9a6b; font-size: 15px; font-weight: 650; width:30px">Employee No :</td>
							<td><z style="color:red"><? echo form_error('emp_num'); ?></z>
								<input style="background-color:#f2d0aa; color:#5a5b5d; background-clip:border-box; padding:auto; height: 25px; width:220px" name="emp_num" value="<?=set_value('emp_num');?>" type="text" tabindex="2" />
								<span class="sidetip" style="display: none;">Please Enter Either your Old ID / SAP ID.</span>
								<x>*</x>
							</td>
						</tr>
						<tr>
							<td style="color:#7d9a6b; font-size: 15px; font-weight: 650;">Birth Date :</td>
							<td><z style="color:red"><? echo form_error('birthday'); ?></z>
								<input style="background-color:#f2d0aa; color:#5a5b5d; background-clip:border-box; padding:auto; height: 25px; width:220px" name="birthday" title="Please select by (MONTH, YEAR, DATE)" id="datepicker" value="<?=set_value('birthday');?>" readonly type="text"  tabindex="3"/>
								<x>*</x>
							</td>
						</tr>



						<tr>

							<td></td>
							<td><input id="loginhover" type="submit" class="demo" tabindex="8"  width="15" name="request" value="NEXT"/>

							</td>
						</tr>
					</table>



					<?form_close();?>


			</div>
