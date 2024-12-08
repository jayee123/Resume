<?php
	include("mysql.inc.php");
?>

<!DOCTYPE html>
<html>
<head>
    <title>訂單管理</title>
	<script type="text/javascript">
	function check(e) {
		var id = e.target.id;
		if (confirm('確定要刪除編號為'+id+'的物料訂單嗎？\n(此項操作可能會影響加工訂單)') == true) {
			document.location.replace('o_delete.php?del='+id);
		}
	}
	
	function to_process(id) {
		try {
			parent.change_title("fpp");
		}
		catch(e) {}
		document.location.replace("../process/p_content.php?fpp_no="+id);
	}
	</script>
	<link rel="stylesheet" type="text/css" href="table.css">
</head>
<body style="text-align: center;">
	<a href="o_index.php">回首頁</a>
    <table class="mytable">
		<tr class="title">
			<td>物料訂單編號</td>
			<td>採購人員</td>
			<td>供應商</td>
			<td>總價</td>
			<td>訂單日期</td>
			<td>交貨日期</td>
			<td>狀態</td>
			<td>下一家工廠</td>
			<td colspan='2'></td>
		</tr>
		<?php
		if (isset($_GET['rm_order_no']) )
		{
			//細項
			$sql1="SELECT rm_order.*, supplier.s_name, staff.st_name
			FROM raw_material_order as rm_order, supplier, staff
			WHERE rm_order.s_no = supplier.s_no 
			AND rm_order.st_no = staff.st_no
			AND rm_order.rm_order_no = '".$_GET["rm_order_no"]."';";
			$order=mysqli_query($conn, $sql1);
			if(!$row = mysqli_fetch_array($order))
				header("Location:o_index.php"); /*查不到資料->網頁跳至物料訂單首頁*/
			
			//查下一家工廠
			$sql2="SELECT processor.*, finished_product_process.fpp_no
			FROM processor, raw_material_order, finished_product_process, sub_process
			WHERE raw_material_order.rm_order_no = '".$_GET["rm_order_no"]."'
			AND raw_material_order.rm_order_no = finished_product_process.rm_order_no
			AND finished_product_process.fpp_no=sub_process.fpp_no
			AND sub_process.sp_num = 1
			AND sub_process.p_no = processor.p_no;";
			$result=mysqli_query($conn, $sql2);
			$processor = mysqli_fetch_array($result);
			
			$state_class = array("待出貨"=>"class='none'","退回"=>"class='ing'","完成"=>"");
			
			$now = strtotime("now");
			$seconds = strtotime($row["rm_order_deadline"]) - $now;

			$day = $seconds/86400;
			$day = intval($day);
			
			$warn = "";
			if($day < 2 and $row['rm_order_state']!="完成") {
				$warn = " style='color:red; font-weight:bolder' ";
			}
			
			echo '<tr>
			<td>'.$row['rm_order_no'].'</td>
			<td>'.$row['st_name'].'</td>
			<td>'.$row["s_no"].'-'.$row['s_name'].'</td>
			<td>'.$row['rm_order_Tprice'].'</td>
			<td>'.$row['rm_order_time'].'</td>
			<td'.$warn.'>'.$row['rm_order_deadline'].'</td>
			<td '.$state_class[$row['rm_order_state']].'>'.$row['rm_order_state'].'</td>';
			if(isset($processor['p_address']))
				echo '<td><a onclick="to_process(\''.$processor["fpp_no"].'\')">'.$processor['p_name'].'－'.$processor['p_address'].'</a></td>';
			else
				echo '<td>暫無</td>';
			echo '<td><button type="button" id="'.$row["rm_order_no"].'" onclick="check(event)">刪除</button></td>
			<td><form action="o_edit.php" method="get"><button type="submit" name="edit" value="'.$row['rm_order_no'].'">編輯</button></form></td>
			</tr>';
		}
		else
			header("Location:o_index.php"); /*網頁沒有傳入rm_order_no->跳至物料訂單首頁*/
		?>
    </table>
	
	<table class="mytable">
		<tr class="title">
			<td>物料</td>
			<td>材質</td>
			<td>數量</td>
			<td>單價</td>
			<td>合計</td>
		</tr>
		<?php
			//購買項目
			$sql3="SELECT raw_material.*, raw_material_order_record.*
			FROM raw_material, raw_material_order, raw_material_order_record
			WHERE raw_material_order.rm_order_no = '".$_GET["rm_order_no"]."'
			AND raw_material_order.rm_order_no = raw_material_order_record.rm_order_no
			AND raw_material_order_record.rm_no = raw_material.rm_no;";
			$result=mysqli_query($conn, $sql3);
			while($row = mysqli_fetch_array($result)) {
				echo '<tr>
				<td>'.$row["rm_no"].'-'.$row["rm_name"].'</td>
				<td>'.$row["rm_made"].'</td>
				<td>'.$row["rm_quantity"].'</td>
				<td>'.$row["rm_Uprice"].'</td>
				<td>'.($row["rm_quantity"]*$row["rm_Uprice"]).'</td>
				</tr>';
			}
		?>
	</table>
</body>
</html>