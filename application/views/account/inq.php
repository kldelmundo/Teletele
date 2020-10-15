<!-- MADE TO COMPENSATE THE PROFILE FOR BLISS PROJECT -->
<body>        
   
<div id="body">
	<div class="bodygradient">
		<div class="bodyminimum">

			<div style="height: 50px; position: relative; width: 100%; top:40px; font-family: Akrobat; font-size: 18px; color:white; text-align: center; padding: 5px;">
			<h1>  </h1>            
			</div>	

			<div id="notify" style="margin: 50px 250px; background-color: white; padding: 40px 50px; font-size: 18px; text-align: left;">

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
							<td class="Thead" colspan=2 style="color:#7d9a6b; font-size: 15px; font-weight: 650;">Inquiry Form</td>
						</tr>
						<tr>
							<td style="color:#7d9a6b; font-size: 15px; font-weight: 650;">Title:</td>
							<!--<td><input type="text" id="title" style="width:250px" value="" name="title"/></td>-->
							<td><select name="title" id="title" style="background-color:#f2d0aa; color:#5a5b5d; background-clip:border-box; padding:auto; height: 25px; width:320px">
									<option value="4">Application for New / Termination of Membership</option>
									<option value="3">Direct Selling Loans / Promo Loans / Pricelist</option>
									<option value="1">Loan Computation / Account Balance</option>
									<option value="2">Savings Deposit / Withdrawal / Balance</option>
									<option value="6">Comments & Suggestion</option>
									<option value="5">Others</option>

							</select></td>
						</tr>
						
						<tr>
							<td style="color:#7d9a6b; font-size: 15px; font-weight: 650;">Message:</td>
							<td><textarea name="msg" id="message" rows="6" cols="40" style="background-color:#f2d0aa; color:#5a5b5d; background-clip:border-box; padding:auto; height: 200px; width:320px"> </textarea></td>
						</tr>
						
						<tr>
							<td>&nbsp;</td>
							<td>
								
								<input type="submit" id="inq_send" name="inq_send" onclick="return myFunction()" value="Send"/>
								<input type="submit" id="cancel_send" name="cancel_send" value="Cancel"/>
								
							</td>
						</tr>
						
					</table>
				<?=form_close();?>
			</div>
		</div>
	</div>
</div>
</body>

