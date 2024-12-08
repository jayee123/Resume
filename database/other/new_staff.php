<?php 
include_once("dbtools.inc.php");
$link = create_connection();

if(isset($_POST["submit"])) {
		$sql = "SELECT st_no FROM staff WHERE st_no='".$_POST["st_no"]."';";
		if(mysqli_num_rows(execute_sql($link,"company",$sql))) {
			echo "<script type='text/javascript'>";
			echo "alert('採購人編號重複，請重新輸入。');";
			echo "document.location.replace('".basename(__FILE__)."');";
			echo "</script>";
		}
		else {
			$sql = "INSERT INTO staff (st_no, st_name) VALUES ('".$_POST["st_no"]."', '".$_POST["st_name"]."');";
			execute_sql($link,"company",$sql);
			echo "<script type='text/javascript'>";
			echo "alert('成功新增採購人。');";
			echo "document.location.replace('staff.php');";
			echo "</script>";
		}
}

function echo_form($link) {
	mysqli_select_db($link,"company");
	echo "<tr><td class='title' height='100px'>採購人編號</td><td><input type='text' name='st_no' maxlength='5' required></td></tr>";
	echo "<tr><td class='title' height='100px'>姓名</td><td><input type='text' name='st_name' maxlength='6' required></td></tr>";
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>新增採購人員</title>
  <link href="table.css" rel="stylesheet" type="text/css">
</head>
<body>
<form action="<?php echo basename(__FILE__)?>" method="post">
	<div class="fun">		
			<table width="90%" style="margin:0 auto;">
				<tr>
					<td width="60%" style="text-align:center;"><b>新增採購人</b></td>
					<td width="10%"><div><a href="staff.php">返回</div></td>
					<td>
						<div width="30%" class="new_btn"><button type='submit' name="submit"><img src="pencil.png" heigth="25px" width="25px">確認</button></div>
					</td>
				</tr>
			</table>
		
	</div>
	
	<table class='mytable'>
	<?php
		echo_form($link);
	?>
	</table>
</form>
</body>
</html>

<?php
	mysqli_close($link);
?>