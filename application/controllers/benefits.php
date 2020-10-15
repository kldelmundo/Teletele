<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Benefits extends CI_Controller {

	public function index()
	{
		$data['body'] = 'benefits/benefits';
		
		$this->load->view('index',$data);
	}
	
	

}
