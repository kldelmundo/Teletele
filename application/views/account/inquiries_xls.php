<?
	header("Content-type: application/octet-stream");
	header("Content-Type: application/force-download");    
	header("Content-Type: application/download");
	header("Content-type: application/vnd.ms-excel");   
	header("Content-Disposition: attachment; filename = Inquiries.xls");
	header("Cache-Control: maxage=1");
	header("Pragma: public");
	header("Expires: 0");



	$sql = <<<SQL
			SELECT *,telescoop_web.member_sys_inquiry.id as inquiry_id
			FROM telescoop_web.member_sys_inquiry 
			LEFT JOIN telescoop_web.member_sys_access USING(member_id)
			LEFT JOIN mem_members USING(member_id)	
			WHERE status = 0	
			ORDER BY id DESC
SQL;
			
			$res_val = $this->db->query($sql);
			?>
			
			
			<table cellspacing="10" border=1 style="background:white;margin-top:-10px;font-size:12px;">
				<tr>
					<td width="60%" class="Thead" colspan="7" align="center">LIST OF INQUIRIES</td>
				</tr>	
				<tr align="center" style="height:20px">
					<td class="Thead" width="10%">#</td>
					
					<td class="Thead" width="10%"></td>
					<td class="Thead" width="10%">MEMBER ID</td>
					<td class="Thead" width="20%">MEMBER NAME</td>
					<td class="Thead" width="10%">TITLE</td>
					<td class="Thead" width="40%">MESSAGE</td>
					<td class="Thead" width="10%">EMAIL</td>
					<td class="Thead" width="40%">DATE ADDED</td>
					<td class="Thead" width="40%">RECIPIENT</td>
					<td class="Thead" width="40%">STATUS</td>
					<td class="Thead" width="40%">DATE/TIME</td>
						
				</tr>
				<?$ctr=1;?>	
				<?foreach( $res_val->result() as $row):?>
					
				<?$name2 = strtoupper($row->mem_lname.', '.$row->mem_fname);?>
					
				<tr>
					<td></td>
					<td align="center" width="10%"><?=$ctr;?></td>

					<td align="center" width="10%"><?=setLength($row->member_id);?></td>
					<td align="center" width="20%"><?=$name2?></td>
					<td align="center" width="10%"><?=$row->title?></td>
					<td align="center" width="40%"><?=$row->message?></td>
					<td align="center" width="10%"><a title="click to reply via outlook" href="mailto:<?=$row->email_add?>?subject=<?=$row->title?>
					&body=<?=$row->message?>"><?=$row->email_add?></a>
					</td>
					<td align="center" width="40%"><?=date("M j, Y H:i",strtotime($row->date_added))?></td>

					<?
					if($row->title == "Application for New / Termination of Membership")
					{
						$recipient = "telescoop.corp_service@yahoo.com.ph";
					}
					elseif($row->title == "Direct Selling Loans / Promo Loans / Pricelist")
					{
						$recipient = "telescoop.directselling@yahoo.com.ph";
					}
					elseif($row->title == "Loan Computation / Account Balance")
					{
						$recipient = "telescoop.cust_serve@yahoo.com.ph";
					}
					elseif($row->title == "Savings Deposit / Withdrawal / Balance")
					{
						$recipient = "telescoop.treasury@yahoo.com.ph";
					}
					elseif($row->title == "Others")
					{
						$recipient = "telescoop.mgmt_info@yahoo.com.ph";
					}
					else
					{
						$recipient = "telescoop.mgmt_info@yahoo.com.ph";
					}
					?>
					<td align="center" width="40%"><?=$recipient;?></td>
					<td></td>
					<td></td>
					
				</tr>
				<?$ctr++;?>
				<?endforeach;?>
				
				<?if(count($res_val) == 0):?>
				<tr>
					<td align="center" colspan=5>NO RESULT FOUND</td>
					
				</tr>
				<?endif?>
				
			</table>

