<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Loans extends CI_Controller {

	public function financial()
	{
		$data['body'] = 'financial';
		
		$this->load->view('index',$data);
	}
	
	public function appliance()
	{
		$data['body'] = 'appliance';
		
		$this->load->view('index',$data);
	}
	
	public function others()
	{
		$data['body'] = 'others';
		
		$this->load->view('index',$data);
	}
	
	function download_fsdlsr()
	{
		$content = '<div id="fsdl_sr">
		<table width="100%" class="center" border=1>
			<tbody><tr class="Thead"><td colspan="8"><center>FSDL SR (Payable thru issuance of Post Dated Checks)</center></td></tr>
			<tr style="text-align: center;" class="Thead">
				<td colspan="8">PHP 500,000.00</td>
				
			</tr>
			<tr class="Thead" style="text-align:center;font-weight:bold;">
				<td>&nbsp;</td>
				<td>12 MOS</td>
				<td>18 MOS</td>
				<td>24 MOS</td>
				<td>30 MOS</td>
				<td>36 MOS</td>
				<td>48 MOS</td>
				<td>60 MOS</td>
			</tr>
			
			<tr style="text-align:right;font-weight:bold;">
				<td style="text-align:left">NET PROCEEDS</td>
				<td> 500,000.00 </td>
				<td> 500,000.00 </td>
				<td> 500,000.00 </td>
				<td> 500,000.00 </td>
				<td> 500,000.00 </td>
				<td> 500,000.00 </td>
				<td> 500,000.00 </td>
			</tr>
			
			
			<tr style="text-align:right">
				<td style="text-align:left">GROSS</td>
				<td> 530,289.96 </td>
				<td> 544,666.86 </td>
				<td> 559,294.08 </td>
				<td> 574,170.90 </td>
				<td> 589,296.96 </td>
				<td> 620,292.48 </td>
				<td> 652,272.60 </td>
			</tr>
			
			<tr style="text-align:right">
				<td style="text-align:left">SERVICE CHARGE</td>
				<td> 10,000.00 </td>
				<td> 10,000.00 </td>
				<td> 10,000.00 </td>
				<td> 10,000.00 </td>
				<td> 10,000.00 </td>
				<td> 10,000.00 </td>
				<td> 10,000.00 </td>
				
			</tr>
			
			<tr style="text-align:right;">
				<td style="text-align:left">1ST YR MO AMORT</td>
				<td> 45,024.16 </td>
				<td> 31,092.60 </td>
				<td> 24,137.25 </td>
				<td> 19,972.36 </td>
				<td> 17,202.69 </td>
				<td> 13,756.09 </td>
				<td> 11,704.54 </td>
			</tr>
			
			<tr style="text-align:right">
				<td style="text-align:left">SUCCEDDING YEARS</td>
				<td>  44,190.83 </td>
				<td>  30,259.27 </td>
				<td>  23,303.92 </td>
				<td>  19,139.03 </td>
				<td>  16,369.36 </td>
				<td>  12,922.76 </td>
				<td>  10,871.21 </td>
			</tr>
			
			
			
		</tbody></table>
		<br>	
		<table width="100%" class="center" border=1>
			<tbody><tr style="text-align: center;" class="Thead">
				<td colspan="8">PHP 400,000.00</td>
				
			</tr>
			<tr class="Thead" style="text-align:center;font-weight:bold;">
				<td>&nbsp;</td>
				<td>12 MOS</td>
				<td>18 MOS</td>
				<td>24 MOS</td>
				<td>30 MOS</td>
				<td>36 MOS</td>
				<td>48 MOS</td>
				<td>60 MOS</td>
			</tr>
			
			<tr style="text-align:right;font-weight:bold;">
				<td style="text-align:left">NET PROCEEDS</td>
				<td> 400,000.00 </td>
				<td> 400,000.00 </td>
				<td> 400,000.00 </td>
				<td> 400,000.00 </td>
				<td> 400,000.00 </td>
				<td> 400,000.00 </td>
				<td> 400,000.00 </td>
			</tr>
			
			
			<tr style="text-align:right">
				<td style="text-align:left">GROSS</td>
				<td>  424,231.92  </td>
				<td>  435,733.56  </td>
				<td>  447,435.36  </td>
				<td>  459,336.90  </td>
				<td>  471,437.64  </td>
				<td>  496,234.08  </td>
				<td>  521,818.20  </td>
			</tr>
			
			<tr style="text-align:right">
				<td style="text-align:left">SERVICE CHARGE</td>
				<td> 8,000.00 </td>
				<td> 8,000.00 </td>
				<td> 8,000.00 </td>
				<td> 8,000.00 </td>
				<td> 8,000.00 </td>
				<td> 8,000.00 </td>
				<td> 8,000.00 </td>
				
			</tr>
			
			<tr style="text-align:right;">
				<td style="text-align:left">1ST YR MO AMORT</td>
				<td>  36,019.33  </td>
				<td>  24,874.09  </td>
				<td>  19,309.81  </td>
				<td>  15,977.90  </td>
				<td>  13,762.16  </td>
				<td>  11,004.88  </td>
				<td>  9,363.64  </td>
			</tr>
			
			<tr style="text-align:right">
				<td style="text-align:left">SUCCEDDING YEARS</td>
				<td>   35,352.66  </td>
				<td>   24,207.42  </td>
				<td>   18,643.14  </td>
				<td>   15,311.23  </td>
				<td>   13,095.49  </td>
				<td>   10,338.21  </td>
				<td>   8,696.97  </td>
			</tr>
			
			
			
		</tbody></table>
		<br>
		
		<table width="100%" class="center" border=1>
			<tbody><tr style="text-align: center;" class="Thead">
				<td colspan="8">PHP 300,000.00</td>
				
			</tr>
			<tr class="Thead" style="text-align:center;font-weight:bold;">
				<td>&nbsp;</td>
				<td>12 MOS</td>
				<td>18 MOS</td>
				<td>24 MOS</td>
				<td>30 MOS</td>
				<td>36 MOS</td>
				<td>48 MOS</td>
				<td>60 MOS</td>
			</tr>
			
			<tr style="text-align:right;font-weight:bold;">
				<td style="text-align:left">NET PROCEEDS</td>
				<td> 300,000.00 </td>
				<td> 300,000.00 </td>
				<td> 300,000.00 </td>
				<td> 300,000.00 </td>
				<td> 300,000.00 </td>
				<td> 300,000.00 </td>
				<td> 300,000.00 </td>
			</tr>
			
			
			<tr style="text-align:right">
				<td style="text-align:left">GROSS</td>
				<td>  318,174.00  </td>
				<td>  326,800.08  </td>
				<td>  335,576.40  </td>
				<td>  344,502.60  </td>
				<td>  353,578.32  </td>
				<td>  372,175.68  </td>
				<td>  391,363.80  </td>
			</tr>
			
			<tr style="text-align:right">
				<td style="text-align:left">SERVICE CHARGE</td>
				<td> 6,000.00 </td>
				<td> 6,000.00 </td>
				<td> 6,000.00 </td>
				<td> 6,000.00 </td>
				<td> 6,000.00 </td>
				<td> 6,000.00 </td>
				<td> 6,000.00 </td>
				
			</tr>
			
			<tr style="text-align:right;">
				<td style="text-align:left">1ST YR MO AMORT</td>
				<td>  27,014.50  </td>
				<td>  18,655.56  </td>
				<td>  14,482.35  </td>
				<td>  11,983.42  </td>
				<td>  10,321.62  </td>
				<td>  8,253.66  </td>
				<td>  7,022.73  </td>
			</tr>
			
			<tr style="text-align:right">
				<td style="text-align:left">SUCCEDDING YEARS</td>
				<td>   26,514.50  </td>
				<td>   18,155.56  </td>
				<td>   13,982.35  </td>
				<td>   11,483.42 </td>
				<td>   9,821.62  </td>
				<td>   7,753.66  </td>
				<td>   6,522.73  </td>
			</tr>
			
			
			<tr style="text-align: right; font-weight: bold;">
				<td colspan="8" style="text-align: left;">&nbsp;</td>
				
			</tr>
			<tr>
				<td colspan="8" style="text-align: left;">&nbsp;
					<strong>Note:</strong> &nbsp;Service charge is payable over a period of <strong>12 months</strong>
					and not included in the gross amount  as indicated above.
				</td>
				
			</tr>
			
			
			
		</tbody></table>
		<br>
			</div>';
		
		
		$file_name = 'fsdl_sr.xls';
		header("Content-type: application/octet-stream");
		header("Content-Type: application/force-download");
		header("Content-Type: application/download");
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=\"$file_name\"");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Pragma: public");
		header("Expires: 0");
		
		echo $content;
		exit();
	}
	
	function download_fsdljr()
	{
		$content ='<div id="fsdl_jr">
		<table width="100%" class="center" border=1></tr>

			<tbody><tr class="Thead"><td colspan="7"><center>FSDL JR</center> </td></tr>
			
			<tr class="Thead" style="text-align:center">
							<td colspan=7>PHP 25,000.00</td>
						</tr>
						<tr class="Thead" style="text-align:center">
							<td>&nbsp;</td>
							<td>6 MOS</td>
							<td>12 MOS</td>
							<td>18 MOS</td>
							<td>24 MOS</td>
							<td>30 MOS</td>
							<td>36 MOS</td>
						</tr>
						
						<tr style="text-align:right">
							<td style="text-align:left;">GROSS</td>
							<td>25,000.00</td>
							<td>25,000.00</td>
							<td>25,000.00</td>	
							<td>25,000.00</td>
							<td>25,000.00</td>
							<td>25,000.00</td>
						</tr>
						
						<tr style="text-align:right">
							<td style="text-align:left">SEMI-MO AMORT</td>
							<td>2083.33</td>
							<td>1041.67</td>
							<td>694.44</td>
							<td>520.83</td>
							<td>416.67</td>
							<td>347.22</td>
						</tr>
						<tr style="text-align:right;font-weight:bold;">
							<td style="text-align:left">NET PROCEEDS</td>
							<td>23,625.00</td>
							<td>22,875.00</td>
							<td>22,125.00</td>
							<td>21,375.00 </td>
							<td>20,625.00</td>
							<td>19,875.00</td>
						</tr>		
						
						<tr class="Thead" style="text-align:center">
							<td colspan=7>PHP 30,000.00</td>
						</tr>
						<tr class="Thead" style="text-align:center">
							<td>&nbsp;</td>
							<td>6 MOS</td>
							<td>12 MOS</td>
							<td>18 MOS</td>
							<td>24 MOS</td>
							<td>30 MOS</td>
							<td>36 MOS</td>
						</tr>
						
						<tr style="text-align:right">
							<td style="text-align:left">GROSS</td>
							<td>30,000.00</td>
							<td>30,000.00</td>
							<td>30,000.00</td>	
							<td>30,000.00</td>
							<td>30,000.00</td>
							<td>30,000.00</td>
						</tr>
						
						<tr style="text-align:right">
							<td style="text-align:left">SEMI-MO AMORT</td>
							<td>2,500.00</td>
							<td> 1,250.00 </td>
							<td> 833.33 </td>
							<td> 625.00 </td>
							<td>500.00 </td>
							<td> 416.67 </td>
						</tr>
						<tr style="text-align:right;font-weight:bold;">
							<td style="text-align:left">NET PROCEEDS</td>
							<td>28,350.00</td>
							<td>27,450.00</td>
							<td>26,550.00</td>
							<td>25,650.00</td>
							<td>24,750.00</td>
							<td>23,850.00</td>
						</tr>

						<tr class="Thead" style="text-align:center">
							<td colspan=7>PHP 35,000.00</td>
						</tr>
						<tr class="Thead" style="text-align:center">
							<td>&nbsp;</td>
							<td>6 MOS</td>
							<td>12 MOS</td>
							<td>18 MOS</td>
							<td>24 MOS</td>
							<td>30 MOS</td>
							<td>36 MOS</td>
						</tr>
						
						<tr style="text-align:right">
							<td style="text-align:left">GROSS</td>
							<td>35,000.00</td>
							<td>35,000.00</td>
							<td>35,000.00</td>	
							<td>35,000.00</td>
							<td>35,000.00</td>
							<td>35,000.00</td>
						</tr>
						
						<tr style="text-align:right">
							<td style="text-align:left">SEMI-MO AMORT</td>
							<td> 2,916.67 </td>
							<td> 1,458.33 </td>
							<td> 972.22  </td>
							<td> 729.17   </td>
							<td> 583.33  </td>
							<td>  486.11  </td>
						</tr>
						<tr style="text-align:right;font-weight:bold;">
							<td style="text-align:left">NET PROCEEDS</td>
							<td>33,075.00</td>
							<td>32,025.00</td>
							<td>30,975.00</td>
							<td>29,925.00</td>
							<td>28,875.00</td>
							<td>27,825.00</td>
						</tr>

						<tr class="Thead" style="text-align:center">
							<td colspan=7>PHP 40,000.00</td>
						</tr>
						<tr class="Thead" style="text-align:center">
							<td>&nbsp;</td>
							<td>6 MOS</td>
							<td>12 MOS</td>
							<td>18 MOS</td>
							<td>24 MOS</td>
							<td>30 MOS</td>
							<td>36 MOS</td>
						</tr>
						
						<tr style="text-align:right">
							<td style="text-align:left">GROSS</td>
							<td>40,000.00</td>
							<td>40,000.00</td>
							<td>40,000.00</td>	
							<td>40,000.00</td>
							<td>40,000.00</td>
							<td>40,000.00</td>
						</tr>
						
						<tr style="text-align:right">
							<td style="text-align:left">SEMI-MO AMORT</td>
							<td> 3,333.33  </td>
							<td>  1,666.67  </td>
							<td> 1,111.11 </td>
							<td>833.33 </td>
							<td> 666.67  </td>
							<td>  555.56  </td>
						</tr>
						<tr style="text-align:right;font-weight:bold;">
							<td style="text-align:left">NET PROCEEDS</td>
							<td>37,800.00</td>
							<td>36,600.00</td>
							<td>35,400.00</td>
							<td>34,200.00</td>
							<td>33,000.00</td>
							<td>31,800.00</td>
						</tr>

						<tr class="Thead" style="text-align:center">
							<td colspan=7>PHP 45,000.00</td>
						</tr>
						<tr class="Thead" style="text-align:center">
							<td>&nbsp;</td>
							<td>6 MOS</td>
							<td>12 MOS</td>
							<td>18 MOS</td>
							<td>24 MOS</td>
							<td>30 MOS</td>
							<td>36 MOS</td>
						</tr>
						
						<tr style="text-align:right">
							<td style="text-align:left">GROSS</td>
							<td>45,000.00</td>
							<td>45,000.00</td>
							<td>45,000.00</td>	
							<td>45,000.00</td>
							<td>45,000.00</td>
							<td>45,000.00</td>
						</tr>
						
						<tr style="text-align:right">
							<td style="text-align:left">SEMI-MO AMORT</td>
							<td>  3,750.00  </td>
							<td>  1,875.00 </td>
							<td>  1,250.00 </td>
							<td> 937.50  </td>
							<td>  750.00 </td>
							<td> 625.00  </td>
						</tr>
						<tr style="text-align:right;font-weight:bold;">
							<td style="text-align:left">NET PROCEEDS</td>
							<td>42,525.00</td>
							<td>41,175.00</td>
							<td>39,825.00</td>
							<td>38,475.00</td>
							<td>37,125.00</td>
							<td>35,775.00</td>
						</tr>

						<tr class="Thead" style="text-align:center">
							<td colspan=7>PHP 50,000.00</td>
						</tr>
						<tr class="Thead" style="text-align:center">
							<td>&nbsp;</td>
							<td>6 MOS</td>
							<td>12 MOS</td>
							<td>18 MOS</td>
							<td>24 MOS</td>
							<td>30 MOS</td>
							<td>36 MOS</td>
						</tr>
						
						<tr style="text-align:right">
							<td style="text-align:left;">GROSS</td>
							<td>50,000.00</td>
							<td>50,000.00</td>
							<td>50,000.00</td>	
							<td>50,000.00</td>
							<td>50,000.00</td>
							<td>50,000.00</td>
						</tr>
						
						<tr style="text-align:right">
							<td style="text-align:left">SEMI-MO AMORT</td>
							<td>  4,166.67  </td>
							<td> 2,083.33 </td>
							<td> 1,388.89  </td>
							<td> 1,041.67  </td>
							<td> 833.33 </td>
							<td> 694.44 </td>
						</tr>
						<tr style="text-align:right;font-weight:bold;">
							<td style="text-align:left;">NET PROCEEDS</td>
							<td>47,250.00</td>
							<td>45,750.00</td>
							<td>44,250.00</td>
							<td>42,750.00</td>
							<td>41,250.00</td>
							<td>39,750.00</td>
						</tr>

						<tr class="Thead" style="text-align:center">
							<td colspan=7>PHP 55,000.00</td>
						</tr>
						<tr class="Thead" style="text-align:center">
							<td>&nbsp;</td>
							<td>6 MOS</td>
							<td>12 MOS</td>
							<td>18 MOS</td>
							<td>24 MOS</td>
							<td>30 MOS</td>
							<td>36 MOS</td>
						</tr>
						
						<tr style="text-align:right">
							<td style="text-align:left">GROSS</td>
							<td>55,000.00</td>
							<td>55,000.00</td>
							<td>55,000.00</td>	
							<td>55,000.00</td>
							<td>55,000.00</td>
							<td>55,000.00</td>
						</tr>

						
						<tr style="text-align:right">
							<td style="text-align:left">SEMI-MO AMORT</td>
							<td> 4,583.33 </td>
							<td> 2,291.67  </td>
							<td> 1,527.78  </td>
							<td> 1,145.83 </td>
							<td> 916.67 </td>
							<td> 763.89 </td>
						</tr>
						<tr style="text-align:right;font-weight:bold;">
							<td style="text-align:left">NET PROCEEDS</td>
							<td>51,975.00</td>
							<td>51,325.00</td>
							<td>48,675.00</td>
							<td>47,025.00</td>
							<td>45,375.00</td>
							<td>43,725.00</td>
						</tr>

						<tr class="Thead" style="text-align:center">
							<td colspan=7>PHP 60,000.00</td>
						</tr>
						<tr class="Thead" style="text-align:center">
							<td>&nbsp;</td>
							<td>6 MOS</td>
							<td>12 MOS</td>
							<td>18 MOS</td>
							<td>24 MOS</td>
							<td>30 MOS</td>
							<td>36 MOS</td>
						</tr>
						
						<tr style="text-align:right">
							<td style="text-align:left;">GROSS</td>
							<td>60,000.00</td>
							<td>60,000.00</td>
							<td>60,000.00</td>	
							<td>60,000.00</td>
							<td>60,000.00</td>
							<td>60,000.00</td>
						</tr>
						
						<tr style="text-align:right">
							<td style="text-align:left">SEMI-MO AMORT</td>
							<td>  5,000.00 </td>
							<td> 2,500.00  </td>
							<td> 1,666.67 </td>
							<td> 1,250.00 </td>
							<td> 1,000.00 </td>
							<td> 833.33 </td>
						</tr>
						<tr style="text-align:right;font-weight:bold;">
							<td style="text-align:left">NET PROCEEDS</td>
							<td>56,700.00</td>
							<td>54,900.00</td>
							<td>53,100.00</td>
							<td>51,300.00</td>
							<td>49,500.00</td>
							<td>47,700.00</td>
						</tr>

						<tr class="Thead" style="text-align:center">
							<td colspan=7>PHP 65,000.00</td>
						</tr>
						<tr class="Thead" style="text-align:center">
							<td>&nbsp;</td>
							<td>6 MOS</td>
							<td>12 MOS</td>
							<td>18 MOS</td>
							<td>24 MOS</td>
							<td>30 MOS</td>
							<td>36 MOS</td>
						</tr>
						
						<tr style="text-align:right">
							<td style="text-align:left">GROSS</td>
							<td>65,000.00</td>
							<td>65,000.00</td>
							<td>65,000.00</td>	
							<td>65,000.00</td>
							<td>65,000.00</td>
							<td>65,000.00</td>
						</tr>
						
						<tr style="text-align:right">
							<td style="text-align:left">SEMI-MO AMORT</td>
							<td> 5,416.67 </td>
							<td> 2,708.33 </td>
							<td> 1,805.56 </td>
							<td> 1,354.17 </td>
							<td> 1,083.33 </td>
							<td> 902.78 </td>
						</tr>
						<tr style="text-align:right;font-weight:bold;">
							<td style="text-align:left">NET PROCEEDS</td>
							<td> 61,425.00 </td>
							<td> 59,475.00 </td>
							<td> 57,525.00 </td>
							<td> 55,575.00 </td>
							<td> 53,625.00 </td>
							<td> 51,675.00 </td>
						</tr>

						<tr class="Thead" style="text-align:center">
							<td colspan=7>PHP 70,000.00</td>
						</tr>
						<tr class="Thead" style="text-align:center">
							<td>&nbsp;</td>
							<td>6 MOS</td>
							<td>12 MOS</td>
							<td>18 MOS</td>
							<td>24 MOS</td>
							<td>30 MOS</td>
							<td>36 MOS</td>
						</tr>
						
						<tr style="text-align:right">
							<td style="text-align:left">GROSS</td>
							<td>70,000.00</td>
							<td>70,000.00</td>
							<td>70,000.00</td>
							<td>70,000.00</td>
							<td>70,000.00</td>
							<td>70,000.00</td>
						</tr>

						
						<tr style="text-align:right">
							<td style="text-align:left">SEMI-MO AMORT</td>
							<td> 5,833.33 </td>
							<td> 2,916.67 </td>
							<td> 1,944.44 </td>
							<td> 1,458.33 </td>
							<td> 1,166.67 </td>
							<td> 972.22 </td>
						</tr>
						<tr style="text-align:right;font-weight:bold;">
							<td style="text-align:left">NET PROCEEDS</td>
							<td> 66,150.00 </td>
							<td> 64,050.00 </td>
							<td> 61,950.00 </td>
							<td> 59,850.00 </td>
							<td> 57,750.00 </td>
							<td> 55,650.00 </td>
						</tr>

						<tr class="Thead" style="text-align:center">
							<td colspan=7>PHP 75,000.00</td>
						</tr>
						<tr class="Thead" style="text-align:center">
							<td>&nbsp;</td>
							<td>6 MOS</td>
							<td>12 MOS</td>
							<td>18 MOS</td>
							<td>24 MOS</td>
							<td>30 MOS</td>
							<td>36 MOS</td>
						</tr>
						
						<tr style="text-align:right">
							<td style="text-align:left">GROSS</td>
							<td>75,000.00</td>
							<td>75,000.00</td>
							<td>75,000.00</td>
							<td>75,000.00</td>
							<td>75,000.00</td>
							<td>75,000.00</td>
						</tr>
						
						<tr style="text-align:right">
							<td style="text-align:left">SEMI-MO AMORT</td>
							<td>  6,250.00  </td>
							<td> 3,125.00 </td>
							<td> 2,083.33 </td>
							<td> 1,562.50 </td>
							<td> 1,250.00 </td>
							<td> 1,041.67 </td>
						</tr>
						<tr style="text-align:right;font-weight:bold;">
							<td style="text-align:left">NET PROCEEDS</td>
							<td> 70,875.00 </td>
							<td> 68,625.00 </td>
							<td> 66,375.00 </td>
							<td> 64,125.00 </td>
							<td> 61,875.00 </td>
							<td> 59,625.00 </td>
						</tr>
						<tr style="text-align:right;font-weight:bold;">
							<td style="text-align:right" colspan=7>
								&nbsp;
							</td>
							
						</tr>
		</tbody></table>
		
		<br>
			</div>';
			
			
		$file_name = 'fsdl_jr.xls';
		header("Content-type: application/octet-stream");
		header("Content-Type: application/force-download");
		header("Content-Type: application/download");
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=\"$file_name\"");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Pragma: public");
		header("Expires: 0");
		
		echo $content;
		exit();	
	}
	
	function download_various()
	{
		$content = '<div id="various">
					
					<table width="100%" class="center" border=1>
						<tbody><tr><td colspan="6" class="Thead"><center>VARIOUS</center></td></tr>
			<tr style="text-align: center;" class="Thead">
				<td colspan="6">PHP 5,000.00</td>
			</tr>
			<tr style="text-align: center;font-weight:bold" class="Thead">
				<td width="142px">&nbsp;</td>
				<td>3 MOS</td>
				<td>6 MOS</td>
				<td>12 MOS</td>
				<td>18 MOS</td>
				<td>24 MOS</td>
			</tr>
			
			<tr style="text-align: right;">
				<td style="text-align: left;">GROSS AMOUNT</td>
				<td> 5,367.00 </td>
				<td> 5,484.00  </td>
				<td> 5,712.00 </td>
				<td> 5,940.00 </td>
				<td> 6,168.00  </td>
			</tr>
			
			<tr style="text-align: right;">
				<td style="text-align: left;">SEMI-MO AMORT</td>
				<td> 894.50 </td>
				<td> 457.00 </td>
				<td> 238.00 </td>
				<td> 165.00 </td>
				<td> 128.50 </td>
			</tr>
			<tr style="text-align: right; font-weight: bold;">
				<td style="text-align: left;">NET PROCEEDS</td>
				<td> 5,000.00 </td>
				<td> 5,000.00 </td>
				<td> 5,000.00 </td>
				<td> 5,000.00 </td>
				<td> 5,000.00 </td>
			</tr>
			
		
			
			
			
		</tbody></table>
		<br>
		
		<table width="100%" class="center" border=1>
			<tbody><tr style="text-align: center;" class="Thead">
				<td colspan="6">PHP 10,000.00</td>
			</tr>
			<tr style="text-align: center;font-weight:bold" class="Thead">
				<td width="142px">&nbsp;</td>
				<td>3 MOS</td>
				<td>6 MOS</td>
				<td>12 MOS</td>
				<td>18 MOS</td>
				<td>24 MOS</td>
			</tr>
			
			<tr style="text-align: right;">
				<td style="text-align: left;">GROSS AMOUNT</td>
				<td>  10,731.00  </td>
				<td>  10,962.00 </td>
				<td>  11,424.00 </td>
				<td>  11,880.00  </td>
				<td>  12,360.00  </td>
			</tr>
			
			<tr style="text-align: right;">
				<td style="text-align: left;">SEMI-MO AMORT</td>
				<td>  1,788.50  </td>
				<td>  913.50 </td>
				<td>  476.00 </td>
				<td>  330.00 </td>
				<td> 257.50  </td>
			</tr>
			
			<tr style="text-align: right; font-weight: bold;">
				<td style="text-align: left;">NET PROCEEDS</td>
				<td> 10,000.00 </td>
				<td> 10,000.00 </td>
				<td> 10,000.00 </td>
				<td> 10,000.00 </td>
				<td> 10,000.00 </td>
			</tr>
		
			
			
			
		</tbody></table>
		
		<br>
		
		<table width="100%" class="center" border=1>
			<tbody><tr style="text-align: center;" class="Thead">
				<td colspan="6">PHP 15,000.00</td>
			</tr>
			<tr style="text-align: center;font-weight:bold" class="Thead">
				<td width="142px">&nbsp;</td>
				<td>3 MOS</td>
				<td>6 MOS</td>
				<td>12 MOS</td>
				<td>18 MOS</td>
				<td>24 MOS</td>
			</tr>
			
			<tr style="text-align: right;">
				<td style="text-align: left;">GROSS AMOUNT</td>
				<td>  16,095.00  </td>
				<td>  16,440.00 </td>
				<td>  17,136.00  </td>
				<td>  17,820.00  </td>
				<td>  18,528.00  </td>
			</tr>
			
			<tr style="text-align: right;">
				<td style="text-align: left;">SEMI-MO AMORT</td>
				<td> 2,682.50  </td>
				<td> 1,370.00  </td>
				<td> 714.00  </td>
				<td> 495.00 </td>
				<td>  386.00 </td>
			</tr>
				
			<tr style="text-align: right; font-weight: bold;">
				<td style="text-align: left;">NET PROCEEDS</td>
				<td> 15,000.00 </td>
				<td> 15,000.00 </td>
				<td> 15,000.00 </td>
				<td> 15,000.00 </td>
				<td> 15,000.00 </td>
			</tr>
			
			
		</tbody></table>
		
		<br>
		
		<table width="100%" class="center" border=1>
			<tbody><tr style="text-align: center;" class="Thead">
				<td colspan="6">PHP 20,000.00</td>
			</tr>
			<tr style="text-align: center;font-weight:bold" class="Thead">
				<td width="142px">&nbsp;</td>
				<td>3 MOS</td>
				<td>6 MOS</td>
				<td>12 MOS</td>
				<td>18 MOS</td>
				<td>24 MOS</td>
			</tr>
			
			<tr style="text-align: right;">
				<td style="text-align: left;">GROSS AMOUNT</td>
				<td>   21,462.00  </td>
				<td>  21,924.00  </td>
				<td>   22,848.00  </td>
				<td> 23,760.00  </td>
				<td>  24,696.00  </td>
			</tr>
			
			<tr style="text-align: right;">
				<td style="text-align: left;">SEMI-MO AMORT</td>
				<td>  3,577.00   </td>
				<td> 1,827.00  </td>
				<td>  952.00  </td>
				<td>  660.00 </td>
				<td>  514.50 </td>
			</tr>
			
			
		
			<tr style="text-align: right; font-weight: bold;">
				<td style="text-align: left;">NET PROCEEDS</td>
				<td> 20,000.00 </td>
				<td> 20,000.00 </td>
				<td> 20,000.00 </td>
				<td> 20,000.00 </td>
				<td> 20,000.00 </td>
			</tr>
			
			
		</tbody></table>
	
		
				</div>';
		$file_name = 'various.xls';
		header("Content-type: application/octet-stream");
		header("Content-Type: application/force-download");
		header("Content-Type: application/download");
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=\"$file_name\"");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Pragma: public");
		header("Expires: 0");
		
		echo $content;
		exit();	
	}
	
	function download_hmpl()
	{
		$content = '<div id="hmpl">
				
					<table width="100%" class="center" border=1 >
						<tbody><tr><td colspan="6" class="Thead"><center>Handog Maligayang Pasko Loan (HMPL) / Maagang Regalo sa Disyembre (MRD)</center></td></tr>
			<tr style="text-align: center;" class="Thead">
				<td colspan="6">PHP 5,000.00</td>
			</tr>
			<tr style="text-align: center; font-weight:bold" class="Thead">
				<td width="142px">&nbsp;</td>
				<td>3 MOS</td>
				<td>6 MOS</td>
				<td>12 MOS</td>
				<td>18 MOS</td>
				<td>24 MOS</td>
			</tr>
			
			<tr style="text-align: right;">
				<td style="text-align: left;">GROSS AMOUNT</td>
				<td>  5,487.00  </td>
				<td> 5,724.00  </td>
				<td>  6,204.00  </td>
		
		<table width="100%" class="center" border=1>
			<tbody><tr style="text-align: center;" class="Thead">
				<td colspan="6">PHP 20,000.00</td>
			</tr>
			<tr style="text-align: center; font-weight:bold" class="Thead">
				<td width="142px">&nbsp;</td>
				<td>3 MOS</td>
				<td>6 MOS</td>
				<td>12 MOS</td>
				<td>18 MOS</td>
				<td>24 MOS</td>
			</tr>
			
			<tr style="text-align: right;">
				<td style="text-align: left;">GROSS AMOUNT</td>
				<td> 21,945.00 </td>
				<td> 22,890.00 </td>
				<td> 24,780.00 </td>
				<td> 26,676.00 </td>
				<td> 28,560.00 </td>
			</tr>
			
			<tr style="text-align: right;">
				<td style="text-align: left;">SEMI-MO AMORT</td>
				<td>  3,657.50  </td>
				<td> 1,907.50 </td>
				<td> 1,032.50 </td>
				<td> 741.00 </td>
				<td> 595.00 </td>
			</tr>
			
			
		
			<tr style="text-align: right; font-weight: bold;">
				<td style="text-align: left;">NET PROCEEDS</td>
				<td> 20,000.00 </td>
				<td> 20,000.00 </td>
				<td> 20,000.00 </td>
				<td> 20,000.00 </td>
				<td> 20,000.00 </td>
			</tr>
			
			
			
		</tbody></table>
	
		
				</div>';
		$file_name = 'hmpl_mrd.xls';
		header("Content-type: application/octet-stream");
		header("Content-Type: application/force-download");
		header("Content-Type: application/download");
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=\"$file_name\"");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Pragma: public");
		header("Expires: 0");
		
		echo $content;
		exit();	
	}
	
}
	
	