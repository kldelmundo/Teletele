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
		
	#$table = 'deferred_wo_ecml';
	$table = 'shellcard_batch2part_C';
	#$table = 'tester';
	#$filename = 'FAQs.pdf';
	#$att_file = 'ECML3.jpg';
	#$filename = 'Circular.jpg';
	$att_file = 'FAQs.pdf';
	#$att_file1 = 'Membership Updating Letter.doc';
	#$att_file = 'Loan Form.doc';
		
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
		#$this->email->cc('gbliamzon@telescoop.com.ph');
		
        	
		$path=$_SERVER["DOCUMENT_ROOT"];	
        	
		$data["body"] = "Good day!<br><br>
						Telescoop is offering you our new product, the Shell Gas Card.<br>
						This is non-interest bearing and discounted at 1 peso per liter for gasoline and P 0.50 for diesel. <br>
						For your application, please provide us with the following information:<br><br>
						<strong><font color='blue'>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NAME:<br>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ID #:<br>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;COMPANY:<br>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CONTACT #:<br>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Name of Driver to appear in the Shell Gas Card:<br>
						<br>
						</font></strong>

						For more details, Please see attached FAQs.<br><br><br>

						Cooperatively yours,<br>
						<strong>TELESCOOP</strong>
						";
		#<img src="cid:"'.$filename.' />
		#$this->email->attach($path.'/assets/files/'.$filename);
		$this->email->attach($path.'/assets/files/'.$att_file);
		#$this->email->attach($path.'/assets/files/'.$att_file);

			
		$emailbody = $this->load->view('mail_view.php',$data,true);
		$this->email->subject('Shell Gas Card');
		 
		$this->email->message("$emailbody");    
		 
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





