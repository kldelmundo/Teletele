<style>
		.toggler { width: 500px; height: 200px; position: relative; }
		#button { padding: .5em 1em; text-decoration: none; }
		#effect { width: 240px; height: 135px; padding: 0.4em; position: relative; }
		#effect h3 { margin: 0; padding: 0.4em; text-align: center; }
		.ui-effects-transfer { border: 2px dotted gray; } 
		
		.TheadB {
    background: repeat-x scroll 0 0 lightgray;
    color: black;
    font-weight: bold;
}
	</style>







<div id="body-left">
	
		<div id="left-content">
				
			<span class="tag-title">LOAN CALCULATOR!</span>
			<br>
				
			<form accept-charset="utf-8" method="post" action="http://www.telescoop.com.ph/home/loan_calculator.aspx">						<table>
							<tbody><tr>
								<td colspan="2" class="Thead">LOAN PROCEEDS CALCULATOR</td>
							</tr>
							<tr>
								<td>LOAN TYPE:</td>
								<td>
									<select name="loan_type">
										<option value="team">TEAM LOAN - (100K per PO)</option>
									</select>
								</td>
							</tr>
							<tr>
								<td>TOTAL COST</td>
								<td><select style="width:125px" name="total_cost">
									
									<?
										for($x = 100000; $x <= 1000000; $x+=100000)
										{
											$txt = '';
											
											if(isset($_POST['total_cost'])){
												if($_POST['total_cost'] == $x){
													$txt = 'selected';
												}
											}
											
											echo "<option $txt value='$x'>Php ".nf($x)."</option>";
										}
										
									?>
										<!--option value="100000">Php 100,000.00</option>
										<option value="200000">Php 200,000.00</option>
										<option value="300000">Php 300,000.00</option>
										<option value="400000">Php 400,000.00</option>
										<option value="500000">Php 500,000.00</option>
										<option value="600000">Php 600,000.00</option>
										<option value="700000">Php 700,000.00</option>
										<option value="800000">Php 800,000.00</option>
										<option value="900000">Php 900,000.00</option>
										<option value="1000000">Php 1,000,000.00</option-->
									</select>
								</td>
							</tr>
							<tr>
								<td>PAYMENT TERMS</td>
								<td><select style="width:125px" name="payment_terms">
								<?	
									for($x = 12; $x <= 36; $x+=12)
										{
											$txt = '';
											
											if(isset($_POST['payment_terms'])){
												if($_POST['payment_terms'] == $x){
													$txt = 'selected';
												}
											}
											
											echo "<option $txt value='$x'>$x months</option>";
										}
								?>
										<!--option value="12">12 months</option>
										<option value="24">24 months</option>
										<option value="36">36 months</option-->
									</select>
								</td>
							</tr>
							
							
	<?if(!isset($_POST)): ?>						
							<tr>
								<td>&nbsp;</td>
								<td>
									
									<input type="submit" value="Compute Proceeds" name="compute" id="compute">
									
								</td>
							</tr>
	<?endif?>						
							
							
							
	<?  if($_POST) 
		{
			$member_id = $row->member_id;
			
			$sqlsdf = "SELECT DISTINCT(pay_period)
						   FROM ar_member_subs where member_id = '$member_id'
						   && pay_period < NOW()
						   AND post_by IS NOT NULL
						   ORDER BY `ar_member_subs`.`pay_period`  DESC LIMIT 1";
						   
			$resultadf= mysql_query($sqlsdf) or die (mysql_error().$sqlsdf);
			$rowadf = mysql_fetch_array($resultadf, MYSQL_ASSOC);			
			
			$pay_period = $rowadf['pay_period'];
			
			$puc = $this->m_account->get_puc($member_id,$pay_period);			
			$ob = $this->m_account->get_ob($member_id,$pay_period);			
			
			#echo $puc.'<br>';
			#echo $ob.'<br>';
			
			$total_cost = $_POST['total_cost'];
			$payment_terms1 = $_POST['payment_terms'] * 2;
			$payment_terms2 = $_POST['payment_terms'];
			
			#echo $payment_terms2;
			if($payment_terms2 == 12){
				$rate = 0.0662;
			}elseif($payment_terms2 == 24){
				$rate = 0.1298;
			}elseif($payment_terms2 == 36){
				$rate = 0.1957;
			}
			
			$gross = $total_cost  + ($total_cost * $rate) + ($total_cost * 0.03);
			
			if($payment_terms2 == 12)
			{
				$semi_a = $gross / 24;
				$semi_b = 0;
			}
			else
			{
				$semi_a = ($total_cost + $total_cost * 0.1298) / $payment_terms1 + ($total_cost * 0.03 / $payment_terms2 );
				$semi_b = ($gross - $total_cost * 0.03) / $payment_terms1;
			}
			
			$req_scs = ( $gross + $ob ) / 8;
			
			$req_scs2 = ($req_scs - $puc) < 0 ? 0 : ($req_scs - $puc);
			
			$req_scs_loan = $gross / 8;
			
			if($req_scs_loan > $req_scs2){
				$req_final = $req_scs2;
			}else{
				$req_final = $req_scs_loan;
			}
			
			
			#echo $req_scs.'<br>';
			
			#echo $req_scs.'<br>';
	
			
			$gross = nf($gross);
			$semi_a = nf($semi_a);
			$semi_b = nf($semi_b);
			$net_proceeds = nf($total_cost - $req_final);
			$total_cost = nf($total_cost);
			$req_final = nf($req_final);
			
			$puc = nf($puc);
			$ob = nf($ob);
	?>						
							
							<tr>
								<td colspan="2" class="TheadB"  style="font-weight:bold">RESULT</td>
							</tr>
							
							
							
							<tr>
								<td>GROSS AMOUNT</td>
								<td>
									<input type="text" style="text-align:right" value="<?=$gross?>" readonly name="gross_amount"/>
								</td>
							</tr>
							
							<tr>
								<td>SEMI AMORT. <em>(1ST YEAR)</em></td>
								<td>
									<input type="text" style="text-align:right" value="<?=$semi_a?>" readonly name="gross_amount"/>
								</td>
							</tr>
							
							<tr>
								<td>SEMI AMORT. <em>(2ND YEAR - 3RD YEAR)</em></td>
								<td>
									<input type="text" style="text-align:right" value="<?=$semi_b?>" readonly name="gross_amount"/>
								</td>
							</tr>
							
							<tr>
								<td colspan="2" class="TheadB"  style="font-weight:bold">FIXED REQUIREMENT COMPUTATION</td>
							</tr>
							
							<tr>
								<td>PAID UP (hide)</td>
								<td>
									<input type="text" style="text-align:right" value="<?=$puc?>" readonly name="gross_amount"/>
								</td>
							</tr>
							
							<tr>
								<td>OB <em>(EXCLUDING SR) (hide)</em></td>
								<td>
									<input type="text" style="text-align:right" value="<?=$ob?>" readonly name="gross_amount"/>
								</td>
							</tr>
							
							<tr>
								<td>FIXED REQ.(Loan) (hide)</em></td>
								<td>
									<input type="text" style="text-align:right" value="<?=nf($req_scs_loan)?>" readonly name=""/>
								</td>
							</tr>
							
							<tr>
								<td>FIXED REQ SCS (hide)</em></td>
								<td>
									<input type="text" style="text-align:right" value="<?=nf($req_scs2)?>" readonly name=""/>
								</td>
							</tr>
							
							<tr>
								<td>FIXED REQUIRED <em style="color:red">(Less)</em></td>
								<td>
									<input type="text" title="Enter Fixed Deposit" value="<?=$req_final;?>" readonly style="text-align:right;color:red" placeholder="0.00"  name="puc"/>
								</td>
							</tr>
							
							<tr>
								<td>TOTAL COST</td>
								<td>
									<input type="text" style="text-align:right" value="<?=$total_cost?>" readonly name="gross_amount"/>
								</td>
							</tr>
							
							<tr>
								<td><strong style="size:15px;">TOTAL NET PROCEEDS</strong></td>
								<td>
									<input type="text" style="width:142px;height:25px;size:15px;text-align:right;font-weight:bold" value="<?=$net_proceeds?>" 
									readonly name="net_proceeds"/>
								</td>
							</tr>
							
			<? } ?>			
						<tr>
								<td>&nbsp;</td>
								<td>
									
									<input type="submit" value="Recompute Proceeds" name="compute" id="compute">
									
								</td>
							</tr>	
						</tbody></table>
						</form>
			
			
		</div>
</div>
	
	
