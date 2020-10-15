


<html>
<head>
	<style>
		/* Center the loader */
		#loader {
		  position: absolute;
		  left: 50%;
		  top: 50%;
		  z-index: 1;
		  width: 150px;
		  height: 150px;
		  margin: -75px 0 0 -75px;
		  border: 16px solid #f3f3f3;
		  border-radius: 50%;
		  border-top: 16px solid #3498db;
		  width: 120px;
		  height: 120px;
		  -webkit-animation: spin 2s linear infinite;
		  animation: spin 2s linear infinite;
		}
		
		@-webkit-keyframes spin {
		  0% { -webkit-transform: rotate(0deg); }
		  100% { -webkit-transform: rotate(360deg); }
		}
		
		@keyframes spin {
		  0% { transform: rotate(0deg); }
		  100% { transform: rotate(360deg); }
		}
		
		
		
		/* Add animation to "page content" */
		.animate-bottom {
		  position: relative;
		  -webkit-animation-name: animatebottom;
		  -webkit-animation-duration: 1s;
		  animation-name: animatebottom;
		  animation-duration: 1s
		}
		
		@-webkit-keyframes animatebottom {
		  from { bottom:-100px; opacity:0 } 
		  to { bottom:0px; opacity:1 }
		}
		
		@keyframes animatebottom { 
		  from{ bottom:-100px; opacity:0 } 
		  to{ bottom:0; opacity:1 }
		}
		
		#myDiv {
		  display: none;
		  text-align: center;
		}
	</style>

		

<link rel='stylesheet' href='<?=CSS_PATH?>thickbox.css' type='text/css' charset='utf-8' />
		
	<script type="text/JavaScript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	<script type="text/JavaScript" src="<?=JS_PATH?>thickbox.js"></script>
	<script type="text/JavaScript" src="<?=JS_PATH?>jquery.maskedinput.min.js"></script>
		
	
	<link rel='stylesheet' href='<?=CSS_PATH?>bootstrap.min.css' type='text/css' charset='utf-8' />
	<link rel='stylesheet' href='<?=CSS_PATH?>ace.min.css' type='text/css' charset='utf-8' />

	<script src="<?=JS_PATH?>sweetalert2/dist/sweetalert2.all.min.js"></script>


	<script src="<?=JS_PATH?>sweetalert2/dist/sweetalert2.min.js"></script>
	<link rel="stylesheet" href="<?=JS_PATH?>sweetalert2/dist/sweetalert2.min.css">

</head>
<body>
	
	
	<script type="text/javascript">

		$( document ).ready(function() {
			
		});
		

		var t;
		window.onload=resetTimer;
		window.onload=team2;
		document.onkeypress=resetTimer;
		document.onclick=resetTimer;
		
		
		
		function close_window() {
		    close();
		}
		
		function logout()
		{
			alert('You have been inactive for awhile. \n\nFor security purposes, your session will automatically logout.');
			close_window();
			<?php echo "window.location = '".site_url('account/logout')."';"; ?>
		}
		function resetTimer()
		{
			clearTimeout(t);
			t=setTimeout(logout,900000) //logs out in 15 minutes
		}
		
		function team2()
		{
			var terms = document.getElementById('pterms').value;
			var principal = parseFloat(document.getElementById('financial_amt').value);
			var principal3 = parseFloat(document.getElementById('financial_amt').value);
			
			var min = parseFloat(document.getElementById('min_amt').value);
			var max = parseFloat(document.getElementById('max_amt').value);
			
			$.post( "<?=site_url('account/check_session')?>", {terms:terms} ,function( data ) {
			  if(data.is_login == 0){logout()};
			}, "json");
			
			$.post( "<?=site_url('account/get_start_end_date')?>", {terms:terms} ,function( data ) {
			  $("#start").val(data.po_start_date);
			  $("#end").val(data.po_end_date);
			}, "json");
			
				if(principal != null && principal != 0.00 && isNaN(principal) != 1) 
				{
					if((principal >= min) && (principal <= max || max == 0.00)) 
					{
						var interest = document.getElementById('interest').value;
						var service_fee = document.getElementById('service_charge').value;
						var sc_amort_months = document.getElementById('sc_amort_months').value;
						
						//var commission_fee = document.getElementById('commission').value;
						var mor_mos = 0;//document.getElementById('moratorium_mos').value;
						var ctr = terms;
						var i = interest/12;
						var n = terms;
						var x = (1/i) - (1/(Math.pow(1+i,terms)*i));
						var monthly_amortization = Math.round((principal/x)*100)/100;
						var total_am = 0;
						var total_interest=0;
						var total_deduction;
						var computed_interest;
						var deduction
						var t_service_charge = 0;
						var mo_interest=0;
						var mo_service_charge=0;
						var computed_service_fee = service_fee*principal;
						var mor_interest = ((interest*principal)/12)*mor_mos;
							
						t_service_charge = principal * service_fee;
						
						
							
						var net_proceeds = principal-(mo_interest); // mo_service_charge +
			
						var ctr_int = 1;
						var year_int = 0;
						while (ctr > 0) 
						{
							computed_interest = Math.round((principal*i)*100)/100;
							deduction = Math.round((monthly_amortization - computed_interest)*100)/100;
							principal -= Math.round(deduction*100)/100;
							//total_interest += Math.round(computed_interest*100)/100;
								
							ctr--;
								
							if (principal > 0 && ctr == 0) 
							{
								var principal2;
								principal2 = Math.round(principal*100)/100;
								monthly_amortization += principal2;
								deduction = Math.round((monthly_amortization - computed_interest)*100)/100;
								principal = 0;		
							}
								
							total_deduction += Math.round(deduction*100)/100;
							total_am += monthly_amortization;
							
							if(ctr_int <= 12)
							{
								year_int += computed_interest;
							}
							
							ctr_int++;
						}
							
						total_interest = total_am - principal3;// - computed_service_fee;
						
						var md = total_am / terms;
						var smd = md / 2;
						var semi_sc = 0;
						
						if(sc_amort_months > 0)
						{
							if(terms <= sc_amort_months)
							{
								sc_amort_months = terms;
							}
							semi_sc = smd + (t_service_charge / (sc_amort_months * 2));
						}
							
						//document.getElementById('moratorium_interest').value = mor_interest.toFixed(2);
						document.getElementById('sc_amount').value = computed_service_fee.toFixed(2);	
						document.getElementById('int_charge').value = total_interest.toFixed(2);	
						document.getElementById('year_interest').value = year_int.toFixed(2);	
						document.getElementById('gross_amount').value = numberWithCommas(total_am.toFixed(2));
						document.getElementById('net_proceeds').value = 0;
						//document.getElementById('md_amt').value = Math.round(md);
						document.getElementById('semi').value = numberWithCommas(smd.toFixed(2));
						document.getElementById('semi_w_sc').value = numberWithCommas(semi_sc.toFixed(2));
						document.getElementById('monthly').value = numberWithCommas(md.toFixed(2));
						//computeEndDate();
						//document.forms[0].submit();
						
				} else {
					//document.getElementById('pterms').value = 0;
					document.getElementById('net_proceeds').value = numberWithCommas(max.toFixed(2));
					document.getElementById('financial_amt').value = max.toFixed(2);
					Swal('Invalid amount of principal for min. and max. credit limit!','','error')
					team2();
				}
			} else {
				//document.getElementById('pterms').value = 0;
				document.getElementById('net_proceeds').value = numberWithCommas(max.toFixed(2));
				document.getElementById('financial_amt').value = max.toFixed(2);
				Swal('Invalid amount for principal!','','error');
				team2();
				
			}
		}
		
	</script>


<div id="loader" style="display:none"></div>

	
		
	<script type="text/javascript">
	
	function numberWithCommas(n) {
			
	   	n = parseFloat(n).toFixed(2);
		   	
		var withCommas = Number(n).toLocaleString('en');
			
		return withCommas;
	}
	
	function removeCommas(str) 
	{
		if(str != '')
		{
			while (str.search(",") >= 0) {
	        	str = (str + "").replace(',', '');
	    	}
		}
	    
	    return str;
	};
		
	function recompute() {
		
		var net = document.getElementById("financial_amt").value;
		
		document.getElementById("loanable_amt").value = net;
	    
	    team2();
	    
	    
	}
	
	
	function save()
	{
		swal({
			title: 'Are you sure you want to submit?',
			text: "",
			type: 'info',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, Continue!',
			showLoaderOnConfirm: true,
			
		}).then((result) => {

			if (result.value) {

				$("#body").hide();
				$("#loader").show();
					
				var po_number = '' //walapa
				var dr_number = 'TEST' //walapa
				
				var member_id = $('#member_id').val(); //meron
				var prod_id = $('#prod_id').val(); //meron
				
				var supplier_id = $('#supplier_id').val(); //meron
				var down_payment = 0; //wala
				
				var actual_amount = $('#financial_amt').val(); //meron
				
				var interest = $('#int_charge').val(); //meron
				var interest_rate = $('#interest').val(); ////meron
					
				var commission = 0;
				var commission_rate = 0;
				
				var insurance = 0;
				
				var s_fee = $('#sc_amount').val();
				var s_fee_rate = $('#service_charge').val();
					
				var delivery_receipt = '';
				var w_moratorium = 0;
				var moratorium_months = 0;
				var moratorium_interest = 0;
					
				var net_proceeds = 0;
					
				var po_start_date = $('#start').val();
				var po_end_date = $('#end').val();
					
				var monthly_amor = removeCommas($('#monthly').val());
				var semi_monthly_amor = removeCommas($('#semi').val());
				var collection_type = 1;
					
				var release_type = 0;
				var current = 0;
				var non_current = 0;
					
				var year_interest = $('#year_interest').val();
				var gross_amount = removeCommas($('#gross_amount').val());
					
				var semi_amort_w_sc = 0;
				var semi_amort_wo_sc = 0;
					
				var sc_amort_months = $('#sc_amort_months').val();
				
				var pay_terms = $('#pterms').val(); //meron
					
				var remarks = '';
					
				var action = 'create';

				//check gadget_check_if_within_loanable
				$.post("<?=site_url('account/check_amount_if_within_loanable')?>",
				{actual_amount:actual_amount},
				function(data)
				{

					if(data.ok == 1)
					{
						var item_detail_id = $('#item_detail_id').val();
						//check if gadget still available on stocks
						$.post("<?=site_url('account/check_if_gadget_still_available')?>",
						{item_detail_id:item_detail_id},
						function(data)
						{

							if(data.ok == 1)
							{

								$.post("<?=site_url('account/save_po')?>",
								{
									po_number:po_number,
									dr_number:dr_number,
									member_id:member_id,
									prod_id:prod_id,
									supplier_id:supplier_id,
									down_payment:down_payment,
									gross_amount:gross_amount,
									actual_amount:actual_amount,
									interest:interest,
									interest_rate:interest_rate,
									commission:commission,
									commission_rate:commission_rate,
									insurance:insurance,
									s_fee:s_fee,
									s_fee_rate:s_fee_rate,
									w_moratorium:w_moratorium,
									moratorium_months:moratorium_months,
									moratorium_interest:moratorium_interest,
									po_start_date:po_start_date,
									po_end_date:po_end_date,
									monthly_amor:monthly_amor,
									semi_monthly_amor:semi_monthly_amor,
									pay_terms:pay_terms,
									release_type:release_type,
									net_proceeds:net_proceeds,
									non_current:non_current,
									current:current,
									year_interest:year_interest,
									semi_amort_w_sc:semi_amort_w_sc,
									semi_amort_wo_sc:semi_amort_wo_sc,
									sc_amort_months:sc_amort_months,
									collection_type:collection_type,
									remarks:remarks,
									delivery_receipt:delivery_receipt
								},
								function(data)
								{
									if(data.ok == 1)
									{
										//saving po detail..
										var online_id = data.online_id;

										var item_id = $('#item_id').val();
										
										var unit_cost = $('#unit_cost').val();
										var acq_cost = $('#acq_cost').val();
										var discount = $('#discount').val();
										var serial_number = $('#serial_number').val();
										var qty = $('#qty').val();
										var type = $('#type').val();
										var i_desc = $('#i_desc').val();
										var warranty = $('#warranty').val();
										var agent_id = $('#agent_id').val();
										var location = $('#location').val();
										var released_by = $('#released_by').val();

											$.post("<?=site_url('account/save_po_detail')?>",
											{
												online_id:online_id,
												item_id:item_id,
												item_detail_id:item_detail_id,
												unit_cost:unit_cost,
												acq_cost:acq_cost,
												discount:discount,
												serial_number:serial_number,
												qty:qty,
												type:type,
												i_desc:i_desc,
												warranty:warranty,
												agent_id:agent_id,
												location:location,
												released_by:released_by
											},
											function(data)
											{
											},'json');
											
										//sending email
										var jqxhr = $.post( "https://www.telescoop.com.ph/For_Evaluation/index.php/Welcome/test_send",
                                        {
                                            valid_key:data.valid_key,
                                            ip_address:'<?=$_SERVER['REMOTE_ADDR']?>'
                                        },
                                        function(data) 
										{
											$("#body").show();
											$("#loader").hide();

											if(data.return == 1)
											{
												swal(
												'Success!',
												'Your Loan has been accepted.\nPlease check your email for verification key.',
												'success'
												).then((result) => {
													var doc = window.opener.document;
													var theForm = doc.getElementById("POL_form");
												
													close_window();
													theForm.submit();
												});
											}
											else
											{
												//rollback transaction
                                                $.post("<?=site_url('account/rollback_pol')?>",
                                                {
                                                    online_id:data.online_id
                                                },
                                                function(data)
                                                {

                                                },'json');


                                                swal(
                                                'Email Server Problem!',
                                                'Please try again.',
                                                'error'
                                                ).then((result) => {
                                                    close_window();
                                                });
												
											}

											
											
										},'json').done(function() {
											//alert( "DONE" );
										}).fail(function (jqXHR, textStatus, error) {
											console.log("Post error: " + error);
                                            //rollback transaction
                                            $.post("<?=site_url('account/rollback_pol')?>",{online_id:data.online_id},function(data){},'json');

                                            swal(
                                            'Email Server Problem!',
                                            'Please try again.',
                                            'error'
                                            ).then((result) => {
                                                close_window();
                                            });
										}).always(function() {
											//alert( "EMAIL SUCCESSFULLY SENT!" );
										});
									}
									else
									{
										
										swal(
											'Server Error!',
											'Please try again.',
											'error'
										).then((result) => {
											close_window();
										});
									}
								},'json');
							}
							else
							{
								swal(
									'Stocks error!',
									'Please try again.',
									'error'
								).then((result) => {
									var doc = window.opener.document;
									var theForm = doc.getElementById("POL_form");
								
									close_window();
									theForm.submit();
								});
							}
					
						},'json');	

					}
					else
					{
						swal(
							'Loanable Amount Exceeded!',
							'Please try again.',
							'error'
						).then((result) => {
							var doc = window.opener.document;
							var theForm = doc.getElementById("POL_form");
						
							close_window();
							theForm.submit();
						});
					}
					
				},'json');
				
			}

		})

		
			

/*
	    var request = $.ajax({
	    	type: "GET",
	    	url: "http://119.93.95.162/For_Evaluation/index.php/Welcome/test_send/23299",
	        crossDomain:true, 
	    	success: function(data){
	    		alert(1)
	    	},
	    	dataType: "jsonp",
	    	cache: false,
	    	
    	});
    	
    	request.done(function( msg ) {
		    console.log(123124123);
	    });
	    
	    */
	    
	}
	
	</script>
	
	<style>
	.slidecontainer {
    width: 85%; /* Width of the outside container */
    margin-left: 20px;
}

/* The slider itself */
.slider {
    -webkit-appearance: none;  /* Override default CSS styles */
    appearance: none;
    width: 100%; /* Full-width */
    height: 25px; /* Specified height */
    background: #d3d3d3; /* Grey background */
    outline: none; /* Remove outline */
    opacity: 0.7; /* Set transparency (for mouse-over effects on hover) */
    -webkit-transition: .2s; /* 0.2 seconds transition on hover */
    transition: opacity .2s;
}

/* Mouse-over effects */
.slider:hover {
    opacity: 1; /* Fully shown on mouse-over */
}

/* The slider handle (use -webkit- (Chrome, Opera, Safari, Edge) and -moz- (Firefox) to override default look) */
.slider::-webkit-slider-thumb {
    -webkit-appearance: none; /* Override default look */
    appearance: none;
    width: 25px; /* Set a specific slider handle width */
    height: 25px; /* Slider handle height */
    background: #4CAF50; /* Green background */
    cursor: pointer; /* Cursor on hover */
}

.slider::-moz-range-thumb {
    width: 25px; /* Set a specific slider handle width */
    height: 25px; /* Slider handle height */
    background: #4CAF50; /* Green background */
    cursor: pointer; /* Cursor on hover */
}


.btn-group button {
    background-color: #4CAF50; /* Green background */
    border: 1px solid green; /* Green border */
    color: white; /* White text */
    padding: 10px 24px; /* Some padding */
    cursor: pointer; /* Pointer/hand icon */
    float: left; /* Float the buttons side by side */
}

.btn-group button:not(:last-child) {
    border-right: none; /* Prevent double borders */
}

/* Clear floats (clearfix hack) */
.btn-group:after {
    content: "";
    clear: both;
    display: table;
}

/* Add a background color on hover */
.btn-group button:hover {
    background-color: #3e8e41;
}
	</style>

<div id="body">
			
			<h3 class="primary">
				<i class="icon-book bigger-100"></i>
				&nbsp;GADGET LOAN APPLICATION  <small style="color:blue">NO COMAKER REQUIRED!!</small> 
			</h3>
			
			<hr>
		
			<table id="table_ledger" style="margin-left:5px;width:90%;background:white;margin-top:-10px;font-size:11px; font-family:tahoma; " class="table table-bordered table-condensed table-hover no-footer" cellspacing="10" border="1">
				
				
				<tr>
					<td><strong>MEMBER NAME:</strong></td>
					<td colspan=2 style="font-size:13px"><?=strtoupper($row->mem_lname.', '.$row->mem_fname.' '.$row->mem_mname);?></td>
				</tr>
				<tr>
					<td><strong>CREDIT AVAILABLE:</strong></td>
					<? $loanable = $this->m_account->get_loanable_amount_online($row->member_id);?>
					<td> <x style="font-weight:bold; color:green; font-size:12px;">Php <?=number_format($loanable['loanable_amt'],2);?></x> <small>(<em><strong>As of: <?=date('F j, Y')?>) </strong></em> </small> </td>
				</tr>
				
				<?

							$sql_item = "SELECT * FROM ( 
										SELECT agent_id,item_detail_id,item_id, inv_po_header.date_received,inv_item_detail.item_flag,
										agent_name,item_short_desc,item_long_desc,inv_req_trans_no,inv_req_date
										,inv_req_exchange,serial_series,color,inv_item_detail.unit_cost as u_cost,
										inv_item_requisition_d.qty as qty_a,inv_item_detail.acq_cost,specs
										FROM inv_item_requisition_h
										LEFT JOIN inv_item_requisition_d USING(inv_req_trans_no)
										LEFT JOIN inv_item_detail USING(item_detail_id)
										LEFT JOIN inv_po_header USING (order_id)
										LEFT JOIN inv_prod_items USING(item_id)
										LEFT JOIN stg_sales_agent USING(agent_id)
										WHERE item_detail_id IS NOT NULL AND inv_item_detail.status LIKE '%assigned%'
										AND inv_item_requisition_d.return_number IS NULL
										AND inv_item_detail.item_flag != 'series'
										AND agent_id = 30
										
										
										UNION ALL
										
									  	SELECT agent_id,item_detail_id,item_id,inv_po_header.date_received,inv_item_detail.item_flag,agent_name,item_short_desc,item_long_desc,inv_req_trans_no,inv_req_date,
									  	inv_req_exchange,serial_series,color,inv_item_detail.unit_cost as u_cost,
									  	inv_item_requisition_d.qty as qty_a,inv_item_detail.acq_cost,specs  
									  	FROM inv_item_requisition_h 
									  	LEFT JOIN inv_item_requisition_d USING(inv_req_trans_no)
								      	LEFT JOIN inv_item_detail USING(item_detail_id)
									  	LEFT JOIN inv_po_header USING (order_id)
								      	LEFT JOIN stg_sales_agent USING(agent_id)
								      	LEFT JOIN inv_prod_items USING(item_id)
									  	WHERE inv_item_detail.item_flag = 'series'
									  	AND inv_item_detail.status LIKE '%assigned%'
									  	AND inv_item_requisition_d.return_date IS NULL 
									  	AND agent_id = 30
									
								  	GROUP BY inv_req_trans_no,item_id
								  	) X
								  	
								  	WHERE X.u_cost <= {$loanable['loanable_amt']}
								  	AND X.item_detail_id = $item_detail_id
								  	#GROUP BY X.item_id
							 		ORDER BY X.u_cost,X.date_received";
							 		
							$query = $this->etbms_db->query($sql_item);
							$ctr = 1;
							$row_item = $query->row(); ?>
				
				
				<tr>
				<td><strong>ITEM NAME</strong></td>
				<td style="font-size:13px; color:blue; font-weight:bold"><?=$row_item->item_short_desc.' '.$row_item->item_long_desc?></td>
				</tr>
				
				<tr>
				<td><strong>SERIAL NUMBER / COLOR:</strong></td>
				<td style="font-size:13px"><?=$row_item->serial_series?> / <?=$row_item->color?> </td>
				</tr>
				
				<tr>
				<td><strong>UNIT COST:</strong></td>
				<td style="font-size:13px"><strong>Php <?=number_format($row_item->u_cost,2)?></strong></td>
				</tr>

			
				<input type="hidden" id="item_id" value="<?=$row_item->item_id?>"/>
				<input type="hidden" id="item_detail_id" value="<?=$row_item->item_detail_id?>"/>
				<input type="hidden" id="unit_cost" value="<?=$row_item->u_cost?>"/>
				<input type="hidden" id="acq_cost" value="<?=$row_item->acq_cost?>"/>
				<input type="hidden" id="discount" value="0"/>
				<input type="hidden" id="serial_number" value="<?=$row_item->serial_series?>"/>
				<input type="hidden" id="qty" value="1"/>
				<input type="hidden" id="type" value="2"/>
				<input type="hidden" id="i_desc" value="<?=$row_item->item_short_desc.' '.$row_item->item_long_desc?>"/>
				<input type="hidden" id="warranty" value="12"/>
				<input type="hidden" id="agent_id" value="<?=$row_item->agent_id?>"/>
				<input type="hidden" id="location" value="<?=$row->mem_location?>"/>
				<input type="hidden" id="released_by" value="ONLINE"/>
				
						
			</table>

			<div class="slidecontainer">

				
			
			<h4><x style="color:blue">STEP 1:</x>  SET PAYMENT TERMS:
			
			<select id="pterms" onchange="team2()">
			
			<? $pt_query = $this->etbms_db->query("SELECT * FROM stg_loan_maker 
																   LEFT JOIN stg_loan_maker_pterms USING(line_no)
																   LEFT JOIN stg_payment_terms USING (term_id)
																   WHERE prod_id = 'O-DS01'# AND maker_type = $row->company_id
																   GROUP BY pay_terms
																   ORDER BY pay_terms")?>
			<? foreach($pt_query->result() as $p_terms): ?>
				<option value='<?=$p_terms->pay_terms?>'><?=round($p_terms->pay_terms)?> Months</option>
			<? endforeach; ?>
			</select>
			</h4>

			<? 
			$prod_query = $this->etbms_db->query("SELECT * FROM stg_loan_products WHERE prod_id = 'O-DS01'");
			$row_prod = $prod_query->row();

			$int = ($row_prod->interest_value == 1) ? $row_prod->interest / 100 : $row_prod->interest;
			$sc = ($row_prod->sc_value == 1) ? $row_prod->service_charge / 100 : $row_prod->service_charge;
			?>

			
			<table style="width:1000px">
			<tr>
		  	 	<td>
								
		  	 		<input type="hidden" id="member_id" value="<?=$row->member_id?>"/>
		  	 		<input type="hidden" id="prod_id" value="O-DS01"/>
		  	 		
		  	 		<input type="hidden" id="insurance" value="0"/>
		  	 		<input type="hidden" id="interest" value="<?=$int?>"/>
		  	 		
					<input type="hidden" id="net_proceeds" value="0"/>
		  	 		<input type="hidden" id="sc_amount" value="0"/>
		  	 		<input type="hidden" id="service_charge" value="<?=$sc?>"/>
		  	 		<input type="hidden" id="sc_amort_months" value="0"/>
		  	 		<input type="hidden" id="semi_w_sc" value="0"/>
		  	 		<input type="hidden" id="year_interest" value="0"/>
		  	 		<input type="hidden" id="int_charge" value="0"/>
		  	 		<input type="hidden" id="min_amt" value="0"/>
		  	 		<input type="hidden" id="max_amt" value="<?=$row_item->u_cost?>"/>
		  	 		
		  	 		<input type="hidden" id="financial_amt" value="<?=$row_item->u_cost?>" />
	  	 		</td>

			</tr>
			</table >
				<h4>
			  <table class="table table-bordered">
			   <tr>
			  	<td>GROSS AMOUNT:</td>
			   	<td><input readonly style="text-align:right; font-weight:bold;" id="gross_amount" type="text" value="0"/></td>
			   </tr>
			  <tr>
					
			  <tr>
			  	<td>SEMI MONTHLY:</td>
			   	<td><input readonly style="text-align:right; font-weight:bold;" id="semi" type="text" value="0"/></td>
			   </tr>
			   <tr>
			  	<td>MONTHLY:</td>
			   	<td><input readonly style="text-align:right; font-weight:bold;" id="monthly" type="text" value="0"/></td>
			   </tr>
			    <tr>
			  	<td>START DATE:</td>
			   	<td><input readonly style="text-align:right; font-weight:bold;" id="start" type="text" value="0"/></td>
			   </tr>
			    <tr>
			  	<td>END DATE:</td>
			   	<td><input readonly style="text-align:right; font-weight:bold;" id="end" type="text" value="0"/></td>
			   </tr>
			   
			   </table>
			   
			   
			  </h4>
			  </h4>
				<hr>
				<h4><x style="color:blue">STEP 2:</x> Press <button onclick="save()">&nbsp;SUBMIT NOW&nbsp;</button> </h4>
				
			</div>			
								
	<hr>							
	
</div>	
								
