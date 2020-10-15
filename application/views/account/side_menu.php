
<script>

$(document).ready(
			
	function()
	{
	    $('#subs').each(function(){
		    var url = $(this).attr('href') + '?TB_iframe=true&height=500&width=800';
		    $(this).attr('href', url);
	    });
	    
	    $('#subs2').each(function(){
		    var url = $(this).attr('href') + '?TB_iframe=true&height=400&width=700';
		    $(this).attr('href', url);
	    });
	    
	     $('#subs3').each(function(){
		    var url = $(this).attr('href') + '?TB_iframe=true&height=400&width=850';
		    $(this).attr('href', url);
	    });
	}
			
); 
	

</script>

<script type="text/javascript">
function showPopup(url) {
newwindow=window.open(url,'for_evaluation','height=190,width=520,top=200,left=300,resizable');
if (window.focus) {newwindow.focus()}
}
</script>


<div id="body-right">
	<div class="bg-separator"></div>
	<div id="right-content">
			
		<? if($is_questions_answered): ?>
			<? if($is_questions_answered2): ?>
				<div class="left-title">My Account</div>
				<div id="menu">
					<!--<div class="mtitle"><a href="javascript:void(0);" onclick="showContent('home');">Home</a></div>	-->
					
					<div class="mtitle"><a href="javascript:void(0);" onclick="showContent('profile');">My Profile</a></div>
					
					<div class="mtitle" 
							
						onclick="javascript: window.open('<?=site_url()?>/account/ledger.aspx', 'printable1', 'scrollbars=1,menubar=0, resizable=0, height=650, width=1005');" 
							
						onmouseover="this.style.cursor='pointer';" style="width: 200px; cursor: pointer;">
							
							
							
						<a href="#">Subsidiary Ledger</a>
							
					</div>
					
					<? #if($row->access_levels == 1) :?>	
						<div class="mtitle" 
							
							onclick="javascript: window.open('<?=site_url()?>/account/comakers.aspx', 'printable2', 'scrollbars=1,menubar=0, resizable=0, height=650, width=800');" 
								
							onmouseover="this.style.cursor='pointer';" style="width: 200px; cursor: pointer;">
								
								
								
							<a href="#">Co-maker Exposure</a>
								
						</div>
					
					
					<? if($shell_query->num_rows() > 0):?>
					<?#=$shell_query>num_rows();?>
					<div class="mtitle" 
							
							onclick="javascript: window.open('<?=site_url()?>/account/shell.aspx', 'printable3', 'scrollbars=1,menubar=0, resizable=0, height=450, width=930');" 
								
							onmouseover="this.style.cursor='pointer';" style="width: 200px; cursor: pointer;">
								
								
								
							<a href="#">Shell Card Transaction </a>
								
					</div>
					<?endif?>
					
					<div class="mtitle"><a href="javascript:void(0);" onclick="showContent('x');">Dividend Information </a></div>
					<div class="mtitle"><a href="javascript:void(0);" onclick="showContent('savings');">My Telescoop Savings</a></div>
					<? $new = $row_new_loans->num_rows(); ?>
					<? if($new > 0):?>
					<div class="mtitle"><a href="javascript:void(0);" onclick="showContent('new_loans');">Newly Applied Loans (<?=$new?>)</a></div>
					<?endif;?>
					<div class="mtitle"><a href="javascript:void(0);" onclick="showContent('POL');">ONLINE LOAN APPLICATION <x style="color:red">**NEW**</x></a></div>
				</div>
				<br>
			<? else: ?>		
				<div class="left-title">My Account</div>
			
				<div id="menu">
					<div class="mtitle"><a href="javascript:void(0);" onclick="showContent('home');">Home</a></div>	
					
					<div class="mtitle"><a href="javascript:void(0);" onclick="showContent('profile');">My Profile</a></div>
					
					<div class="mtitle" 
							
						onclick="alert('Security Questions Required to Answer!')" 
							
						onmouseover="this.style.cursor='pointer';" style="width: 200px; cursor: pointer;">
							
							
							
						<a href="#">Subsidiary Ledger</a>
							
					</div>
					<<div class="mtitle"><a href="javascript:void(0);" onclick="showContent('x');">Dividend Information <x style="color:red">**NEW**</x></a></div>
					<div class="mtitle"><a href="javascript:void(0);" onclick="alert('Security Questions Required to Answer!')" > My Telescoop Savings</a></div>
					<? $new = $row_new_loans->num_rows(); ?>
					<? if($new > 0):?>
					<div class="mtitle"><a href="javascript:void(0);" onclick="showContent('new_loans');">Newly Applied Loans (<?=$new?>)</a></div>
					<?endif;?>
				</div>
				<br>
			<?endif;?>
		<? else: ?>	
			<div class="left-title">My Account</div>
			
			<div id="menu">
				<div class="mtitle"><a href="javascript:void(0);" onclick="showContent('home');">Home</a></div>	
				
				<div class="mtitle"><a href="javascript:void(0);" onclick="showContent('profile');">My Profile</a></div>
				
				<div class="mtitle" 
						
					onclick="alert('Challenge Questions Required!')" 
						
					onmouseover="this.style.cursor='pointer';" style="width: 200px; cursor: pointer;">
						
						
						
					<a href="#">Subsidiary Ledger</a>
						
				</div>
				
				
				<div class="mtitle"><a href="javascript:void(0);" onclick="showContent('x');">Dividend Information <x style="color:red">**NEW**</x></a></div>

				<div class="mtitle"><a href="javascript:void(0);" onclick="alert('Challenge Questions Required!')" > My Telescoop Savings</a></div>
				<? $new = $row_new_loans->num_rows(); ?>
				<? if($new > 0):?>
				<div class="mtitle"><a href="javascript:void(0);" onclick="showContent('new_loans');">Newly Applied Loans (<?=$new?>)</a></div>
				<?endif;?>
				
				
			</div>
			<br>
		<?endif;?>	
			
			<div class="left-title">Options</div>
			
			<div id="menu">
				
				<div class="mtitle"><a href="javascript:void(0);" onclick="showContent('pwd');">Change Password</a></div>
				<div class="mtitle"><a href="javascript:void(0);" onclick="showContent('notify');">Notification Settings</a></div>
				<? if($row->access_levels == 1) :?>	
				
				<? $count = $this->db->get_where('telescoop_web.member_sys_access',array('access_status'=>2)) ?>
				<? $count2 = $this->db->get_where('telescoop_web.member_sys_inquiry',array('status'=>0)) ?>
				
					<!--<div class="mtitle"><a id="subs2" title="For Evaluation" href="<?=site_url("account/for_evaluation")?>" class="thickbox">For Evaluation (<?=$count->num_rows();?>)</a></div>-->


					<div class="mtitle" 
							
						onclick="javascript: window.open('http://119.93.95.162/For_Evaluation', 'mywindow', 'scrollbars=1,menubar=0, resizable=0, height=650, width=1005');" 
							
						onmouseover="this.style.cursor='pointer';" style="width: 200px; cursor: pointer;">
							
							
							
						<a href="#">For Evaluation (<?=$count->num_rows();?>)</a>
							
					</div>


					<!--<div class="mtitle"><a name="for_evaluation" title="For Evaluation" href="http://192.168.200.11/CodeIgniter1/" target="_blank" >For Evaluation</a></div>-->
					<div class="mtitle"><a id="subs3" title="List of inquiries" href="<?=site_url("account/inquiries")?>" class="thickbox">Inquiries (<?=$count2->num_rows();?>)</a></div>
					


					
				<?endif;?>
				
			<div class="mtitle"><a href="javascript:void(Tawk_API.popup());" onclick="showContent('inq');">Inquiry Form</a></div>
			<div class="mtitle"><a href="<?=site_url('account/logout')?>">Logout</a></div>

		</div>
	</div>
</div>

