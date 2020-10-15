<?
$member_id = $this->session->userdata('member_id');
#$home = file_get_contents('http://192.168.200.11/dl_form/');
#$home = "<script>window.location.replace('http://119.93.95.162/dl_form/index.php/PForms/home/$member_id')</script>";
#echo $home;
$home = "https://www.telescoop.com.ph/dl_form/index.php/PForms/home/$member_id"?>
<br>
<br>
<br>

<iframe width="100%" height="400" src="<?=$home?>"> </iframe>
