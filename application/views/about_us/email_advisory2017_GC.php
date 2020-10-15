<?
#echo 1;

if(isset($_POST['submit'])):
		
	#$table = 'email_staff';
	#$table = 'active_20171103';
	#$table = 'RRG_zamboanga';
	#$table = 'email_web1';
	#$table = 'email_off';
	$table = 'tester';
	#$table = 'email_scc';

	$filename = 'survey.JPG';


		
	$sql = "SELECT *
			FROM teles_bin2.$table
			WHERE status IN (0)
			#AND member_id IN (23299,9)
			LIMIT 500";
			
	$query = $this->db->query($sql);
	$ctr = 1;
	
	foreach($query->result() as $row)
	{
	
		$path=$_SERVER["DOCUMENT_ROOT"];	
    	$data["body"] = 'PLEASE SEE ATTACHED.<br><br>';
	
		$emailbody = $this->load->view('mail_view.php',$data,true);
		#$this->email->subject('NEW TELESCOOP TIE UP');
		$this->email->subject('HOLIDAY PROMO');
		#$this->email->subject('ADVISORY ON THE REDUCTION OF INTEREST ON FSDL SR AND REDUCTION OF SERVICE CHARGE ON ALL LOANS EXCEPT MPL');
		 
		$this->email->message($emailbody);
		
		
		$config = array(
                        'from'=>'TELESCOOP <sysadmin@telescoop.com.ph>',
                        'to'=> trim($row->email_ads),
                        'subject' => 'TELESCOOP SURVEY',
                        'html'    => '<html>

											<img src="cid:'.$filename.'">
											<br><br>
											<strong>
												GREAT NEWS FOR ALL TELESCOOP MEMBERS!!
											</strong>
												<br>
												<br>
												We want to know you more so we can serve you better!
												<br>
												<br>
												Join our survey to update your profile and win exciting prizes!
												<br>
												<br>
												Survey period is from <strong>January 12, 2018 to March 8, 2018</strong>. All who participate will get a chance <br>to win any of these prizes via electronic raffle:
												<br>
												<br>
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1st Prize : High Grade Motorized Home Treadmill
												<br>
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2nd Prize : Practical, Easy Carry Folding Bike
												<br>
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3rd Prize : Weight Buster Shake and Fit Board
												<br>
												<br>
												<strong>BUT WAIT, THERES MORE! </strong>Submit your updated profile on or before <strong>Feb.4, 2018</strong> and get<br> a chance to win a Professional Spinning Bike!!!
												<br>
												<br>
												There are 3 ways to answer the survey:
												<br>
												<br>
												&nbsp;&nbsp;&nbsp;&nbsp;1.	Through online (if you have internet browsing privilege ), <a href="https://docs.google.com/forms/d/e/1FAIpQLSdLZ5yksTRwAz2AOPwpF1yDtxn21J_NMmuXVqIlIHSUmD-awQ/viewform" target="_blank">click here to access Online Survey </a>
												<br>
												&nbsp;&nbsp;&nbsp;&nbsp;2.  Download the attached Service Profiling survey form, answer the survey and send back to <br>sysadmin@telescoop.com.ph
												<br>
												&nbsp;&nbsp;&nbsp;&nbsp;3.	Secure  and fill out a copy of the Service Profiling survey form from our Telescoop booth at the<br> canteen<br>
											

				     				  </html>'

                    );
						
		$inline = array( 
				'inline' => array($path.'/assets/files/'.$filename), 
				#'attachment' => array($path.'/assets/files/2017_PMS_Menu-Fully_Synthetic_Oil.pdf', $path.'/assets/files/2017_PMS_Menu-Semi_Synthetic_Oil.pdf', $path.'/assets/files/2017_PMS_Menu-Regular_Oil.pdf')
				#'attachment' => array($path.'/assets/IMAGES/'.$attachment)
				'attachment' => array($path.'/assets/files/TELESCOOP_Service_Profiling_Survey.xls'),
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





