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
		
	#$table = 'tester';	
	$table = 'headswithnoreply2015';
	#$filename = 'Advisory.jpg';
	#$att_file = 'Advisory.jpg';
	#$filename = 'Advisory2015.jpg';
	#$att_file = 'Membership Updating Letter.jpg';
	#$att_file1 = 'Membership Updating Letter.doc';
	#$att_file = 'ECML2.jpg';
		
	$sql = "SELECT *
			FROM teles_bin2.$table
			WHERE status IN (0)
			LIMIT 1000";
			
	$query = $this->db->query($sql);
	$ctr = 1;	 	
	foreach($query->result() as $row)
	{
		$this->email->clear(TRUE);
		$this->email->set_newline("\r\n");	
		$today = date("F j, Y");		 
		$this->email->from('ELECOM2015@telescoop.com.ph', 'TELESCOOP Election Committee');
		$this->email->to(trim($row->email_ads));
		$this->email->cc('rmdino@pldt.com.ph');
		#$this->email->cc('gie.armada@telescoop.com.ph');
		
        	
		$path=$_SERVER["DOCUMENT_ROOT"];	
        	
		$data["body"] = "March 7, 2015
						<br>
						<br>
						<br>
						Dear <u>Sir/Mam</u>
						<br>
						<br>
						&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
						As of today, we have not yet received your Nomination Form for your Office/Division's<br>
						Elected Representative to the TELESCOOP Representative Assembly scheduled on Saturday, March 14, 2015.
						<br><br>
						&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
						In this connection, we wish to advise you that deadline for the submission of your
						<br>
						Accomplished Nomination Form shall be on Monday, March 9, 2015, at 5:00pm.
						<br><br><br>
						&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
						<strong>Thank you</strong>
						<br>
						<br>
						<br>
						<br>
						<strong>ELECOM</strong>";#<img src="cid:"'.$filename.' />
		#$this->email->attach($path.'/assets/files/'.$filename);
		#$this->email->attach($path.'/assets/files/'.$att_file);
		#$this->email->attach($path.'/assets/files/'.$att_file);

			
		$emailbody = $this->load->view('mail_view.php',$data,true);
		$this->email->subject('Reminder - TELESCOOP 2015 Representative Assembly');
		 
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





