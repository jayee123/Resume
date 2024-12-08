<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>物料</title>
  <link href="table.css" rel="stylesheet" type="text/css">
</head>
<body>
	<div class="fun">
		<form action="<?php echo basename(__FILE__)?>" method="post">
			<table width="90%" style="margin:0 auto;"">
				<tr>
					<td width="20%" style="text-align:right;"><b>搜尋：</b></td>
					<td width="15%" style="text-align:center;">
						<label><input type="radio" name="opt" value="編號" checked>依物料編號</label> 
						<label><input type="radio" name="opt" value="名稱">名稱</label>
					</td>
					<td width="15%" style="text-align:center;" id="query"><input name="query" type="text" required></td>
					<td width="15%" style="text-align:left;"><input type="submit" name="submit" value="確認"></td>
					<td width="10%" style="text-align:left;">
						<?php
							if (isset($_POST["submit"]))
								echo "<div><a href='".basename(__FILE__)."'>返回</div>";
						?>
					</td>
					<td>
						<div class="new_btn"><a href="new_rm.php"><img src="pencil.png" heigth="25px" width="25px">新增</a></div>
					</td>
				</tr>
			</table>
		</form>
	</div>
	<?php
		include_once("dbtools.inc.php");
		
		$link = create_connection();
		
		$sql = "";
		if (isset($_POST["submit"])) {
			if ($_POST["opt"]=="編號")
				$sql = "WHERE rm_no LIKE '%".$_POST["query"]."%'";
			else if ($_POST["opt"]=="名稱")
				$sql = "WHERE rm_name LIKE '%".$_POST["query"]."%'";
		}
		$sql = "SELECT * FROM raw_material ".$sql." ORDER BY rm_no ASC;";
		$rm = execute_sql($link,"company",$sql);
		
		if(mysqli_num_rows($rm)) {
			echo "<table class='mytable'>\n";
			echo "<tr class='title'><td width='25%'>物料編號</td><td width='25%'>名稱</td><td width='25%'>材質</td><td width='25%'></td></tr>\n";
			while ($row = mysqli_fetch_assoc($rm)) {
				$red = "";
				if($row["rm_state"] == "停用") {
					$red = " style='color:red;'";
				}
				echo "<tr".$red."><td>".$row["rm_no"]."</td><td>".$row["rm_name"]."</td><td>".$row["rm_made"]."</td>";
				if($row["rm_state"] == "使用中") {
					echo "<td><button type='button' id='e".$row["rm_no"]."' onclick='btn_click(event)'>編輯</button>　";
					echo "<button type='button' id='d".$row["rm_no"]."' onclick='btn_click(event)'>刪除</button>";
					echo "<form method='post' action='edit_rm.php' id='fe".$row["rm_no"]."'><input type='hidden' name='rm_no' value='".$row["rm_no"]."'><input type='hidden' name='edit' value='edit'></form>";
					echo "<form method='post' action='delRM.php' id='fd".$row["rm_no"]."'><input type='hidden' name='rm_no' value='".$row["rm_no"]."'><input type='hidden' name='del' value='del'></form>";
					echo "</td>";
				}
				else
					echo "<td>停用</td>";
				echo "</tr>";
			}
			echo "</table>\n";
		}
		else
			echo "<table class='mytable'><tr><td>無資料</td></tr></table>";
		mysqli_close($link);
	?>

<script type="text/javascript">
	function btn_click(e) {
		var id = e.target.id;
		if(id[0]=="e") {
			document.getElementById('f'+id).submit();
		}
		else if(id[0]=="d") {
			check(id);
		}
	}
	function check(id) {
		if (confirm('確定要刪除編號為'+id.substr(1)+'的物料嗎？') == true) {
			document.getElementById('f'+id).submit();
		}
	}
</script>
</body>
</html>