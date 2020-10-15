<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

require 'mailgun/autoload.php';
use Mailgun\Mailgun;

class Mailguinmar
{
	

	function send($config, $inline=array())
	{
		//Your credentials
		$mg = new Mailgun("key-d783d2f6f96cfe079e4112599d7b447e");
		$domain = "telescoop.com.ph";
		
		if(!empty($inline)){
			//Customise the email - self explanatory
			$ret = $mg->sendMessage($domain, $config, $inline);
		}else{
			//Customise the email - self explanatory
			$ret = $mg->sendMessage($domain, $config);
		}
		
		
		
		#return $ret->http_response_body;
	}
	
}


?>

