
		
		<link rel='stylesheet' href='<?=CSS_PATH?>ledger.css' type='text/css' charset='utf-8' />
			
		<div>

			<style>

			.btn-success:hover, .open .btn-success.dropdown-toggle
			{
			    background-color: #629b58 !important;
			    border-color: #87b87f;
			}
			.btn:hover, .btn-default:hover, .open .btn.dropdown-toggle, .open .btn-default.dropdown-toggle
			{
			    background-color: #8b9aa3 !important;
			    border-color: #abbac3;
			}
			.btn-success:hover, .btn-success:focus, .btn-success:active, .btn-success.active, .open .dropdown-toggle.btn-success
			{
			    color: #fff;
			    background-color: #47a447;
			    border-color: #398439;
			}
			.btn:hover, .btn:focus
			{
			    color: #333;
			    text-decoration: none;
			}
			a:hover, a:focus
			{
			    color: #2a6496;
			    text-decoration: underline;
			}
			a:active, a:hover
			{
			    outline: 0;
			}
			.btn
			{
			    filter: progid:DXImageTransform.Microsoft.gradient(enabled=false) !important;
			}
			.btn-success, .btn-success:focus
			{
			    background-color: #87b87f !important;
			    border-color: #87b87f;
			}
			.btn, .btn-default, .btn:focus, .btn-default:focus
			{
			    background-color: #abbac3 !important;
			    border-color: #abbac3;
			}
			.btn-xs
			{
			    border-width: 3px;
			}
			.btn
			{
			    display: inline-block;
			    color: #FFF !important;
			    text-shadow: 0 -1px 0 rgba(0,0,0,0.25) !important;
			    background-image: none !important;
			    border: 5px solid #FFF;
			        border-top-width: 5px;
			        border-right-width: 5px;
			        border-bottom-width: 5px;
			        border-left-width: 5px;
			        border-top-color: rgb(255, 255, 255);
			        border-right-color: rgb(255, 255, 255);
			        border-bottom-color: rgb(255, 255, 255);
			        border-left-color: rgb(255, 255, 255);
			    border-radius: 0;
			    box-shadow: none !important;
			    -webkit-transition: all ease .15s;
			    transition: all ease .15s;
			    cursor: pointer;
			    vertical-align: middle;
			    margin: 0;
			    position: relative;
			}
			.btn-xs
			{
			    padding: 1px 5px;
			}
			.btn-sm, .btn-xs
			{
			    padding: 5px 10px;
			    font-size: 12px;
			    line-height: 1.5;
			    border-radius: 3px;
			}
			.btn-success
			{
			    color: #fff;
			    background-color: #5cb85c;
			    border-color: #4cae4c;
			}
			.btn
			{
			    display: inline-block;
			    padding: 6px 12px;
			    margin-bottom: 0;
			    font-size: 14px;
			    font-weight: normal;
			    line-height: 1.428571429;
			    text-align: center;
			    white-space: nowrap;
			    vertical-align: middle;
			    cursor: pointer;
			    border: 1px solid transparent;
			    border-radius: 4px;
			    -webkit-user-select: none;
			    -moz-user-select: none;
			    -ms-user-select: none;
			    -o-user-select: none;
			    user-select: none;
			}
			a
			{
			    color: #428bca;
			    text-decoration: none;
			}

			
			</style>
			
			
			<? 
			$inquiry = $this->input->post('inquiry');
			
			if(!empty($inquiry)):
				
				
				foreach($inquiry  as  $k => $inquiry_id):
			
				
				$sql = "UPDATE telescoop_web.member_sys_inquiry 
						SET status = 1
						WHERE id = $inquiry_id";
						
				$this->db->query($sql);
				
					
				endforeach;
					
			endif;	
			
			?>
			
			
			
			<? 

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
			
			<form action="<?=site_url($this->uri->uri_string())?>" method="POST" name="myForm">
			
			<table>
				<tr>
					<td width="60%" class="Thead" colspan="5" align="center">LIST OF INQUIRIES</td>
					<td width="20%" class="Thead" style="cursor:pointer" align="center"><a class="btn btn-xs btn-sucess" href="<?=site_url("account/download_inquiries/")?>">Print</a></td>	
					<td width="20%" class="Thead" style="cursor:pointer" align="center"><button>Done</button></td>
				</tr>	
				<tr align="center" style="height:10px">
					<td class="Thead" width="5%">#</td>
					
					<td class="Thead" width="5%">MEMBER ID</td>
					<td class="Thead" width="20%">MEMBER NAME</td>
					<td class="Thead" width="10%">TITLE</td>
					<td class="Thead" width="40%">MESSAGE</td>
					<td class="Thead" width="10%">EMAIL</td>
					<td class="Thead" width="40%">DATE ADDED</td>
						
				</tr>
				<?$ctr=1;?>	
				<?foreach( $res_val->result() as $row):?>
					
				<?$name2 = strtoupper($row->mem_lname.', '.$row->mem_fname);?>
					
				<tr>
					<td align="center"><input name="inquiry[]" type="checkbox" value="<?=$row->inquiry_id?>"/></td>

					<td align="center"><?=setLength($row->member_id);?></td>
					<td ><?=$name2?></td>
					<td ><?=$row->title?></td>
					<td><?=$row->message?></td>
					<td><a title="click to reply via outlook" href="mailto:sysadmin@telescoop.com.ph?subject=<?=$row->title?>
&cc=<?=$row->email_add?>&body=<?=$row->message.'%0AMember ID is '.$row->member_id.'%0AName : '.$name2?>"><?=$row->email_add?></a>
</td>
					<td align="center"><?=date("M j, Y H:i",strtotime($row->date_added))?></td>
					
				</tr>
					
				<?endforeach;?>
				
				<?if(count($res_val) == 0):?>
				<tr>
					<td align="center" colspan=5>NO RESULT FOUND</td>
					
				</tr>
				<?endif?>
				
			</table>
			
			</form>
			
		</div>	