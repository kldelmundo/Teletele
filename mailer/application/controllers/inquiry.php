<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inquiry extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
	}

	/**
	 * Show the control panel
	 */
	public function forward()
	{
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
        $this->email->to('jethromalate@gmail.com');
        $this->email->subject('Payment notification from spex');	
        
        
        
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
        
		
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */