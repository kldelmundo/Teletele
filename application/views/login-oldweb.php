				<div id="login">

					<form name="form1" method="post" action="<?=site_url('account/login')?>" accept-charset="utf-8" autocomplete="off">



					<table>

						<tr><td class="Thead" colspan="3">PLEASE LOGIN</td></tr>
						<input type='hidden' name='redirect_page' value='<?=$redirect_page?>'/>
						<?if(isset($error)):?>

						<td colspan=2 align="center">
							<x style="color:red	"><?=$error?></x>
						</td>

						<?endif;?>
						<tr>

							<td>Username :</td>
							<td><input style="width:150px" name="myusername" type="text" tabindex="1"/></td>
						</tr>
						<tr>
							<td>Password :</td>
							<td><input  style="width:150px" name="mypassword" type="password"  tabindex="2"/></td>
						</tr>
						<tr>


							<td></td>
							<td><input type="submit" width="15" name="login" value="  Login  "/></td>
						</tr>
					</table>
					</form>

				</div>

				<br>

				<div class="info">
					<p style="font-size:12px">Not yet registered? Click&nbsp;<?=anchor('account/request','here.')?></p>
					<!--<p style="font-size:12px">Forgot your password? Click&nbsp;<?=anchor('account/forgot_password','here.')?></p>	-->
					<!--br>
					<p style="font-size:11px"><strong>Note: </strong>Please call us for your TELESCOOP Member ID.</p-->

				</div>
