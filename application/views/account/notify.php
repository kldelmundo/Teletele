<!-- MADE TO COMPENSATE THE PROFILE FOR BLISS PROJECT -->
<body>        
   
<div id="body">
	<div class="bodygradient">
		<div class="bodyminimum">

			<div style="height: 50px; position: relative; width: 100%; top:40px; font-family: Akrobat; font-size: 18px; color:white; text-align: center; padding: 5px;">
			<h1>  </h1>            
			</div>	

			<div id="notify" style="margin: 50px 250px; background-color: white; padding: 40px 50px; font-size: 18px; text-align: left;">
				<center>
				<input type='hidden' name='redirect_page' value=''/>
				<?=form_open('account/notification');?>
					<? $row = $this->m_account->get_member_info(); ?>
				<table style="width:65%;margin:auto;font-size:11px;">
					<tr>
						<td class="Thead" colspan=2>Notification Settings</td>
					</tr>
						<tr>
							<td style="color:#3b5a51; font-size: 15px; font-weight: 650;">Email Address:</td>
							<td><input style="background-color:#f2d0aa; color:#5a5b5d; background-clip:border-box; padding:auto; height: 25px; width:320px" required type="text" name="email_add" value="<?=$row->email_add?>" /></td>
							
						</tr>
						<tr>
						<td style="color:#3b5a51; font-size: 15px; font-weight: 650;">Mobile #:</td>
						
						<? if($row->is_notify_sms == 1)
						   {
						   		$checked = 'checked';
						   }else{
						   		$checked = '';
						   }
						?>
							<td><input type="text" value="+639" readonly style="font-size:13px; background-color:#f2d0aa; color:#5a5b5d; background-clip:border-box; padding:auto; height: 25px; width:80px">
								<input type="text" style="background-color:#f2d0aa; color:#5a5b5d; background-clip:border-box; padding:auto; height: 25px; width:240px" required value="<?=substr($row->mobile_no,-9)?>" name="mobile_no">&nbsp;&nbsp;<input type="checkbox" name="is_notify_sms" <?=$checked?> title="Notify me via mobile" /> <x style="font-size:10px;" >notify me via mobile</x></td>
						</tr>	
						<td>&nbsp;</td>
							<td align="left"><input type="submit" value="Update record"></td>
						</tr>		
						
				</table>
				<?=form_close();?>	
				</center>
			</div>

		</div>
	</div>
</div>

</body>