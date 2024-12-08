<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>供應商</title>
  <link href="table.css" rel="stylesheet" type="text/css">
</head>
<body>
	<div class="fun">
		<form action="<?php echo basename(__FILE__)?>" method="post">
			<table width="90%" style="margin:0 auto;"">
				<tr>
					<td width="20%" style="text-align:right;"><b>搜尋：</b></td>
					<td width="15%" style="text-align:center;">
						<label><input type="radio" name="opt" value="編號" checked>依供應商編號</label> 
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
						<div class="new_btn"><a href="new_s.php"><img src="pencil.png" heigth="25px" width="25px">新增</a></div>
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
				$sql = "WHERE s_no LIKE '%".$_POST["query"]."%'";
			else if ($_POST["opt"]=="名稱")
				$sql = "WHERE s_name LIKE '%".$_POST["query"]."%'";
		}
		$sql = "SELECT * FROM supplier ".$sql." ORDER BY s_no ASC;";
		$s = execute_sql($link,"company",$sql);
		
		$addr = " style='text-align:left;'";
		if(mysqli_num_rows($s)) {
			echo "<table class='mytable'>\n";
			echo "<tr class='title'><td>供應商編號</td><td>名稱</td><td>地址</td><td>聯絡人</td><td>電話</td><td>信箱</td><td></td></tr>\n";
			while ($row = mysqli_fetch_assoc($s)) {
				$red = "";
				if($row["s_state"] == "停業") {
					$red = " style='color:red;'";
				}
				echo "<tr".$red."><td>".$row["s_no"]."</td><td>".$row["s_name"]."</td><td".$addr.">".$row["s_address"]."</td><td>".$row["s_contact"]."</td><td>".$row["s_phone"]."</td><td>".$row["s_email"]."</td>";
				if($row["s_state"] == "營業中") {
					echo "<td><button type='button' id='e".$row["s_no"]."' onclick='btn_click(event)'>編輯</button>　";
					echo "<button type='button' id='d".$row["s_no"]."' onclick='btn_click(event)'>刪除</button>";
					echo "<form method='post' action='edit_s.php' id='fe".$row["s_no"]."'><input type='hidden' name='s_no' value='".$row["s_no"]."'><input type='hidden' name='edit' value='edit'></form>";
					echo "<form method='post' action='delS.php' id='fd".$row["s_no"]."'><input type='hidden' name='s_no' value='".$row["s_no"]."'><input type='hidden' name='del' value='del'></form>";
					echo "</td>";
				}
				else
					echo "<td>停業</td>";
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
		if (confirm('確定要刪除編號為'+id.substr(1)+'的供應商嗎？') == true) {
			document.getElementById('f'+id).submit();
		}
	}
</script>
</body>
</html>