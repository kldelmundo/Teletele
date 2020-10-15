<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	function test_send()
    {
    // header('Access-Control-Allow-Origin: *');
		// header('Access-Control-Allow-Credentials: true');
		// header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');

		// echo $_SERVER['HTTP_ORIGIN'];

		$valid_key      = $this->input->post('valid_key');
		$ip_add         = $this->input->post('ip_address');

		if(empty($valid_key))
		{
				$valid_key =  $this->uri->segment(3);
		}


		$this->etbms_db = $this->load->database('etbms_db', TRUE);
		$this->web_db   = $this->load->database('web_db', TRUE);

    	$sql = "SELECT *
    			FROM ar_loans_online_header
				LEFT JOIN ar_loans_online_detail USING(online_id)
				LEFT JOIN mem_members USING(member_id)
				WHERE valid_key = '$valid_key'";

		$query = $this->etbms_db->query($sql);



		$row = $query->row();

		$sql_web = "SELECT *
    			    FROM member_sys_access
    			    WHERE member_id = $row->member_id";
    	$query_web = $this->web_db->query($sql_web);

		#	echo $this->web_db->last_query();

		$row_web = $query_web->row();

		$email_add_web = $row_web->email_add;


    $this->load->library('email');

		$subject = 'Thank you for your Loan, '.ucwords(strtolower($row->mem_fname)).'.';

		$terms = $row->pay_terms;
		$loan = number_format($row->gross_amount,2);
		$loan_id = setLength($row->online_id);
		$lname  = ucwords(strtolower($row->mem_lname));

		if($row->mem_gender == 'M'){
			$title = 'Mr. ';
		}else{
			$title = 'Ms. ';
		}

		if($row->prod_id == 'O-FS01' OR $row->prod_id == 'O-FS02')
		{
			$terms = round($terms);
			$message = <<<EOD

			Dear $title$lname,<br><br>

			Please confirm details of your requested PO thru Online for Financial Loan <strong>ID#$loan_id</strong> <br>
			amounting to <strong> Php $loan </strong> dated $row->po_date, payable in $terms months. <br><br>

			To validate, please enter the key <strong>$valid_key</strong><br>on the field provided.<br><br>

			<strong>IMPORTANT NOTE:</strong> This key is valid for 5 minutes ONLY.  <br>
			Validating beyond the prescribed period will automatically cancel this loan.<br><br>

			Should you still have some queries, <br>
			please call our Customer Services at 8462807 /8462307 /8900409 or 09209535323.<br><br>

			Thank you for having TELESCOOP as your <br>
			COOPERATIVE OF CHOICE and for the continuous Support and Patronage.
EOD;
		}
		else
		{


			$terms = round($terms);
			$message = <<<EOD

			Dear $title$lname,.<br><br>

			Please confirm details of your requested PO thru Online for Direct Selling Loan <strong>ID#$loan_id</strong> <br>
			for <strong>$row->i_desc</strong> dated $row->po_date amounting to <strong> Php $loan </strong>, payable in $terms months. <br><br>

			PLEASE ENTER VALIDATION KEY: <strong>$valid_key</strong><br><br>

			Confirmation can still be done up to <strong>5 minutes</strong> ONLY. <br>
			If we do not hear from you within the specified period of time, this loan will be AUTOMATIC cancelled.<br><br>

			Should you still have some queries, <br>
			please call our Sales and Marketing Group at 8997911  or 09209535322<br><br>

			Thank you for having   TELESCOOP as your <br>
			COOPERATIVE OF CHOICE and for the continuous Support and Patronage.

EOD;
		}



		// Get full html:
		$body = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>

		    <style type="text/css">
		        body {
		            font-family: Arial, Verdana, Helvetica, sans-serif;
					font-size: 16px;
					font-color: black;
		        }
		    </style>
		</head>
		<body>
		' . $message . '
		</body>
		</html>';
		// Also, for getting full html you may use the following internal method:
		//$body = $this->email->full_html($subject, $message);

		if($ip_add == '192.168.200.202')
		{
			$email_ad = 'guinmar.liamzon@telescoop.com.ph';
		}
		elseif($ip_add == '192.168.200.200')
		{
			$email_ad = 'gie.armada@telescoop.com.ph';
		}
		elseif($ip_add == '192.168.200.204')
		{
			$email_ad = 'anthony.manzano@telescoop.com.ph';
		}
		elseif($ip_add == '192.168.200.109')
		{
			$email_ad = 'guinmar.liamzon@telescoop.com.ph';
		}
		elseif($ip_add == '192.168.200.188')
		{
			$email_ad = 'jethromalate@gmail.com';
		}
		else
		{
			$email_ad = $email_add_web;
			#$email_ad = 'guinmar.liamzon@telescoop.com.ph';
		}

		$result = $this->email
		    ->from('sysadmin@telescoop.com.ph', 'TELESCOOP')
			->to($email_ad)
			->subject($subject)
		    ->message($body)
		    ->send();


		if($result)
		{
			echo json_encode(array('return'=>1,'member_id'=>$row->member_id));
		}
		else
		{
			echo json_encode(array('return'=>0));
		}



	}

	function send_text()
	{
		$valid_key      = $this->input->post('valid_key');
		$ip_add         = $this->input->post('ip_address');
		$member_id      = $this->input->post('member_id');

		$this->etbms_db = $this->load->database('etbms_db', TRUE);
		$this->web_db   = $this->load->database('web_db', TRUE);

		/***************************************************************************************************SMART MESSAGING SYSTEM******************************************************************************************************************************/
						// $this->load->model('m_account');
		        // $member_row = $this->m_account->get_member_info_by_member_id($member_id);

						$sql = "SELECT *
								FROM member_sys_access
								WHERE member_id = $member_id";
						$member_row = $this->web_db->query($sql)->row();


						echo $this->web_db->last_query();


		        if(strlen($member_row->mobile_no) >= 13 || strlen($member_row->mobile_no) <= 10 )
		        {
		        	$mobile_number = $member_row->mobile_no;
		            $today = date("Y-m-d H:i:s");
		            $status = "not send due to wrong number";

		            #$mobile_number = "09661825445";//guinmar phone
		            #$mobile_number = "09063747332";//mam gie phone

		            $this->db->insert('smart_messagingsuite',
		                        array('member_id'=> $member_row->member_id,
		                              'sender' => 'Smart Messagingsuite',
		                              'receiver'=> $mobile_number,
		                              'message' => 'Wrong mobile number.',
		                              'send_date_time' => $today,
		                              'status'=> $status));
		        }
		        else
		        {

			        #$mobile_number = $member_row->mem_telno;
			        #$mobile_number = '09063747332';

			        //%0A means new line in browser %20 means space in browser
			        $text = "Thank%20you%20for%20using%20our%20PO%20Online%20system%0APlease%20confirm%20details%20of%20your%20requested%20PO%20thru%20Online,%20to%20validate%20please%20enter%20the%20validation%20key%20".$valid_key."%20,Thanks";


			        #$mobile_number = $member_row->mobile_no;

			        $mobile_number = "09661825445";
			        $uname   = 'gie.armada@telescoop.com.ph';
			        $pword   = 'T3l3sc00p1';
			        $url = "https://messagingsuite.smart.com.ph/cgphttp/servlet/sendmsg?username=".$uname."&password=".$pword."&destination=".$mobile_number."&text=".$text."";
			        echo  '<br>'.$homepage = file_get_contents($url);//post and get response from smart messaging suite but not secure.
			        /*
			        //open connection
			        $ch = curl_init();

			        //set the url, number of POST vars, POST data
			        curl_setopt($ch,CURLOPT_URL,$url);
			        curl_setopt($ch,CURLOPT_POST,true);
			        curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
			        curl_setopt($ch, CURLOPT_VERBOSE, 1);
			        curl_setopt($ch, CURLOPT_HEADER, 1);

			        //execute post
			        $result = curl_exec($ch);

			        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
			        $header = substr($result, 0, $header_size).'<br><br><br>';
			        $status = substr($result, $header_size);

			        //close connection
			        curl_close($ch);
			        */

			        $ch = curl_init();

			        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
			        $header = substr($homepage, 0, $header_size).'<br><br><br>';//change $result to $homepage if cURL is not working or having error like ERROR 400 InvalidRequest
			        $status = substr($homepage, $header_size);//change $result to $homepage if cURL is not working or having error like ERROR 400 InvalidRequest

			        curl_close($ch);

			        $today = date("Y-m-d H:i:s");

			        $this->db->insert('smart_messagingsuite',
			                    array('member_id'=> $member_row->member_id,
			                          'sender' => 'Smart Messagingsuite',
			                          'receiver'=> $mobile_number,
			                          'message' => 'ONLINE LOAN VERIFICATION ('.$valid_key.')',
			                          'send_date_time' => $today,
			                          'status'=> $status));


			    }

/***************************************************************************************************END******************************************************************************************************************************/

	}

	function test_send_confirm($valid_key)
    {
    header('Access-Control-Allow-Origin: https://www.telescoop.com.ph');
		header('Access-Control-Allow-Credentials: true');
		header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
		header('Access-Control-Allow-Methods: POST, GET');

		$this->etbms_db = $this->load->database('etbms_db', TRUE);
		$this->web_db = $this->load->database('web_db', TRUE);

		if(!empty($valid_key))
		{
			$sql = "SELECT *
					FROM ar_loans_online_header
					LEFT JOIN ar_loans_online_detail USING(online_id)
					LEFT JOIN mem_members USING(member_id)
					WHERE valid_key = '$valid_key'";
			$query = $this->etbms_db->query($sql);

			$row = $query->row();

			$sql_web = "SELECT *
						FROM member_sys_access
						WHERE member_id = $row->member_id";
			$query_web = $this->web_db->query($sql_web);
			$row_web = $query_web->row();

			$email_add_web = $row_web->email_add;

			$loan_id = setLength($row->online_id);

			$this->load->library('email');

			$subject = 'Your loan ID#'.$loan_id.' has been confirmed';

			if($row->mem_gender == 'M'){
				$title = 'Mr. ';
			}else{
				$title = 'Ms. ';
			}

			if($row->prod_id == 'O-FS01' OR $row->prod_id == 'O-FS02')
			{
				$bcc = array('gina.babista@telescoop.com.ph','armi.geneta@telescoop.com.ph','kc.munoz@telescoop.com.ph','raymond.mendoza@telescoop.com.ph','sysadmin@telescoop.com.ph','eirleen.cruz@telescoop.com.ph');

				$amount = $row->actual_amount;
				$date = $row->po_date;
				$payable = round($row->pay_terms)." Months";

				$message = '
				Dear '.$title.ucwords(strtolower($row->mem_lname)).', '.ucwords(strtolower($row->mem_fname)).',<br><br><br>

				Your loan ID#'.$loan_id.' was confirmed and NOW ready for processing.<br><br>

				<p>Amount: '.number_format($amount,2).'</p>
				<p>Date: '.$date.'</p>
				<p>Payable: '.$payable.'</p>

				Correction/cancellation can still be done within <strong>30 minutes</strong> ONLY. <br><br>
				If we do not receive any action from you within the specified period of time, we will assume and <br>
				consider this transaction as FINAL, and TELESCOOP will now process your request.<br><br>

				Loan application received and confirmed up to 10:00am of same day shall be included in the day'."'s transaction,<br>
				otherwise it will be considered on the next day's transaction.<br><br>

				Should you still have some queries, <br>
				please call our Customer Services at 8462807 /8462307 /8900409 or 09209535323.<br><br>

				Thank you for having TELESCOOP as your <br>
				COOPERATIVE OF CHOICE and for the continuous Support and Patronage.";



			}
			else
			{
				$bcc = array('imee.armada@telescoop.com.ph','gigi.dichoso@telescoop.com.ph','nori.balane@telescoop.com.ph','kaira.alquigue@telescoop.com.ph','sysadmin@telescoop.com.ph');
				$item = $row->i_desc;
				$amount = $row->unit_cost;
				$sn = $row->serial_number;
				$date = $row->po_date;
				$payable = round($row->pay_terms)." Months";

				$message = '
				Dear '.$title.ucwords(strtolower($row->mem_lname)).',<br><br><br>

				Your loan ID#'.$loan_id.' was confirmed and NOW ready for processing.<br><br>

				<p><strong>Item Name:</strong> '.$item.'</p>
				<p><strong>Amount:</strong> '.number_format($amount,2).'</p>
				<p><strong>Serial Number:</strong> '.$sn.'</p>
				<p><strong>Date:</strong> '.$date.'</p>
				<p><strong>Payable:</strong> '.$payable.'</p>

				Correction/cancellation can still be done within <strong>30 minutes</strong> ONLY. <br><br>
				If we do not receive from you within the specified period of time, we will assume and <br>
				consider this transaction as FINAL, and TELESCOOP will now process your request.<br><br>

				Loan application received and confirmed up to 10:00am of same day shall be included in the day'."'s transaction,<br>
				otherwise it will be considered on the next day's transaction.<br><br>

				Should you still have some queries, <br>
				please call our Sales and Marketing Group at 8997911  or 09209535322<br><br>

				Thank you for having TELESCOOP as your <br>
				COOPERATIVE OF CHOICE and for the continuous Support and Patronage.";
			}

			// Get full html:
			$body = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml">
			<head>

				<style type="text/css">
					body {
						font-family: Arial, Verdana, Helvetica, sans-serif;
						font-size: 16px;
					}
				</style>
			</head>
			<body>
			' . $message . '
			</body>
			</html>';
			// Also, for getting full html you may use the following internal method:
			//$body = $this->email->full_html($subject, $message);


			// if($ip_add == '192.168.200.202')
			// {
			// 	$email_ad = 'guinmar.liamzon@telescoop.com.ph';
			// }
			// elseif($ip_add == '192.168.200.200')
			// {
			// 	$email_ad = 'gie.armada@telescoop.com.ph';
			// }
			// elseif($ip_add == '192.168.200.204')
			// {
			// 	$email_ad = 'anthony.manzano@telescoop.com.ph';
			// }
			// elseif($ip_add == '192.168.200.188')
			// {
			// 	$email_ad = 'jethromalate@gmail.com';
			// }
			// else
			// {
			// 	#$email_ad = $email_add_web;
			// 	$email_ad = 'guinmar.liamzon@telescoop.com.ph';
			// }
			$email_ad = $email_add_web;
			#$email_ad = 'guinmar.liamzon@telescoop.com.ph';

			$result = $this->email
				->from('sysadmin@telescoop.com.ph', 'TELESCOOP')
				->to($email_ad)
				->subject($subject)
				->bcc($bcc)
				->message($body)
				->send();

			if($result){

				$time = 30 * 60; //30 minutes
				$cancel_until = date('Y-m-d H:i:s', time() + $time);
				$data = array('cancel_until' => $cancel_until,'po_order_status'=>'confirmed','confirm_date'=>date('Y-m-d H:i:s'));
				$this->etbms_db->where('online_id',$row->online_id);
				$this->etbms_db->update("ar_loans_online_header",$data);

				echo json_encode(array('return_nya'=>'success'));
			}else{
				echo json_encode(array('return_nya'=>'not_success'));
			}

		}
    	else{
			echo json_encode(array('return_nya'=>'not_success'));
		}

	}

	function test_send_cancel($online_id)
    {
    	header('Access-Control-Allow-Origin: https://www.telescoop.com.ph');
		header('Access-Control-Allow-Credentials: true');
		header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');

    	$this->etbms_db = $this->load->database('etbms_db', TRUE);
			$this->web_db = $this->load->database('web_db', TRUE);
		#$online_id = $this->input->post('online_id');
		#$ip_add = $this->input->post('ip_add');

		#echo $online_id;

		if(!empty($online_id))
		{
			$sql = "SELECT *
					FROM ar_loans_online_header
					LEFT JOIN ar_loans_online_detail USING(online_id)
					LEFT JOIN mem_members USING(member_id)
					WHERE online_id = '$online_id'";
			$query = $this->etbms_db->query($sql);

			#echo $this->etbms_db->last_query();

			$row = $query->row();

			$sql_web = "SELECT *
						FROM member_sys_access
						WHERE member_id = $row->member_id";
			$query_web = $this->web_db->query($sql_web);
			$row_web = $query_web->row();

			$email_add_web = $row_web->email_add;

			if($row->mem_gender == 'M'){
				$title = 'Mr. ';
			}else{
				$title = 'Ms. ';
			}

			$cancel_date = date('c');

			$data = array('cancel_date' => $cancel_date,'po_order_status'=>'cancelled');

			$this->etbms_db->where('online_id',$row->online_id);
			$this->etbms_db->update("ar_loans_online_header",$data);

			$this->load->library('email');

			if($row->prod_id == 'O-FS01' OR $row->prod_id == 'O-FS02')
			{
				$bcc = array('gina.babista@telescoop.com.ph','armi.geneta@telescoop.com.ph','kc.munoz@telescoop.com.ph','raymond.mendoza@telescoop.com.ph','sysadmin@telescoop.com.ph','eirleen.cruz@telescoop.com.ph');
				$amount = $row->actual_amount;
				$date = $row->po_date;
				$payable = round($row->pay_terms)." Months";

				$call = "please call our Customer Services at 8462807 /8462307 /8900409 or 09209535323.<br><br>";

				$subject = 'Request for Cancellation';
				$message = '
							Dear '.$title.ucwords(strtolower($row->mem_lname)).',<br><br>
							<p>This is to confirm your CANCELLATION of your Online PO with the following details:</br></br>

							<p>Your Loan ID:'.setLength($row->online_id).'</p>
							<p>Amount: '.$amount.'</p>
							<p>Date: '.$date.'</p>
							<p>Payable Month: '.$payable.'</p>

							Should you still have some queries, <br>
							'.$call.'

							Thank you for having TELESCOOP as your <br>
							COOPERATIVE OF CHOICE and for the continuous Support and Patronage.
							';
			}
			else
			{
				$bcc = array('imee.armada@telescoop.com.ph','gigi.dichoso@telescoop.com.ph','nori.balane@telescoop.com.ph','kaira.alquigue@telescoop.com.ph','sysadmin@telescoop.com.ph');
				$item = $row->i_desc;
				$amount = $row->unit_cost;
				$date = $row->po_date;
				$payable = round($row->pay_terms)." Months";

				$call = "please call our Sales and Marketing Group at 8997911  or 09209535322<br><br>";

				$subject = 'Request for Cancellation';
				$message = '
						Dear '.$title.ucwords(strtolower($row->mem_lname)).', '.ucwords(strtolower($row->mem_fname)).',<br><br>
						<p>This is to confirm your CANCELLATION of your Online PO with the following details:</br></br>

						<p>Your Loan ID:'.setLength($row->online_id).'</p>
						<p>Item: '.$item.'</p>
						<p>Amount: '.number_format($amount,2).'</p>
						<p>Date: '.$date.'</p>
						<p>Payable Month: '.$payable.'</p>

						Should you still have some queries, <br>
						'.$call.'

						Thank you for having TELESCOOP as your <br>
						COOPERATIVE OF CHOICE and for the continuous Support and Patronage.
						';
			}

			// Get full html:
			$body = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml">
			<head>

				<style type="text/css">
					body {
						font-family: Arial, Verdana, Helvetica, sans-serif;
						font-size: 16px;
					}
				</style>
			</head>
			<body>
			' . $message . '
			</body>
			</html>';
			// Also, for getting full html you may use the following internal method:
			//$body = $this->email->full_html($subject, $message);

			// if($ip_add == '192.168.200.202')
			// {
			// 	$email_ad = 'guinmar.liamzon@telescoop.com.ph';
			// }
			// elseif($ip_add == '192.168.200.200')
			// {
			// 	$email_ad = 'gie.armada@telescoop.com.ph';
			// }
			// elseif($ip_add == '192.168.200.204')
			// {
			// 	$email_ad = 'anthony.manzano@telescoop.com.ph';
			// }
			// elseif($ip_add == '192.168.200.188')
			// {
			// 	$email_ad = 'jethromalate@gmail.com';
			// }
			// else
			// {
			// 	#$email_ad = $email_add_web;
			// 	$email_ad = 'guinmar.liamzon@telescoop.com.ph';
			// }
			$email_ad = $email_add_web;
		#	$email_ad = 'guinmar.liamzon@telescoop.com.ph';

			$result = $this->email
				->from('sysadmin@telescoop.com.ph', 'TELESCOOP')
				->to($email_ad)
				->subject($subject)
				->bcc($bcc)
				->message($body)
				->send();

			/*var_dump($result);
			echo '<br />';
			echo $this->email->print_debugger();


			*/
			echo json_encode(array('return_nya'=>'success', 'member_id' => $row->member_id));
		}
		else
		{
			echo json_encode(array('return_nya'=>'not_success'));
		}




    }


	public function index()
	{

		/*$sql = "SELECT ID,member_id,CONCAT(SURNAME,', ',FIRSTNAME,' ',MI) as name, mark as location,date,email_ads,status,datetime
			FROM Ra2016delegates limit 1";



				$query = $this->db->query($sql);*/

		$sql = "SELECT mem_lname,mem_fname,member_id,username,`password`,company_name,email_add,acct_remarks,date_register
				FROM telescoop_web.member_sys_access
				LEFT JOIN mem_members USING(member_id)
				LEFT JOIN stg_company USING(company_id)
				WHERE access_status = 2
				AND approved_by IS NULL";

		$query = $this->db->query($sql);

				$data['query'] = $query;

			$this->load->view('welcome_message', $data);

	}




	function Send()
	{
		if($this->input->post('submit') == TRUE)
		{
			date_default_timezone_set('Asia/Manila');
			$datetime = date('Y-m-d');

			foreach($this->input->post('email') as $key => $id)
			{

				$member_id = $this->input->post("member_".$id);
				$email_ads = $this->input->post("email_".$id);
				$ip = $this->input->post("ip_".$id);

				if($ip == "192.168.200.202")
				{
					$approved_by = "024023";
				}
				else if($ip == "192.168.200.204")
				{
					$approved_by = "016283";
				}
				else if($ip == "192.168.200.200")
				{
					$approved_by = "000009";
				}
				else
				{
					$approved_by = "023299";
				}



				if(!empty($email_ads))
				{

					if(valid_email($email_ads))
					{
						$this->load->model('m_account');
						$member_row = $this->m_account->get_member_info_by_member_id($member_id);

					    $path=$_SERVER["DOCUMENT_ROOT"];



						$this->load->library('email');
						$this->email->clear(TRUE);
					    $this->email->from('sysadmin@telescoop.com.ph', 'TELESCOOP'); // change it to yours
					    #$this->email->to(trim($member_email));// change it to yours
					    #$this->email->to('guinmar.liamzon@telescoop.com.ph');// change it to yours
					    $this->email->to($email_ads);// change it to yours
					    $this->email->bcc('sysadmin@telescoop.com.ph');
					    $this->email->subject('TELESCOOP Web Account');


						$today = date("F j, Y");
						$msg = '
							    <html>
								<head>
								<title>Your title</title>
								</head>
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

					        		<br>&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;You can now access your account <a href="http://www.telescoop.com.ph">here</a>.

					        		<br><br>
					        		&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;<strong>Username</strong>: '.$member_row->username.'<br>&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;<strong>Password</strong>: '.$member_row->password.'<br><br><br>
									</td>
								</tr>
							  	</table>
								</center>
								</body>
								</html>';
								#$msg = "hello world";


					    $this->email->message($msg);
						#$mail->Body = $msg;



							if($this->email->send())
							{

							$sql = "UPDATE telescoop_web.member_sys_access
									SET access_status = 1,
										date_approved = NOW(),
										approved_by = '$approved_by'
									WHERE member_id = $member_id";

							$this->db->query($sql);

							echo '<script>
								alert("Sending Email Successfully")
								window.location = "'.site_url("welcome/index").'"
								</script>';


							}
							else
							{
							 show_error($this->email->print_debugger());
							}




					}
					else
					{
						echo '<script>
							alert("Invalid Email.")
							window.location = "'.site_url("welcome/index").'"
							</script>';
					}


				}
				else
				{
					echo '<h3><center><br><br><br><br><br><br><br><br><br>No Email Address Found</center></h3>';
				}


			}

		}

	}

	function Sended()
	{
echo 1;
	}

	function for_evaluation()
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

		*/

		$this->load->library('mailguinmar');

		$data['member_id'] = $this->session->userdata('member_id');

		$this->load->view('account/for_evaluation',$data);
	}

	//guinmar doing for validation as per bmportugal
	function send_congrats($member_id)
	{
		$this->load->model('m_account');
		$member_info = $this->m_account->get_member_info_by_member_id($member_id);
		if(!empty($member_info->mem_email))
		{
			if(valid_email($member_info->mem_email))
			{
					$this->load->library('email');
					$this->email->clear(TRUE);
			    $this->email->from('sysadmin@telescoop.com.ph', 'TELESCOOP'); // change it to yours
			    $this->email->to(trim($member_info->mem_email));// change it to yours
			    #$this->email->to('gie.armada@telescoop.com.ph');// change it to yours
			    #$this->email->to($member_info->mem_email);// change it to yours
			    #$this->email->bcc('sysadmin@telescoop.com.ph');
			    $this->email->subject('TELESCOOP Online Account Creation');

			    $filename = "announcement_online_completed.jpg";

			    $path=$_SERVER["DOCUMENT_ROOT"];

			    $data["body"] = '<center><img src="cid:'.$filename.'" /></center>';

			    $this->email->attach($path.'/For_Evaluation/assets/images/'.$filename);

			    $msg = $this->load->view('mail_view.php',$data,true);


			    $this->email->message($msg);

			    if($this->email->send())
				{
					// echo "<script>window.location.replace('http://119.93.95.162/POL/index.php/account')</script>";
					$newdata = array('is_login'  => TRUE);

					$this->session->set_userdata($newdata);


					$send = $member_id;
					echo "<script>
							alert('Validation Accepted');
							window.location.replace('https://telescoop.com.ph/account/notify/');
						</script>";
				}
				else
				{
					show_error($this->email->print_debugger());
				}

			}
		}
	}

	function failed_attempt($member_id)
	{
		$this->load->model('m_account');
		$member_info = $this->m_account->get_member_info_by_member_id($member_id);
		if(!empty($member_info->mem_email))
		{
			if(valid_email($member_info->mem_email))
			{
					$this->load->library('email');
					$this->email->clear(TRUE);
			    $this->email->from('sysadmin@telescoop.com.ph', 'TELESCOOP'); // change it to yours
			    $this->email->to(trim($member_info->mem_email));// change it to yours
			    #$this->email->to('gie.armada@telescoop.com.ph');// change it to yours
			    #$this->email->to($member_info->mem_email);// change it to yours
			    #$this->email->bcc('sysadmin@telescoop.com.ph');
			    $this->email->subject('TELESCOOP Online Account Creation');

			    $msg ="Dear Ma'am/Sir,<br><br>

						We have noticed that you have failed to input the correct information needed on completing your Online Account. You may call at 8890-0431 for any assistance.<br><br>

						If you DID NOT perform TELESCOOP Online Account completion, please immediately report to TELESCOOP MIS at 8890-0431.<br><br>

						Thank you.<br><br>

						TELESCOOP MIS Admin Team";

						$this->email->message($msg);

					if($this->email->send())
					{
						// echo "<script>window.location.replace('http://119.93.95.162/POL/index.php/account')</script>";
						#$send = $member_id;
						echo "<script>
								alert('Your account is Locked! Call our MIS @ 8-890-04-31 to unlock account!');
								window.location.replace('https://www.telescoop.com.ph/account/login');
							</script>";
					}
					else
					{
						show_error($this->email->print_debugger());
					}
				}
			}
	}
	//end validation bmp

}
