<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>加工訂單</title>
	<link href="table.css" rel="stylesheet" type="text/css">
	<script type="text/javascript">
		function sortTable(n) {
			var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
			table = document.getElementsByClassName("mytable")[0];
			switching = true;
			dir = "asc";
			while (switching) {
				switching = false;
				rows = table.rows;
				for (i = 1; i < (rows.length - 1); i++) {
					shouldSwitch = false;
					x = rows[i].getElementsByTagName("TD")[n];
					y = rows[i + 1].getElementsByTagName("TD")[n];
					if (dir == "asc") {
						if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
						shouldSwitch = true;
						break;
						}
					}
					else if (dir == "desc") {
						if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
						shouldSwitch = true;
						break;
						}
					}
				}
				if (shouldSwitch) {
					rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
					switching = true;
					switchcount ++;
				}
				else {
					if (switchcount == 0 && dir == "asc") {
						dir = "desc";
						switching = true;
					}
				}
			}
			
			while (switching) {
				switching = false;
				rows = table.rows;
				for (i = 1; i < (rows.length - 1); i++) {
					shouldSwitch = false;
					x = rows[i].getElementsByTagName("TD")[0];
					y = rows[i + 1].getElementsByTagName("TD")[0];
					if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
					shouldSwitch = true;
					break;
					}
				}
				if (shouldSwitch) {
					rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
					switching = true;
					switchcount ++;
				}
				else {
					if (switchcount == 0 && dir == "asc") {
						dir = "desc";
						switching = true;
					}
				}
			}
		}
	</script>
</head>
<body>
	<div class="fun">
		<form action="<?php echo basename(__FILE__)?>" method="post">
			<table width="90%" style="margin:0 auto;">
				<tr>
					<td width="20%" style="text-align:right;"><b>搜尋：</b></td>
					<td width="23%" style="text-align:center;">
						<!-- <select name="opt" id="opt" oninput="opt_change(event)" onporpertychange="opt_change(event)">
							<option value="時間">依委託時間</option>
							<option value="成品">依製作成品</option>
							<option value="狀態">依狀態</option>
						</select> -->
						<label><input type="radio" name="opt" value="時間" onchange="opt_change(event)" checked>依委託時間</label> 
						<label><input type="radio" name="opt" value="成品" onchange="opt_change(event)">製作成品</label> 
						<label><input type="radio" name="opt" value="狀態" onchange="opt_change(event)">狀態</label>
					</td>
					<script type="text/javascript">
						function opt_change(e){
							const opt = e.target;
							
							var opt_v = opt.value;
							
							var html = "";

							if (opt_v=="狀態")
								html = '<select name="query"><option value="材料未運達">材料未運達</option><option value="加工中">加工中</option><option value="完成">完成</option></select>';
							else
								html = '<input name="query" type="text" required>';
							var query = document.getElementById("query");
							query.innerHTML = html;
						}
					</script>
					<td width="15%" style="text-align:center;" id="query"><input name="query" type="text" required></td>
					<td width="15%" style="text-align:left;"><input type="submit" name="submit" value="確認"></td>
					<td width="10%" style="text-align:left;">
						<?php
							if (isset($_POST["submit"]))
								echo "<div><a href='".basename(__FILE__)."'>返回</div>";
						?>
					</td>
					<td>
						<div class="new_btn"><a href="new_process.php"><img src="pencil.png" heigth="25px" width="25px">新增</a></div>
					</td>
				</tr>
			</table>
		</form>
	</div>
	<?php
		include_once("dbtools.inc.php");
		include_once("state_check.php");
		
		$link = create_connection();
		$warn_fpp_no = fp_process_check($link);
		
		$sql = "";
		if (isset($_POST["submit"])) {
			if ($_POST["opt"]=="時間")
				$sql = "fpp_time LIKE '%".$_POST["query"]."%' and ";
			else if ($_POST["opt"]=="成品")
				$sql = "fp_name LIKE '%".$_POST["query"]."%' and ";
			else
				$state_q = $_POST["query"];
		}
		$sql = "SELECT fpp_no,fpp_time,p_Tprice,a.fp_no,fp_name,fp_finished_quantity FROM finished_product_process as a,finished_product as b WHERE ".$sql." a.fp_no=b.fp_no ORDER BY fpp_time DESC,fpp_no ASC;";
		$fpps = execute_sql($link,"company",$sql);
		
		if(mysqli_num_rows($fpps)) {
			echo "<table class='mytable'>\n";
			echo "<tr class='title'><td>加工編號</td><td>製作成品</td><td>預計完成量</td><td>加工花費</td><td>委託時間</td><td><a onclick='sortTable(5)'>預計完成日 <img src='arrow.png' height='13.5'></a></td><td><a onclick='sortTable(6)'>加工狀態 <img src='arrow.png' height='13.5'></a></td><td>更多</td></tr>\n";
			$state_class = array("材料未運達"=>"none","加工中"=>"ing","完成"=>"");
			while ($row = mysqli_fetch_assoc($fpps)) {
				$warn = "";
				if(in_array($row["fpp_no"],$warn_fpp_no))
					$warn = "style='color: red; font-weight:bolder;' ";
				
				$sql = "SELECT max(sp_num),max(p_deadline), sum(p_loss) FROM sub_process WHERE fpp_no='".$row["fpp_no"]."';";

				$p_content = mysqli_fetch_assoc(execute_sql($link,"company",$sql));
				$p_deadline = $p_content["max(p_deadline)"];
				$p_loss = "";
				if($p_content["sum(p_loss)"]>0)
					$p_loss =  " (-".$p_content["sum(p_loss)"].")";
				$sql = "SELECT p_state FROM sub_process WHERE fpp_no='".$row["fpp_no"]."' and (p_state = '材料未運達' or p_state = '加工中');";
				$sps = execute_sql($link,"company",$sql);
				if (mysqli_num_rows($sps)>=1) {
					$p_state = mysqli_fetch_assoc($sps)["p_state"];
				}
				else
					$p_state = "完成";
				
				if (isset($state_q)) {
					if($p_state==$state_q)
						echo "<tr><td>".$row["fpp_no"]."</td><td>".$row["fp_name"]."</td><td>".$row["fp_finished_quantity"].$p_loss."</td><td>".
							 $row["p_Tprice"]."</td><td>".$row["fpp_time"]."</td><td>".
							 $p_deadline."</td><td class='".$state_class[$p_state]."'>".$p_state."</td><td><a ".$warn."href='p_content.php?fpp_no=".$row["fpp_no"]."'>查看詳情</a></td></tr>\n";
				}
				else
					echo "<tr><td>".$row["fpp_no"]."</td><td>".$row["fp_name"]."</td><td>".$row["fp_finished_quantity"].$p_loss."</td>
						 <td>".$row["p_Tprice"]."</td><td>".$row["fpp_time"]."</td><td>".
						 $p_deadline."</td><td class='".$state_class[$p_state]."'>".$p_state."</td><td><a ".$warn."href='p_content.php?fpp_no=".$row["fpp_no"]."'>查看詳情</a></td></tr>\n";
			}
			echo "</table>\n";
		}
		else
			echo "<table class='mytable'><tr><td>無資料</td></tr></table>";
		mysqli_close($link);
	?>
</body>
</html>