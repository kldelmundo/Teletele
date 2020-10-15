
<?session_start()?>
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
	<script type="text/javascript" src="<?=JS_PATH?>p7exp/p7exp.js"></script>

	<link rel='stylesheet' href='<?=CSS_PATH?>flowtip.css' type='text/css' charset='utf-8' />
	<script type="text/JavaScript" src="<?=JS_PATH?>jquery.tools.min.js"></script>
	<script type="text/JavaScript" src="<?=JS_PATH?>sxi-flowtip.js"></script>



	<!--[if lte IE 7]>
	<style>
	#menuwrapper, #p7menubar ul a {height: 1%;}
	a:active {width: auto;}
	</style>
	<![endif]-->




<body onLoad="P7_ExpMenu();">

<?if($this->session->userdata('is_login')):?>
	<script type="text/javascript">
		var t;
		window.onload=resetTimer;
		document.onkeypress=resetTimer;
		document.onclick=resetTimer;

		function logout()
		{
			alert('You have been inactive for awhile. \n\nFor security purposes, your session will automatically logout.');
			<?php echo "window.location = '".site_url('account/logout')."';"; ?>
		}
		function resetTimer()
		{
			clearTimeout(t);
			t=setTimeout(logout,900000) //logs out in 15 minutes
		}
	</script>
<?endif?>


<div id="outer">
	<div id="wrapper">
		<div id="banner">

			<div id="menuwrapper">

			<ul id="p7menubar">



				 <?if($this->session->userdata('is_login')):?>
				<li><a href="<?=site_url('account/logout')?>">Logout</a></li>
				<!--<li><a href="<?=site_url('home/cart')?>">Shop</a></li>-->




				<?endif?>

				 <li>
				 <?if($this->session->userdata('is_login')):?>
				<a href="<?=site_url('account')?>">My Account </a>
				 <?else:?>
				<a href="<?=site_url('account/login')?>">Login</a>
				 <?endif?>

				</li>

				 <?if($this->session->userdata('is_login')):?>
				<li><a href="<?=site_url('home/contact_us')?>">Contact Us</a></li>
				<!--li><a href="#">Reports</a>
					<ul>
						<li><a href="#" onclick='window.open("<?=FILES_PATH?>2010_highlights.pdf","_blank")'>Comparative Highlights</a></li>
						<li><a href="#">Financial Statement</a></li>
						<li><a href="#">Financial Operation</a></li>
					</ul>
				</li-->
				<li><a class="#" href="#">Services</a>
				<!--<li><a class="#" href="<?=site_url('home/services')?>">Services</a>-->

					<!-- attys data needed -->
				<ul>
						<li><a href="<?=site_url('home/financial')?>">Financial Loans</a></li>
						<li><a href="<?=site_url('home/mpl')?>">Multi-Purpose Loans</a></li>
						<li><a href="<?=site_url('home/fsdl_sr')?>">FSDL SR.</a></li>
						<li><a href="<?=site_url('home/appliance')?>">Direct Selling</a></li>
						<li><a href="<?=site_url('home/fsdl_subs')?>">FSDL & Direct Selling (Subs & Aff)</a></li>
						<li><a href="<?=site_url('home/gift_checks')?>">Gift Checks</a></li>
						<li><a href="<?=site_url('home/shell_gas_card')?>">Shell Gas Card</a></li>
						<li><a href="<?=site_url('home/others')?>">Other Services</a></li>

					</ul>
				</li>
				<li><a href="<?=site_url('home/benefits')?>">Benefits</a>
					<!--ul>
						<li><a href="<?=site_url('home/tbp')?>">TELESCOOP benefit plan</a></li>
						<li><a href="<?=site_url('home/rbp')?>">Retirement benefit plan</a></li>


					</ul-->
				</li>

				<li><a href="#">Membership</a>
					<ul>
						<li><a href="<?=site_url('home/member_req')?>">Qualification for Membership</a></li>
						<li><a href="<?=site_url('home/duties')?>">Duties & Reponsibilies</a></li>
						<li><a href="<?=site_url('home/mem_resignation')?>">Resignation of Membership</a></li>
						<li><a href="<?=site_url('home/sched_dedn')?>">Schedule of deduction</a></li>



					</ul>
				</li>
				<li><a href="<?=site_url('home/events')?>">Events</a></li>


				<li><a href="#">About Us</a>
					<ul>
						<li><a href="<?=site_url('about_us/history')?>">History</a></li>
						<li><a href="<?=site_url('about_us/vm')?>">Mission & Vision</a></li>
						<li><a href="<?=site_url('about_us/board')?>">Board of Directors</a></li>
						<li><a href="<?=site_url('about_us/aic')?>">Audit Commitee</a></li>
						<li><a href="<?=site_url('about_us/edcom')?>">Education Committee</a></li>
						<li><a href="<?=site_url('about_us/comelec')?>">Election Committee</a></li>
						<li><a href="<?=site_url('about_us/mediation')?>">Mediation & Conciliation Committee</a></li>
						<li><a href="<?=site_url('about_us/gad')?>">Gender & Development Committee</a></li>
						<li><a href="<?=site_url('about_us/ethics')?>">Ethics Committee</a></li>
						<li><a href="<?=site_url('about_us/staff')?>">TELESCOOP Staff</a></li>
					</ul>

				</li>


				 <?else:?>


				 <li><a href="<?=site_url('home/contact_us')?>">Contact Us</a></li>


				 <li><a class="#" href="#">Services</a>
				 <!--<li><a class="#" href="<?=site_url('home/services')?>">Services</a>-->
					<ul>
						<li><a href="<?=site_url('home/financial')?>">Financial Loans</a></li>
						<li><a href="<?=site_url('home/mpl')?>">Multi-Purpose Loans</a></li>
						<li><a href="<?=site_url('home/fsdl_sr')?>">FSDL SR.</a></li>
						<li><a href="<?=site_url('home/appliance')?>">Direct Selling</a></li>
						<li><a href="<?=site_url('home/fsdl_subs')?>">FSDL & Direct Selling (Subs & Aff)</a></li>
						<li><a href="<?=site_url('home/gift_checks')?>">Gift Checks</a></li>
						<li><a href="<?=site_url('home/shell_gas_card')?>">Shell Gas Card</a></li>
						<li><a href="<?=site_url('home/others')?>">Other Services</a></li>

					</ul>

				 <li><a href="<?=site_url('home/benefits')?>">Benefits</a></li>

				 <li><a href="#">Membership</a>
					<ul>
						<li><a href="<?=site_url('home/member_req')?>">Qualification for Membership</a></li>
						<li><a href="<?=site_url('home/duties')?>">Duties & Reponsibilies</a></li>
						<li><a href="<?=site_url('home/mem_resignation')?>">Resignation of Membership</a></li>
						<li><a href="<?=site_url('home/sched_dedn')?>">Schedule of deduction</a></li>

					</ul>
				</li>

				<li><a href="<?=site_url('home/events')?>">Events</a></li>

				 <li><a href="#">About Us</a>
					<ul>
						<li><a href="<?=site_url('about_us/history')?>">History</a></li>
						<li><a href="<?=site_url('about_us/vm')?>">Mission & Vision</a></li>
						<li><a href="<?=site_url('about_us/board')?>">Board of Directors</a></li>
						<li><a href="<?=site_url('about_us/aic')?>">Audit Commitee</a></li>
						<li><a href="<?=site_url('about_us/edcom')?>">Education Commitee</a></li>
						<li><a href="<?=site_url('about_us/comelec')?>">Election Commitee</a></li>
						<li><a href="<?=site_url('about_us/mediation')?>">Mediation & Conciliation Committee</a></li>
						<li><a href="<?=site_url('about_us/gad')?>">Gender & Development Committee</a></li>
						<li><a href="<?=site_url('about_us/ethics')?>">Ethics Committee</a></li>
						<li><a href="<?=site_url('about_us/staff')?>">TELESCOOP Staff</a></li>
					</ul>

				</li>
				 <?endif?>

				<li><a href="<?=site_url('home')?>">Home</a></li>
			</ul>
			</div>
		</div>

		<div id="body">
			<div id="banner-down"></div>
			<center>


				<?=$this->load->view($body);?>

				<?if(isset($has_side_menu) AND $has_side_menu == TRUE):?>
				<?=$this->load->view('side_menu');?>
				<?endif;?>

			</center>
			<div class="clear"></div>
		</div>




		<div id="FOOTER">
			<p>Copyright &copy; <?=date('Y')?> - www.TELESCOOP.com.ph - All rights reserved</p>
			<p>For your comments and suggestions please email us at: <a href="mailto:sysadmin@telescoop.com.ph">sysadmin@telescoop.com.ph</a></p>

		</div>
	</div>
	<!--END OD ID=WRAPPER-->
</div>
<!--END OD ID=OUTER-->

<?if($this->session->userdata('is_login')):?>

<!--Start of Tawk.to Script-->
<script type="text/javascript">

var Tawk_API = Tawk_API || {};
Tawk_API.visitor = {
	name  : '<?php echo ucwords(strtolower($this->session->userdata("name"))) ?>',
	email : '<?php echo $this->session->userdata("email"); ?>',
	hash  : '<?php echo hash_hmac("sha256", $this->session->userdata("email"), "8cd1526a9833a2c1197522397d9ca8aaab0eb025"); ?>'
};




(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/577fc4b31ca3e686763c0200/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->


<?else:?>

<!--Start of Tawk.to Script-->
<script type="text/javascript">
var $_Tawk_API={},$_Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/577fc4b31ca3e686763c0200/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->

<?endif?>



</body>
</html>
