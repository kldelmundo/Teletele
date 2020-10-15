<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Security-Policy" content="policy-definition; charset=utf-8"/>
	<meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self' *.mycdn.com 'unsafe-inline';">
	<title>TELESCOOP | PLDT Employees Multi-Purpose Cooperative </title>
	<!--link href='images/icon.jpg' rel='icon' type='image/jpg'/-->
	<link rel='stylesheet' href='<?=CSS_PATH?>style.css' type='text/css' charset='utf-8' />

	<script type="text/javascript" src="<?=JS_PATH?>accordian.pack.js"></script>
	<script type="text/JavaScript" src="<?=JS_PATH?>lib.js"></script>

	<link href="<?=MENU_PATH?>p7exp/p7exp.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="<?=JS_PATH?>p7exp/p7exp.js"></script>
	<!--[if lte IE 7]>
	<style>
	#menuwrapper, #p7menubar ul a {height: 1%;}
	a:active {width: auto;}
	</style>
	<![endif]-->
<?php
//Tell browser site should only be loaded over https
header("Strict-Transport-Security:max-age=63072000");
?>
</head>

<body onLoad=" P7_ExpMenu(); new Accordian('menu-style',2,'openmenu');">
<div id="outer">
	<div id="wrapper">
		<div id="banner">
			<div id="menuwrapper">

			<ul id="p7menubar">
				<li><a href="#">My Account</a></li>
				<li><a href="#">Contact Us</a></li>
				<li><a class="#" href="#">Loan Products</a>
				<ul>
					<li><a href="#">Financial</a></li>
					<li><a href="#">Appliance</a></li>

				</ul>
				</li>
				<li><a href="#">About Us</a></li>
				<li><a href="#">Home</a></li>
			</ul>
			</div>
		</div>

		<div id="body">
			<div id="banner-down"></div>
			<center>
								<div id="login">
					<form name="form1" method="post" action="#">
					<table>
						<tr><td class="Thead" colspan="3">LOGIN</td></tr>
						<tr>

							<td>Username :</td>
							<td><input name="myusername" type="text" id="myusername" tabindex="1"/></td>
						</tr>
						<tr>
							<td>Password :</td>
							<td><input name="mypassword" type="password" id="mypassword" tabindex="2" /></td>
						</tr>
						<tr>

							<td></td>
							<td><input type="submit" width="15" value="  OK  "/></td>
						</tr>
					</table>
					</form>
				</div>
				<div class="info">
					<p>Security Purposes: You must login to view this site. </p>

				</div>
			</center>
			<div class="clear"></div>
		</div>
		<!-- BODY TAG END -->
		<div id="FOOTER">
			<p>&copy; 2012 - PLDT Employees Multi-Purpose Cooperative (TELESCOOP)</p>
			<p>For your comments and suggestions please email us at: <a href="mailto:mis@telescoop.com.ph">webteam@telescoop.com.ph</a></p>

		</div>
	</div>
	<!--END OD ID=WRAPPER-->
</div>
<!--END OD ID=OUTER-->

</body>
</html>
