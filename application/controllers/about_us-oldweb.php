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
	public function ethics()
	{
		$data['body'] = 'about_us/ethics';
		
		$this->load->view('index',$data);
	}
	public function mediation()
	{
		$data['body'] = 'about_us/mediation';
		
		$this->load->view('index',$data);
	}
	public function gad()
	{
		$data['body'] = 'about_us/gad';
		
		$this->load->view('index',$data);
	}
	
	public function vm()
	{
		if($this->session->userdata('is_login')){
			$data['row'] = $this->m_account->get_member_info();
		}
		$data['has_side_menu'] = TRUE;
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
			
			$data['has_side_menu'] = TRUE;
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
	function online_cat2_generator()
	{
		#$data['body'] = 'about_us/ol_generator';

		 $lastbilling = get_last_billing();
		 $lastbilling_next = switch_next_date($lastbilling);
		 $data['lastbilling'] = $lastbilling;
		 $data['lastbilling_next'] = $lastbilling_next;
		
		$this->load->view('about_us/ol_generator', $data);
	}
	
	

}

