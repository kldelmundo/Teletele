<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Raffle extends CI_Controller {

	public function index()
	{
		echo "<form method='post' action='/raffle'><h1 style='color:red'>RAFFLE WINNER 2018 <button name='submit'>START RAFFLE</button></h2></form>";
		
		if(isset($_POST['submit']))
		{
			$query = $this->db->query("SELECT * FROM teles_bin.survey_raffle_2018 ORDER BY RAND() LIMIT 1 ");
			$ctr = 1;
			foreach($query->result() as $row)
			{
				// sleep for 10 seconds
				echo '<h2>'.$ctr++.'. '.$row->mem_lname.', '.$row->mem_mname.', '.$row->mem_fname.' </h2>';
			}
			
			
		}
		
	}
	
	

}

