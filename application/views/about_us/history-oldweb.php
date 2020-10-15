<?

error_reporting(E_ALL ^ E_NOTICE);
ini_set("memory_limit","1500M");
ini_set('max_execution_time', 300); 

					
 				

/*
	$sql = <<<SQL
    		
	    	SELECT *
	    	FROM teles_bin.for_email_member4
	    	WHERE id BETWEEN 5301 AND 5350
	    	#OR
	    	#email_send IN ('jethro.malate@telescoop.com.ph')
	    	 
		#WHERE email_send IN ('jethromalate@gmail.c	om', 'gie.armada@telescoop.com.ph')
SQL;
	$query = $this->db->query($sql);
	$ctr = 1;	
	foreach($query->result() as $row)
	{
		$this->email->clear(TRUE);
			
		$msg = '<p style="font-size:20px"><br>
					
		Good day  …………. TELESCOOP MEMBERS
		<br>
		<br>	
		<br> 		
		&nbsp;&nbsp;&nbsp;&nbsp;    CHRISTMAS is already approaching and might be thinking of  giving something 
		<br>special to your  LOVE ONES. Maybe you can choose it from the attach List of TELESCOOP products.
		<br><br>
		&nbsp;&nbsp;&nbsp;&nbsp;You can avail it thru TELESCOOP <strong style="background:yellow">@ a very low prices</strong> and on installment basis which 
		<br>entitled you to a  Patronage Refund(Dividend) .
		<br><br>
		</p>	
		<br>
		<p style="font-size:18px">
		For inquiries, you may call  Ms. Susan O. Domingo at telephone numbers 8997911 or 8997912 (09395448739)
		<br>
		Or send email to (susan.domingo@telescoop.com.ph, cynthia.laroya@telescoop.com.ph, gigi.deguzman@telescoop.com.ph)
		<br><br>
  		Or to our Sales Representatives located at :
  		<br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;RC canteen – Alvin Aureada (09195240714)
        <br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Teltech canteen- Elbert Magcalas( 09198276305)
        <br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sampaloc canteen – Edmun Bulaon ( 09219949005)
        <br>
 		<br>
 		</p>
 		<p style="font-size:20px">
		It\'s our privilege to be of  SERVICE TO YOU…. And ..ADVANCE MERRY CHRISTMAS
		<br>
		<br>
		<br>
		</p>					
		';	
		$this->db->where('id',$row->id);
		$this->db->update('teles_bin.for_email_member4',array('status'=> 1));
			
		$this->email->to($row->email_send);
    				 
	    $this->email->from('sysadmin@telescoop.com.ph', 'TELESCOOP');
	    $this->email->subject("TELESCOOP");	
	    $this->email->message($msg);
	    	
	    $path=$_SERVER["DOCUMENT_ROOT"];
		    	
	    $this->email->attach($path.'/assets/files/DIRECT SELLING PRICELIST.xls');
	    	
    	if ( ! $this->email->send())
		{
		    echo $ctr++.'. The email error '.$this->email->print_debugger().'<br>';
		}else{
			echo $ctr++.'. The email was sent to '.$row->email_send .'<br>';
		}
	    	
	}
*/		
?>



<div id="body-left">
	<div id="left-content">
		<span class="tag-title">&nbsp;&nbsp;HISTORY OF TELESCOOP</span>	
		
		<br>
			In April 1974, the General Assembly of the PLDT Employees’ Credit Cooperative, Inc. (PECCI) passed and approved a General Assembly Resolution directing its Board of Directors to organize a “Consumers Cooperative”. A committee was then formed to prepare and work on the feasibility study.
			
		<br><br>
			In May, 1974, the Committee confirmed the need to organize a “Consumers Cooperative” to beat the skyrocketing prices of goods, commodities and services due to the devaluation of the Peso at that time. As conceptualized by Messrs. Ildefonso L. Abasolo, Jr. and Constantino Pastrana, the proposed name was “TELEPHONE EMPLOYEES’ SERVICE COOPERATIVE” where the present acronym “TELESCOOP” was derived. To give emphasis and align with the institutional base of membership which was “PLDT”, the proposed name was changed to “PLDT EMPLOYEES’ CONSUMER COOPERATIVE, INC.” which was adopted in the application for registration. There were nine (9) founding directors and thirty (30) founding members who signed the Articles of Incorporation and By-Laws. The nine (9) founding directors were:
			<br><br>
			
			<div class="sched">
				<table>
					<tbody>


					<tr style="color: black;">
					<td width="1%">1.</td>
					<td>ILDEFONSO L. ABASOLO Jr.</td>
					<td width="1%">4.</td>
					<td>KASARINLAN O. GARCIA</td>
					<td width="1%">7.</td>
					<td>RENATO C. KALALANG</td>

					</tr>
					<tr style="color: black;">
					<td width="1%">2.</td>
					<td>DOLORES R. CANSECO</td>
					<td width="1%">5.</td>
					<td>BIENVENIDO R. GREY</td>
					<td width="1%">8.</td>
					<td>ROLANDO L. LAVARIAS</td>

					</tr>
					<tr style="color: black;">
					<td width="5px">3.</td>
					<td>ISABELO A. FERIDO Jr.</td>
					<td width="1%">6.</td>
					<td>ANTONIO B. JIMENEZ</td>
					<td width="1%">9.</td>
					<td>ROMEO C. RANJO</td>


					</tbody>
				</table>
			</div>

			<br><br>
			On June 17, 1974, the application together with the Articles of Incorporation and By-Laws and other supporting documents were submitted to the Bureau of Cooperative Development for evaluation and approval.
			<br><br>
			On October 22, 1974, The Bureau of Cooperative Development granted authority to organize but suggested to change the proposed name from “PLDT EMPLOYEES’ CONSUMER COOPERATIVE INC.” to “PLDT EMPLOYEES’ SERVICE COOPERATIVE, INC.” but retaining in the process the acronym “TELESCOOP”.
			<br><br>
			On November 19, 1974, the nine (9) interim Board of Directors were elected by the founding members with Renato C. Kalalang being elected as Interim Chairman/President and Rolando L. Lavarias being elected as General Manager. At the same time, the first three (3) Members of the Audit Committee (formerly Audit and Inventory Committee) were elected namely: Vicente Bolisig, Wilfredo Dela Cruz and Rodrigo Profeta.
			<br><br>
			In December 1974, the interim Chairman/President, Renato C. Kalalang, sent a letter to PLDT Management requesting for a check-off payroll deduction arrangement for TELESCOOP. This was approved by no less than the PLDT-President ,Ramon O. Cojuangco.
			<br><br>
			In January, 1975, membership campaign was started and intensified which generated positive response from PLDT employees who applied for Telescoop membership.
			<br><br>
			In February 1975, the first payroll deduction was started for share capital contribution of early batch of TELESCOOP members and PLDT remitted to TELESCOOP the first payroll check-off amounting to   P 15,000.00. This check-off deduction arrangement continues up to the present.
			<br><br>
			On June 18, 1976, the Bureau of Cooperative Development issued Certificate of Registration No. FF-045 formally registering “PLDT Employees’ Service Cooperative, Inc. (TELESCOOP)” as a full pledge primary cooperative. The date of its registration on June 18, 1976 was officially adopted as the birth of TELESCOOP.
			<br><br>
			After receipt of the Certificate of Registration No. FF-045, the First General Assembly was immediately held by the founding members and elected the following regular nine (9) members of the Board of Directors for a term of one (1) year:
			<br><br>

			<div class="sched">
				<table>
					<tbody>


					<tr style="color: black;">
					<td width="1%">1.</td>
					<td>ILDEFONSO L. ABASOLO Jr.</td>
					<td width="1%">4.</td>
					<td>KASARINLAN O. GARCIA</td>
					<td width="1%">7.</td>
					<td>RENATO C. KALALANG</td>

					</tr>
					<tr style="color: black;">
					<td width="1%">2.</td>
					<td>DOLORES R. CANSECO</td>
					<td width="1%">5.</td>
					<td>BIENVENIDO R. GREY</td>
					<td width="1%">8.</td>
					<td>ROLANDO L. LAVARIAS</td>

					</tr>
					<tr style="color: black;">
					<td width="5px">3.</td>
					<td>ISABELO A. FERIDO Jr.</td>
					<td width="1%">6.</td>
					<td>ANTONIO B. JIMENEZ</td>
					<td width="1%">9.</td>
					<td>ROMEO C. RANJO</td>


					</tbody>
				</table>
			</div>

			<br><br>
			Its principal office and operations were originally conducted at the Third (3rd) Floor, PLDT Makati General Office (MGO) Building, Dela Rosa St., Makati City. Then at the Ground Floor,PLDT Building, Reposo St., Makati City. When PECCI and TELESCOOP jointly purchased the PLDT Cooperatives Building in 1996, TELESCOOP relocated and transferred its principal office and operations in 2000 to the 5th Floor, PLDT Cooperatives Building, 4718 Eduque St., Makati City where it continues its operations up to the present.
			<br><br>
			Its area of operation and institutional base of membership includes PLDT Inc. and its Subsidiaries and Affiliates. From a high of 9,500 regular members in 2006, membership went down to the present 6,500 members due to attrition brought about by the continuous Manpower Reduction Program (MRP) of PLDT Inc.
			<br><br>
			In 2003, the General Assembly approved the amendment of its cooperative structure from a single purpose to a multi-purpose primary cooperative. In the process, “PLDT Employees’ Service Cooperative, Inc”, was amended to “PLDT Employees Multi-Purpose Cooperative” with the same acronym “TELESCOOP”.
			<br><br>
			In 2008, after a span of thirty two (32)years of operations, buoyed-up by the spirit of cooperativism and sustained patronage of its members, TELESCOOP achieved a remarkable feat of being a “ BILLIONAIRE COOPERATIVE”.
			<br><br>
			Always a “Helping Hand” in times of needs and provider of funds for providential and productive purposes for its members, the driving force “TELESCOOP-Kaagapay Sa Pag-Unlad “ is now proverbial among its members and stakeholders.
			<br><br>

		
		
	<!--<br><br>		
	In June 17, 1974 application together with documents were submitted to the Bureau of Cooperative Development.
	<br><br>		
	In October 22, 1974 the Bureau granted authority to organize but suggested to change name to PLDT EMPLOYEES' SERVICE COOPERATIVE, INC.  The acronym adopted was TELESCOOP.
	<br><br>	
	In November 19, 1974 the board of incorporators met and elected the interim nine (9) Board of Directors namely:  Kalalang, Lavarias, Abasolo, Ranjo and Dizon and three (3) Audit and Inventory Committee namely:  Dela Cruz, Profeta and Bolisig.  In the ensuing elections, Kalalang and Lavarias were chosen/President and General Manager, respectively.
	<br><br>
	In December 1974, the Chairman/President wrote PLDT  Management for a chek-off deduction for TELESCOOP through payroll.  Mr. Ramon Cojuangco, PLDT-President approved the request.
	<br><br>
	In January 1975 started the campaign for membership.
	<br><br>
	In February 1975 started payroll deduction for capital share of members who registered.
	<br><br>
	In June 18, 1976, the Bureau of Cooperative Development granted a certificate of registration No. Ff-045 a full pledge Cooperative.  The date was officially adopted as the birth of TELESCOOP.
	<br><br>
	After receipt of certification of registration, an election of nine (9) Board of Directors was held and the following were elected for a one (1) year term.
<br><br>
	<div class="sched">
				<table >
					</tr>
					<tr style="color:black;">
						<td width=1%>1.</td>
						<td>I. ABASOLO, JR.</td>
						<td width=1%>5.</td>
						<td>B. GREY</td>
						<td width=1%>9.</td>
						<td>R. RANJO</td>
					
					</tr>
					<tr style="color:black;">
						<td width=1%>2.</td>
						<td>D. CANSECO</td>
						<td width=1%>6.</td>
						<td>A. JIMENEZ</td>
					</tr>		
					<tr style="color:black;">
						<td width=5px>3.</td>
						<td>I. FERIDO, JR.</td>
						<td width=1%>7.</td>
						<td>R. KALALANG</td>
					</tr>		
					<tr style="color:black;">
						<td width=1%>4.</td>
						<td>K. GARCIA</td>
						<td width=1%>8.</td>
						<td>R. LAVARIAS</td>
					</tr>		
				</table>
	</div>	
		
	<br><br>
		
	From among the board members, elected Chairman/President was Kalalang and Jimenez as General Manager.
	<br><br>
	From its official birth in 1976, TELESCOOP has registered continuous growth to become one of the top Cooperative in the country with total assets of                    
	P 2,130,487,540  as of December 31, 2015.	-->	
	</div>	
</div>