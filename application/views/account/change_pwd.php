<!-- MADE TO COMPENSATE THE PROFILE FOR BLISS PROJECT -->
<body>        
   
<div id="body">
 
	<div class="bodygradient">
		<div class="bodyminimum">
    	
			<div style="height: 50px; position: relative; width: 100%; top:40px; font-family: Akrobat; font-size: 18px; color:white; text-align: center; padding: 5px;">
			<h1> Change Password </h1>            
			</div>
	    		<div id="change_password" style="margin: 50px 250px; background-color: white; padding: 40px 50px; font-size: 18px; text-align: left;">

						<?=form_open('account/change_password');?>
						<table>
							<tr>
								<td class="Thead" colspan=2>Change Password</td>
							</tr>
							<tr>
								<td style="color:#3b5a51; font-size: 15px; font-weight: 650;">Username:</td>
								<td> <input style="background-color:#f2d0aa; color:#5a5b5d; background-clip:border-box; padding:auto; height: 25px; width:320px" type="text" name="username" readonly value="<?=$this->session->userdata('username')?>"/></td>
							</tr>
							
							<tr>
								<td style="color:#3b5a51; font-size: 15px; font-weight: 650;">Current Password:</td>
								<td><input style="background-color:#f2d0aa; color:#5a5b5d; background-clip:border-box; padding:auto; height: 25px; width:320px" type="password" id="old_pwd" name="old_pwd"/></td>
							</tr>
							
							<tr>
								<td style="color:#3b5a51; font-size: 15px; font-weight: 650;">New Password:</td>
								<td><input style="background-color:#f2d0aa; color:#5a5b5d; background-clip:border-box; padding:auto; height: 25px; width:320px" type="password" id="new_pwd" name="new_pwd"/></td>
							</tr>
							
							<tr>
								<td style="color:#3b5a51; font-size: 15px; font-weight: 650;">Confirm New Password:</td>
								<td><input style="background-color:#f2d0aa; color:#5a5b5d; background-clip:border-box; padding:auto; height: 25px; width:320px" type="password" id="conf_new_pwd" name="conf_new_pwd"/></td>
							</tr>
							
							<tr>
								<td>&nbsp;</td>
								<td><input  type="submit" name="submit" value="Submit"/></td>
							</tr>
						</table>
						<?=form_close();?>
				</div>	    
		</div>
	</div>
</div>

</body>
