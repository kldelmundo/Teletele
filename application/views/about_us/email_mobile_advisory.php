<?
#echo 1;

if(isset($_POST['submit'])):
		
		
	$table = 'email_secondaccount1';		

	$filename = 'app_raffle.jpg';
	#$filename1 = 'Valentines_Promo.pdf';

		
	$sql = "SELECT *
			FROM teles_bin2.$table
			WHERE status IN (0)
			LIMIT 300";
			
	$query = $this->db->query($sql);
	$ctr = 1;
	
	foreach($query->result() as $row)
	{
	
		$path=$_SERVER["DOCUMENT_ROOT"];	
    	$data["body"] = 'PLEASE SEE ATTACHED.<br><br>';
	
		$emailbody = $this->load->view('mail_view.php',$data,true);
		$this->email->subject('TELESCOOP MOBILE ADVISORY');
		#$this->email->subject('ADVISORY ON THE REDUCTION OF INTEREST ON FSDL SR AND REDUCTION OF SERVICE CHARGE ON ALL LOANS EXCEPT MPL');
		 
		$this->email->message($emailbody);
		
		
		$config = array(
                        'from'=>'TELESCOOP <sysadmin@telescoop.com.ph>',
                        'to'=> trim($row->email_ads),
                        'subject' => 'TELESCOOP MOBILE ADVISORY',
                        'html'    => '<html><img src="cid:'.$filename.'"></html>'
                    );
						
		$inline = array( 
				'inline' => array($path.'/assets/files/'.$filename)
				#'attachment' => array($path.'/assets/files/Valentines_Promo.pdf')
			);

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





