<?

class M_account extends CI_Model {

    var $mem_access_id = NULL;
	var $member_id   = '';
	var $username   = '';
	var $password   = '';
	var $email_add   = '';
	var $access_levels   = '';
	var $access_status   = '';
	var $date_register   = '';
	var $date_approved   = '';
	var $approved_by   = '';
	var $last_login   = '';
	var $last_login_mobile   = '';
	var $is_change_password   = '';
	var $is_validated   = '';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function message_out($mobile_no)
    {

    	$this->db->insert('telescoop_web.ozekimessageout',
    	array('receiver'=> $mobile_no,
    		  'msg' => 'Your registration was confirmed. You may now access your account by logging in to TELESCOOP website using your log in credentials. Thank you. - telescoop.com.ph',
    		  'status'=> 'send'));

    }

    function get_puc($member_id,$pay_period)
	{
		$sql = <<<SQL
		SELECT *
		FROM ar_member_subs
		WHERE trans_id IN (9,10)
		AND pay_period = '$pay_period'
		AND member_id = $member_id
		ORDER BY trans_id
SQL;
		$query = mysql_query($sql) or die(mysql_error().$sql);

		$puc = 0;

		if(mysql_num_rows($query) > 1)
		{
			$end = 0;
			while($row = mysql_fetch_array($query,MYSQL_ASSOC))
			{

				if($row['trans_id'] == 9)
				{
					$end += $row['end_balance'];
				}

				if($row['trans_id'] == 10)
				{
					$end += $row['end_balance'];
				}
			}

			$puc += $end;

			return $puc;
		}
		else
		{
			$row = mysql_fetch_array($query, MYSQL_ASSOC);

			if($row['trans_id'] == 10)
			{
				$puc += 14000;
			}

			$queryZ = "SELECT SUM(actual_payment) AS t_ap
					   FROM ar_member_subs
					   WHERE member_id = $member_id
					   AND trans_id = {$row['trans_id']}
					   AND pay_period >= '$pay_period'";
			$resultZ = mysql_query($queryZ);# or die(mysql_error().$sql;
			$rowZ = mysql_fetch_array($resultZ);


			$end = $row['beg_balance'] + $rowZ['t_ap'];

			$puc += $end;

			#echo "{$row['beg_balance']} + {$rowZ['actual_payment']}";

			return $puc;
		}

	}

	function get_ob($member_id,$pay_period)
	{

		#EXCLUDE SR, MPL

		$sql = <<<SQL
		(
			SELECT 1 as m_priority,members.member_id,Prod_Id, po_number, trans_type, priority, beginning_bal, end_bal,
					 semi_monthly_amort, sched_dedn_amount, actual_payment, pay_period, paydays_left,
					 start_dt, end_dt,po_date,sales_id FROM members
			LEFT JOIN ar_member_subs_detail a USING (member_id)
			LEFT JOIN p_sales_header USING (po_number)
			LEFT JOIN m_transaction_types ON a.trans_type = m_transaction_types.trans_id
			WHERE a.member_id = '$member_id' && pay_period = '$pay_period'
			AND Prod_Id IN('L-FS08','INS')
			AND po_status NOT IN (5,2)
		)

		UNION ALL

		(
			SELECT 2 as m_priority,members.member_id,Prod_Id, po_number, trans_type, priority, beginning_bal, end_bal,
					 semi_monthly_amort, sched_dedn_amount, actual_payment, pay_period, paydays_left,
					 start_dt, end_dt,po_date,sales_id FROM members
			LEFT JOIN ar_member_subs_detail a USING (member_id)
			LEFT JOIN p_sales_header USING (po_number)
			LEFT JOIN m_transaction_types ON a.trans_type = m_transaction_types.trans_id
			WHERE a.member_id = '$member_id'  && pay_period = '$pay_period'
			AND Prod_Id NOT IN('L-FS09','L-FS08','INS','L-FS04','L-FS03')
			AND po_status NOT IN (5,2)
		)

		UNION ALL
		(
			SELECT 2 as m_priority,members.member_id,Prod_Id, a.po_number, trans_type, priority, beginning_bal, end_bal,
					 semi_monthly_amort, sched_dedn_amount, actual_payment, pay_period, paydays_left,
					 start_dt, end_dt,po_date,sales_id FROM members
			LEFT JOIN ar_member_subs_detail a USING (member_id)
			LEFT JOIN p_sales_details b ON (a.po_number = b.item_code)
			LEFT JOIN p_sales_header USING (sales_id)
			LEFT JOIN m_transaction_types ON a.trans_type = m_transaction_types.trans_id
			WHERE a.member_id = '$member_id' && pay_period = '$pay_period'
			AND Prod_Id = 'L-FS09'
			AND a.po_number LIKE '%-T%'
			AND po_status NOT IN (5,2)
		)
		UNION ALL
		(
			SELECT 3 as m_priority,members.member_id,Prod_Id, po_number, trans_type, priority, beginning_bal, end_bal,
					 semi_monthly_amort, sched_dedn_amount, actual_payment, pay_period, paydays_left,
					 start_dt, end_dt,po_date,sales_id FROM members
			LEFT JOIN ar_member_subs_detail a USING (member_id)
			LEFT JOIN pdc_payroll_deductions USING(po_number)
			LEFT JOIN p_sales_header USING (po_number)
			LEFT JOIN m_transaction_types ON a.trans_type = m_transaction_types.trans_id
			WHERE a.member_id = '$member_id' && pay_period = '$pay_period'
			AND Prod_Id NOT IN('L-FS09','L-FS08','INS','L-FS04')
			AND (deduction_type = 1)
			AND po_status NOT IN (5,2)
		)

		ORDER BY m_priority, priority, po_date, sales_id ASC
SQL;
		$query = mysql_query($sql) or die(mysql_error().$sql);

		$ob = 0;

		#INCLUDE FINES & PENALTIES
		$queryZ = "SELECT *
				   FROM ar_member_subs
				   WHERE member_id = $member_id
				   AND pay_period = '$pay_period'
				   AND trans_id = 3";
		$resultZ = mysql_query($queryZ);
		$rowZ = mysql_fetch_array($resultZ);

		while($row = mysql_fetch_array($query,MYSQL_ASSOC))
		{
			if(($row['m_priority'] == 1 OR $row['m_priority'] == 2) AND $row['trans_type'] != 5)
			{
				$end = $row['end_bal'];

				$ob += $end;
			}
		}

		return $ob + $rowZ['end_balance'];;
	}

    function is_questions_answered()
    {
    	$member_id = $this->session->userdata('member_id');

    	$sql = "SELECT *
		       	FROM telescoop_web.member_questions
				WHERE member_id = $member_id";
		$query = $this->db->query($sql);

		if($query->num_rows() > 0){

			return TRUE;
		}
		else{
			return FALSE;
		}

    }

    function is_questions_answered2()
    {
    	$member_id = $this->session->userdata('member_id');

    	$sql = "SELECT *,DATE(last_login) as last_logged
				FROM telescoop_web.member_sys_access
				LEFT JOIN telescoop_web.member_questions USING(member_id)
				WHERE member_id = $member_id
				#AND is_validated = 1
				GROUP BY member_id
				";
		$query = $this->db->query($sql);
		$row = $query->row();

		if($row->is_validated == 1)
		{
			return TRUE;
		}
		else
		{
			if($row->last_logged == $row->date_added){
				return TRUE;
			}else{
				return FALSE;
			}
		}

    }

    function question_validate()
    {
    	$member_id = $this->session->userdata('member_id');

    	$sql = "SELECT *
		       	FROM telescoop_web.member_questions
				WHERE member_id = $member_id
				ORDER BY RAND()
				LIMIT 1";
		$query = $this->db->query($sql);

		if($query->num_rows() > 0){

			return TRUE;
		}
		else{
			return FALSE;
		}

    }

    function send_bday()
    {


    	$qry_chk = $this->db->query("SELECT * FROM telescoop_web.bday_messenger WHERE bday_date = CURDATE() AND is_sent = 1");

    	if($qry_chk->num_rows() == 0)
    	{
    		$sql = <<<SQL

	    	SELECT *
	    	FROM telescoop_web.member_sys_access
			LEFT JOIN mem_members USING(member_id)
	   		WHERE DATE_FORMAT(mem_bday,'%m-%d') = DATE_FORMAT(NOW(), '%m-%d');
SQL;
/*
			$query = $this->db->query($sql);


			$config['protocol'] = 'smtp';
	        $config['smtp_host'] = '192.168.200.5';
	        $config['smtp_port'] = 25;

	        $config['smtp_user'] = 'sysadmin@telescoop.com.ph';
	        $config['smtp_pass'] = '1234';
	        $config['mailtype'] = 'html';
	 		$config['charset']  = 'utf-8';
	 		$this->load->library('email', $config);



			foreach($query->result() as $row)
			{
				$this->email->clear();

				$msg = "<br>

				Birthdays are filled with yesterday's memories, today's joys, and tomorrow's dreams.

				<br>
				May this day be filled with sunshine and smiles, laughter, love, and cheer.

				<br><br><br>
				Wishing  you a <strong>HAPPY BIRTHDAY</strong> and many more years to come…………

				<br><br><br>

				Thank you for being a member  of <strong>TELESCOOP</strong>………

				<br>
				";

				$this->email->to($row->email_add);

			    $this->email->from('sysadmin@telescoop.com.ph', 'TELESCOOP');
			    $this->email->subject("Birthday Greetings");
			    $this->email->message($msg);
			    $this->email->send();
			}

    		$this->db->query("DELETE FROM telescoop_web.bday_messenger WHERE bday_date <> CURDATE()");

    		$this->db->query("INSERT INTO telescoop_web.bday_messenger VALUES (NOW(),1)");
*/
    	}








    }


	function chk_if_dm_release($sales_id)
	{
		$sql = "SELECT *
				FROM p_debit_memo_h A
				LEFT JOIN p_debit_memo_d B ON A.dm_number = B.dm_number
				WHERE B.sales_id = $sales_id";
		$query = $this->db->query($sql);

		if($query->num_rows() > 0)
		{
			if(!is_null($query->row('audited_by')))
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}
		else
		{
			return FALSE;
		}


	}

	function chk_if_check_release($sales_id)
	{
		$sql = "SELECT *
				FROM p_check_d A
				WHERE doc_ref = $sales_id
				AND check_txn = 1";
		$query = $this->db->query($sql);



		$row = $query->row();

		if($query->num_rows() > 0)
		{
			if(!is_null($row->audited_by))
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}


	}



    function get_new_loans()
    {
    	#GETTING LAST TWO(2) WEEKS OF THEIR NEWLY APPLIED LOANS
    	#EXCLUDE CANCELLED PO'S
    	$member_id = $this->session->userdata('member_id');

    	$sql = "SELECT *
				FROM ar_loans_header
				LEFT JOIN stg_loan_products USING(Prod_Id)
				WHERE po_date >= curdate() - INTERVAL DAYOFWEEK(curdate())+12 DAY
				AND po_date < curdate() - INTERVAL DAYOFWEEK(curdate())-12 DAY
				AND member_id = $member_id
				AND prod_name NOT IN ('MPL')
				AND po_order_status NOT IN('cancelled','disapproved')
				AND po_date NOT IN ('2012-04-08')
				AND sales_id <> 635228
				AND release_type > 0";
		$query = $this->db->query($sql);

		#echo $sql;

		return $query;
    }

    function get_dividend()
    {
    	$member_id = $this->session->userdata('member_id');

    	$sql = "SELECT *
		       	FROM telescoop_web.dividend_2016
				WHERE member_id = $member_id";
		$query = $this->db->query($sql);


		return $query->row();
    }

    function get_member_info()
    {
    	$member_id = $this->session->userdata('member_id');

		$sql = "SELECT *
				FROM mem_members
				LEFT JOIN mem_emplevel USING(emp_level_id)
				LEFT JOIN telescoop_web.member_sys_access USING(member_id)
				WHERE member_id = $member_id";

		#echo $sql;

		$query = $this->db->query($sql);


		return $query->row();
    }

    function get_member_beneficiaries()
    {
    	$member_id = $this->session->userdata('member_id');

    	$sql = "SELECT *
    			FROM mem_beneficiaries
				LEFT JOIN mem_relationship USING(rel_id)
				WHERE member_id =$member_id";

		$query = $this->db->query($sql);

		return $query->result();


    }

    function get_member_info_by_member_id($member_id)
    {
		$sql = "SELECT *,CONCAT(mem_lname,', ',mem_fname,', ',mem_mname) as name
				FROM mem_members
				LEFT JOIN telescoop_web.member_sys_access USING(member_id)
				WHERE member_id = $member_id";
		$query = $this->db->query($sql);


		return $query->row();
    }

    function get_for_evaluation($search='')
    {
    	$where = '';

    	if(!empty($search))
    	{
    		$where = "AND member_id = '$search' OR mem_lname LIKE '%$search%' OR mem_fname = '%$search%'";
    	}


    	$sql = "SELECT *
				FROM telescoop_web.member_sys_access
				LEFT JOIN mem_members USING(member_id)
				LEFT JOIN stg_company USING(company_id)
				WHERE access_status = 2
				AND approved_by IS NULL
				$where";
		$query = $this->db->query($sql);

		return $query->result();
    }

	function last_login()
	{
		$member_id = $this->session->userdata('member_id');


		if(!empty($member_id)){
			$date = date('Y-m-d G:i:s');
			$sql = "UPDATE telescoop_web.member_sys_access
					SET last_login = '$date'
					WHERE member_id = $member_id
					";
			$query = $this->db->query($sql);
		}


	}

    function login()
    {
    	$this->username = $this->input->post('username');
		$this->password = $this->input->post('password');
    }


    function insert_member_access()
    {
    	$this->member_id   = $this->input->post('member_id');
		$this->username = $this->input->post('username');


		$str = rand(0,99).str_shuffle("abcdefghijklmonpqrstuvwxyz").rand(0,99).str_shuffle("ABCDEFGHIJKLMOPQRSTUVWXYZ").rand(0,99).str_shuffle("abcdefghijklmonpqrstuvwxyz").rand(0,99);
		$str = substr(str_shuffle($str),0,8);

		$this->password = $str;#$this->input->post('password');


		$this->email_add = $this->input->post('email');
		$this->mobile_no = '+639'.$this->input->post('mobile');
		$this->is_notify_sms = 0;
		$this->access_levels = 2;
		$this->access_status = 2;
		$this->date_register = date('Y-m-d');
		$this->date_approved = '0000-00-00';
		$this->approved_by = NULL;
		$this->last_login = NULL;
		$this->last_login_mobile = NULL;
		$this->is_validated = 0;
		$this->is_change_password = 1;


		$query = $this->db->get_where('mem_members',array('member_id' =>$this->member_id));

		$mem_lname = $query->row('mem_lname');
		$mem_fname = $query->row('mem_fname');
		$mem_mname = $query->row('mem_mname');


		#CHECK IF USERNAME IS ALREADY TAKEN ~

		$query3 = $this->db->get_where('telescoop_web.member_sys_access',array('username'=>$this->username));

		$query4 = $this->db->get_where('telescoop_web.member_sys_access',array('member_id'=>$this->member_id));

		if($query3->num_rows() == 0 AND $query4->num_rows() == 0)
		{
			/*
			$config['protocol'] = 'smtp';
	        $config['smtp_host'] = '192.168.200.5';
	        $config['smtp_port'] = 25;

	        $config['smtp_user'] = 'sysadmin@telescoop.com.ph';
	        $config['smtp_pass'] = '1234';
	        $config['mailtype'] = 'html';
	 		$config['charset']  = 'utf-8';
	 		$this->load->library('email', $config);


			$msg = "MEMBER NAME: $mem_lname, $mem_fname, $mem_mname<br>MEMBER_ID: ".$this->input->post('member_id').'<br> EMAIL: '.$this->input->post('email');

		    $this->email->to('jethromalate@gmail.com,
		    				  nanet.cabrera@telescoop.com.ph,
		    				  anthony.manzano@telescoop.com.ph,
		    				  joel.olinares@telescoop.com.ph,
		    				  eirleen.cruz@telescoop.com.ph,
		    				  armi.geneta@telescoop.com.ph,
		    				  gie.armada@telescoop.com.ph,
		    				  gina.babista@telescoop.com.ph');

		    $this->email->from('sysadmin@telescoop.com.ph', 'Systems Admin');
		    $this->email->subject("ONLINE ACCESS REQUEST");
		    $this->email->message($msg);
		    $this->email->send();
			*/

	    	$this->db->insert('telescoop_web.member_sys_access', $this);

	    	return 1;
		}
		else
		{
			#USERNAME already taken
			return 2;
		}



    }


    function check_member_id()
    {
    	$this->member_id   = $this->input->post('member_id');

    	$query = $this->db->get_where('mem_members', array('member_id'=>$this->member_id));

        $status_id = $query->row('mem_status_id');
        $mem_status = $query->row('membership_status');

        if($query->num_rows() > 0)
        {

        	if($status_id == 2){
        		return 2; //APPROVED
        	}
        	elseif($status_id == 1)
        	{
        		return 1; //PENDING
        	}
        	elseif($status_id == 3)
        	{
        		return 3; //DISAPPROVED
        	}

        }
        else
        {
        	return 4; //MEMBER ID NOT FOUND
        }
    }

    function check_member_bday()
    {
    	$this->member_id   = $this->input->post('member_id');

    	$query = $this->db->get_where('mem_members', array('member_id'=>$this->member_id));

    	$bday_post = $this->input->post('bday');

    	$bday1 = explode('/',$bday_post);

    	$mo =  $bday1[0];
    	$yr = $bday1[2];
    	$day = $bday1[1];
    	$bday2 = "$yr-$mo-$day";

        $bday = $query->row('mem_bday');

        if($query->num_rows() > 0)
        {
        	if($bday2 == $bday)
        	{
        		return 1;
        	}
        	else
        	{
        		return 2;
        	}
        }
        else
        {
        	return 3;
        }

    }

    function check_if_already_has_access()
    {
    	$this->member_id   = $this->input->post('member_id');

    	$query = $this->db->get_where('telescoop_web.member_sys_access', array('member_id'=>$this->member_id));

        if($query->num_rows() == 0)
        {
        	return 1;
        }
        else
	        {
        	if($query->row('access_status') == 2)
        	{
        		return 3;
        	}else{
        		return 2;
        	}


        }
    }

    function check_member_emp_no()
    {
    	$this->member_id   = $this->input->post('member_id');
    	$emp_no  = strtolower($this->input->post('emp_no'));
    	$query = $this->db->get_where('mem_members', array('member_id'=>$this->member_id));

        if($query->num_rows() > 0)
        {
        	 $emp_id = strtolower($query->row('mem_emp_id'));
        	 $emp_id2 = strtolower($query->row('mem_emp_id2'));

        	if(empty($emp_id) AND $emp_id2){
        		return 1;
        	}
        	else
        	{
        		if($emp_no == $emp_id || $emp_no == $emp_id2)
	        	{

	        		return 1;
	        	}
	        	else
	        	{

	        		return 2;
	        	}
        	}

        }
        else
        {
        	return 3;
        }
    }

    function get_last_ten_entries()
    {
        $query = $this->db->get('entries', 10);
        return $query->result();
    }

    function insert_entry()
    {
        $this->title   = $_POST['title']; // please read the below note
        $this->content = $_POST['content'];
        $this->date    = time();

        $this->db->insert('entries', $this);
    }

    function update_entry()
    {
        $this->title   = $_POST['title'];
        $this->content = $_POST['content'];
        $this->date    = time();

        $this->db->update('entries', $this, array('id' => $_POST['id']));
    }

}
