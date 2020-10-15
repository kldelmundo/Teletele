<?php

use setasign\Fpdi\Fpdi;

defined('BASEPATH') or exit('No direct script access allowed');

class PForms extends CI_Controller
{

      public function __construct()
      {
            parent::__construct();
            include APPPATH . 'third_party/fpdf/fpdf.php';
            include APPPATH . 'third_party/fpdi/src/autoload.php';
      }

      function home($member_id)
      {     
            $data['member_id'] = $member_id;
            $this->load->view('telesforms/onlineforms.php',$data);
      }

      // public function view($page = 'onlineforms')
      // {
      //       if (!file_exists(APPPATH . 'views/telesforms/' . $page . '.php')) {
      //             show_404();
      //       }

      //       $this->load->view('telesforms/' . $page . '');
      // }

      public function generatepdf($member_id)
      {
            //Guinmar add database for mem detials
            $this->etbms_db = $this->load->database('etbms_db', TRUE);
            $sql = "SELECT *,CONCAT(mem_lname,', ',mem_fname,' ',LEFT(mem_mname,1),'.') as name 
				FROM mem_members
				LEFT JOIN mem_emplevel USING(emp_level_id)
				LEFT JOIN mem_account USING(member_id)
				LEFT JOIN mem_temp_bank USING(bank_id)
				LEFT JOIN stg_company USING(company_id)
				WHERE member_id = $member_id";
					
            $query = $this->etbms_db->query($sql);
            //end guinmar
            
            // echo '1';
            // Check form submit or not
            if($this->input->post('submit') != NULL) {

                  $postData = $this->input->post();

                  $filename = $postData['selectedfile'];

                  //TODO: Replace $member_name, $member_name with real variable
                  
                  //guinmar added for detials
                  $member_name = $query->row('name');
                  $member_id = $query->row('member_id');
                  $emp_id = $query->row('mem_emp_id2');
                  if(empty($emp_id))
                  {
                        $emp_id = $query->row('mem_emp_id');
                  }

                  $sql1 = "SELECT * FROM form_ctrl
                        ORDER BY id DESC
                        LIMIT 1";
                  $query1 = $this->etbms_db->query($sql1)->row();
                  $form_no = $query1->id+1;

                  $dr_no = "DR-".$member_id.$form_no;
                  //end guinmar

                  
                 #$dr_no = "DR-".$member_id.date("His"); 

                  $pdf = new Fpdi();

                  $srcPath = FCPATH  . "assets/forms/$filename";
                  $pdf->setSourceFile("$srcPath.pdf");

                  //Import the first page of the file
                  $tpl  = $pdf->importPage(1);
                  $size = $pdf->getTemplateSize($tpl);
                  $pdf->AddPage('', [$size['width'], $size['height']]);

                  //We need to ensure the size of the pdf stays the same when pdf is generated
                  $pdf->useTemplate($tpl, 0, 0, $size['width'], $size['height'], FALSE);

                  $json = file_get_contents(FCPATH . "assets/forms/forms.config.json");
                  $obj_attr  = json_decode($json, true);

                  $obj  = (object) json_decode($json, true)[$filename];
                  
                  // Erase the DRNUMBER near the top right to give way to generated one                  
                  $pdf->SetXY($obj->DRX, $obj->DRY);

                  // Fill color similar to background
                  $pdf->SetFillColor($obj->R, $obj->G, $obj->B);

                  // Fill color the color
                  $pdf->Cell(160, 10, '', 3, 0, 'C', true);

                  $pdf = $this->insertData($pdf, $obj->DRX, $obj->DRY + 5, "$dr_no", 12, [255, 0, 0]); //DR NUMBER
                  $pdf = $this->insertData($pdf, $obj->NAMEX, $obj->NAMEY, "$member_name");            //MAKER NAME
                  $pdf = $this->insertData($pdf, $obj->EMPNOX, $obj->NAMEY, "$emp_id");             //EMPLOYEE NUMBER


                  //added by guinmar for database tagging
                  $data = array('member_id' => $member_id,
                                'form_no' => $dr_no);

                  $this->etbms_db->insert('form_ctrl',$data);
                  //end fixed of guinmar

                  //Download the File 
                  $pdf->Output('D', "$filename" . "_$dr_no.pdf");
                  //Go back to member downloads
                  $this->load->view('telesforms/onlineforms.php');
            }
      }

      // private function getPDFToDownload($pdf, $type)
      // {

      //       $json = file_get_contents(FCPATH . "assets/forms/form_list_attr.json");
      //       $obj_attr  = json_decode($json, true);

      //       $obj  = (object) json_decode($json, true)[$type];

      //       // Erase the DRNUMBER near the top right to give way to generated one
      //       $pdf->SetXY(
      //             $obj->{'DR-X'},
      //             $obj->{'DR-Y'}
      //       );

      //       // Fill color similar to background
      //       $pdf->SetFillColor(
      //             $obj->R,
      //             $obj->G,
      //             $obj->B
      //       );

      //       // Fill color the color
      //       $pdf->Cell(0, 10, '', 3, 0, 'C', true);

      //       $pdf = $this->insertData($pdf, $obj->DRX, $obj->DRY, "$dr_no", 14, [255, 0, 0]);      //DR NUMBER
      //       $pdf = $this->insertData($pdf, $obj->NAMEX, $obj->NAMEY, "$member_name");            //MAKER NAME
      //       $pdf = $this->insertData($pdf, $obj->NAMEX + 50, $obj->NAMEY, "$member_id");              //EMPLOYEE NUMBER

      // }


      public function insertData(&$pdf, $xaxis, $yaxis, $text, $fontsize = 8, $fontcolor = [0, 0, 0])
      {
            $pdf->SetXY($xaxis, $yaxis);
            $pdf->SetFont('Arial', '', $fontsize);
            $pdf->SetTextColor($fontcolor[0], $fontcolor[1], $fontcolor[2]);
            $pdf->Write(0, $text);
            return $pdf;
      }
}
