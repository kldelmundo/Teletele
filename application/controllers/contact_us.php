<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contact_us extends CI_Controller {

	public function index()
	{
		$data['body'] = 'contact_us';
		
		$this->load->view('index',$data);
	}
	

}
