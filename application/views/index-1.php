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

        <link href='<?=IMAGE_PATH?>iconteles.png' rel='icon' type='image/png'>

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

<?

  $member_id = $this->session->userdata('member_id');
  $query = $this->db->get_where('telescoop_web.member_sys_access',array('member_id'=>$member_id));
  $count = $this->db->get_where('telescoop_web.member_sys_access',array('access_status'=>2));
  $count2 = $this->db->get_where('telescoop_web.member_sys_inquiry',array('status'=>0));

  ?>


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

    <div id="menuwrapper">

            <img src="<?=IMAGE_PATH?>iconteles.png" style="height:75px; float: left; top: 18px; position: absolute; padding-left: 35px;">

            <ul id="p7menubar">



                <?if($this->session->userdata('is_login')):?>

                    <li><a href="<?=site_url('account/logout')?>" onmouseover="this.style.backgroundColor='#b06328'"  onmouseout="this.style.backgroundColor='#3b5a51'"
                       style="background-color:#3b5a51; font-family:Akrobat;"> Logout</a></li>





               <li>
                    <a href="#" onmouseover="this.style.backgroundColor='#3b5a51'"  onmouseout="this.style.backgroundColor='#c47946'"
                       style="background-color:#c47946; font-family:Akrobat;"> Settings</a>

                   <ul>
                         <li style="font-family:Akrobat;"><a href="<?=site_url('account/change_pwd')?>" >Change Password</a></li>
                         <li style="font-family:Akrobat;"><a href="<?=site_url('account/notify')?>">Notification Settings</a></li>
                         <li style="font-family:Akrobat;"><a href="<?=site_url('account/inq')?>">Inquiry Form</a></li>
                         <? if($query->row('access_levels') == 1):?>
                         <li style="font-family:Akrobat;"><a href="<?=site_url('account/for_evaluation')?>" target="_blank" onclick="window.open(this.href, 'mywin','width=930,height=450,resizable=0'); return false;">For Evaluation (<?=$count->num_rows();?>)</a></li>
                         <li style="font-family:Akrobat;"><a href="<?=site_url('account/inquiries')?>" target="_blank" onclick="window.open(this.href, 'mywin','width=930,height=450,resizable=0'); return false;">Inquiries (<?=$count2->num_rows();?>)</a></li>
                         <?endif?>
                    </ul>

                </li>
                <!--<li><a href="<?=site_url('home/cart')?>">Shop</a></li>-->
                <?endif?>

                <li>
                <?if($this->session->userdata('is_login')):?>

                        <a href="#" onmouseover="this.style.backgroundColor='#3b5a51'"  onmouseout="this.style.backgroundColor='#c47946'"
                               style="background-color:#c47946; font-family: Akrobat;">My Account </a>
                        <ul>
                            <li style="font-family:Akrobat;"><a href="<?=site_url('account/profile')?>">My Profile</a></li>
                            <li style="font-family:Akrobat;"><a href="<?=site_url('account/ledger')?>" target="_blank" onclick="window.open(this.href, 'mywin',
'width=930,height=450,resizable=0'); return false;">Subsidiary Ledger</a></li>
                            <li style="font-family:Akrobat;"><a href="<?=site_url('account/comakers')?>" target="_blank" onclick="window.open(this.href, 'mywin',
'width=930,height=450,resizable=0'); return false;">Co-Maker Exposure</a></li>
                            <li style="font-family:Akrobat;"><a href="<?=site_url('account/shell')?>" target="_blank" onclick="window.open(this.href, 'mywin',
'width=930,height=450,resizable=0'); return false;">Shell Card Transaction</a></li>
                            <li style="font-family:Akrobat;"><a href="<?=site_url('account/dividend')?>">Dividend Information</a></li>
                            <li style="font-family:Akrobat;"><a href="<?=site_url('account/savings')?>">My Telescoop Savings</a></li>
														<?if($this->session->userdata('member_id') == '024023'):?>
														<li style="font-family:Akrobat;"><a href="<?=site_url('account/POL')?>" target="_blank" onclick="window.open(this.href, 'mywin',
'width=1400,height=750,resizable=0'); return false;">Online Loan Application</a></li>
														<?else:?>
														<li style="font-family:Akrobat;"><a href="<?=site_url('account/Maintenance')?>" target="_blank" onclick="window.open(this.href, 'mywin',
'width=1400,height=750,resizable=0'); return false;">Online Loan Application</a></li>
														<?endif;?>
                        </ul>


                 <?else:?>
                        <a href="<?=site_url('account/login')?>" onmouseover="this.style.backgroundColor='#b06328'"  onmouseout="this.style.backgroundColor='#c47946'"
                               style="background-color:#c47946; font-family: Akrobat;"> Login</a>
                 <?endif?>


                </li>


                <li style="font-family:Akrobat;"><a href="<?=site_url('home/contact_us')?>">Contact Us</a></li>


                <li style="font-family:Akrobat;"><a class="" href="<?=site_url('home/services')?>">Services</a>

                <li style="font-family:Akrobat;"><a href="<?=site_url('home/benefits')?>">Benefits</a></li>

                <li style="font-family:Akrobat;"><a href="<?=site_url('home/membership')?>">Membership</a></li>

                <!-- <li><a href="<?=site_url('home/events')?>">Events</a></li> -->

                <li style="font-family:Akrobat;"><a href="#">About Us</a>

                    <ul>
                        <li style="font-family:Akrobat;"><a href="<?=site_url('about_us/history')?>">History</a></li>
                        <li style="font-family:Akrobat;"><a href="<?=site_url('about_us/vm')?>">Mission & Vision</a></li>
                        <li style="font-family:Akrobat;"><a href="<?=site_url('about_us/board')?>">Board of Directors</a></li>
                        <li style="font-family:Akrobat;"><a href="<?=site_url('about_us/aic')?>">Committee</a></li>
                        <li style="font-family:Akrobat;"><a href="<?=site_url('about_us/staff')?>">Departments</a></li>
                    </ul>

                </li>

                <li style="font-family:Akrobat;"><a href="<?=site_url('home')?>">Home</a></li>

            </ul>
    </div>

    <div id="body">

        <center>

            <br><br><br><br><br><br>
            <?=$this->load->view($body);?>

            <?if(isset($has_side_menu) AND $has_side_menu == TRUE):?>
            <?=$this->load->view('side_menu');?>
            <?endif;?>

        </center>
        <div class="clear"></div>
    </div>

    <footer>
        <div id="FOOTER" style="font-family:Avenir-Next;"><strong>Copyright &copy; 2020 - www.TELESCOOP.com.ph - All rights reserved </strong> </div>
    </footer>

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
