<?
#echo 1;

if(isset($_POST['submit'])):
		
		
	$table = 'email_TCL102517';
	#$table = 'tester';

	$filename = 'CIRCULAR_TCL.JPG';
	$attachment = 'CIRCULAR_TCL.pdf';

		
	$sql = "SELECT *
			FROM teles_bin2.$table
			WHERE status IN (0)
			LIMIT 500";
			
	$query = $this->db->query($sql);
	$ctr = 1;
	
	foreach($query->result() as $row)
	{
	
		$path=$_SERVER["DOCUMENT_ROOT"];	
    	$data["body"] = 'PLEASE SEE ATTACHED.<br><br>';
	
		$emailbody = $this->load->view('mail_view.php',$data,true);
		$this->email->subject('CAR MO CARE KO');
		#$this->email->subject('ADVISORY ON THE REDUCTION OF INTEREST ON FSDL SR AND REDUCTION OF SERVICE CHARGE ON ALL LOANS EXCEPT MPL');
		 
		$this->email->message($emailbody);
		
		
		$config = array(
                        'from'=>'TELESCOOP <sysadmin@telescoop.com.ph>',
                        'to'=> trim($row->email_ads),
                        'subject' => 'TELESCOOP CALAMITY LOAN',
                        'html'    => '<html><center>

											<img src="cid:'.$filename.'">
					
				     				  </center></html>'
                    );
						
		$inline = array( 
				'inline' => array($path.'/assets/files/'.$filename), 
				#'attachment' => array($path.'/assets/files/2017_PMS_Menu-Fully_Synthetic_Oil.pdf', $path.'/assets/files/2017_PMS_Menu-Semi_Synthetic_Oil.pdf', $path.'/assets/files/2017_PMS_Menu-Regular_Oil.pdf')
				'attachment' => array($path.'/assets/files/'.$attachment)
				#'attachment' => array($path.'/assets/files/2017_PMS_Menu-Regular_Oil.pdf'),
			);

		#$inline = array( 
				#'inline' => array($path.'/assets/files/'.$filename));
		
		$send_na = $this->mailguinmar->send($config, $inline);
		
		$this->db->where('id',$row->id);
		$this->db->update('teles_bin2.'.$table,array('status'=> 1));    
		echo $ctr++.'. The email '.$row->email_ads.' was already queued to mailgun  - '.date('h:i:s').'<br>';
	
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





