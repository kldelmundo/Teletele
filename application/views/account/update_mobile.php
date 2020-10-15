<? $row = $this->m_account->get_member_info(); ?>
<? $name = ucwords(strtolower($row->mem_lname.', '.$row->mem_fname)); ?>


<div id="notify">
	
	
<h1>Welcome <?=$name?>!</h1>	

<br>
					<center>
					<?=form_open('account/notification');?>
					<input type='hidden' name='redirect_page' value='update na'/>
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