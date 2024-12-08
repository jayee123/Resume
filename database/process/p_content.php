<?php
	include_once("dbtools.inc.php");
	include_once("state_check.php");
	if (!isset($_GET["fpp_no"]))
		header("Location:process.php");
	$link = create_connection();
	
	$warn_sp_num = sub_process_check($link,$_GET["fpp_no"]);
	
	$sql = "";
	$sql = "SELECT a.*,b.* FROM finished_product_process as a, sub_process as b WHERE a.fpp_no='".$_GET["fpp_no"]."' and b.fpp_no='".$_GET["fpp_no"]."';";
	$p_content = execute_sql($link,"company",$sql);
	
	if(!mysqli_num_rows($p_content))
		header("Location:process.php");
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>加工訂單</title>
	<link href="table.css" rel="stylesheet" type="text/css">
	<link href="hover_show_content.css" rel="stylesheet" type="text/css">
	<script type="text/javascript">
	function to_order(id) {
		try {
			parent.change_title("rm_order");
		}
		catch(e) {}
		document.location.replace("../order/o_detail.php?rm_order_no="+id);
	}
	</script>
</head>
<body>
	<div class="fun">
		<form action="edit_process.php" method="post">
			<table width="90%" style="margin:0 auto;">
				<tr>
					<td width="20%" style="text-align:right;"></td>
					<td width="15%" style="text-align:center;"></td>
					<td width="10%" style="text-align:center;"></td>
					<td width="15%" style="text-align:left;"></td>
					<td width="10%"><div><a href="process.php">返回</div></td>
					<td>
						<div width="30%" class="new_btn"><button type="submit"><img src="pencil.png" heigth="25px" width="25px">編輯</button></div>
					</td>
				</tr>
			</table>
			<input type="hidden" name="fpp_no" value="<?php echo $_GET["fpp_no"];?>">
		</form>
	</div>
	<?php
		$state_class = array("材料未運達"=>"none","加工中"=>"ing","完成"=>"");
		echo "<table class='mytable'>\n";
		$st_no = mysqli_fetch_assoc($p_content)["st_no"];
		$staff = mysqli_fetch_assoc(execute_sql($link,"company","SELECT * FROM staff WHERE st_no = '".$st_no."'"));
		echo "<tr><td colspan='9'><b>加工編號---".$_GET["fpp_no"]."</b>　採購人：".$staff["st_no"]."-".$staff["st_name"]."</td></tr>\n";
		echo "<tr class='title'><td>加工順序</td><td>加工廠商</td><td>加工數量</td><td>加工單價</td><td>總價</td><td>加工期限</td><td>狀態</td><td>損耗量</td><td>備註</td></tr>\n";
		mysqli_data_seek($p_content, 0);
		while($row = mysqli_fetch_assoc($p_content)) {
			$warn = "";
			if(in_array($row["sp_num"],$warn_sp_num))
				$warn = "style='color: red; font-weight:bolder;' ";
			
			$p_no = $row["p_no"];
			$sql = "SELECT * FROM processor WHERE p_no = '".$p_no."'";
			$processor = mysqli_fetch_assoc(execute_sql($link,"company",$sql));
			$processor_content = "<div class='content'>
									<div>加工商</div>
									<ul>
									<li>編號：".$processor["p_no"]."</li>
									<li>名稱：".$processor["p_name"]."</li>
									<li>聯絡人：".$processor["p_contact"]."</li>
									<li>電話：".$processor["p_phone"]."</li>
									<li>信箱：".$processor["p_email"]."</li>
									<li>地址：".$processor["p_address"]."</li></ul></div>";
			$total = $row["p_quantity"]*$row["p_Uprice"];
			echo "<tr><td>".$row["sp_num"]."</td><td><a href='#' class='box'>".$processor["p_no"]."-".$processor["p_name"].$processor_content."</a></td><td>".$row["p_quantity"]."</td><td>".
				 $row["p_Uprice"]."</td><td>".$total."</td><td ".$warn.">".$row["p_deadline"]."</td><td class='".$state_class[$row["p_state"]]."'>".$row["p_state"]."</td><td>".
				 $row["p_loss"]."</td><td>".$row["p_content"]."</td></tr>\n";
		}
		echo "</table>\n";
		
		$sql = "SELECT fp_name, b.* FROM finished_product as a,finished_product_process as b WHERE a.fp_no = b.fp_no and fpp_no = '".$_GET["fpp_no"]."';";
		$fpp = mysqli_fetch_assoc(execute_sql($link,"company",$sql));

		$loss = mysqli_fetch_assoc(execute_sql($link,"company","SELECT sum(p_loss) FROM sub_process WHERE fpp_no = '".$_GET["fpp_no"]."';"));
		$p_loss = "";
		if($loss["sum(p_loss)"]>0)
			$p_loss =  " (-".$loss["sum(p_loss)"].")";

		echo "<table class='mytable'>\n";
		echo "<tr class='title'><td>製作成品</td><td>預計完成量</td><td>加工總花費</td><td>委託時間</td><td>物料來源編號</td></tr>\n";
		echo "<tr><td>".$fpp["fp_no"]."-".$fpp["fp_name"]."</td><td>".$fpp["fp_finished_quantity"].$p_loss."</td><td>".$fpp["p_Tprice"]."</td><td>".
		$fpp["fpp_time"]."</td><td>".$fpp["rm_order_no"]."</td></tr>\n";
		echo "</table>";
		
		$sql = "SELECT * FROM raw_material_order_record WHERE rm_order_no = '".$fpp["rm_order_no"]."';";
		$rm = execute_sql($link,"company",$sql);
		
		$staff = mysqli_fetch_assoc(execute_sql($link,"company","SELECT a.st_no,a.st_name FROM staff as a, raw_material_order as b WHERE rm_order_no = '".$fpp["rm_order_no"]."' and a.st_no = b.st_no;"));
		
		echo "<table class='mytable' style='margin: 20px auto 120px;'>\n";
		echo "<tr><td colspan='5'><b><a onclick='to_order(\"".$fpp["rm_order_no"]."\")'>物料訂單---".$fpp["rm_order_no"]."</a></b>　採購人：".$staff["st_no"]."-".$staff["st_name"]."</td></tr>\n";
		echo "<tr class='title'><td>物料</td><td>材質</td><td>數量</td><td>單價</td><td>合計</td></tr>\n";
		while($row = mysqli_fetch_assoc($rm)) {
			$sql = "SELECT rm_name,rm_made FROM raw_material WHERE rm_no = '".$row["rm_no"]."'";
			$rm_content = mysqli_fetch_assoc(execute_sql($link,"company",$sql));
			$total = $row["rm_Uprice"]*$row["rm_quantity"];
			echo "<tr>";
			echo "<td>".$row["rm_no"]."-".$rm_content["rm_name"]."</td><td>".$rm_content["rm_made"]."</td><td>".$row["rm_quantity"]."</td><td>".$row["rm_Uprice"]."</td><td>".$total."</td>\n";
			echo "</tr>";
		}
		$sql = "SELECT * FROM raw_material_order WHERE rm_order_no = '".$fpp["rm_order_no"]."';";
		$rm_order = mysqli_fetch_assoc(execute_sql($link,"company",$sql));
		$sql = "SELECT * FROM supplier WHERE s_no = '".$rm_order["s_no"]."';";
		$s = mysqli_fetch_assoc(execute_sql($link,"company",$sql));
		$supplier_content = "<div class='content'>
								供應商
								<ul>
								<li>編號：".$s["s_no"]."</li>
								<li>名稱：".$s["s_name"]."</li>
								<li>聯絡人：".$s["s_contact"]."</li>
								<li>電話：".$s["s_phone"]."</li>
								<li>信箱：".$s["s_email"]."</li>
								<li>地址：".$s["s_address"]."</li></ul></div>";
		echo "<tr class='title'><td>供應商</td><td width='250px'>訂單時間</td><td>交貨日期</td><td>訂單狀態</td><td>總價</td></tr>\n";
		echo "<tr><td><a href='#' class='box'>".$s["s_no"]."-".$s["s_name"].$supplier_content."</a></td><td>".$rm_order["rm_order_time"]."</td><td>".$rm_order["rm_order_deadline"]."</td>
		<td>".$rm_order["rm_order_state"]."</td><td>".$rm_order["rm_order_Tprice"]."</td></tr>\n";
		echo "</table>\n";
		mysqli_close($link);
	?>
</body>
</html>