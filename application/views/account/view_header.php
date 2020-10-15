
<?	
	#require_once('includes/mysql_connect.inc.php');
	
	
	#$dr_number = $_POST['dr_number'];
	
	$sql = <<<SQL
	SELECT *
	FROM ar_loans_header
	LEFT JOIN stg_loan_products USING(Prod_Id)
	WHERE dr_number = '$dr_number'
SQL;

	$query = mysql_query($sql) or die(mysql_error().$sql); 
	
	
	$row = mysql_fetch_object($query);
	
	$po_number = $row->po_number;
	
	
	$q1 = "SELECT item_short_desc,item_long_desc, B.item_id
				FROM inv_prod_items A
			INNER JOIN (SELECT item_id FROM ar_loans_detail WHERE sales_id = {$row->sales_id}) B on A.item_id = B.item_id
				WHERE A.item_id = B.item_id";
		$r1 = mysql_query($q1) or die (mysql_error() . "Error in Query : ".$q1);
		$rw1 = mysql_fetch_array($r1, MYSQL_ASSOC);
		
		$prod_desc = $rw1['item_long_desc'];
	
		if(empty($prod_desc)){
			$q2 = "SELECT *
				FROM ar_loans_detail
				WHERE sales_id = {$row->sales_id}";
			$r2 = mysql_query($q2) or die (mysql_error() . "Error in Query : ".$q1);
			$rw2 = mysql_fetch_array($r2, MYSQL_ASSOC);
			$prod_desc = $rw2['i_desc'];
		}
		
		
	$sql2 = "SELECT *,CONCAT(mem_lname,', ',mem_fname,' ',mem_mname) as name
			 FROM ar_loans_comakers
			 LEFT JOIN mem_members USING(member_id)
			 WHERE sales_id = '$row->sales_id'";
	$query2 = mysql_query($sql2) or die(mysql_error().$sql2);
	
	
	
?>	




<table width="100%" style="font-size:12px;border:1px solid black;font-family:tahoma;">

<tr border=1>
	<td colspan=2 ><center><strong>LOAN INFORMATION</strong></center></td>
</tr>
<tr>
	<td style="width:150px;border:1px solid black;">SALES ID: </td>
	<td style="border:1px dotted black;"><?=$row->sales_id?> </td>
</tr>
<tr>
	<td style="width:150px;border:1px solid black;">PO DOC NUMBER: </td>
	<td style="border:1px dotted black;"><?=$row->dr_number?> </td>
</tr>
<tr>
	<td style="border:1px solid black;">PO NUMBER: </td>
	<td style="border:1px dotted black;"><?=$row->po_number?> </td>
</tr>

<tr>
	<td style="border:1px solid black;">LOAN TYPE:</td>
	<td style="border:1px dotted black;"><?=$row->prod_name?> </td>
</tr>
	
	<?if(!empty($prod_desc)):?>
<tr>
	<td style="border:1px solid black;">ITEM DESCRIPTION: </td>
	<td style="border:1px dotted black;"><?=$prod_desc?> </td>
</tr>
	<?endif;?>
<tr>
	<td style="border:1px solid black;">PO DATE: </td>
	<td style="border:1px dotted black;"><?=date("F j, Y",strtotime($row->po_date))?> </td>
</tr>
<tr>
	<td style="border:1px solid black;">PO START DATE:</td>
	<td style="border:1px dotted black;"><?=date("F j, Y",strtotime($row->po_start_date))?> </td>
</tr>
<tr>
	<td style="border:1px solid black;">PO END DATE:</td>
	<td  style="border:1px dotted black;"><?=date("F j, Y",strtotime($row->po_end_date))?> </td>
</tr>
<tr>
	<?if($row->prod_id == 'L-FS04'):?>
	<td style="border:1px solid black;">BENEFIT TYPE:</td>
	<? $name = get_mpl_namex($row->po_start_date); ?>
	<td  style="border:1px dotted black;"><?='MPL'.$name?> </td>
	<?else:?>
	<td style="border:1px solid black;">PAY TERMS:</td>
	
	<td  style="border:1px dotted black;"><?=$row->pay_terms?> </td>
	<?endif;?>
</tr>
<tr>
	<td style="border:1px solid black;">TOTAL COST:</td>
	<td  style="border:1px dotted black;"><?=number_format($row->actual_amount,2)?> </td>
</tr>

<tr>
	<td style="border:1px solid black;">GROSS AMOUNT:</td>
	<td  style="border:1px dotted black;"><?=number_format($row->gross_amount,2)?> </td>
</tr>
<tr>
	<td style="border:1px solid black;">NET PROCEEDS:</td>
	<td  style="border:1px dotted black;"><?=number_format($row->net_proceeds,2)?> </td>
</tr>

</table>

<br>
<table width="100%" style="font-size:12px;border:1px solid;font-family:tahoma;">
<tr>
	<td colspan=2><center><strong>MY CO-MAKERS</strong></center></td>
<tr>

<?
$ctr = 1;


while($row2 = mysql_fetch_array($query2, MYSQL_ASSOC)) 
{
	
	
	if( ($row2['member_category'] == 2 AND $row2['membership_status'] == 3) OR $row2['company_id'] == 10 ):
		$rem = 'Resigned';
	else:
		$rem = 'Active';
	endif;
	
	echo '<tr>
	<td>&nbsp;&nbsp;<u>'.$ctr++.'</u>. </td>
	<td>'.$row2['name']." ($rem)".'</td>
	<tr>';
	
}



if(mysql_num_rows($query2) == 0){
	echo '<tr>
	<td colspan="2" align="center">NO CO-MAKER FOUND.</td>
	
	<tr>';
	
	
}

	



	


?>


</table>


<?

function get_mpl_namex($date)
	{
		$sql2 ="SELECT *,CONCAT(YEAR(CURDATE()),'-',benefit_month,'-',15) as mpl_date
				FROM stg_employee_benefits
				WHERE benefit_month = MONTH('$date')
				ORDER BY benefit_month";
		$query2 = mysql_query($sql2);
		$row2 = mysql_fetch_array($query2,MYSQL_ASSOC);
		
		if($row2['benefit_month'] == 11){
			return '-13TH Nov';
		}elseif($row2['benefit_month'] == 12){
			return '-14TH Dec';
		}elseif($row2['benefit_month'] == 3){
			return '-USL';
		}elseif($row2['benefit_month'] == 6){
			return '-LGY';
		}elseif($row2['benefit_month'] == 5){
			return '-MIDYR';
		}else{
			return '-OTHERS';
		}
	}

?>
