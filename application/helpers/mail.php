<?

error_reporting(E_ALL ^ E_NOTICE);
ini_set("memory_limit","1500M");
ini_set('max_execution_time', 300); 

$CI =& get_instance();
$CI->session->sess_write( TRUE );

$config['protocol'] = 'smtp';
$config['smtp_host'] = '192.168.200.254';
$config['smtp_port'] = 25;
$config['smtp_user'] = 'sysadmin@telescoop.com.ph';
$config['smtp_pass'] = '1234';
$config['mailtype'] = 'html';
$config['charset']  = 'utf-8';

$CI->load->library('email', $config);	

#$emailx = 'tototintikya@yahoo.com';
#$email = 'fmbautista@pldt.com.ph';
	$sql = <<<SQL
    		
	    	SELECT *
	    	FROM teles_bin.general_email
	    	#WHERE id BETWEEN 2174 AND 2250
	    	#OR
	    	WHERE email IN ('jethro.malate@telescoop.com.ph')
SQL;
	$query = $CI->db->query($sql);
	$ctr = 1;	
	foreach($query->result() as $row)
	{
		sleep(3);
		$CI->email->clear(TRUE);
		$CI->email->from('sysadmin@telescoop.com.ph', 'TELESCOOP');
		
		$CI->email->to($row->email);
		
		$path=$_SERVER["DOCUMENT_ROOT"];	
		$data["body"] = '<b><img src="cid:gadgets_sale.jpg" />';
	   $CI->email->attach($path.'/assets/files/gadgets_sale.jpg');
		$CI->email->attach($path.'/assets/files/DIRECT SELLING PRICELIST.xls');
		$emailbody = $this->load->view('mail_view.php',$data,true);
		$CI->email->subject('Gadgets Sale / See attached pricelist');
		$CI->email->message($emailbody);    
			
		if ( ! $this->email->send())
		{
			$CI->db->where('id',$row->id);
			$CI->db->update('teles_bin.general_email',array('status'=> 2));
			
		    echo $ctr++.'. The email error '.$row->email .' - '.date('h:i:s').'<br>';
		}else{
			
			$CI->db->where('id',$row->id);
			$CI->db->update('teles_bin.general_email',array('status'=> 1));
			
			echo $ctr++.'. The email was sent to '.$row->email.' - '.date('h:i:s').'<br>';
		}
			
		#echo $ctr++.'. The email was sent to '.$row->email .' - '.date('h:i:s').'<br>';
	}	