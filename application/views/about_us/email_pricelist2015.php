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
		
	//--$table = ('email_gadget2013')->database;--//
	
	$table = 'email_goodacctFMB060415';
	#$filename = 'Gadget_Sale2013.jpg';
	#$filename = 'Gadget_Sale2013.jpg'; --> Distanation of the jpg that will shown in the email.
	//---(Telescoop_Price_List.xls)->files attach in email--//
	$att_file = 'Telescoop_Price_List.xls';	
		
	$sql = "SELECT *
			FROM teles_bin2.$table
			WHERE status IN (0)
			
			LIMIT 1000";
			
			#AND email_ads = 'jethro.malate@telescoop.com.ph'
			
	$query = $this->db->query($sql);
	$ctr = 1;	 	
	foreach($query->result() as $row)
	{
		$this->email->clear(TRUE);
		$this->email->set_newline("\r\n");	
		
        $this->email->from('sysadmin@telescoop.com.ph', 'TELESCOOP');
    	$this->email->to(trim($row->email_ads));
        	
        $path=$_SERVER["DOCUMENT_ROOT"];
	
/*<img src="cid:'.$filename.'" />  --> must be inside the body and most attach it to the mail to show up the pic and must have the attachment distatnation*/
        	
		$data["body"] = '<br><br><br>Good Day.......TELESCOOP MEMBERS 
<br>
<br>
Attached is our updated price list, for you to choose from. Have a nice day....... 
';
		#$this->email->attach($path.'/assets/files/'.$filename);
		$this->email->attach($path.'/assets/files/'.$att_file);
		
		$emailbody = $this->load->view('mail_view.php',$data,true);
		$this->email->subject('Updated Pricelist');
		 
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





