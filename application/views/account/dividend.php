<!-- MADE TO COMPENSATE THE PROFILE FOR BLISS PROJECT -->
<body>

<div id="body">

	<div class="bodygradient">
		<div class="bodyminimum">

			<div style="height: 50px; position: relative; width: 100%; top:40px; font-family: Akrobat; font-size: 18px; color:white; text-align: center; padding: 5px;">
			<h1> DIVIDEND INFORMATION </h1>
			</div>

	    			<div id="dividend" style="margin: 50px 250px; background-color: white; padding: 40px 50px; font-size: 18px; text-align: left;">

						<table style="width:70%;margin:auto;font-size:12px;">

							<?if(count($row_dividend) == 0):?>
								<br>
								<br>
								<br>
								<tr>
									<td colspan=2 align=center><strong>NO DIVIDEND FOUND.</strong></td>
								</tr>
							<?else:?>

							<tr>
								<td class="Thead" colspan=2 align=center><strong>For the Dividend Year 2019</strong></td>
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
		</div>
	</div>
</div>

</body>
</html>
