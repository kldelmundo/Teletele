<script>

$(document).ready(
			
	function()
	{
	    $('#thickbox').each(function(){
		    var url = $(this).attr('href') + '?TB_iframe=true&width=550';
		    $(this).attr('href', url);
	    });
	    
	     $('#thickbox2').each(function(){
		    var url = $(this).attr('href') + '?TB_iframe=true&width=600';
		    $(this).attr('href', url);
	    });
	    
	     $('#thickbox3').each(function(){
		    var url = $(this).attr('href') + '?TB_iframe=true&width=600';
		    $(this).attr('href', url);
	    });
	    
	}
	
			
); 
	

</script>

<style>
.testing {
	min-width:550px;}
</style>
	<div id="body-left">
		<div id="left-content">
			<span class="tag-title">Direct Selling Services</span>	
			
			<br>
						
			<div id="HoldingContainer" style="display:none;">
				
				<div id="dsx">
					<span class="contTitle">DIRECT SELLING</span>
					<br>
					<p>This loan can be availed of by a qualified Member in the purchase or availment of consumer items such as gadgets, cellphones, appliances and construction  materials, among others.  The proceeds of this loan may be made payable to the Supplier or directly to the Member.</p>
					
				</div>
				
				
				<div id="ds">
					<span class="contTitle">DIRECT SELLING</span>
					<br>
					<p>Products within TELESCOOP Inventory<br><br><strong><font color="red">Note: Pricelist is available upon logging-in.<br><br></font></strong></p>
						
				</div>

				<div id="quotation">
					<span class="contTitle">DIRECT SELLING</span>
					<br>
					<p>Products not in TELESCOOP Inventory<br><br><strong><font color="red">Note: Pricelist is available upon logging-in.<br><br></font></strong></p>
					<div>
						<table>
							<tr><td class="Thead" colspan="4">&nbsp;</td></tr>
							
							<tr style="font-weight:bold;">
								<td  colspan=4>AMOUNT: &nbsp;&nbsp;<u>PHP 5,000.00 & UP</u></td>
							</tr>
							
							<tr style="font-weight:bold;">
								<td>TERMS</td>
								<td>3,6,12,18,24,30,36 Months</td>
							</tr>
							
							<tr>
								<td colspan=2>&nbsp;</td>
							</tr>
						
								<tr>
								<td colspan=2><strong>NOTE:</strong> with Php 5.00 monthly insurance /appliance /furnitures /computer package </td>
							</tr>
							
							
							
						</table>
					</div>
				</div>
				
				
				
				
				
				
			</div>
			<div id="DisplayContainer">
				<div id="t_fsdl">
					<span class="contTitle">Direct Selling</span>
					<br>
						<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;This loan can be availed of by a qualified Member in the purchase or availment of consumer items such as gadgets, cellphones, appliances and construction  materials, among others.  The proceeds of this loan may be made payable to the Supplier or directly to the Member.</p>
					<div class="testing">

						


							<table>
								<th colspan="2"><center><h3>List of Promo and Gadgets</center></h3></th>
								<!--<?form_open('home/appliance');?>
								<?form_error('search'); ?>
								<tr>
									<th><center><h3>List of Promo and Gadgets</center></h3></th>
									<?#echo '<th><center>Search: <input type="search" size="10" id="search" name="search" value="<?=$keyword?>" placeholder="Search"></center></th>'?>
								</tr>
								<?form_close();?>-->
								<?foreach($query->result() as $row):?>
								<tr>
									<td><a href="<?=$row->ps_img_url;?>" target="_blank" ><img src="<?=$row->ps_img_url;?>" height="260" width="260" ></a></td>
										
									<td><input type ="text" placeholder="<?=$row->ps_name;?>" size="34" readonly><br>
										
									<input type="text" placeholder="<?=$row->ps_description;?>" size="34" readonly><br>
										
									<textarea rows="4" cols="30" readonly><?=$row->ps_details;?></textarea></td>
									
								</tr>
								<?endforeach;?>
								<br>
								<tr >
									<td colspan="2"><center><?=$this->pagination->create_links();?></center></td>
								</tr>

								
							</table>
						</div>		
				</div>
			</div>
		</div>
	</div>

	<div id="body-right">
		<div class="bg-separator"></div>
		<div id="right-content">
			
			<div class="left-title">DIRECT SELLING TYPES</div>
			
			<div id="menu">
				<!--<div class="mtitle"><a href="javascript:void(0);" onclick="showContent('ds');">DS - In house Inventory</a></div>
				<div class="mtitle"><a href="javascript:void(0);" onclick="showContent('quotation');">DS - Quotation</a></div>-->
				<div class="mtitle"><a href="#" onclick="">DS - In house Inventory</a></div>
				<div class="mtitle"><a href="#" onclick="">DS - Quotation</a></div>
			</div>
			

			<!-- END OF ID=MENU -->

		</div>
		
	</div>

	