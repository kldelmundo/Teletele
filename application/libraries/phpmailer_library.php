<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 


class PHPMailer_Library
{
    public function __construct()
    {
        log_message('Debug', 'PHPMailer class is loaded.');
    }

    public function load()
    {
        require (APPPATH."third_party/phpmailer/src/PHPMailer.php");
        require (APPPATH."third_party/phpmailer/src/Exception.php");
        require (APPPATH."third_party/phpmailer/src/SMTP.php");
        $objMail = new PHPMailer;
        return $objMail;
    }
}


?>

