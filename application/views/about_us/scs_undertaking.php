<?
#echo 1;

if(isset($_POST['submit'])):
		
	error_reporting(E_ALL ^ E_NOTICE);
		
	$config['protocol']  = 'smtp';
	$config['smtp_host'] = '192.168.200.5';
	$config['smtp_port'] = 25;
	$config['smtp_user'] = 'sysadmin@telescoop.com.ph';
	$config['smtp_pass'] = '1234';
	$config['mailtype']  = 'html';
	$config['charset']   = 'utf-8';
			
	$this->load->library('email', $config);	
		
	$table = 'tester';
	#$filename = 'Share Capital Subscription Undertaking.jpg';
	$att_file = 'Share Capital Subscription Undertaking.doc';	
		
	$sql = "SELECT *
			FROM teles_bin2.$table
			WHERE status IN (0)
			LIMIT 500";
			
	$query = $this->db->query($sql);
	$ctr = 1;	 	
	foreach($query->result() as $row)
	{
		$this->email->clear(TRUE);
		$this->email->set_newline("\r\n");	
		$today = date("F j, Y");		 
		$this->email->from('sysadmin@telescoop.com.ph', 'TELESCOOP');
		$this->email->to(trim($row->email_ads));
        	
		$path=$_SERVER["DOCUMENT_ROOT"];	
        	
		#$data["body"] = '<img src="cid:"'.$filename.' />';
		$data["body"] = '<font face="Calibri">In compliance to a Cooperative Development Authority requirement,kindly accomplish the<br>attached “SHARE CAPITAL SUBSCRIPTION UNDERTAKING AND AUTHORITY TO DEDUCT”<br>form and submit to the TELESCOOP Office your accomplished and signed copy.<br> 
		 This form serves as supporting document for the periodic deduction from your PLDT payroll salary for<br>your Share Capital contribution as Member / Co-Owner of TELESCOOP.<br><br>
		 
		 TELESCOOP shall issue to all its members a Share Capital Certificate for their respective<br>
		 accumulated Share Capital Contribution as of December 31, 2013. Succeeding Share Capital<br>
		 Certificate will be issued to each member for every fully-paid P 20,000.00 additional share<br> 
		 capital contribution.<br><br>


				You may scan and email it to Ms. Melissa Manalo at melissa.manalo@telescoop.com.ph or fax to 02-8900917.<br><br>
				
				Please disregard, if have already complied with.<br><br>
							
				Thank you<br><br><br>


				<strong>TELESCOOP MANAGEMENT</strong>
				</font>';
		#$this->email->attach($path.'/assets/files/'.$filename);
		$this->email->attach($path.'/assets/files/'.$att_file);
			
		$emailbody = $this->load->view('mail_view.php',$data,true);
		$this->email->subject('SCS Undertaking');
		 
		$this->email->message($emailbody);    
		 
			if($this->email->send())
			{
			    #echo 'Email was sent successfully.';
				$this->db->where('id',$row->id);
					$this->db->update('teles_bin2.'.$table,array('status'=> 1));    
					echo $ctr++.'. The email was sent to '.$row->email_ads.' - '.date('h:i:s').'<br>';
			}
			else
			{
			    show_error($this->email->print_debugger());
			    $this->db->where('id',$row->id);
					$this->db->update('teles_bin2.'.$table,array('status'=> 2));
			}
	}			
	
endif;



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





