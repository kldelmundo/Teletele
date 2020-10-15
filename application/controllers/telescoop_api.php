<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 require(APPPATH'.libraries/REST_Controller.php');

class Telescoop_API extends REST_Controller {

	public function __construct()
	{
    	parent::__construct();
    	$this->etbms_db = $this->load->database('etbms_db', TRUE);
    }

    function home()
	{
        
   //         $sql = "SELECT * FROM $db_table WHERE status = 0";
			// $query = $this->db->query($sql);

			$sql = "SELECT *,CONCAT(mem_lname,', ',mem_fname,' ',LEFT(mem_mname,1),'.') as name 
				FROM mem_members
				LEFT JOIN mem_emplevel USING(emp_level_id)
				LEFT JOIN mem_account USING(member_id)
				LEFT JOIN mem_temp_bank USING(bank_id)
				LEFT JOIN stg_company USING(company_id)
				WHERE member_id = 24023";
					
            $data = $this->etbms_db->query($sql)->row_array();
            
        $this->response($data, REST_Controller::HTTP_OK);
	}
    function index()
    {
        echo 1;
    }



}
