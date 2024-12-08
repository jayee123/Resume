<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>採購人員</title>
  <link href="table.css" rel="stylesheet" type="text/css">
</head>
<body>
	<div class="fun">
		<form action="<?php echo basename(__FILE__)?>" method="post">
			<table width="90%" style="margin:0 auto;"">
				<tr>
					<td width="20%" style="text-align:right;"><b>搜尋：</b></td>
					<td width="15%" style="text-align:center;">
						<label><input type="radio" name="opt" value="編號" checked>依採購人編號</label> 
						<label><input type="radio" name="opt" value="姓名">姓名</label>
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
						<div class="new_btn"><a href="new_staff.php"><img src="pencil.png" heigth="25px" width="25px">新增</a></div>
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
				$sql = "WHERE st_no LIKE '%".$_POST["query"]."%'";
			else if ($_POST["opt"]=="姓名")
				$sql = "WHERE st_name LIKE '%".$_POST["query"]."%'";
		}
		$sql = "SELECT * FROM staff ".$sql." ORDER BY st_no ASC;";
		$staff = execute_sql($link,"company",$sql);
		
		if(mysqli_num_rows($staff)) {
			echo "<table class='mytable'>\n";
			echo "<tr class='title'><td width='34%'>採購人編號</td><td width='33%'>姓名</td><td width='33%'></td></tr>\n";
			while ($row = mysqli_fetch_assoc($staff)) {
				$red = "";
				if($row["st_state"] == "離職") {
					$red = " style='color:red;'";
				}
				echo "<tr".$red."><td>".$row["st_no"]."</td><td>".$row["st_name"]."</td>";
				if($row["st_state"] == "就職中") {
					echo "<td><button type='button' id='e".$row["st_no"]."' onclick='btn_click(event)'>編輯</button>　";
					echo "<button type='button' id='d".$row["st_no"]."' onclick='btn_click(event)'>刪除</button>";
					echo "<form method='post' action='edit_staff.php' id='fe".$row["st_no"]."'><input type='hidden' name='st_no' value='".$row["st_no"]."'><input type='hidden' name='edit' value='edit'></form>";
					echo "<form method='post' action='delStaff.php' id='fd".$row["st_no"]."'><input type='hidden' name='st_no' value='".$row["st_no"]."'><input type='hidden' name='del' value='del'></form>";
					echo "</td>";
				}
				else
					echo "<td>離職</td>";
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
		if (confirm('確定要刪除編號為'+id.substr(1)+'的員工嗎？') == true) {
			document.getElementById('f'+id).submit();
		}
	}
</script>
</body>
</html>