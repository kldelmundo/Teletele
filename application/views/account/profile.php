<!-- MADE TO COMPENSATE THE PROFILE FOR BLISS PROJECT -->
<body>        
   
<div id="body">
 
	<div class="bodygradient">
		<div class="bodyminimum">
    	
			<div style="height: 50px; position: relative; width: 100%; top:40px; font-family: Akrobat; font-size: 18px; color:white; text-align: center; padding: 5px;">
			<h1> PROFILE </h1>            
			</div>
	    		<div id="profile" style="margin: 50px 250px; background-color: white; padding: 40px 50px; font-size: 18px; text-align: left;">
						
						<table>
							<tr>
								<td class="Thead" colspan=6>My Profile Information</td>
								</tr>
								<tr>
									<td><strong>NAME:</strong></td>
									<td colspan=2 style="font-size:13px"><?=strtoupper($row->mem_lname.', '.$row->mem_fname.' '.$row->mem_mname);?></td>
									<td>
										<strong>MEMBER ID: &nbsp;</strong> <?=setLength($row->member_id)?>
										<input type="hidden" id="member_id" value="<?=$row->member_id?>"/>
									</td>
								</tr>
							<tr>
							<?$id_no = $row->mem_emp_id;
								$level = $row->emp_level;
								?>
									<td><strong>COMPANY ID#:</strong></td>
									<td><?=$id_no;?></td>
									<td><strong>EMP LEVEL:</strong></td>
									<td><?=$level;?></td>
									<!--td><strong>POSITION:</strong></td>
									<td><?=$row->position?></td-->
								</tr>	
								<!--tr>
									<td><strong>LOCATION:</strong></td>
									<td><?=$row->mem_location?></td>
									<td><strong>DEPARTMENT:</strong></td>
									<td><?=$row->department_name?></td>
								</tr-->
								<tr>
									<td><strong>DATE HIRED:</strong></td>
									<td><?=date('F j, Y',strtotime($row->mem_hired_date));?></td>
									<td><strong>TELEPHONE#:</strong></td>
									<td><?=$row->mem_telno?></td>
								</tr>
								
								<tr>
									<td><strong>BIRTH DATE:</strong></td>
									<td>	<?=date('F j, Y',strtotime($row->mem_bday));?></td>
									<td><strong>FIRST DEDUCTION:</strong></td>
									<td>	<?=date('F j, Y',strtotime($row->dedn_start_dt));?></td> 
								</tr>
								
								<tr>
									<td><strong>ADDRESS:</strong></td>
									<td colspan=4><?=$row->mem_address;?></td>
								</tr>
									
						</table>
						
						<table>
							<tr>
								<td class="Thead" colspan=6>Beneficiaries</td>
								</tr>
								<tr>
									<td class="Thead" >#</td>
									<td class="Thead" >Name of Beneficiaries</td>
									<td class="Thead" >Relationship</td>
									<td class="Thead" >Date of Birth</td>
								</tr>
								
								<? $ctr=1; foreach($row_dep as $row2):?>
								<tr>
									<td><?=$ctr++?></td>
									<td><?=$row2->ben_lname?>, <?=$row2->ben_fname?></td>
									<td><?=$row2->rel_desc?></td>
									<td><?=date('F j, Y',strtotime($row2->beneficiary_bday));?></td>
								</tr>
								
								<?endforeach;?>
								<?if(count($row_dep) == 0):?>
								<tr>
									<td colspan=4 align=center><center>NO BENEFICIARY FOUND.</center></td>
									
								</tr>
								<?endif;?>
								
						</table>
					</div>	    
		</div>
	</div>
</div>

</body>

