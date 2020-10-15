<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class About_us extends CI_Controller {

	public function board()
	{
		$data['body'] = 'about_us/board';

		$this->load->view('index',$data);
	}

	public function sms()
	{

		$URL = "https://ws.smartmessaging.com.ph/soap/?wsdl";
		$client = new soapclient($URL);
		#$token = "18fcaf7e64da1a3f03e105d986b5ed52";
		/*
		$method = 'GETCONNECT';
		$parameters = array(
		                array(
		                    'token' => $token
		                )
		            );
		#$return = $client->__call($method, $parameters));


		$method = 'SENDSMS';
		$parameters = array(
		                array(
		                    'token' => $token,
		                    'msisdn' => '09297869228',
		                    'message' => 'Sample message here.'
		                )
		            );
		$return = $client->__call($method, $parameters));

		*/
		#print_r($parameters);


		print_r($client);

	}

	public function aic()
	{
		$data['body'] = 'about_us/aic';

		$this->load->view('index',$data);
	}

	public function comelec()
	{
		$data['body'] = 'about_us/comelec';

		$this->load->view('index',$data);
	}

	public function vm()
	{
		if($this->session->userdata('is_login')){
			$data['row'] = $this->m_account->get_member_info();
		}
		#$data['has_side_menu'] = TRUE;
		$data['body'] = 'about_us/vm';

		$this->load->view('index',$data);
	}

	public function edcom()
	{
		$data['body'] = 'about_us/edcom';

		$this->load->view('index',$data);
	}

	function history()
	{
		/*
		$config['protocol'] = 'smtp';
	    $config['smtp_host'] = '192.168.200.254';
	    $config['smtp_port'] = 25;
	    $config['smtp_user'] = 'sysadmin@telescoop.com.ph';
	    $config['smtp_pass'] = '1234';
	    $config['mailtype'] = 'html';
		$config['charset']  = 'utf-8';
		*/


		$config['protocol'] = 'smtp';
		$config['smtp_host'] = 'ssl://smtp.gmail.com';
		$config['smtp_port'] = 465;
		$config['smtp_user'] = 'jethromalate@gmail.com';
		$config['smtp_pass'] = 'adminkb?.';
		$config['mailtype'] = 'html';
			$config['charset']  = 'utf-8';
		$this->load->library('email', $config);

		$this->email->set_newline("\r\n");

		$this->email->from('jethromalate@gmail.com', 'Jethro Malate');
		$this->email->to('jethromalate@yahoo.com');
		$this->email->subject('Payment notification from telesweb');

		/*

		$msg = '
		    aw';

		$this->email->message($msg);



		if($this->email->send())
		{

		    echo 'Your email was sent, successfully.';
		}

		else
		{
		    show_error($this->email->print_debugger());
		}
			*/
			if($this->session->userdata('is_login')){
				$data['row'] = $this->m_account->get_member_info();
			}

			#$data['has_side_menu'] = TRUE;
			$data['body'] = 'about_us/history';

			$this->load->view('index',$data);
	}

	function email()
	{
		$config['protocol'] = 'smtp';
		$config['smtp_host'] = 'smtp.office365.com';
		$config['smtp_port'] = 587;
		#$config['smtp_crypto'] = 'tls';
		$config['smtp_user'] = 'sysadmin@telescoop.com.ph';
		$config['smtp_pass'] = 'Telescoop061876';
		$config['mailtype'] = 'html';
		$config['charset']  = 'utf-8';

			$this->load->library('email', $config);
			$this->load->library('mailguinmar');

			if($this->session->userdata('is_login')){
				$data['row'] = $this->m_account->get_member_info();
			}
		#UPDATE
			$data['has_side_menu'] = TRUE;
		//-------------------about_us/(email_pricelist2014)->is a php file,where you can edit the files to be send and emails adds.
			#$data['body'] = 'about_us/email_pricelist2014';
			#$data['body'] = 'about_us/email_pricelist2015';
			#$data['body'] = 'about_us/email_valentine2015';
			#$data['body'] = 'about_us/email_shellcard_form';
			#$data['body'] = 'about_us/email_webinvi';
			#$data['body'] = 'about_us/scs_undertaking';
			#$data['body'] = 'about_us/email_gadget2013';
			#$data['body'] = 'about_us/email_gadget2015';
			#$data['body'] = 'about_us/email_advisory2014';
			#$data['body'] = 'about_us/email_advisory2015';//done sending to masterlist 1/24/15
			#$data['body'] = 'about_us/email_advisory2016';//cp number advisory
			#$data['body'] = 'about_us/email_advisory2017_GC';//TOYOTA PMS -> TCL loan
			#$data['body'] = 'about_us/email_mobile_advisory';//app raffle ads
			#$data['body'] = 'about_us/RA2015';
			#$data['body'] = 'about_us/email_graduation2015';
			#$data['body'] = 'about_us/email_graduation2017';
			#$data['body'] = 'about_us/survey';//done sending to masterlist 1/21/15
			#$data['body'] = 'about_us/scs_undertaking';
			#$data['body'] = 'about_us/email_bundled';
			#$data['body'] = 'about_us/email_web';
			#$data['body'] = 'about_us/email_tfl2013';
			#$data['body'] = 'about_us/email_travel';
			#$data['body'] = 'about_us/email_salescaravan';
			#$data['body'] = 'about_us/email_eRaffleCertificate';
			#$data['body'] = 'about_us/throwback.php';
			#$data['body'] = 'about_us/email_fmb';
			#$data['body'] = 'about_us/email_eRaffle';
			#$data['body'] = 'about_us/email_ituro2013';
			#$data['body'] = 'about_us/email_ituro2015';
			$data['body'] = 'about_us/email_GVCL';

		//-----------------------------------------------------------
			$this->load->view('index',$data);
	}
	function staff()
	{

		$data['body'] = 'about_us/staff';

		$this->load->view('index',$data);
	}

	function smsblaster()
	{
		$member_id = $this->session->userdata('member_id');

		if(!$this->session->userdata('is_login'))
		{
			#$data['body'] = 'about_us/error_404';
			$this->load->view('about_us/error_404.php');
		}
		else
		{
			if($member_id == "024023" || $member_id == "000009")
			{
				$data['body'] = 'about_us/smsblast';
				$this->load->view('index',$data);

			}
			else
			{
				#$data['body'] = 'about_us/error_404';
				$this->load->view('about_us/error_404.php');
			}
		}
	}

	function send_smsblaster()
	{
		if($_POST)
		{
			$txt_message = $this->input->post('txt_message');
			//rawurlencode($txt_message) use to convert space to acceptable url spaces which is %20 or +

			$db_table = "sms_db.sales_march";

			$member_id = $this->session->userdata('member_id');
			$sql = "SELECT * FROM $db_table WHERE status = 0";
			$query = $this->db->query($sql);

			foreach($query->result() as $row)
			{
				$mobile_no = $row->mobile_no;
				$stats = $row->status;


						#echo $mobile_no.'<br>'.rawurlencode($txt_message);
						$text = rawurlencode($txt_message);

						$uname   = 'gie.armada@telescoop.com.ph';
						$pword   = 'T3l3sc00p1';

						if(strlen($mobile_no) < 11)
						{
							$mobile_no = "098765432101";
						}
						$url = "https://messagingsuite.smart.com.ph/cgphttp/servlet/sendmsg?username=".$uname."&password=".$pword."&destination=".$mobile_no."&text=".$text."";
						echo  '<br>'.$homepage = file_get_contents($url);//post and get response from smart messaging suite but not secure.

						$ch = curl_init();

						$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
						$header = substr($homepage, 0, $header_size).'<br><br><br>';//change $result to $homepage if cURL is not working or having error like ERROR 400 InvalidRequest
						$status = substr($homepage, $header_size);//change $result to $homepage if cURL is not working or having error like ERROR 400 InvalidRequest

						curl_close($ch);



										$today = date("Y-m-d H:i:s");
										$mobile_no = $row->mobile_no;

										$data = array(
										        'text_message' => $txt_message,
														'status_sms' => $status,
										        'datetime' => $today,
														'sended_by' => $member_id,
														'status' => '1'
										);

										$this->db->where('mobile_no', $mobile_no);
										$this->db->update($db_table, $data);


								#return $result;
								echo '<script>
								alert("Successfull in Sending Text")
								window.location = "'.site_url("account/index").'"
								</script>';

			}
		}
	}



}
