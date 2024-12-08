<?php
    include("mysql.inc.php");
	
	$s_rm = "<select name='query' required>";
	$result = mysqli_query($conn,"SELECT rm_no,rm_name FROM raw_material;");
	while($row = mysqli_fetch_assoc($result))
		$s_rm .= "<option value='".$row["rm_no"]."'>".$row["rm_no"]."-".$row["rm_name"]."</option>";
	$s_rm .= "</select>";
	
	$s_fp= "<select name='query' required>";
	$result = mysqli_query($conn,"SELECT fp_no,fp_name FROM finished_product;");
	while($row = mysqli_fetch_assoc($result))
		$s_fp .= "<option value='".$row["fp_no"]."'>".$row["fp_no"]."-".$row["fp_name"]."</option>";
	$s_fp .= "</select>";
?>

<!DOCTYPE html>
<html>
<head>
    <title>訂單比價</title>
	<link rel="stylesheet" type="text/css" href="table.css">
	<script type="text/javascript">
		function opt_change(e){
			const opt = document.getElementById("opt");
			
			var opt_v = opt.value;
			
			var html = "";

			if (opt_v=="rm_no")
				html = "<?php echo $s_rm;?>";
			else
				html = "<?php echo $s_fp;?>";
			var query = document.getElementById("query");
			query.innerHTML = html;
		}
	</script>
	
	<style>
	.bottom td {
		border-bottom: 2px solid black;
	}
	.mytable {
		border-collapse: collapse;
		border: 2px solid black;
	}
	</style>
</head>
<body>
<form action="<?php echo basename(__FILE__);?>" method="post">      
	<table width="90%" style="margin:0 auto;">
	<tr>
		<td width="22.5%" style="text-align:right;"><b>搜尋：</b></td>
		<td width="17.5%" style="text-align:center;">
			<select name="opt" id="opt" oninput="opt_change(event)" onporpertychange="opt_change(event)">
				<option value="rm_no">依物料編號</option>
				<option value="fp_no">依成品編號</option>
				<option value="fpp_fp_no">依加工之成品編號</option>
			</select></td>
		<td width="22.5%" style="text-align:left;" id="query"><?php echo $s_rm;?></td>
		<td width="27.5%" style="text-align:left;"><input type="submit" name="submit" value="確認"></td> 
	</tr>
	</table>
</form>
<?php
	if(isset($_POST["submit"])) {
		if($_POST["opt"]=="rm_no") {
			$rm_name = mysqli_fetch_assoc(mysqli_query($conn,"SELECT rm_name FROM raw_material WHERE rm_no = '".$_POST["query"]."'"))["rm_name"];
			$rm = $_POST["query"]."-".$rm_name;
			echo '<table class="mytable">
			<tr><td colspan="6">'.$rm.'</td></tr>
			<tr class="title">
				<td>物料訂單編號</td>
				<td>供應商</td>
				<td>訂單日期</td>
				<td style="border-left: 3px solid black;">數量</td>
				<td>單價</td>
				<td>合計</td>
			</tr>';

			$sql="SELECT rm_order.*, supplier.s_name, supplier.s_no, raw_material_order_record.*
			FROM raw_material_order as rm_order, supplier, raw_material_order_record
			WHERE rm_order.s_no = supplier.s_no AND
			rm_order.rm_order_no = raw_material_order_record.rm_order_no AND
			rm_no = '".$_POST["query"]."'
			ORDER BY rm_Uprice ASC, rm_order.rm_order_no ASC";
			$result=mysqli_query($conn, $sql);

			if ( mysqli_num_rows($result) >0 ){
				while ( $row = mysqli_fetch_array($result) ) {
					echo '<tr>
					<td>'.$row['rm_order_no'].'</td>
					<td>'.$row['s_no'].'-'.$row['s_name'].'</td>
					<td>'.$row['rm_order_time'].'</td>
					<td style="border-left: 3px solid black;">'.$row['rm_quantity'].'</td>
					<td>'.$row['rm_Uprice'].'</td>
					<td>'.$row['rm_quantity']*$row['rm_Uprice'].'</td>
					</tr>';
				}
			}
			else
				echo "<tr><td colspan='6'>無訂單資料</td></tr>";
			echo '</table>';
		}
		else if($_POST["opt"]=="fp_no") {
			$fp_name = mysqli_fetch_assoc(mysqli_query($conn,"SELECT fp_name FROM finished_product WHERE fp_no = '".$_POST["query"]."'"))["fp_name"];
			$fp = $_POST["query"]."-".$fp_name;
			echo '<table class="mytable">
			<tr><td colspan="6">'.$fp.'</td></tr>
			<tr class="title">
				<td>物料訂單編號</td>
				<td>供應商</td>
				<td>訂單日期</td>
				<td style="border-left: 3px solid black;">數量</td>
				<td>單價</td>
				<td>合計</td>
			</tr>';

			$sql="SELECT fp_order.*, supplier.s_name, supplier.s_no, finished_product_order_record.*
			FROM finished_product_order as fp_order, supplier, finished_product_order_record
			WHERE fp_order.s_no = supplier.s_no AND
			fp_order.fp_order_no = finished_product_order_record.fp_order_no AND
			fp_no = '".$_POST["query"]."'
			ORDER BY fp_Uprice ASC, fp_order.fp_order_no ASC";
			$result=mysqli_query($conn, $sql);

			if ( mysqli_num_rows($result) >0 ){
				while ( $row = mysqli_fetch_array($result) ) {
					echo '<tr>
					<td>'.$row['fp_order_no'].'</td>
					<td>'.$row['s_no'].'-'.$row['s_name'].'</td>
					<td>'.$row['fp_order_time'].'</td>
					<td style="border-left: 3px solid black;">'.$row['fp_quantity'].'</td>
					<td>'.$row['fp_Uprice'].'</td>
					<td>'.$row['fp_quantity']*$row['fp_Uprice'].'</td>
					</tr>';
				}
			}
			else
				echo "<tr><td colspan='6'>無訂單資料</td></tr>";
			echo '</table>';
		}
		else if($_POST["opt"]=="fpp_fp_no") {
			$fp_name = mysqli_fetch_assoc(mysqli_query($conn,"SELECT fp_name FROM finished_product WHERE fp_no = '".$_POST["query"]."'"))["fp_name"];
			$fp = $_POST["query"]."-".$fp_name;
			echo '<table class="mytable">
			<tr><td colspan="8">'.$fp.'</td></tr>
			<tr class="title">
				<td>加工編號</td>
				<td>加工商</td>
				<td>委託日期</td>
				<td>加工順序</td>
				<td>備註</td>
				<td>數量</td>
				<td>單價</td>
				<td>合計</td>
			</tr>';
			
			$sql="SELECT * FROM finished_product_process WHERE fp_no = '".$_POST["query"]."';";
			$result=mysqli_query($conn, $sql);

			if ( mysqli_num_rows($result) >0 ){
				while ( $fpp = mysqli_fetch_array($result) ) {
					$sql = "SELECT * FROM sub_process WHERE fpp_no = '".$fpp["fpp_no"]."' ORDER BY sp_num ASC;";
					$subs = mysqli_query($conn,$sql);
					
					$subs_count = mysqli_num_rows($subs);
					while($sub = mysqli_fetch_assoc($subs)) {
						$p = mysqli_fetch_assoc(mysqli_query($conn,"SELECT p_no,p_name FROM processor WHERE p_no = '".$sub["p_no"]."';"));
						if($sub["sp_num"]==1) {	
							if($sub["sp_num"] == $subs_count)
								echo '<tr class="bottom"><td>'.$fpp['fpp_no'].'</td>';
							else
								echo '<tr><td rowspan="'.$subs_count.'" style="border-bottom: 2px solid black;">'.$fpp['fpp_no'].'</td>';
						}
						else {
							if($sub["sp_num"] == $subs_count)
								echo "<tr class='bottom'>";
							else
								echo "<tr>";
						}
						
						echo '
						<td>'.$p['p_no'].'-'.$p['p_name'].'</td>
						<td>'.$fpp['fpp_time'].'</td>
						<td style="border-left: 3px solid black;">'.$sub['sp_num'].'</td>
						<td>'.$sub['p_content'].'</td>
						<td>'.$sub['p_quantity'].'</td>
						<td>'.$sub['p_Uprice'].'</td>
						<td>'.$sub['p_quantity']*$sub['p_Uprice'].'</td>
						</tr>';
					}
				}
			}
			else
				echo "<tr><td colspan='8'>無訂單資料</td></tr>";
			echo '</table>';
		}
	}
	else
		echo "<table class='mytable'><tr><td>請根據比價條件進行查詢</td></tr></table>";
?>
</body>
</html>