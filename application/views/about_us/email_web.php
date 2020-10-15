<?

if(isset($_POST['submit'])):

error_reporting(E_ALL ^ E_NOTICE);
ini_set("memory_limit","1500M");
ini_set('max_execution_time', 300); 


$config['protocol'] = 'smtp';
$config['smtp_host'] = '192.168.200.254';
$config['smtp_port'] = 25;
$config['smtp_user'] = 'sysadmin@telescoop.com.ph';
$config['smtp_pass'] = '1234';
$config['mailtype'] = 'html';
$config['charset']  = 'utf-8';
		
$this->load->library('email', $config);	
		
#$emailx = 'tototintikya@yahoo.com';
#$email = 'fmbautista@pldt.com.ph';
		
#for($x = 1; $x <= 3; $x++)
#{
	#sleep(10);	
	$sql = <<<SQL
    		
	    	#SELECT *
	    	#FROM teles_bin.email_src
    		#WHERE #status IS NULL# OR 
    		#WHERE
    		#email_ads IN ('eealemany@pldt.com.ph','gbgarcia@pldt.com.ph')
			#LIMIT 30#,'gie.armada@telescoop.com.ph')
			
			SELECT *
			FROM teles_bin2.tester
			WHERE status = 0
			#email_ads IN ('jethro.malate@telescoop.com.ph')
			LIMIT 30
			#WHERE email_ads IN ('jethro.malate@telescoop.com.ph','gie.armada@telescoop.com.ph')
		
			
			# email_ads IN ('fmbautista@pldt.com.ph','anthony.manzano@telescoop.com.ph')
			# email_ads IN ('jethro.malate@telescoop.com.ph','gie.armada@telescoop.com.ph')
SQL;
	$query = $this->db->query($sql);
	$ctr = 1;	 	
	foreach($query->result() as $row)
	{
		sleep(3);
		$this->email->clear(TRUE);
		$this->email->from('sysadmin@telescoop.com.ph', 'TELESCOOP');
			
		$this->email->to($row->email_ads);
			
		$path=$_SERVER["DOCUMENT_ROOT"];	
		#$data["body"] = '<b><img src="cid:3G_sale.jpg" />';
		#$this->email->attach($path.'/assets/files/3G_sale.jpg');
		#$this->email->attach($path.'/assets/files/3g_pricelist_sale.xls');
		
		$img_web = '<img src="cid:web.JPG" />';
		
		$data["body"] = <<<STR
		<html>

<head>
<meta http-equiv=Content-Type content="text/html; charset=windows-1252">
<meta name=Generator content="Microsoft Word 11 (filtered)">
<title>To Our Valued TELESCOOP Members:</title>
<style>
<!--
 /* Font Definitions */
 @font-face
	{font-family:Wingdings;
	panose-1:5 0 0 0 0 0 0 0 0 0;}
@font-face
	{font-family:Tahoma;
	panose-1:2 11 6 4 3 5 4 4 2 4;}
 /* Style Definitions */
 p.MsoNormal, li.MsoNormal, div.MsoNormal
	{margin:0in;
	margin-bottom:.0001pt;
	font-size:12.0pt;
	font-family:"Times New Roman";}
a:link, span.MsoHyperlink
	{color:blue;
	text-decoration:underline;}
a:visited, span.MsoHyperlinkFollowed
	{color:purple;
	text-decoration:underline;}
@page Section1
	{size:8.5in 11.0in;
	margin:9.35pt .7in 1.0in .7in;}
div.Section1
	{page:Section1;}
 /* List Definitions */
 ol
	{margin-bottom:0in;}
ul
	{margin-bottom:0in;}
-->
</style>

</head>

<body lang=EN-US link=blue vlink=purple>

<div class=Section1>
<p class=MsoNormal><span style='font-size:9.0pt;font-family:Tahoma'>To Our
Valued TELESCOOP Members:</span></p>

<p class=MsoNormal><span style='font-size:9.0pt;font-family:Tahoma'>&nbsp;</span></p>

<p class=MsoNormal><span style='font-size:9.0pt;font-family:Tahoma'>We wish to
invite you to visit our website to know more about the products and  services
that the cooperative is offering</span></p>

<p class=MsoNormal style='text-align:justify'><span style='font-size:9.0pt;
font-family:Tahoma'>&nbsp;</span></p>

<p class=MsoNormal style='text-align:justify'><span style='font-size:9.0pt;
font-family:Tahoma'>Members can  view his/her Telescoop Accounts (Subsidiary
Ledger), and  can check the balances of outstanding loans, share <br> capital , and status
of applied loan from time to time. </span></p>

<p class=MsoNormal style='margin-left:.25in;text-align:justify'><span
style='font-size:9.0pt;font-family:Tahoma'>&nbsp;</span></p>

<p class=MsoNormal><span style='font-size:9.0pt;font-family:Tahoma'>Members can
also   monitor their savings account. Member’s profile is also viewable in the
website, so that any changes in <br> status, beneficiaries , etc can be relayed to  Telescoop
office for  proper updating.</span></p>

<p class=MsoNormal style='margin-left:.25in;text-align:justify'><span
style='font-size:9.0pt;font-family:Tahoma'>&nbsp;</span></p>

<p class=MsoNormal style='margin-left:.25in;text-align:justify'><span
style='font-size:9.0pt;font-family:Tahoma'>Should you still have no access to
our website, please consider the  following steps:</span></p>

<p class=MsoNormal style='margin-left:.25in;text-align:justify'><span
style='font-size:9.0pt;font-family:Tahoma'>&nbsp;</span></p>

<p class=MsoNormal style='margin-left:1.0in;text-align:justify;text-indent:
-.25in'><span style='font-size:9.0pt;font-family:Symbol'>·<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span><span style='font-size:9.0pt;font-family:Tahoma'>Call up
Telescoop Customer Service hotline at 8900409 and know your “TELESCOOP
MEMBER_ID” (six <br>digit number)</span></p>

<p class=MsoNormal style='margin-left:1.0in;text-align:justify;text-indent:
-.25in'><span style='font-size:9.0pt;font-family:Symbol'>·<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span><span style='font-size:9.0pt;font-family:Tahoma'>Go to <a
href="http://www.telescoop.com.ph/">www.telescoop.com.ph</a></span></p>

<p class=MsoNormal style='margin-left:1.0in;text-align:justify;text-indent:
-.25in'><span style='font-size:9.0pt;font-family:Symbol'>·<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span><span style='font-size:9.0pt;font-family:Tahoma'>On the right
side of the page is the member’s Log in, click “create new account”</span></p>

<p class=MsoNormal style='margin-left:1.0in;text-align:justify;text-indent:
-.25in'><span style='font-size:9.0pt;font-family:Symbol'>·<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span><span style='font-size:9.0pt;font-family:Tahoma'>Fill out the
Register User Account Box</span></p>

<p class=MsoNormal style='margin-left:.75in;text-align:justify'><span
style='font-size:9.0pt;font-family:Tahoma'>  
        
$img_web

</span></p>

<p class=MsoNormal style='margin-left:.75in;text-align:justify'><span
style='font-size:9.0pt;font-family:Tahoma'>                                   And
will send advice thru email , once approved</span></p>

<p class=MsoNormal style='margin-left:.75in;text-align:justify'><span
style='font-size:9.0pt;font-family:Tahoma'>                                    
</span></p>

<p class=MsoNormal><span style='font-size:9.0pt;font-family:Tahoma'>                              
Other Important Reminders:</span></p>

<p class=MsoNormal style='margin-left:147.0pt;text-indent:-.25in'><span
style='font-size:9.0pt;font-family:Symbol'>·<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span><span style='font-size:9.0pt;font-family:Tahoma'>Telescoop member
Id  -   6 digit number</span></p>

<p class=MsoNormal style='margin-left:147.0pt;text-indent:-.25in'><span
style='font-size:9.0pt;font-family:Symbol'>·<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span><span style='font-size:9.0pt;font-family:Tahoma'>Employee
No.              -   either old idno or sap id</span></p>

<p class=MsoNormal style='margin-left:147.0pt;text-indent:-.25in'><span
style='font-size:9.0pt;font-family:Symbol'>·<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span><span style='font-size:9.0pt;font-family:Tahoma'>Birthdate                     
-   month, year, date</span></p>

<p class=MsoNormal style='margin-left:147.0pt;text-indent:-.25in'><span
style='font-size:9.0pt;font-family:Symbol'>·<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span><span style='font-size:9.0pt;font-family:Tahoma'>Mobile
#                       -   LAST 9 digits or if cp# is not available</span></p>

<p class=MsoNormal style='margin-left:129.0pt'><span style='font-size:9.0pt;
font-family:Tahoma'>                                                 Key in 9
zeros</span></p>

<p class=MsoNormal><span style='font-size:9.0pt;font-family:Tahoma'>&nbsp;</span></p>

<p class=MsoNormal><span style='font-size:9.0pt;font-family:Tahoma'>           
</span></p>

<p class=MsoNormal style='margin-left:.5in'><span style='font-size:9.0pt;
font-family:Tahoma'>Suggestions/ Comments  are highly appreciated for the
improvement and success of our cooperative and TELESCOOP <br>website</span></p>

<p class=MsoNormal><span style='font-size:11.0pt'>&nbsp;</span></p>

</div>

</body>

</html>
	
STR;
		$this->email->attach($path.'/assets/files/web.JPG');
		$emailbody = $this->load->view('mail_view.php',$data,true);
		$this->email->subject('Web Advisory');
		$this->email->message($emailbody);    
			
		if ( ! $this->email->send())
		{
			$this->db->where('id',$row->id);
			$this->db->update('teles_bin.email_3g_web',array('status'=> 2));
			
		    echo $ctr++.'. The email error '.$row->email_ads .' - '.date('h:i:s').'<br>';
		}else{
			
			$this->db->where('id',$row->id);
			$this->db->update('teles_bin.email_3g_web',array('status'=> 1));
			
			echo $ctr++.'. The email was sent to '.$row->email_ads.' - '.date('h:i:s').'<br>';
		}
			
		#echo $ctr++.'. The email was sent to '.$row->email .' - '.date('h:i:s').'<br>';
	}

#}	
	
endif;


/*
$this->email->from('sysadmin@telescoop.com.ph', 'TELESCOOP');

$this->email->to($email);
$path=$_SERVER["DOCUMENT_ROOT"];	
$data["body"] = '<b><img src="cid:gadgets_sale.jpg" />';
$this->email->attach($path.'/assets/files/gadgets_sale.jpg');
$this->email->attach($path.'/assets/files/DIRECT SELLING PRICELIST.xls');
$emailbody = $this->load->view('mail_view.php',$data,true);
$this->email->subject('Gadgets Sale / See attached pricelist');
$this->email->message($emailbody);    

	if ( ! $this->email->send())
	{
	    echo $ctr++.'. The email error '.$this->email->print_debugger().'<br>';
	}else{
		echo $ctr++.'. The email was sent to '.$email .'<br>';
	}

*/
/*
	$sql = <<<SQL
    		
	    	SELECT *
	    	FROM teles_bin.for_email_member4
	    	WHERE id BETWEEN 5301 AND 5350
	    	OR
	    	email_send IN ('jethro.malate@telescoop.com.ph')
	    	 
		#WHERE email_send IN ('jethromalate@gmail.com', 'gie.armada@telescoop.com.ph')
SQL;
	$query = $this->db->query($sql);
	$ctr = 1;	
	foreach($query->result() as $row)
	{
		$this->email->clear(TRUE);
		$path=$_SERVER["DOCUMENT_ROOT"];	
		$msg = '
		Please see attach';	
		$this->db->where('id',$row->id);
		$this->db->update('teles_bin.for_email_member4',array('status'=> 1));
			
		$this->email->to($row->email_send);
    				 
	    $this->email->from('sysadmin@telescoop.com.ph', 'TELESCOOP');
	    $this->email->subject("TELESCOOP");	
	    
	    
	    $emailbody = $this->load->view('mail_view.php',$data,true);
	    
	    $this->email->message($msg);
	    	
	    
		    	
	    $this->email->attach($path.'/assets/files/DIRECT SELLING PRICELIST.xls');
    	 $this->email->attach($path.'/assets/files/gadgets_sale.jpg', "inline");  
    	if ( ! $this->email->send())
		{
		    echo $ctr++.'. The email error '.$this->email->print_debugger().'<br>';
		}else{
			echo $ctr++.'. The email was sent to '.$row->email_send .'<br>';
		}
	    	
	}
*/		

if(!isset($_POST['from'])){
	$_POST['from'] = '';
}
if(!isset($_POST['to'])){
	$_POST['to'] = '';
}
?>

<div id="body-left">
	<div id="left-content">
		<?=form_open('about_us/email')?>

			<table border=0>
				<tr>
					<td align="right">from: <input type="text" name="from" value="<?=$_POST['from']?>"></td>
				</tr>
				<tr>	
					<td align="right">to: <input type="text" name="to" value="<?=$_POST['to']?>"></td>
				</tr>
				<tr>	
					<td align="right"><input type="submit" name="submit" value="submit"/></td>
				</tr>
			</table>
			<?=form_close()?>
	</div>	
</div>





