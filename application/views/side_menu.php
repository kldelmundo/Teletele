<script>
$(document).ready(

	function()
	{
		$("#about_us_side").click(
		function()
		{
		    if( $(".about_us_side").attr("style") == '' ||
		        $(".about_us_side").attr("style") == 'display: block;'
	          ){
		    	 $(".about_us_side").hide();
		    }
			else{
				$(".about_us_side").attr("style, 'display:inline'");
				$(".about_us_side").show();
			}

    	});

    	$("#membership_side").click(
		function()
		{
		    if( $(".membership_side").attr("style") == '' ||
		        $(".membership_side").attr("style") == 'display: block;'
	          ){
		    	 $(".membership_side").hide();
		    }
			else{
				$(".membership_side").attr("style, 'display:inline'");
				$(".membership_side").show();
			}

    	});

    	$("#services_side").click(
		function()
		{
		    if( $(".services_side").attr("style") == '' ||
		        $(".services_side").attr("style") == 'display: block;'
	          ){
		    	 $(".services_side").hide();
		    }
			else{
				$(".services_side").attr("style, 'display:inline'");
				$(".services_side").show();
			}

    	});
    	/*
    	#DO NOT SHOW REPORTS
    	$("#reports_side").click(
		function()
		{
		    if( $(".reports_side").attr("style") == '' ||
		        $(".reports_side").attr("style") == 'display: block;'
	          ){
		    	 $(".reports_side").hide();
		    }
			else{
				$(".reports_side").attr("style, 'display:inline'");
				$(".reports_side").show();
			}

    	});
	    */
	}



);


</script>


<div id="body-right">
		<div class="bg-separator"></div>
		<div id="right-content">

			 <?if(!$this->session->userdata('is_login')):?>


			<?=form_open('account/login')?>
			<table>


						<tr><td class="Thead" colspan="2">MEMBER'S LOGIN</td></tr>

						<tr>

							<td width="10px">Username:</td>
							<td><input style="width:140px" name="myusername" type="text" id="myusername" tabindex="1" autocomplete="off" /></td>
						</tr>
						<tr>
							<td>Password:</td>
							<td><input style="width:140px" name="mypassword" type="password" id="mypassword" tabindex="2" autocomplete="off" /></td>
						</tr>
						<tr>

							<td></td>
							<td><input type="submit" width="15" name="login" value="  Login  "/></td>
						</tr>


					</table>
					<div id="menu">
						<div class="mtitle"><?=anchor('account/request','Create new account')?></div>
						<!--<div class="mtitle"><?=anchor('account/forgot_password','Recover Password')?></div>-->
					</div>


					<!--br>
					<div class="left-title">ADVERTISEMENT</div>

					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>



					<br-->


			<?=form_close();?>
			<br>

			<?else:?>

			<table>


						<tr><td class="Thead" colspan="2">NAVIGATION</td></tr>

			</table>

			<br/>
			<?$name = strtoupper($row->mem_lname.', '.$row->mem_fname);?>

			<div class="left-title">WELCOME <?=$name?>!</div>


			<div id="menu">
				<div class="mtitle"><a href="<?=site_url('account')?>">My Account</a></div>
				<div class="mtitle"><a href="<?=site_url('account/logout/1')?>">Logout</a></div>
			</div>
			<br>
			<?endif;?>

			<table>


						<tr><td class="Thead" colspan="2">QUICK LINKS</td></tr>

			</table>
			<br>
			<div class="left-title" style="cursor:pointer"><a href="<?=site_url('home')?>">Home</div></a>


		 <?if($this->session->userdata('is_login')):?>
		 	<div id="menu" class="about_us_side" style="display:none">
				<div class="mtitle"><a href="<?=site_url('about_us/history')?>">History</a></div>
				<div class="mtitle"><a href="<?=site_url('about_us/vm')?>">Mission & Vision</a></div>
				<div class="mtitle"><a href="<?=site_url('about_us/board')?>">Board of Directors</a></div>
				<div class="mtitle"><a href="<?=site_url('about_us/aic')?>">Audit & Inventory Committee</a></div>
				<div class="mtitle"><a href="<?=site_url('about_us/edcom')?>">Education Committee</a></div>
				<div class="mtitle"><a href="<?=site_url('about_us/staff')?>">TELESCOOP Staff</a></div>
				<br>
			</div>

			<div class="left-title" id="events_side" style="cursor:pointer" ><a href="<?=site_url('home/events')?>">Events</a></div>


			<div class="left-title" id="membership_side" style="cursor:pointer" >Membership</div>

			<div id="menu" class="membership_side" style="display:none">
				<div class="mtitle"><a href="<?=site_url('home/member_req')?>">Membership requirements</a></div>
				<div class="mtitle"><a href="<?=site_url('home/sched_dedn')?>">Schedule of deduction</a></div>
				<div class="mtitle"><a href="<?=site_url('home/duties')?>">Duties & responsibilities</a></div>
				<br>
			</div>
			<div class="left-title" id="benefits_side" style="cursor:pointer" ><a href="<?=site_url('home/benefits')?>">Benefits</a></div>
			<div class="left-title" id="services_side" style="cursor:pointer" ><a href="<?=site_url('home/services')?>">Services</a></div>
			<!--<div id="menu" class="services_side" style="display:none">
				<div class="mtitle"><a href="<?=site_url('home/financial')?>">Financial Loans</a></div>
				<div class="mtitle"><a href="<?=site_url('home/appliance')?>">Appliance Loans</a></div>
				<div class="mtitle"><a href="<?=site_url('home/other')?>">Other Services</a></div>
				<br>
			</div>-->

			<!--div class="left-title" id="reports_side" style="cursor:pointer" >Reports</div>
			<div id="menu" class="reports_side" style="display:none">
				<div class="mtitle"><a href="#" onclick='window.open("<?=FILES_PATH?>2010_highlights.pdf","_blank")'>Comparative Highlights</a></div>
				<div class="mtitle"><a href="#">Financial Statement</a></div>
				<div class="mtitle"><a href="#">Financial Operation</a></div>
				<br>
			</div-->

			<div class="left-title" id="reports_side" style="cursor:pointer" ><a href="<?=site_url('home/contact_us')?>">Contact Us</a></div>
			<!--center style="border-bottom:1px solid #FF9900;cursor:pointer" onclick="window.open('http://www.telescoop.com.ph/webmail')"><img src="<?=IMAGE_PATH?>webmail.gif" style="width:70%" /></center-->
		<?else:?>
		<div class="left-title" id="about_us_side" style="cursor:pointer" >About Us</div>

			<div id="menu" class="about_us_side" style="display:none">
				<div class="mtitle"><a href="<?=site_url('about_us/history')?>">History</a></div>
				<div class="mtitle"><a href="<?=site_url('about_us/vm')?>">Mission & Vision</a></div>
				<div class="mtitle"><a href="<?=site_url('about_us/board')?>">Board of Directors</a></div>
				<div class="mtitle"><a href="<?=site_url('about_us/aic')?>">Audit & Inventory Committee</a></div>
				<div class="mtitle"><a href="<?=site_url('about_us/edcom')?>">Education Committee</a></div>
				<div class="mtitle"><a href="<?=site_url('about_us/staff')?>">TELESCOOP Staff</a></div>
				<br>
			</div>

		<div class="left-title" id="events_side" style="cursor:pointer" ><a href="<?=site_url('home/events')?>">Events</a></div>

		<div class="left-title" id="membership_side" style="cursor:pointer" >Membership</div>
			<div id="menu" class="membership_side" style="display:none">
				<div class="mtitle"><a href="<?=site_url('home/member_req')?>">Membership requirements</a></div>
				<div class="mtitle"><a href="<?=site_url('home/sched_dedn')?>">Schedule of deduction</a></div>
				<div class="mtitle"><a href="<?=site_url('home/duties')?>">Duties & responsibilities</a></div>
				<br>
			</div>

		<div class="left-title" id="benefits_side" style="cursor:pointer" ><a href="<?=site_url('home/benefits')?>">Benefits</a></div>

		<!--<div class="left-title" id="services_side" style="cursor:pointer" ><a href="<?=site_url('home/services')?>">Services</a></div>-->
		<div class="left-title" id="services_side" style="cursor:pointer" ><a href="#">Services</a></div>
			<div id="menu" class="services_side" style="display:none">
				<div class="mtitle"><a href="<?=site_url('home/financial')?>">Financial Loans</a></div>
				<div class="mtitle"><a href="<?=site_url('home/mpl')?>">Multi-Purpose Loans</a></div>
				<div class="mtitle"><a href="<?=site_url('home/fsdl_sr')?>">FSDL SR.</a></div>
				<div class="mtitle"><a href="<?=site_url('home/appliance')?>">Direct Selling</a></div>
				<div class="mtitle"><a href="<?=site_url('home/fsdl_subs')?>">FSDL & Direct Selling (Subs & Aff)</a></div>
				<div class="mtitle"><a href="<?=site_url('home/gift_checks')?>">Gift Checks</a></div>
				<div class="mtitle"><a href="<?=site_url('home/others')?>">Other Services</a></div>
				<br>
			</div>
		<div class="left-title" id="reports_side" style="cursor:pointer" ><a href="<?=site_url('home/contact_us')?>">Contact Us</a></div>

		<?endif;?>
		</div>
</div>
