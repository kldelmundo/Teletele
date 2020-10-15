<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends CI_Controller {
	
	/*
		1=admin, 2=member	
		1=active; 2=pending; 3=restricted
	*/
	
	function __construct()
    {
        parent::__construct();
        
       
        
    }
    
    function notification()
    {
    	$email_add = $this->input->post('email_add');
    	$mobile_no = $this->input->post('mobile_no');
    	$is_notify_sms = $this->input->post('is_notify_sms');
    	$member_id = $this->session->userdata('member_id');
    	if(empty($is_notify_sms))
    	{
    		$is_notify_sms = 0;
    	}else{
    		$is_notify_sms = 1;
    	}
    	
    	#echo $member_id;
    	
    	if(!empty($member_id))
    	{
    		if(is_numeric($mobile_no))
    		{
	    		if(strlen($mobile_no) == 9)
	    		{
		    		$sql = "UPDATE telescoop_web.member_sys_access
					      	SET email_add = '$email_add',
						      	mobile_no = '+639{$mobile_no}',
						      	is_notify_sms = $is_notify_sms
							WHERE member_id = $member_id";
							
					#echo "$sql";		
					
					$this->db->query($sql);
					
					echo "
						
						<script>alert('Successfully updated!')
						
						window.location = '".site_url('account')."';
						
						</script>";
						
				}else{
					echo "
					
					<script>
					
					alert('ERROR INPUT: mobile # must be at least 9 characters in length.')
					window.location = '".site_url('account')."';
					
					</script>";
				}
					
			}else{
				echo "
					
					<script>
					
					alert('ERROR INPUT: mobile # should be in number format.')
					window.location = '".site_url('account')."';
					
					</script>";
			}
			
    	}
    	else
    	{
    		echo "<script>alert('ERROR: Please try again later!')</script>";
    	}
    	
    	
    	
    }
    
    function change_password()
    {
		
    	$username = $this->input->post('username');
    	$password = $this->input->post('old_pwd');
	    	
    	$new_pwd = $this->input->post('new_pwd');
    	$conf_new_pwd = $this->input->post('conf_new_pwd');
			
    	$member_id = $this->session->userdata('member_id');
    	
    	
		$query = $this->db->get_where('telescoop_web.member_sys_access',array('username'=>$username,'password'=>$password));
		
		if(empty($new_pwd)){
			
			echo "
				
				<script>alert('New password is required!')
				
				window.location = '".site_url('account')."';
				
				</script>";
		}
		else
		{
			if($query->num_rows() >= 1)
			{
				#CHECK IF NEW PASSWORD IS SAME TO CONFIRM PASSWORD	
				
				if($conf_new_pwd != $new_pwd) 
				{
					echo "
						
					<script>alert('Password confirmation does not match!')
					
					window.location = '".site_url('account')."';
					
					</script>";
				}
				else
				{
					$sql = "UPDATE telescoop_web.member_sys_access
							SET password = '$new_pwd'
							WHERE username = '$username'
							AND password  = '$password'";
					$query = mysql_query($sql) or die(mysql_error().$sql);
					
					echo "
					
					<script>alert('Password successfully changed!')
					
					window.location = '".site_url('account')."';
					
					</script>";
				}
				
			}
			else
			{
				echo "
				
				<script>alert('Invalid Old Password!')
				
				window.location = '".site_url('account')."';
				
				</script>";
					
			}
		}
    	/*
    	$data = array(
    				  'member_id'=>$member_id, 
    				  'title' => $title,
    				  'message' => $msg,
    				  'date_added' => date('c')
    				 );
    		
    	$this->db->insert('telescoop_web.member_sys_inquiry',$data);
    	*/
    	
    	#redirect('account');
    	
    	
    }
    
    function submit_inquiry()
    {
    	$msg = $this->input->post('msg');
    	$title = $this->input->post('title');
    			
    	$member_id = $this->session->userdata('member_id');
    	
    	
    	if(!isset($_POST['inq_send']))
    	{
    		echo "
				
			<script>
			
			window.location = '".site_url('account')."';
			
			</script>";
    	}
    	else
    	{
	    	if(empty($msg) OR empty($title))
	    	{
	    		echo "
					
				<script>alert('Invalid Input!')
				
				window.location = '".site_url('account')."';
				
				</script>";
	    	}
	    	else
	    	{
	    		/*
	    		$sql = "SELECT * 
						FROM members 
						LEFT JOIN telescoop_web.member_sys_access USING(member_id)
						LEFT JOIN positions USING(position_id)
						LEFT JOIN m_location ON members.mem_location = m_location.Loc_ID
						LEFT JOIN departments USING(department_id)
						WHERE member_id = $member_id";
						
				#echo $sql;
						
				$query = $this->db->query($sql);
				
				$mem_email = $query->row('email_add');
	    		
	    		$config['protocol'] = 'smtp';
		        $config['smtp_host'] = '192.168.200.254';
		        $config['smtp_port'] = 25;
			      		
		        $config['smtp_user'] = 'sysadmin@telescoop.com.ph';
		        $config['smtp_pass'] = '1234';
		        $config['mailtype'] = 'html';
		 		$config['charset']  = 'utf-8';
		 		$this->load->library('email', $config);
					
				$this->email->to($row->email_add);
				 
			    $this->email->from('sysadmin@telescoop.com.ph', 'TELESCOOP');
			    $this->email->subject("TELES WEB INQUIRY RE: $title");	
			    $this->email->message($msg."<br> From: $mem_email");
			    $this->email->send();
			
	    		*/
	    		
	    		$data = array(
	    				  'member_id'=>$member_id, 
	    				  'title' => $title,
	    				  'message' => $msg,
	    				  'date_added' => date('c')
	    				 );
	    		
				$this->db->insert('telescoop_web.member_sys_inquiry',$data);
		    		
		    	echo "
					
				<script>alert('Successfully Sent!')
				
				window.location = '".site_url('account')."';
				
				</script>";
	    	}
	    }	
    }
		
	public function index() //HOME PAGE
	{
		$member_id = $this->session->userdata('member_id');
		
		if(!$this->session->userdata('is_login'))
		{
			echo "
					
			<script>
				
				alert('Session expired. Please login to continue.')
				
				window.location = '".site_url('account/login')."';
				
			</script>";
		}
		
		if(isset($_POST['question2']))
		{
			if($_POST['question1'] == $_POST['question2'])
			{
				echo "
						
				<script>
					
					alert('Please choose a different challenge question.')
					
				</script>";
				
				$_POST['question2'] = 0;
			}
		}
			
		if(isset($_POST['submit_answers2']))
		{
			$question_idx = $_POST['question_idx'];
			$answerx = $_POST['answerx'];
			
			$qx = $this->db->query("SELECT * FROM telescoop_web.member_questions WHERE question_id = $question_idx AND member_id = $member_id");
			$answer_tama = $qx->row('answer');
			
			if(strtolower($answerx) == strtolower($answer_tama)){
				$this->db->query("UPDATE telescoop_web.member_sys_access SET is_validated = 1 WHERE member_id = $member_id");
				echo "<script>alert('Successfully Validated!')</script>";
			}else{
				echo "<script>alert('Your answer does not match to your record!')</script>";
			}
			
		}
		
		if(isset($_POST['submit_answers'])){
			
			if  (!empty($_POST['answer1']) AND !empty($_POST['answer2']) AND
				  $_POST['question1'] != 0 AND $_POST['question2'] != 0
				)
			{
				#CHECK QUESTION 1
				if($_POST['answer1'] == $_POST['conf_answer1']){
					$success1 = TRUE;
				}else{
					echo "<script>alert('Confirm Password for Question#1 does not match!')</script>";
					$success1 = FALSE;
				}
				
				#CHECK QUESTION 1
				if($_POST['answer2'] == $_POST['conf_answer2']){
					$success2 = TRUE;
				}else{
					echo "<script>alert('Confirm Password for Question#2 does not match!')</script>";
					$success2 = FALSE;
				}
				
				if($success1 AND $success2)
				{
					#1
					$q_id1 = $this->input->post('question1');
					$queryq1 = $this->db->query("SELECT * FROM telescoop_web.challenge_questions WHERE question_id = $q_id1")->row();
					$answer1 = $this->input->post('answer1');
					$q1 = $queryq1->question;
					
					$date1 = date('Y-m-d');
					$queryq1_num = $this->db->query("SELECT * FROM telescoop_web.member_questions WHERE question_id = $q_id1 AND member_id = $member_id")->num_rows();
					if($queryq1_num == 0):
						$value1 = array('member_id' => $member_id, 'question_id'=>$q_id1, 'question'=>$q1, 'answer'=>$answer1,'date_added'=> $date1);
						$this->db->insert("telescoop_web.member_questions",$value1);
					endif;	
					
					#2
					$q_id2 = $this->input->post('question2');
					$queryq2 = $this->db->query("SELECT * FROM telescoop_web.challenge_questions WHERE question_id = $q_id2")->row();
					$q2 = $queryq2->question;
					$answer2 = $this->input->post('answer2');
					$date2 = date('Y-m-d');
					
					$queryq2_num = $this->db->query("SELECT * FROM telescoop_web.member_questions WHERE question_id = $q_id2 AND member_id = $member_id")->num_rows();
					if($queryq2_num == 0):
						$value2 = array('member_id' => $member_id, 'question_id'=>$q_id2, 'question'=>$q2, 'answer'=>$answer2,'date_added'=> $date2);
						$this->db->insert("telescoop_web.member_questions",$value2);
					endif;
					
					$_POST['answer1'] = '';
					$_POST['answer2'] = '';
						
					echo "<script>alert('Successfully submitted challenge questions!')</script>";
				}
			}
			else
			{
				echo "<script>alert('Invalid Inputs!')</script>";
			}
		}
		
		$data['is_questions_answered2'] = $this->m_account->is_questions_answered2();
		$data['is_questions_answered'] = $this->m_account->is_questions_answered();
		$data['row_new_loans'] = $this->m_account->get_new_loans();
		$data['row_dividend'] = $this->m_account->get_dividend();
		$data['row_dep'] = $this->m_account->get_member_beneficiaries();
		$data['row'] = $this->m_account->get_member_info();
		$data['res_eval'] = $this->m_account->get_for_evaluation();
		$data['member_id'] = $this->session->userdata('member_id');
		$data['side_menu'] = 'account/side_menu';
		#$data['view_by'] = $this->input->post('view_by_savings');
		$data['body'] = 'account/home';
		
		$this->load->view('index',$data);
				
	}
		
	function ledger($member_id='')
	{
		if(!$this->session->userdata('is_login'))
        {
			echo "
					
			<script>
				
				alert('Session expired. Please login to continue.')
			
			</script>";
		}
		else
		{
			
			if(!empty($member_id))
			{
				$data['member_id'] = $member_id;
			}
			else{
				$data['member_id'] = $this->session->userdata('member_id');	
			}
			
			$this->load->view('account/ledger',$data);
		}
	}
	
	function inquiries()
	{
		
		
		$data['member_id'] = $this->session->userdata('member_id');
			
		$this->load->view('account/inquiries',$data);
	}
	
	function for_evaluation()
	{
		$config['protocol'] = 'smtp';
        $config['smtp_host'] = '192.168.200.5';
        $config['smtp_port'] = 25;
	      		
        $config['smtp_user'] = 'sysadmin@telescoop.com.ph';
        $config['smtp_pass'] = '1234';
        $config['mailtype'] = 'html';
		$config['charset']  = 'utf-8';
		$this->load->library('email', $config);
			
		$data['member_id'] = $this->session->userdata('member_id');
			
		$this->load->view('account/for_evaluation',$data);
	}
	
	function loan_calculator()
	{
		$data['member_id'] = $this->session->userdata('member_id');
			
		$this->load->view('account/for_evaluation',$data);
	}
	
	function request()
	{
		if($_POST)
		{
			
			if($this->m_account->check_if_already_has_access() == 1)
			{
				
				$this->form_validation->set_rules('bday', 'Birth date', 'required|callback_bday_check');
				$this->form_validation->set_rules('username', 'Username', 'alpha_numeric|min_length[6]|max_length[15]|required');
				$this->form_validation->set_rules('password', 'Password', 'min_length[6]|max_length[15]|required|matches[conf_password]');
				$this->form_validation->set_rules('member_id', 'TELESCOOP Member ID', 'required|callback_member_id_check');
				$this->form_validation->set_rules('emp_no', 'Employee No', 'callback_emp_no_check');
				$this->form_validation->set_rules('conf_password', 'Password Confirmation', 'required');
				$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
				$this->form_validation->set_rules('mobile', 'Mobile number #', 'min_length[9]|max_length[9]|required|integer');
				
				
				if ($this->form_validation->run() == FALSE)
				{
					$data['body'] = 'request_access';
					
					echo "<script>alert('Please check required fields!')</script>";
					
					$this->load->view('index',$data);
				}
				else
				{
					//INSERT TO mem_sys_access
					
						
					$return = $this->m_account->insert_member_access();
					
					if($return == 1)
					{
						$data['msg'] = 'Your account are now pending for evaluation. Please wait our notification to your email!';
					}
					else
					{
						$data['msg'] = 'Error: Username already taken!';
					}
					
					
					$data['body'] = 'request_access';
						
					$this->load->view('index',$data);
				}
			}
			elseif($this->m_account->check_if_already_has_access() == 2)
			{
				$data['msg'] = 'Your Member Id has already access.';
				
				$data['body'] = 'request_access';
						
				$this->load->view('index',$data);
			}
			elseif($this->m_account->check_if_already_has_access() == 3)
			{
				$data['msg'] = 'Your Member Id has already requested.';	
				
				$data['body'] = 'request_access';
						
				$this->load->view('index',$data);
			}
			
			
		}
		else
		{
			$data['body'] = 'request_access';
		
			$this->load->view('index',$data);
		}
		
		
	}
	
	function member_id_check()
	{
		if($this->m_account->check_member_id() == 1)
		{
			$this->form_validation->set_message('member_id_check', 'Your account is subject for board approval!');
			return FALSE;
		}
		elseif($this->m_account->check_member_id() == 3)
		{
			$this->form_validation->set_message('member_id_check', 'Your account was disapproved!');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	function bday_check()
	{
		
		if($this->m_account->check_member_bday() == 2)
		{
			$this->form_validation->set_message('bday_check', 'Your Birthday did not match in our record!');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
		
	}
	
	function emp_no_check()
	{
		if($this->m_account->check_member_emp_no() == 2)
		{
			$this->form_validation->set_message('emp_no_check', 'Your Employee No. did not match in our record!');
			return FALSE;
		}
		elseif($this->m_account->check_member_emp_no() == 3)
		{
			$this->form_validation->set_message('emp_no_check', 'Member ID not found!');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	
	function login()
	{
		if($this->session->userdata('is_login'))
        {
			redirect('account');
		}
		
		if(isset($_POST['login']))
		{
			
			$username = $this->input->post('myusername');
			$password = $this->input->post('mypassword');
			
			#echo $username;
			#echo $password;
			
			
			$sql = 'SELECT * 
					FROM telescoop_web.member_sys_access
					LEFT JOIN mem_members USING(member_id) 
					WHERE username = "'.$username.'" 
					AND md5(password) = md5("'.$password.'")
					LIMIT 1';
			
			$query = $this->db->query($sql);
			
			$level = $query->row('access_level'); //1 admin; 2 user;
			$mem_category = $query->row('member_category');
			$status = $query->row('access_status'); //1 admin; 2 user; 	
			
			#echo $query->num_rows().' num_rows()';
			
			
			
			if($query->num_rows() == 1 AND $status == 1)
			{
				
				if($mem_category != 1)
				{
					$data['body'] = 'login';
					$data['error'] = 'Your account has been deactivated!';
					$this->load->view('index',$data);
				}
				else
				{
					$newdata = array(
			                   'is_login'  => TRUE,
			                   'email'     => $query->row('email_add'),
			                    'member_id'     => $query->row('member_id'),
			                   'username' => $query->row('username')
			               );
					
					$this->session->set_userdata($newdata);
					
					$this->m_account->last_login();
					
					redirect('account');
				}
				
				
			}
			elseif($query->num_rows() == 0)
			{
				$data['body'] = 'login';
				$data['error'] = 'Login failed! Please try again.';
				$this->load->view('index',$data);
				
			}
			elseif($status = 2)	
			{
				$data['body'] = 'login';
				$data['error'] = 'Your account are now pending for evaluation. Please wait our notification to your email!';
				$this->load->view('index',$data);
			}
		}
		else{
			$data['body'] = 'login';
			$this->load->view('index',$data);
		}
		
		
	}
	
	function logout($int)
	{
		
			
		$newdata = array('is_login'  => FALSE);
					
		$this->session->set_userdata($newdata);
		
		#$this->session->sess_destroy();
		
		if(empty($int)){
			redirect('account/login');
		}else{
			redirect('home');
		}
		
		
	}
	
	function view_header($dr_number)
	{
		#echo '<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Under construction';
		
		$data['dr_number'] = $dr_number;
		
		$this->load->view('account/view_header',$data);
	}
	
	function comakers()
	{
		
		$member_id = $this->session->userdata('member_id');	
		
		$date = getLastBilling();
		$query = "  SELECT
					CONCAT(mem_lname, ', ', mem_fname, ' ', LEFT(mem_mname, 1), '.') as maker_name,
					D.dr_number as dr_number,
					A1.po_number as po_number,
					pay_period,
					beginning_bal,
					po_date,
					A1.maker_id as member_id,
					A1.sales_id
					FROM ar_loans_comakers A1 
					LEFT JOIN mem_members B1 on A1.maker_id = B1.member_id
					LEFT JOIN ar_loans_subs_detail C on A1.sales_id = C.sales_id
					LEFT JOIN ar_loans_header D on A1.sales_id = D.sales_id
					WHERE A1.member_id = $member_id and pay_period >= '$date' and end_bal > 0
					GROUP BY A1.po_number
					ORDER BY CONCAT(mem_lname, ', ', mem_fname, ' ', LEFT(mem_mname, 1), '.'), po_date, A1.po_number
					";
		$result = mysql_query($query) or die(mysql_error() .$query);
		
		/*$query = "SELECT CONCAT(member_lname,', ',member_fname) as maker_name,ar_member_subs_detail.*,dr_number,po_date
				FROM p_comakers
				LEFT JOIN members ON members.member_id = maker_id
				LEFT JOIN p_sales_header USING(po_number)
				INNER JOIN ar_member_subs_detail USING(po_number)
				WHERE p_comakers.member_id = 23299
				AND pay_period = '2014-06-15'";
				
		$result = mysql_query($query) or die (mysql_error().$query);*/
		$ctr = 1;
		
		echo "<p style='font-family:arial'>Co-maker Exposure as of <strong>$date</strong><br><br>";
		
		echo "<table border=1 width='100%' cellpadding='5' style='border-collapse:collapse;font-size:12px; font-family: Arial;'>
			  <tr style='background:lightgray;font-weight:bold'>
			  		<td>#</td>
				  	<td>Maker Name</td>
				  	<td>DR Number</td>
				  	<td>PO Number</td>
				  	<td>PO Date</td>
				  	<td align='center'>Balance </td>
				  	<td>Member Share</td>
				  	<td align='center'>Active CM</td>
				  	
			  </tr>
		
		";
		

		$t_ob = 0;
		$t_share = 0;
		
		if(mysql_num_rows($result) == 0)
		{
			echo "<tr>
					<td align = 'center' colspan = '11'>NO RECORD FOUND</td>";
			echo '</tr>';
		}
		else
		{
			
			while($row = mysql_fetch_array($result, MYSQL_ASSOC))
			{
				$q = "SELECT COUNT(po_number) as a
						FROM ar_loans_comakers
						LEFT JOIN mem_members USING (member_id)
						WHERE po_number='{$row['po_number']}' AND (company_id !=10 AND company_id !=25) AND member_category=1
						GROUP BY po_number";
				$r = mysql_query($q) or die(mysql_error());
				$r2 = mysql_fetch_array($r);
				
				
				$beg_balance = $row['beginning_bal'];
				
				$sql3 = "SELECT SUM(actual_payment) as t_payment
						 FROM ar_loans_subs_detail
						 WHERE sales_id = '{$row['sales_id']}'
						 AND pay_period >= '$date'
						 AND member_id = {$row['member_id']}
						 ";
				
				$query3 = mysql_query($sql3) or die(mysql_error().$sql3);
				$total = mysql_fetch_array($query3,MYSQL_ASSOC);
				
				$ob = $beg_balance - $total['t_payment'];
				
				$share = $ob / $r2['a'];
						
				$t_ob += $ob;
				$t_share += $share;
				
				if(empty($row['maker_name']))
				{
					$sql4 = "SELECT CONCAT(mem_lname,', ',mem_fname) as member_name
							 FROM ar_loans_header
						 	 LEFT JOIN mem_members USING(member_id)
							 WHERE dr_number = '{$row['dr_number']}'";
							 
					$r4 = mysql_query($sql4) or die(mysql_error());
					$r4 = mysql_fetch_array($r4);	
					
					$row['maker_name'] = $r4['member_name'];
				}
				
				echo " <tr >
						<td>".$ctr++."</td>
					  	<td>".strtoupper($row['maker_name'])."</td>
					  	<td>{$row['dr_number']}</td>
					  	<td>{$row['po_number']}</td>
					  	<td>".date('m/d/Y',strtotime($row['po_date']))."</td>
					  	<td align='right'>".number_format($ob,2)."</td>
					  	<td align='right'>".number_format($share,2)."</td>
					  	<td align='center'>{$r2['a']}</td>
				  </tr>";
			}
			
			echo " <tr >
						
					  	<td colspan='5' align='right'><strong>TOTAL:</strong></td>
					  	<td align='right'><strong>".number_format($t_ob,2)."</strong></td>
					  	<td align='right'><strong>".number_format($t_share,2)."</strong></td>
					  	<td align='center'>&nbsp;</td>
				  </tr>";
			
			echo "</table>";
		}
			
	}
	
	function fpdf($lastBilling,$is_current,$member_id='')
	{
		
		if($is_current == 1){
			$_GET['date'] = 0;
		}else{
			$_GET['date'] = 1;
		}
		
		$username = $this->session->userdata('username');
		
		
		if(!empty($member_id))
		{
			$member_id = $member_id;
		}else{
			$member_id = $this->session->userdata('member_id');
		}
		
		$this->load->library('subs_member');
		
		$pdf= new Subs_member('P','mm','Letter');
		$pdf->Member($member_id,$lastBilling,$is_current,$username);
		
			
		$query = "SELECT
                    A.member_id, 
                    CONCAT(member_lname, ', ', member_fname, ' ', LEFT(member_mname, 1), '.') AS name,
                    member_emp_id, member_emp_id2, company_name, member_lname, company_name, max(pay_period) as period, scs_divisor, 
                    bank_acct,account_no,member_hired_date,dedn_start_dt,E.bank_name,acct_remarks
                  FROM members A 							
			 	  LEFT JOIN companies B ON A.company_id = B.company_id
				  LEFT JOIN ar_member_subs C on A.member_id = C.member_id
				  LEFT JOIN member_account D on A.member_id = D.member_id
				  LEFT JOIN member_temp_bank E on D.bank_id = E.bank_id
				  WHERE A.member_id = {$member_id}
				  GROUP BY A.member_id, name,
						member_emp_id, member_emp_id2, company_name, member_lname, company_name";
		$result = mysql_query($query) or die (mysql_error().$query);
		$row = mysql_fetch_array($result, MYSQL_ASSOC);
		$scs_divisor = $row['scs_divisor'];
			
		$pdf->SetMargins(10,5,10);
		$pdf->SetAutoPageBreak(true , 40);
		$pdf->AliasNbPages();
		$pdf->AddPage();
		
		$nxtBilling = switch_next_date($lastBilling);
		
		
		$query = "SELECT subs_id, member_id, A.trans_id, pay_period, ROUND(beg_balance,6) as beg_balance, semi_mon_ammort, scheduled_dedn_amt, actual_payment, deferred_amount, ROUND(end_balance,6) as end_balance, post_by, post_date, B.trans_id, accnt_code, trans_type_sdesc, trans_type_ldesc, priority, semi_monthly_contrib, created_by, date_created, updated_by, date_updated
				FROM ar_member_subs A
				LEFT JOIN m_transaction_types B on A.trans_id = B.trans_id
				WHERE member_id = {$member_id} AND A.trans_id  in (3)
				AND A.pay_period = '$lastBilling'
			UNION ALL
				SELECT subs_id, member_id, A.trans_id, pay_period, ROUND(beg_balance,6) as beg_balance, semi_mon_ammort, scheduled_dedn_amt, actual_payment, deferred_amount, ROUND(end_balance,6)  as end_balance, post_by, post_date, B.trans_id, accnt_code, trans_type_sdesc, trans_type_ldesc, priority, semi_monthly_contrib, created_by, date_created, updated_by, date_updated 
				FROM ar_member_subs A
				LEFT JOIN m_transaction_types B on A.trans_id = B.trans_id
				WHERE member_id = {$member_id} AND A.trans_id not in (0,1,2,3,4,5,7,10)
				AND A.pay_period = '$lastBilling'
			UNION ALL
				SELECT subs_id, member_id, A.trans_id, pay_period, ROUND(beg_balance,6) as beg_balance, semi_mon_ammort, scheduled_dedn_amt, actual_payment, deferred_amount, ROUND(end_balance,6) as end_balance, post_by, post_date, B.trans_id, accnt_code, trans_type_sdesc, trans_type_ldesc, priority, semi_monthly_contrib, created_by, date_created, updated_by, date_updated 
				FROM ar_member_subs A
				LEFT JOIN m_transaction_types B on A.trans_id = B.trans_id
				WHERE member_id = {$member_id} AND A.trans_id in (10)
				AND A.pay_period = '$lastBilling'";
	//(SELECT MAX(pay_period) FROM ar_member_subs WHERE member_id = $member_id GROUP BY member_id LIMIT 1)
	$result = mysql_query($query) or die (mysql_error().$query);

	$y = 40;
	$t_dedn_amt = 0;
	$t_actual_pay = 0;
	$t_deferr = 0;
	$t_semi = 0;
	$t_end_bal = 0;
	$t_scs = 0;
	$pdf->SetFont('Arial','',8);
	while($row = mysql_fetch_array($result, MYSQL_ASSOC))
	{
		
		$chkOR_contrib = "SELECT sum(amt) as or_amount, pay_period1, pay_period2 FROM or_header A 
						INNER JOIN or_details B on A.or_id = B.or_id
					WHERE po_num = '{$row['accnt_code']}' AND or_date > '$lastBilling' AND or_date <= '$nxtBilling'
						AND member_id = {$member_id}
					GROUP BY po_num";
		$resultOR_contrib = mysql_query($chkOR_contrib) or die (mysql_error() . "Error in Query : ". $chkOR_contrib);
		$rowOR = mysql_fetch_array($resultOR_contrib, MYSQL_ASSOC);
		$or_contrib = is_null($rowOR['or_amount']) ? 0 : $rowOR['or_amount'];
		
		$qAdvance = "SELECT sum(actual_payment) as adv_payments FROM ar_member_subs
			WHERE trans_id = '{$row['trans_id']}' AND pay_period > '{$lastBilling}'  AND member_id = '{$member_id}'";
		$rAdvance = mysql_query($qAdvance) or die (mysql_error() . "Error in Query : ".$qAdvance);
		$rwAdvance = mysql_fetch_array($rAdvance, MYSQL_ASSOC);
		
		if ($_GET['date'] == 0)
		{
			if($row['trans_id'] == 9)
			{
				$qAdvance2 = "SELECT sum(actual_payment) as adv_payments
									 FROM ar_member_subs
									 WHERE trans_id = 10
									 AND pay_period > '{$lastBilling}'
									 AND member_id = '{$member_id}'";
				$rAdvance2 = mysql_query($qAdvance2) or die (mysql_error() . "Error in Query : ".$qAdvance2);
				$rwAdvance2 = mysql_fetch_array($rAdvance2, MYSQL_ASSOC);
				
				$rwAdvance['adv_payments'] += $rwAdvance2['adv_payments'];
			}
			
			
			#advance payments						
			$balance_contrib = $row['end_balance'] + $rwAdvance['adv_payments'];
			$payments_contrib = $or_contrib;
			$deferred = number_format($row['deferred_amount'],2,".",",");
			$t_deferr += $row['deferred_amount'];
		}
		else
		{
			/*
			if (!is_null($rowOR['or_amount']))
			{		/*				
				$pd1 = explode("-", $rowOR['pay_period1']);
				$pd2 = explode("-", $rowOR['pay_period2']);
				if (mktime(0,0,0,$pd1[1],$pd1[2], $pd1[0]) == mktime(0,0,0,$pd2[1],$pd2[2], $pd2[0]))
				{
					if ($or_contrib < $row['scheduled_dedn_amt'])
						$payments_contrib = 0;
					else 
					$payments_contrib = $row['scheduled_dedn_amt'] - $or_contrib;
				}
				else 
				$payments_contrib = $row['actual_payment'] - ($or_contrib - $rwAdvance['adv_payments']);	
				if ($or_contrib < $row['scheduled_dedn_amt'])
					$diff = $row['scheduled_dedn_amt']	- $or_contrib;	
				$deferred = ($or_contrib - $rwAdvance['adv_payments']) + $diff ;
				//$balance_contrib = ($or_contrib - $rwAdvance['adv_payments']) + $diff;
			#	$balance_contrib = $row['beg_balance'] - $payments_contrib;
				$balance_contrib = $row['end_balance'] - $deferred;
				$t_deferr += $deferred;
				$deferred = number_format($deferred,2,".",",");
			##else 
			#{*/
				$balance_contrib = $row['end_balance'];
				$payments_contrib = $row['actual_payment'];
				$deferred = number_format($row['deferred_amount'],2,".",",");
				$t_deferr += $row['deferred_amount'];
			#}				
			
		}
		$sched_dedn_amt = number_format($row['scheduled_dedn_amt'],2,".",",");
		$actual_pay = number_format($payments_contrib,2,".",",");
		
		$semi = number_format($row['semi_mon_ammort'],2,".",",");
		$end_bal = number_format($balance_contrib,2,".",",");
		
		$t_dedn_amt += $row['scheduled_dedn_amt'];
		$t_actual_pay += $payments_contrib;		
		$t_semi += $row['semi_mon_ammort'];
		$t_end_bal += $balance_contrib;
		
		if($row['trans_id'] == 9 OR $row['trans_id'] == 10) {
			$t_scs += $row['end_balance'];
		}

		$pdf->SetXY(3,$y);
		$pdf->Cell(9,5,$row['trans_type_sdesc'],0,0,'L');
		$pdf->Cell(63,5,'',0,0,'C');
		$pdf->Cell(18,5,$sched_dedn_amt,0,0,'R');
		$pdf->Cell(18,5,$actual_pay,0,0,'R');
		$pdf->Cell(18,5,$deferred,0,0,'R');
		$pdf->Cell(19,5,$semi,0,0,'R');
		$pdf->Cell(20,5,$end_bal,0,0,'R');
		$pdf->Cell(25,5,$row['trans_type_ldesc'],0,1,'L');	
		$y+=5;
		
		
		
		if($row['trans_id'] == 10){
			$scs1_exist = 1;
		}
		
		if($row['trans_id'] == 9){
			$scs_exist = 1;
		}
		
		
	}
	
	//===============================================================//
	//added by carl 
	//temporary sol'n to show scs (Hardcode)
	if($scs1_exist == 1 && $scs_exist != 1){
		
		$t_scs += 14000;
		$t_end_bal+= 14000;
		$pdf->SetXY(3,$y);
		$pdf->Cell(9,5,"SCS",0,0,'L');
		$pdf->Cell(63,5,'',0,0,'C');
		$pdf->Cell(18,5,"0.00",0,0,'R');
		$pdf->Cell(18,5,"0.00",0,0,'R');
		$pdf->Cell(18,5,"0.00",0,0,'R');
		$pdf->Cell(19,5,"0.00",0,0,'R');
		$pdf->Cell(20,5,"14,000.00",0,0,'R');
		$pdf->Cell(25,5,'Subscription Fee',0,0,'L');	
		#$pdf->Cell(10,5,'A',0,0,'C');	
		$y+=5;
		

	}
	
	
	
	if(mysql_num_rows($result) > 0) {
		$pdf->SetXY(3,$y);
		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(72,5,'',0,0,'C');
		$pdf->Cell(18,5,number_format($t_dedn_amt,2,".",","),1,0,'R');
		$pdf->Cell(18,5,number_format($t_actual_pay,2,".",","),1,0,'R');
		$pdf->Cell(18,5,number_format($t_deferr,2,".",","),1,0,'R');
		$pdf->Cell(19,5,number_format($t_semi,2,".",","),1,0,'R');
		$pdf->Cell(20,5,number_format($t_end_bal,2,".",","),1,1,'R');
	}	
	
		
	$today2 = date("Y-m-d");
	$query2 = "SELECT *, C.interest as intrst, A.po_number as this_po_number , po_start_date, pay_period, beginning_bal, C.commission, C.prod_id as prod, trans_type_sdesc
						FROM ar_member_subs_detail A 
							LEFT JOIN m_transaction_types B on A.trans_type = B.trans_id
							LEFT JOIN p_sales_header C on A.po_number = C.po_number
							LEFT JOIN m_loan_products D on C.prod_id = D.prod_id
						WHERE A.member_id = {$member_id} 
						AND A.pay_period = '$lastBilling'  
						AND C.prod_id NOT IN ( 'L-FS09'  ,'L-FS04')
						AND po_status != 5";
			
	//(SELECT MAX(pay_period) FROM ar_member_subs WHERE member_id = $member_id GROUP BY member_id LIMIT 1)
	$result2 = mysql_query($query2) or die (mysql_error().$query2);
	$ys = $y+10;
	$t_dedn_amt2 = 0;
	$t_actual_pay2 = 0;
	$t_deferr2 = 0;
	$t_semi2 = 0;
	$t_end_bal2 = 0;
	$t_principal = 0;
	$pdf->SetFont('Arial','',8);
	while($row2 = mysql_fetch_array($result2, MYSQL_ASSOC))
	{
		$chkOR_contrib = "SELECT sum(amt) as or_amount, pay_period1, pay_period2 FROM or_header A 
						INNER JOIN or_details B on A.or_id = B.or_id
					WHERE po_num = '{$row2['this_po_number']}' AND or_date > '$lastBilling' AND or_date <= '$nxtBilling'
						AND member_id = {$member_id}
					GROUP BY po_num";
		$resultOR_contrib = mysql_query($chkOR_contrib) or die (mysql_error() . "Error in Query : ". $chkOR_contrib);
		$rowOR = mysql_fetch_array($resultOR_contrib, MYSQL_ASSOC);
		$or_contrib = is_null($rowOR['or_amount']) ? 0 : $rowOR['or_amount'];
		
		$queryZ = "SELECT SUM(actual_payment) AS t_ap FROM ar_member_subs_detail 
					WHERE po_number = '{$row2['this_po_number']}' && pay_period > '$lastBilling'";
		$resultZ = mysql_query($queryZ);
		$rowZ = mysql_fetch_array($resultZ);
		
		if ($_GET['date'] == 0)
		{
			#advance payments						
			$end_bal2 = $row2['end_bal'] - $rowZ['t_ap'];
			$a_p = $or_contrib;
			$deferred2 = number_format($row2['deferred_amount'],2,".",",");
			$t_deferr2 += $row2['deferred_amount'];
		}
		else
		{
			if (!is_null($rowOR['or_amount']))
			{						
				$a_p = $row2['actual_payment']; #- ($or_contrib - $rowZ['t_ap']);										
				$deferred2 = ($row2['sched_dedn_amount'] - $a_p);		
				
				if($deferred2 < 0)
				{
					$deferred2 = 0;
				}
					
				$end_bal2 = ($row2['beginning_bal'] - $a_p);
				if ( $row2['prod'] != 'L-FS04'){
					$t_deferr2 += $deferred2;
				}
				
				$deferred2 = number_format($deferred2,2,".",",");
			}
			else 
			{
				$end_bal2  = $row2['end_bal'];
				$a_p	   = $row2['actual_payment'];
				$deferred2 = number_format($row2['deferred_amount'],2,".",",");
				
				if ( $row2['prod'] != 'L-FS04'){
						$t_deferr2 += $row2['deferred_amount'];
				}
			}				
		}
		
		$sched_dedn_amt2 = number_format($row2['sched_dedn_amount'],2,".",",");
		$actual_pay2 = number_format($a_p,2,".",",");		
		$semi2 = number_format($row2['semi_monthly_amort'],2,".",",");
		
		if ( $row2['prod'] != 'L-FS04' && $row2['prod'] != 'L-FS03')
		{
			$t_dedn_amt2 += $row2['sched_dedn_amount'];
		}
		$t_actual_pay2 += $a_p;		
		$t_semi2 += $row2['semi_monthly_amort'];
		
		if (is_null($row['post_ar_by']) && date("Y-m-d") == $lastBilling )
		{			
			$ending = $row2['beginning_bal'];
			$pd_left = (int)$row2['paydays_left'] - 1;
		}
		else 
		{			
			$ending = $row2['end_bal'];
			$pd_left = (int)$row2['paydays_left'];
		}
		if ($row2['prod'] != 'Ins' && $row2['prod'] != 'INS' && $row2['prod'] != 'L-FS04')
			$t_end_bal2 += $end_bal2;
		
		/*	
		if ($row2['prod'] == 'L-FS01' || $row2['prod'] == 'L-FS02' || $row2['prod'] == 'L-FS07' || $row2['prod'] == 'L-FS08' || $row2['prod'] == 'L-FS09' || $row2['prod'] == 'L-FS11')
		{
			
			#TEAM LOAN SCS REQUIREMENT
			if($row2['prod'] == 'L-FS11')
			{
				$sql_tm = mysql_query("SELECT member_hired_date 
									   FROM members 
									   WHERE member_id = {$_POST['member_id']}");
				$row_tm = mysql_fetch_row($sql_tm);
						
				$member_hired_dt = $row_tm[0];
					
				$los = getLOS_by_po($member_hired_dt,$row2['po_date']);
				
				if($los < 5)
				{
					$principal = $end_bal2;
					$sub_total += $principal;
				}
				else
				{
					$principal = 0;
				}	
			}
			else
			{	
				if ($row2['prod'] == 'L-FS01' || $row2['prod'] == 'L-FS02' || $row2['prod'] == 'L-FS07' || $row2['prod'] == 'L-FS08' || $row2['prod'] == 'L-FS11')
					$principal = $end_bal2;
				else
				{
					if ($row2['paydays_left'] > 0 && $row2['end_bal'] > 0)
						$principal = (float) $end_bal2 - (((float) $row2['intrst'] / ((int) $row2['pay_terms'] * 2)) * (int) $pd_left-1);				
					else 
						$principal = $end_bal2;
				}
				$sub_total += $principal;
			}
		}
		else
			$principal = 0;
		*/
		
		$principal = get_principal($row2['prod'],$end_bal2);	
		$sub_total += $principal;
		
		if ($row2['prod'] == 'L-FS04')	
		{	
			$semi2 = number_format($row2['semi_monthly_amort'],2,".",",");	
			$t_semi2 -= $row2['semi_monthly_amort'];
		}	
			
		$t_principal += $principal;	
		//$pdf->SetXY(3,$ys);
		$pdf->SetX(3);
		$asterisk = '';
		if ($row2['prod'] == 'INS' OR $row2['prod'] == 'Ins')	{
			$asterisk = ' *';
		}
		$prod_desc = $row2['Prod_Name'];
		if ($row2['prod'] == 'L-DS01' || $row2['prod'] == 'L-DS02' || $row2['prod'] == 'L-QTN')
		{
			$q1 = "SELECT item_short_desc, B.item_code 
					FROM p_items A
					INNER JOIN (SELECT item_code FROM p_sales_details WHERE sales_id = {$row2['sales_id']}) B on A.item_code = B.item_code
					WHERE A.item_code = B.item_code";
			$r1 = mysql_query($q1) or die (mysql_error() . "Error in Query : ".$q1);
			$rw1 = mysql_fetch_array($r1, MYSQL_ASSOC);
			
			$prod_desc = $rw1['item_short_desc'];
			
			
			if(empty($prod_desc)){
				$q2 = "SELECT *
					FROM p_sales_details
					WHERE sales_id = {$row2['sales_id']}";
				$r2 = mysql_query($q2) or die (mysql_error() . "Error in Query : ".$q2);
				$rw2 = mysql_fetch_array($r2, MYSQL_ASSOC);
				$prod_desc = $rw2['i_desc'];
			}
			
			if ($prod_desc == ''){
				$prod_desc = $row2['Prod_Name'];
			}
			
			$prod_desc = ucfirst(strtolower($prod_desc));
			
			$x = strlen($prod_desc);
	
			if($x > 30){
				$prod_desc = substr($prod_desc,0,30);
			}
		}
		
		$pdf->Cell(9,5,$row2['trans_type_sdesc'],0,0,'L');
		$pdf->Cell(25,5,$row2['this_po_number'],0,0,'L');
		$pdf->Cell(22,5,strtoupper($row2['dr_number']),0,0,'L');
		$pdf->Cell(16,5,transform_date($row2['end_dt']),0,0,'R');
		$pdf->Cell(18,5,$sched_dedn_amt2,0,0,'R');
		$pdf->Cell(18,5,$actual_pay2,0,0,'R');
		$pdf->Cell(18,5,$deferred2,0,0,'R');
		$pdf->Cell(19,5,$semi2,0,0,'R');
		if ($row2['prod'] == 'INS' OR $row2['prod'] == 'Ins')	{
			$pdf->Cell(20,5,'0.00',0,0,'R');
		}else{
			$pdf->Cell(20,5,number_format($end_bal2,2,".",","),0,0,'R');
		}
		
		$pdf->Cell(25,5,$prod_desc,0,1,'L');
		$ys+=5;
	}

	
	# Added By Majo : 2009-03-06 : Conso Loans
	$query4 = "SELECT *, C.interest as intrst, A.po_number as this_po_number , po_start_date, pay_period, beginning_bal, C.commission, dr_number
						FROM ar_member_subs_detail A 
							LEFT JOIN p_sales_details F on A.po_number = F.item_code
							LEFT JOIN p_sales_header C on F.sales_id = C.sales_id
							LEFT JOIN m_loan_products D on C.prod_id = D.prod_id
							LEFT JOIN m_transaction_types E on A.trans_type = E.trans_id
						WHERE A.member_id = {$member_id} AND A.pay_period = '$lastBilling' AND C.prod_id = 'L-FS09' 
							AND ((A.po_number LIKE '%-T' OR A.po_number LIKE '%-P' OR A.po_number LIKE '%-T2') OR (dr_number LIKE 'CLF_%' AND dr_number NOT LIKE 'CLF-2%')) AND po_status != 5";
	
	$result4 = mysql_query($query4) or die (mysql_error().$query4);
	
	$x = 0;
	while($row4 = mysql_fetch_array($result4, MYSQL_ASSOC))
	{
		$chkOR_contrib = "SELECT sum(amt) as or_amount, pay_period1, pay_period2 FROM or_header A 
						INNER JOIN or_details B on A.or_id = B.or_id
					WHERE po_num = '{$row4['this_po_number']}' AND or_date > '$lastBilling' AND or_date <= '$nxtBilling'
						AND member_id = {$member_id}
					GROUP BY po_num";
		$resultOR_contrib = mysql_query($chkOR_contrib) or die (mysql_error() . "Error in Query : ". $chkOR_contrib);
		$rowOR = mysql_fetch_array($resultOR_contrib, MYSQL_ASSOC);
		$or_contrib = is_null($rowOR['or_amount']) ? 0 : $rowOR['or_amount'];
		
		$queryZ = "SELECT SUM(actual_payment) AS t_ap FROM ar_member_subs_detail 
					WHERE po_number = '{$row4['this_po_number']}' && pay_period > '$lastBilling'";
		$resultZ = mysql_query($queryZ);
		$rowZ = mysql_fetch_array($resultZ);
		
		if ($_GET['date'] == 0)
		{
			#advance payments						
			$end_bal4 = $row4['end_bal'] - $rowZ['t_ap'];
			$a_p = $or_contrib;
			$deferred4 = number_format($row4['deferred_amount'],2,".",",");
			$t_deferr2 += $row4['deferred_amount'];
		}
		else
		{
			if (!is_null($rowOR['or_amount']))
			{			/*			
				$pd1 = explode("-", $rowOR['pay_period1']);
				$pd2 = explode("-", $rowOR['pay_period2']);
				if (mktime(0,0,0,$pd1[1],$pd1[2], $pd1[0]) == mktime(0,0,0,$pd2[1],$pd2[2], $pd2[0]))
					$a_p = $row4['sched_dedn_amount'] - $or_contrib;
				else
					$a_p = $row4['sched_dedn_amount'] - ($or_contrib - $rowZ['t_ap']);										
				$deferred4 = $or_contrib - $rowZ['t_ap'];
				$end_bal4 = $row4['beginning_bal'] - $a_p;		
				$t_deferr2 += $deferred4;
				$deferred4 = number_format($deferred4,2,".",",");
				*/
				$a_p = $row4['actual_payment'] - ($or_contrib - $rowZ['t_ap']);	
				$deferred4 = ($row4['sched_dedn_amount'] - $a_p);
				$end_bal4 = $row4['beginning_bal'] - $a_p;		
				$t_deferr2 += $deferred4;
				$deferred4 = number_format($deferred4,2,".",",");
			}
			else 
			{
				$end_bal4 = $row4['end_bal'];
				$a_p = $row4['actual_payment'];
				$deferred4 = number_format($row4['deferred_amount'],2,".",",");
				$t_deferr2 += $row4['deferred_amount'];
			}				
			
		}
		
		$sched_dedn_amt4 = number_format($row4['sched_dedn_amount'],2,".",",");
		$actual_pay4 = number_format($a_p,2,".",",");		
		$semi4 = number_format($row4['semi_monthly_amort'],2,".",",");
		
		
		$t_dedn_amt2 += $row4['sched_dedn_amount'];
		$t_actual_pay2 += $a_p;		
		$t_semi2 += $row4['semi_monthly_amort'];
		
		if(substr($row4['this_po_number'],-1) != 'P' ) 
					$t_end_bal2 += $end_bal4;
	
		/*			
					
		if(substr($row4['this_po_number'],-1) == 'T'  || substr($row4['this_po_number'],-2) == 'T2') 
			{
				$payd_left = $row4['paydays_left']-1;
				if ($row4['paydays_left'] > 0 && $row4['end_bal'] > 0)
				{
					$principal4 = (float) $end_bal4 - (((float) $row4['intrst'] / ((int) $row4['pay_terms'] * 2)) * (int)$payd_left);				
				}
				else
					$principal4 = $row4['end_bal'];				
					$sub_total += $principal4;
			}
		elseif (substr($row4['this_po_number'],-1) == 'P')
			{
				
				$principal4 = 0;					
				$sub_total += 0;			
				
			}
		*/
		
		$principal4 = get_principal('L-FS09',$end_bal4);
		$sub_total += $principal4;
				
		$t_principal += $principal4;	
		//$pdf->SetXY(3,$ys);
		$pdf->SetX(3);
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(9,5,$row4['trans_type_sdesc'],0,0,'L');
		$pdf->Cell(25,5,$row4['this_po_number'],0,0,'L');
		$pdf->Cell(22,5,strtoupper($row4['dr_number']),0,0,'L');
		$pdf->Cell(16,5,date("m/d/Y",strtotime($row4['end_dt'])),0,0,'C');
		$pdf->Cell(18,5,$sched_dedn_amt4,0,0,'R');
		$pdf->Cell(18,5,$actual_pay4,0,0,'R');
		$pdf->Cell(18,5,$deferred4,0,0,'R');
		$pdf->Cell(19,5,$semi4,0,0,'R');
		$pdf->Cell(20,5,number_format($end_bal4,2,".",","),0,0,'R');
		$pdf->Cell(25,5,substr($row4['Prod_Name'],0,15),0,1,'L');
		$ys+=5;
		
		
	
	}
	
	//$nextBilling = chkBilling($lastBilling);
	$lastBilling2 = switch_date($lastBilling);
	$end_dt = date("Y-m-d");//$_GET['billing_date']?$_GET['billing_date']:
	$query3 = "SELECT *, B.interest as intrst, A.po_number as this_po_number, po_start_date, pay_period, beginning_bal, B.prod_id as prod,trans_type_sdesc,
									B.commission as commission, net_proceeds, sales_id
								FROM ar_member_subs_detail A
									LEFT JOIN p_sales_header B ON A.po_number = B.po_number
										AND A.member_id = B.member_id
									LEFT JOIN m_loan_products C ON B.prod_id = C.prod_id	
									LEFT JOIN m_transaction_types D on A.trans_type = D.trans_id						
								WHERE  po_start_date > '$lastBilling' 
								#AND po_date <= '$lastBilling'
								AND C.prod_id != 'L-FS04'
								AND A.member_id = {$member_id} AND po_status != 5
								GROUP BY A.po_number
				UNION ALL
							
				SELECT A.*,C.*,D.*,F.*,C.interest as intrst,
						 A.po_number as this_po_number, po_start_date, pay_period, beginning_bal, C.prod_id as prod,trans_type_sdesc,
						 C.commission as commission, net_proceeds, C.sales_id
				FROM ar_member_subs_detail A
					LEFT JOIN p_sales_details E on A.po_number = E.item_code
					LEFT JOIN p_sales_header C on E.sales_id = C.sales_id
					LEFT JOIN m_loan_products D on C.prod_id = D.prod_id
					LEFT JOIN m_transaction_types F on A.trans_type = F.trans_id
				WHERE A.member_id = {$member_id} AND A.start_dt > '$lastBilling' 
				#AND C.po_date <= '$lastBilling'
				AND C.prod_id = 'L-FS09'
				AND ((A.po_number LIKE '%-T' OR A.po_number LIKE '%-P' OR A.po_number LIKE '%-T2') OR dr_number LIKE 'CLF_%'
				AND dr_number NOT LIKE 'CLF-2%')
				AND po_status != 5
				GROUP BY A.po_number";	
								
	#and approved_date <= '$today2'
	$result3 = mysql_query($query3) or die (mysql_error().$query3);	
	while($row3 = mysql_fetch_array($result3, MYSQL_ASSOC))
	{
		
		if ($row3['po_date'] <= $lastBilling OR $_GET['date'] == 0)
		{
		
			$a_p = 0;
			if ($_GET['date'] == 0)
			{
				#-------------------------------------------------------------------------------------------------
				$queryZ = "SELECT SUM(actual_payment) AS t_ap FROM ar_member_subs_detail 
							WHERE po_number = '{$row3['this_po_number']}'";
				$resultZ = mysql_query($queryZ);
				$rowZ = mysql_fetch_array($resultZ);
				$advance = $rowZ['t_ap'];
				
				$a_p = $advance;
				#-------------------------------------------------------------------------------------------------
			}
			$sched_dedn_amt3 = number_format($row3[''],2,".",",");
			$actual_pay3 = number_format($a_p,2,".",",");
			$deferred3 = number_format($row3[''],2,".",",");
			$semi3 = number_format($row3['semi_monthly_amort'],2,".",",");
			
			
			$t_dedn_amt2 += $row3[''];
			$t_actual_pay2 += $a_p;
			$t_deferr2 += $row3[''];
			$t_semi2 += $row3['semi_monthly_amort'];
			$end_bal3 = number_format($row3['beginning_bal'] - $a_p,2,".",",");	
			if ($row3['prod'] != 'Ins' && $row3['prod'] != 'INS' && $row3['prod'] != 'L-FS04')	
				$t_end_bal2 += $row3['beginning_bal'] - $a_p;
			
			$principal2 = get_principal($row3['prod'],$row3['beginning_bal']);		
			$sub_total += $principal2;
			
			if ($row3['prod'] == 'L-FS04')	
			{	
				$semi3 = number_format($row3[''],2,".",",");	
				$t_semi2 -= $row3['semi_monthly_amort'];
			}	
			
			/*
			if ($row3['prod'] == 'L-DS01' || $row3['prod'] == 'L-DS02' || $row3['prod'] == 'L-QTN')
			{
				
				
				$q1 = "SELECT item_short_desc, B.item_code 
						FROM p_items A
						INNER JOIN (SELECT item_code FROM p_sales_details WHERE sales_id = {$row3['sales_id']}) B on A.item_code = B.item_code
						WHERE A.item_code = B.item_code";
				$r1 = mysql_query($q1) or die (mysql_error() . "Error in Query : ".$q1);
				$rw1 = mysql_fetch_array($r1, MYSQL_ASSOC);
				
				$prod_desc = $rw1['item_short_desc'];
				
				
				if(empty($prod_desc)){
					$q2 = "SELECT *
						FROM p_sales_details
						WHERE sales_id = {$row3['sales_id']}";
					$r2 = mysql_query($q2) or die (mysql_error() . "Error in Query : ".$q2);
					$rw2 = mysql_fetch_array($r2, MYSQL_ASSOC);
					$prod_desc = $rw2['i_desc'];
				}
				
				if ($prod_desc == ''){
					$prod_desc = $row3['Prod_Name'];
				}
				
				$x = strlen($prod_desc);
	
				if($x > 32){
					$prod_desc = substr($prod_desc,0,32);
				}
			}
			*/
			
			if ($row3['prod'] == 'L-DS01' || $row3['prod'] == 'S-DS01' || $row3['prod'] == 'S-DS02' || $row3['prod'] == 'L-DS02' || $row3['prod'] == 'L-QTN')
			{
				$q1 = "SELECT item_short_desc, B.item_code 
						FROM p_items A
						INNER JOIN (SELECT item_code FROM p_sales_details WHERE sales_id = {$row3['sales_id']}) B on A.item_code = B.item_code
						WHERE A.item_code = B.item_code";
				$r1 = mysql_query($q1) or die (mysql_error() . "Error in Query : ".$q1);
				$rw1 = mysql_fetch_array($r1, MYSQL_ASSOC);
				
				$prod_desc = $rw1['item_short_desc'];
				
				
				if(empty($prod_desc)){
					$q2 = "SELECT *
						FROM p_sales_details
						WHERE sales_id = {$row3['sales_id']}";
					$r2 = mysql_query($q2) or die (mysql_error() . "Error in Query : ".$q2);
					$rw2 = mysql_fetch_array($r2, MYSQL_ASSOC);
					$prod_desc = $rw2['i_desc'];
				}
				
				if ($prod_desc == ''){
					$prod_desc = $row2['Prod_Name'];
				}
				
				$x = strlen($prod_desc);
	
				if($x > 32){
					$prod_desc = substr($prod_desc,0,32);
				}
				
				
			}
			else $prod_desc = $row3['Prod_Name'];
			
			
			
			$t_principal += $principal2;	
			//$pdf->SetXY(3,$ys);
			$pdf->SetX(3);
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(9,5,$row3['trans_type_sdesc'],0,0,'L');
			$pdf->Cell(25,5,$row3['this_po_number'],0,0,'L');
			$pdf->Cell(22,5,strtoupper($row3['dr_number']),0,0,'L');
			$pdf->Cell(16,5,date("m/d/Y",strtotime($row3['end_dt'])),0,0,'C');
			$pdf->Cell(18,5,$sched_dedn_amt3,0,0,'R');
			$pdf->Cell(18,5,$actual_pay3,0,0,'R');
			$pdf->Cell(18,5,$deferred3,0,0,'R');
			$pdf->Cell(19,5,$semi3,0,0,'R');
			$pdf->Cell(20,5,$end_bal3,0,0,'R');
			$pdf->Cell(25,5,$prod_desc,0,1,'L');
			$ys+=5;
		}
		
	}
	
		$chk_fullDed = "SELECT *
				    FROM m_fully_paid_deduction
				    WHERE member_id = {$member_id}
				    AND is_fully_paid = 1
				    AND pay_period >= '$lastBilling'";
						   
			$result_fullDed = mysql_query($chk_fullDed) or die (mysql_error() . "Error in Query : ". $chk_fullDed);
					
			while ($row_fullDed = mysql_fetch_array($result_fullDed, MYSQL_ASSOC))
			{
				$po = substr($row_fullDed['po_number'],-1);
				if($po == 'T')
					$po_n = "CONCAT(B.po_number,'-T')";
				elseif($po == 'P')
					$po_n = "CONCAT(B.po_number,'-P')";
				elseif($po == '2')
					{
					if((substr($row_fullDed['po_number'],-2)) == 'T2')
						{
						$po_n = "CONCAT(B.po_number,'-T2')";
						}
					else 
						$po_n = "B.po_number";
					}
				else 
					$po_n = "B.po_number";
				
					$query3 = "SELECT *,
								    B.interest as intrst,
									A.po_number as this_po_number,
									po_start_date,
									pay_period, 
									beginning_bal,
									B.prod_id as prod,
									trans_type_sdesc
							FROM ar_member_subs_detail_history A
							   LEFT JOIN p_sales_header B ON A.po_number = $po_n
							   AND A.member_id = B.member_id
							   LEFT JOIN m_loan_products C ON B.prod_id = C.prod_id		
							   LEFT JOIN m_transaction_types D ON A.trans_type= D.trans_id
							WHERE A.po_number = '{$row_fullDed['po_number']}'
							AND A.pay_period = '$lastBilling'
							AND po_status != 5";
							#AND A.post_ar_date IS NOT NULL";
						
				$result3 = mysql_query($query3) or die (mysql_error().$query3);	
				while($row5 = mysql_fetch_array($result3, MYSQL_ASSOC))
				{
					$last_cutoff = getLastBilling();
					if ($_GET['date'] == 0)
					{
						$qr = "SELECT *
								   FROM p_sales_rebate
								   WHERE po_number = '{$row5['this_po_number']}'";
						$rr = mysql_query($qr);
						$rwr = mysql_fetch_array($rr, MYSQL_ASSOC);
						$rbt = is_null($rwr['rebate_40']) ? 0 : $rwr['rebate_40'];
						
						$a_p = 0;
						
						$queryZ = "SELECT amt as t_ap FROM m_fully_paid_deduction
								   WHERE po_number = '{$row5['this_po_number']}'
								   AND pay_period = '$lastBilling'";	
								   			   
						$resultZ = mysql_query($queryZ);
						$rowZ = mysql_fetch_array($resultZ);
						$advance = $rowZ['t_ap'] - $rbt;
						$a_p = $advance;
						$endbal3 = 0;
						$deff3 = 0;
						$sched3 = 0;
						$principal2 = 0;
						
						#$t_end_bal2 -= $row3['actual_payment'];
						
					}
					else
					{
						if ($_GET['date'] == $last_cutoff)
						{
							$qr = "SELECT *
								   FROM p_sales_rebate
								   WHERE po_number = '{$row3['this_po_number']}'";
							$rr = mysql_query($qr);
							$rwr = mysql_fetch_array($rr, MYSQL_ASSOC);
							
							$rbt = is_null($rwr['rebate_40']) ? 0 : $rwr['rebate_40'];
							
							$sql3 = "SELECT *
									FROM ar_member_subs_detail_temp
									WHERE po_number = '{$row5['this_po_number']}'
									AND pay_period = '$lastBilling'";
									
							$row_sql3 = mysql_query($sql3) or die (mysql_error() . "Error in Query : ". $sql3);
							$rw = mysql_fetch_array($row_sql3);
							if(mysql_num_rows($row_sql3) > 0)
							{
								$a_p 	 = $rw['actual_payment'];
								$endbal3 = $rw['end_bal'];
								$deff3   = $rw['deferred_amount'];
								$sched3  = $rw['sched_dedn_amount'];
								$t_end_bal2 += $endbal3;
							}
							else
							{
								$endbal3 = $row5['end_bal'];
								$a_p = $row5['actual_payment'];
								$deff3 = $row5['deferred_amount'];
								$sched3 = $row5['sched_dedn_amount'];	
							}
						}
						else 
						{
							$endbal3 = $row5['end_bal'];
							$a_p = $row5['actual_payment'];
							$deff3 = $row5['deferred_amount'];
							$sched3 = $row5['sched_dedn_amount'];	
							
						}
						
						if ($row5['prod'] != 'L-FS03' && $row5['prod'] != 'L-FSVC' && $row5['prod'] != 'Ins' && $row5['prod'] != 'INS' && $row5['prod'] != 'L-FS04')
						{
							$principal2 = $row5['beginning_bal'] - $a_p;
							$sub_total += $principal2;
						}
						else
						{
							$principal2 = 0;
						}
						$principal2 = 0;
					}
					
					$end_bal3 = number_format($row5['beginning_bal'] - $a_p,2,".",",");
					$sched_dedn_amt3 = number_format($sched3,2,".",",");
					$actual_pay3 = number_format($a_p,2,".",",");
					$deferred3 = number_format($deff3,2,".",",");
					$semi3 = number_format($row5['semi_monthly_amort'],2,".",",");				
					
					$t_actual_pay2 += $a_p;
					$t_semi2 += $row5['semi_monthly_amort'];
					
					
					# not including INS and MPL in total end balance
					#=================================================================================#
					if ($row5['prod'] != 'Ins' && $row5['prod'] != 'INS' && $row5['prod'] != 'L-FS04')
					{
						$t_end_bal2 += $row5['end_bal'];#($row5['beginning_bal'] - $a_p );
						$t_dedn_amt2 += $sched3;
						$t_deferr2 += $deff3;
					}	
					#==================================================================================#
					#===============================================#
					if ($row3['prod'] == 'L-FS04')	
					{	
						$semi3 = number_format($row5[''],2,".",",");	
						$t_semi2 -= $row5['semi_monthly_amort'];
					}
					#===============================================#
					$t_principal += $principal2;
					
					$pdf->SetX(3);
					$pdf->SetFont('Arial','',8);
					$pdf->Cell(9,5,$row5['trans_type_sdesc'],0,0,'L');
					$pdf->Cell(25,5,$row5['this_po_number'],0,0,'L');
					$pdf->Cell(22,5,strtoupper($row5['dr_number']),0,0,'L');
					$pdf->Cell(16,5,date("m/d/Y",strtotime($row5['end_dt'])),0,0,'C');
					$pdf->Cell(18,5,$sched_dedn_amt3,0,0,'R');
					$pdf->Cell(18,5,$actual_pay3,0,0,'R');
					$pdf->Cell(18,5,$deferred3,0,0,'R');
					$pdf->Cell(19,5,$semi3,0,0,'R');
					$pdf->Cell(20,5,number_format($endbal3,2),0,0,'R');
					$pdf->Cell(25,5,substr($row5['Prod_Name'],0,15),0,1,'L');
				}	
			}
	
	
	
	//-----------------------------------------------------------------------------------------------------------------------------------------------
			#change jeth jan16, 2012
			$m = date('m',strtotime($lastBilling));
			$y = date('Y',strtotime($lastBilling));			   
			$chkOR_full = "SELECT *
						   FROM or_header A
						   LEFT JOIN or_details B ON A.or_id = B.or_id
						   #LEFT JOIN p_sales_header C ON B.po_num = C.po_number
						   WHERE A.member_id = {$member_id}
						   AND is_fully_paid = 1
						   AND MONTH(or_date) >= $m
 						   AND YEAR(or_date) = $y";
						   
			$resultOR_full = mysql_query($chkOR_full) or die (mysql_error() . "Error in Query : ". $chkOR_full);
			
			while ($row_full = mysql_fetch_array($resultOR_full, MYSQL_ASSOC))
			{	
				$header_p = "SELECT * FROM p_sales_header WHERE po_number = '{$row_full['po_num']}'";
				$query_p = mysql_query($header_p);
				$row_p = mysql_fetch_array($query_p);
				
				$sr_mora = 0;
				
				$po = substr($row_full['po_num'],-1);
				if($po == 'T')
					$po_n = "CONCAT(B.po_number,'-T')";
				elseif($po == 'P')
					$po_n = "CONCAT(B.po_number,'-P')";
				elseif($po == '2')
					{
					if((substr($row_full['po_num'],-2)) == 'T2')
						{
						$po_n = "CONCAT(B.po_number,'-T2')";
						}
					else 
						$po_n = "B.po_number";
					}
				else 
					$po_n = "B.po_number";
				
				
				if($row_p['moratorium'] == 1)
				{
					if( strtotime($row_p['po_start_date']) > strtotime($lastBilling) )
					{
						$query3 = "SELECT *,
							    B.interest as intrst,
								A.po_number as this_po_number,
								po_start_date,
								pay_period, 
								beginning_bal,
								B.prod_id as prod,
								trans_type_sdesc
						FROM ar_member_subs_detail_history A
						   LEFT JOIN p_sales_header B ON A.po_number = $po_n
						   AND A.member_id = B.member_id
						   LEFT JOIN m_loan_products C ON B.prod_id = C.prod_id		
						   LEFT JOIN m_transaction_types D ON A.trans_type= D.trans_id
						WHERE A.po_number = '{$row_full['po_num']}'
						AND B.po_start_date > '$lastBilling'
						AND po_status != 5
						GROUP BY A.po_number";
						
						$sr_mora = 1;
					}
					
				}
				elseif($row_p['Prod_Id'] == 'L-FS04') #MPL
				{
					$query3 = "SELECT *,
							    B.interest as intrst,
								A.po_number as this_po_number,
								po_start_date,
								pay_period, 
								beginning_bal,
								B.prod_id as prod,
								trans_type_sdesc
						FROM ar_member_subs_detail_history A
						   LEFT JOIN p_sales_header B ON A.po_number = $po_n
						   AND A.member_id = B.member_id
						   LEFT JOIN m_loan_products C ON B.prod_id = C.prod_id		
						   LEFT JOIN m_transaction_types D ON A.trans_type= D.trans_id
						WHERE A.po_number = '{$row_full['po_num']}'
						AND A.pay_period >= '$lastBilling'
						AND po_status != 5";
				}
				else
				{
					$query3 = "SELECT *,
							    B.interest as intrst,
								A.po_number as this_po_number,
								po_start_date,
								pay_period, 
								beginning_bal,
								B.prod_id as prod,
								trans_type_sdesc
						FROM ar_member_subs_detail_history A
						   LEFT JOIN p_sales_header B ON A.po_number = $po_n
						   AND A.member_id = B.member_id
						   LEFT JOIN m_loan_products C ON B.prod_id = C.prod_id		
						   LEFT JOIN m_transaction_types D ON A.trans_type= D.trans_id
						WHERE A.po_number = '{$row_full['po_num']}'
						AND A.pay_period >= '$lastBilling'
						AND po_status != 5
						LIMIT 1";
						
				
				}
				
				
				$result3 = mysql_query($query3) or die (mysql_error().$query3);	
				while($row3 = mysql_fetch_array($result3, MYSQL_ASSOC))
				{
					$last_cutoff = getLastBilling();
					
					$qr = "SELECT * FROM p_sales_rebate WHERE po_number = '{$row3['this_po_number']}'";
							$rr = mysql_query($qr);
							$rwr = mysql_fetch_array($rr, MYSQL_ASSOC);
					$rbt = is_null($rwr['rebate_40']) ? 0 : $rwr['rebate_40'];
					
					if ($_GET['date'] == 0)
					{
						
						
						$queryY = "SELECT SUM(actual_payment) AS t_ap
						   FROM ar_member_subs_detail_history 
						   WHERE po_number = '{$row3['this_po_number']}'
						   AND pay_period >= '$lastBilling'";
						$resultY = mysql_query($queryY);
						$rowY = mysql_fetch_array($resultY);
						
						$a_py = $rowY['t_ap'];	
						
						$queryZ = "SELECT SUM(amt) as t_ap FROM or_details
								   LEFT JOIN or_header USING(or_id)
								   WHERE po_num = '{$row3['this_po_number']}'
								   AND pay_period = '$lastBilling'";	
								   
						$resultZ = mysql_query($queryZ);
						$rowZ = mysql_fetch_array($resultZ);
						$advance = $rowZ['t_ap'];
						$a_p = $advance;
						$endbal3 = 0;
						$deff3 = 0;
						$sched3 = 0;
						$principal2 = 0;
						
						#$t_end_bal2 -= $rbt;
						#-------------------------------------------------------------------------------------------------
					}
					else
					{	
						
						if($sr_mora == 0)
						{			      
							$chkOR_contrib = "SELECT sum(amt) as or_amount, pay_period1, pay_period2
											  FROM or_header A 
											  INNER JOIN or_details B on A.or_id = B.or_id
										      WHERE po_num = '{$row3['this_po_number']}'
											  AND or_date >= '$lastBilling'
											  AND or_date <= '$nxtBilling'
											  AND member_id = {$member_id}
											  GROUP BY po_num";
											  
							$resultOR_contrib = mysql_query($chkOR_contrib) or die (mysql_error() . "Error in Query : ". $chkOR_contrib);
							$rowOR = mysql_fetch_array($resultOR_contrib, MYSQL_ASSOC);
							
							#=====================================================================#
							$or_contrib = is_null($rowOR['or_amount']) ? 0 : $rowOR['or_amount'];
							#=====================================================================#
							
							if ($_GET['date'] == $last_cutoff)
							{
								
									
								$queryZ = "SELECT SUM(actual_payment) AS t_ap 
										   FROM ar_member_subs_detail_history 
										   WHERE po_number = '{$row3['this_po_number']}' 
										   AND pay_period > '$lastBilling'";
								$resultZ = mysql_query($queryZ);
								$rowZ = mysql_fetch_array($resultZ);
								
							    if (!is_null($rowOR['or_amount']))
							    {														
									$sql3 = "SELECT *
											FROM ar_member_subs_detail_temp
											WHERE po_number = '{$row3['this_po_number']}'
											AND pay_period = '$lastBilling'";
											
									$row_sql3 = mysql_query($sql3) or die (mysql_error() . "Error in Query : ". $sql3);
									$rw = mysql_fetch_array($row_sql3);
									if(mysql_num_rows($row_sql3) > 0)
									{
										$a_p 	 = $rw['actual_payment'];
										$endbal3 = $rw['end_bal'];
										$deff3   = $rw['deferred_amount'];
										$sched3  = $rw['sched_dedn_amount'];
										
									}
									else
									{
										$a_p 	 = $row3['actual_payment'] - (($or_contrib - $rbt) - ($rowZ['t_ap']) + $rbt);
										if($row3['sched_dedn_amount'] < $a_p){
											$deff3   = 0;#$row3['sched_dedn_amount'] - $a_p;
										}else{
											$deff3   = $row3['sched_dedn_amount'] - $a_p;
										}
										$endbal3 = $row3['Prod_Id'] == 'L-FS03' ? $row3['end_bal'] : ($row3['beginning_bal'] - $a_p);
										
										
										#echo $endbal3;
										
										$sched3  = $row3['sched_dedn_amount'];
									}
								}
								else
								{
									$a_p 	 = $row3['actual_payment'];
									$endbal3 = $row3['end_bal'];
									$deff3   = $row3['deferred_amount'];
									$sched3  = $row3['sched_dedn_amount'];	
									
									#echo $endbal3;
								}
							}
							else 
							{
								$endbal3 = $row3['end_bal'];
								$a_p = $row3['actual_payment'];
								$deff3 = $row3['deferred_amount'];
								$sched3 = $row3['sched_dedn_amount'];	
							}
							
							if ($row3['prod'] != 'L-FS03' && $row3['prod'] != 'L-FSVC' && $row3['prod'] != 'Ins' && $row3['prod'] != 'INS' && $row3['prod'] != 'L-FS04')
							{
							$principal2 = 0;#$row3['beginning_bal'] - $a_p;
							$sub_total += 0;#$principal2;
							}
							else
							$principal2 = 0;
						}
					}
					
					if($sr_mora == 1 AND $_GET['date'] != 0)
					{
						$a_p = 0;
						$endbal3 = number_format($row3['beginning_bal'],2,".",",");	
						$sched_dedn_amt3 = number_format(0,2,".",",");
						$actual_pay3 = number_format(0,2,".",",");
						$deferred3 = number_format(0,2,".",",");
						$semi3 = number_format($row3['semi_monthly_amort'],2,".",",");	
					}
					else
					{
						if($_GET['date'] == 0)
						{
							$endbal3 = $row3['beginning_bal'] - $a_py;
								
							if($row3['end_bal'] == 0)
							{
								$endbal3 = 0;	
							}
							
							$sched_dedn_amt3 = number_format($sched3,2,".",",");
							$actual_pay3 = number_format($a_p,2,".",",");
							$deferred3 = number_format($deff3,2,".",",");
							$semi3 = number_format($row3['semi_monthly_amort'],2,".",",");		
						}
						else
						{
							
							
							$endbal3 = $row3['beginning_bal'] - $a_p;
							$sched_dedn_amt3 = number_format($sched3,2,".",",");
							$actual_pay3 = number_format($a_p,2,".",",");
							$deferred3 = number_format($deff3,2,".",",");
							$semi3 = number_format($row3['semi_monthly_amort'],2,".",",");		
						}
					}	
		
					$t_actual_pay2 += $a_p;
					$t_semi2 += $row3['semi_monthly_amort'];
					
					if ($row3['prod'] != 'Ins' && $row3['prod'] != 'INS' && $row3['prod'] != 'L-FS04')	
						$t_end_bal2 += $endbal3;#($row3['beginning_bal'] - $a_p );
						$t_dedn_amt2 += $sched3;
						$t_deferr2 += $deff3;
					
					
					if ($row3['prod'] == 'L-FS04')	
					{	
						$semi3 = number_format($row3[''],2,".",",");	
						$t_semi2 -= $row3['semi_monthly_amort'];
					}
					$t_principal += $principal2;	
					
					
					$sql = "SELECT rebate_40 as rbt
							FROM p_sales_rebate
							WHERE po_number = '{$row3['this_po_number']}'";
							
					$row_sql = mysql_query($sql) or die (mysql_error() . "Error in Query : ". $sql);
					$rbtrow = mysql_fetch_array($row_sql);
					$actual_pay3 = $actual_pay3 <=0 ? number_format(0,2,".",",") : $actual_pay3;
					
					if($endbal3 > 0){
						$endbal3 -= $rbtrow['rbt'];
						$t_end_bal2 -= $rbtrow['rbt'];
					}
					
					$pdf->SetX(3);
					$pdf->SetFont('Arial','',8);
					$pdf->Cell(9,5,$row3['trans_type_sdesc'],0,0,'L');
					$pdf->Cell(25,5,$row3['this_po_number'],0,0,'L');
					$pdf->Cell(22,5,strtoupper($row3['dr_number']),0,0,'L');
					$pdf->Cell(16,5,date("m/d/Y",strtotime($row3['end_dt'])),0,0,'C');
					$pdf->Cell(18,5,$sched_dedn_amt3,0,0,'R');
					$pdf->Cell(18,5,$actual_pay3,0,0,'R');
					$pdf->Cell(18,5,$deferred3,0,0,'R');
					$pdf->Cell(19,5,$semi3,0,0,'R');
					$pdf->Cell(20,5,number_format($endbal3,2),0,0,'R');
					$pdf->Cell(25,5,substr($row3['Prod_Name'],0,15),0,1,'L');
					/*echo "
							<tr><td colspan=\"11\"></td></tr>
							<tr class=\"normal\">
								<td class = 'td'>{$row3['trans_type_sdesc']}</td>
								<td class = 'td'>{$row3['this_po_number']}</td>
								<td class = 'td'>{$row3['dr_number']}</td>
								<td class = 'td'>".date("m/d/Y",strtotime($row3['end_dt']))."</td>
								<td class = 'td' align=\"right\">$sched_dedn_amt3</td>
								<td class = 'td' align=\"right\">$actual_pay3</td>
								<td class = 'td' align=\"right\">$deferred3</td>
								<td class = 'td' align=\"right\">$semi3</td>
								<td class = 'td' align=\"right\"><span style=\"color: red; font-size: 10px; font-weight: 700;\">**</span>".number_format($endbal3,2,".",",")."</td>
								<td class = 'td' align=\"right\">".number_format($principal2,2,".",",")."</td>
								<td class = 'td'>{$row3['Prod_Name']}</td>
							</tr>
							";*/
					$x++;
					}	
			}
			//-----------------------------------------------------------------------------------------------------------------------------------------------	
			$chkfull = "SELECT *
						FROM m_fully_paid
						WHERE is_fully_paid = 1
						AND pay_period >= '$lastBilling'
						AND member_id = {$member_id}";
			$chkfull_res = mysql_query($chkfull) or die (mysql_error().$chkfull);
			
			while ($row_fulls = mysql_fetch_array($chkfull_res, MYSQL_ASSOC))
			{
				
				$po = substr($row_fulls['po_number'],-1);
				if($po == 'T')
					$po_n = "CONCAT(B.po_number,'-T')";
				elseif($po == 'P')
					$po_n = "CONCAT(B.po_number,'-P')";
				elseif($po == '2')
					{
					if((substr($row_fulls['po_number'],-2)) == 'T2')
						{
						$po_n = "CONCAT(B.po_number,'-T2')";
						}
					else 
						$po_n = "B.po_number";
					}
				else 
					$po_n = "B.po_number";
				
				$query4 = "SELECT *,
							    B.interest as intrst,
								A.po_number as this_po_number,
								po_start_date,
								pay_period, 
								beginning_bal,
								B.prod_id as prod,
								trans_type_sdesc,
								B.semi_mo_amor as semi
						FROM ar_member_subs_detail_history A
						   LEFT JOIN p_sales_header B ON A.po_number = $po_n
						   AND A.member_id = B.member_id
						   LEFT JOIN m_loan_products C ON B.prod_id = C.prod_id		
						   LEFT JOIN m_transaction_types D ON A.trans_type= D.trans_id
						WHERE A.po_number = '{$row_fulls['po_number']}'
						AND A.pay_period = '$lastBilling'
						AND B.Prod_Id NOT IN ('L-FS04')
						AND po_status != 5
						AND A.post_ar_date IS NOT NULL";
						
				$result4 = mysql_query($query4) or die (mysql_error().$query3);	
				while($row4 = mysql_fetch_array($result4, MYSQL_ASSOC))
				{
					$mpl_name = get_mpl_name($row4['pay_period']);
					
					if ($_GET['date'] == 0)
					{
						$a_p = 0;
						$endbal3 = 0;
						$deff3 = 0;
						$sched3 = 0;
						$principal2 = 0;
						$semi4 = 0;
						
						if($row4['prod'] != 'L-FS04')
							$t_end_bal2 -= $row4['actual_payment'];
						
					}
					else
					{
						$principal2 = 0;
						$endbal3 = $row4['end_bal'];
						$a_p = $row4['actual_payment'];
						$deff3 = $row4['deferred_amount'];
						$sched3 = $row4['sched_dedn_amount'];	
						$semi4 = 0;#$row4['semi'];
					}
					
					$end_bal3 = ($row4['beginning_bal'] - $a_p);
					$sched_dedn_amt3 = $sched3;#number_format($sched3,2,".",",");
					$actual_pay3 = $a_p;#number_format($a_p,2,".",",");
					$deferred3 = $deff3;#number_format($deff3,2,".",",");
					$semi3 = $semi4;#number_format($semi4,2,".",",");		
							
					$actual_pay3 = $actual_pay3 <=0 ? number_format(0,2,".",",") : $actual_pay3;
					
					$sched_dedn_amt3 = $sched_dedn_amt3 <=0 ? number_format(0,2,".",",") : $sched_dedn_amt3;
					
					$t_actual_pay2 += $actual_pay3;
					
					$t_semi2 += $row4['semi'];
					
					
					/* not including INS and MPL in total end balance*/
					#=================================================================================#
					if ($row4['prod'] != 'Ins' && $row4['prod'] != 'INS' && $row4['prod'] != 'L-FS04')
					{
						$t_end_bal2 += ($row4['beginning_bal'] - $a_p );
						$t_dedn_amt2 += $sched3;
						$t_deferr2 += $deff3;
					}	
					#==================================================================================#
					#===============================================#
					if ($row4['prod'] == 'L-FS04')	
					{	
						$semi3 = number_format($row4[''],2,".",",");	
						$t_semi2 -= $row4['semi'];
					}
					#===============================================#
					#$t_principal += $principal2;
					
					$pdf->SetX(3);
					$pdf->SetFont('Arial','',8);
					$pdf->Cell(9,5,$row4['trans_type_sdesc'],0,0,'L');
					$pdf->Cell(25,5,$row4['this_po_number'],0,0,'L');
					$pdf->Cell(22,5,strtoupper($row4['dr_number']),0,0,'L');
					$pdf->Cell(16,5,date("m/d/Y",strtotime($row4['end_dt'])),0,0,'C');
					$pdf->Cell(18,5,number_format($sched_dedn_amt3,2),0,0,'R');
					$pdf->Cell(18,5,number_format($actual_pay3,2),0,0,'R');
					$pdf->Cell(18,5,$deferred3,0,0,'R');
					$pdf->Cell(19,5,number_format($semi3,2),0,0,'R');
					$pdf->Cell(20,5,number_format($endbal3,2),0,0,'R');
					$pdf->Cell(25,5,substr($row4['Prod_Name'],0,15),0,1,'L');
					
					$x++;
				}
			}
			
			
			//-----------------------------------------------------------------------------------------------------------------------------------------------	

	
	#$pdf->SetX(1);#,$ys);
	$pdf->Ln(1);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(65,5,'Total Payroll Accounts',T,0,'R');
	$pdf->Cell(18,5,number_format($t_dedn_amt2,2,".",","),1,0,'R');
	$pdf->Cell(18,5,number_format($t_actual_pay2,2,".",","),1,0,'R');
	$pdf->Cell(18,5,number_format($t_deferr2,2,".",","),1,0,'R');
	$pdf->Cell(19,5,number_format($t_semi2,2,".",","),1,0,'R');
	$pdf->Cell(20,5,number_format($t_end_bal2,2,".",","),1,1,'R');
		
	$g_dedn_amt = $t_dedn_amt2 + $t_dedn_amt;
	$g_actual_pay = $t_actual_pay2 + $t_actual_pay;
	$g_deferr = $t_deferr2 + $t_deferr;
	$g_semi = $t_semi2 + $t_semi;
	$g_end_bal = $t_end_bal2; #+ $t_end_bal;
	
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(65,5,'',0,0,'R');
	$pdf->Cell(18,5,number_format($g_dedn_amt,2,".",","),1,0,'R');
	$pdf->Cell(18,5,number_format($g_actual_pay,2,".",","),1,0,'R');
	$pdf->Cell(18,5,number_format($g_deferr,2,".",","),1,0,'R');
	$pdf->Cell(19,5,number_format($g_semi,2,".",","),1,1,'R');
	
	$pdf->Ln(5);
	
	#$pdf->Ln(2);
	
	#MPL POSTING LAST BILLING
#--------------------------------------------------#	
	$mpl_last_billing = mpl_last_billing();
	$mpl_last_billing_nxt = get_next_ben_month($mpl_last_billing);
	
	$today_mpl = date("Y-m-d");
	
	$query_mpl = "SELECT *, C.interest as intrst, A.po_number as this_po_number , po_start_date, pay_period, beginning_bal, 
							C.commission, C.prod_id as prod, trans_type_sdesc
				  FROM ar_member_subs_detail A 
						LEFT JOIN m_transaction_types B on A.trans_type = B.trans_id
						LEFT JOIN p_sales_header C on A.po_number = C.po_number
						LEFT JOIN m_loan_products D on C.prod_id = D.prod_id
				  WHERE A.member_id = {$member_id} 
				  AND A.pay_period = '$mpl_last_billing'  
				  AND C.prod_id = 'L-FS04'  
				  AND po_status != 5
				  ORDER BY A.po_number";	
				  
	#echo $query_mpl;			  			
			
	//(SELECT MAX(pay_period) FROM ar_member_subs WHERE member_id = $member_id GROUP BY member_id LIMIT 1)
	$result_mpl = mysql_query($query_mpl) or die (mysql_error().$query_mpl);
	
	$one_mpl = mysql_num_rows($result_mpl);
	
	$pdf->SetFont('Arial','',8);
	$t_dedn_amt_mpl =0;
	$t_actual_pay_mpl =0;
	$t_deferr_mpl =0;
	$t_semi_mpl =0;
	$t_end_bal_mpl =0;
	while($row_mpl = mysql_fetch_array($result_mpl, MYSQL_ASSOC))
	{
		$mpl_name = get_mpl_name($row_mpl['pay_period']);
		
		#START OF CHECKING
		$mpl_date = "$year-$prev_month-15"; 
		
		$sql_mpl2 = "SELECT *
					 FROM ar_member_subs_detail
					 WHERE po_number = '{$row_mpl['this_po_number']}'
					 AND pay_period = '$mpl_last_billing'";
					 
		$result = mysql_query($sql_mpl2) or die(mysql_error().$sql_mpl2);	
		
		if(mysql_num_rows($result) > 0)
		{
			
			#FOR UPDATE
			$chkOR_contrib_mpl = "SELECT sum(amt) as or_amount, pay_period1, pay_period2 FROM or_header A 
							  INNER JOIN or_details B on A.or_id = B.or_id
						      WHERE po_num = '{$row_mpl['this_po_number']}' 
						      AND or_date > '$mpl_last_billing' 
						      AND or_date <= '$mpl_last_billing_nxt'
							  AND member_id = {$member_id}
						      GROUP BY po_num";
			$resultOR_contrib_mpl = mysql_query($chkOR_contrib_mpl) or die (mysql_error() . "Error in Query : ". $chkOR_contrib_mpl);
			$rowOR_mpl = mysql_fetch_array($resultOR_contrib_mpl, MYSQL_ASSOC);
			$or_contrib_mpl = is_null($rowOR_mpl['or_amount']) ? 0 : $rowOR_mpl['or_amount'];
			
			$queryZ_mpl = "SELECT SUM(actual_payment) AS t_ap 
						   FROM ar_member_subs_detail 
						   WHERE po_number = '{$row_mpl['this_po_number']}' 
						   AND pay_period > '$mpl_last_billing'";
			$resultZ_mpl = mysql_query($queryZ_mpl);
			$rowZ_mpl = mysql_fetch_array($resultZ_mpl);
			/*
			if ($_GET['date'] == 0)
			{
				#advance payments						
				$end_bal_mpl = $row_mpl['end_bal'] - $rowZ_mpl['t_ap'];
				$a_p_mpl = $or_contrib_mpl;
				$deferred_mpl = number_format($row_mpl['deferred_amount'],2,".",",");
				$t_deferr2 += $row_mpl['deferred_amount'];
				$t_end_bal_mpl += $row_mpl['end_bal'] - $rowZ_mpl['t_ap'];
				$t_deferr_mpl += $row_mpl['deferred_amount'];
			}
			else
			{
			*/		
				if (!is_null($rowOR_mpl['or_amount']))
				{						
					$a_p_mpl = $row_mpl['actual_payment'] - ($or_contrib_mpl - $rowZ_mpl['t_ap']);										
					$deferred_mpl = ($row_mpl['sched_dedn_amount'] - $a_p_mpl);			
					$end_bal_mpl = ($row_mpl['beginning_bal'] - $a_p_mpl);
					#$end_bal2 = $row2['Prod_Id'] == 'L-FS03' ? $row2['end_bal'] : ($row2['beginning_bal'] - $a_p);		
					if ( $row_mpl['prod'] != 'L-FS04'){
						$t_deferr2 += $deferred_mpl;
					}
					
					$t_deferr_mpl += $deferred_mpl;
					$deferred_mpl = number_format($deferred_mpl,2,".",",");
					$t_end_bal_mpl += ($row_mpl['beginning_bal'] - $a_p_mpl);
					
				}
				else 
				{
					$end_bal_mpl  = $row_mpl['end_bal'];
					$a_p_mpl	   = $row_mpl['actual_payment'];
					$deferred_mpl = number_format($row_mpl['deferred_amount'],2,".",",");
					
					$t_deferr_mpl += $row_mpl['deferred_amount'];
					
					$t_end_bal_mpl += $row_mpl['end_bal'];
				}				
				
			#}
			
			$sched_dedn_amt_mpl = number_format($row_mpl['sched_dedn_amount'],2,".",",");
			$actual_pay_mpl = number_format($a_p_mpl,2,".",",");		
			$semi_mpl = number_format($row_mpl['semi_monthly_amort'],2,".",",");
			
			
			$t_actual_pay2 += $a_p_mpl;		
			$t_semi2 += $row_mpl['semi_monthly_amort'];
			
			if (is_null($row_mpl['post_ar_by']) && date("Y-m-d") == $lastBilling )
			{			
				$ending = $row_mpl['beginning_bal'];
				$pd_left = (int)$row_mpl['paydays_left'] - 1;
			}
			else 
			{			
				$ending = $row_mpl['end_bal'];
				$pd_left = (int)$row_mpl['paydays_left'];
			}
			
			$principal = 0;
			
			if ($row_mpl['prod'] == 'L-FS04')	
			{	
				$semi_mpl = number_format($row_mpl['semi_monthly_amort'],2,".",",");	
				$t_semi2 -= $row_mpl['semi_monthly_amort'];
			}	
				
			$t_principal += $principal;	
			//$pdf->SetXY(3,$ys);
			$pdf->SetX(3);
			
			$pdf->Cell(9,5,$row_mpl['trans_type_sdesc'],0,0,'L');
			$pdf->Cell(25,5,$row_mpl['this_po_number'],0,0,'L');
			$pdf->Cell(22,5,strtoupper($row_mpl['dr_number']),0,0,'L');
			$pdf->Cell(16,5,date("m/d/Y",strtotime($row_mpl['end_dt'])),0,0,'C');
			$pdf->Cell(18,5,$sched_dedn_amt_mpl,0,0,'R');
			$pdf->Cell(18,5,$actual_pay_mpl,0,0,'R');
			$pdf->Cell(18,5,$deferred_mpl,0,0,'R');
			$pdf->Cell(19,5,$semi_mpl,0,0,'R');
			$pdf->Cell(20,5,number_format($end_bal_mpl,2,".",","),0,0,'R');
			#$pdf->Cell(10,5,'A',0,0,'C');	
			$pdf->Cell(25,5,substr($row_mpl['Prod_Name'],0,15).$mpl_name,0,1,'L');
			$ys+=5;
			
			$t_dedn_amt_mpl += $row_mpl['sched_dedn_amount'];
			$t_actual_pay_mpl += $a_p_mpl;
			
			$t_semi_mpl +=$row_mpl['semi_monthly_amort'];
			
		}
	}
		
			
	$chkfull = "SELECT *
				FROM m_fully_paid
				WHERE is_fully_paid = 1
				AND pay_period >= '$mpl_last_billing'
				AND member_id = {$member_id}";
	$chkfull_res = mysql_query($chkfull) or die (mysql_error().$chkfull);
	
	$two_mpl = mysql_num_rows($chkfull_res);
	
	if($one_mpl > 0 OR $two_mpl > 0)
	{
	
	while ($row_fulls = mysql_fetch_array($chkfull_res, MYSQL_ASSOC))
	{
		
		$po = substr($row_fulls['po_number'],-1);
		if($po == 'T')
			$po_n = "CONCAT(B.po_number,'-T')";
		elseif($po == 'P')
			$po_n = "CONCAT(B.po_number,'-P')";
		elseif($po == '2')
			{
			if((substr($row_fulls['po_number'],-2)) == 'T2')
				{
				$po_n = "CONCAT(B.po_number,'-T2')";
				}
			else 
				$po_n = "B.po_number";
			}
		else 
			$po_n = "B.po_number";
		
		$query4 = "SELECT *,
					    B.interest as intrst,
						A.po_number as this_po_number,
						po_start_date,
						pay_period, 
						beginning_bal,
						B.prod_id as prod,
						trans_type_sdesc,
						B.semi_mo_amor as semi
				FROM ar_member_subs_detail_history A
				   LEFT JOIN p_sales_header B ON A.po_number = $po_n
				   AND A.member_id = B.member_id
				   LEFT JOIN m_loan_products C ON B.prod_id = C.prod_id		
				   LEFT JOIN m_transaction_types D ON A.trans_type= D.trans_id
				WHERE A.po_number = '{$row_fulls['po_number']}'
				AND A.pay_period = '{$row_fulls['pay_period']}'
				AND B.Prod_Id IN ('L-FS04')
				AND po_status != 5
				";
				
		$result4 = mysql_query($query4) or die (mysql_error().$query3);	
		while($row4 = mysql_fetch_array($result4, MYSQL_ASSOC))
		{
			$mpl_name = get_mpl_name($row4['pay_period']);
			
			/*if ($_GET['date'] == 0)
			{
				$a_p = 0;
				$endbal3 = 0;
				$deff3 = 0;
				$sched3 = 0;
				$principal2 = 0;
				$semi4 = 0;
				
				if($row4['prod'] != 'L-FS04')
					$t_end_bal2 -= $row4['actual_payment'];
				
			}
			else
			{*/
				$principal2 = 0;
				$endbal3 = $row4['end_bal'];
				$a_p = $row4['actual_payment'];
				$deff3 = $row4['deferred_amount'];
				$sched3 = $row4['sched_dedn_amount'];	
				$semi4 = 0;#$row4['semi'];
			#}
			
			$end_bal3 = ($row4['beginning_bal'] - $a_p);
			$sched_dedn_amt3 = $sched3;#number_format($sched3,2,".",",");
			$actual_pay3 = $a_p;#number_format($a_p,2,".",",");
			$deferred3 = $deff3;#number_format($deff3,2,".",",");
			$semi3 = $semi4;#number_format($semi4,2,".",",");		
					
			$actual_pay3 = $actual_pay3 <=0 ? number_format(0,2,".",",") : $actual_pay3;
			
			$sched_dedn_amt3 = $sched_dedn_amt3 <=0 ? number_format(0,2,".",",") : $sched_dedn_amt3;
			
			$t_actual_pay2 += $actual_pay3;
			
			$t_semi2 += $row4['semi'];
			
			
			#===============================================#
			if ($row4['prod'] == 'L-FS04')	
			{	
				$semi3 = number_format($row4[''],2,".",",");	
				$t_semi2 -= $row4['semi'];
			}
			#===============================================#
			#$t_principal += $principal2;
			
			$pdf->SetX(3);
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(9,5,$row4['trans_type_sdesc'],0,0,'L');
			$pdf->Cell(25,5,$row4['this_po_number'],0,0,'L');
			$pdf->Cell(22,5,strtoupper($row4['dr_number']),0,0,'L');
			$pdf->Cell(16,5,date("m/d/Y",strtotime($row4['end_dt'])),0,0,'C');
			$pdf->Cell(18,5,number_format($sched_dedn_amt3,2,".",","),0,0,'R');
			$pdf->Cell(18,5,number_format($actual_pay3,2,".",","),0,0,'R');
			$pdf->Cell(18,5,$deferred3,0,0,'R');
			$pdf->Cell(19,5,$semi3,0,0,'R');
			$pdf->Cell(20,5,$endbal3,0,0,'R');
			$pdf->Cell(25,5,substr($row4['Prod_Name'],0,15).$mpl_name,0,1,'L');
			
			$t_dedn_amt_mpl += $row4['sched_dedn_amount'];
			$t_actual_pay_mpl += $a_p;
			
			#$t_semi_mpl +=$row4['semi'];
			
			
			$ys+=5;
		}
	}
	
	

	
	
	
	$pdf->Ln(1);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(65,5,'Total MPL Accounts',T,0,'R');
	$pdf->Cell(18,5,number_format($t_dedn_amt_mpl,2,".",","),1,0,'R');
	$pdf->Cell(18,5,number_format($t_actual_pay_mpl,2,".",","),1,0,'R');
	$pdf->Cell(18,5,number_format($t_deferr_mpl,2,".",","),1,0,'R');
	$pdf->Cell(19,5,number_format($t_semi_mpl,2,".",","),1,0,'R');
	$pdf->Cell(20,5,number_format($t_end_bal_mpl,2,".",","),1,1,'R');
	
	
	
	}
	
	$query_mpl = "SELECT *, C.interest as intrst, A.po_number as this_po_number , po_start_date, pay_period, beginning_bal, 
							C.commission, C.prod_id as prod, trans_type_sdesc
				  FROM ar_member_subs_detail A 
						LEFT JOIN m_transaction_types B on A.trans_type = B.trans_id
						LEFT JOIN p_sales_header C on A.po_number = C.po_number
						LEFT JOIN m_loan_products D on C.prod_id = D.prod_id
				  WHERE A.member_id = {$member_id} 
				  AND A.pay_period > '$mpl_last_billing'  
				  AND C.prod_id = 'L-FS04'  
				  AND po_status != 5
				  GROUP BY A.po_number
				  #ORDER BY pay_period DESC,po_start_date DESC";				
			
	//(SELECT MAX(pay_period) FROM ar_member_subs WHERE member_id = $member_id GROUP BY member_id LIMIT 1)
	$result_mpl = mysql_query($query_mpl) or die (mysql_error().$query_mpl);
	
	$three_mpl = mysql_num_rows($result_mpl);
	
	if($three_mpl > 0)
	{
	
	$pdf->SetFont('Arial','',8);
	$t_dedn_amt_mpl =0;
	$t_actual_pay_mpl =0;
	$t_deferr_mpl =0;
	$t_semi_mpl =0;
	$t_end_bal_mpl =0;
	while($row_mpl = mysql_fetch_array($result_mpl, MYSQL_ASSOC))
	{
		$mpl_name = get_mpl_name($row_mpl['pay_period']);
		
		#START OF CHECKING
		$mpl_date = "$year-$prev_month-15"; 
		
		$sql_mpl2 = "SELECT *
					 FROM ar_member_subs_detail
					 WHERE po_number = '{$row_mpl['this_po_number']}'
					 AND pay_period = '{$row_mpl['pay_period']}'";
					 
		$result = mysql_query($sql_mpl2) or die(mysql_error().$sql_mpl2);	
		
		if(mysql_num_rows($result) > 0)
		{
		
			$chkOR_contrib_mpl = "SELECT sum(amt) as or_amount, pay_period1, pay_period2 FROM or_header A 
							  INNER JOIN or_details B on A.or_id = B.or_id
						      WHERE po_num = '{$row_mpl['this_po_number']}' 
						      AND or_date > '$mpl_last_billing' 
						      AND or_date <= '$mpl_last_billing_nxt'
							  AND member_id = {$member_id}
						      GROUP BY po_num";
			$resultOR_contrib_mpl = mysql_query($chkOR_contrib_mpl) or die (mysql_error() . "Error in Query : ". $chkOR_contrib_mpl);
			$rowOR_mpl = mysql_fetch_array($resultOR_contrib_mpl, MYSQL_ASSOC);
			$or_contrib_mpl = is_null($rowOR_mpl['or_amount']) ? 0 : $rowOR_mpl['or_amount'];
			
			$queryZ_mpl = "SELECT SUM(actual_payment) AS t_ap 
						   FROM ar_member_subs_detail 
						   WHERE po_number = '{$row_mpl['this_po_number']}' 
						   AND pay_period > '$mpl_last_billing'";
			$resultZ_mpl = mysql_query($queryZ_mpl);
			$rowZ_mpl = mysql_fetch_array($resultZ_mpl);
			/*
			if ($_GET['date'] == 0)
			{
				#advance payments						
				$end_bal_mpl = $row_mpl['end_bal'] - $rowZ_mpl['t_ap'];
				$a_p_mpl = $or_contrib_mpl;
				$deferred_mpl = number_format($row_mpl['deferred_amount'],2,".",",");
				$t_deferr2 += $row_mpl['deferred_amount'];
				$t_end_bal_mpl += $row_mpl['end_bal'] - $rowZ_mpl['t_ap'];
				$t_deferr_mpl += $row_mpl['deferred_amount'];
			}
			else
			{
				*/
					
				if (!is_null($rowOR_mpl['or_amount']))
				{						
					$a_p_mpl = $row_mpl['actual_payment'] - ($or_contrib_mpl - $rowZ_mpl['t_ap']);										
					$deferred_mpl = ($row_mpl['sched_dedn_amount'] - $a_p_mpl);			
					$end_bal_mpl = ($row_mpl['beginning_bal'] - $a_p_mpl);
					#$end_bal2 = $row2['Prod_Id'] == 'L-FS03' ? $row2['end_bal'] : ($row2['beginning_bal'] - $a_p);		
					if ( $row_mpl['prod'] != 'L-FS04'){
					#	$t_deferr2 += $deferred_mpl;
					}
					
					#$t_deferr_mpl += $deferred_mpl;
					$deferred_mpl = number_format($deferred_mpl,2,".",",");
					#$t_end_bal_mpl += ($row_mpl['beginning_bal'] - $a_p_mpl);
					
				}
				else 
				{
					$end_bal_mpl  = $row_mpl['end_bal'];
					$a_p_mpl	   = $row_mpl['actual_payment'];
					$deferred_mpl = number_format($row_mpl['deferred_amount'],2,".",",");
					
					$t_deferr_mpl += $row_mpl['deferred_amount'];
					
					$t_end_bal_mpl += $row_mpl['end_bal'];
				}				
				
			#}
			
			$sched_dedn_amt_mpl = number_format($row_mpl['sched_dedn_amount'],2,".",",");
			$actual_pay_mpl = number_format($a_p_mpl,2,".",",");		
			$semi_mpl = number_format($row_mpl['semi_monthly_amort'],2,".",",");
			
			
			$t_actual_pay2 += $a_p_mpl;		
			$t_semi2 += $row_mpl['semi_monthly_amort'];
			
			if (is_null($row_mpl['post_ar_by']) && date("Y-m-d") == $lastBilling )
			{			
				$ending = $row_mpl['beginning_bal'];
				$pd_left = (int)$row_mpl['paydays_left'] - 1;
			}
			else 
			{			
				$ending = $row_mpl['end_bal'];
				$pd_left = (int)$row_mpl['paydays_left'];
			}
			
			$principal = 0;
			
			if ($row_mpl['prod'] == 'L-FS04')	
			{	
				$semi_mpl = number_format($row_mpl['semi_monthly_amort'],2,".",",");	
				$t_semi2 -= $row_mpl['semi_monthly_amort'];
			}	
				
			$t_principal += $principal;	
			//$pdf->SetXY(3,$ys);
			$pdf->SetX(3);
			
			$pdf->Cell(9,5,$row_mpl['trans_type_sdesc'],0,0,'L');
			$pdf->Cell(25,5,$row_mpl['this_po_number'],0,0,'L');
			$pdf->Cell(22,5,strtoupper($row_mpl['dr_number']),0,0,'L');
			$pdf->Cell(16,5,date("m/d/Y",strtotime($row_mpl['end_dt'])),0,0,'C');
			$pdf->Cell(18,5,$sched_dedn_amt_mpl,0,0,'R');
			$pdf->Cell(18,5,$actual_pay_mpl,0,0,'R');
			$pdf->Cell(18,5,$deferred_mpl,0,0,'R');
			$pdf->Cell(19,5,$semi_mpl,0,0,'R');
			$pdf->Cell(20,5,number_format($end_bal_mpl,2,".",","),0,0,'R');
			#$pdf->Cell(10,5,'A',0,0,'C');	
			$pdf->Cell(25,5,substr($row_mpl['Prod_Name'],0,15).$mpl_name	,0,1,'L');
			$ys+=5;
			
			$t_dedn_amt_mpl += $row_mpl['sched_dedn_amount'];
			$t_actual_pay_mpl += $a_p_mpl;
			
			$t_semi_mpl +=$row_mpl['semi_monthly_amort'];
			
		}
	}
	
	$pdf->Ln(1);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(65,5,'Total MPL Accounts',T,0,'R');
	$pdf->Cell(18,5,number_format($t_dedn_amt_mpl,2,".",","),1,0,'R');
	$pdf->Cell(18,5,number_format($t_actual_pay_mpl,2,".",","),1,0,'R');
	$pdf->Cell(18,5,number_format($t_deferr_mpl,2,".",","),1,0,'R');
	$pdf->Cell(19,5,number_format($t_semi_mpl,2,".",","),1,0,'R');
	$pdf->Cell(20,5,number_format($t_end_bal_mpl,2,".",","),1,1,'R');
	
	$g_end_bal += $t_end_bal_mpl;
	
	}
	
	
	$pdf->Ln(1);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(65,5,'Grand Total:',0,0,'R');
	$pdf->Cell(18,5,number_format($g_dedn_amt,2,".",","),B,0,'R');
	$pdf->Cell(18,5,number_format($g_actual_pay,2,".",","),B,0,'R');
	$pdf->Cell(18,5,number_format($g_deferr,2,".",","),B,0,'R');
	$pdf->Cell(19,5,number_format($g_semi,2,".",","),B,0,'R');
	$pdf->Cell(20,5,number_format($g_end_bal,2,".",","),B,1,'R');
	$pdf->Ln(1);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(65,5,'',0,0,'R');
	$pdf->Cell(18,5,'',T,0,'R');
	$pdf->Cell(18,5,'',T,0,'R');
	$pdf->Cell(18,5,'',T,0,'R');
	$pdf->Cell(19,5,'',T,0,'R');
	$pdf->Cell(20,5,'',T,1,'R');
	
	
	#END
		
	$pdf->SetX(4);	
	$pdf->SetFont('Arial','B',8);
	#$pdf->Cell(8,5,'Note:',0,0,'L');	
	$pdf->SetFont('Arial','I',8);
	
	
	$pdf->SetX(4);
		
		
	$pdf->Output();
		
	}
}
