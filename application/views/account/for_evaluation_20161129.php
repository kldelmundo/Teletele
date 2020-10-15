		<link rel='stylesheet' href='<?=CSS_PATH?>ledger.css' type='text/css' charset='utf-8' />
			
		<div>
			
			<? 
			$members = $this->input->post('member');
			$search = $this->input->post('search');
			
			if(!empty($members)):
				
				
				foreach($members  as  $k => $member_id):
			
				#UPDATE ACCESS_STATUS TO 1;
				$approved_by = $this->session->userdata('member_id');
				$att_file = 'Telescoop_Price_List.xls';
				$path=$_SERVER["DOCUMENT_ROOT"];
				
				$sql = "UPDATE telescoop_web.member_sys_access 
						SET access_status = 1,
							date_approved = NOW(),
							approved_by = '$approved_by' 
						WHERE member_id = $member_id";
						
				$this->db->query($sql);
				$member_row = $this->m_account->get_member_info_by_member_id($member_id);
				
				if(IS_SMS)
				{
					$this->m_account->message_out($member_row->mobile_no);
				}
				
					
				$today = date("F j, Y");
			        
		        $this->email->set_newline("\r\n");	
				 
		        $this->email->from('sysadmin@telescoop.com.ph', 'TELESCOOP');
		        $this->email->to($member_row->email_add);
		        $this->email->subject('TELESCOOP WEB Online Access');	
			        
		        $msg = '
		            
			    <html>
				<head><title>Your title</title></head>
				<body>
			  	<center>
				  		
			  	<table style="width: 80% ;border: 1px solid #3399FF;">
			    <tr>
			    	<td style="text-align: center;font-family: Tahoma; font-size: small; color: black;">
			    		<br><strong>PLDT EMPLOYEES MULTI-PURPOSE COOPERATIVE (TELESCOOP) </strong>
			    	</td>
			    </tr>
			      
			    <tr>
			     	<td style="text-align: center;font-family: Tahoma;    font-size: small;    color: black;">
						<center> 5th Floor, PLDT Cooperatives Building 4718 Eduque St., Brgy. Poblacion, Makati City 1210
				 	</td> 
				</tr>
				
				<tr>
				  	<td style="text-align: center;font-family: Tahoma;    font-size: small;  color: black;">
						<center> Tel.Nos. 890-0409 / 846-2307 / 8462308 Fax No. 890-0365 / 890-0917
					</td>
			    </tr>
				  
				  
				<tr>
					<td style="text-align: left;font-family: Tahoma; font-size: small;">
						<br><br><br>
						&nbsp;&nbsp;&nbsp;&nbsp; '.$today.'
						<br><br>
						&nbsp;&nbsp; &nbsp;  Good Day!
						<br><br>
					</td>	
				</tr>
						
				<tr>
			         		 
					<td style="text-align: left;font-family: Tahoma; font-size: small;">
	        		&nbsp;&nbsp;&nbsp; &nbsp; <strong>Account name: '.$member_row->name.'</strong>
	        		
	        		<br>&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;You can now access your account <a href="'.site_url('account/login').'">here</a>.
	        		
	        		<br><br>
	        		&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;<strong>Username</strong>: '.$member_row->username.'
	        		<br>
	        		&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;<strong>Password</strong>: '.$member_row->password.'
	        		<br><br><br>
					</td>
				</tr>
			  	</table>
				</center>
				</body>
				</html>';
		        	
		        $this->email->message($msg);
				 
		        if($this->email->send())
		        {
		            #echo 'Email was sent successfully.';
			            
		            $this->email->clear(TRUE);
				    $this->email->to('guinmar.liamzon@telescoop.com.ph');
				    $this->email->cc('jethro.malate@telescoop.com.ph');
				    $this->email->from('sysadmin@telescoop.com.ph', 'TELESCOOP');
				    //$this->email->attach($path.'/assets/files/'.$att_file);
				    $this->email->subject('TELESCOOP WEB Online Access');	
				    $this->email->message($msg);
				    $this->email->send();
		        }
		        else
		        {
		            show_error($this->email->print_debugger());
		        }
					
				endforeach;
					
			endif;	
			
			$res_val = $this->m_account->get_for_evaluation($search);
			?>
			
			<form action="<?=site_url($this->uri->uri_string())?>" method="POST">
			
			<table>
					
				<tr>
					<td width="60%" class="Thead" colspan="3" align="center">LIST OF ACCOUNTS FOR EVALUATION</td>
						
					<td width="20%" colspan=4 class="Thead" style="cursor:pointer" align="right">SEARCH:&nbsp; <input type="text" name="search"></td>
						
					<td width="30%" class="Thead" style="cursor:pointer" align="center"><button>Approve</button></td>
				</tr>
				<tr align="center" style="height:10px">
						
					<td class="Thead" width="5%"><input type="checkbox"/></td>
					<td class="Thead" width="20%">MEMBER ID</td>
					<td class="Thead" width="50%">NAME</td>
					<td  class="Thead" width="20%">COMPANY</td>
					<td colspan="2" class="Thead" width="60%">EMAIL</td>
					<td  class="Thead" width="40%">MIS REMARKS</td>
					<td class="Thead" width="20%">DATE REGISTER</td>
						
				</tr>
					
				<?foreach( $res_val as $row):?>
					
				<?$name2 = strtoupper($row->mem_lname.', '.$row->mem_fname);?>
					
				<tr>
					<td width="5%" align="center"><input id="chkbox" name="member[]" type="checkbox" value="<?=$row->member_id?>"/></td>
					<td align="center"><?=setLength($row->member_id);?></td>
					<td ><?=$name2?></td>
					<td ><?=$row->company_name?></td>
					<td ><?=$row->email_add?></td>
					<td ><strong><?=$row->acct_remarks?></strong></td>
					<td align="center" colspan=2><?=$row->date_register?></td>
					
				</tr>
					
				<?endforeach;?>
				
				<?if(count($res_val) == 0):?>
				<tr>
					<td align="center" colspan=8>NO RESULT FOUND</td>
					
				</tr>
				<?endif?>
				
			</table>
			
			</form>
			
		</div>