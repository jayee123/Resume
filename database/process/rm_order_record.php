<?php
	include_once("dbtools.inc.php");
	if (!isset($_POST["rm_order_no"]))
		header("Location:process.php");
	
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>原料訂單清單</title>
  <link href="table.css" rel="stylesheet" type="text/css">
</head>
<body>
	<?php
		$link = create_connection();
		$sql = "SELECT a.*,b.s_name,c.st_name from raw_material_order as a, supplier as b, staff as c WHERE rm_order_no='".$_POST["rm_order_no"]."' and a.s_no = b.s_no and a.st_no = c.st_no;";
		$rm_order = mysqli_fetch_assoc(execute_sql($link,"company",$sql));
		
		echo "<table class='mytable'>\n";
		echo "<tr><td colspan='5'><b>物料訂單---".$_POST["rm_order_no"]."</b>　採購人：".$rm_order["st_no"]."-".$rm_order["st_name"]."</td></td></tr>\n";
		echo "<tr class='title'><td>供應商</td><td>訂單時間</td><td>交貨日期</td><td>訂單狀態</td><td>總價</td></tr>\n";
		echo "<tr><td>".$rm_order["s_no"]."-".$rm_order["s_name"]."</td><td>".$rm_order["rm_order_time"]."</td><td>".$rm_order["rm_order_deadline"]."</td><td>".$rm_order["rm_order_state"]."</td><td>".
		$rm_order["rm_order_Tprice"]."</td></tr>\n";
		
		$sql = "SELECT * FROM raw_material_order_record WHERE rm_order_no = '".$_POST["rm_order_no"]."';";
		$rm = execute_sql($link,"company",$sql);
		echo "<tr class='title'><td colspan='2'>物料</td><td>材質</td><td>數量</td><td>單價</td></tr>\n";
		while($row = mysqli_fetch_assoc($rm)) {
			$sql = "SELECT rm_name,rm_made FROM raw_material WHERE rm_no = '".$row["rm_no"]."'";
			$rm_content = mysqli_fetch_assoc(execute_sql($link,"company",$sql));
			echo "<tr>";
			echo "<td colspan='2'>".$row["rm_no"]."-".$rm_content["rm_name"]."</td><td>".$rm_content["rm_made"]."</td><td>".$row["rm_quantity"]."</td><td>".$row["rm_Uprice"]."</td>\n";
			echo "</tr>";
		}
		echo "</table>\n";
		mysqli_close($link);
	?>
</body>
</html>