<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Membership extends CI_Controller {

	public function requirements()
	{
		$data['body'] = 'member/requirements';
		
		$this->load->view('index',$data);
	}

}
