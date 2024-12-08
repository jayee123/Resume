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
		if (confirm('確定要刪除編號為'+id+'的成品訂單嗎？') == true) {
			document.location.replace('f_delete.php?del='+id);
		}
	}
	</script>
	<link rel="stylesheet" type="text/css" href="table.css">
</head>
<body style="text-align: center;">
<a href="f_index.php">回首頁</a>
    <table class="mytable">
		<tr class="title">
			<td>成品訂單編號</td>
			<td>採購人員</td>
			<td>供應商</td>
			<td>總價</td>
			<td>訂單日期</td>
			<td>交貨日期</td>
			<td>狀態</td>
			<td colspan='2'></td>
		</tr>
		<?php
		if (isset($_GET['fp_order_no']) )
		{
			//細項
			$sql1="SELECT fp_order.*, supplier.s_name, staff.st_name
			FROM finished_product_order as fp_order, supplier, staff
			WHERE fp_order.s_no = supplier.s_no 
			AND fp_order.st_no = staff.st_no
			AND fp_order.fp_order_no = '".$_GET["fp_order_no"]."';";
			$order=mysqli_query($conn, $sql1);
			if(!$row = mysqli_fetch_array($order))
				header("Location:f_index.php"); /*查不到資料->網頁跳至物料訂單首頁*/

			$state_class = array("待出貨"=>"class='none'","退回"=>"class='ing'","完成"=>"");
			$now = strtotime("now");
			$seconds = strtotime($row["fp_order_deadline"]) - $now;

			$day = $seconds/86400;
			$day = intval($day);
			
			$warn = "";
			if($day < 2 and $row['fp_order_state']!="完成") {
				$warn = " style='color:red; font-weight:bolder' ";
			}

			echo '<tr>
			<td>'.$row['fp_order_no'].'</td>
			<td>'.$row['st_name'].'</td>
			<td>'.$row["s_no"].'-'.$row['s_name'].'</td>
			<td>'.$row['fp_order_Tprice'].'</td>
			<td>'.$row['fp_order_time'].'</td>
			<td'.$warn.'>'.$row['fp_order_deadline'].'</td>
			<td '.$state_class[$row['fp_order_state']].'>'.$row['fp_order_state'].'</td>';

			echo '<td><button type="button" id="'.$row['fp_order_no'].'" onclick="check(event)">刪除</button></td>
				  <td><form action="f_edit.php" method="get"><button type="submit" name="edit" value="'.$row['fp_order_no'].'">編輯</button></form></td>
			</tr>';
		}
		else
		 	header("Location:f_index.php"); /*網頁沒有傳入fp_order_no->跳至物料訂單首頁*/
		?>
    </table>
	
	<table class="mytable">
		<tr class="title">
			<td>成品</td>
			<td>材質</td>
			<td>數量</td>
			<td>單價</td>
			<td>合計</td>
		</tr>
		<?php
			//購買項目
			$sql3="SELECT finished_product.*, finished_product_order_record.*
			FROM finished_product, finished_product_order, finished_product_order_record
			WHERE finished_product_order.fp_order_no = '".$_GET["fp_order_no"]."'
			AND finished_product_order.fp_order_no = finished_product_order_record.fp_order_no
			AND finished_product_order_record.fp_no = finished_product.fp_no;";
			$result=mysqli_query($conn, $sql3);
			while($row = mysqli_fetch_array($result)) {
				echo '<tr>
				<td>'.$row["fp_no"].'-'.$row["fp_name"].'</td>
				<td>'.$row["fp_made"].'</td>
				<td>'.$row["fp_quantity"].'</td>
				<td>'.$row["fp_Uprice"].'</td>
				<td>'.($row["fp_quantity"]*$row["fp_Uprice"]).'</td>
				</tr>';
			}
		?>
	</table>
</body>
</html>