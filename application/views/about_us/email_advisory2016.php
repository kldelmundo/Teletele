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
	#$table = 'email_masterlist';	
	#$table = 'email_staff';
	$filename = 'Important Reminder.jpg';
	#$att_file = 'Advisory.jpg';
	#$filename = 'TEN Loan.jpg';
	#$filename = 'TEN2.jpg';
	#$filename2 = 'ECML3.jpg';
	#$att_file = 'Membership Updating Letter.jpg';
	#$att_file1 = 'Membership Updating Letter.doc';
	#$att_file = 'ECML2.jpg';
		
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
		#$this->email->to('gie.armada@telescoop.com.ph');
		#$this->email->cc('gbliamzon@telescoop.com.ph');
		
        	
		$path=$_SERVER["DOCUMENT_ROOT"];	
        	$data["body"] = '<center><img src="cid:"'.$filename.' /></center>';
		/*$data["body"] = 'Dear Members,<br><br>
		
					In our desire to serve our membership
					better by giving faster and more updated information to our members related to launching
					of new Telescoop products and in disseminating  Cooperative advisories,<br>
					may we request you to provide us your contact numbers.
					In this way ,we could communicate these updates through SMS (text)/Call. <br><br> 
					
				Thanks you.
				<br>
				<br>
				';*/
		$this->email->attach($path.'/assets/files/'.$filename);
		#$this->email->attach($path.'/assets/files/'.$filename2);
		#$this->email->attach($path.'/assets/files/'.$att_file);
		#$this->email->attach($path.'/assets/files/'.$att_file);

			
		$emailbody = $this->load->view('mail_view.php',$data,true);
		$this->email->subject('TELESCOOP ADVISORY');
		#$this->email->subject('ADVISORY ON THE REDUCTION OF INTEREST ON FSDL SR AND REDUCTION OF SERVICE CHARGE ON ALL LOANS EXCEPT MPL');
		 
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





