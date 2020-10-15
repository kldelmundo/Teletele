<!-- MADE TO COMPENSATE THE PROFILE FOR BLISS PROJECT -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

	<META HTTP-EQUIV="Content-type" CONTENT="text/html; charset=UTF-8">
		<TITLE>TELESCOOP - PLDT Employees Multi-Purpose Cooperative</TITLE>
		<LINK REV="made" href="mailto:sysadmin@telescoop.com.ph">

		<meta name="keywords" content="CDA, Philippine Cooperative, list of cooperatives, Cooperative Development Authority, Coop, Co-op, Coop Sector Philippines, Coop Movement, cooperatives, CDA website, Cooperative website, Status of Cooperative Movement" />
	  	<meta name="description" content="TELESCOOP, PLDT cooperative, Know about the Cooperative Development Authority and its work. Learn about the status of the cooperative sector in the Philippines, Cooperative Laws that govern their operation and other stakeholders that advocate cooperativism" />


		<META NAME="author" CONTENT="MIS">
		<META NAME="ROBOTS" CONTENT="ALL">

        <link href='<?=IMAGE_PATH?>logo.png' rel='icon' type='image/jpg'>
        <link rel='stylesheet' href='<?=CSS_PATH?>style.css' type='text/css' charset='utf-8' />
        <link rel='stylesheet' href='<?=CSS_PATH?>thickbox.css' type='text/css' charset='utf-8' />
        <link rel='stylesheet' href='<?=CSS_PATH?>jquery.css' type='text/css' charset='utf-8' />


        <script type="text/JavaScript" src="<?=JS_PATH?>lib.js"></script>
        <script type="text/JavaScript" src="<?=JS_PATH?>jquery.js"></script>
        <script type="text/JavaScript" src="<?=JS_PATH?>ui.core.js"></script>
        <script type="text/JavaScript" src="<?=JS_PATH?>swissarmy.js"></script>



        <script type="text/JavaScript" src="<?=JS_PATH?>thickbox.js"></script>

        <link href="<?=MENU_PATH?>p7exp/p7exp.css" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="<?=JS_PATH?>p7exp/p7exp.js.download"></script>

        <link rel='stylesheet' href='<?=CSS_PATH?>flowtip.css' type='text/css' charset='utf-8' />
        <script type="text/JavaScript" src="<?=JS_PATH?>jquery.tools.min.js"></script>
        <script type="text/JavaScript" src="<?=JS_PATH?>sxi-flowtip.js"></script>
<body>
  <script src="<?=JS_PATH?>sweetalert2/dist/sweetalert2.min.js"></script>
  <link rel="stylesheet" href="<?=JS_PATH?>sweetalert2/dist/sweetalert2.min.css">
  <style>
    .toggler { width: 500px; height: 200px; position: relative; }
    #button { padding: .5em 1em; text-decoration: none; }
    #effect { width: 240px; height: 135px; padding: 0.4em; position: relative; }
    #effect h3 { margin: 0; padding: 0.4em; text-align: center; }
    .ui-effects-transfer { border: 2px dotted gray; }

  #loader {
      position: absolute;
      left: 38%;
      top: 70%;
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

  </style>

  <style>
    /* {box-sizing:border-box}*/

    .mySlides {display:none}

    /* Slideshow container */
    .slideshow-container {
      max-width: 1000px;
      position: relative;
      margin: auto;
    }

    /* Caption text */
    .text {
      color: #f2f2f2;
      font-size: 15px;
      padding: 8px 12px;
      position: absolute;
      bottom: 8px;
      width: 100%;
      text-align: center;
    }

    /* Number text (1/3 etc) */
    .numbertext {
      color: #f2f2f2;
      font-size: 12px;
      padding: 8px 12px;
      position: absolute;
      top: 0;
    }

    /* The dots/bullets/indicators */
    .dot {
      cursor:pointer;
      height: 13px;
      width: 13px;
      margin: 0 2px;
      background-color: #bbb;
      border-radius: 50%;
      display: inline-block;
      transition: background-color 0.6s ease;
    }

    .prev, .next {
      z-index:0;
      cursor: pointer;
      position: absolute;
      top: 50%;
      width: auto;
      margin-top: -22px;

      padding: 16px;
      color: white;
      font-weight: bold;
      font-size: 18px;
      transition: 0.6s ease;
      border-radius: 0 3px 3px 0;
    }

    .prev{
       margin-left:-285px;
    }

    /* Position the "next button" to the right */
    .next {
      margin-right:10px;
      right: 0;
      border-radius: 3px 0 0 3px;
    }

    /* On hover, add a black background color with a little bit see-through */
    .prev:hover, .next:hover {
      background-color: rgba(0,0,0,0.8);
    }

    .active {
      background-color: #717171;
    }

    /* Fading animation */
    .fade {
      -webkit-animation-name: fade;
      -webkit-animation-duration: 1.5s;
      animation-name: fade;
      animation-duration: 1.5s;
    }

    @-webkit-keyframes fade {
      from {opacity: .4}
      to {opacity: 1}
    }

    @keyframes fade {
      from {opacity: .4}
      to {opacity: 1}
    }

    /* On smaller screens, decrease text size */
    @media only screen and (max-width: 300px) {
      .text {font-size: 11px}
    }
  </style>

  <script type="text/JavaScript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <script>


  $(document).ready(function(){

  	<?
  		if(isset($_POST['item_model']) OR isset($_POST['credit_loanable'])) {
  			echo "showContent('POL');";
  		}
  	?>

  	    $('#thickbox').each(function(){
  		    var url = $(this).attr('href') + '?TB_iframe=true&height=500&width=800';
  		    $(this).attr('href', url);
  	    });
  });

  function cancel_loan(online_id)
  {
  	swal({
  		title: 'Are you sure you want to request cancellation for this Loan?',
  		text: "",
  		type: 'info',
  		showCancelButton: true,
  		cancelButtonColor: '#3085d6',
  		confirmButtonColor: '#d33',
  		confirmButtonText: 'Yes, Cancel it!',
  		cancelButtonText: 'No, Process it'

  	}).then((result) => {

  		if(result.value)
  		{
				$("#loader").show();

  			$.get("https://www.telescoop.com.ph/For_Evaluation/index.php/Welcome/test_send_cancel/"+online_id+"/",
  			function(data){
					var member_id = data['member_id'];
					var tests_cancel = $.post( "https://www.telescoop.com.ph/account/POL",
																				{
																					member_id:member_id
																				});


  				swal(
  				'Successfully cancelled!',
  				'',
  				'success'
  				).then((result) => {
						$("#loader").hide();

						var theForm = document.getElementById("POL_form");

						theForm.submit();

  				});

  			},'json');
  		}

  	});

  }


  </script>

	<div id="loader" style="display:none"></div>

  <div id="POL">
    <form id="POL_form" action="<?=site_url($this->uri->uri_string())?>" method="POST">
      <table>
        <tr>
          <td class="Thead" colspan=6>TELESCOOP ONLINE LOAN APPLICATION - NO COMAKER REQUIRED!!! </td>
          </tr>
          <tr>
            <td><strong>MEMBER NAME:</strong></td>
            <td colspan=3 style="font-size:13px"><?=strtoupper($row->mem_lname.', '.$row->mem_fname.' '.$row->mem_mname);?></td>
            <input type="hidden" id="member_id" value="<?=$row->member_id?>"/>
          </tr>
        <tr>

        <!--tr>
          <td><strong>BIRTH DATE:</strong></td>
          <td>	<?=date('F j, Y',strtotime($row->mem_bday));?></td>
          <td><strong>DATE HIRED:</strong></td>
          <td>	<?=date('F j, Y',strtotime($row->mem_hired_date));?></td>
        </tr>

        <tr>
          <td><strong>LOCATION:</strong></td>
          <td><?=$row->mem_location?></td>
          <td><strong>DEPARTMENT:</strong></td>
          <td><?=$row->department_name?></td>
        </tr-->

        <tr>
          <td><strong>CREDIT AVAILABLE:</strong></td>
          <? $loanable = $this->m_account->get_loanable_amount_online($row->member_id);?>
          <input type="hidden" type="text" value="<?=$loanable['loanable_amt']?>" name="credit_loanable"/>
          <td style="font-weight:bold; color:green; font-size:12px;">Php <?=number_format($loanable['loanable_amt'],2);?> <small style='color:black'>(<em><strong>As of: <?=date('F j, Y')?>) </strong></em> </small></td>

          <? if($loanable['loanable_amt'] > 0):?>
          <td colspan=2>
            <button style="cursor:pointer; background: none;color: inherit;border: none;padding: 0;font: inherit;outline: inherit;" onclick="javascript: window.open('<?=site_url('account/avail_now/')?>', 'avail_now', 'scrollbars=1,menubar=0, resizable=0, height=650, width=600'); return false; ">
            <img src="<?=IMAGE_PATH?>button_apply-financial-loan.png" />
            </button>
            <!--button> &nbsp;View Loans Availed&nbsp; </button-->
          </td>
          <?endif?>
        </tr>

      </table>

      <?
        $sql_ol = "SELECT *
               FROM ar_loans_online_header
               LEFT JOIN ar_loans_online_detail USING(online_id)
               WHERE member_id = $row->member_id
               AND po_order_status = 'pending'
               #AND valid_until > NOW()";
        $query_ol = $this->etbms_db->query($sql_ol);
      ?>

      <?if($query_ol->num_rows() > 0):?>

        <br>


        <span class="tag-title">Pending for confirmation:</span>
        <br>
        <table>
          <tr>
            <td class="Thead">#</td>
            <td class="Thead" align="center">Loan&nbsp;ID</td>
            <td class="Thead">Category</td>
            <td class="Thead">Amount</td>
            <td class="Thead">Valid Until</td>
            <td class="Thead">Email Verification Key</td>
          </tr>

          <?
          $ctr = 1;

          foreach($query_ol->result() as $row_ol):?>

          <script>
          // Set the date we're counting down to
          var countDownDate_<?=$ctr?> = new Date("<?=date('M j, Y H:i:s',strtotime($row_ol->valid_until))?>").getTime();

          //timeAfterMins_<?=$ctr?> = new Date(countDownDate_<?=$ctr?>.setMinutes(countDownDate_<?=$ctr?>.getMinutes() + 30));

          //alert(timeAfterMins_<?=$ctr?>);

          // Update the count down every 1 second
          var x_<?=$ctr?> = setInterval(function()
          {

            // Get todays date and time
            var now_<?=$ctr?> = new Date().getTime();

            // Find the distance between now an the count down date
            var distance_<?=$ctr?> = countDownDate_<?=$ctr?> - now_<?=$ctr?>;

            // Time calculations for days, hours, minutes and seconds
            var days_<?=$ctr?> = Math.floor(distance_<?=$ctr?> / (1000 * 60 * 60 * 24));
            var hours_<?=$ctr?> = Math.floor((distance_<?=$ctr?> % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes_<?=$ctr?> = Math.floor((distance_<?=$ctr?> % (1000 * 60 * 60)) / (1000 * 60));
            var seconds_<?=$ctr?> = Math.floor((distance_<?=$ctr?> % (1000 * 60)) / 1000);

            // Display the result in the element with id="demo"  days_<?=$ctr?> + "d " + hours_<?=$ctr?> + "h "
            document.getElementById("demo_<?=$ctr?>").innerHTML = "<x style='color:green'>" + minutes_<?=$ctr?> + "m " + seconds_<?=$ctr?> + "s </x>";

            // If the count down is finished, write some text
            if (distance_<?=$ctr?> < 0)
            {
              clearInterval(x_<?=$ctr?>);
              document.getElementById("demo_<?=$ctr?>").innerHTML = "<x style='color:red'>EXPIRED<x>";
              $("#valid_key_<?=$ctr?>").attr("disabled", "disabled");
              $("#conf_btn_<?=$ctr?>").attr("disabled", "disabled");

              //auto cancelled via post

              var online_id = <?=$row_ol->online_id?>;

              $.post("<?=site_url('account/cancelled_expired')?>",
              {online_id: online_id},function(data){},'json');
            }


          }, 1000);
          </script>


          <tr>
            <td style="color:black; font-weight:bold"><?=$ctr?></td>
            <td style="color:black; font-weight:bold" align="center"><?=setLength($row_ol->online_id)?></td>
            <td style="color:blue; font-weight:bold"><?=$row_ol->prod_id=='O-FS01'?'FINANCIAL':'GADGET '?></td>
            <td style="font-weight:bold; color:black;">Php <?=number_format($row_ol->actual_amount,2)?></td>
            <td align="center" id="demo_<?=$ctr?>"></td>
            <td>

              <input id="valid_key_<?=$ctr?>" style='width:150px' type="text" placeholder=" --ENTER KEY HERE-- "><?=$ctr;?>
              <button id="conf_btn_<?=$ctr?>" style="cursor:pointer" onclick="check_validation_key(<?=$ctr++?>); return false;"> &nbsp;Confirm&nbsp; </button>
              <?if($row_ol->prod_id=='O-FS01'):?>
              <button style="cursor:pointer" onclick="javascript: window.open('<?=site_url('account/view_fin_loan/'.$row_ol->online_id)?>', 'view_loan', 'scrollbars=1,menubar=0, resizable=0, height=650, width=500'); return false;" > &nbsp;View&nbsp; </button>
              <?else:?>
              <button style="cursor:pointer" onclick="javascript: window.open('<?=site_url('account/view_gadget_loan/'.$row_ol->item_detail_id)?>', 'view_loan', 'scrollbars=1,menubar=0, resizable=0, height=580, width=520'); return false;" > &nbsp;View&nbsp; </button>
              <?endif?>
            </td>
          </tr>
          <?endforeach?>
        </table>
        <br>

      <?endif?>

      <?
        $sql_ol = "SELECT *
               FROM ar_loans_online_header
               LEFT JOIN ar_loans_online_detail USING(online_id)
               WHERE member_id = $row->member_id
               AND po_order_status IN ('confirmed','processing')
               ";
        $query_ol = $this->etbms_db->query($sql_ol);
      ?>

      <?if($query_ol->num_rows() > 0):?>

        <br>


        <span class="tag-title">Active Loan for processing:</span>
        <br>
        <table>
          <tr>
            <td class="Thead">#</td>
            <td class="Thead" align="center">Loan&nbsp;ID</td>
            <td class="Thead" align="center">Datetime</td>
            <td class="Thead">Category</td>
            <td class="Thead">Amount</td>
            <td class="Thead" align="center">Time/Status</td>
            <td class="Thead" align="center">Action</td>
          </tr>

          <?
          $ctr = 1;

          foreach($query_ol->result() as $row_ol):?>

          <script>
          // Set the date we're counting down to
          var XcountDownDate_<?=$ctr?> = new Date("<?=date('M j, Y H:i:s',strtotime($row_ol->cancel_until))?>").getTime();

          //timeAfterMins_<?=$ctr?> = new Date(countDownDate_<?=$ctr?>.setMinutes(countDownDate_<?=$ctr?>.getMinutes() + 30));

          //alert(timeAfterMins_<?=$ctr?>);

          // Update the count down every 1 second
          var Xx_<?=$ctr?> = setInterval(function() {

          // Get todays date and time
          var Xnow_<?=$ctr?> = new Date().getTime();

          // Find the distance between now an the count down date
          var Xdistance_<?=$ctr?> = XcountDownDate_<?=$ctr?> - Xnow_<?=$ctr?>;

          // Time calculations for days, hours, minutes and seconds
          var Xdays_<?=$ctr?> = Math.floor(Xdistance_<?=$ctr?> / (1000 * 60 * 60 * 24));
          var Xhours_<?=$ctr?> = Math.floor((Xdistance_<?=$ctr?> % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
          var Xminutes_<?=$ctr?> = Math.floor((Xdistance_<?=$ctr?> % (1000 * 60 * 60)) / (1000 * 60));
          var Xseconds_<?=$ctr?> = Math.floor((Xdistance_<?=$ctr?> % (1000 * 60)) / 1000);

          // Display the result in the element with id="demo"  days_<?=$ctr?> + "d " + hours_<?=$ctr?> + "h "
          document.getElementById("Xdemo_<?=$ctr?>").innerHTML = "<x style='color:green'>" + Xminutes_<?=$ctr?> + "m " + Xseconds_<?=$ctr?> + "s </x>";

          // If the count down is finished, write some text
          if (Xdistance_<?=$ctr?> < 0) {
            clearInterval(Xx_<?=$ctr?>);
            document.getElementById("Xdemo_<?=$ctr?>").innerHTML = "<x style='color:green'>PROCESSING<x>";

          }
          }, 1000);
          </script>


          <tr>
            <td style="color:black; font-weight:bold"><?=$ctr?></td>
            <td style="color:black; font-weight:bold" align="center"><?=setLength($row_ol->online_id)?></td>
            <td style="color:black; font-weight:bold" align="center"><?=date('M j g:ia',strtotime($row_ol->created_date))?></td>
            <td style="color:blue; font-weight:bold"><?=$row_ol->prod_id=='O-FS01'?'FINANCIAL':'GADGET '?></td>
            <td style="font-weight:bold; color:black;">Php <?=number_format($row_ol->actual_amount,2)?></td>
            <td align="center" id="Xdemo_<?=$ctr++?>"></td>
            <td align="center">
              <?if($row_ol->po_order_status == 'processing'):?>

                <?if($row_ol->prod_id=='O-FS01'):?>
                <button style="cursor:pointer" onclick="javascript: window.open('<?=site_url('account/view_fin_loan/'.$row_ol->online_id)?>', 'view_loan', 'scrollbars=1,menubar=0, resizable=0, height=650, width=500'); return false;" > &nbsp;View&nbsp; </button>
                <?else:?>
                <button style="cursor:pointer" onclick="javascript: window.open('<?=site_url('account/view_gadget_loan/'.$row_ol->item_detail_id)?>', 'view_loan', 'scrollbars=1,menubar=0, resizable=0, height=580, width=520'); return false;" > &nbsp;View&nbsp; </button>
                <?endif?>

              <?else:?>
              <button style="cursor:pointer" onclick="cancel_loan(<?=$row_ol->online_id?>); return false;"> &nbsp;Request to cancel&nbsp; </button>

                <?if($row_ol->prod_id=='O-FS01'):?>
                <button style="cursor:pointer" onclick="javascript: window.open('<?=site_url('account/view_fin_loan/'.$row_ol->online_id)?>', 'view_loan', 'scrollbars=1,menubar=0, resizable=0, height=650, width=500'); return false;" > &nbsp;View&nbsp; </button>
                <?else:?>
                <button style="cursor:pointer" onclick="javascript: window.open('<?=site_url('account/view_gadget_loan/'.$row_ol->item_detail_id)?>', 'view_loan', 'scrollbars=1,menubar=0, resizable=0, height=580, width=520'); return false;" > &nbsp;View&nbsp; </button>
                <?endif?>

              <?endif?>
            </td>
          </tr>
          <?endforeach?>
        </table>
        <br>

      <?endif?>

      <? if($loanable['loanable_amt'] > 0):?>

        <!--span class="tag-title">Apply Financial Loan:</span>
        <br>
        <table>
          <tr>
            <td class="Thead">#</td>
            <td class="Thead">PO Name</td>
            <td class="Thead" align="center">Loanable Amount</td>
            <td class="Thead" align="center">Action</td>
          </tr>

          <tr>
            <td style="color:black; font-weight:bold">1</td>
            <td style="color:blue; font-weight:bold">ONLINE FINANCIAL LOAN</td>
            <td  style="font-weight:bold; color:black;" align="center">Up to <?=number_format($loanable['loanable_amt'],2)?></td>
            <td align="center">


            </td>
          </tr>
        </table-->

        <br>
          <?
          $sql_item_m = "SELECT *
                   FROM (
                    SELECT item_detail_id,item_id, inv_po_header.date_received,inv_item_detail.item_flag,
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

                    SELECT item_detail_id,item_id,inv_po_header.date_received,inv_item_detail.item_flag,agent_name,item_short_desc,item_long_desc,inv_req_trans_no,inv_req_date,
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
                    GROUP BY item_short_desc
                  ) X
                WHERE X.u_cost <= {$loanable['loanable_amt']}
                AND X.item_detail_id NOT IN (
                                SELECT item_detail_id
                                FROM ar_loans_online_detail
                                LEFT JOIN ar_loans_online_header USING(online_id)
                                WHERE po_order_status IN ('confirmed','pending')
                              )
                #exclude pending GADGETS
                GROUP BY X.item_short_desc";
          #echo $sql_item_m;
          $query_model = $this->etbms_db->query($sql_item_m);
				#	echo $this->etbms_db->last_query();

          ?>
          <span class="tag-title">Gadget Loan: </span>
          <br>

          <table>

          <tr>
            <td style="width:10px" align="center" class="Thead">#</td>
            <td class="Thead" width="260px">

              ITEM MODEL

              <x style="float:right">
              <select name="item_model" onchange="submit()">
                <option value=''>ALL</option>
                <?foreach($query_model->result() as $row_model):?>
                <? if($_POST['item_model'] == $row_model->item_short_desc):?>
                <option selected value='<?=$row_model->item_short_desc?>'><?=$row_model->item_short_desc?></option>
                <? else:?>
                <option value='<?=$row_model->item_short_desc?>'><?=$row_model->item_short_desc?></option>
                <?endif?>
                <?endforeach?>
              </select>
              </x>
            </td>
            <td style="width:23px" class="Thead" align="center">SPECS</td>
            <td style="width:23px" class="Thead" align="center">UNIT COST</td>
            <td style="width:85px" class="Thead" align="center">ACTION</td>
          </tr>
        <?
        $where = '';
          if(isset($_POST['item_model']) AND !empty($_POST['item_model'])) {
            $where = " AND X.item_short_desc = '{$_POST['item_model']}' ";
          }
        $sql_item = "SELECT * FROM (
                SELECT item_detail_id,item_id, inv_po_header.date_received,inv_item_detail.item_flag,
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

                  SELECT item_detail_id,item_id,inv_po_header.date_received,inv_item_detail.item_flag,agent_name,item_short_desc,item_long_desc,inv_req_trans_no,inv_req_date,
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
                $where
              AND X.item_detail_id NOT IN (
                              SELECT item_detail_id
                              FROM ar_loans_online_detail
                              LEFT JOIN ar_loans_online_header USING(online_id)
                              WHERE po_order_status IN ('confirmed','pending')
                            )
                #GROUP BY X.item_id
              ORDER BY X.u_cost,X.date_received";

          $query = $this->etbms_db->query($sql_item);
          $ctr = 1;
          foreach($query->result() as $row_item): ?>
            <tr>
              <td align="center" style="color:black; font-weight:bold"><?=$ctr++?></td>
              <td >
                <x style="font-weight:bold; color:blue"><?=strtoupper($row_item->item_short_desc.'-'.$row_item->item_long_desc)?>  </x>
                <br>
                <small><strong>S/N:</strong> <?=$row_item->serial_series?> <strong>COLOR:</strong> <?=strtoupper($row_item->color)?></small>

              </td>
              <td style="color:red" align="center">
                <? if(!empty($row_item->specs)): ?>
                <a onclick="javascript: window.open('<?=$row_item->specs?>', 'gsmarena', 'scrollbars=1,menubar=0, resizable=0, height=650, width=1080');" href="#">SEE&nbsp;SPECS</a>
                <? else:?>
                N/A
                <?endif?>
              </td>
              <td style="font-weight:bold; color:black" align="center">Php&nbsp;<?=number_format($row_item->u_cost,2)?></td>

              <td align="center">
                <button style="cursor:pointer; background: none;color: inherit;border: none;padding: 0;font: inherit;outline: inherit;" onclick="javascript: window.open('<?=site_url('account/avail_gadget_now/'.$row_item->item_detail_id)?>', 'avail_now_gadget', 'scrollbars=1,menubar=0, resizable=0, height=600, width=550'); return false; ">
                <img src="<?=IMAGE_PATH?>button_avail-now.png" />
                </button>

              </td>
            </tr>
            <!--tr>

              <td align="center">
                 <a onclick="javascript: window.open('https://www.google.com/search?tbm=isch&q=<?=str_replace(' ','+',$row_item->item_short_desc.'+'.$row_item->item_long_desc)?>', 'printable1', 'scrollbars=1,menubar=0, resizable=0, height=650, width=1005');" href="#">VIEW IMAGES</a> </td>
            </tr-->
          <?endforeach;?>

          <?if($query->num_rows() == 0):?>
            <tr>
              <td align="center" colspan=5>NO AVAILABLE ITEMS</td>
            </tr>
          <?endif?>

        </table>
        </form>
      <?endif?>
    </div>


    <script>

  	var slideIndex = 1;
  	showSlides(slideIndex);

  	setInterval(function(){ autoSlides(); }, 5000);

  	function autoSlides() {
  	var slides = document.getElementsByClassName("mySlides");

  	if (slideIndex > slides.length) {slideIndex = 1}
  	else {slideIndex++ }
  	showSlides(slideIndex);
  	}

  	function plusSlides(n) {
  		showSlides(slideIndex += n);
  	}

  	function currentSlide(n) {
  		showSlides(slideIndex = n);
  	}

  	function showSlides(n)
  	{
  		var i;
  		var slides = document.getElementsByClassName("mySlides");
  		var dots = document.getElementsByClassName("dot");
  		//alert(n.' x '.slides.length)
  		if (n > slides.length) {slideIndex = 1}
  		if (n < 1) {slideIndex = slides.length}
  		for (i = 0; i < slides.length; i++) {
  			slides[i].style.display = "none";
  		}
  		for (i = 0; i < dots.length; i++) {
  			dots[i].className = dots[i].className.replace(" active", "");
  		}
  		slides[slideIndex-1].style.display = "block";
  		dots[slideIndex-1].className += " active";
  	}

  	function check_validation_key(ctr)
  	{
  		var valid_key = document.getElementById("valid_key_"+ctr).value;
  		var member_id = document.getElementById("member_id").value;

  		$.post( "<?=site_url('account/check_validation_key')?>", {valid_key:valid_key, member_id:member_id} ,function( data ) {
  			if(data.ok == 0){
  				Swal('Wrong verification key! ','Please try again!','error')
  			}else{

  				swal.showLoading();

  				//sending email
  				$.get( "https://www.telescoop.com.ph/For_Evaluation/index.php/Welcome/test_send_confirm/"+valid_key+"/", function(data)
  				{
  					if(data.return_nya == "success")
  					{
							var tests = $.post( "https://www.telescoop.com.ph/account/POL",
																						{
																							member_id:member_id
																						});
  						// showContent("POL");

  						swal(
  							'Your loan has been confirmed.','Now ready for processing..','success'
  						).then((result) => {

  							var theForm = document.getElementById("POL_form");

  							theForm.submit();
  						});
  					}
  					else
  					{
  						swal(
  						'Email Server Problem!',
  						'Please try again.',
  						'error'
  						).then((result) => {
  							close_window();
  						});

  					}


  				},'json');
  			}
  		}, "json");

  	}



  	</script>
