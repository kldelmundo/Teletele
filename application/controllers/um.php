<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Um extends CI_Controller {

	function __construct()
	{
	    parent::__construct();      

	     $total = count($this->uri->segment_array());
	          if($total > 0){
	          redirect('um');
	     }
         
	}

	public function index()
	{

		// set the endDate of the maintinance at assets/js/um/global.js
		// rename the account controller to accountx
		// set the route to um

		
		$this->load->view('um.php');


	}
}

	