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
		#officer and selected email
		#	SELECT * FROM teles_bin.for_email_member_off WHERE type IN (1,3)
    		
	    	#SELECT *
	    	#FROM teles_bin.email_src
    		#WHERE #status IS NULL# OR 
    		#WHERE
    		#email_ads IN ('eealemany@pldt.com.ph','gbgarcia@pldt.com.ph')
			#LIMIT 30#,'gie.armada@telescoop.com.ph')
			
		#jethro	
			SELECT *
			FROM teles_bin.email_cyberya
			WHERE status = 0
			LIMIT 30
			
			#WHERE email_ads IN ('anthony.manzano@telescoop.com.ph')#,'gie.armada@telescoop.com.ph','anthony.manzano@telescoop.com.ph')
			#WHERE email_ads IN ('jethro.malate@telescoop.com.ph','gie.armada@telescoop.com.ph','anthony.manzano@telescoop.com.ph')
			
			#LIMIT 30
			#OR 
			
		#email_ads IN ('jethro.malate@telescoop.com.ph','rupontigon@pldt.com.ph')
			
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
		$data["body"] = '<img src="cid:Telescoop_Advisory.jpg" /> <br /> <br /><strong>For more information, you may also call TELESCOOP Office at 8462807 or 8997911.</strong>';
		$this->email->attach($path.'/assets/files/Telescoop_Advisory.jpg');
		#$this->email->attach($path.'/assets/files/TFL_computation.xls');
		$emailbody = $this->load->view('mail_view.php',$data,true);
		$this->email->subject('NEGOSYO para sa MIYEMBRO');
			
			
		$this->email->message($emailbody);    
			
		if ( ! $this->email->send())
		{
			$this->db->where('id',$row->id);
			$this->db->update('teles_bin.email_cyberya',array('status'=> 2));
			
		    echo $ctr++.'. The email error '.$row->email_ads .' - '.date('h:i:s').'<br>';
		}else{
			
			$this->db->where('id',$row->id);
			$this->db->update('teles_bin.email_cyberya',array('status'=> 1));
			
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





